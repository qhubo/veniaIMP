<?php

class reporte_portafolioActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
public function executeIndex(sfWebRequest $request){
    $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
    if (!$empresaId) {
          sfContext::getInstance()->getUser()->setAttribute('usuario', false, 'filtra_empresa');
    }
    // Productos que cumplen las condiciones del portafolio
    $this->productos = ProductoQuery::create()
        ->filterByActivo(true)
        ->filterByImagen('', Criteria::NOT_EQUAL)
        ->find();
    // Obtener existencia acumulada por producto
    $existencias = ProductoExistenciaQuery::create()
        ->withColumn('SUM(producto_existencia.cantidad)', 'existencia_total')
        ->groupByProductoId()
        ->find();
    // Convertir las existencias en un arreglo
    $this->existencias = array();
    foreach ($existencias as $existencia) {
        $this->existencias[$existencia->getProductoId()] = (float) $existencia->getVirtualColumn('existencia_total');
    }
    foreach ($this->productos as $key => $producto) {
        $productoId = $producto->getId();
        $existencia = isset($this->existencias[$productoId])
            ? $this->existencias[$productoId]
            : 0;
        if ($existencia <= 0) {
            unset($this->productos[$key]);
        }
    }

    $this->marcasVehiculo = array();
    foreach ($this->productos as $producto) {
        $productoId = $producto->getId();
        $marcasVehiculo = ProductoMarcaQuery::create()
            ->filterByProductoId($productoId)
            ->orderByMarca('Asc')
            ->find();
        $this->marcasVehiculo[$productoId] = array();
        foreach ($marcasVehiculo as $productoMarca) {
            $this->marcasVehiculo[$productoId][] = $productoMarca->getMarca();
        }
   }
   $this->marcas = $this->marcasVehiculo;
    sfContext::getInstance()->getUser()->setAttribute('usuario', false, 'filtra_empresa');

}

}
