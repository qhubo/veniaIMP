<?php

class pedido_facturaActions extends sfActions {

    
    public function executeActualizaPrecio(sfWebRequest $request){
    $id = $request->getParameter('id');
    $valor = $request->getParameter('valor');
    $linea = OrdenCotizacionDetalleQuery::create()->findOneById($id);
    if ($linea) {
        $linea->setValorUnitario($valor);
        $linea->setValorTotal($valor * $linea->getCantidad());
        $linea->save();
    }
    $operacion =$linea->getOrdenCotizacion();
      $ordenEMpaque = OrdenCotizacionEmpaqueQuery::create()
                ->filterByOrdenCotizacionId($linea->getOrdenCotizacionId())
                ->find();
        $list[] = $linea->getOrdenCotizacionId();
        foreach ($ordenEMpaque as $reg) {
            $list[] = $reg->getOrdenEmpaque();
        }
    
        $LISTA = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($list, Criteria::IN)
                ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalValorTotal')
                ->findOne();
        $operacion->setValorTotal($LISTA->getTotalValorTotal());
        $operacion->save();
      $retorna = Parametro::formato($LISTA->getTotalValorTotal());
      echo $retorna;
      die();
    

}

    
    public function executeEliminaPedido(sfWebRequest $request) {
        error_reporting(-1);
        $id = $request->getParameter('id');
        $ordenCotizacion = OrdenCotizacionDetalleQuery::create()->findOneById($id);
        $ordenCoti = OrdenCotizacionEmpaqueQuery::create()->findOneByOrdenEmpaque($ordenCotizacion->getOrdenCotizacionId());
        $codigo = $ordenCoti->getOrdenCotizacion()->getCodigo();
        $ordenCoti->delete();
        $this->redirect('pedido_factura/nueva?codigo=' . $codigo);
    }

    public function executeAgregarEmpa(sfWebRequest $request) {
        $pedido = $request->getParameter('pedido');
        $em = $request->getParameter('em');
        $ordenCo = OrdenCotizacionQuery::create()->findOneByCodigo($pedido);

        $ordenCoti = OrdenCotizacionEmpaqueQuery::create()
                ->filterByOrdenCotizacionId($ordenCo->getId())
                ->filterByOrdenEmpaque($em)
                ->findOne();
        if (!$ordenCoti) {
            $ordenCoti = new OrdenCotizacionEmpaque();
            $ordenCoti->setOrdenCotizacionId($ordenCo->getId());
            $ordenCoti->setOrdenEmpaque($em);
            $ordenCoti->save();
        }
        $this->getUser()->setFlash('exito', 'Lista de Empaque agregada');
        $this->redirect('pedido_factura/nueva?codigo=' . $ordenCo->getCodigo());
    }

    public function executeConfirmar(sfWebRequest $request) {
   $con = Propel::getConnection();
        $con->beginTransaction();
        try {
        $id = $request->getParameter('id');
        $tipoSerie = $request->getParameter('tipoSerie');
        error_reporting(-1);
        $query = "select IFNULL(MAX(op.codigo_factura),0) codigo  from operacion_detalle de inner join operacion op on op.id=de.operacion_id where prefijo ='" . $tipoSerie . "'";
        $con = Propel::getConnection();
        $stmt = $con->prepare($query);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            $codigo = $result[0]['codigo'];
            $numero = (int) str_replace($tipoSerie, "", $codigo) + 1;
        }


        $prefijo = $tipoSerie . $numero;
        if (strlen($numero) == 1) {
            $prefijo = $tipoSerie . '000' . $numero;
        }
        if (strlen($numero) == 2) {
            $prefijo = $tipoSerie . '00' . $numero;
        }
        if (strlen($numero) == 3) {
            $prefijo = $tipoSerie . '0' . $numero;
        }

//            echo $prefijo;
//            die();

        $ordenQ = OrdenCotizacionQuery::create()->findOneById($id);
        OrdenCotizacionPeer::ProcesaAutoUbicacion($ordenQ, $prefijo, $tipoSerie);
        $ordenEMpaque = OrdenCotizacionEmpaqueQuery::create()
                ->filterByOrdenCotizacionId($ordenQ->getId())
                ->find();
        foreach ($ordenEMpaque as $registro) {
            $cotis = OrdenCotizacionQuery::create()->findOneById($registro->getOrdenEmpaque());
            if ($cotis) {
            $cotis->setEstatus('Facturada');
            $cotis->save();
            }
        }
        $ordenQ->setEstatus('Facturada');
        $ordenQ->save();
      $con->commit();
   $this->getUser()->setFlash(            'exito',            'Pedido facturado con éxito'        );
        $this->redirect('pedido_factura/index?codigo=' . $ordenQ->getCodigo());
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
        $this->redirect('pedido_factura/index?codigo=' . $ordenQ->getCodigo());

        }

