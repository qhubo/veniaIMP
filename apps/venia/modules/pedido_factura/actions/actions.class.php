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
        $ordenQ= OrdenCotizacionQuery::create()->findOneById($id);
        
        OrdenCotizacionPeer::ProcesaAutoUbicacion($ordenQ);
        $ordenQ->setEstatus('Facturada');
        $ordenQ->save();
//        $operaicon = OperacionQuery::create()->findOneById($id);
//        $operaicon->setEstatus('Facturado');
//        $operaicon->save();
 
        $this->getUser()->setFlash('exito', 'Pedido facturado  con exito');
        $this->redirect('pedido_factura/index?codigo=' . $ordenQ->getCodigo());
    }

    public function executeEliminaLinea(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $operacionDetalle = OrdenCotizacionDetalleQuery::create()->findOneById($id);
        $operacion = $operacionDetalle->getOrdenCotizacion();
        $codigo = $operacionDetalle->getOrdenCotizacion()->getCodigo();
        $operacionDetalle->delete();
        $LISTA = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($operacion->getId())
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

        $LISTA = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($operacion->getId())
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

        $LISTA = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($id)
                ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalValorTotal')
                ->findOne();
        $operacion->setValorTotal($LISTA->getTotalValorTotal());
        $operacion->save();

        $this->getUser()->setFlash('exito', 'Servicio agregado con exito ' . $servicioQ->getNombre());
        $this->redirect('pedido_factura/nueva?codigo=' . $operacion->getCodigo());
    }

    public function executeNueva(sfWebRequest $request) {
        $codigo = $request->getParameter('codigo');
        $this->operacion = OrdenCotizacionQuery::create()->findOneByCodigo($codigo);
        $this->detalle = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($this->operacion->getId())
                ->find();
        $this->servicios = ServicioQuery::create()
                ->orderByNombre()
                ->find();
        $this->transportes = TipoTransporteQuery::create()->orderByNombre()->find();
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
