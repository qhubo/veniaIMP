<?php

/**
 * debito_banco actions.
 *
 * @package    plan
 * @subpackage debito_banco
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11ffech:07:44Z Kris.Wallsmith $
 */
class debito_bancoActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBan', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['banco'] = null;
            $valores['estatus'] = null;
        }

        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = $EmpresaQuery->getNombre();
        $pestanas[] = 'Movimiento Banco Débito';
        $filename = "Movimiento Banco Débito   " . $nombreempresa . date("d_m_Y");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $hoja = $xl->setActiveSheetIndex(0);
//CABECERA  Y FILTRO
        $hoja->getRowDimension('1')->setRowHeight(15);
        $hoja->getRowDimension('2')->setRowHeight(20);

        $hoja->mergeCells("A1:A2");
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit(strtoupper($nombreempresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(13);
// $hoja->getStyle("B1")->applyFromArray($styleArray);

        $hoja->getCell("C1")->setValueExplicit("Movimiento Banco Débito ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C1")->getFont()->setBold(true);
        $hoja->getStyle("C1")->getFont()->setSize(10);

        $textoBusqueda = $this->textobusqueda($valores);
        $hoja->mergeCells("C1:E1");
        $hoja->getCell("B2")->setValueExplicit("Busqueda ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B2")->getFont()->setBold(true);
        $hoja->getStyle("B2")->getFont()->setSize(10);
        $hoja->getCell("C2")->setValueExplicit($textoBusqueda, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle('C2')->getAlignment()->setWrapText(true);
        $hoja->mergeCells("C2:E2");

        $fila = 3;
        $columna = 0;
        $encabezados = null;

        $encabezados[] = array("Nombre" => strtoupper("Fecha"), "width" => 12, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Usuario"), "width" => 20, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Banco"), "width" => 40, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Documento"), "width" => 25, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Valor"), "width" => 25, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Tipo"), "width" => 20, "align" => "left", "format" => "#,##0");
   $encabezados[] = array("Nombre" => strtoupper("Observaciones"), "width" => 60, "align" => "left", "format" => "#,##0");
         
sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '00:00';
        $valores['fin'] = '23:00';

        $operaciones = new MovimientoBancoQuery();
        if ($valores['banco']) {

            $operaciones->filterByBancoId($valores['banco']);
            ;
        }
        $operaciones->orderByFechaDocumento("Desc");
        $operaciones->filterByTipo('Debito');
        $operaciones->where("MovimientoBanco.FechaDocumento >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'");
        $operaciones->where("MovimientoBanco.FechaDocumento <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'");
        $this->operaciones = $operaciones->find();

        $total = 0;
        foreach ($this->operaciones as $regi) {
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $regi->getFechaDocumento('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regi->getUsuario());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regi->getBancoRelatedByBancoId()->getNombre());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regi->getDocumento());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $regi->getValor());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regi->getTipo());  // ENTERO
$datos[] = array("tipo" => 3, "valor" => $regi->getObservaciones());  // ENTERO



            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;
//        $hoja->getCell("E" . $fila)->setValueExplicit("TOTALES ", PHPExcel_Cell_DataType::TYPE_STRING);
//        $hoja->getStyle("E" . $fila)->getFont()->setBold(true);
//        $hoja->getStyle("E" . $fila)->getFont()->setSize(12);
//        //$hoja->mergeCells("F" . $fila . ":G" . $fila);
//        $hoja->getCell("H" . $fila)->setValueExplicit(round($TOTAL, 2), PHPExcel_Cell_DataType::TYPE_NUMERIC);
//        $hoja->getStyle("H" . $fila)->getFont()->setBold(true);
//        $hoja->getStyle("H" . $fila)->getFont()->setSize(12);
//        $fila++;
//        $LetraFin = UsuarioQuery::numeroletra(7);
//        $hoja->getCell("A" . $fila)->setValueExplicit("ULTIMA LINEA", PHPExcel_Cell_DataType::TYPE_STRING);
//        $hoja->mergeCells("B" . $fila . ":" . $LetraFin . $fila);

        $hoja = $xl->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function textobusqueda($valores) {
        $textoBusqueda = '';
        $Busqueda = null;

        foreach ($valores as $clave => $valor) {
            $clave = trim(strtoupper($clave));
//            echo $clave;
//            echo "<br>";
            if ($valor) {
                if ($clave == 'FECHAINICIO') {
                    $Busqueda[] = 'DEL ' . $valor;
                }
                if ($clave == 'FECHAFIN') {
                    $Busqueda[] = ' AL  ' . $valor;
                }
                if ($clave == 'BANCO') {
                    $query = BancoQuery::create()->findOneById($valor);
                    if ($query) {
                        $valor = $query->getNombre();
                    }
                    $Busqueda[] = ' BANCO : ' . $valor;
                }

                if ($clave == 'ESTATUS') {
                    if ($valor == "") {
                        $Busqueda[] = ' Todos los Estatus ';
                    } else {
                        $Busqueda[] = 'ESTADO : ' . $valor;
                    }
                }
            }
        }
        if ($Busqueda) {
            $textoBusqueda = implode(",", $Busqueda);
        }
        return $textoBusqueda;
    }

    public function executeConfirmar(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
                                   $acceso = MenuSeguridad::Acceso('debito_banco');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
        
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $PartidaQ = PartidaQuery::create()->findOneById($id);
        if ($PartidaQ) {
            $tokenGuardado = sha1($PartidaQ->getId());
            if ($token == $tokenGuardado) {
                $debitoanco = MovimientoBancoQuery::create()->findOneByPartidaNo($PartidaQ->getId());
                if ($debitoanco) {
                    $debitoid = $debitoanco->getId();
                    $valordebito = $debitoanco->getValor() * -1;
//                    echo $valordebito;
//                    die();
                    $Partidas = PartidaDetalleQuery::create()
                            ->filterByPartidaId($PartidaQ->getId())
                            ->withColumn('sum(PartidaDetalle.Haber)', 'TotalHaber')
                            ->withColumn('sum(PartidaDetalle.Debe)', 'TotalDebe')
                            ->findOne();
                    $totalDebe = $Partidas->getTotalDebe();
                    $totalHaber = $Partidas->getTotalHaber();
                    $diferencaia = $totalDebe - $totalHaber;

//                    if (abs($valordebito) <> abs($totalDebe)) {
//                        $this->getUser()->setFlash('error', 'Valores de partida no son correctos, valor esperado ' . $valordebito);
//                        $this->redirect('debito_banco/partidaNueva?id=' . $debitoid);
//                    }
//                    if (abs($valordebito) <> abs($totalHaber)) {
//                        $this->getUser()->setFlash('error', 'Valores de partida no son correctos, valor esperado ' . $valordebito);
//                        $this->redirect('debito_banco/partidaNueva?id=' . $debitoid);
//                    }
//                    if (abs($totalDebe) <> abs($totalHaber)) {
//                        $this->getUser()->setFlash('error', 'Valores de partida no son correctos diferencia ' . $diferencaia);
//
//                        $this->redirect('debito_banco/partidaNueva?id=' . $debitoid);
//                    }
                    $PartidaQ->setConfirmada(true);
                    $PartidaQ->setEstatus('Cerrada');
                    $PartidaQ->save();
                    $this->getUser()->setFlash('exito', 'Partida cerrada con exito');
                    $this->redirect('debito_banco/muestra?id=' . $debitoid);
                }
            }
        }
        $this->redirect('debito_banco/index?id=' . $id);
    }

    public function executeElimina(sfWebRequest $request) {
        $edit = $request->getParameter('edit');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $defaulta['fecha'] = date('d/m/Y');
        $numero = $request->getParameter('no');
        $partidaDetalle = PartidaDetalleQuery::create()
                ->filterById($edit)
                ->findOne();
        $numero = $partidaDetalle->getPartidaId();
        $debito = MovimientoBancoQuery::create()->findOneByPartidaNo($partidaDetalle->getPartidaId());
        $id = $debito->getId();

        if ($partidaDetalle) {
            $this->getUser()->setFlash('error', 'Detalle de partida eliminada con exito');
            $partidaDetalle->delete();
        }

        $Partidas = PartidaDetalleQuery::create()
                ->filterByPartidaId($numero)
                ->withColumn('sum(PartidaDetalle.Haber)', 'TotalHaber')
                ->withColumn('sum(PartidaDetalle.Debe)', 'TotalDebe')
                ->findOne();
        if ($Partidas) {
            $totalDebe = $Partidas->getTotalDebe();
            $totalHaber = $Partidas->getTotalHaber();
        }

        if ($pendiente) {
            $pendiente->setValor($totalDebe);
            $pendiente->save();
        }

        $this->redirect('debito_banco/partidaNueva?id=' . $id);
    }

    public function executePartidaNueva(sfWebRequest $request) {
        $defaulta = null;
        $edit = 0;
        if ($request->getParameter('edit')) {
            $edit = $request->getParameter('edit');
        }
        $id = $request->getParameter('id');
        $debito = MovimientoBancoQuery::create()->findOneById($id);
        $partidaDetalle = PartidaDetalleQuery::create()
                ->filterById($edit)
                ->findOne();
        if ($partidaDetalle) {
            $debito = MovimientoBancoQuery::create()->findOneByPartidaNo($partidaDetalle->getPartidaId());
            $id = $debito->getId();
        }

        $this->id = $id;
        $this->edit = $edit;
        $this->debito = $debito;
        $partidaId = $debito->getPartidaNo();
        $partidaQ = PartidaQuery::create()->findOneById($partidaId);
        $this->partida = $partidaQ;
        $defaulta['fecha'] = $partidaQ->getFechaContable('d/m/Y');
        $defaulta['numero'] = $partidaQ->getId();
        $defaulta['detalle'] = $partidaQ->getTipo();
        $this->borra = 0;
        $this->valor1 = 0;
        $this->valor2 = 0;
        if ($partidaDetalle) {

            if ($partidaDetalle->getDebe() > 0) {
                $defaulta['cuenta_debe'] = $partidaDetalle->getCuentaContable();
                $defaulta['valor_debe'] = $partidaDetalle->getDebe();
                $this->borra = 1;
                $this->valor1 = $partidaDetalle->getDebe();
            }
            if ($partidaDetalle->getHaber() > 0) {
                $defaulta['cuenta_haber'] = $partidaDetalle->getCuentaContable();
                $defaulta['valor_haber'] = $partidaDetalle->getHaber();
                $this->borra = 2;
                $this->valor2 = $partidaDetalle->getHaber();
            }
        }
        $this->form = new EditaPartidaForm($defaulta);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();

//                echo "<pre>";
//                print_r($valores);
//                die();

                if ($partidaDetalle) {
                    if ($valores['cuenta_debe'] <> "") {
                        $partidaDetalle->setCuentaContable($valores['cuenta_debe']);
                    }
                    if ($valores['cuenta_haber'] <> "") {
                        $partidaDetalle->setCuentaContable($valores['cuenta_haber']);
                    }
                    $partidaDetalle->setDebe($valores['valor_debe']);
                    $partidaDetalle->setHaber($valores['valor_haber']);
                    $partidaDetalle->save();
                }
                if (!$partidaDetalle) {
                    if (($valores['cuenta_debe'] <> "") && ($valores['valor_debe'] > 0)) {
                        $cuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($valores['cuenta_debe']);
                        $cuenta = $cuentaQ->getCuentaContable();
                        $nombreCuenta = $cuentaQ->getNombre();
                        $partidaNe = new PartidaDetalle();
                        $partidaNe->setPartidaId($partidaQ->getId());
                        $partidaNe->setCuentaContable($cuenta);
                        $partidaNe->setDetalle($nombreCuenta);
                        $partidaNe->setDebe($valores['valor_debe']);
                        $partidaNe->setHaber(0);
//                        $partidaNe->setDebe($valores['valor_debe']);
//                        $partidaNe->setHaber(0);
                        $partidaNe->save();
                    }
                    if (($valores['cuenta_haber'] <> "") && ($valores['valor_haber'] > 0)) {
                        $cuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($valores['cuenta_haber']);
                        $cuenta = $cuentaQ->getCuentaContable();
                        $nombreCuenta = $cuentaQ->getNombre();
                        $partidaNe = new PartidaDetalle();
                        $partidaNe->setPartidaId($partidaQ->getId());
                        $partidaNe->setCuentaContable($cuenta);
                        $partidaNe->setDetalle($nombreCuenta);
//               $partidaNe->setDebe(0);
//             $partidaNe->setHaber($valores['valor_haber']);
                        $partidaNe->setDebe(0);
                        $partidaNe->setHaber($valores['valor_haber']);
                        $partidaNe->save();
                    }
                }
                $Partidas = PartidaDetalleQuery::create()
                        ->filterByPartidaId($partidaQ->getId())
                        ->withColumn('sum(PartidaDetalle.Debe)', 'ValorTotal')
                        ->findOne();
                if ($Partidas) {
                    $partidaQ->setValor($Partidas->getValorTotal());
                    $partidaQ->save();
                }

                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect('debito_banco/partidaNueva?id=' . $id);

//                echo "<pre>";
//                print_r($valores);
//                die();
            }
        }
        $this->detalle = PartidaDetalleQuery::create()
                ->filterById($edit, Criteria::NOT_EQUAL)
                ->filterByPartidaId($partidaId)
                ->find();
    }

    public function executeMuestra(sfWebRequest $request) {
                                   $acceso = MenuSeguridad::Acceso('debito_banco');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
        $id = $request->getParameter('id');
        $this->muestra = MovimientoBancoQuery::create()->findOneById($id);
    }

    public function executePartida(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $this->partida = PartidaQuery::create()->findOneById($id);
    }

    public function partidaPago($movimientoBanco) {
        $valorV = $movimientoBanco->getValor() * -1;

        $partidaId = Partida::Crea('Debito Banco ', $movimientoBanco->getId(), $valorV, null, $movimientoBanco->getFechaDocumento());

        $cuentaContable = $movimientoBanco->getBancoRelatedByBancoOrigen()->getCuentaContable();
        if ($cuentaContable == '') {
            $cuentaPartida = Partida::busca("BANCO DEBITO" . $movimientoBanco->getBancoRelatedByBancoOrigen()->getCodigo(), 5, 3);
            $cuentaContable = $cuentaPartida['cuenta'];
            $nombreCuenta = $cuentaPartida['nombre'];
        }
        $nombreCuenta = Partida::cuenta($cuentaContable);
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setHaber($valorV);
        $partidaLinea->setDebe(0);
        $partidaLinea->setTipo(5);
        $partidaLinea->setGrupo("BANCO  DEBITO" . $movimientoBanco->getBancoRelatedByBancoOrigen()->getCodigo());
        $partidaLinea->save();

        $cuentaPartida = Partida::busca("CUENTA%PAGAR", 5, 3);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
//   $nombreCuenta = Partida::cuenta($cuentaContable);
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setHaber(0);
        $partidaLinea->setDebe($valorV);
        $partidaLinea->setTipo(5);
        $partidaLinea->setGrupo("CUENTA PAGAR");
        $partidaLinea->save();

        $movimientoBanco->setPartidaNo($partidaId);
        $movimientoBanco->save();
    }

    public function executeIndex(sfWebRequest $request) {
             error_reporting(-1);
        date_default_timezone_set("America/Guatemala");

                                   $acceso = MenuSeguridad::Acceso('debito_banco');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
        
        $Movimiento = MovimientoBancoQuery::create()
                ->filterByTipoMovimiento("Transferencia")
                ->filterByPartidaNo(0)
                ->find();
        foreach ($Movimiento as $Lista) {
            if ($Lista->getTipoMovimiento() == "Transferencia") {
                $movimB = MovimientoBancoQuery::create()
                        ->filterByTipoMovimiento("Transferencia")
                        ->filterByDocumento($Lista->getDocumento())
// ->filterByBancoId($Lista->getBancoId())
                        ->filterByPartidaNo(0, Criteria::GREATER_THAN)
                        ->findOne();
                if ($movimB) {
                    $partidaId = $movimB->getPartidaNo();
                    $Lista->setPartidaNo($partidaId);
                    $Lista->save();
                }
            }
        }

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBanco', null, 'consulta'));
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['banco'] = null;
            sfContext::getInstance()->getUser()->setAttribute('datoconsultaBanco', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaReporteCajaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsultaBanco', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBanco', null, 'consulta'));
                $this->redirect('debito_banco/index?id=');
            }
        }
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '00:00';
        $valores['fin'] = '23:00';
        if ($valores['banco']) {
            $this->operaciones = MovimientoBancoQuery::create()
                    ->filterByBancoId($valores['banco'])
                    ->orderByFechaDocumento("Desc")
                    ->filterByTipo('Debito')
                    ->where("MovimientoBanco.FechaDocumento >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("MovimientoBanco.FechaDocumento <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->find();
        } else {
            $this->operaciones = MovimientoBancoQuery::create()
                    ->orderByFechaDocumento("Desc")
                    ->filterByTipo('Debito')
                    ->where("MovimientoBanco.FechaDocumento >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("MovimientoBanco.FechaDocumento <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->find();
        }


        $this->bancos = BancoQuery::create()
                ->orderByNombre("Asc")
                ->filterByActivo(true)
                ->find();

//        $operaciones = MovimientoBancoQuery::create()
//                ->orderById("Desc")
//                ->filterByTipo('DEBITO')
//                ->setLimit(1)
//                 ->find();
//        $partidas[]=0;   
//         foreach ($operaciones as $regi){
//            $partidas[]=$regi->getPartidaNo();             
//         }

        $partidas = null;

        $this->partidas = $partidas;
    }

    public function executeNueva(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $default['fecha_movimiento'] = date('d/m/Y');
        $this->form = new IngresaDebitoBancoForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $fecha_documento = $valores['fecha_movimiento'];
                $fecha_documento = explode('/', $fecha_documento);
                $fecha_documento = $fecha_documento[2] . '-' . $fecha_documento[1] . '-' . $fecha_documento[0];
                $medioPago = MedioPagoQuery::create()->findOneById($valores['medio_pago']);
                $movimiento = New MovimientoBanco();
                $movimiento->setTipo('Debito');
                $movimiento->setTipoMovimiento($medioPago->getNombre());
                $movimiento->setBancoId($valores['banco']);
                $movimiento->setValor($valores['monto']);
                $movimiento->setBancoOrigen($valores['banco']);
                $movimiento->setDocumento($valores['referencia']);
                $movimiento->setFechaDocumento($fecha_documento);
                $movimiento->setValor($valores['monto'] * -1);
                $movimiento->setObservaciones($valores['observaciones']);
                $movimiento->setEstatus("Confirmado");
                $movimiento->setMedioPagoId($valores['medio_pago']);
                $movimiento->setUsuario($usuarioQ->getUsuario());
                $movimiento->save();

//                $cxc = New CuentaBanco();
//                $cxc->setBancoId($movimiento->getBancoId());
//                $cxc->setMovimientoBancoId($movimiento->getId());
//                $cxc->setValor($movimiento->getValor() * -1);
//                $cxc->setFecha($movimiento->getCreatedAt());
//                $cxc->setDocumento($movimiento->getDocumento());
//                $cxc->setUsuario($movimiento->getUsuario());
//                $cxc->setCreatedAt($movimiento->getCreatedAt());
//                $cxc->setObservaciones($movimiento->getTipo());
//                $cxc->save();
                $archivo = $valores["archivo"];
                if ($archivo) {
                    $carpetaArchivo = 'movimiento' . $empresaId;
                    $filename = sha1($archivo->getOriginalName() . date("Ymdhis") . rand(111111, 999999)) . $archivo->getExtension($archivo->getOriginalExtension());
                    $archivo->save(sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . $carpetaArchivo . DIRECTORY_SEPARATOR . $filename);
                    $nombreOriginal = $archivo->getOriginalName();
                    $bitacora = New BitacoraArchivo();
                    $bitacora->setNombre($filename);
                    $bitacora->setTipo('Movimiento');
                    $bitacora->setNombreOriginal($nombreOriginal);
                    $bitacora->setCarpeta($carpetaArchivo);
                    $bitacora->save();
                    $movimiento->setBitacoraArchivoId($bitacora->getId());
                    $movimiento->save();
                }
                $this->partidaPago($movimiento);
                $this->getUser()->setFlash('exito', 'Débito bancario');
                $this->redirect('debito_banco/muestra?id=' . $movimiento->getId());
            }
        }
    }

}