        $this->getUser()->setFlash('exito', 'Pedido facturado  con exito');
        $this->redirect('pedido_factura/index?codigo=' . $ordenQ->getCodigo());
    }

    public function executeEliminaLinea(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $operacionDetalle = OrdenCotizacionDetalleQuery::create()->findOneById($id);
        $operacion = $operacionDetalle->getOrdenCotizacion();
        $codigo = $operacionDetalle->getOrdenCotizacion()->getCodigo();
        $ordenEMpaque = OrdenCotizacionEmpaqueQuery::create()
                ->filterByOrdenCotizacionId($operacionDetalle->getOrdenCotizacionId())
                ->find();
        $list[] = $operacionDetalle->getOrdenCotizacionId();
        foreach ($ordenEMpaque as $reg) {
            $list[] = $reg->getOrdenEmpaque();
        }
        $operacionDetalle->delete();
        $LISTA = OrdenCotizacionDetalleQuery::create()
                ->filterByConfirmado(true)
                ->filterByOrdenCotizacionId($list, Criteria::IN)
                ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalValorTotal')
                ->findOne();
        $operacion->setValorTotal($LISTA->getTotalValorTotal());
        $operacion->save();
        $this->getUser()->setFlash('error', 'Servicio eliminado con exito');
        $this->redirect('pedido_factura/nueva?codigo=' . $codigo);
    }

    public function executeCambia(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $val = $request->getParameter('val');
        $operacionDetalle = OrdenCotizacionDetalleQuery::create()->findOneById($id);
        $operacionDetalle->setValorUnitario($val);
        $operacionDetalle->setValorTotal(round($val * $operacionDetalle->getCantidad(), 2));
        $operacionDetalle->save();

        $operacion = $operacionDetalle->getOrdenCotizacion();
        $codigo = $operacionDetalle->getOrdenCotizacion()->getCodigo();
        
                $ordenEMpaque = OrdenCotizacionEmpaqueQuery::create()
                ->filterByOrdenCotizacionId($operacionDetalle->getOrdenCotizacionId())
                ->find();
        $list[] = $operacionDetalle->getOrdenCotizacionId();
        foreach ($ordenEMpaque as $reg) {
            $list[] = $reg->getOrdenEmpaque();
        }
        $LISTA = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($list, Criteria::IN)
                ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalValorTotal')
                ->findOne();
        $operacion->setValorTotal(round($LISTA->getTotalValorTotal(), 2));
        $operacion->save();

        $returna['total'] = Parametro::formato($LISTA->getTotalValorTotal(), true);
        $returna['linea'] = round($val * $operacionDetalle->getCantidad(), 2);
        return $this->renderText(json_encode($returna));
    }

    public function executeTransporte(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $val = $request->getParameter('val');
        $operacion = OrdenCotizacionQuery::create()->findOneById($id);
        $operacion->setTransporte($val);
        $operacion->save();
        echo "actualizado";
        die();
    }

    public function executeAgrega(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $servicio = $request->getParameter('servicio');
        $servicioQ = ServicioQuery::create()->findOneById($servicio);
        $operacion = OrdenCotizacionQuery::create()->findOneById($id);
        $detalle = New OrdenCotizacionDetalle();
        $detalle->setServicioId($servicio);
        $detalle->setOrdenCotizacionId($id);
        $detalle->setDetalle($servicioQ->getNombre());
        $detalle->setCodigo($servicioQ->getCodigo());
        $detalle->setValorUnitario($servicioQ->getPrecio());
        $detalle->setCantidad(1);
        $detalle->setValorTotal($servicioQ->getPrecio());
        $detalle->save();
        
         $ordenEMpaque = OrdenCotizacionEmpaqueQuery::create()
                ->filterByOrdenCotizacionId($detalle->getOrdenCotizacionId())
                ->find();
        $list[] = $detalle->getOrdenCotizacionId();
        foreach ($ordenEMpaque as $reg) {
            $list[] = $reg->getOrdenEmpaque();
        }
        

        $LISTA = OrdenCotizacionDetalleQuery::create()
              //  ->filterByConfirmado(true)
                ->filterByOrdenCotizacionId($list, Criteria::IN)
                ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalValorTotal')
                ->findOne();
        $operacion->setValorTotal($LISTA->getTotalValorTotal());
        $operacion->save();

        $this->getUser()->setFlash('exito', 'Servicio agregado con exito ' . $servicioQ->getNombre());
        $this->redirect('pedido_factura/nueva?codigo=' . $operacion->getCodigo());
    }

    public function executeNueva(sfWebRequest $request) {
        $codigo = $request->getParameter('codigo');
        error_reporting(-1);
        $operacion = OrdenCotizacionQuery::create()->findOneByCodigo($codigo);
        $ordenEMpaque = OrdenCotizacionEmpaqueQuery::create()
                ->filterByOrdenCotizacionId($operacion->getId())
                ->find();
        $list[] = $operacion->getId();
        foreach ($ordenEMpaque as $reg) {
            $list[] = $reg->getOrdenEmpaque();
        }
        
        $servicios = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($list, Criteria::IN)
                ->filterByServicioId(null, Criteria::NOT_EQUAL)
                ->find();
//        echo "<pre>";
//        print_r($servicios);
//        die();
        $con=0;
        foreach($servicios as $regi) {
            $con++;
            if ($con >1) {
                $regi->delete();
            }
        }
         $LISTA = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($list, Criteria::IN)
                ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalValorTotal')
                ->findOne();
        $operacion->setValorTotal(round($LISTA->getTotalValorTotal(), 2));
        $operacion->save();
       
       $this->operacion=$operacion;
        $this->detalle = OrdenCotizacionDetalleQuery::create()
               ->filterByOrdenCotizacionId($list, Criteria::IN)
                ->orderByServicioId("Asc")
                ->orderByOrdenCotizacionId()
              
                ->find();
//        $this->cargos = OrdenCotizacionDetalleQuery::create()
//                ->filterByProductoId(null)
//                ->filterByOrdenCotizacionId($this->operacion->getId())
//                ->find();
        $this->servicios = ServicioQuery::create()
                ->orderByNombre()
                ->find();
        $this->transportes = TipoTransporteQuery::create()->orderByNombre()->find();
        $this->empaques = OrdenCotizacionQuery::create()
                ->filterByCodigo($codigo, Criteria::NOT_EQUAL)
                ->filterByEstatus('Confirmada')
                ->filterByEmpacado(true)
                ->find();
    }

    public function executeIndex(sfWebRequest $request) {
        $this->registros = OrdenCotizacionQuery::create()
                ->filterByEstatus('Confirmada')
                ->filterByEmpacado(true)
                ->find();
        $codigo = $request->getParameter('codigo');
        $this->operacion = OperacionQuery::create()->findOneByCodigo($codigo);
    }

}
