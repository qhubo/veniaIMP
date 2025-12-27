<?php

/**
 * rpt_venta_producto actions.
 *
 * @package    plan
 * @subpackage rpt_venta_producto
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rpt_venta_productoActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'rptCategoria'));
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $bodegaId = $valores['bodega'];
        $fechaInicio = $fechaInicio;
        $fechaFin = $fechaFin;
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "REPORTE";
        $pestanas[] = 'Ventas Por Producto';
        $nombreEMpresa = $EmpresaQuery->getNombre();
//        $color = $EmpresaQuery->getColorUno();
//        $color = str_replace("#", "", $color);
        //   $styleArray = $EmpresaQuery->getEstiloExcel();
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $logoFile = $EmpresaQuery->getLogo();
        $filename = "VENTA_POR_PRODUCTO" . date("d_m_Y");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $hoja = $xl->setActiveSheetIndex(0);
        //CABECERA  Y FILTRO        
        $hoja->getRowDimension('1')->setRowHeight(15);
        $hoja->getRowDimension('2')->setRowHeight(20);
        $textoBusqueda = $this->textobusqueda($valores);
        $hoja->mergeCells("A1:A2");
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit("REPORTE", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(13);
        // $hoja->getStyle("B1")->applyFromArray($styleArray);
        $hoja->getCell("C1")->setValueExplicit("Reporte Ventas Por Producto ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C1")->getFont()->setBold(true);
        $hoja->getStyle("C1")->getFont()->setSize(10);

        $hoja->mergeCells("C1:E1");
        $hoja->getCell("B2")->setValueExplicit("Busqueda ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B2")->getFont()->setBold(true);
        $hoja->getStyle("B2")->getFont()->setSize(10);
        $hoja->getCell("C2")->setValueExplicit($textoBusqueda, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle('C2')->getAlignment()->setWrapText(true);
        $hoja->mergeCells("C2:G2");
        $fila = 3;
        $columna = 0;
        $encabezados = null;
        $encabezados[] = array("Nombre" => ("Tienda"), "width" => 22, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => ("Periodo"), "width" => 45, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => ("Codigo Sku"), "width" => 25, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => ("Nombre"), "width" => 30, "align" => "rigth", "format" => "#,##0");
        $encabezados[] = array("Nombre" => ("Descripción"), "width" => 45, "align" => "rigth", "format" => "#,##0");
        $encabezados[] = array("Nombre" => ("Unidad"), "width" => 20, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => ("Ventas"), "width" => 20, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => ("Costo Promedio"), "width" => 20, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => ("Precio Uni."), "width" => 20, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => ("Precio Total"), "width" => 20, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => ("Costo Total"), "width" => 15, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => ("Margen"), "width" => 15, "align" => "rigth", "format" => "#,##0.00");

        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

        $totalventa = 0;
        $totalCosto = 0;
        $movimiento = $this->datos();
        $Grantotal = 0;
        $tot = 0;
        if ($movimiento) {
            foreach ($movimiento as $tp) {
                $tot = $tp->getTotalMonto() + $tot;
            }
        }
        $Grantotal = $tot;
        foreach ($movimiento as $registro) {
   if ($registro->getProductoId()) { 
                            $valorCostoPromedio = ProductoQuery::ValorCostoPromedio ($bodegaId, $fechaInicio, $fechaFin, $registro->getProductoId()); 
                            $precioUNi = $registro->getTotalMonto() / $registro->getTotalCantidad(); 
                            $valorCosto = ProductoQuery::ValorCosto($bodegaId, $fechaInicio, $fechaFin, $registro->getProductoId()); 

                $fila++;
                $datos = null;

                $datos[] = array("tipo" => 3, "valor" => $registro->getOperacion()->getBodega()->getNombre());
                $datos[] = array("tipo" => 3, "valor" => $fechaInicio . " AL " . $fechaFin);
                $datos[] = array("tipo" => 3, "valor" => $registro->getProducto()->getCodigoSku());
                $datos[] = array("tipo" => 3, "valor" => $registro->getProducto()->getNombre());
                $datos[] = array("tipo" => 3, "valor" => $registro->getProducto()->getDescripcion());
                $datos[] = array("tipo" => 3, "valor" => $registro->getProducto()->getUnidadMedida());
                $datos[] = array("tipo" => 3, "valor" => round($registro->getTotalCantidad(), 2));
                $datos[] = array("tipo" => 3, "valor" => round($valorCostoPromedio, 2));
                $datos[] = array("tipo" => 3, "valor" => round($precioUNi, 2));
                $datos[] = array("tipo" => 3, "valor" => round($registro->getTotalMonto(), 2));
                $datos[] = array("tipo" => 3, "valor" => round($valorCosto, 2));
                $datos[] = array("tipo" => 3, "valor" => round($registro->getTotalMonto() - $valorCosto, 2));
                $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
            }
        }


//        $encabezados = null;
//        $encabezados[] = array("Nombre" => '', "width" => 22, "align" => "center", "format" => "@");
//        $encabezados[] = array("Nombre" => '', "width" => 45, "align" => "left", "format" => "#,##0");
//        $encabezados[] = array("Nombre" => '', "width" => 15, "align" => "center", "format" => "@");
//        $encabezados[] = array("Nombre" => 'TOTALES', "width" => 45, "align" => "rigth", "format" => "#,##0");
//        $encabezados[] = array("Nombre" => round($totalventa, 2), "width" => 20, "align" => "left", "format" => "#,##0.00");
//        $encabezados[] = array("Nombre" => round($totalCosto, 2), "width" => 20, "align" => "left", "format" => "#,##0");
//        $encabezados[] = array("Nombre" => '', "width" => 20, "align" => "left", "format" => "#,##0");
//        $encabezados[] = array("Nombre" => '', "width" => 20, "align" => "rigth", "format" => "#,##0.00");
//        $encabezados[] = array("Nombre" => '', "width" => 15, "align" => "rigth", "format" => "#,##0.00");
//
//        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);


        $fila++;

        $LetraFin = UsuarioQuery::numeroletra(10);
        $hoja->getCell("A" . $fila)->setValueExplicit("ULTIMA LINEA", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B" . $fila . ":" . $LetraFin . $fila);
        //  $color = str_replace("#", "", $color);
        //  $hoja->getStyle("A" . $fila)->applyFromArray($styleArray);
        //  $hoja->getStyle("B" . $fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($color);


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeIndex(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $UsuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'rptCategoria'));
        if (!$valores) {
            $valores['fechaInicio'] = date('01/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['bodega'] = $UsuarioQ->getBodegaId();
            $valores['tipo'] = sfContext::getInstance()->getUser()->getAttribute('tipo_id', null, 'seguridad');
            $valores['marca'] = sfContext::getInstance()->getUser()->getAttribute('marca_id', null, 'seguridad');
            sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'rptCategoria');
        }
        $default = $valores;
        $this->bodegas = BodegaQuery::create()->orderByNombre()->find();
        $this->form = new ConsultaListaPrecioForm($default);
        $this->total = ProductoQuery::create()->count();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'rptCategoria');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'rptCategoria'));
                sfContext::getInstance()->getUser()->setAttribute('tipo_id', $valores['tipo'], 'seguridad');
                sfContext::getInstance()->getUser()->setAttribute('marca_id', $valores['marca'], 'seguridad');
                $this->redirect('rpt_venta_producto/index');
            }
        }
        sfContext::getInstance()->getUser()->setAttribute('tipo_id', $valores['tipo'], 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('marca_id', $valores['marca'], 'seguridad');

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $this->bodegaId = $valores['bodega'];
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;


        $this->productos = $this->datos();

        $this->Grantotal = 0;
        $tot = 0;

        foreach ($this->productos as $tp) {
            $tot = $tp->getTotalMonto() + $tot;
        }
////                echo "<pre>";
////        print_r($this->productos);
//       die();
        $this->Grantotal = $tot;
    }

    public function textobusqueda() {
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'rptCategoria'));
        $textoBusqueda = 'Todo los productos';
        $Busqueda = null;
        foreach ($valores as $clave => $valor) {
            $clave = strtoupper($clave);
            if ($valor) {
                if ($clave == 'NOMBREBUSCAR') {
                    $Busqueda[] = ': ' . $valor;
                }
                if ($clave == 'TIPO') {
                    $query = TipoAparatoQuery::create()->findOneById($valor);
                    if ($query) {
                        $valor = $query->getDescripcion();
                    }
                    $Busqueda[] = strtoupper(TipoAparatoQuery::tipo()) . ": " . $valor;
                }
                if ($clave == 'MODELO') {
                    $query = ModeloQuery::create()->findOneById($valor);
                    if ($query) {
                        $valor = $query->getDescripcion();
                    }
                    $Busqueda[] = strtoupper(TipoAparatoQuery::modelo()) . ": " . $valor;
                }
//            if ($clave == 'BODEGA') {
//                $Busqueda[]='BUSQUEDA : '; 
//            }
                if ($clave == 'MARCA') {
                    $query = MarcaQuery::create()->findOneById($valor);
                    if ($query) {
                        $valor = $query->getDescripcion();
                    }
                    $Busqueda[] = strtoupper(TipoAparatoQuery::marca()) . ": " . $valor;
                }
            }
        }
        if ($Busqueda) {
            $textoBusqueda = implode(",", $Busqueda);
        }
        return $textoBusqueda;
    }

    public function datos() {
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'rptCategoria'));

        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

        $tipo = $valores['tipo']; // => 4
        $marca = $valores['marca']; // => 
        $operacionDetalleQ = new OperacionDetalleQuery();
        //  $operacionDetalleQ->filterByProductoId(Criteria::NOT_EQUAL,null);
        $operacionDetalleQ->useProductoQuery();
        $operacionDetalleQ->useOperacionQuery();
        $operacionDetalleQ->groupBy('Operacion.BodegaId');
        $operacionDetalleQ->groupBy('Producto.Id');
        if ($valores['bodega']) {
            $operacionDetalleQ->where("Operacion.BodegaId = " . $valores['bodega']);
        }
        if ($marca) {
            $operacionDetalleQ->where("Producto.MarcaId = " . $marca);
        }
        if ($tipo) {
            $operacionDetalleQ->where("Producto.TipoAparatoId = " . $tipo);
        }
        $operacionDetalleQ->withColumn('sum(OperacionDetalle.ValorTotal)', 'TotalMonto');
        $operacionDetalleQ->withColumn('sum(OperacionDetalle.Cantidad)', 'TotalCantidad');
        $operacionDetalleQ->where("Operacion.EmpresaId = " . $empresaId);
        $operacionDetalleQ->where("Operacion.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operacionDetalleQ->where("Operacion.Fecha  <= '" . $fechaFin . " 23:59:00" . "'");
        $operaQ = $operacionDetalleQ->find();

        return $operaQ;
    }

}
