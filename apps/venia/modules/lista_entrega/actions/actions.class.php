<?php

/**
 * lista_entrega actions.
 *
 * @package    plan
 * @subpackage lista_entrega
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lista_entregaActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->operaciones = OperacionQuery::create()
                ->filterByEstatus('Entrega')
                ->orderByFecha("Desc")
                ->find();
    }

    public function executeEntrega(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&$dirh =
        $OperacionId = $request->getParameter('id'); //=155555&$dirh =
        $operacion = OperacionQuery::create()->findOneById($OperacionId);
        $this->operacion = OperacionQuery::create()->findOneById($OperacionId);
        $this->detalle = OperacionDetalleQuery::create()
                ->groupByProductoId()
                ->useProductoQuery()
                ->filterByTercero(true)
                ->endUse()
                ->filterByOperacionId($OperacionId)
                 ->withColumn('sum(OperacionDetalle.Cantidad)', 'TotalGeneral')
                ->find();
        $this->pagos = OperacionPagoQuery::create()->filterByOperacionId($OperacionId)->find();
        $this->form = new ListaInventarioForm();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("ingreso"), $request->getFiles("ingreso"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();

                foreach ($this->detalle as $reg) {
                    $totalRebaja = $reg->getTotalGeneral();
                    $totalSeleccion = 0;
                    foreach ($reg->getDetallePro() as $de) {
                        $name = $de->getFechaVence('dmY') . "_" . $de->getProductoId(). "_" . $operacion->getTiendaId();
                        $totalSeleccion = $totalSeleccion + $valores[$name];
                    }
                    if ($totalRebaja <> $totalSeleccion) {
                        $this->getUser()->setFlash('error', "Producto " . $reg->getDetalle() . " La sumatoria total seleccionada es diferente a la entregar");
                        $this->redirect('lista_entrega/entrega?id=' . $OperacionId);
                    }
                }

                foreach ($this->detalle as $reg) {
                    $totalRebaja = $reg->getTotalGeneral();
                    $totalSeleccion = 0;
//                    echo $reg->getProducto()->getNombre()."  ".$totalRebaja;
                    foreach ($reg->getDetallePro() as $de) {
                        $name = $de->getFechaVence('dmY') . "_" . $de->getProductoId(). "_" . $operacion->getTiendaId();
                        $cantidad = $valores[$name];
                        if ($cantidad > 0) {
                            $productoid = $de->getProductoId();
                            $fecha = $de->getFechaVence('Y-m-d');
                            for ($i = 1; $i <= $cantidad; $i++) {
                                $ivne = InventarioVenceQuery::create()
                                        ->filterByTiendaId($operacion->getTiendaId())
                                        ->filterByProductoId($productoid)
                                        ->filterByFechaVence($fecha)
                                        ->filterByDespachado(false)
                                        ->findOne();
                                $ivne->setOperacionNo($operacion->getId());
                                $ivne->setDespachado(true);
                                $ivne->save();
                            }
                        }
                    }
                }
                $operacion->setEstatus('Procesada');
                $operacion->save();
                $this->getUser()->setFlash('exito', "Productos entregados con exito");
                $this->redirect('lista_entrega/index?id=' . $OperacionId);
            }
        }
        // die();
    }

}
