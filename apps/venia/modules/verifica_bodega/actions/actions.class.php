<?php

class verifica_bodegaActions extends sfActions {

    public function executeTcaja(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $val = $request->getParameter('val');
        $ordenCoti = OrdenCotizacionQuery::create()->findOneById($id);
        $ordenCoti->setCantidadTotalCaja($val);
        $ordenCoti->save();
        die();
    }

    public function executeTpeso(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $val = $request->getParameter('val');
        $ordenCoti = OrdenCotizacionQuery::create()->findOneById($id);
        $ordenCoti->setPesoTotal($val);
        $ordenCoti->save();
        die();
    }

    public function executeCaja(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $val = $request->getParameter('val');
        $ordenId = OrdenCotizacionDetalleQuery::create()->findOneById($id);
        $ordenId->setCantidadCaja($val);
        $ordenId->save();
        $ordenCoti = OrdenCotizacionQuery::create()->findOneById($ordenId->getOrdenCotizacionId());
        $movimiento = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($ordenId->getOrdenCotizacionId())
                ->withColumn('sum(OrdenCotizacionDetalle.CantidadCaja)', 'TotalTotal')
                ->findOne();
        echo $movimiento->getTotalTotal();
        $ordenCoti->setCantidadTotalCaja($movimiento->getTotalTotal());
        $ordenCoti->save();
        die();
    }

    public function executePeso(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $val = $request->getParameter('val');
        $ordenId = OrdenCotizacionDetalleQuery::create()->findOneById($id);
        $ordenId->setPeso($val);
        $ordenId->save();
        $ordenCoti = OrdenCotizacionQuery::create()->findOneById($ordenId->getOrdenCotizacionId());
        $movimiento = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($ordenId->getOrdenCotizacionId())
                ->withColumn('sum(OrdenCotizacionDetalle.Peso)', 'TotalTotal')
                ->findOne();
        echo $movimiento->getTotalTotal();
        $ordenCoti->setPesoTotal($movimiento->getTotalTotal());
        $ordenCoti->save();

        die();
        die();
    }

    public function executeConfirmaPediVendedor(sfWebRequest $request) {
        error_reporting(-1);
         $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $id = $request->getParameter('id');
        $id = str_replace("PE", "", $id);
        $ordeCoti = VendedorProductoQuery::create()
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->filterByOrdenVendedorId($id)
                ->find();
        $linea = 0;
        $descuenta = null;
        foreach ($ordeCoti as $reg) {
            $linea++;
            $CANTIDAD_TOTAL = $reg->getCantidad();
            $ubicaciones = ProductoUbicacionQuery::create()->filterByCantidad(0, criteria::GREATER_THAN)->filterByProductoId($reg->getProductoId())->find();
            $CANTIDAD_DESGLOZADA = 0;
            if (count($ubicaciones) == 0) {
                $CANTIDAD_TOTAL = $CANTIDAD_DESGLOZADA;
            }
            foreach ($ubicaciones as $rego) {
                $cantiUBI = $request->getParameter('ubica' . $rego->getId());
                $CANTIDAD_DESGLOZADA = $cantiUBI + $CANTIDAD_DESGLOZADA;
                if ($cantiUBI > 0) {
                    $producto['tienda_ubica'] = $rego->getTiendaId();
                    $producto['producto_id'] = $reg->getProductoId();
                    $producto['ubicaciones'] = $rego->getUbicacion();
                    $producto['tienda_id'] = $usuarioQ->getTiendaId();
                    $producto['cantidad'] = $cantiUBI;
                    $descuenta[] = $producto;
                }
            }
            if ($CANTIDAD_DESGLOZADA <> $CANTIDAD_TOTAL) {
                $this->getUser()->setFlash('error', 'Desglose en linea  ' . $linea . " Producto " . $reg->getProducto()->getNombre() . " Suma de descontar en ubicaciones " . $CANTIDAD_DESGLOZADA . " no es igual a cantidad solicitada " . $CANTIDAD_TOTAL);
                $this->redirect('verifica_bodega/index?em=PE' . $id);
            }
        }
//        echo $id;
//        echo "<pre>";
//        print_r($descuenta);
//        die();
//        
        
        foreach ($descuenta as $repo) {
            $ubicac = new OrdenUbicacion();
            $ubicac->setOrdenVendedorId($id);
            $ubicac->setTiendaId($repo['tienda_id']);
            $ubicac->setProductoId($repo['producto_id']);
            $ubicac->setUbicacionId($repo['ubicaciones']);
            $ubicac->setCantidad($repo['cantidad']);
            $ubicac->setTiendaUbica($repo['tienda_ubica']);
            $ubicac->save();
        }
        foreach ($ordeCoti as $ordeDetalle) {
            $ordeDetalle->setVerificado(true);
            $ordeDetalle->save();
            sfContext::getInstance()->getUser()->setAttribute('em', null, 'seguridad');
            $this->getUser()->setFlash('exito', 'Existencia confirmada con exito');
        }
        $pedidoVen = OrdenVendedorQuery::create()->findOneById($id);
        $pedidoVen->setEstado('Verificado');
        $pedidoVen->save();
        $this->redirect('verifica_bodega/index?id=PE' . $id);
    }

