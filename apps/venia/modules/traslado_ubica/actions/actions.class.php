<?php

class traslado_ubicaActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $acceso = MenuSeguridad::Acceso('traslado_ubica');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioq = UsuarioQuery::create()->findOneById($usuarioId);
        $trasladoBu = TrasladoUbicacionQuery::create()
                ->filterByEstado('Proceso')
                ->filterByUsuario($usuarioq->getUsuario())
                ->findOne();
        $default = null;
        $tiendaAnteior = null;
        $idTra = null;
        if ($trasladoBu) {
            $idTra = $trasladoBu->getId();
            $default['observaciones'] = $trasladoBu->getObservaciones();
            $default['tienda_id'] = $trasladoBu->getTiendaId();
            $tiendaAnteior = $trasladoBu->getTiendaId();
        }
        $this->form = new TrasladoUbicacionForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                if (!$trasladoBu) {
                    $trasladoBu = new TrasladoUbicacion();
                    $trasladoBu->setEstado('Proceso');
                    $trasladoBu->setUsuario($usuarioq->getUsuario());
                    $trasladoBu->save();
                }
                $trasladoBu->setFecha(date('Y-m-d H:i'));
                $trasladoBu->setObservaciones($valores['observaciones']);
                $trasladoBu->setTiendaId($valores['tienda_id']);
                $trasladoBu->save();
                if ($trasladoBu <> $valores['tienda_id']) {
                    $traDetalle = TrasladoUbicacionDetalleQuery::create()
                            ->filterByTrasladoUbicacionId($trasladoBu->getId())
                            ->findOne();
                    if ($traDetalle) {
                        $traDetalle->delete();
                    }
                }
                $this->getUser()->setFlash('exito', ' Informacion actualizada ');
                $this->redirect('traslado_ubica/index');
            }
        }
        $this->trasladoBu = $trasladoBu;
        $this->bodegas = TiendaQuery::create()->orderByNombre()->find();
        $this->listado = TrasladoUbicacionDetalleQuery::create()->filterByTrasladoUbicacionId($idTra)->find();
    }

    public function executeProducto(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('movi');
        $trasladoProducto = TrasladoUbicacionQuery::create()->findOneById($id);
        $tiendaId = $trasladoProducto->getTiendaId();
        $productoid = $request->getParameter('id');
        $producto = ProductoExistenciaQuery::create()->filterByProductoId($productoid)->filterByTiendaId($tiendaId)->findOne();
        if (!$producto) {
            $this->getUser()->setFlash('error', 'No existe existencia de ese producto');
            $this->redirect('traslado_ubica/index?movi=' . $id);
        }
        if ($producto) {
            if ($producto->getCantidad() <= 0) {
                $this->getUser()->setFlash('error', 'No existe existencia de ese producto');
                $this->redirect('traslado_ubica/index?movi=' . $id);
            }
        }
        if ($producto) {
//            $ubicaciones = ProductoUbicacionQuery::create()
//                    ->filterByProductoId($productoid)
//                    ->filterByTiendaId($tiendaId)
//                    ->find();
//            foreach ($ubicaciones as $registro) {
            $ordenQ = new TrasladoUbicacionDetalle();
            $ordenQ->setCantidad($producto->getCantidad());
            $ordenQ->setProductoId($productoid);
            $ordenQ->setTrasladoUbicacionId($id);
            $ordenQ->setUbicacionOriginal('');
            $ordenQ->save();
            //  }
            $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
        }
        $this->redirect('traslado_ubica/index?movi=' . $id);
    }

    public function executeCantidad(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $valor = $request->getParameter('valor');
        $ordenDetalle = TrasladoUbicacionDetalleQuery::create()
                ->filterById($id)
                ->findOne();
        $ordenDetalle->setCantidad($valor);
        $ordenDetalle->save();
        die();
    }

    public function executeHistorial(sfWebRequest $request) {

        date_default_timezone_set("America/Guatemala");
//        $acceso = MenuSeguridad::Acceso('nota_credito');
//        if (!$acceso) {
//            $this->redirect('inicio/index');
//        }
        date_default_timezone_set("America/Guatemala");

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBanco', null, 'consulta'));
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('datoconsultaBanco', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaReporteCajaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsultaBanco', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBanco', null, 'consulta'));
                $this->redirect('traslado_ubica/historial');
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
        $this->operaciones = TrasladoUbicacionQuery::create()
                ->orderByFecha()
                ->where("TrasladoUbicacion.Fecha  >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("TrasladoUbicacion.Fecha  <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->find();
    }

    public function executeReportePdf(sfWebRequest $request) {
        error_reporting(-1);
        $this->id = $request->getParameter("id");
        $pedidoVendedor = TrasladoUbicacionQuery::create()->findOneById($this->id);
        $logo = $pedidoVendedor->getEmpresa()->getLogo();
        $logo = 'uploads/images/' . $logo;
        $NOMBRE_EMPRESA = $pedidoVendedor->getEmpresa()->getNombre();
        $DIRECCION = $pedidoVendedor->getEmpresa()->getDireccion();
        $TELEFONO = $pedidoVendedor->getEmpresa()->getTelefono();
        $detalle = TrasladoUbicacionDetalleQuery::create()->filterByTrasladoUbicacionId($this->id)->find();
        $html = $this->getPartial('traslado_ubica/reporte', array(
            "logo" => $logo, 'NOMBRE_EMPRESA' => $NOMBRE_EMPRESA,
            'DIRECCION' => $DIRECCION, 'TELEFONO' => $TELEFONO,
            "operacion" => $pedidoVendedor, 'detalle' => $detalle,
        ));
        $pdf = new sfTCPDF("P", "mm", "Letter");
//echo $html;
//die();

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle('Traslado  Ubicacion Producto ' . $pedidoVendedor->getCodigo());
        $pdf->SetSubject('Recibo');
        $pdf->SetKeywords('Recibo recibo'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetMargins(3, 5, 0, true);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetHeaderMargin(0.1);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont('dejavusans', '', 9);
        $pdf->AddPage();
        $pdf->Image($logo, 1, 8, 35, '', '', '', '100', false, 0);
        $pdf->writeHTML($html);



        $pdf->Output('Traslado  Ubicacion Producto' . $pedidoVendedor->getCodigo() . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeTienda(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $valor = $request->getParameter('valor');
        $ordenDetalle = TrasladoUbicacionDetalleQuery::create()
                ->filterById($id)
                ->findOne();
        $ordenDetalle->setTiendaId($valor);
        $ordenDetalle->save();
        die();
    }

    public function executeConfirma(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('mov');
        $trasladoBu = TrasladoUbicacionQuery::create()->findOneById($id);
        $ordenDetalle = TrasladoUbicacionDetalleQuery::create()
                ->filterByTrasladoUbicacionId($id)
                ->find();
        $linea = 0;
        foreach ($ordenDetalle as $detalle) {
            $linea++;
            $Cantidad = $request->getParameter('numero' . $detalle->getId());
            $tiendaId = $request->getParameter('tienda' . $detalle->getId());
            $ubicacion = $request->getParameter('ubicacion' . $detalle->getId());
            if ($Cantidad <= 0) {
                $this->getUser()->setFlash('error', 'Debe ingresar cantidad Linea #' . $linea);
                $this->redirect('traslado_ubica/index?movi=' . $id);
            }
            if ((!$tiendaId)) {
                $this->getUser()->setFlash('error', 'Debe seleccionar tienda/ubicacion Linea #' . $linea);
                $this->redirect('traslado_ubica/index?movi=' . $id);
            }
        }

        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            foreach ($ordenDetalle as $registro) {
                $productoId = $registro->getProductoId();
                $cantidad = $registro->getCantidad();
                $empresaId = $trasladoBu->getEmpresaId();
                // ============================
                // ======= SALIDA ============
                // ============================
                $tiendaOrigen = $registro->getTrasladoUbicacion()->getTiendaId();
                $productoExistencia = ProductoExistenciaQuery::create()
                        ->filterByTiendaId($tiendaOrigen)
                        ->filterByProductoId($productoId)
                        ->findOne();
                $inicial = $productoExistencia->getCantidad();
                if ($inicial < $cantidad) {
                       $this->getUser()->setFlash('exito', "Stock insuficiente para el producto ID: " . $productoId);
                        $this->redirect('traslado_ubica/index?movi=' . $id);
                }
                $nuevoValor = $inicial - $cantidad;
               // Movimiento Kardex Salida
                $movimiento = new ProductoMovimiento();
                $movimiento->setTiendaId($tiendaOrigen);
                $movimiento->setProductoId($productoId);
                $movimiento->setCantidad($cantidad);
                $movimiento->setIdentificador("TRASLADO " . $id);
                $movimiento->setTipo('TRASLADO SALIDA');
                $movimiento->setFecha(date('Y-m-d H:i:s'));
                $movimiento->setMotivo(substr($trasladoBu->getObservaciones(), 0, 90));
                $movimiento->setInicio($inicial);
                $movimiento->setEmpresaId($empresaId);
                $movimiento->setFin($nuevoValor);
                $movimiento->setLineaNo("TRASA" . $registro->getId());
                $movimiento->save();
                $productoExistencia->setCantidad($nuevoValor);
                $productoExistencia->save();

                // ============================
                // ======= INGRESO ===========
                // ============================
                $tiendaDestino = $registro->getTiendaId();
                $productoExistenciaDestino = ProductoExistenciaQuery::create()
                        ->filterByTiendaId($tiendaDestino)
                        ->filterByProductoId($productoId)
                        ->findOne();
                if (!$productoExistenciaDestino) {
                    $productoExistenciaDestino = new ProductoExistencia();
                    $productoExistenciaDestino->setCantidad(0);
                    $productoExistenciaDestino->setTiendaId($tiendaDestino);
                    $productoExistenciaDestino->setProductoId($productoId);
                    $productoExistenciaDestino->save();
                }
                $inicialDestino = $productoExistenciaDestino->getCantidad();
                $nuevoValorDestino = $inicialDestino + $cantidad;
                // Movimiento Kardex Ingreso
                $movimiento = new ProductoMovimiento();
                $movimiento->setTiendaId($tiendaDestino);
                $movimiento->setProductoId($productoId);
                $movimiento->setCantidad($cantidad);
                $movimiento->setIdentificador("TRASLADO " . $id);
                $movimiento->setTipo('TRASLADO INGRESO');
                $movimiento->setFecha(date('Y-m-d H:i:s'));
                $movimiento->setMotivo(substr($trasladoBu->getObservaciones(), 0, 90));
                $movimiento->setInicio($inicialDestino);
                $movimiento->setEmpresaId($empresaId);
                $movimiento->setFin($nuevoValorDestino);
                $movimiento->setLineaNo("TRAIN" . $registro->getId());
                $movimiento->save();
                $productoExistenciaDestino->setCantidad($nuevoValorDestino);
                $productoExistenciaDestino->save();
            }
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            $this->getUser()->setFlash('error', $e->getMessage());
            return $this->redirect('traslado_ubica/index');
        }
// Confirmar traslado
        $trasladoBu->setEstado('Confirmada');
        $trasladoBu->save();
        $this->getUser()->setFlash('exito', 'Traslado realizado con éxito');
        $this->redirect('traslado_ubica/index?movi=' . $id);
        die();
    }

    public function executeEliminaLinea(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $ordenDetalle = TrasladoUbicacionDetalleQuery::create()
                ->filterById($id)
                ->findOne();
        $vendedorIr = $ordenDetalle->getTrasladoUbicacionId();
        $ordenDetalle->delete();
        $this->getUser()->setFlash('error', 'Registro eliminado  con exito ');
        $this->redirect('traslado_ubica/index?movi=' . $vendedorIr);
    }

}
