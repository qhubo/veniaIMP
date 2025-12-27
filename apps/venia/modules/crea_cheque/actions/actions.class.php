<?php

/**
 * crea_cheque actions.
 *
 * @package    plan
 * @subpackage crea_cheque
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class crea_chequeActions extends sfActions {

    public function executeReporteExcel(sfWebRequest $request) {
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
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = $EmpresaQuery->getNombre();

        $pestanas[] = 'Listado Cheque';

        $filename = "Listado de cheques emitidos  " . $nombreempresa . date("d_m_Y");
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

        $hoja->getCell("C1")->setValueExplicit("Listado de cheques emitidos ", PHPExcel_Cell_DataType::TYPE_STRING);
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
        $encabezados[] = array("Nombre" => strtoupper("Tipo"), "width" => 25, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Banco"), "width" => 40, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Numero"), "width" => 20, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Nombre"), "width" => 40, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Valor Total"), "width" => 25, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Estatus"), "width" => 20, "align" => "left", "format" => "#,##0");

        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

        $cheques = new ChequeQuery();
        $cheques->where("Cheque.FechaCreo >= '" . $fechaInicio . " 00:00:00" . "'");
        $cheques->where("Cheque.FechaCreo <= '" . $fechaFin . " 23:59:00" . "'");
        if ($valores['banco']) {
            $cheques->filterByBancoId($valores['banco']);
        }
        if ($valores['estatus']) {
            $cheques->filterByEstatus($valores['estatus']);
        }
        $this->cheques = $cheques->find();
        $total = 0;
        foreach ($this->cheques as $registro) {
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $registro->getFechaCheque('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getUsuario());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getTipoDetalle());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getBanco()->getNombre());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getNumero());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getBeneficiario());  // ENTERO

            $datos[] = array("tipo" => 2, "valor" => $registro->getValor());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getEstatus());  // ENTERO


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
                  if  ($valor=="") {
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

    public function partidaSolici($solicitud) {

        $tienda = '';
        $tiendaID = sfContext::getInstance()->getUser()->getAttribute("tienda", null, 'seguridad');
        $tiendaQ = TiendaQuery::create()->findOneById($tiendaID);
        if ($tiendaQ) {
            $tienda = $tiendaQ->getNombre();
        }
        $partidaId = Partida::Crea('Cheque ' . $solicitud->getTipo(), $solicitud->getId(), $solicitud->getValor());
        $solicitud->setPartidaNo($partidaId);
        $solicitud->save();
        $valor = $solicitud->getValor();

        $cuentaPartida = Partida::busca("SOL" . $solicitud->getTipo(), 1, 2);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        if ($cuentaContable == "") {
            $nombreCuenta = 'CUENTAS POR PAGAR EMPLEADOS';
            $cuentaContable = '2015-08';
        }
        //   $nombreCuenta = Partida::cuenta($cuentaContable);
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe($valor);
        $partidaLinea->setHaber(0);
        $partidaLinea->setTipo(1);
        $partidaLinea->setGrupo("SOL" . $solicitud->getTipo());
        $partidaLinea->save();

        $cheque = ChequeQuery::create()->findOneBySolicitudChequeId($solicitud->getId());
        $cuentaER = CuentaErpContableQuery::create()->findOneByCuentaContable($cheque->getBanco()->getCuentaContable());
        $nombreCuenta = $cuentaER->getNombre();
        $cuentaContable = $cuentaER->getCuentaContable();

        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe(0);
        $partidaLinea->setHaber($valor);
        $partidaLinea->setGrupo("PAGO " . $solicitud->getTipo());
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();

        return $partidaId;
    }

    public function executeMuestraS(sfWebRequest $request) {
        
               $modulo = 'crea_cheque';
                     $acceso = MenuSeguridad::Acceso('crea_cheque');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
        
        
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $this->id = $id;
        $devolucion = SolicitudChequeQuery::create()->findOneById($id);
        $this->total = $devolucion->getValor();
        $this->devolucion = $devolucion;
        $default['no_negociable'] = true;
        $this->form = new CreaNuevoChequeForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $partidaNo = $devolucion->getPartidaNo();
//                $partidaDetalle = PartidaDetalleQuery::create()
//                        ->filterByGrupo('DEVSCHEQUE')
//                        ->filterByPartidaId($partidaNo)
//                        ->findOne();
//                if ($partidaDetalle) {
//                    $bancoQ = BancoQuery::create()->findOneById($valores['banco']);
//                    if ($bancoQ) {
//                   $cuenta=   $cuentaConta=$bancoQ->getCuentaContable();
//                   $cuentCon= CuentaErpContableQuery::create()->findOneByCuentaContable($cuenta);
//                   $partidaDetalle->setCuentaContable($cuenta);
//                   $partidaDetalle->setDetalle($cuentCon->getNombre());
//                   $partidaDetalle->save();
//                    }
//                }
//                echo "<pre>";
//                print_r($partidaDetalle);
//                die();
                $cheque = new Cheque();
                $cheque->setDocumentoChequeId($valores['formato']);
                $cheque->setSolicitudChequeId($devolucion->getId());
                $cheque->setBeneficiario($devolucion->getNombre());
                $cheque->setBancoId($valores['banco']);
                $cheque->setNumero($valores['cheque']);
                $cheque->setMotivo($devolucion->getMotivo());
                $cheque->setEstatus("Procesado");
                $cheque->setFechaCheque(date('Y-m-d'));
                $cheque->setUsuario($usuarioQ->getUsuario());
                $cheque->setFechaCreo(date('Y-m-d H:i:s'));
                $cheque->save();
                $cheque->setNegociable(true);
                if ($valores['no_negociable']) {
                    $cheque->setNegociable(true);
                }
                $cheque->setValor($this->total);
                $cheque->save();
                $devolucion->setChequeNo($cheque->getId());
                $devolucion->save();

                //** movimiento banco
                $movimiento = New MovimientoBanco();
                $movimiento->setTipoMovimiento($devolucion->getTipo());
                $movimiento->setTipo('Cheque');
                $movimiento->setBancoId($cheque->getBancoId());
                $movimiento->setValor($cheque->getValor() * -1);
                $movimiento->setBancoOrigen($cheque->getBancoId());
                $movimiento->setDocumento($cheque->getNumero());
                $movimiento->setFechaDocumento($cheque->getFechaCheque('Y-m-d'));
                $movimiento->setObservaciones("Cheque No " . $cheque->getNumero());
                $movimiento->setEstatus("Confirmado");
                $movimiento->setUsuario($usuarioQ->getUsuario());

//                $movimiento->setPartidaNo($v)
                $movimiento->save();
                $partidaId = $this->partidaSolici($devolucion);
                $movimiento->setPartidaNo($partidaId);
                $movimiento->save();
                $devolucion->setEstatus("Procesado");
                $devolucion->save();
                $formato = DocumentoChequeQuery::create()->findOneById($valores['formato']);
                $formato->setCorrelativo($valores['cheque'] + 1);
                $formato->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect('crea_cheque/cheque?id=' . $cheque->getId());
            }
        }
    }

    public function executeMuestraD(sfWebRequest $request) {
                  $modulo = 'crea_cheque';
                     $acceso = MenuSeguridad::Acceso('crea_cheque');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $this->id = $id;
        $devolucion = OrdenDevolucionQuery::create()->findOneById($id);
        $this->total = $devolucion->getValor() - $devolucion->getValorOtros();
        $this->devolucion = $devolucion;
        $default['no_negociable'] = true;
        $this->form = new CreaNuevoChequeForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $partidaNo = $devolucion->getPartidaNo();
                $partidaDetalle = PartidaDetalleQuery::create()
                        ->filterByGrupo('DEVSCHEQUE')
                        ->filterByPartidaId($partidaNo)
                        ->findOne();
                if ($partidaDetalle) {
                    $bancoQ = BancoQuery::create()->findOneById($valores['banco']);
                    if ($bancoQ) {
                        $cuenta = $cuentaConta = $bancoQ->getCuentaContable();
                        $cuentCon = CuentaErpContableQuery::create()->findOneByCuentaContable($cuenta);
                        $partidaDetalle->setCuentaContable($cuenta);
                        $partidaDetalle->setDetalle($cuentCon->getNombre());
                        $partidaDetalle->save();
                    }
                }
//                echo "<pre>";
//                print_r($partidaDetalle);
//                die();
                $cheque = new Cheque();
                $cheque->setDocumentoChequeId($valores['formato']);
                $cheque->setOrdenDevolucionId($devolucion->getId());
                $cheque->setBeneficiario($devolucion->getNombre());
                $cheque->setBancoId($valores['banco']);
                $cheque->setNumero($valores['cheque']);
                $cheque->setMotivo($devolucion->getConcepto());
                $cheque->setEstatus("Procesado");
                $cheque->setFechaCheque(date('Y-m-d'));
                $cheque->setUsuario($usuarioQ->getUsuario());
                $cheque->setFechaCreo(date('Y-m-d H:i:s'));
                $cheque->save();
                $cheque->setNegociable(true);
                if ($valores['no_negociable']) {
                    $cheque->setNegociable(true);
                }
                $cheque->setValor($this->total);
                $cheque->save();
                $devolucion->setChequeNo($cheque->getId());
                $devolucion->save();

                //** movimiento banco
                $movimiento = New MovimientoBanco();
                $movimiento->setTipoMovimiento('Devolucion');
                $movimiento->setTipo('Cheque');
                $movimiento->setBancoId($cheque->getBancoId());
                $movimiento->setValor($cheque->getValor() * -1);
                $movimiento->setBancoOrigen($cheque->getBancoId());
                $movimiento->setDocumento($cheque->getNumero());
                $movimiento->setFechaDocumento($cheque->getFechaCheque('Y-m-d'));
                $movimiento->setObservaciones("Cheque No " . $cheque->getNumero());
                $movimiento->setEstatus("Confirmado");
                //           $movimiento->setMedioPagoId();
                $movimiento->setUsuario($usuarioQ->getUsuario());
                $movimiento->save();
                $formato = DocumentoChequeQuery::create()->findOneById($valores['formato']);
                $formato->setCorrelativo($valores['cheque'] + 1);
                $formato->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect('crea_cheque/cheque?id=' . $cheque->getId());
            }
        }
    }

    public function executeIndex(sfWebRequest $request) {
                  $modulo = 'crea_cheque';
                     $acceso = MenuSeguridad::Acceso('crea_cheque');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
        date_default_timezone_set("America/Guatemala");
        sfContext::getInstance()->getUser()->setAttribute("banco", null, 'seleccion');
        $this->ordenes = OrdenProveedorPagoQuery::create()
                ->filterByTipoPago('Cheque')
                ->filterByChequeId(null)
                ->find();
        $this->gastos = GastoPagoQuery::create()
                ->filterByTipoPago('Cheque')
                ->filterByChequeId(null)
                ->find();
        $this->tab = 1;
        if ($request->getParameter('tab')) {
            $this->tab = $request->getParameter('tab');
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
        $this->form = new ConsultaChequeBancoFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsultaBan', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBan', null, 'consulta'));
                $this->redirect('crea_cheque/index?tab=3');
            }
        }

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

        $cheques = new ChequeQuery();
        $cheques->where("Cheque.FechaCreo >= '" . $fechaInicio . " 00:00:00" . "'");
        $cheques->where("Cheque.FechaCreo <= '" . $fechaFin . " 23:59:00" . "'");
        if ($valores['banco']) {
            $cheques->filterByBancoId($valores['banco']);
        }
        if ($valores['estatus']) {
            $cheques->filterByEstatus($valores['estatus']);
        }
        $this->cheques = $cheques->find();
        $this->devoluciones = OrdenDevolucionQuery::create()
                ->filterByEstatus('Autorizado')
                ->filterByPagoMedio('Cheque')
                ->filterByChequeNo(0)
                ->find();
        $totalPendiente = count($this->devoluciones) + count($this->ordenes) + count($this->gastos);
        if ($totalPendiente == 0) {
            $this->tab = 3;
        }

        $this->solicitudes = SolicitudChequeQuery::create()
                ->filterByEstatus('Nuevo')
                ->filterByChequeNo(0)
                ->find();

        $this->partidaPen = PartidaQuery::create()
                ->filterByConfirmada(0)
                ->filterByTipo('%cheque%', Criteria::LIKE)
                ->findOne();
    }

    public function executeLimpiag(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $this->id = $id;
        $gasto = GastoPagoQuery::create()->findOneById($id);
        $gastos = GastoPagoQuery::create()
                ->filterByBancoId($gasto->getBancoId())
                ->filterByProveedorId($gasto->getProveedorId())
                ->filterByTipoPago('Cheque')
                ->filterByChequeId(null)
                ->find();
        foreach ($gastos as $registro) {
            $registro->setTemporal(false);
            $registro->save();
        }
        $gasto->setTemporal(true);
        $gasto->save();
        $this->redirect('crea_cheque/muestrag?id=' . $gasto->getId());
    }

    public function executeLimpia(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $this->id = $id;
        $gasto = OrdenProveedorPagoQuery::create()->findOneById($id);
        $gastos = OrdenProveedorPagoQuery::create()
                ->filterByBancoId($gasto->getBancoId())
                ->filterByProveedorId($gasto->getProveedorId())
                ->filterByTipoPago('Cheque')
                ->filterByChequeId(null)
                ->find();
        foreach ($gastos as $registro) {
            $registro->setTemporal(false);
            $registro->save();
        }
        $gasto->setTemporal(true);
        $gasto->save();
        $this->redirect('crea_cheque/muestra?id=' . $gasto->getId());
    }

    public function executeMuestra(sfWebRequest $request) {
        
                  $modulo = 'crea_cheque';
                     $acceso = MenuSeguridad::Acceso('crea_cheque');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $this->id = $id;
        $gasto = OrdenProveedorPagoQuery::create()->findOneById($id);
        $this->gastos = OrdenProveedorPagoQuery::create()
                ->filterByBancoId($gasto->getBancoId())
                ->filterByProveedorId($gasto->getProveedorId())
                ->filterByTipoPago('Cheque')
                ->filterByChequeId(null)
                ->find();

        $this->total = OrdenProveedorPagoQuery::Pago($gasto->getProveedorId(), $gasto->getBancoId());
        sfContext::getInstance()->getUser()->setAttribute("banco", $gasto->getBancoId(), 'seleccion');
        $default['banco'] = $gasto->getBanco()->getNombre();
        $default['no_negociable'] = true;
        $this->form = new CreaSeleccionChequeForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $cheque = new Cheque();
                $cheque->setDocumentoChequeId($valores['formato']);
                $cheque->setProveedorId($gasto->getProveedorId());
                $cheque->setBeneficiario($gasto->getOrdenProveedor()->getNombre());
                $cheque->setBancoId($gasto->getBancoId());
                $cheque->setNumero($valores['cheque']);
                $cheque->setMotivo($gasto->getOrdenProveedor()->getComentario());
                $cheque->setEstatus("Procesado");
                $cheque->setFechaCheque(date('Y-m-d'));
                $cheque->setUsuario($usuarioQ->getUsuario());
                $cheque->setFechaCreo(date('Y-m-d H:i:s'));
                $cheque->save();
                $cheque->setNegociable(true);
                if ($valores['no_negociable']) {
                    $cheque->setNegociable(true);
                }
                $cheque->setValor($this->total);
                $cheque->save();
                $Lista = OrdenProveedorPagoQuery::create()
                        ->filterByTemporal(true)
                        ->filterByTipoPago('Cheque')
                        ->filterByChequeId(null)
                        ->filterByProveedorId($gasto->getOrdenProveedor()->getProveedorId())
                        ->filterByBancoId($gasto->getBancoId())
                        ->find();
                foreach ($Lista as $detalle) {
                    $detalle->setChequeId($cheque->getId());
                    $detalle->save();
                }
                $formato = DocumentoChequeQuery::create()->findOneById($valores['formato']);
                $formato->setCorrelativo($valores['cheque'] + 1);
                $formato->save();

                $movimiento = New MovimientoBanco();
                $movimiento->setTipoMovimiento('Orden Compra');
                $movimiento->setTipo('Cheque');
                $movimiento->setBancoId($cheque->getBancoId());
                $movimiento->setValor($cheque->getValor() * -1);
                $movimiento->setBancoOrigen($cheque->getBancoId());
                $movimiento->setDocumento($cheque->getNumero());
                $movimiento->setFechaDocumento($cheque->getFechaCheque('Y-m-d'));
                $movimiento->setObservaciones("Cheque No " . $cheque->getNumero());
                $movimiento->setEstatus("Confirmado");
                //           $movimiento->setMedioPagoId();
                $movimiento->setUsuario($usuarioQ->getUsuario());
                $movimiento->save();

                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect('crea_cheque/cheque?id=' . $cheque->getId());
            }
        }
    }

    public function executeMuestrag(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $this->id = $id;
        $gasto = GastoPagoQuery::create()->findOneById($id);

        $this->gastos = GastoPagoQuery::create()
                ->filterByBancoId($gasto->getBancoId())
                ->filterByProveedorId($gasto->getProveedorId())
                ->filterByTipoPago('Cheque')
                ->filterByChequeId(null)
                ->find();
        $this->total = GastoPagoQuery::Pago($gasto->getProveedorId(), $gasto->getBancoId());
        sfContext::getInstance()->getUser()->setAttribute("banco", $gasto->getBancoId(), 'seleccion');
        $default['banco'] = $gasto->getBanco()->getNombre();
        $default['no_negociable'] = true;
        $formatocheque = DocumentoChequeQuery::create()
                ->filterByBancoId($gasto->getBancoId())
                ->find();
        if (count($formatocheque) == 1) {
            $default['formato'] = $formatocheque[0]->getId();
            $default['cheque'] = $formatocheque[0]->getCorrelativo();
        }
        $default['nombre_beneficiario'] = $gasto->getGasto()->getProveedor();
        $this->nombre = $gasto->getGasto()->getProveedor();
        $this->caja = GastoCajaQuery::create()
                ->filterByGastoId($gasto->getGastoId())
                ->count();

        $this->form = new CreaSeleccionChequeForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $cheque = new Cheque();
                $cheque->setDocumentoChequeId($valores['formato']);
                $cheque->setProveedorId($gasto->getProveedorId());
                $cheque->setBeneficiario($valores['nombre_beneficiario']);
                $cheque->setBancoId($gasto->getBancoId());
                $cheque->setNumero($valores['cheque']);
                $cheque->setMotivo($gasto->getGasto()->getDetalle());
                $cheque->setEstatus("Procesado");
                $cheque->setFechaCheque(date('Y-m-d'));
                $cheque->setUsuario($usuarioQ->getUsuario());

                $cheque->setFechaCreo(date('Y-m-d H:i:s'));
                $cheque->save();
                $cheque->setNegociable(true);
                if ($valores['no_negociable']) {
                    $cheque->setNegociable(true);
                }
                $cheque->setValor($this->total);
                $cheque->save();
                $Lista = GastoPagoQuery::create()
                        ->filterByTemporal(true)
                        ->filterByTipoPago('Cheque')
                        ->filterByChequeId(null)
                        ->filterByProveedorId($gasto->getGasto()->getProveedorId())
                        ->filterByBancoId($gasto->getBancoId())
                        ->find();
                foreach ($Lista as $detalle) {
                    $detalle->setChequeId($cheque->getId());
                    $detalle->save();
                }
                $formato = DocumentoChequeQuery::create()->findOneById($valores['formato']);
                $formato->setCorrelativo($valores['cheque'] + 1);
                $formato->save();

                $movimiento = New MovimientoBanco();
                $movimiento->setTipoMovimiento('Gasto');
                $movimiento->setTipo('Cheque');
                $movimiento->setBancoId($cheque->getBancoId());
                $movimiento->setValor($cheque->getValor() * -1);
                $movimiento->setBancoOrigen($cheque->getBancoId());
                $movimiento->setDocumento($cheque->getNumero());
                $movimiento->setFechaDocumento($cheque->getFechaCheque('Y-m-d'));
                $movimiento->setObservaciones("Cheque No " . $cheque->getNumero());
                $movimiento->setEstatus("Confirmado");
                //           $movimiento->setMedioPagoId();
                $movimiento->setUsuario($usuarioQ->getUsuario());
                $movimiento->save();

                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect('crea_cheque/cheque?id=' . $cheque->getId());
            }
        }
    }

    public function executeCheckO(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $vivi = $request->getParameter('vivi');
        $cuentaVivienda = OrdenProveedorPagoQuery::create()->findOneById($id);
        $viviendaId = 0;
        $bancoId = 0;
        if ($cuentaVivienda) {
            $cuentaVivienda->setTemporal(true);
            $cuentaVivienda->save();
            $ordenProvee = $cuentaVivienda->getProveedorId();
            $bancoId = $cuentaVivienda->getBancoId();
        }
        $gradTOTAL = OrdenProveedorPagoQuery::Pago($ordenProvee, $bancoId);
        $gradTOTAL = number_format($gradTOTAL, 2);
        $gradTOTAL = "<h3>" . $gradTOTAL . "</h3>";
        ECHO $gradTOTAL;
        die();
    }

    public function executeUncheckO(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $cuentaVivienda = OrdenProveedorPagoQuery::create()->findOneById($id);
        if ($cuentaVivienda) {
            $cuentaVivienda->setTemporal(false);
            $cuentaVivienda->save();
            $ordenProvee = $cuentaVivienda->getProveedorId();
            $bancoId = $cuentaVivienda->getBancoId();
        }
        $gradTOTAL = OrdenProveedorPagoQuery::Pago($ordenProvee, $bancoId);
        $gradTOTAL = number_format($gradTOTAL, 2);
        $gradTOTAL = "<h3>" . $gradTOTAL . "</h3>";
        ECHO $gradTOTAL;

        die();
    }

    public function executeCheck(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $vivi = $request->getParameter('vivi');
        $cuentaVivienda = GastoPagoQuery::create()->findOneById($id);
        $viviendaId = 0;
        $bancoId = 0;
        if ($cuentaVivienda) {
            $cuentaVivienda->setTemporal(true);
            $cuentaVivienda->save();
            $ordenProvee = $cuentaVivienda->getProveedorId();
            $bancoId = $cuentaVivienda->getBancoId();
        }
        $gradTOTAL = GastoPagoQuery::Pago($ordenProvee, $bancoId);
        $gradTOTAL = number_format($gradTOTAL, 2);
        $gradTOTAL = "<h3>" . $gradTOTAL . "</h3>";
        ECHO $gradTOTAL;
        die();
    }

    public function executeUncheck(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $cuentaVivienda = GastoPagoQuery::create()->findOneById($id);
        if ($cuentaVivienda) {
            $cuentaVivienda->setTemporal(false);
            $cuentaVivienda->save();
            $ordenProvee = $cuentaVivienda->getProveedorId();
            $bancoId = $cuentaVivienda->getBancoId();
        }
        $gradTOTAL = GastoPagoQuery::Pago($ordenProvee, $bancoId);
        $gradTOTAL = number_format($gradTOTAL, 2);
        $gradTOTAL = "<h3>" . $gradTOTAL . "</h3>";
        ECHO $gradTOTAL;

        die();
    }

    public function executeReporte(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&
        $cheque = ChequeQuery::create()->findOneById($id);
        $documentoCheque = DocumentoChequeQuery::create()->findOneById($cheque->getDocumentoChequeId());
        $x = $documentoCheque->getAncho();
        $y = $documentoCheque->getAlto();
        if ($request->getParameter('X')) {
            $x = $request->getParameter('X');
        }
        if ($request->getParameter('Y')) {
            $y = $request->getParameter('Y');
        }
        $medidas = array($x, $y);
        $pdf = new TCPDF('P', 'mm', $medidas, true, 'UTF-8', false);
        if (($x == 0) && ($y == 0)) {
            $pdf = new sfTCPDF("P", "mm", "Letter");
        }
        $pdf->SetTitle($cheque . " " . $cheque->getBanco()->getNombre() . " " . $cheque->getNumero());
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins($documentoCheque->getMargenIzquierdo(), $documentoCheque->getMargenSuperior());
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('VeniaLink');
        $pdf->SetSubject('Cheque,formato');
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('dejavusans', '', 11);
        $html = $documentoCheque->getFormato();
        $numberToLetterConverter = new NumberToLetterConverter();
        $valor = $cheque->getValor();
        $valor = Parametro::formato($valor, false);
        $valor = str_replace(",", "", $valor);
        $totalImprime = str_replace(".", ",", $valor);

//        echo $totalImprime;
//        echo "<br><br>";
        $html = str_replace("%FECHA%", "Guatemala " . $cheque->getFechaCreo('d/m/Y'), $html);
        $html = str_replace("%CORRELATIVO%", $cheque->getNumero(), $html);
        $html = str_replace("%BENEFICIARIO%", $cheque->getBeneficiario(), $html);
        $html = str_replace("%VALOR%", Parametro::formato($cheque->getValor()), $html);

        $html = str_replace("%VALOR_LETRAS%", $numberToLetterConverter->to_word($totalImprime, $miMoneda = null), $html);
        $html = str_replace("%MOTIVO%", "<font size='-2'>" . strtoupper($cheque->getMotivo()) . "<font>", $html);
        if ($cheque->getNegociable()) {
            $html = str_replace("%NEGOCIABLE%", "<font size='-2'></font> ", $html);
        } else {
            $html = str_replace("%NEGOCIABLE%", "<font size='-2'>No Negociable</font> ", $html);
        }
        $html = $this->getPartial('reporte/cheque', array());
        echo $html;
//        die();
//
//
//        $x = 100; // $documentoCheque->getAlto();
//        $y = 500; // $documentoCheque->getAncho();
        //  $pdf->AddPage('P', $page_format, false, false);
        $img_file = "images/anulado.png";

        $pdf->AddPage();
//        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->writeHTML($html);
        if (strtoupper($cheque->getEstatus()) == 'ANULADO') {

            $pdf->Image($img_file, 15, 55, 25, '', '', '', '100', false, 0);
            $pdf->Image($img_file, 50, 55, 25, '', '', '', '100', false, 0);
            $pdf->Image($img_file, 100, 55, 25, '', '', '', '100', false, 0);
            $pdf->Image($img_file, 150, 55, 25, '', '', '', '100', false, 0);
        }
        $pdf->Output('Documento.' . $documentoCheque->getId() . '.pdf', 'I');
    }

    public function executeCheque(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $this->cheque = ChequeQuery::create()->findOneById($id);
        $this->gastos = GastoPagoQuery::create()
                ->filterByChequeId($id)
                ->find();
        $this->devolucion = OrdenDevolucionQuery::create()
                ->filterByChequeNo($id)
                ->findOne();

        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);

        $this->partidaPen = PartidaQuery::create()
                ->filterByUsuario($usuarioQ->getUsuario())
                ->filterByConfirmada(0)
                ->filterByTipo('%cheque%', Criteria::LIKE)
                ->findOne();

        $this->solcheque = SolicitudChequeQuery::create()
                ->filterByChequeNo($id)
                ->findOne();
    }

    public function executeCorrelativo(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $retonra = '';

        $formatocheque = DocumentoChequeQuery::create()->findOneById($id);
        if ($formatocheque) {
            $retonra = $formatocheque->getCorrelativo();
        }
        echo $retonra;
        die();
    }

    public function executeCorrelativoBan(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $retonra = '';

        $formatocheque = DocumentoChequeQuery::create()
                ->filterByBancoId($id)
                ->find();
        if (count($formatocheque) == 1) {
            $retonra = $formatocheque[0]->getCorrelativo();
        }
        echo $retonra;
        die();
    }

}