    public function executeConfirmaPedi(sfWebRequest $request) {
        error_reporting(-1);
        $id = $request->getParameter('id');
        $ordeCoti = OrdenCotizacionDetalleQuery::create()
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->filterByOrdenCotizacionId($id)
                ->find();
        $linea = 0;
        $descuenta = null;
        foreach ($ordeCoti as $reg) {
            $linea++;
            $CANTIDAD_TOTAL = $reg->getCantidad();
            $ubicaciones = ProductoUbicacionQuery::create()->filterByCantidad(0, criteria::GREATER_THAN)->filterByProductoId($reg->getProductoId())->find();
            $CANTIDAD_DESGLOZADA = 0;
            if (count($ubicaciones) == 0) {
                $CANTIDAD_TOTAL = $CANTIDAD_DESGLOZADA;
            }
            foreach ($ubicaciones as $rego) {
                $cantiUBI = $request->getParameter('ubica' . $rego->getId());
                $CANTIDAD_DESGLOZADA = $cantiUBI + $CANTIDAD_DESGLOZADA;
                if ($cantiUBI > 0) {
                    $producto['tienda_ubica'] = $rego->getTiendaId();
                    $producto['producto_id'] = $reg->getProductoId();
                    $producto['ubicaciones'] = $rego->getUbicacion();
                    $producto['tienda_id'] = $reg->getOrdenCotizacion()->getTiendaId();
                    $producto['cantidad'] = $cantiUBI;
                    $descuenta[] = $producto;
                }
            }
            if ($CANTIDAD_DESGLOZADA <> $CANTIDAD_TOTAL) {
                $this->getUser()->setFlash('error', 'Desglose en linea  ' . $linea . " Producto " . $reg->getDetalle() . " Suma de descontar en ubicaciones " . $CANTIDAD_DESGLOZADA . " no es igual a cantidad solicitada " . $CANTIDAD_TOTAL);
                $this->redirect('verifica_bodega/index?em=' . $id);
            }
        }
        foreach ($descuenta as $repo) {
            $ubicac = new OrdenUbicacion();
            $ubicac->setOrdenCotizacionId($id);
            $ubicac->setTiendaId($repo['tienda_id']);
            $ubicac->setProductoId($repo['producto_id']);
            $ubicac->setUbicacionId($repo['ubicaciones']);
            $ubicac->setCantidad($repo['cantidad']);
            $ubicac->setTiendaUbica($repo['tienda_ubica']);
            $ubicac->save();
        }
        foreach ($ordeCoti as $ordeDetalle) {
            $ordeDetalle->setVerificado(true);
            $ordeDetalle->save();
            sfContext::getInstance()->getUser()->setAttribute('em', null, 'seguridad');
            $this->getUser()->setFlash('exito', 'Existencia confirmada con exito');
        }
        $this->redirect('verifica_bodega/index?id=' . $id);
    }

    
       public function executeModificar(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $canti = $request->getParameter('canti');
        $ordeDetalle = OrdenCotizacionDetalleQuery::create()->findOneById($id);
        $ordeDetalle->setCantidad($canti);
        $ordeDetalle->save();
        $this->getUser()->setFlash('exito', 'Cantidad Actualizada con exito');
        $this->redirect('verifica_bodega/index?em=' . $ordeDetalle->getOrdenCotizacionId());
    }

