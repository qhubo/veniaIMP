
<?php

class actualiza_precioActions extends sfActions {

    public function executeCarga(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
         $em=1;
        if (sfContext::getInstance()->getUser()->getAttribute('cajas', null, 'seleccion')) {
         $em=sfContext::getInstance()->getUser()->getAttribute('cajas', null, 'seleccion');
        }  
        $id = $request->getParameter('id');
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
//     echo "<pre>";
//     print_r($sheetData);
//     die();
        foreach ($sheetData as $registro) {
            $valido = false;
            $contador++;
            /// encabezado
            if ($contador == 2) {
                for ($i = 0; $i <= 3; $i++) {
                    $letra = sfContext::getInstance()->getUser()->numeroletra($i);
                    if (strtoupper(trim($registro[$letra])) == 'PRECIO') {
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
                }
            }
            if ($contador > 2) {
//                echo $columnaCantidad;
//                die();
//                
                if ((!$columnaCodigo) or (!$columnaCantidad)) {
                    sfContext::getInstance()->getUser()->setAttribute('carga', null, 'busqueda');
                    $this->getUser()->setFlash('error', ' Revisar archivo!! Nombre de una columna no fue econtrada: ' . strtoupper("código") . ", PRECIO ");
                    $this->redirect('actualiza_precio/index');
                }
                $codigo = 0;
                if (array_key_exists($columnaCodigo, $registro)) {
                    $codigo = $registro[$columnaCodigo];
                }
                $cantidad = 0;
                if (array_key_exists($columnaCantidad, $registro)) {
                    $cantidad = $registro[$columnaCantidad];
                }
//                echo "<pre>";
//                print_r($registro);
//                die();
                $cantidad = str_replace(",", "", $cantidad);
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
                $productoExiste = ProductoQuery::create()
                        ->filterByCodigoSku($codigo)
                        ->findOne();
                if ($productoExiste) {
                    $productoid = $productoExiste->getId();
                    $nombre = $productoExiste->getNombre();
                    $descripcion = $productoExiste->getTipoAparato()->getDescripcion();
                    $fechaPre = $productoExiste->getFechaPrecio();
                    $pro = $productoExiste->getPrecio();
                    $ante = $productoExiste->getPrecioAnterior();
                    if ($em==2) {
                      $pro = $productoExiste->getCostoProveedor();
                      $ante = $productoExiste->getCostoAnterior();
                    }
                    $valido = true;
                }
                $limcodigo = str_replace(" ", "", $codigo);
//                echo $cantidad;
//                echo "<br>";
                
                if (strtoupper($limcodigo) <> 'ULTIMALINEA') {
                    if (!$valido) {
                        $cantidad = 0;
                    }
                    $datos['Codigo'] = $codigo;
                    $datos['Cantidad'] = round($cantidad,2);
                    $datos['valido'] = $valido;
                    $datos['productoId'] = $productoid;
                    $datos['precio'] = $existencia;
                    $datos['nombre'] = $nombre;
                    $datos['anterior'] = $pro;
                    $datos['descripcion'] = $descripcion;
                    $datos['fecha'] = $fechaPre;
                    $linea[] = $datos;
                }
            }
        }

//        echo "<pre>";
//        print_r($linea);
//        die();

        sfContext::getInstance()->getUser()->setAttribute('carga', serialize($linea), 'busqueda');
        $this->getUser()->setFlash('exito', ' Archivo exportado con éxito ');
        $this->redirect('actualiza_precio/index');
    }

    
    
    public function executeReporteF(sfWebRequest $request) {
        $this->getResponse()->setContentType('text/html;charset=utf-8');
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "Modelo";
        $pestanas[] = "ACTUALIZA_INV";
        $nombre = "Modelo";
        $nombreEMpresa = $EmpresaQuery->getNombre();
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $filename = "Archivo_Carga_Precio_".date("Ymd");
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
            $encabezados = null;
        $encabezados[] = array("Nombre" => "CODIGO", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Nombre"), "width" => 60, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Precio"), "width" => 15, "align" => "left", "format" => "#,##0.00");

//        die();
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
        $pestanas[] = substr($EmpresaQuery->getNombre(), 0, 30);
        $nombre = "Modelo";
        $nombreEMpresa = $EmpresaQuery->getNombre();
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $filename = "Archivo_Carga_Precio_".date("Ymd");
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
//        $encabezados[] = array("Nombre" => strtoupper("Precio Actual"), "width" => 25, "align" => "left", "format" => "#,##0.00");
//
//   

     
        header("Content-Type: text/html;charset=utf-8");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeMuestra(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $em=1;
        if (sfContext::getInstance()->getUser()->getAttribute('cajas', null, 'seleccion')) {
         $em=sfContext::getInstance()->getUser()->getAttribute('cajas', null, 'seleccion');
        }  
        
        $prefijo = substr($em, 0,2);
//        echo $prefijo;
//       // echo $em;
//        die();
        
//        echo $em;
//        die();
        $id = $request->getParameter('id');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioq = UsuarioQuery::create()->findOneById($usuarioId);
        $this->forma = new NumeroPrecioProductoForm();
        $this->total = ProductoQuery::create()->filterByAfectoInventario(true)->count();
        $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodegaSele');
        $productoId = null;
        if ($request->isMethod('post')) {
            $this->forma->bind($request->getParameter("registro"), $request->getFiles("registro"));
            if ($this->forma->isValid()) {
                $ingresoIn = new PrecioProducto();
                $ingresoIn->setTipoNo($em);
                $ingresoIn->setUsuarioId($usuarioId);
                $ingresoIn->setTiendaId($bodegaId);
                $ingresoIn->setFecha(date('Y-m-d H:i:s'));
                $ingresoIn->save();
                $valores = $this->forma->getValues();
                $tipo_carga = $valores['tipo_carga'];
                sfContext::getInstance()->getUser()->setAttribute('muestrabusqueda', 0, 'busqueda');
                sfContext::getInstance()->getUser()->setAttribute('carga', null, 'busqueda');
                foreach ($valores as $clave => $valor) {
                    if ($valor > 0) {
                       // $valor =round($valor,2);
                        $clave = str_replace("numero_", "", $clave);
                        $productoQuery = ProductoQuery::create()->findOneById($clave);
                        $proceso="CambioPrecio";
                        if ($em==1) {
                         $proceso="CambioPrecio";
                        $anterior = $productoQuery->getPrecio();
                        $productoQuery->setPrecioAnterior($productoQuery->getPrecio());
                        $productoQuery->setPrecio($valor);
                        $productoQuery->save();
                      //  $obser = "Producto " . $productoQuery->getDescripcion() . " Precio Anterior: " . number_format($anterior, 2) . " Nuevo Precio: " . number_format($valor, 2);
                            
                        }
                        if ($em==2) {
                        $proceso="CambioCosto";
                         $anterior = $productoQuery->getCodigoProveedor();
                        $productoQuery->setCostoAnterior($anterior);
                        $productoQuery->setCostoProveedor($valor);
                        $productoQuery->save();
                    //    $obser = "Producto " . $productoQuery->getDescripcion() . " Precio Anterior: " . number_format($anterior, 2) . " Nuevo Precio: " . number_format($valor, 2);
                            
                        }
                        if ($prefijo =='LP') {
                            $listaPrecioId = str_replace($prefijo, "", $em);
                           $precionew= ProductoPrecioQuery::create()
                                    ->filterByListaPrecioId($listaPrecioId)
                                    ->filterByProductoId($clave)
                                    ->findOne();
                          if (!$precionew)  {
                            $precionew= new ProductoPrecio();
                            $precionew->setListaPrecioId($listaPrecioId);
                            $precionew->setProductoId($clave);
                            $precionew->save();    
                           }
                         $precionew->setValor($valor);
                         $precionew->save();
                        }
                        
                        $bitacora = New BitacoraCambio();
                        $bitacora->setUsuario($usuarioq->getUsuario());
                        $bitacora->setFecha(date('Y-m-d H:i:s'));
                        $bitacora->setRevisado(false);
                        $bitacora->setTipo($proceso);
                        $bitacora->setObservaciones($ingresoIn->getId());
                        $bitacora->save();

                        $detalle = new PrecioProductoDetalle();
                        $detalle->setProductoId($clave);
                        $detalle->setPrecio($valor);
                        $detalle->setPrecioProductoId($ingresoIn->getId());
                        $detalle->save();
                        $productoId[] = $clave;
                    }
                }

                $this->getUser()->setFlash('exito', ' Inventario actualizado con  éxito  ');
                $this->redirect('actualiza_precio/muestra?id=' . $ingresoIn->getId());
            }
        }

        $this->cabecera = PrecioProductoQuery::create()->findOneById($id);
        $this->bitacora = BitacoraCambioQuery::create()->findOneByObservaciones($id);
        $this->productos = PrecioProductoDetalleQuery::create()
                ->filterByPrecioProductoId($id)
                ->find();
//   echo "<pre>";
//   print_r($this->cabecera);
//   die();
//        
    }

    public function executeCantidad(sfWebRequest $request) {
        $cantidad = $request->getParameter('id');
        $productoId = $request->getParameter('idv');
        $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodegaSele');
        $productoQuer = ProductoQuery::create()->findOneById($productoId);
        $antes = 0;
        if ($productoQuer) {
            $antes = $productoQuer->getExistenciaBodega($bodegaId);
        }
        $retorna = $antes + $cantidad;
        $retorna = "<strong>" . $retorna . "</strong>";
        echo $retorna;
        die();
    }

    public function executeIndex(sfWebRequest $request) {
        $this->em=1;
        if ($request->getParameter('em')) {     
            sfContext::getInstance()->getUser()->setAttribute('cajas', $request->getParameter('em'), 'seleccion');
            sfContext::getInstance()->getUser()->setAttribute('carga', null, 'busqueda'); 
            $this->redirect('actualiza_precio/index');
        }
        if (sfContext::getInstance()->getUser()->getAttribute('cajas', null, 'seleccion')) {
         $this->em=sfContext::getInstance()->getUser()->getAttribute('cajas', null, 'seleccion');
        }
        $acceso = MenuSeguridad::Acceso('actualiza_precio');
        if (!$acceso) {
            $this->redirect('inicio/index');
            }
        $this->bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodegaSele');
        $this->bodega = TiendaQuery::create()->findOneById($this->bodegaId);
        $datos = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));
        $default['estatus'] = 2;
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
        $this->form = new consultaProductoPrecioForm($default);
        $this->total = ProductoQuery::create()->filterByActivo(true)->count();

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'consultaproducto');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));
                sfContext::getInstance()->getUser()->setAttribute('muestrabusqueda', 1, 'busqueda');
                sfContext::getInstance()->getUser()->setAttribute('carga', null, 'busqueda');
                $this->redirect('actualiza_precio/index?n=1');
            }
        }

        if ($valores) {
            $nombre = $valores['nombrebuscar']; // => 4555
            $tipo = $valores['tipo']; // => 4
            $marca = $valores['marca']; // => 
            $modelo = $valores['modelo']; // => 
            $estatus = $valores['estatus'];
            $operaciones = new ProductoQuery();
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
            $this->productos = $operaciones->find();
//            echo "<pre>";
//            print_r($this->productos);
//            echo "<pre>";
//            die();
        }
        $this->forma = new NumeroPrecioProductoForm ();
        if ($request->isMethod('post')) {
            $this->forma->bind($request->getParameter("registro"), $request->getFiles("registro"));
            if ($this->forma->isValid()) {
                $valores = $this->forma->getValues();
            }
        }
       
        $this->precios = ListaPrecioQuery::create()->filterByActivo(true)->orderByNombre()->find();
        
 
    }

}
