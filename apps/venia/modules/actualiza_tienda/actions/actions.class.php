<?php

/**
 * actualiza_tienda actions.
 *
 * @package    plan
 * @subpackage actualiza_tienda
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class actualiza_tiendaActions extends sfActions {
    

    

    public function executeCarga(sfWebRequest $request) {
        $id = $request->getParameter('id');
              date_default_timezone_set("America/Guatemala");
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
                }
            }
            if ($contador > 2) {
                if ((!$columnaCodigo) or (!$columnaCantidad)) {
                    sfContext::getInstance()->getUser()->setAttribute('carga', null, 'busqueda');
                    $this->getUser()->setFlash('error', ' Revisar archivo!! Nombre de una columna no fue econtrada: ' . strtoupper("código") . ", CANTIDAD ");
                    $this->redirect('actualiza_tienda_ubica/index');
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

                $codigo = substr($codigo, 0, 30);

                $productoExiste = ProductoQuery::create()
                        ->filterByActivo(true)
                        //->filterByAfectoInventario(true)
                        ->filterByCodigoSku($codigo)
                        ->findOne();
                if ($productoExiste) {
                    $productoid = $productoExiste->getId();
                    $nombre = $productoExiste->getNombre();
                    $descripcion = $productoExiste->getTipoAparato()->getDescripcion(); //. " " . $productoExiste->getCampoBuscaCompleto();
                    $existencia = $productoExiste->getExistencia();
                    $valido = true;
                    $tercero = $productoExiste->getTercero();
                }
                $limcodigo = str_replace(" ", "", $codigo);
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
                    $datos['fecha'] = date('d/m/Y');
                    $datos['descripcion'] = $descripcion;
                    $datos['tercero'] = $tercero;

                    $linea[] = $datos;
                }
            }
        }



        sfContext::getInstance()->getUser()->setAttribute('carga', serialize($linea), 'busqueda');
        $this->getUser()->setFlash('exito', ' Archivo exportado con éxito ');
        $this->redirect('actualiza_tienda/index');
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

        $acceso = MenuSeguridad::Acceso('actualiza_tienda');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }

        $this->bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodegaSele');

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
        $this->form = new consultaProductoActualiForm($default);
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
                $this->redirect('actualiza_tienda/index?n=1');
            }
        }

        if ($valores) {
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
//            echo "<pre>";
//            print_r($this->productos);
//            echo "<pre>";
//            die();
        }
        foreach ($this->productos as $regi) {
            $default['fechaInicio_' . $regi->getId()] = date('d/m/Y');
        }
        $this->forma = new NumeroProductoForm($default);

        if ($request->isMethod('post')) {
            $this->forma->bind($request->getParameter("registro"), $request->getFiles("registro"));
            if ($this->forma->isValid()) {
                $valores = $this->forma->getValues();
            }
        }
        $this->totalB = count($this->productos);

        $this->bodega = TiendaQuery::create()->findOneById($this->bodegaId);
    }

    public function executeMuestra(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $default['fechaInicio'] = date('d/m/Y');
        $this->forma = new NumeroProductoForm($default);
        $this->total = ProductoQuery::create()->filterByComboProductoId(null)->filterByAfectoInventario(true)->count();
        $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodegaSele');
        $productoId = null;
        if ($request->isMethod('post')) {
            $this->forma->bind($request->getParameter("registro"), $request->getFiles("registro"));
            if ($this->forma->isValid()) {
                $ingresoIn = new IngresoProducto();
                $ingresoIn->setUsuarioId($usuarioId);
                $ingresoIn->setTiendaId($bodegaId);
                $ingresoIn->setFecha(date('Y-m-d H:i:s'));
                $ingresoIn->save();
                $valores = $this->forma->getValues();
                $tipo_carga = $valores['tipo_carga'];
                sfContext::getInstance()->getUser()->setAttribute('muestrabusqueda', 0, 'busqueda');
                sfContext::getInstance()->getUser()->setAttribute('carga', null, 'busqueda');
                foreach ($valores as $clave => $valor) {
                    $graba = false;
                    if ($valor <> 0) {
                        $graba = true;
                    }
                    if ($tipo_carga == "SI") {
                        $graba = true;
                    }
                    if ($graba) {
                        $clave = str_replace("numero_", "", $clave);
                        $productoQuery = ProductoQuery::create()->findOneById($clave);
                        $productoExistencia = ProductoExistenciaQuery::create()->filterByProductoId($clave)->find();
                        foreach ($productoExistencia as $rego) {
                            $rego->delete();
                        }
                        $igreso = IngresoProductoDetalleQuery::create()->filterByProductoId($clave)->find();
                        foreach ($igreso as $lindata) {
                            $lindata->delete();
                        }

                        ProductoMovimientoQuery::Ingreso($clave, 0, 'ReIN' . $ingresoIn->getId(), "ReinicioInventario");
                        //  die();
                        ProductoMovimientoQuery::Ingreso($clave, $valor, 'IN' . $ingresoIn->getId(), "Ingreso Inventario", date("Y-m-d"), $bodegaId);
                        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
                        ProductoExistenciaQuery::Actualiza($clave, $valor, $bodegaId);
                        $ListaProductos = ProductoExistenciaQuery::create()
                                ->filterByEmpresaId($empresaId)
                                ->filterByProductoId($clave)
                                ->withColumn('sum(ProductoExistencia.Cantidad)', 'ValorTotal')
                                ->findOne();
                        $nuevaExistencia = $ListaProductos->getValorTotal();
                        $productoQuery->setExistencia($nuevaExistencia);
                        $productoQuery->save();
                        $detalle = new IngresoProductoDetalle();
                        $detalle->setProductoId($clave);
                        $detalle->setCantidad($valor);
                        $detalle->setIngresoProductoId($ingresoIn->getId());
                        $detalle->save();
                        $productoId[] = $clave;
                    }
                }
            }
            $this->getUser()->setFlash('exito', ' Inventario actualizado con  éxito  ');
            $this->redirect('actualiza_tienda/muestra?id=' . $ingresoIn->getId());
        }


        $this->cabecera = IngresoProductoQuery::create()->findOneById($id);
        $this->productos = IngresoProductoDetalleQuery::create()
                ->filterByIngresoProductoId($id)
                ->find();
    }

}
