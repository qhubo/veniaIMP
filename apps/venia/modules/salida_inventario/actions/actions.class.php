<?php

/**
 * salida_inventario actions.
 *
 * @package    plan
 * @subpackage salida_inventario
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class salida_inventarioActions extends sfActions {

    public function executeHistorial(sfWebRequest $request) {

        date_default_timezone_set("America/Guatemala");
//        $acceso = MenuSeguridad::Acceso('nota_credito');
//        if (!$acceso) {
//            $this->redirect('inicio/index');
//        }
        date_default_timezone_set("America/Guatemala");

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBanco', null, 'consulta'));
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('datoconsultaBanco', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaReporteCajaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsultaBanco', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBanco', null, 'consulta'));
                $this->redirect('salida_inventario/historial');
            }
        }
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '00:00';
        $valores['fin'] = '23:00';
        $this->operaciones = SalidaProductoQuery::create()
                ->orderByFechaDocumento("Desc")
                ->where("SalidaProducto.FechaDocumento  >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("SalidaProducto.FechaDocumento  <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->find();
    }

    public function executeReportePdf(sfWebRequest $request) {
        error_reporting(-1);
        $this->id = $request->getParameter("id");
        $pedidoVendedor = SalidaProductoQuery::create()->findOneById($this->id);
        $logo = $pedidoVendedor->getEmpresa()->getLogo();
        $logo = 'uploads/images/' . $logo;
        $NOMBRE_EMPRESA = $pedidoVendedor->getEmpresa()->getNombre();
        $DIRECCION = $pedidoVendedor->getEmpresa()->getDireccion();
        $TELEFONO = $pedidoVendedor->getEmpresa()->getTelefono();
        $detalle = OrdenUbicacionQuery::create()->filterBySalidaProductoId($this->id)->find();
        $html = $this->getPartial('salida_inventario/reporte', array(
            "logo" => $logo, 'NOMBRE_EMPRESA' => $NOMBRE_EMPRESA,
            'DIRECCION' => $DIRECCION, 'TELEFONO' => $TELEFONO,
            "operacion" => $pedidoVendedor, 'detalle' => $detalle,
        ));
        $pdf = new sfTCPDF("P", "mm", "Letter");

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle('Salida Producto ' . $pedidoVendedor->getCodigo());
        $pdf->SetSubject('Recibo');
        $pdf->SetKeywords('Recibo recibo'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetMargins(3, 5, 0, true);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetHeaderMargin(0.1);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont('dejavusans', '', 9);
        $pdf->AddPage();
        $pdf->Image($logo, 1, 8, 35, '', '', '', '100', false, 0);
        $pdf->writeHTML($html);



        $pdf->Output('Salida Producto ' . $pedidoVendedor->getCodigo() . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeMuestra(sfWebRequest $request) {
        error_reporting(-1);
        $id = $request->getParameter('id');
        $this->id = $id;
        $this->productos = OrdenUbicacionQuery::create()
                ->filterBySalidaProductoId($id)
                ->find();
    }

    public function executeConfirmar(sfWebRequest $request) {
        error_reporting(-1);
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $EmpresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $SAlidaPRO = SalidaProductoQuery::create()
                ->filterByUsuarioId($usuarioId)
                ->filterByEstatus('Proceso')
                ->findOne();
        if ($request->isMethod('post')) {
            $linea = unserialize(sfContext::getInstance()->getUser()->getAttribute('cargaSalida', null, 'busqueda'));



            foreach ($linea as $dete) {
                if ($dete['valido']) {
                    $cantidad = $request->getParameter('valor' . $dete['productoId']);
                    if ($cantidad > 0) {
                        $producto = ProductoQuery::create()->findOneById($dete['productoId']);
                        $SAlida = new SalidaProductoDetalle();
                        $SAlida->setSalidaProductoId($SAlidaPRO->getId());
                        $SAlida->setProductoId($dete['productoId']);
                        $SAlida->setCantidad($cantidad);
                        $SAlida->setDetalle($producto->getNombre());
                        $SAlida->setCodigo($producto->getCodigoSku());
                        $SAlida->setEmpresaId($SAlidaPRO->getEmpresaId());
                        $SAlida->setValor($producto->getPrecio());
                        $SAlida->setValorTotal($producto->getPrecio() * $cantidad);
                        $SAlida->save();
                        $producotUbicaion = ProductoUbicacionQuery::create()
                                ->useTiendaQuery()
                                ->filterByEmpresaId($empresaId)
                                ->endUse()
                                ->filterByProductoId($dete['productoId'])
                                ->filterByCantidad(0, Criteria::GREATER_THAN)
                                ->find();
                        $productoExistencia = null;
                        if (count($producotUbicaion) == 0) {

                            $productoExistencia = ProductoExistenciaQuery::create()
                                    ->useTiendaQuery()
                                    ->filterByEmpresaId($empresaId)
                                    ->endUse()
                                    ->filterByProductoId($dete['productoId'])
                                    ->findOne();
                        }

//                                     
                        // ** ubicacion
                        $SALDO = $cantidad;
                        foreach ($producotUbicaion as $ubica) {
                            $cantidaMaxima = $ubica->getCantidad() - $ubica->getTransito();
                            ///  echo '**'.$cantidaMaxima.'**';
                            if ($SALDO > 0) {
                                if ($cantidaMaxima > $SALDO) {
                                    $cantidadGRABA = $SALDO;
                                    $SALDO = 0;
                                } else {
                                    $cantidadGRABA = $cantidaMaxima;
                                    $SALDO = $SALDO - $cantidadGRABA;
                                }
                                $ubicac = new OrdenUbicacion();
                                $ubicac->setSalidaProductoId($SAlidaPRO->getId());
                                $ubicac->setTiendaId($ubica->getTiendaId());
                                $ubicac->setProductoId($ubica->getProductoId());
                                $ubicac->setUbicacionId($ubica->getUbicacion());
                                $ubicac->setCantidad($cantidadGRABA);
                                $ubicac->setTiendaUbica($ubica->getTiendaId());
                                $ubicac->save();
                            }
                        }
                        //** fin salida ubicacion
                        if ($productoExistencia) {
                            $ubicac = new OrdenUbicacion();
                            $ubicac->setSalidaProductoId($SAlidaPRO->getId());
                            $ubicac->setTiendaId($productoExistencia->getTiendaId());
                            $ubicac->setProductoId($productoExistencia->getProductoId());
                            $ubicac->setUbicacionId('');
                            $ubicac->setCantidad($SALDO);
                            $ubicac->setTiendaUbica($productoExistencia->getTiendaId());
                            $ubicac->save();
                        }
                    }
                }
            }
        }
        $PROCESADO = false;
        $ubicacionesPro = OrdenUbicacionQuery::create()
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->filterByProcesado(false)
                ->filterBySalidaProductoId($SAlidaPRO->getId())
                ->find();
        foreach ($ubicacionesPro as $lista) {
            $productoQuery = ProductoQuery::create()->findOneById($lista->getProductoId());
            $clave = $lista->getProductoId();
            ProductoMovimientoQuery::Salida($clave, $lista->getCantidad(), 'SALIDA', $lista->getTiendaUbica(), $SAlidaPRO->getCodigo() . "-" . $SAlidaPRO->getNumeroDocumento(), null, null);
            ProductoExistenciaQuery::Resta($clave, $lista->getCantidad(), $lista->getTiendaUbica());
            $ListaProductos = ProductoExistenciaQuery::create()
                    ->filterByEmpresaId($empresaId)
                    ->filterByProductoId($clave)
                    ->withColumn('sum(ProductoExistencia.Cantidad)', 'ValorTotal')
                    ->findOne();
            $nuevaExistencia = $ListaProductos->getValorTotal();
            $productoQuery->setExistencia($nuevaExistencia);
            $productoQuery->save();
            $ubicacActual = ProductoUbicacionQuery::create()
                    ->filterByUbicacion($lista->getUbicacionId())
                    ->filterByProductoId($lista->getProductoId())
                    ->filterByTiendaId($lista->getTiendaUbica())
                    ->findOne();
            if ($ubicacActual) {
                $PROCESADO = true;
                $existeActual = $ubicacActual->getCantidad();
                $nuevaCantidad = $existeActual - $lista->getCantidad();
                $ubicacActual->setCantidad($nuevaCantidad);
                $ubicacActual->save();
            }

            $lista->setProcesado(true);
            $lista->save();
        }
        //      die();

        sfContext::getInstance()->getUser()->setAttribute('cargaSalida', null, 'busqueda');
        // 04211-35020  10 3
        $SAlidaPRO->setEstatus('Confirmada');
        $SAlidaPRO->save();
        $this->getUser()->setFlash('exito', ' Salida de inventario realizada con exito ');
        $this->redirect('salida_inventario/muestra?id=' . $SAlidaPRO->getId());
    }

    public function executeCarga(sfWebRequest $request) {
        error_reporting(-1);
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
                    $this->redirect('salida_inventario/index');
                }
                $codigo = 0;
                if (array_key_exists($columnaCodigo, $registro)) {
                    $codigo = trim($registro[$columnaCodigo]);
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
                    $existencia = $productoExiste->getExistencia() - $productoExiste->getTransito();
                    $valido = true;
                    $tercero = $productoExiste->getTercero();
                }
                $limcodigo = str_replace(" ", "", $codigo);
                if (strtoupper($limcodigo) <> 'ULTIMALINEA') {
                    if (!$valido) {
                        $cantidad = 0;
                    }
                    if ($existencia < $cantidad) {
                        $valido = 0;
                        $nombre = $nombre . "  <font color='red'> EXISTENCIA ACTUAL " . $existencia . " ES MENOR </font> ";
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
        sfContext::getInstance()->getUser()->setAttribute('cargaSalida', serialize($linea), 'busqueda');
        $this->getUser()->setFlash('exito', ' Archivo exportado con éxito ');
        $this->redirect('salida_inventario/index');
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $acceso = MenuSeguridad::Acceso('actualiza_inventario');
//        if (!$acceso) {
//            $this->redirect('inicio/index');
//        }
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $EmpresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $SAlida = SalidaProductoQuery::create()
                ->filterByUsuarioId($usuarioId)
                ->filterByEstatus('Proceso')
                ->findOne();
        $default = null;
        $default['fechaInicio'] = date('d/m/Y');
        if ($SAlida) {
            $default['fechaInicio'] = $SAlida->getFechaDocumento('d/m/Y');
            $default['tienda'] = $SAlida->getTiendaId();
            $default['observaciones'] = $SAlida->getObservaciones();
            $default['documento'] = $SAlida->getNumeroDocumento();
        }
        $this->form = new salidaInventarioForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                if (!$SAlida) {
                    $SAlida = new SalidaProducto();
                    $SAlida->setUsuarioId($usuarioId);
                    $SAlida->setEstatus('Proceso');
                }

                $fechaInicio = $valores['fechaInicio'];
                $fechaInicio = explode('/', $fechaInicio);
                $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];

                $SAlida->setNumeroDocumento($valores['documento']);
                $SAlida->setFechaDocumento($fechaInicio);
                $SAlida->setObservaciones($valores['observaciones']);
                $SAlida->setTiendaId($valores['tienda']);
                $SAlida->setEmpresaId($empresaId);
                $SAlida->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado con exito');
                $this->redirect('salida_inventario/index?id=' . $SAlida->getId());
            }
        }
        $this->salida = $SAlida;
    }

    public function executeReporte(sfWebRequest $request) {
        $this->getResponse()->setContentType('text/html;charset=utf-8');
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "Modelo";
        $pestanas[] = "SALIDA INVENTARIO";
        $nombre = "Modelo";
        $nombreEMpresa = $EmpresaQuery->getNombre();
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $filename = "Archivo_salida_invetarios" . $nombreEMpresa . date("Ymd");
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
        header("Content-Type: text/html;charset=utf-8");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

}
