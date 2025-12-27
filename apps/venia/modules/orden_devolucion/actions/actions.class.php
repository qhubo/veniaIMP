<?php

/**
 * orden_devolucion actions.
 *
 * @package    plan
 * @subpackage orden_devolucion
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class orden_devolucionActions extends sfActions {

   
    public function executeVista(sfWebRequest $request) {
        $acceso = MenuSeguridad::Acceso('orden_devolucion');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }

        $id = $request->getParameter('id');
        $this->orden = OrdenDevolucionQuery::create()->findOneById($id);
    }

    public function executeElimina(sfWebRequest $request) {
        $acceso = MenuSeguridad::Acceso('orden_devolucion');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        $id = $request->getParameter('id');
        $nocheque = '';
        $ordenDevolucion = OrdenDevolucionQuery::create()->findOneById($id);

        $cheque = ChequeQuery::create()->findOneByOrdenDevolucionId($id);
        if ($cheque) {
            $movimientoBanco = MovimientoBancoQuery::create()
                    ->filterByDocumento($cheque->getNumero())
                    ->filterByBancoId($cheque->getBancoId())
                    ->findOne();
            if ($movimientoBanco) {
                $movimientoBanco->delete();
            }
            $nocheque = $cheque->getNumero();
            $cheque->setEstatus("ANULADO");
            $cheque->save();
        }

        $partidaId = $ordenDevolucion->getPartidaNo();
        $partidaQ = PartidaDetalleQuery::create()
                ->filterByPartidaId($partidaId)
                ->find();
        if ($partidaQ) {
            $partidaQ->delete();
        }
        $partidaQ = PartidaQuery::create()->findOneById($partidaId);
        if ($partidaQ) {
            $partidaQ->delete();
        }

        $ordenDevolucion->setEstatus("ANULADO");
        $ordenDevolucion->save();

        $solicitudDe = SolicitudDevolucionQuery::create()->findOneById($ordenDevolucion->getSolicitudDevolucionId());
        if ($solicitudDe) {
            $solicitudDe->setEstatus("ANULADO");
            $solicitudDe->save();
        }
        $this->getUser()->setFlash('exito', 'Devolucion anualada  # ' . $ordenDevolucion->getCodigo() . " Cheque no " . $nocheque);

        BitacoraDocumento::grabacion("Devolucion", $ordenDevolucion->getCodigo(), 'Anulado', 'Devolucion anualada  # ' . $ordenDevolucion->getCodigo() . " Cheque no " . $nocheque);
        $this->redirect('orden_devolucion/index?id=');
    }

    public function executePartida(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $this->partida = PartidaQuery::create()->findOneById($id);
    }

    public function partidaPago($devolucion) {
        $tienda = '';
        $tiendaID = sfContext::getInstance()->getUser()->getAttribute("tienda", null, 'seguridad');
        $tiendaQ = TiendaQuery::create()->findOneById($tiendaID);
        if ($tiendaQ) {
            $tienda = $tiendaQ->getNombre();
        }
        $partidaId = Partida::Crea('Orden Devolución', $devolucion->getId(), $devolucion->getValor());
        $devolucion->setPartidaNo($partidaId);
        $valorDevolucion = $devolucion->getValor();
        $valorOtros = 0;

        if ($devolucion->getPorcentajeRetenie()) {
            $por = $devolucion->getPorcentajeRetenie();

            $valorDevolucion = round(($devolucion->getValor() * (100 - $por)) / 100, 2);
            $valorOtros = round(($devolucion->getValor() * $por) / 100, 2);
        }

        $devolucion->setValorOtros($valorOtros);
        $devolucion->save();
        $cuentaPartida = Partida::busca("DEVS" . $devolucion->getPagoMedio(), 1, 2);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        //   $nombreCuenta = Partida::cuenta($cuentaContable);
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setHaber($valorDevolucion);
        $partidaLinea->setDebe(0);
        $partidaLinea->setTipo(1);
        $partidaLinea->setGrupo("DEVS" . $devolucion->getPagoMedio());
        $partidaLinea->save();

        $valoresIva = ParametroQuery::ObtenerIva($devolucion->getValor(), false, false);
        $VALORSINIVA = $valoresIva['VALOR_SIN_IVA'];
        $IVA = $valoresIva['IVA'];
        $cuentaPartida = Partida::busca("%DEVOLUCION%USA%", 0, 1, '', $tienda);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe($VALORSINIVA);
        $partidaLinea->setHaber(0);
        $partidaLinea->setTipo(0);
        $partidaLinea->setGrupo('DEVOLUCION USA');
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();

        $cuentaPartida = Partida::busca("IVA%PAGAR%", 0, 1);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $cuentaContable = ' 2035-08';
        $nombreCuenta = 'IVA POR PAGAR';
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setHaber(0);
        $partidaLinea->setDebe($IVA);
        $partidaLinea->setGrupo("IVA POR PAGAR");
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();

        if ($valorOtros > 0) {
            $cuentaPartida = Partida::busca("OTROS%INGRESOS", 1, 2);
            $cuentaContable = $cuentaPartida['cuenta'];
            $nombreCuenta = $cuentaPartida['nombre'];
            //   $nombreCuenta = Partida::cuenta($cuentaContable);
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaId);
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setHaber($valorOtros);
            $partidaLinea->setDebe(0);
            $partidaLinea->setTipo(1);
            $partidaLinea->setGrupo('OTROS INGRESOS');
            $partidaLinea->save();
        }
    }

    public function executeIndex(sfWebRequest $request) {

        $solicutDevolu = SolicitudDevolucionQuery::create()
                ->orderById("Desc")
                ->setLimit(25)
                ->find();
        foreach ($solicutDevolu as $regi) {
            $ordenDevolucio = OrdenDevolucionQuery::create()->findOneBySolicitudDevolucionId($regi->getId());
            if ($ordenDevolucio) {
                $ordenDevolucio->setDetalleMotivo($regi->getMotivos());
                $ordenDevolucio->save();
            }
        }


        $acceso = MenuSeguridad::Acceso('orden_devolucion');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datonsuFE', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $fecha_actual = date("d-m-Y");
            $fecha = date("d/m/Y", strtotime($fecha_actual . "- 3 days"));
            $valores['fechaInicio'] = $fecha;
            $valores['fechaFin'] = date('d/m/Y');
            $valores['usuario'] = trim($usuarioQue->getUsuario());
            $valores['estatus_devolucion'] = null;
            $valores['motivo'] = null;
            $valores['tipo_repuesto'] = null;
            sfContext::getInstance()->getUser()->setAttribute('datonsuFE', serialize($valores), 'consulta');
        }
//        echo "<pre>";
//        print_r($valores);
//        die();
        $this->form = new ConsultaFechaDevoluciForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datonsuFE', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datonsuFE', null, 'consulta'));
                $this->redirect('orden_devolucion/index?id=');
            }
        }

        $this->partidaPen = PartidaQuery::create()
                ->filterByConfirmada(0)
                ->filterByTipo('Orden Devolución')
                ->findOne();
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '00:00';
        $valores['fin'] = '23:00';
        $registros = OrdenDevolucionQuery::create();
        $registros->where("OrdenDevolucion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'");
        $registros->where("OrdenDevolucion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'");
        if ($valores['estatus_devolucion']) {
            $registros->filterByEstatus($valores['estatus_devolucion']);
        }
        if ($valores['usuario']) {
            $registros->filterByUsuarioCreo($valores['usuario']);
        }
        if ($valores['motivo']) {
            $registros->filterByDetalleMotivo('%' . $valores['motivo'] . "%");
        }
        if ($valores['tipo_repuesto']) {
            $registros->filterByDetalleRepuesto('%' . $valores['tipo_repuesto'] . "%");
        }

        $this->registros = $registros->find();

    }

    public function executeTipo(sfWebRequest $request) {
        $val = $request->getParameter('val');
        sfContext::getInstance()->getUser()->setAttribute('tipodevolu', $val, 'seguridad');
        echo $val;

        die();
    }

    public function executeMuestra(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioq = UsuarioQuery::create()->findOneById($usuarioId);
        $this->id = $id;
        $default = null;
        $default['medio'] = 'CHEQUE';
        $tip = sfContext::getInstance()->getUser()->getAttribute('tipodevolu', null, 'seguridad');
        if ($tip) {
            $default['tipo'] = $tip;
        }   
        $this->sol = 0;
        $ordenDevolucion = OrdenDevolucionQuery::create()
                ->filterById($id)
                //->filterByEstatus('Pendiente')
                ->findOne();
        if ($ordenDevolucion) {
            $default['tipo'] = 'Cliente';
            $default['nombre'] = $ordenDevolucion->getNombre();  // INTERNACIONAL
            $default['referencia_factura'] = $ordenDevolucion->getReferenciaFactura();  // 2339
            $default['valor'] = $ordenDevolucion->getValor();  // 500
            $default['medio'] = $ordenDevolucion->getPagoMedio();  // CHEQUE
            $default['vendedor'] = $ordenDevolucion->getVendedor();  // 3
            $default['concepto'] = "";  // asdasd
            $default['porcentaje_retenie'] = $ordenDevolucion->getPorcentajeRetenie();  //
            $default['referencia_nota'] = $ordenDevolucion->getReferenciaNota();  // 12312
            $default['no_hollander'] = $ordenDevolucion->getNoHollander();  //
            $default['no_stock'] = $ordenDevolucion->getNoStock();  //
            $default['descripcion'] = $ordenDevolucion->getDescripcion();  //
            $default['retencion'] = $ordenDevolucion->getRetencion();  //
            $this->sol = $ordenDevolucion->getSolicitudDevolucionId();
        }
        $this->detalle = SolicitudDevDetalleQuery::create()
                ->filterBySolicitudDevolucionId($this->sol)
                ->find();
        $this->form = new CreaDevolucionForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($valores);
//                die();
                

                $fechaInicio = $valores['fechaInicio'];

                $nuevo = $ordenDevolucion;
                if (!$ordenDevolucion) {
                    $nuevo = new OrdenDevolucion();
                }
                $nuevo->setTipo($valores['tipo']);
                $nuevo->setNombre($valores['nombre']); // => Edwin Eduardo Figueroa Alvarado
                if ($valores['tipo'] == "Proveedor") {
                    $nuevo->setProveedorId($valores['proveedor_id']);
                    $proveQ = ProveedorQuery::create()->findOneById($valores['proveedor_id']);
                    $nuevo->setNombre($proveQ->getNombre());
                }
                if ($valores['tipo'] == "Cliente") {
                    $nuevo->setProveedorId(null);
                }
                $nuevo->setFecha(date('Y-m-d H:i:s'));
                $nuevo->setReferenciaFactura($valores['referencia_factura']);  // => 5458488
                $nuevo->setValor($valores['valor']); // => 390
                $nuevo->setConcepto($valores['concepto']);  // => Devolucion en repuesto fact xela 102-1230
                $nuevo->setEstatus('Nuevo');
                $nuevo->setUsuarioCreo($usuarioq->getUsuario());
                $nuevo->setCreatedAt(date('Y-m-d H:i:s'));
                $nuevo->setPorcentajeRetenie($valores['porcentaje_retenie']);
                $nuevo->setPagoMedio($valores['medio']);
                $nuevo->setVendedor($valores['vendedor']);
                $nuevo->setReferenciaNota($valores['referencia_nota']);
                $nuevo->setNoHollander($valores['no_hollander']);  //
                $nuevo->setProductoId($valores['no_hollander']);
                $nuevo->setCantidad($valores['cantidad']);
                $nuevo->setNoStock($valores['no_stock']);  //
                $nuevo->setDescripcion($valores['descripcion']);  //
               // $nuevo->setFechaConfirmo(date('Y-m-d H:i:s'));
                $tiendaId = sfContext::getInstance()->getUser()->getAttribute("tienda", null, 'seguridad');
                $nuevo->setTiendaId($tiendaId);
                if ($fechaInicio) {
                    $fechaInicio = explode('/', $fechaInicio);
                    $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
                    $nuevo->setFechaFactura($fechaInicio);
                }

                $nuevo->save();
                if ($valores["archivo"]) {
                    $archivo = $valores["archivo"];
                    $nombre = $archivo->getOriginalName();
                    $nombre = str_replace(" ", "_", $nombre);
                    $nombre = str_replace(".", "", $nombre);
                    $filename = $nuevo->getCodigo() . "." . $archivo->getExtension($archivo->getOriginalExtension());
                    $archivo->save(sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . 'devoluciones' . DIRECTORY_SEPARATOR . $filename);
                    $nuevo->setArchivo($filename);
                    $nuevo->save();
                }

                if ($valores["archivo2"]) {
                    $archivo = $valores["archivo2"];
                    $nombre = $archivo->getOriginalName();
                    $nombre = str_replace(" ", "_", $nombre);
                    $nombre = str_replace(".", "", $nombre);
                    $filename = $nuevo->getCodigo() . "_2." . $archivo->getExtension($archivo->getOriginalExtension());
                    $archivo->save(sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . 'devoluciones' . DIRECTORY_SEPARATOR . $filename);
                    $nuevo->setArchivo2($filename);
                    $nuevo->save();
                }
                $nuevo->setRetencion($valores['retencion']);
                $nuevo->save();
                $nuevo->setToken(sha1($nuevo->getCodigo()));
                $nuevo->save();
             
                //* AQUI MOVIMIENTO_BANCO
                // $this->partidaPago($nuevo);
                $this->getUser()->setFlash('exito', 'Orden devolución  realizada con exito  # ' . $nuevo->getId());
                $this->redirect('orden_devolucion/index');
            }
        }
    }

    public function executeReporte(sfWebRequest $request) {
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datonsuFE', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = $EmpresaQuery->getNombre();
        $pestanas[] = 'Devoluciones';
        $pestanas[] = 'Detalle';
        $nombreEMpresa = $EmpresaQuery->getNombre();
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $filename = "Devoluciones_" . $nombreEMpresa . date("d_m_Y");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $hoja = $xl->setActiveSheetIndex(0);
        //CABECERA  Y FILTRO
        $hoja->getRowDimension('1')->setRowHeight(15);
        $hoja->getRowDimension('2')->setRowHeight(20);
        $textoBusqueda = $this->textobusqueda($valores);
        $hoja->mergeCells("A1:A2");
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit(strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(13);
        // $hoja->getStyle("B1")->applyFromArray($styleArray);
        $hoja->getCell("C1")->setValueExplicit("Reporte Devoluciones ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C1")->getFont()->setBold(true);
        $hoja->getStyle("C1")->getFont()->setSize(10);

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

        $encabezados[] = array("Nombre" => strtoupper("Código"), "width" => 15, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Fecha"), "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Nombre"), "width" => 40, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Ref Factura"), "width" => 24, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Ref Nota"), "width" => 24, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Concepto"), "width" => 24, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Pago"), "width" => 18, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Valor"), "width" => 15, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Estatus"), "width" => 15, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Usuario"), "width" => 18, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Garantia"), "width" => 15, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Autorizo"), "width" => 18, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Fecha Autorizo"), "width" => 22, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Vendedor"), "width" => 30, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Fecha Factura"), "width" => 22, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Motivo"), "width" => 25, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Tipo Repuesto"), "width" => 25, "align" => "rigth", "format" => "#,##0.00");

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '00:00';
        $valores['fin'] = '23:00';
        $registros = OrdenDevolucionQuery::create();
        $registros->where("OrdenDevolucion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'");
        $registros->where("OrdenDevolucion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'");
        if ($valores['usuario']) {
            $registros->filterByUsuarioCreo($valores['usuario']);
        }
        if ($valores['estatus_devolucion']) {
            $registros->filterByEstatus($valores['estatus_devolucion']);
        }
        if ($valores['motivo']) {
            $registros->filterByDetalleMotivo('%' . $valores['motivo'] . "%");
        }
        if ($valores['tipo_repuesto']) {
            $registros->filterByDetalleRepuesto('%' . $valores['tipo_repuesto'] . "%");
        }

        $listado = $registros->find();

        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        //  $hoja->getStyle("A" . $fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($color);
        $TOTAL = 0;
        foreach ($listado as $data) {
            $fila++;
            $datos = null;
            $TOTAL = $TOTAL + $data->getValor();
            $datos[] = array("tipo" => 3, "valor" => $data->getCodigo());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $data->getFecha('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $data->getNombre());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $data->getReferenciaFactura());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $data->getReferenciaNota());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $data->getConcepto());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $data->getPagoMedio());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $data->getValor());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $data->getEstatus());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $data->getUsuarioCreo());  // ENTERO


            if ($data->getSolicitudDevolucionId()) {
                $datos[] = array("tipo" => 3, "valor" => $data->getSolicitudDevolucion()->getCodigo());  // ENTERO
            } else {
                $datos[] = array("tipo" => 3, "valor" => "");  // ENTERO
            }
            $datos[] = array("tipo" => 3, "valor" => $data->getUsuarioConfirmo());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $data->getFechaConfirmo('d/m/Y'));  // ENTERO

            $hoja->getStyle('E' . $fila)->getAlignment()->setWrapText(true);
            $datos[] = array("tipo" => 3, "valor" => $data->getVendedor());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $data->getFechaFactura('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $data->getDetalleMotivo());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $data->getDetalleRepuesto());  // ENTERO
            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;
        $hoja->getCell("E" . $fila)->setValueExplicit("TOTALES ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("E" . $fila)->getFont()->setBold(true);
        $hoja->getStyle("E" . $fila)->getFont()->setSize(12);
        //$hoja->mergeCells("F" . $fila . ":G" . $fila);
        $hoja->getCell("H" . $fila)->setValueExplicit(round($TOTAL, 2), PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $hoja->getStyle("H" . $fila)->getFont()->setBold(true);
        $hoja->getStyle("H" . $fila)->getFont()->setSize(12);
        $fila++;
        $LetraFin = UsuarioQuery::numeroletra(7);
        $hoja->getCell("A" . $fila)->setValueExplicit("ULTIMA LINEA", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B" . $fila . ":" . $LetraFin . $fila);

        $hoja = $xl->setActiveSheetIndex(1);
        //CABECERA  Y FILTRO
        $hoja->getRowDimension('1')->setRowHeight(15);
        $hoja->getRowDimension('2')->setRowHeight(20);
        $textoBusqueda = $this->textobusqueda($valores);
        $hoja->mergeCells("A1:A2");
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit(strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(13);
        // $hoja->getStyle("B1")->applyFromArray($styleArray);
        $hoja->getCell("C1")->setValueExplicit("Detalle Devoluciones ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C1")->getFont()->setBold(true);
        $hoja->getStyle("C1")->getFont()->setSize(10);

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
        $encabezados[] = array("Nombre" => strtoupper("Fecha"), "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Devolucion"), "width" => 18, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Garantia"), "width" => 18, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Vendedor"), "width" => 30, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Hollander"), "width" => 20, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Stock"), "width" => 20, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Descripcion"), "width" => 30, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Motivo"), "width" => 40, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Estatus"), "width" => 18, "align" => "rigth", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $estatus[] = 'Entregado';
        $estatus[] = "Autorizado";

        if (!$valores['usuario']) {
            $devoluciones = SolicitudDevDetalleQuery::create()
                    ->filterByTipo(1)
                    ->useSolicitudDevolucionQuery()
                    ->useOrdenDevolucionQuery()
                    ->where("OrdenDevolucion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("OrdenDevolucion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->filterByEstatus($estatus, Criteria::IN)
                    ->endUse()
                    ->endUse()
                    ->where("SolicitudDevolucion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("SolicitudDevolucion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->find();
        }
        if ($valores['usuario']) {
            $devoluciones = SolicitudDevDetalleQuery::create()
                    ->filterByTipo(1)
                    ->useSolicitudDevolucionQuery()
                    ->useOrdenDevolucionQuery()
                    ->filterByUsuarioCreo($valores['usuario'])
                    ->where("OrdenDevolucion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("OrdenDevolucion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->filterByEstatus($estatus, Criteria::IN)
                    ->endUse()
                    ->endUse()
                    ->where("SolicitudDevolucion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("SolicitudDevolucion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->find();
        }
        foreach ($devoluciones as $devolucion) {
            $fila++;
            $datos = null;
            $ordeDev = OrdenDevolucionQuery::create()->findOneBySolicitudDevolucionId($devolucion->getSolicitudDevolucionId());
            if ($ordeDev) {
                $datos[] = array("tipo" => 3, "valor" => $devolucion->getSolicitudDevolucion()->getFecha('d/m/Y'));  // ENTERO
                $datos[] = array("tipo" => 3, "valor" => $ordeDev->getCodigo());  // ENTERO
                $datos[] = array("tipo" => 3, "valor" => $devolucion->getSolicitudDevolucion()->getCodigo());  // ENTERO
                $datos[] = array("tipo" => 3, "valor" => $ordeDev->getVendedor());  // ENTERO
                $datos[] = array("tipo" => 3, "valor" => $devolucion->getHollander());  // ENTERO
                $datos[] = array("tipo" => 3, "valor" => $devolucion->getStock());  // ENTERO
                $datos[] = array("tipo" => 3, "valor" => $devolucion->getDescripcion());  // ENTERO
                $datos[] = array("tipo" => 3, "valor" => $devolucion->getSolicitudDevolucion()->getDescripcion());  // ENTERO
                $datos[] = array("tipo" => 3, "valor" => $ordeDev->getEstatus());  // ENTERO

                $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
            }
        }
        $fila++;

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
                if ($clave == 'USUARIO') {
                    $query = UsuarioQuery::create()->findOneById($valor);
                    if ($query) {
                        $valor = $query->getUsuario();
                    }
                    $Busqueda[] = ' USUARIO: ' . $valor;
                }
            }
        }
        if ($Busqueda) {
            $textoBusqueda = implode(",", $Busqueda);
        }
        return $textoBusqueda;
    }

}
