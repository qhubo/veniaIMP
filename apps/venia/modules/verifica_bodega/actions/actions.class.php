<?php

class verifica_bodegaActions extends sfActions {

      public function executeRecuperar(sfWebRequest $request) {
       error_reporting(-1);
        $id = $request->getParameter('id');
        $detalle = OrdenCotizacionDetalleQuery::create()->findOneById($id);
        $OrdenID = $request->getParameter('coti');


          $new = new OrdenCotizacionDetalle();
            $new->setOrdenCotizacionId($OrdenID);
            $new->setConfirmado(true);
            $new->setProductoId( $detalle->getProductoId());
            $new->setDetalle( $detalle->getDetalle());
            $new->setCodigo( $detalle->getCodigo());
            $new->setValorUnitario( $detalle->getValorUnitario());
            $new->setValorTotal( $detalle->getValorTotal());
            $new->setCantidad( $detalle->getCantidad());
            $new->setCostoUnitario( $detalle->getCostoUnitario());
            $new->save();
        
        $ordenQ = OrdenCotizacionQuery::create()->findOneById($OrdenID);
        $lista = OrdenCotizacionDetalleQuery::create()
                ->filterByConfirmado(true)
                ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalGeneral')
                ->filterByOrdenCotizacionId($OrdenID)
                ->findOne();
        $suma = $lista->getTotalGeneral();
        $valores = ParametroQuery::ObtenerIva($suma, false);
        $iva = $valores['IVA'];
        $valorSInIVa = $valores['VALOR_SIN_IVA'];
        $ordenQ->setSubTotal($valorSInIVa);
        $ordenQ->setValorTotal($suma);
        $ordenQ->setIva($iva);
        $ordenQ->save();

        $this->getUser()->setFlash('exito', 'Producto Agregado Con exito');
        $this->redirect('verifica_bodega/index?em='.$OrdenID);
      }
    
    
    public function executeElimina(sfWebRequest $request) {
        error_reporting(-1);
        $id = $request->getParameter('id');
        $operacion = OrdenCotizacionDetalleQuery::create()->findOneById($id);
        $OrdenID = $operacion->getOrdenCotizacionId();
        $operacion->delete();
        $ordenQ = OrdenCotizacionQuery::create()->findOneById($OrdenID);
        $lista = OrdenCotizacionDetalleQuery::create()
                ->filterByConfirmado(true)
                ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalGeneral')
                ->filterByOrdenCotizacionId($OrdenID)
                ->findOne();
        $suma = $lista->getTotalGeneral();
        $valores = ParametroQuery::ObtenerIva($suma, false);
        $iva = $valores['IVA'];
        $valorSInIVa = $valores['VALOR_SIN_IVA'];
        $ordenQ->setSubTotal($valorSInIVa);
        $ordenQ->setValorTotal($suma);
        $ordenQ->setIva($iva);
        $ordenQ->save();

        $this->getUser()->setFlash('error', 'Linea eliminada con exito');
        $this->redirect('verifica_bodega/index');
    }

    public function executeConfirmaPedi(sfWebRequest $request) {
        error_reporting(-1);
        $id = $request->getParameter('id');
        $opreacion = OrdenCotizacionQuery::create()->findOneById($id);
        $opreacionDetalle = OrdenCotizacionDetalleQuery::create()
                ->filterByConfirmado(true)
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
//                ->filterByCantidadCaja()
                ->filterByOrdenCotizacionId($id)
                ->find();
        foreach ($opreacionDetalle as $detalle) {
            if ((!$detalle->getCantidadCaja()) && (!$detalle->getBultoSuperior())) {
                $this->getUser()->setFlash('error', 'Cantidad de bulto no definidad para producto ' . $detalle->getDetalle());
                $this->redirect('verifica_bodega/index?id=' . $id);
            }
        }
        $opreacion->setEmpacado(true);
        $opreacion->save();
        $this->getUser()->setFlash('exito', 'Pedido empacado ' . $opreacion->getCodigo());
        $this->redirect('verifica_bodega/index?id=' . $opreacion->getId());
    }

