<?php

/**
 * rpt_producto_valores actions.
 *
 * @package    plan
 * @subpackage rpt_producto_valores
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rpt_producto_valoresActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeReporte(sfWebRequest $request) {
        $bodegas = BodegaQuery::create()->orderByNombre()->find();
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "Modelo";
        $pestanas[] = 'Detalle_Iventario';
        $nombre = "Modelo";
        $nombreEMpresa = $EmpresaQuery->getNombre();
        // $color = $EmpresaQuery->getColor();
        $color = '';
        $color = str_replace("#", "", $color);
   
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $logoFile = $EmpresaQuery->getLogo();
        $filename = "Inventario_" . $nombreEMpresa . date("d_m_Y");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        //CABECERA  Y FILTRO        
        $hoja->getRowDimension('1')->setRowHeight(15);
        $hoja->getRowDimension('2')->setRowHeight(20);
        $textoBusqueda = $this->textobusqueda();
        $hoja->mergeCells("A1:A2");
//        $obj = new PHPExcel_Worksheet_Drawing();
//        $obj->setName("Logo");
//        $obj->setDescription("Logo");
//        $obj->setPath("./uploads/empresas/" . $logoFile);
//        $obj->setCoordinates("A1");
//        $obj->setHeight(48);
//        $obj->setWorksheet($hoja);
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit(strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(13);
//        $hoja->getStyle("B1")->applyFromArray($styleArray);
        $hoja->getCell("C1")->setValueExplicit("Reporte Producto valores ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C1")->getFont()->setBold(true);
        $hoja->getStyle("C1")->getFont()->setSize(10);

        $hoja->mergeCells("C1:E1");
        $hoja->getCell("B2")->setValueExplicit("Busqueda ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B2")->getFont()->setBold(true);
        $hoja->getStyle("B2")->getFont()->setSize(10);
        $hoja->getCell("C2")->setValueExplicit($textoBusqueda, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle('C2')->getAlignment()->setWrapText(true);
        $hoja->mergeCells("C2:E2");
        $fila = 3;
        $columna = 0;
        $encabezados = null;
         $encabezados[] = array("Nombre" => strtoupper("Categoria"), "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("SubCategoria"), "width" => 25, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Codigo Sku"), "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Nombre"), "width" => 30, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Descripcion"), "width" => 40, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Unidad"), "width" => 20, "align" => "center", "format" => "@");
         $encabezados[] = array("Nombre" => strtoupper("Precio"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Unidad Costo"), "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Costo"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $hoja->getStyle("A" . $fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($color);
        $datos = $this->datos();
        foreach ($datos as $regis) {
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $regis->getTipoAparato());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regis->getMarca());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regis->getCodigoSku());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regis->getNombre());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regis->getDescripcion());  // ENTERO
            $datos[] = array("tipo" => 1, "valor" => $regis->getUnidadMedida());  // ENTERO
            $datos[] = array("tipo" => 1, "valor" => round(($regis->getPrecio()), 2));  // ENTERO
            $datos[] = array("tipo" => 1, "valor" => $regis->getUnidadMedidaCosto());  // ENTERO
            $datos[] = array("tipo" => 1, "valor" => round($regis->getCostoProveedor(), 2));  // ENTERO
       
            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;

        $LetraFin = UsuarioQuery::numeroletra(8);
        $hoja->getCell("A" . $fila)->setValueExplicit("ULTIMA LINEA", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B" . $fila . ":" . $LetraFin . $fila);
        $color = str_replace("#", "", $color);
     //   $hoja->getStyle("A" . $fila)->applyFromArray($styleArray);
        $hoja->getStyle("B" . $fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($color);

        header("Content-Type: text/html;charset=utf-8");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeIndex(sfWebRequest $request) {
            $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
     
        $datos = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaInventa'));
        $default['bodega'] = $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodega');
        $valores = null;
        if ($datos) {
            $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaInventa'));
            $default = $valores;
        }
        $this->bodegas = BodegaQuery::create()->orderByNombre()->find();
        $this->form = new consultaProductoInventarioForm($default);
        $this->total = ProductoQuery::create()->count();
        $this->productos = ProductoQuery::create()->find();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'consultaInventa');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaInventa'));
            }
        }
        
             sfContext::getInstance()->getUser()->setAttribute('tipo_id', $valores['tipo'], 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('marca_id', $valores['marca'], 'seguridad');

        

        $this->productos = $this->datos();
        $this->totalB = count($this->productos);
    }

    public function textobusqueda() {
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaInventa'));
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
        $productos = null;
            $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
     
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaInventa'));
        if ($valores) {
            $nombre = $valores['nombrebuscar']; // => 4555
            $tipo = $valores['tipo']; // => 4
            $marca = $valores['marca']; // => 
            $modelo = $valores['modelo']; // => 
            //   $estatus = $valores['estatus'];
            $operaciones = new ProductoQuery();
            $filtro=false;
            if ($tipo) {
                $filtro=true;
                $operaciones->filterByTipoAparatoId($tipo);
            }
            if ($marca) {
                $filtro=true;
                $operaciones->filterByMarcaId($marca);
            }
            if ($modelo) {
                $filtro=true;
                $operaciones->filterByModeloId($modelo);
            }
            $operaciones->filterByEmpresaId($empresaId);
            if ($nombre <>"") {
                
                $filtro=true;
            $operaciones->where(" ( campo_busca like  '%" . $nombre . "%' or codigo_sku like  '%" . $nombre . "%')");
            }
            if ($filtro) {
            $productos = $operaciones->find();
            }
        }
        return $productos;
    }

}
