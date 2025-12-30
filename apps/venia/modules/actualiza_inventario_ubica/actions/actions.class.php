<?php

class actualiza_inventario_ubicaActions extends sfActions {

    public function executeCarga(sfWebRequest $request) {
              date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        //     header('Content-type: text/plain; charset=utf-8');
        $bitacora = BitacoraArchivoQuery::create()->findOneById($id);
        sfContext::getInstance()->getUser()->setAttribute('muestrabusqueda', 0, 'busqueda');
        $filename = $bitacora->getNombre();
        $inputFileName = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . 'cargas' . DIRECTORY_SEPARATOR . $filename;

        $objReader = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $contador = 0;
        $columnaCodigo = null;
        $columnaCantidad = null;
        $columnaDescripcion = null;
        $columnaCategoria = null;
        $linea = null;
        $columnaCantidad = null;
        $columnaCodigo = null;
        $columnaUbica = null;


        foreach ($sheetData as $registro) {
            $valido = false;
            $contador++;
            /// encabezado
            if ($contador == 2) {
                for ($i = 0; $i <= 4; $i++) {
                    $letra = sfContext::getInstance()->getUser()->numeroletra($i);
                    if (strtoupper(trim($registro[$letra])) == 'CANTIDAD') {
                        $columnaCantidad = $letra;
                    }
                    if (strtoupper(trim($registro[$letra])) == strtoupper("código")) {
                        $columnaCodigo = $letra;
                    }
                    if (strtoupper(trim($registro[$letra])) == "CóDIGO") {
                        $columnaCodigo = $letra;
                    }
                    if (strtoupper(trim($registro[$letra])) == "CÓDIGO") {
                        $columnaCodigo = $letra;
                    }
                    if (strtoupper(trim($registro[$letra])) == "CODIGO") {
                        $columnaCodigo = $letra;
                    }
                    if (strtoupper(trim($registro[$letra])) == "UBICACION") {
                        $columnaUbica = $letra;
                    }
                    if (strtoupper(trim($registro[$letra])) == "UBICACIÓN") {
                        $columnaUbica = $letra;
                    }
                }
            }
            if ($contador > 2) {
                if ((!$columnaCodigo) or (!$columnaCantidad) or (!$columnaUbica)) {
                    sfContext::getInstance()->getUser()->setAttribute('carga', null, 'busqueda');
                    $this->getUser()->setFlash('error', ' Revisar archivo!! Nombre de una columna no fue econtrada: UBICACION, ' . strtoupper("código") . ", CANTIDAD ");
                    $this->redirect('actualiza_inventario_ubica/index');
                }

                $ubicacion = "xx";
                if (array_key_exists($columnaUbica, $registro)) {
                    $ubicacion = $registro[$columnaUbica];
                }

                $codigo = 0;
                if (array_key_exists($columnaCodigo, $registro)) {
                    $codigo = $registro[$columnaCodigo];
                }
                $cantidad = 0;
                if (array_key_exists($columnaCantidad, $registro)) {
                    $cantidad = $registro[$columnaCantidad];
                }
                if (!(is_numeric($cantidad))) {
                    $cantidad = 0;
                }
                if ($cantidad < 0) {
                    $cantidad = 0;
                }
                $productoid = null;
                $nombre = '';
                $descripcion = '';
                $existencia = 0;
                $tercero = false;
                $codigo = $registro['A'];
             
                $codigo = str_replace (" ", "", $codigo);
                $codigo =trim($codigo);

              //  $codigo = substr($codigo, 0, 30);

                $productoExiste = ProductoQuery::create()
                        ->filterByActivo(true)
                        ->where("REPLACE(Producto.CodigoSku, ' ', '') ='".$codigo."'")
                        //->filterByAfectoInventario(true)
                      //  ->filterByCodigoSku($codigo)
                        ->findOne();
                if ($productoExiste) {
                    $productoid = $productoExiste->getId();
                    $nombre = $productoExiste->getNombre();
                    $descripcion = $productoExiste->getTipoAparato()->getDescripcion(); //. " " . $productoExiste->getCampoBuscaCompleto();
                    $existencia = $productoExiste->getExistencia();
                    $valido = true;
                    $tercero = $productoExiste->getTercero();
                } else {
                   if ($codigo <> "") {
                                        $texto = "\n";
        $texto .=date('Y-m-d H:i:s'). " Producto no existe, ".$codigo;
        $ruta = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . "producto_pendiente.txt";
        $fh = fopen($ruta, 'a');
        fwrite($fh, $texto);
        fclose($fh);
        
//           echo "<pre>";
//       
//                   echo $codigo;
//                die();
                    }
        
                }
             
                $limcodigo = str_replace(" ", "", $codigo);
                if (trim($codigo) <> "") {
                    if (strtoupper($limcodigo) <> 'ULTIMALINEA') {
                        if (!$valido) {
                            $cantidad = 0;
                        }
                        $datos['Codigo'] = $codigo;
                        $datos['Cantidad'] = $cantidad;
                        $datos['valido'] = $valido;
                        $datos['productoId'] = $productoid;
                        $datos['existencia'] = $existencia;
                        $datos['nombre'] = $nombre;
                        $datos['descripcion'] = $descripcion;
                        $datos['fecha'] = date('d/m/Y');
                        $datos['descripcion'] = $descripcion;
                        $datos['ubicacion'] = $ubicacion;

                        $linea[$codigo][] = $datos;
                    }
                }
            }
        }

        sfContext::getInstance()->getUser()->setAttribute('carga', serialize($linea), 'busqueda');
        $linea=unserialize(sfContext::getInstance()->getUser()->getAttribute('carga', null, 'busqueda'));
//             echo "<pre>";
//        print_r($linea);
//        die();
//        
        $this->getUser()->setFlash('exito', ' Archivo exportado con éxito ');
        $this->redirect('actualiza_inventario_ubica/index');
    }

