<?php

class verifica_bodegaActions extends sfActions {

    public function executeTcaja(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $val = $request->getParameter('val');
        $ordenCoti = OperacionQuery::create()->findOneById($id);
        $ordenCoti->setCantidadTotalCaja($val);
        $ordenCoti->save();
        die();
    }

    public function executeTpeso(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $val = $request->getParameter('val');
        $ordenCoti = OperacionQuery::create()->findOneById($id);
        $ordenCoti->setPesoTotal($val);
        $ordenCoti->save();
        die();
    }

    public function executeCaja(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $val = $request->getParameter('val');
        $ordenId = OperacionDetalleQuery::create()->findOneById($id);
        $ordenId->setCantidadCaja($val);
        $ordenId->save();
        $ordenCoti = OperacionQuery::create()->findOneById($ordenId->getOperacionId());
        $movimiento = OperacionDetalleQuery::create()
                ->filterByOperacionId($ordenId->getOperacionId())
                ->withColumn('sum(OperacionDetalle.CantidadCaja)', 'TotalTotal')
                ->findOne();
         $total=round($movimiento->getTotalTotal(),2);
        $ordenCoti->setCantidadTotalCaja($total);
        $ordenCoti->save();
        echo $total;
        die();
    }

    public function executePeso(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $val = $request->getParameter('val');
        $ordenId = OperacionDetalleQuery::create()->findOneById($id);
        $ordenId->setPeso($val);
        $ordenId->save();
        $ordenCoti = OperacionQuery::create()->findOneById($ordenId->getOperacionId());
        $movimiento = OperacionDetalleQuery::create()
                ->filterByOperacionId($ordenId->getOperacionId())
                ->withColumn('sum(OperacionDetalle.Peso)', 'TotalTotal')
                ->findOne();
        echo $movimiento->getTotalTotal();
        $ordenCoti->setPesoTotal($movimiento->getTotalTotal());
        $ordenCoti->save();

        die();
        die();
    }

    public function executeConfirmaPedi(sfWebRequest $request) {
        $id = $request->getParameter('id');
        
        $opreacion= OperacionQuery::create()->findOneById($id);
        $opreacionDetalle = OperacionDetalleQuery::create()
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
//                ->filterByCantidadCaja()
                ->filterByOperacionId($id)
                ->find();
        foreach($opreacionDetalle as $detalle) {
            if (!$detalle->getCantidadCaja()) {
              $this->getUser()->setFlash('error', 'Cantidad de bulto no definidad para producto '.$detalle->getDetalle());
        $this->redirect('verifica_bodega/index?id=' . $id);
            }
        }
        
        $opreacion->setEmpacado(true);
        $opreacion->save();
              $this->getUser()->setFlash('exito', 'Pedido empacado '.$opreacion->getCodigo());
        $this->redirect('verifica_bodega/index');
        
//        $ordeDetalle = OperacionDetalleQuery::create()->findOneById($id);
//        //$ordeDetalle->setVerificado(true);
//        $ordeDetalle->save();

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

        $this->tipo = 1;

        $this->detalles = OperacionDetalleQuery::create()
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->useOperacionQuery()
                ->filterById($this->em)
                ->filterByEstatus('Procesada')
                ->filterByEmpacado(false)

                //  ->filterBySolicitarBodega(true)
                ->endUse()
                ->find();

        //*** OPCION PEDIDDO VENDEROD

        $this->muestraBoton = 1;
        $this->codigo = '';
        $ordenq = OperacionQuery::create()->findOneById($this->em);
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
            $this->detalles = OperacionDetalleQuery::create()
                    ->filterByProductoId(null, Criteria::NOT_EQUAL)
                    ->useOperacionQuery()
                    ->filterByEmpacado(false)
                    ->filterByEstatus('Procesada')
                    ->endUse()
                    ->find();

            $this->muestraBoton = 0;
        }

        $this->cotizacio = OperacionDetalleQuery::create()
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->groupByOperacionId()
                ->useOperacionQuery()
                ->filterByEmpacado(false)
                ->filterByEstatus('Procesada')
                ->endUse()
                ->find();
    }

}