    public function executeGrabaEmpaque(sfWebRequest $request) {
        error_reporting(-1);
        $id = $request->getParameter('id');
        $OrdenCotizacionDetalle = OrdenCotizacionDetalleQuery::create()->findOneById($id);
        $bulto_superior = $request->getParameter('seleccion_' . $id);
        if ($bulto_superior > 0) {
            $query = "select bulto_inicio, bulto_fin from orden_cotizacion_detalle where id ='" . $bulto_superior . "'";
            $con = Propel::getConnection();
            $stmt = $con->prepare($query);
            $resource = $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                $inicio = $result[0]['bulto_inicio'];
                $fin = $result[0]['bulto_fin'];
            }

            $OrdenCotizacionDetalle->setBultoSuperior($bulto_superior);
            $OrdenCotizacionDetalle->setCantidadCaja(0);
            $OrdenCotizacionDetalle->setBultoInicio($inicio);
            $OrdenCotizacionDetalle->setBultoFin($fin);
            $OrdenCotizacionDetalle->save();
            $this->getUser()->setFlash('exito', 'Registro actualizado con exito  ');
            $this->redirect('verifica_bodega/index');
        }
        $cantitad = $request->getParameter('cantidad' . $id);
        $inicio = $request->getParameter('inicio' . $id);
        if ($cantitad == 0) {
            $this->getUser()->setFlash('error', 'Debe Ingresar cantidad  ');
            $this->redirect('verifica_bodega/index');
        }
        if ($inicio == 0) {
            $this->getUser()->setFlash('error', 'Debe Ingresar numero de bulto  ');
            $this->redirect('verifica_bodega/index');
        }

        $operaiconId = $OrdenCotizacionDetalle->getOrdenCotizacionId();
        $registros = OrdenCotizacionDetalleQuery::create()
                ->filterByConfirmado(true)
                ->filterByCantidadCaja(0, Criteria::GREATER_THAN)
                ->filterById($id, Criteria::NOT_EQUAL)
                ->filterByOrdenCotizacionId($operaiconId)
                ->find();

        $ListaPrevia[0] = 0;
        foreach ($registros as $deta) {
            $inicioCon = $deta->getBultoInicio();
            $fin = $deta->getBultoFin();
            for ($i = $inicioCon; $i <= $fin; $i++) {
                $ListaPrevia[$i] = $i;
            }
        }
        if (array_key_exists($inicio, $ListaPrevia)) {
            $this->getUser()->setFlash('error', 'Numero de bulto ya se encuentra registrado  ');
            $this->redirect('verifica_bodega/index');
        }
        $fin = $inicio + $cantitad - 1;
        $OrdenCotizacionDetalle->setCantidadCaja($cantitad);
        $OrdenCotizacionDetalle->setBultoInicio($inicio);
        $OrdenCotizacionDetalle->setBultoFin($fin);
        $OrdenCotizacionDetalle->save();


        $bultoSuperiores = OrdenCotizacionDetalleQuery::create()
                ->filterByConfirmado(true)
                ->filterByBultoSuperior($OrdenCotizacionDetalle->getId())
                ->find();
        foreach ($bultoSuperiores as $superio) {
            $superio->setBultoSuperior(null);
            $superio->setCantidadCaja(0);
            $superio->setBultoInicio(null);
            $superio->setBultoFin(null);
            $superio->save();
        }

