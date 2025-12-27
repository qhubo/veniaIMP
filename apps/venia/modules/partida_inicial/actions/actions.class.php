<?php

/**
 * partida_inicial actions.
 *
 * @package    plan
 * @subpackage partida_inicial
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class partida_inicialActions extends sfActions {

    public function executeCarga(sfWebRequest $request) {
        $this->getResponse()->setContentType('charset=utf-8');
        $id = $request->getParameter('id');
        $this->id = $id;
        $datos = CuentaErpContablePeer::pobladatosPartida($id);

        if (!$datos['valido']) {
            $texto = $datos['pendiente'];

            $textol = implode(' , ', $texto);
            $this->getUser()->setFlash('error', 'Las siguiente columnas no fueron encontradas: ' . $textol);
            $this->redirect('partida_inicial/index');
        }
        $this->datos = $datos['datos'];

        sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');

        sfContext::getInstance()->getUser()->setAttribute('usuarioDatosPartida', serialize($datos), 'seguridad');

        $this->redirect('partida_inicial/index?carga=1');
        //   die();
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $carga = $request->getParameter('carga');
        $ma2 = $request->getParameter('ma2');
        $this->carga = $carga;
        $this->listaCuentas = CuentaErpContableQuery::create()
                //->where('length(CuentaErpContable.CuentaContable) >6 ')
                ->setLimit(5)->orderById()->find();
        if ($ma2) {
            $this->listaCuentas = CuentaErpContableQuery::create()
                    //->where('length(CuentaErpContable.CuentaContable) >6 ')
                    ->orderById()->find();
        }
        $this->total1 = 0;
        $this->total2 = 0;
        $default = null;
        if ($carga) {
            $datosArchivo = unserialize(sfContext::getInstance()->getUser()->getAttribute('usuarioDatosPartida', null, 'seguridad'));

            $this->listaCuentas = CuentaErpContableQuery::create()
                         //  ->where('length(CuentaErpContable.CuentaContable) >4 ')
                           ->filterById($datosArchivo['lista'], Criteria::IN)
                            ->orderById()->find();

            $registros = $datosArchivo['datos'];
            $total1 = 0;
            $total2 = 0;
            foreach ($registros as $data) {
                $total1 = $total1 + $data['DEBE'];
                $total2 = $total2 + $data['HABER'];
                $default['debe' . $data['ID']] = $data['DEBE'];
                $default['haber' . $data['ID']] = $data['HABER'];
            }

            $this->total1 = $total1;
            $this->total2 = $total2;
        } else {
            sfContext::getInstance()->getUser()->setAttribute('usuarioDatosPartida', null, 'seguridad');
        }
        foreach ($this->listaCuentas as $li) {
            $list[] = $li->getId();
        }
        $this->lis = $list;

        // $default=null;

        $this->form = new IngreCargaInicialForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();

                $totalv1 = 0;
                $totalv2 = 0;
                $can = 0;
                foreach ($this->listaCuentas as $li) {
                    $can++;
                    $totalv1 = $totalv1 + $valores['debe' . $li->getId()];
                    $totalv2 = $totalv2 + $valores['haber' . $li->getId()];
                }
                $totalv1 = Parametro::formato($totalv1);
                $totalv2 = Parametro::formato($totalv2);
                // die();
                if ($totalv1 == $totalv2) {
                    
                } else {
                    $this->getUser()->setFlash('error', $can . ' Carga de saldo inorrecta totales no conciden: ' . $totalv1 . "  " . $totalv2);
                    $this->redirect('partida_inicial/index?carga=' . $carga);
                }

                $partidaId = Partida::Crea('Partida Inicial ', date('Y').'0101', $totalv1);
                //   $nombreCuenta = Partida::cuenta($cuentaContable);


                foreach ($this->listaCuentas as $li) {
                    $debe = $valores['debe' . $li->getId()];
                    $haber = $valores['haber' . $li->getId()];
                    $monto = $debe;
                    if ($haber > 0) {
                        $monto = $haber * -1;
                    }
                    $cuentaErp = CuentaErpContableQuery::create()->findOneById($li->getId());
                    $cuentaErp->setCreatedBy($usuarioQ->getUsuario());
                    $cuentaErp->setFechaInicio(date('Y-m-d H:i:s'));
                    $cuentaErp->setSaldoInicio($monto);
                    $cuentaErp->save();
                    $partidaLinea = new PartidaDetalle();
                    $partidaLinea->setPartidaId($partidaId);
                    $partidaLinea->setDetalle($li->getNombre());
                    $partidaLinea->setCuentaContable($li->getCuentaContable());
                    $partidaLinea->setDebe($debe);
                    $partidaLinea->setHaber($haber);
                    $partidaLinea->setTipo(0);
                    $partidaLinea->setGrupo("PARTIDA INICIAL");
                    $partidaLinea->save();

                    $Banco = BancoQuery::create()->findOneByCuentaContable($li->getCuentaContable());
                    if ($Banco) {
                        $montoBano = $debe;
                        if ($haber > 0) {
                            $montoBano = $haber * -1;
                        }
                        $movimiento = New MovimientoBanco();
                        $movimiento->setTipo('Inicial');
                        $movimiento->setTipoMovimiento('Saldo Inicial');
                        $movimiento->setDocumento($partidaId);
                        $movimiento->setBancoOrigen($Banco->getId());
                        $movimiento->setBancoId($Banco->getId());
                        $movimiento->setFechaDocumento(date('Y-m-d'));
                        $movimiento->setValor($montoBano);
                        $movimiento->setObservaciones("SaldoInicial");
                        $movimiento->setEstatus("Confirmado");
                        $movimiento->setUsuario($usuarioQ->getUsuario());
                        $movimiento->save();

                        $cxc = CuentaBancoQuery::create()->findOneByMovimientoBancoId($movimiento->getId());
                        if (!$cxc) {
                            $cxc = New CuentaBanco();
                        }
                        $cxc->setBancoId($movimiento->getBancoId());
                        $cxc->setMovimientoBancoId($movimiento->getId());
                        $cxc->setValor($movimiento->getValor());
                        $cxc->setFecha($movimiento->getCreatedAt());
                        $cxc->setDocumento($movimiento->getDocumento());
                        $cxc->setUsuario($movimiento->getUsuario());
                        $cxc->setCreatedAt($movimiento->getCreatedAt());
                        $cxc->setObservaciones($movimiento->getTipo());
                        $cxc->save();
                    }
                }
                sfContext::getInstance()->getUser()->setAttribute('usuarioDatosPartida', null, 'seguridad');
$partidaQ = PartidaQuery::create()->findOneById($partidaId);
$partidaQ->setConfirmada(true);
$partidaQ->save();
                $this->getUser()->setFlash('exito', "Saldos cargados con exito");
                $this->redirect('partida_inicial/index');
            }
        }
        
        $this->partidas = PartidaQuery::create()->filterByTipo('Partida Inicial')->find();
//                                echo "<pre>aaaa";
//        print_r( $default);
//        die();
//        
    }

    public function executeReporteModelo(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $empresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = strtoupper($empresaQ->getNombre());
        $nombreEMpresa = strtoupper($empresaQ->getNombre());
        $pestanas[] = 'Carga de Saldos';
        $nombre = "Reporte";
        $filename = "Archivo_modelo_carga_inicial" . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("LISTADO DE CUENTAS CONTABLES  CARGA SALDOS " . strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        // $hoja->getCell("B1")->setValueExplicit(strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("A1:D1");
        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');
        $encabezados[] = array("Nombre" => (strtoupper(("Tipo"))), "width" => 10, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => (strtoupper(("Cuenta"))), "width" => 25, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => (strtoupper(("Nombre"))), "width" => 50, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => (strtoupper(("Debe"))), "width" => 22, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => (strtoupper(("Haber"))), "width" => 22, "align" => "left", "format" => "@");

        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

        $registros = CuentaErpContableQuery::create()
                //->where('length(CuentaErpContable.CuentaContable) >6 ')
                ->orderByTipo('Asc')->find();
        foreach ($registros as $data) {
            //$totalDos = $totalDos + $data->getValorPagado();
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $data->getTipo());
            $datos[] = array("tipo" => 3, "valor" => $data->getCuentaContable());
            $datos[] = array("tipo" => 3, "valor" => $data->getNombre());
            $datos[] = array("tipo" => 3, "valor" => 0.00);
            $datos[] = array("tipo" => 3, "valor" => 0.00);

            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

}
