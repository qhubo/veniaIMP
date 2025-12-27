<?php

class producto_vendedorActions extends sfActions {

    public function executeConfirmarpedi(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $ordenQ = OrdenVendedorQuery::create()->findOneById($id);
        $empresaId = $ordenQ->getId();
        $productos = VendedorProductoQuery::create()
                ->filterByOrdenVendedorId($id)
                ->find();
  
        
        
        
        foreach ($productos as $detalle) {
            if ($detalle->getProductoId()) {
                $existencia = $detalle->getProducto()->getExistencia();
                $cantidaSOlicita = $detalle->getCantidad();
                if ($cantidaSOlicita > $existencia) {
                    $this->getUser()->setFlash('error', 'No hay existencia de ' . $cantidaSOlicita . ' para el producto seleccionado ' . $detalle->getDetalle());
                    $this->redirect('producto_vendedor/index?id=');
                }

                if ($existencia <= 0) {
                    $this->getUser()->setFlash('error', 'No hay existencia para el producto seleccionado ' . $detalle->getDetalle());
                    $this->redirect('producto_vendedor/index?id=');
                }
            }
        }
        sfContext::getInstance()->getUser()->setAttribute('CotizacionId', null, 'seguridad');
        if ($ordenQ) {
      
            $PROCESADO = false;
            $ubicacionesPro = OrdenUbicacionQuery::create()
                    ->filterByProductoId(null, Criteria::NOT_EQUAL)
                    ->filterByProcesado(false)
                    ->filterByOrdenVendedorId($ordenQ->getId())
                    ->find();
//          echo "<pre>";
//        print_r($ubicacionesPro);
//        die();
            
            foreach ($ubicacionesPro as $lista) {
                $productoQuery = ProductoQuery::create()->findOneById($lista->getProductoId());
                $clave = $lista->getProductoId();
                ProductoMovimientoQuery::TRANSITO($clave, $lista->getCantidad(), 'VENTA', $lista->getTiendaUbica(), $ordenQ->getId() . "-" . $lista->getUbicacionId(), null, null);
                ProductoExistenciaQuery::Transito($clave, $lista->getCantidad(), $lista->getTiendaUbica());
                $ubicacActual = ProductoUbicacionQuery::create()
                        ->filterByUbicacion($lista->getUbicacionId())
                        ->filterByProductoId($lista->getProductoId())
                        ->filterByTiendaId($lista->getTiendaUbica())
                        ->findOne();
                if ($ubicacActual) {
                    $PROCESADO = true;
                    $existeActual = $ubicacActual->getTransito();
                    $nuevaCantidad = $existeActual + $lista->getCantidad();
                    $ubicacActual->setTransito($nuevaCantidad);
                    $ubicacActual->save();
                }
                $lista->setProcesado(true);
                $lista->save();
            }
            $ordenQ->setEstado("Finalizada");
            $ordenQ->save();
            $this->getUser()->setFlash('exito', 'Registro actualizado   con exito  ');
            $this->redirect('producto_vendedor/index?id=' . $id);
        }
        $this->redirect('producto_vendedor/index');
    }

    public function executeReporte(sfWebRequest $request) {
        error_reporting(-1);
        $this->id = $request->getParameter("id");
        $this->id = str_replace("PE", "", $this->id);
        $pedidoVendedor = OrdenVendedorQuery::create()->findOneById($this->id);
        $logo = $pedidoVendedor->getEmpresa()->getLogo();
        $logo = 'uploads/images/' . $logo;
        $NOMBRE_EMPRESA = $pedidoVendedor->getEmpresa()->getNombre();
        $DIRECCION = $pedidoVendedor->getEmpresa()->getDireccion();
        $TELEFONO = $pedidoVendedor->getEmpresa()->getTelefono();
        $detalle = VendedorProductoQuery::create()->filterByOrdenVendedorId($this->id)->find();
        $html = $this->getPartial('producto_vendedor/reporte', array(
            "logo" => $logo, 'NOMBRE_EMPRESA' => $NOMBRE_EMPRESA,
            'DIRECCION' => $DIRECCION, 'TELEFONO' => $TELEFONO,
            "operacion" => $pedidoVendedor, 'detalle' => $detalle,
        ));
        $pdf = new sfTCPDF("P", "mm", "Letter");

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle('Pedido Vendedor ' . $pedidoVendedor->getId());
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
        $pdf->Image($logo, 5, 10, 35, '', '', '', '100', false, 0);
        $pdf->writeHTML($html);



        $pdf->Output('Pedido Vendedor ' . $pedidoVendedor->getId() . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeHistorial(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaGasto', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('datoconsultaGasto', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsultaGasto', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaGasto', null, 'consulta'));
                $this->redirect('producto_vendedor/historial?id=1');
            }
        }
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '01:00';
        $valores['fin'] = '23:00';
        $this->registros = OrdenVendedorQuery::create()
                ->where("OrdenVendedor.Fecha >= '" . $fechaInicio . " 00:00:00" . "'")
                ->where("OrdenVendedor.Fecha <=  '" . $fechaFin . " 23:59:00" . "'")
                ->find();
    }