        public function executeReporteF(sfWebRequest $request) {
        $this->getResponse()->setContentType('text/html;charset=utf-8');
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "Modelo";
        $pestanas[] = "ACTUALIZA_PRECIO";
        $nombre = "Modelo";
        $nombreEMpresa = $EmpresaQuery->getNombre();
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $filename = "Archivo_Carga_precios_costos_" . $nombreEMpresa . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("TIPO DE ARCHIVO ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->getCell("B1")->setValueExplicit("Carga de inventario " . strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B1:D1");
        $fila = 2;
        $columna = 0;
        $encabezados = null;
       $encabezados[] = array("Nombre" => "CODIGO", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Nombre"), "width" => 60, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Precio"), "width" => 15, "align" => "left", "format" => "#,##0.00");
       sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));
    $productos = ProductoQuery::create()->orderByNombre()->find();
        foreach ($productos as $registro) {
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $registro->getCodigoSku());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getNombre());  // ENTERO
                 $datos[] = array("tipo" => 2, "valor" => $registro->getPrecio());  // ENTERO
            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;

        header("Content-Type: text/html;charset=utf-8");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }
    
    
    public function executeReporte(sfWebRequest $request) {
        $this->getResponse()->setContentType('text/html;charset=utf-8');
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "Modelo";
        $pestanas[] = "ACTUALIZA_INV";
        $nombre = "Modelo";
        $nombreEMpresa = $EmpresaQuery->getNombre();
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $filename = "Archivo_Carga_Existencia_" . $nombreEMpresa . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("TIPO DE ARCHIVO ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->getCell("B1")->setValueExplicit("Carga de inventario " . strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B1:D1");
        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $encabezados[] = array("Nombre" => "CODIGO", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Nombre"), "width" => 60, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("cantidad"), "width" => 15, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => "UBICACION", "width" => 20, "align" => "center", "format" => "@");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));

        $nombre = $valores['nombrebuscar']; // => 4555
        $tipo = $valores['tipo']; // => 4
        $marca = $valores['marca']; // => 
        $modelo = $valores['modelo']; // => 

        $operaciones = new ProductoQuery();
        $operaciones->filterByComboProductoId(null);
        $operaciones->filterByEmpresaId($empresaId);
        $operaciones->filterByActivo(true);

        if ($tipo) {
            $operaciones->filterByTipoAparatoId($tipo);
        }
        if ($marca) {
            $operaciones->filterByMarcaId($marca);
        }
        if ($modelo) {
            $operaciones->filterByModeloId($modelo);
        }
        if ($nombre <> "") {
            $operaciones->where(" (  codigo_barras like  '%" . $nombre . "%' or campo_busca like  '%" . $nombre . "%' or codigo_sku like  '%" . $nombre . "%')");
        }
        $operaciones->orderByCodigoSku();
        $productos = $operaciones->find();
        foreach ($productos as $registro) {
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $registro->getCodigoSku());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getNombre());  // ENTERO
            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;

        $hoja->getCell("A" . $fila)->setValueExplicit("ULTIMA LINEA", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B" . $fila . ":D" . $fila);
        $hoja->getCell("B" . $fila)->setValueExplicit("----------------------------------------", PHPExcel_Cell_DataType::TYPE_STRING);
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

    public function executeIndex(sfWebRequest $request) {
                date_default_timezone_set("America/Guatemala");
                error_reporting(-1);
//        $acceso = MenuSeguridad::Acceso('actualiza_inventario');
//        if (!$acceso) {
//            $this->redirect('inicio/index');
//        }
        $this->bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodegaSele');
        $this->bodega = TiendaQuery::create()->findOneById($this->bodegaId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $datos = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));
        $default['estatus'] = 2;
        $default['tienda'] = sfContext::getInstance()->getUser()->getAttribute("tienda", null, 'seguridad');
        $valores = null;
        if ($datos) {
            $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));
            $default = $valores;
        }
        $n = 0;
        if ($request->getParameter('n')) {
            $n = $request->getParameter('n');
        }
        if ($n == 0) {
            sfContext::getInstance()->getUser()->setAttribute('muestrabusqueda', 0, 'busqueda');
        }
        $this->form = new consultaProductoForm($default);
        $this->total = ProductoQuery::create()->filterByEmpresaId($empresaId)->filterByAfectoInventario(true)->filterByActivo(true)->count();
        $this->productos = ProductoQuery::create()->filterByEmpresaId($empresaId)->filterByAfectoInventario(true)->find();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'consultaproducto');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));
                sfContext::getInstance()->getUser()->setAttribute('muestrabusqueda', 1, 'busqueda');
                sfContext::getInstance()->getUser()->setAttribute('carga', null, 'busqueda');
                sfContext::getInstance()->getUser()->setAttribute("usuario", $valores['tienda'], 'bodegaSele');
                $this->bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodegaSele');
                $this->bodega = TiendaQuery::create()->findOneById($this->bodegaId);
                $this->redirect('actualiza_inventario_ubica/index?n=1');
            }
        }
        if ($valores) {
//            echo "<pre>";
//            print_r($valores);
//            echo "<pre>";
            $nombre = $valores['nombrebuscar']; // => 4555
            $tipo = $valores['tipo']; // => 4
            $marca = $valores['marca']; // => 
            $modelo = $valores['modelo']; // => 
            $estatus = $valores['estatus'];
            $operaciones = new ProductoQuery();
            $operaciones->filterByEmpresaId($empresaId);
            $operaciones->filterByActivo(true);
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
            if ($nombre <> "") {
                $operaciones->where(" (  codigo_barras like  '%" . $nombre . "%' or campo_busca like  '%" . $nombre . "%' or codigo_sku like  '%" . $nombre . "%')");
            }
            $operaciones->orderByCodigoSku();
            $this->productos = $operaciones->find();
        }
        foreach ($this->productos as $regi) {
            $default['fechaInicio_' . $regi->getId()] = date('d/m/Y');
        }       
         $default['fechaDocumento'] = date('d/m/Y');
        $this->forma = new CargaProductoUbiForm($default);
        if ($request->isMethod('post')) {
            $this->forma->bind($request->getParameter("registro"), $request->getFiles("registro"));
            if ($this->forma->isValid()) {
                $valores = $this->forma->getValues();
            }
        }
        $this->totalB = count($this->productos);
        $this->bodega = TiendaQuery::create()->findOneById($this->bodegaId);
        
       sfContext::getInstance()->getUser()->setAttribute('valores', null, 'procesa_productos');
    }

    public function executeMuestra(sfWebRequest $request) {
                date_default_timezone_set("America/Guatemala");
        $PROCESA_PRODUCTOS = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'procesa_productos'));
        