     public function executeModificarP(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $canti = $request->getParameter('canti');
        $ordeDetalle = VendedorProductoQuery::create()->findOneById($id);
        $ordeDetalle->setCantidad($canti);
        $ordeDetalle->save();
        $this->getUser()->setFlash('exito', 'Cantidad Actualizada con exito');
        $this->redirect('verifica_bodega/index?em=PE' . $ordeDetalle->getOrdenVendedorId());
    }

    
    
    
            
            
    public function executeConfirma(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $ordeDetalle = OrdenCotizacionDetalleQuery::create()->findOneById($id);
        $ordeDetalle->setVerificado(true);
        $ordeDetalle->save();
        $this->getUser()->setFlash('exito', 'Existencia confirmada con exito');
        $this->redirect('verifica_bodega/index?id=' . $id);
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        if ($request->getParameter('em')) {
            sfContext::getInstance()->getUser()->setAttribute('em', $request->getParameter('em'), 'seguridad');
        }

        $PREfijo = substr($request->getParameter('em'), 0, 2);
        $this->em = sfContext::getInstance()->getUser()->getAttribute('em', null, 'seguridad');
        $this->token = '';
        $perdidoVendedor = null;
        $this->tipo = 1;

        //** OPCION COTIZACION
        if ($PREfijo != 'PE') {
            $this->detalles = OrdenCotizacionDetalleQuery::create()
                    ->filterByProductoId(null, Criteria::NOT_EQUAL)
                    ->filterByVerificado(false)
                    ->useOrdenCotizacionQuery()
                    ->filterById($this->em)
                    ->filterBySolicitarBodega(true)
                    ->endUse()
                    ->find();
        } else {
            $this->tipo = 2;
            $idp = str_replace("PE", "", $this->em);
            $this->detalles = VendedorProductoQuery::create()
                    ->filterByOrdenVendedorId($idp)
                    ->useOrdenVendedorQuery()
                    ->filterByEstado('Confirmado')
                    ->endUse()
                    ->find();
        }

        //*** OPCION PEDIDDO VENDEROD

        $this->muestraBoton = 1;
        $this->codigo = '';
        $ordenq = OrdenCotizacionQuery::create()->findOneById($this->em);
        if ($ordenq) {
            $this->token = $ordenq->getToken();
            $this->codigo = $ordenq->getCodigo();
            $this->peso = $ordenq->getPesoTotal();
            $this->caja = $ordenq->getCantidadTotalCaja();
            $this->idp = $ordenq->getId();
        }
        if (count($this->detalles) == 0) {
            sfContext::getInstance()->getUser()->setAttribute('em', null, 'seguridad');
            $this->em = '';
            $this->detalles = OrdenCotizacionDetalleQuery::create()
                    ->filterByProductoId(null, Criteria::NOT_EQUAL)
                    ->filterByVerificado(false)
                    ->useOrdenCotizacionQuery()
                    ->filterBySolicitarBodega(true)
                    ->endUse()
                    ->find();
            $perdidoVendedor = VendedorProductoQuery::create()
                    ->useOrdenVendedorQuery()
                    ->filterByEstado('Confirmado')
                    ->endUse()
                    ->find();
            $this->muestraBoton = 0;
        }

        $this->cotizacio = OrdenCotizacionDetalleQuery::create()
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->groupByOrdenCotizacionId()
                ->filterByVerificado(false)
                ->useOrdenCotizacionQuery()
                ->filterBySolicitarBodega(true)
                ->endUse()
                ->find();


        $this->perdidoVendedor = $perdidoVendedor;
        $this->pedidos = OrdenVendedorQuery::create()
                ->filterByEstado('Confirmado')
                ->find();
    }

}
