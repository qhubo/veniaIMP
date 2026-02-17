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
          $tipoSerie = $request->getParameter('tipoSerie');
             error_reporting(-1);
        $query="select IFNULL(MAX(op.codigo_factura),0) codigo  from operacion_detalle de inner join operacion op on op.id=de.operacion_id where prefijo ='".$tipoSerie."'";
  
        $con = Propel::getConnection();
        $stmt = $con->prepare($query);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            $codigo = $result[0]['codigo'];
            $numero =(int) str_replace($tipoSerie, "", $codigo)+1;
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
        
        $ordenQ= OrdenCotizacionQuery::create()->findOneById($id);
        OrdenCotizacionPeer::ProcesaAutoUbicacion($ordenQ, $prefijo, $tipoSerie);
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
                      ->filterByConfirmado(true)
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
                      ->filterByConfirmado(true)
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
                      ->filterByConfirmado(true)
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
                      ->filterByConfirmado(true)
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