    public function executeConfirmar(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $ordenVe = OrdenVendedorQuery::create()->findOneById($id);
        $ordenVe->setFecha(date('Y-m-d H:i:s'));
        $ordenVe->setEstado("Confirmado");
        $ordenVe->save();
        $this->getUser()->setFlash('exito', 'Registro confirmado  con exito ');
        $this->redirect('producto_vendedor/index');
    }

    public function executeDetalleCabecera(sfWebRequest $request) {
        $detalle = $request->getParameter('id');
        $ListaId = $request->getParameter('idv');
        $listaProducto = OrdenVendedorQuery::create()
                ->filterById($ListaId)
                ->findOne();
        $listaProducto->setObservaciones($detalle);
        $listaProducto->save();
        die();
    }

    public function executeDetalle(sfWebRequest $request) {
        $detalle = $request->getParameter('id');
        $ListaId = $request->getParameter('idv');
        $listaProducto = VendedorProductoQuery::create()
                ->filterById($ListaId)
                ->findOne();
        $listaProducto->setObservaciones($detalle);
        $listaProducto->save();
        die();
    }

    public function executeCantidad(sfWebRequest $request) {
        $cantidad = $request->getParameter('id');
        $ListaId = $request->getParameter('idv');
        $listaProducto = VendedorProductoQuery::create()
                ->filterById($ListaId)
                ->findOne();
        $valor = $listaProducto->getValorUnitario();
        $retorna = $cantidad * $valor;
        $listaProducto->setCantidad($cantidad);
        // $listaProducto->setValorTotal($retorna);
        $listaProducto->save();
        $suma = $retorna;
        $valorSInIVa = 0;
        $iva = 0;
        $retorna = "<strong>" . number_format($retorna, 2) . "</strong>";
        $retorna .= '|' . number_format($suma, 2) . "|" . number_format($iva, 2) . "|" . number_format($valorSInIVa, 2);
        echo $retorna;
        die();
    }

    public function executeEliminaLinea(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $ordenDetalle = VendedorProductoQuery::create()
                ->filterById($id)
                ->findOne();
        $vendedorIr = $ordenDetalle->getVendedorId();
        $ordenDetalle->delete();
        $this->getUser()->setFlash('error', 'Registro eliminado  con exito ');
        $this->redirect('producto_vendedor/index?movi=' . $vendedorIr);
    }

    public function executeIndex(sfWebRequest $request) {
        $this->movi = $request->getParameter('movi');
        $this->registros = VendedorQuery::create()->filterByActivo(true)->find();

        $this->orden = null;
        $ordenID = null;
        $vendedor = VendedorQuery::create()->findOneById($this->movi);
        if ($vendedor) {
            $ordenVe = OrdenVendedorQuery::create()
                    ->filterByVendedorId($vendedor->getId())
                    ->filterByEstado('Proceso')
                    ->findOne();
            if (!$ordenVe) {
                $ordenVe = new OrdenVendedor();
                $ordenVe->setVendedorId($vendedor->getId());
                $ordenVe->setEstado('Proceso');
                $ordenVe->save();
            }
            $this->orden = $ordenVe;
            $ordenID = $ordenVe->getId();
        }

        $this->confirmados = OrdenVendedorQuery::create()->filterByEstado('Verificado')->find();
        $this->listado = VendedorProductoQuery::create()->filterByOrdenVendedorId($ordenID)->filterByVendedorId($this->movi)->find();
    }

    public function executeProducto(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('movi');
        $productoid = $request->getParameter('id');
        $producto = ProductoQuery::create()->findOneById($productoid);
        if ($producto->getExistencia() < 0) {
            $this->getUser()->setFlash('error', 'No existe existencia de ese producto');
            $this->redirect('producto_vendedor/index?movi=' . $id);
        }

        $ordenVe = OrdenVendedorQuery::create()
                ->filterByVendedorId($id)
                ->filterByEstado('Proceso')
                ->findOne();

        if ($producto) {
            $ordenQ = new VendedorProducto();
            $ordenQ->setCantidad(1);
            $ordenQ->setProductoId($producto->getId());
            $ordenQ->setOrdenVendedorId($ordenVe->getId());
            //  $ordenQ->setObservaciones($producto->getNombre());
            //  $ordenQ->setCodigo($producto->getCodigoSku());
            $ordenQ->setCantidad(1);
            $ordenQ->setValorUnitario($producto->getPrecio());
            $ordenQ->setVendedorId($id);
            $ordenQ->save();
            $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
        }
        $this->redirect('producto_vendedor/index?movi=' . $id);
    }

}