//        echo "<pre>";
//        print_r($PROCESA_PRODUCTOS);
//        die();
        $id = $request->getParameter('id');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $default['fechaInicio'] = date('d/m/Y');
        $this->forma = new CargaProductoUbiForm($default);
        $this->total = ProductoQuery::create()->filterByComboProductoId(null)->filterByAfectoInventario(true)->count();
        $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodegaSele');
        $productoId = null;
        if ($request->isMethod('post')) {
            $this->forma->bind($request->getParameter("registro"), $request->getFiles("registro"));
            if ($this->forma->isValid()) {
                $valores = $this->forma->getValues();
//                echo "<pre>";
//                print_r($PROCESA_PRODUCTOS);
//                     echo "<pre>";
//                print_r($valores);
//                die();
//                
                            $fechaInicio = $valores['fechaDocumento'];
                $fechaInicio = explode('/', $fechaInicio);
                $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
                
                
//                
                $ingresoIn = new IngresoProducto();
                $ingresoIn->setUsuarioId($usuarioId);
                $ingresoIn->setTiendaId($bodegaId);
                $ingresoIn->setFecha(date('Y-m-d H:i:s'));
                 $ingresoIn->setFechaDocumento($fechaInicio);
                  $ingresoIn->setObservaciones($valores['observaciones']);
                   $ingresoIn->setNumeroDocumento($valores['numero_documento']);
                            $ingresoIn->setNumeroOrden($valores['numero_orden']);
                $ingresoIn->save();
                $tipo_carga = $valores['tipo_carga'];
                sfContext::getInstance()->getUser()->setAttribute('muestrabusqueda', 0, 'busqueda');
                sfContext::getInstance()->getUser()->setAttribute('carga', null, 'busqueda');
               // foreach ($valores as $clave => $valor) {
                foreach ($PROCESA_PRODUCTOS as  $pref=>$producto_id) {
                    $valor =$valores["numero".$pref];
                    $UBICACION=$valores["ubica".$pref];
                    
//                    if ($producto_id==3929) {
//                        echo $pref;
//                        echo "<br>";
//                        echo $valor;
//                        echo "<br>";
//
//                        echo $UBICACION;
//                        echo "<br>";
//                        die();
//                        
//                    }
                   //   $valores
                    if ($valor <> 0) {
//                        $UBICACION = $valores[$CUbica];
//                        $valoresPr = explode('_',$clave);
//                        $producto_id =$valoresPr[1]; // str_replace("numero_", "", $clave);
                        $productoQuery = ProductoQuery::create()->findOneById($producto_id);
                        if ($productoQuery) {
                            if ($tipo_carga == "SI") {
                                $PROD = ProductoExistenciaQuery::create()->filterByProductoId($producto_id)->filterByTiendaId($bodegaId)->findOne();
                                if ($PROD) {
                                    $PROD->delete();
                                }
                                $PRODU_UBI= ProductoUbicacionQuery::create()->filterByUbicacion($UBICACION)->filterByTiendaId($bodegaId)->findOne();
                                if ($PRODU_UBI) {
                                    $PRODU_UBI->delete();
                                }
                                ProductoMovimientoQuery::Ingreso($producto_id, 0, 'ReIN' . $ingresoIn->getId(), "ReinicioInventario");
                            }
                            ProductoMovimientoQuery::Ingreso($producto_id, $valor, 'INGRESO ' . $ingresoIn->getNumeroDocumento(), "Ingreso Inventario", date("Y-m-d"), $bodegaId);
                            $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
                            ProductoExistenciaQuery::Actualiza($producto_id, $valor, $bodegaId);
                            $ListaProductos = ProductoExistenciaQuery::create()
                                    ->filterByEmpresaId($empresaId)
                                    ->filterByProductoId($producto_id)
                                    ->withColumn('sum(ProductoExistencia.Cantidad)', 'ValorTotal')
                                    ->findOne();
                            $nuevaExistencia = $ListaProductos->getValorTotal();
                            $productoQuery->setExistencia($nuevaExistencia);
                            $productoQuery->save();
                            $detalle = new IngresoProductoDetalle();
                            $detalle->setProductoId($producto_id);
                            $detalle->setCantidad($valor);
                            $detalle->setIngresoProductoId($ingresoIn->getId());
                            $detalle->setUbicacion($UBICACION);
                            $detalle->save();
                            
                            ProductoMovimientoPeer::MovimientoUBi($producto_id, $bodegaId, $UBICACION, $valor);
                            
                            $productoId[] = $producto_id;
                        }
                    }
                }
                
                       sfContext::getInstance()->getUser()->setAttribute('valores', null, 'procesa_productos');
                $this->getUser()->setFlash('exito', ' Inventario actualizado con  éxito  ');
                $this->redirect('actualiza_inventario_ubica/muestra?id=' . $ingresoIn->getId());
            }
                  $this->redirect('actualiza_inventario_ubica/index');
        }
        $this->cabecera = IngresoProductoQuery::create()->findOneById($id);
        $this->productos = IngresoProductoDetalleQuery::create()
                ->groupByProductoId()
                ->withColumn('sum(IngresoProductoDetalle.Cantidad)', 'ValorTotal')
                ->filterByIngresoProductoId($id)
                ->find();
    }

}
