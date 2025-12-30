<?php

/**
 * reporte_inventario actions.
 *
 * @package    plan
 * @subpackage reporte_inventario
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporte_inventarioActions extends sfActions {

    public function executeReporteUbicacion(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        error_reporting(-1);
//        $bodegas = TiendaQuery::create()->orderByNombre()->find();
        $bodegas = ProductoExistenciaQuery::create()->groupByTiendaId()->filterByEmpresaId($empresaId)->filterByCantidad(0, Criteria::GREATER_THAN)->find();
        $text = '';
        $file = fopen("uploads/reporteInventarioUbicacion" . $text . ".csv", "w");
        $file = "uploads/reporteInventario" . $text . ".csv";
        $this->getResponse()->setContentType('charset=utf-8');
        header('Expires: 0');
        header('Cache-control: private');
        header('Content-Type: application/x-octet-stream'); // Archivo de Excel
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
        header('Last-Modified: ' . date('D, d M Y H:i:s'));
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header("Content-Transfer-Encoding: binary");


        $encabezados = null;
        $encabezados[] = "Codigo Sku";
        $encabezados[] = "Nombre";
        $encabezados[] = "Tienda";
        $encabezados[] = "Grupo";
        $encabezados[] = "Ubicacion";
        $encabezados[] = "Cantidad";
        $Datos = implode(",", $encabezados);
        $Datos .= "\r\n";
//        echo $Datos;
//        die();


        $datosR = $this->datos();
        foreach ($datosR as $lista) {

            $bodegas = ProductoExistenciaQuery::create()->filterByProductoId($lista->getId())->filterByCantidad(0, criteria::GREATER_THAN)->find();
            foreach ($bodegas as $bode) {
                $ubicaciones = ProductoUbicacionQuery::create()->filterByTiendaId($bode->getTiendaId())->filterByCantidad(0, criteria::GREATER_THAN)->filterByProductoId($lista->getId())->find();
                foreach ($ubicaciones as $registr) {

                    $datos = null;
                    $datos[] = "'" . str_replace(",", "", $lista->getCodigoSku());  // ENTERO
                    $datos[] = str_replace(",", "", $lista->getNombre());  // ENTERO
                    $apar = TipoAparatoQuery::create()->findOneById($lista->getTipoAparatoId());
                    if ($apar) {
                        $datos[] = str_replace(",", "", $apar->getDescripcion()); //->getDescripcion();  // ENTERO    
                    } else {
                        $datos[] = $lista->getTipoAparatoId(); //->getDescripcion();  // ENTERO
                    }
                    $datos[] = $registr->getTienda()->getNombre();
                    $datos[] = $registr->getUbicacion();
                    $datos[] = $registr->getCantidad();
                    $lineas = implode(",", $datos);
                    $Datos .= $lineas;
                    $Datos .= "\r\n";
                }
            }
        }
        echo $Datos;
        die();
    }

    public function executeReporte(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        error_reporting(-1);
//        $bodegas = TiendaQuery::create()->orderByNombre()->find();
        $bodegas = ProductoExistenciaQuery::create()->groupByTiendaId()->filterByEmpresaId($empresaId)->filterByCantidad(0, Criteria::GREATER_THAN)->find();
        $text = '';
        $file = fopen("uploads/reporteInventario" . $text . ".csv", "w");
        $file = "reporteInventario" . $text . ".csv";
        $this->getResponse()->setContentType('charset=utf-8');
        header('Expires: 0');
        header('Cache-control: private');
        header('Content-Type: application/x-octet-stream'); // Archivo de Excel
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
        header('Last-Modified: ' . date('D, d M Y H:i:s'));
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header("Content-Transfer-Encoding: binary");
        $listaPrecio = ListaPrecioQuery::create()->find();


        $encabezados = null;
        $encabezados[] = "Codigo Sku";
        $encabezados[] = "Nombre";
        $encabezados[] = "Grupo";
        foreach ($bodegas as $data) {
            $bode = $data->getTienda();
            $encabezados[] = strtoupper($bode);
        }
        $encabezados[] = strtoupper("Precio");
        $encabezados[] = strtoupper("Costo");
        foreach ($listaPrecio as $dtPrecio) {
            $encabezados[] = strtoupper($dtPrecio->getNombre());
        }

        $Datos = implode(",", $encabezados);
        $Datos .= "\r\n";
        $datosR = $this->datos();
        foreach ($datosR as $lista) {
            $datos = null;
            $datos[] = "'" . str_replace(",", "", $lista->getCodigoSku());  // ENTERO
            $datos[] = str_replace(",", "", $lista->getNombre());  // ENTERO
            $apar = TipoAparatoQuery::create()->findOneById($lista->getTipoAparatoId());
            if ($apar) {
                $datos[] = str_replace(",", "", $apar->getDescripcion()); //->getDescripcion();  // ENTERO    
            } else {
                $datos[] = $lista->getTipoAparatoId(); //->getDescripcion();  // ENTERO
            }
            foreach ($bodegas as $data) {
                $bode = $data->getTienda();
                $datos[] = $lista->getExistenciaBodega($bode->getId());  // ENTERO
            }
            $datos[] = round($lista->getPrecio(), 2);  // ENTERO
            $datos[] = round($lista->getCostoProveedor(), 2);  // ENTERO
             foreach ($listaPrecio as $dtPrecio) {
                    $datos[] = round($lista->getPrecioLista($dtPrecio->getId()), 2);  // ENTERO 
             }
            $lineas = implode(",", $datos);
            $Datos .= $lineas;
            $Datos .= "\r\n";
        }
        echo $Datos;
        die();
    }

    public function executeReportex(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        // $bodegas = TiendaQuery::create()->orderByNombre()->find();
        $bodegas = ProductoExistenciaQuery::create()->groupByTiendaId()->filterByEmpresaId($empresaId)->filterByCantidad(0, Criteria::GREATER_THAN)->find();
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "Modelo";
        $pestanas[] = 'Detalle_Iventario';
        $pestanas[] = 'Vencimiento';
        $nombre = "Modelo";
        $nombreEMpresa = $EmpresaQuery->getNombre();
        // $color = $EmpresaQuery->getColor();
        $color = '';
        $color = str_replace("#", "", $color);
        //  $styleArray = $EmpresaQuery->getEstiloExcel();
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
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit(strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(13);
//        $hoja->getStyle("B1")->applyFromArray($styleArray);
        $hoja->getCell("C1")->setValueExplicit("Reporte Inventario ", PHPExcel_Cell_DataType::TYPE_STRING);
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
        $encabezados[] = array("Nombre" => strtoupper("Codigo Sku"), "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Nombre"), "width" => 40, "align" => "left", "format" => "#,##0.00");
//        $encabezados[] = array("Nombre" => strtoupper(TipoAparatoQuery::tipo()), "width" => 20, "align" => "left", "format" => "#,##0");
//        $encabezados[] = array("Nombre" => strtoupper(TipoAparatoQuery::marca()), "width" => 20, "align" => "center", "format" => "@");
        foreach ($bodegas as $data) {
            $bode = $data->getTienda();
            $encabezados[] = array("Nombre" => strtoupper($bode), "width" => 20, "align" => "left", "format" => "#,##0");
        }
        $encabezados[] = array("Nombre" => strtoupper("Precio"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Costo"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $datosR = $this->datos();
        foreach ($datosR as $lista) {
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => "'" . $lista->getCodigoSku());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $lista->getNombre());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $lista->getTipoAparato()->getDescripcion());  // ENTERO
//           if ($lista->getMarcaId()) {
//            $datos[] = array("tipo" => 3, "valor" => $lista->getMarca()->getDescripcion());  // ENTERO
//           } else {
//                $datos[] = array("tipo" => 3, "valor" => '');
//           }
            foreach ($bodegas as $data) {
                $bode = $data->getTienda();
                $datos[] = array("tipo" => 2, "valor" => $lista->getExistenciaBodega($bode->getId()));  // ENTERO
                $canf = $lista->getExistenciaBodega($bode->getId());
            }
            $datos[] = array("tipo" => 1, "valor" => round($lista->getPrecio(), 2));  // ENTERO
            $datos[] = array("tipo" => 1, "valor" => round($lista->getCostoProveedor(), 2));  // ENTERO
            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }

        $LetraFin = UsuarioQuery::numeroletra(6);
        $hoja->getCell("A" . $fila)->setValueExplicit("ULTIMA LINEA", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B" . $fila . ":" . $LetraFin . $fila);
        $color = str_replace("#", "", $color);
        $hoja->getStyle("B" . $fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($color);

        ////*** PAGINA DOS
        $hoja = $xl->setActiveSheetIndex(1);
        //CABECERA  Y FILTRO        
        $hoja->getRowDimension('1')->setRowHeight(15);
        $hoja->getRowDimension('2')->setRowHeight(20);
        $textoBusqueda = $this->textobusqueda();
        $hoja->mergeCells("A1:A2");
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit(strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(13);
//        $hoja->getStyle("B1")->applyFromArray($styleArray);
        $hoja->getCell("C1")->setValueExplicit("Reporte Inventario con vencimiento ", PHPExcel_Cell_DataType::TYPE_STRING);
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
        $encabezados[] = array("Nombre" => strtoupper("Codigo Sku"), "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Nombre"), "width" => 40, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper(TipoAparatoQuery::tipo()), "width" => 20, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper(TipoAparatoQuery::marca()), "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Vencimiento"), "width" => 20, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Bodega"), "width" => 24, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Cantidad"), "width" => 18, "align" => "right", "format" => "#,##0");

        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $datosR = $this->datosVENCE();
        foreach ($datosR as $lista) {
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => "'" . $lista->getProducto()->getCodigoSku());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $lista->getProducto()->getNombre());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $lista->getProducto()->getTipoAparato()->getDescripcion());  // ENTERO
            if ($lista->getProducto()->getMarcaId()) {
                $datos[] = array("tipo" => 3, "valor" => $lista->getProducto()->getMarca()->getDescripcion());  // ENTERO
            } else {
                $datos[] = array("tipo" => 3, "valor" => '');
            }
            $datos[] = array("tipo" => 1, "valor" => $lista->getFechaVence());  // ENTERO
            $datos[] = array("tipo" => 1, "valor" => $lista->getTienda()->getNombre());  // ENTERO

            $datos[] = array("tipo" => 1, "valor" => $lista->getTotalGeneral());  // ENTERO
            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }

        $LetraFin = UsuarioQuery::numeroletra(6);
        $hoja->getCell("A" . $fila)->setValueExplicit("ULTIMA LINEA", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B" . $fila . ":" . $LetraFin . $fila);
        $color = str_replace("#", "", $color);
        $hoja->getStyle("B" . $fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($color);





        $hoja = $xl->setActiveSheetIndex(0);

        header("Content-Type: text/html;charset=utf-8");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        $datos = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaInventa'));
        $default['bodega'] = $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodega');
        $valores = null;
        if ($datos) {
            $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaInventa'));
            $default = $valores;
        }
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');

        //$this->bodegas = TiendaQuery::create()->orderByNombre()->find();
        $this->bodegas = ProductoExistenciaQuery::create()->groupByTiendaId()->filterByEmpresaId($empresaId)->filterByCantidad(0, Criteria::GREATER_THAN)->find();

        $this->form = new consultaProductoInventarioForm($default);
        // $this->total = ProductoQuery::create()->filterByComboProductoId(null)->count();
        //$this->productos = ProductoQuery::create()->find();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'consultaInventa');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaInventa'));
            }
        }
        if ($valores) {
            if ($valores['bodega']) {
                $this->bodegas = ProductoExistenciaQuery::create()->filterByTiendaId($valores['bodega'])->groupByTiendaId()->find(); //TiendaQuery::create()->filterById($valores['bodega'])->find();
            }
        }
        $this->productos = $this->datos();
        $this->totalB = count($this->productos);
        //$this->productosVence = $this->datosVENCE();

        $this->listaPrecio = ListaPrecioQuery::create()->find();


//    echo "<pre>";
//    print_r($this->productosVence);
//    die();
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

    public function datosVENCE() {
        $productos = null;
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaInventa'));
        if ($valores) {
            $nombre = $valores['nombrebuscar']; // => 4555
            $tipo = $valores['tipo']; // => 4
            $marca = $valores['marca']; // => 
            $modelo = $valores['modelo']; // => 
            ///
            //   $estatus = $valores['estatus'];
            $operaciones = new InventarioVenceQuery();
            $operaciones->filterByDespachado(false);
            $operaciones->groupByFechaVence();
            $operaciones->groupByTiendaId();
            $operaciones->groupByProductoId();
            $operaciones->withColumn('count(InventarioVence.Id)', 'TotalGeneral');
            $operaciones->useProductoQuery();
//            if ($tipo) {
//                $operaciones->filterByTipoAparatoId($tipo);
//            }
//            if ($marca) {
//                $operaciones->filterByMarcaId($marca);
//            }
//            if ($modelo) {
//                $operaciones->filterByModeloId($modelo);
//            }
            $operaciones->where(" ( Producto.Nombre like  '%" . $nombre . "%' or Producto.CodigoSku like  '%" . $nombre . "%'  or Producto.Descripcion like  '%" . $nombre . "%')");
            $productos = $operaciones->find();
        }
        return $productos;
    }

    public function datos() {
        $productos = null;
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaInventa'));
        if ($valores) {
            $nombre = $valores['nombrebuscar']; // => 4555
            $tipo = $valores['tipo']; // => 4
            $marca = $valores['marca']; // => 
            $modelo = $valores['modelo']; // => 
            //   $estatus = $valores['estatus'];
            $operaciones = new ProductoQuery();
            $operaciones->filterByComboProductoId(null);
            if ($tipo) {
                $operaciones->filterByTipoAparatoId($tipo);
            }
            if ($marca) {
                $operaciones->filterByMarcaId($marca);
            }
            if ($modelo) {
                $operaciones->filterByModeloId($modelo);
            }
            // $operaciones->where(" ( nombre like  '%" . $nombre . "%' or codigo_sku like  '%" . $nombre . "%'  or descripcion like  '%" . $nombre . "%')");
            $productos = $operaciones->find();
        }
        return $productos;
    }

}
