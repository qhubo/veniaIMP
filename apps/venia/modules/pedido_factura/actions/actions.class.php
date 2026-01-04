<?php

/**
 * pedido_factura actions.
 *
 * @package    plan
 * @subpackage pedido_factura
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pedido_facturaActions extends sfActions {
  
        public function executeConfirmar(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $operaicon = OperacionQuery::create()->findOneById($id);
        $operaicon->setEstatus('Facturado');
        $operaicon->save();
        $codigo= $operaicon->getCodigo();
        
  $this->getUser()->setFlash('exito', 'Pedido facturado  con exito');
        $this->redirect('pedido_factura/index?codigo=' . $codigo);
        }
    
      public function executeCambia(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $val = $request->getParameter('val');
        $operacionDetalle = OperacionDetalleQuery::create()->findOneById($id);
        $operacionDetalle->setValorUnitario($val);
        $operacionDetalle->setValorTotal(round($val*$operacionDetalle->getCantidad(),2));
        $operacionDetalle->save();

        $operacion = $operacionDetalle->getOperacion();
        $codigo = $operacionDetalle->getOperacion()->getCodigo();

        $LISTA = OperacionDetalleQuery::create()
                ->filterByOperacionId($operacion->getId())
                ->withColumn('sum(OperacionDetalle.ValorTotal)', 'TotalValorTotal')
                ->findOne();
        $operacion->setValorTotal(round($LISTA->getTotalValorTotal(),2));
        $operacion->save();

        $returna['total']= Parametro::formato($LISTA->getTotalValorTotal(),true);
        $returna['linea']=round($val*$operacionDetalle->getCantidad(),2);
           return $this->renderText(json_encode($returna));
    }
    
    

    public function executeTransporte(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $val = $request->getParameter('val');
        $operacion = OperacionQuery::create()->findOneById($id);
        $operacion->setTransporte($val);
        $operacion->save();
        echo "actualizado";
        die();
    }

    public function executeEliminaLinea(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $operacionDetalle = OperacionDetalleQuery::create()->findOneById($id);
        $operacion = $operacionDetalle->getOperacion();
        $codigo = $operacionDetalle->getOperacion()->getCodigo();
        $operacionDetalle->delete();
        $LISTA = OperacionDetalleQuery::create()
                ->filterByOperacionId($operacion->getId())
                ->withColumn('sum(OperacionDetalle.ValorTotal)', 'TotalValorTotal')
                ->findOne();
        $operacion->setValorTotal($LISTA->getTotalValorTotal());
        $operacion->save();
        $this->getUser()->setFlash('error', 'Servicio eliminado con exito');
        $this->redirect('pedido_factura/nueva?codigo=' . $codigo);
    }

    public function executeAgrega(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $servicio = $request->getParameter('servicio');
        $servicioQ = ServicioQuery::create()->findOneById($servicio);
        $operacion = OperacionQuery::create()->findOneById($id);
        $detalle = New OperacionDetalle();
        $detalle->setServicioId($servicio);
        $detalle->setOperacionId($id);
        $detalle->setDetalle($servicioQ->getNombre());
        $detalle->setCodigo($servicioQ->getCodigo());
        $detalle->setValorUnitario($servicioQ->getPrecio());
        $detalle->setCantidad(1);
        $detalle->setValorTotal($servicioQ->getPrecio());
        $detalle->save();

        $LISTA = OperacionDetalleQuery::create()
                ->filterByOperacionId($id)
                ->withColumn('sum(OperacionDetalle.ValorTotal)', 'TotalValorTotal')
                ->findOne();
        $operacion->setValorTotal($LISTA->getTotalValorTotal());
        $operacion->save();

        $this->getUser()->setFlash('exito', 'Servicio agregado con exito ' . $servicioQ->getNombre());
        $this->redirect('pedido_factura/nueva?codigo=' . $operacion->getCodigo());
    }

    public function executeNueva(sfWebRequest $request) {
        $codigo = $request->getParameter('codigo');
        $this->operacion = OperacionQuery::create()->findOneByCodigo($codigo);
        $this->detalle = OperacionDetalleQuery::create()
                ->filterByOperacionId($this->operacion->getId())
                ->find();
        $this->servicios = ServicioQuery::create()
                ->orderByNombre()
                ->find();
    }

    public function executeIndex(sfWebRequest $request) {

        $this->registros = OperacionQuery::create()
                ->filterByEstatus('Procesada')
                ->filterByEmpacado(true)
                ->find();
    }

}