        $this->getUser()->setFlash('exito', 'Registro actualizado con exito  ');
        $this->redirect('verifica_bodega/index');
    }

    public function executeDividir(sfWebRequest $request) {
        error_reporting(-1);
        $id = $request->getParameter('id');
        $cantidadTotal = $request->getParameter('cantidadV' . $id);
        $Linea1 = $request->getParameter('linea1_' . $id);
        $Linea2 = $cantidadTotal - $Linea1;
//        echo " LINEA 1 ".$Linea1;
//        echo "<br>";
//        echo " LINEA 2 ".$Linea2;
//        die();
        $Detalle = OrdenCotizacionDetalleQuery::create()->findOneById($id);
        $productoID = $Detalle->getProductoId();
        $valorUnitario = $Detalle->getValorUnitario();
        /// ACTUALIZANDO VALOR 1
        $Detalle->setCantidad($Linea1);
        $Detalle->setValorTotal(round($Linea1 * $valorUnitario, 2));
        $Detalle->save();

        if ($Linea2 > 0) {
            $productoQ = $Detalle->getProducto();
            $nueva = new OrdenCotizacionDetalle();
            $nueva->setConfirmado(true);
            $nueva->setOrdenCotizacionId($Detalle->getOrdenCotizacionId());
            $nueva->setProductoId($productoQ->getId());
            $nueva->setDetalle($productoQ->getNombre());
            $nueva->setCodigo($productoQ->getCodigoSku());
            $nueva->setValorUnitario($valorUnitario);
            $nueva->setCantidad($Linea2);
            $nueva->setValorTotal(round($Linea2 * $valorUnitario, 2));
            $nueva->save();
        }
        $OrdenID = $Detalle->getOrdenCotizacionId();
        $ordenQ = OrdenCotizacionQuery::create()->findOneById($OrdenID);
        $lista = OrdenCotizacionDetalleQuery::create()
                ->filterByConfirmado(true)
                ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalGeneral')
                ->filterByOrdenCotizacionId($OrdenID)
                ->findOne();
        $suma = $lista->getTotalGeneral();
        $valores = ParametroQuery::ObtenerIva($suma, false);
        $iva = $valores['IVA'];
        $valorSInIVa = $valores['VALOR_SIN_IVA'];
        $ordenQ->setSubTotal($valorSInIVa);
        $ordenQ->setValorTotal($suma);
        $ordenQ->setIva($iva);
        $ordenQ->save();
        $this->getUser()->setFlash('exito', 'Linea modificada con exito  ');
        $this->redirect('verifica_bodega/index?pr=' . $productoID);
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        $odenC = OrdenCotizacionQuery::create()
                ->filterByEstatus('Confirmada')
                ->filterByEmpacado(null)
                ->find();
        foreach ($odenC as $reg) {
            $reg->setEmpacado(false);
            $reg->save();
        }
        $id = $request->getParameter('id');
        date_default_timezone_set("America/Guatemala");
        if ($request->getParameter('em')) {
            sfContext::getInstance()->getUser()->setAttribute('em', $request->getParameter('em'), 'seguridad');
        }

        $this->pr = $request->getParameter('pr');
        $this->em = sfContext::getInstance()->getUser()->getAttribute('em', null, 'seguridad');
        $this->token = '';
        $this->tipo = 1;
        $this->detalles = OrdenCotizacionDetalleQuery::create()
                ->filterByConfirmado(true)
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->useOrdenCotizacionQuery()
                ->filterById($this->em)
                ->filterByEstatus('Confirmada')
                ->endUse()
                ->withColumn('CAST(orden_cotizacion_detalle.bulto_inicio AS UNSIGNED)', 'BultoOrden')
                ->orderBy('BultoOrden')
                ->find();

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
                    ->filterByConfirmado(true)
                    ->filterByProductoId(null, Criteria::NOT_EQUAL)
                    ->useOrdenCotizacionQuery()
                    ->filterByEmpacado(false)
                    ->filterByEstatus('Confirmada')
                    ->endUse()
                    ->find();
            $this->muestraBoton = 0;
        }

        $this->cotizacio = OrdenCotizacionDetalleQuery::create()
                ->filterByConfirmado(true)
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->groupByOrdenCotizacionId()
                ->useOrdenCotizacionQuery()
                //   ->filterByEmpacado(false)
                ->filterByEstatus('Confirmada')
                ->endUse()
                ->find();
        $bultocreados = OrdenCotizacionDetalleQuery::create()
                ->filterByConfirmado(true)
                ->filterByBultoSuperior(null)
                ->filterByOrdenCotizacionId($this->em)
                ->filterByCantidadCaja(0, Criteria::GREATER_EQUAL)
                ->find();
        $listaCr = null;
        foreach ($bultocreados as $reg) {
            if ($reg->getBultoInicio() > 0) {
                $detalle = "Bulto " . $reg->getBultoInicio();
                if ($reg->getCantidadCaja() > 1) {
                    $detalle .= " A Bulto " . $reg->getBultoFin();
                }
                $listaCr[$reg->getId()] = $detalle;
            }
        }

        $this->productos = OrdenCotizacionDetalleQuery::create()
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->filterByOrdenCotizacionId($this->em)
                ->filterByConfirmado(true)
                ->groupByProductoId()
                ->find();


        $this->bultosCreado = $listaCr;
        $this->operacion = OrdenCotizacionQuery::create()->findOneById($id);
 $this->productoBorrado =null;
        $CotizacionEmpaque = OrdenCotizacionQuery::create()->findOneById($this->em);
        if ($CotizacionEmpaque) {
                // ==============================
                // 1️⃣ PRODUCTOS EN LISTA EMPAQUE
                // ==============================
                $listaEmpaque = OrdenCotizacionDetalleQuery::create()
                        ->filterByOrdenCotizacionId($CotizacionEmpaque->getId())
                        ->groupByProductoId()
                        ->find();
                // Obtener IDs de productos del empaque
                $productosEmpaque = array();
                foreach ($listaEmpaque as $detalle) {
                    $productosEmpaque[] = $detalle->getProductoId();
                }
//                echo "<pre>";
//                print_r($productosEmpaque);
//                echo "</pre>";
                
                // ==============================
                //OBTENER CODIGO DEL PEDIDO
                // ==============================
                $codigoPedido = str_replace("LIST-", "", $CotizacionEmpaque->getCodigo());
                // ==============================
                // PRODUCTOS DEL PEDIDO ORIGINAL
                // ==============================
    
       
                $listaPedido = OrdenCotizacionDetalleQuery::create()
                      ->filterByProductoId($productosEmpaque, Criteria::NOT_IN)
                        ->useOrdenCotizacionQuery()
                        ->filterByCodigo($codigoPedido)
                        ->endUse()
                        ->groupByProductoId()
                        ->find();
                
              
             
        }
         $this->productoBorrado =$listaPedido;
    }

}
