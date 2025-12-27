<?php

/**
 * traslado_ubica actions.
 *
 * @package    plan
 * @subpackage traslado_ubica
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class traslado_ubicaActions extends sfActions {

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

    public function executeUbicacion(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $valor = $request->getParameter('valor');
        $ordenDetalle = TrasladoUbicacionDetalleQuery::create()
                ->filterById($id)
                ->findOne();
        $ordenDetalle->setNuevaUbicacion($valor);
        $ordenDetalle->save();
        die();
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
            if ((!$tiendaId) or ($ubicacion == "")) {
                $this->getUser()->setFlash('error', 'Debe seleccionar tienda/ubicacion Linea #' . $linea);
                $this->redirect('traslado_ubica/index?movi=' . $id);
            }
        }
        foreach ($ordenDetalle as $detalle) {
            $linea++;
            $Cantidad = $request->getParameter('numero' . $detalle->getId());
            $tiendaId = $request->getParameter('tienda' . $detalle->getId());
            $ubicacion = $request->getParameter('ubicacion' . $detalle->getId());
            if ($Cantidad <= 0) {
                $this->getUser()->setFlash('error', 'Debe ingresar cantidad Linea #' . $linea);
                $this->redirect('traslado_ubica/index?movi=' . $id);
            }
            if ((!$tiendaId) or ($ubicacion == "")) {
                $this->getUser()->setFlash('error', 'Debe seleccionar tienda/ubicacion Linea #' . $linea);
                $this->redirect('traslado_ubica/index?movi=' . $id);
            }
        }
        foreach ($ordenDetalle as $registro) {
            $productoId = $registro->getProductoId();
            $cantida = $registro->getCantidad();
            $empresaId = $trasladoBu->getEmpresaId();
            $UbicacionOrginal = ProductoUbicacionQuery::create()
                    ->filterByUbicacion($registro->getUbicacionOriginal())
                    ->filterByTiendaId($registro->getTrasladoUbicacion()->getTiendaId())
                    ->filterByProductoId($registro->getProductoId())
                    ->findOne();
            $productoExistencia = ProductoExistenciaQuery::create()
                    ->filterByTiendaId($registro->getTrasladoUbicacion()->getTiendaId())
                    ->filterByProductoId($productoId)
                    ->findOne();
            $inicial = $productoExistencia->getCantidad();
            $nuevoValor = $inicial - $cantida;
            $UbicacionOrginal->setCantidad($nuevoValor);
            $UbicacionOrginal->save();
            $movimienoto = new ProductoMovimiento();
            $movimienoto->setTiendaId($registro->getTrasladoUbicacion()->getTiendaId());
            $movimienoto->setProductoId($productoId);
            $movimienoto->setCantidad($cantida);
            $movimienoto->setIdentificador("TRASLADO " . $id);
            $movimienoto->setTipo('TRASLADO SALIDA');
            $movimienoto->setFecha(date('Y-m-d H:i:s'));
            $movimienoto->setMotivo(substr($trasladoBu->getObservaciones(), 0, 90));
            $movimienoto->setInicio($inicial);
            $movimienoto->setEmpresaId($empresaId);
            $movimienoto->setFin($nuevoValor);
            $movimienoto->save();
            $UbicacionFinal = ProductoUbicacionQuery::create()
                    ->filterByUbicacion($registro->getNuevaUbicacion())
                    ->filterByTiendaId($registro->getTiendaId())
                    ->filterByProductoId($registro->getProductoId())
                    ->findOne();
            if (!$UbicacionFinal) {
                $UbicacionFinal = new ProductoUbicacion();
                $UbicacionFinal->setCantidad(0);
                $UbicacionFinal->setUbicacion($registro->getNuevaUbicacion());
                $UbicacionFinal->setTiendaId($registro->getTiendaId());
                $UbicacionFinal->setProductoId($registro->getProductoId());
                $UbicacionFinal->save();
            }
            $inicial = 0;
            $productoExistencia = ProductoExistenciaQuery::create()
                    ->filterByTiendaId($registro->getTiendaId())
                    ->filterByProductoId($productoId)
                    ->findOne();
            IF ($productoExistencia) {
                $inicial = $productoExistencia->getCantidad();
            }
            $nuevoValor = $inicial + $cantida;
            $UbicacionFinal->setCantidad($nuevoValor);
            $UbicacionFinal->save();
            $movimienoto = new ProductoMovimiento();
            $movimienoto->setTiendaId($registro->getTiendaId());
            $movimienoto->setProductoId($productoId);
            $movimienoto->setCantidad($cantida);
            $movimienoto->setIdentificador("TRASLADO " . $id);
            $movimienoto->setTipo('TRASLADO INGRESO');
            $movimienoto->setFecha(date('Y-m-d H:i:s'));
            $movimienoto->setMotivo(substr($trasladoBu->getObservaciones(), 0, 90));
            $movimienoto->setInicio($inicial);
            $movimienoto->setEmpresaId($empresaId);
            $movimienoto->setFin($nuevoValor);
            $movimienoto->save();
        }
        $trasladoBu->setEstado('Confirmada');
        $trasladoBu->save();
        $this->getUser()->setFlash('exito', ' Traslado Realizado con exito ');
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
            $ubicaciones = ProductoUbicacionQuery::create()
                    ->filterByProductoId($productoid)
                    ->filterByTiendaId($tiendaId)
                    ->find();
            foreach ($ubicaciones as $registro) {
                $ordenQ = new TrasladoUbicacionDetalle();
                $ordenQ->setCantidad($registro->getCantidad());
                $ordenQ->setProductoId($productoid);
                $ordenQ->setTrasladoUbicacionId($id);
                $ordenQ->setUbicacionOriginal($registro->getUbicacion());
                $ordenQ->save();
            }
            $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
        }
        $this->redirect('traslado_ubica/index?movi=' . $id);
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $acceso = MenuSeguridad::Acceso('actualiza_inventario');
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

}
