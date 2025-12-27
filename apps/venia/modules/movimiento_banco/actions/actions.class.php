<?php

/**
 * movimiento_banco actions.
 *
 * @package    plan
 * @subpackage movimiento_banco
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class movimiento_bancoActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $acceso = MenuSeguridad::Acceso('movimiento_banco');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }


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
        $pestanas[] = 'Movimiento Banco Transferencia';
        $filename = "Movimiento Banco Transferencia   " . $nombreempresa . date("d_m_Y");
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

        $hoja->getCell("C1")->setValueExplicit("Movimiento Banco Transferencia ", PHPExcel_Cell_DataType::TYPE_STRING);
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
        $operaciones->filterByTipo('Credito');
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

    public function executeMuestra(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $this->muestra = MovimientoBancoQuery::create()->findOneById($id);
        $acceso = MenuSeguridad::Acceso('movimiento_banco');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
    }

    public function executeNueva(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $default['fecha_movimiento'] = date('d/m/Y');
        $this->form = new IngresoMovimientoForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $fecha_documento = $valores['fecha_movimiento'];
                $fecha_documento = explode('/', $fecha_documento);
                $fecha_documento = $fecha_documento[2] . '-' . $fecha_documento[1] . '-' . $fecha_documento[0];
                $movimiento = New MovimientoBanco();
                $movimiento->setTipoMovimiento('Transferencia');
                $movimiento->setTipo('Credito');
                $movimiento->setBancoOrigen($valores['banco_origen']);
                $movimiento->setDocumento($valores['referencia']);
                $movimiento->setBancoId($valores['banco_destino']);
                $movimiento->setFechaDocumento($fecha_documento);
                $movimiento->setValor($valores['monto']);
                $movimiento->setObservaciones($valores['observaciones']);
                $movimiento->setEstatus("Confirmado");
                $movimiento->setUsuario($usuarioQ->getUsuario());
                $movimiento->save();
                $this->partida($movimiento);
                $IDMOV = $movimiento->getId();
                $movimiento = New MovimientoBanco();
                $movimiento->setTipoMovimiento('Transferencia');
                $movimiento->setTipo('Debito');
                $movimiento->setBancoOrigen($valores['banco_origen']);
                $movimiento->setDocumento($valores['referencia']);
                $movimiento->setBancoId($valores['banco_origen']);
                $movimiento->setFechaDocumento($fecha_documento);
                $movimiento->setValor($valores['monto'] * -1);
                $movimiento->setObservaciones($valores['observaciones']);
                $movimiento->setEstatus("Confirmado");
                $movimiento->setUsuario($usuarioQ->getUsuario());
                $movimiento->save();

//                        $cxc = New CuentaBanco();
//                        $cxc->setBancoId($movimiento->getBancoOrigen());
//                        $cxc->setMovimientoBancoId($movimiento->getId());
//                        $cxc->setValor($movimiento->getValor()*-1);
//                        $cxc->setFecha($movimiento->getCreatedAt());
//                        $cxc->setDocumento($movimiento->getDocumento());
//                        $cxc->setUsuario($movimiento->getUsuario());
//                        $cxc->setCreatedAt($movimiento->getCreatedAt());
//                        $cxc->setObservaciones($movimiento->getTipo());
//                        $cxc->save();
//                        
//                        $cxc = New CuentaBanco();
//                        $cxc->setBancoId($movimiento->getBancoId());
//                        $cxc->setMovimientoBancoId($movimiento->getId());
//                        $cxc->setValor($movimiento->getValor());
//                        $cxc->setFecha($movimiento->getCreatedAt());
//                        $cxc->setDocumento($movimiento->getDocumento());
//                        $cxc->setUsuario($movimiento->getUsuario());
//                        $cxc->setCreatedAt($movimiento->getCreatedAt());
//                        $cxc->setObservaciones($movimiento->getTipo());
//                        $cxc->save();



                $this->getUser()->setFlash('exito', 'Transferencia ingresada con exito ');
                $this->redirect('movimiento_banco/muestra?id=' . $IDMOV);
            }
        }
    }

    public function partida($movimientoBanco) {


        $bancoOrigen = BancoQuery::create()->findOneById($movimientoBanco->getBancoOrigen());
        $bancoDestino = BancoQuery::create()->findOneById($movimientoBanco->getBancoId());
        $partidaId = Partida::Crea('Transferencia Banco ', $movimientoBanco->getId(), $movimientoBanco->getValor(), null, $movimientoBanco->getFechaDocumento());
        // $cuentaContable = '2.1.1.2.001';
        $cuentaContable = $bancoOrigen->getCuentaContable();
        $nombreCuenta = Partida::cuenta($cuentaContable);
        if ($cuentaContable == '') {
            $cuentaPartida = Partida::busca("BANCO " . $bancoOrigen->getCodigo(), 0, 2, $bancoOrigen->getCodigo());
            $cuentaContable = $cuentaPartida['cuenta'];
            $nombreCuenta = $cuentaPartida['nombre'];
        }

        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setHaber($movimientoBanco->getValor());
        $partidaLinea->setDebe(0);
        //      $partidaLinea->setDebe($movimientoBanco->getValor());
        //      $partidaLinea->setHaber(0);       
        $partidaLinea->setTipo(0);
        $partidaLinea->setGrupo("BANCO " . $bancoOrigen->getCodigo());
        $partidaLinea->save();

        $cuentaContable = $bancoDestino->getCuentaContable();
        if ($cuentaContable == '') {
            $cuentaPartida = Partida::busca("BANCO " . $bancoDestino->getCodigo(), 0, 2, $bancoOrigen->getCodigo());
            $cuentaContable = $cuentaPartida['cuenta'];
            $nombreCuenta = $cuentaPartida['nombre'];
        }

        $nombreCuenta = Partida::cuenta($cuentaContable);
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        //      $partidaLinea->setDebe(0);
        //      $partidaLinea->setHaber($movimientoBanco->getValor());
        $partidaLinea->setHaber(0);
        $partidaLinea->setDebe($movimientoBanco->getValor());
        $partidaLinea->setTipo(0);
        $partidaLinea->setGrupo("BANCO " . $bancoDestino->getCodigo());
        $partidaLinea->save();
        $movimientoBanco->setPartidaNo($partidaId);
        $movimientoBanco->save();
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $acceso = MenuSeguridad::Acceso('movimiento_banco');
        if (!$acceso) {
            $this->redirect('inicio/index');
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
                $this->redirect('movimiento_banco/index?id=');
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
                    ->filterByBancoOrigen($valores['banco'])
                    ->orderByFechaDocumento("Desc")
                    ->filterByTipoMovimiento('Transferencia')
                    ->where("MovimientoBanco.FechaDocumento >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("MovimientoBanco.FechaDocumento <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->find();
        } else {
            $this->operaciones = MovimientoBancoQuery::create()
                    ->orderByFechaDocumento("Desc")
                    ->filterByTipoMovimiento('Transferencia')
                    ->where("MovimientoBanco.FechaDocumento >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("MovimientoBanco.FechaDocumento <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->find();
        }

        $this->bancos = BancoQuery::create()
                ->orderByNombre("Asc")
                ->filterByActivo(true)
                ->find();

//           $operaciones = MovimientoBancoQuery::create()
//                ->orderById("Desc")
//                ->filterByTipo('Transferencia')
//                ->setLimit(50)
//                 ->find();
//        $partidas[]=0;   
//         foreach ($operaciones as $regi){
//        $partidas[]=$regi->getPartidaNo();
//             
//         }
//        
//         $this->partidas = $partidas;
//        $partidaPen = PartidaQuery::create()->filterById($partidas, Criteria::IN)->filterByConfirmada(false)->orderById('Asc')->findOne();  
//         echo "<pre>";
//         print_r($partidaPen);
//         die();
    }
}
