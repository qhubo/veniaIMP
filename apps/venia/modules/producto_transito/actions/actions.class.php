<?php

/**
 * producto_transito actions.
 *
 * @package    plan
 * @subpackage producto_transito
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class producto_transitoActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
          $this->prover = $request->getParameter('prover');
          
          if ( $this->prover ){ 
                 $this->productos = OrdenUbicacionQuery::create()
                         ->useProductoQuery()
                         ->endUse()
                   ->useOrdenVendedorQuery()
                    ->filterByVendedorId( $this->prover)
                      ->endUse()
                ->filterByCantidad(0, Criteria::GREATER_THAN)
                ->filterByOrdenVendedorId(0, Criteria::GREATER_THAN)
                ->find();
              
              
          } else {
        $this->productos = OrdenUbicacionQuery::create()
                        ->useProductoQuery()
                         ->endUse()
                ->filterByCantidad(0, Criteria::GREATER_THAN)
                ->filterByOrdenVendedorId(0, Criteria::GREATER_THAN)
                ->find();
          }
        $vendedores = VendedorQuery::create()->orderByNombre()->find();
        
          $seleccion = null;
        foreach ($vendedores as $registro) {
            $seleccion[$registro->getId()] = $registro->getNombre();
        }
         $this->seleccion = $seleccion;
         
//         echo "<pre>";
//         print_r($this->productos);
//         die();
        
    }

    public function executeModificarP(sfWebRequest $request) {
        error_reporting(-1);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $id = $request->getParameter('id');
        $cantida = $request->getParameter('cantidad');
        $ordenUbicacion = OrdenUbicacionQuery::create()->findOneById($id);
        $tiendaId = $ordenUbicacion->getTiendaUbica();
        $productoId = $ordenUbicacion->getProductoId();   
        $ubicacionId = $ordenUbicacion->getUbicacionId();
        $UbicacionProducto = ProductoUbicacionQuery::create()
                ->filterByTiendaId($tiendaId)
                ->filterByProductoId($productoId)
                ->filterByUbicacion($ubicacionId)
                ->findOne();
        ///--- restamos al pedido
        $nuevaCantida = $ordenUbicacion->getCantidad() - $cantida;
        $ordenUbicacion->setCantidad($nuevaCantida);
        $ordenUbicacion->save();
        if ($nuevaCantida < 0) {
            $ordenUbicacion->delete();
        }
        $nuevaCantidad = $UbicacionProducto->getCantidad() + $cantida;
        $nuevoTransito = $UbicacionProducto->getTransito() - $cantida;
       // $UbicacionProducto->setCantidad($nuevaCantidad);
        $UbicacionProducto->setTransito($nuevoTransito);
        $UbicacionProducto->save();
        $productoExistencia= ProductoExistenciaQuery::create()
                ->filterByTiendaId($tiendaId)
                ->filterByProductoId($productoId)
                ->findOne();
        if ($productoExistencia) {
            $inicial = $productoExistencia->getCantidad()-$productoExistencia->getTransito();
            $transito=$productoExistencia->getTransito()- $cantida;
            $productoExistencia->setTransito($transito);
            $productoExistencia->save();          
            $nuevoValor=$inicial+$cantida;
        }          
        $movimienoto = new ProductoMovimiento();
        $movimienoto->setTiendaId($tiendaId);
        $movimienoto->setProductoId($productoId);
        $movimienoto->setCantidad($cantida);
        $movimienoto->setIdentificador("PEDIDO ".$id);
        $movimienoto->setTipo('TRANSITO INGRESO');
        $movimienoto->setFecha(date('Y-m-d H:i:s'));
        $movimienoto->setMotivo("Retorno Transito");
        $movimienoto->setInicio($inicial);
        $movimienoto->setEmpresaId($empresaId);
        $movimienoto->setFin($nuevoValor);
        $movimienoto->save();
        $this->getUser()->setFlash('exito', 'Cantidad Actualizada con exito');
        $this->redirect('producto_transito/index');
    }

    
    public function executeReporte(sfWebRequest $request) {
      
        $this->getResponse()->setContentType('text/html;charset=utf-8');
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "Modelo";
        $pestanas[] = substr($EmpresaQuery->getNombre(), 0, 30);
        $nombre = "Modelo";
        $nombreEMpresa = $EmpresaQuery->getNombre();
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $filename = "Reporte de Productos en transito " . $nombreEMpresa . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->mergeCells("B1:D1");
        $fila = 2;
        $columna = 0;
        $hoja->getCell("A1")->setValueExplicit("PRODUCTOS EN TRANSITO", PHPExcel_Cell_DataType::TYPE_STRING);

        $encabezados = null;
        $encabezados[] = array("Nombre" => "Fecha", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Pedido", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Vendedor", "width" => 40, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Codigo", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Producto", "width" => 45, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" =>"Cantidad", "width" => 15, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => "Ubicacion", "width" => 30, "align" => "center", "format" => "@");
    

        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

     $this->prover = $request->getParameter('prover');
          
          if ( $this->prover ){ 
                 $productos = OrdenUbicacionQuery::create()
                   ->useOrdenVendedorQuery()
                    ->filterByVendedorId( $this->prover)
                      ->endUse()
                ->filterByCantidad(0, Criteria::GREATER_THAN)
                ->filterByOrdenVendedorId(0, Criteria::GREATER_THAN)
                ->find();
              
              
          } else {
        $productos = OrdenUbicacionQuery::create()
                ->filterByCantidad(0, Criteria::GREATER_THAN)
                ->filterByOrdenVendedorId(0, Criteria::GREATER_THAN)
                ->find();
          }
        
        foreach ($productos as $regis) { 
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $regis->getOrdenVendedor()->getFecha('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" =>  "PEDIDO " . $regis->getOrdenVendedorId());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regis->getOrdenVendedor()->getVendedor()->getNombre());
            $datos[] = array("tipo" => 3, "valor" =>$regis->getProducto()->getCodigoSku());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regis->getProducto()->getNombre());
            $datos[] = array("tipo" => 2, "valor" => $regis->getCantidad());
            $datos[] = array("tipo" => 3, "valor" => $regis->getUbicacionId());

            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;

//        $hoja->getCell("A" . $fila)->setValueExplicit("ULTIMA LINEA", PHPExcel_Cell_DataType::TYPE_STRING);
//        $hoja->mergeCells("B" . $fila . ":D" . $fila);
//        $hoja->getCell("B" . $fila)->setValueExplicit("----------------------------------------", PHPExcel_Cell_DataType::TYPE_STRING);
//        print_r($encabezados);
//        
//        die();
        header("Content-Type: text/html;charset=utf-8");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    
}
