<?php


class orden_compraActions extends sfActions {

        public function executeCosto(sfWebRequest $request) {
        $valor = $request->getParameter('id');
        $ListaId = $request->getParameter('idv');
        $listaProducto = OrdenProveedorDetalleQuery::create()
                ->filterById($ListaId)
                ->findOne();
        $listaProducto->setCostoPromedio($valor);
        $listaProducto->save();
        echo "actualizado " . $valor;
        die();
    }

    public function executeCarga(sfWebRequest $request) {
           error_reporting(-1);
        $ordenId = sfContext::getInstance()->getUser()->getAttribute('OrdenId', null, 'seguridad');
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
        $columnaValor = null;
//
//        $linea = null;
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
                    $valor = str_replace(" ", "", strtoupper(trim($registro[$letra])));
                    if ($valor == 'CANTIDAD') {
                        $columnaCantidad = $letra;
                    }
                    if ($valor == strtoupper("código")) {
                        $columnaCodigo = $letra;
                    }
                    if ($valor == "CóDIGO") {
                        $columnaCodigo = $letra;
                    }
                    if ($valor == "CÓDIGO") {
                        $columnaCodigo = $letra;
                    }
                    if ($valor == "CODIGO") {
                        $columnaCodigo = $letra;
                    }
                    if ($valor == "VALORUNITARIO") {
                        $columnaValor = $letra;
                    }
                }
            }
            if ($contador > 2) {
                if ((!$columnaCodigo) or (!$columnaCantidad) or (!$columnaValor)) {
                    sfContext::getInstance()->getUser()->setAttribute('carga', null, 'busqueda');
                    $this->getUser()->setFlash('error', ' Revisar archivo!! Nombre de una columna no fue econtrada: ' . strtoupper("código") . ", CANTIDAD, VALOR UNITARIO ");
                    $this->redirect('orden_compra/index?id=' . $ordenId);
                }
                $codigo = "";
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
                $valorUnitario = 0;
//                echo $columnaValor;
//                die();
                if (array_key_exists($columnaValor, $registro)) {
                    $valorUnitario = $registro[$columnaValor];
                }
                if (!(is_numeric($valorUnitario))) {
                    $valorUnitario = 0;
                }
                if ($valorUnitario < 0) {
                    $valorUnitario = 0;
                }
                
                $productoExiste = ProductoQuery::create()
                        ->filterByCodigoSku($codigo)
                        ->findOne();
//                echo $codigo." ".$valorUnitario;
//                echo "<pre>";
//                print_r($productoExiste);
//                die();
                if ($productoExiste) {
                    $productoid = $productoExiste->getId();
                    if (($valorUnitario > 0) & ($cantidad > 0)) {
                  
                        $ordenQ = new OrdenProveedorDetalle();
                        $ordenQ->setCantidad(1);
                        $ordenQ->setProductoId($productoExiste->getId());
                        $ordenQ->setDetalle($productoExiste->getNombre());
                        $ordenQ->setCodigo($productoExiste->getCodigoSku());
                        $ordenQ->setCantidad($cantidad);
                        $ordenQ->setValorTotal(round($cantidad * $valorUnitario, 2));
                        $ordenQ->setValorUnitario($valorUnitario);
                        $ordenQ->setTotalIva(0);
                        $ordenQ->setOrdenProveedorId($ordenId);
                        $ordenQ->save();
                    }
                }
            }
        }

        
       $ordenProveedor = OrdenProveedorQuery::create()->findOneById($ordenId);
   $lista = OrdenProveedorDetalleQuery::create()
                ->withColumn('sum(OrdenProveedorDetalle.ValorTotal)', 'TotalGeneral')
                ->filterByOrdenProveedorId($ordenId)
                ->findOne();
        if ($lista) {
            $suma = $lista->getTotalGeneral();

            $valores = ParametroQuery::ObtenerIva($suma, false,false, false, '');
            $iva = $valores['IVA'];
            $valorSInIVa = $valores['VALOR_SIN_IVA'];
        }
        $retorna = "<strong>" . number_format($retorna, 2) . "</strong>";
        $retorna .= '|' . number_format($suma, 2) . "|" . number_format($iva, 2) . "|" . number_format($valorSInIVa, 2);
        $ordenProveedor->setSubTotal($suma);
        $ordenProveedor->setValorTotal($suma);
        $ordenProveedor->setIva(0);
        $ordenProveedor->setValorIsr($valores['VALOR_ISR']);
        $ordenProveedor->setValorRetieneIva($valores['VALOR_RETIENE_IVA']);
        $ordenProveedor->save();
        $this->getUser()->setFlash('exito', ' Archivo exportado con éxito ');
        $this->redirect('orden_compra/index?id=' . $ordenId);
    }

    public function executeReporte(sfWebRequest $request) {
         error_reporting(-1);
        $this->getResponse()->setContentType('text/html;charset=utf-8');
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "Modelo";
        $pestanas[] = "ACTUALIZA_INV";
        $nombre = "Modelo";
        $nombreEMpresa = $EmpresaQuery->getNombre();
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $filename = "Carga_orden_compra_" . $nombreEMpresa . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("TIPO DE ARCHIVO ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->getCell("B1")->setValueExplicit("Orden Compra " . strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B1:D1");
        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $encabezados[] = array("Nombre" => "CODIGO", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Nombre"), "width" => 60, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("cantidad"), "width" => 15, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("valor unitario"), "width" => 20, "align" => "left", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));


        $fila++;


        header("Content-Type: text/html;charset=utf-8");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeAgregaProducto(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $ordenProveedor = OrdenProveedorQuery::create()->findOneById($id);
        $this->formProducto = new CreaProductoOrdenForm();
        if ($request->isMethod('post')) {
            $this->formProducto->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->formProducto->isValid()) {
                $valores = $this->formProducto->getValues();
                $productoQ = ProductoQuery::create()->findOneByCodigoSku($valores['codigo_sku']);
                if ($productoQ) {
                    $this->getUser()->setFlash('error', 'Codigo de Producto ya existe');
                }
                $producto = New Producto();
                $producto->setCodigoSku($valores['codigo_sku']);  // => COML
                $producto->setNombre($valores['nombre']);  // => INSTALACION
                $producto->setTipoAparatoId($valores['tipo']);  // => 1
                $producto->setPrecio($valores['precio']);  // => 515
                $producto->setExistencia(0); //   $valores['existencia'];  // => 10
                $producto->setCostoProveedor($valores['costo']);  // => 550
                $producto->setNombreIngles($valores['nombre_ingles']);  // => 
                $producto->setMarcaProducto($valores['marcaProducto']);  // => JAPANYFORCE
                $producto->setCaracteristica($valores['caracteristica']);  // => 
                $producto->setCodigoArancel($valores['codigo_arancel']);  // => 
                $producto->setCostoFabrica($valores['costo_fabrica']);  // => 
                $producto->setCostoCif($valores['costo_cif']);  // => 
                $producto->setOrigen($valores['origen']);  // => 
                $producto->setPeso($valores['peso']);  // => 
                $producto->setAlto($valores['alto']);  // => 
                $producto->setAncho($valores['ancho']);  // => 
                $producto->setLargo($valores['largo']);  // => 
                $producto->setCodigoProveedor($valores['codigo_proveedor']);  // => 
                $producto->setActivo(false);
                $producto->setCreatedBy('ORDEN');
                $producto->save();
                $ordenQ = new OrdenProveedorDetalle();
                $ordenQ->setCantidad(1);
                $ordenQ->setProductoId($producto->getId());
                $ordenQ->setDetalle($producto->getNombre());
                $ordenQ->setCodigo($producto->getCodigoSku());
                $ordenQ->setCantidad($valores['existencia']);
                $ordenQ->setValorTotal(round($valores['existencia'] * $valores['costo'], 2));
                $ordenQ->setValorUnitario($valores['costo']);
                $ordenQ->setTotalIva(0);
                $ordenQ->setOrdenProveedorId($id);
                $ordenQ->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
            }
        }
        $this->redirect('orden_compra/index?id=' . $id);
    }

    public function executeValorPendiente(sfWebRequest $request) {
        $val = $request->getParameter('val');
        $id = $request->getParameter('id');

        $ordenGasto = OrdenProveedorQuery::create()->findOneById($id);
        $retorna = $ordenGasto->getValorTotal();
        $ordenValor = CuentaProveedorQuery::create()->findOneByOrdenProveedorId($id);
        if ($ordenValor) {
            $retorna = $ordenValor->getValorTotal() - $ordenValor->getValorPagado();
            $retorna = round($retorna, 2);
        }
        $notaCredito = NotaCreditoQuery::create()->findOneById($val);
        if ($notaCredito) {
            $retorna = $notaCredito->getValorTotal() - $notaCredito->getValorConsumido();
        }
        echo $retorna;
        die();
    }

    public function executeValorGas(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $valorGas = $request->getParameter('valor');
        $registro = OrdenProveedorQuery::create()->findOneById($id);
        $registro->setImpuestoGas($valorGas);
        $registro->save();
        $excento = false;
        if (!$registro->getAplicaIva()) {
            $excento = true;
        }
        $tiporegi = '';
        if ($registro->getProveedorId()) {
            $tiporegi = $registro->getProveedor()->getRegimenIsr();
        }


        $valoresIva = ParametroQuery::ObtenerIva($registro->getValorTotal(), $excento, $registro->getAplicaIsr(), $registro->getExcentoIsr(), $tiporegi, false, $valorGas);
//        echo "<pre>";
//        print_r($valoresIva);
//        die();

        $registro->setSubTotal($valoresIva['VALOR_SIN_IVA']);
        $registro->setIva($valoresIva['IVA']);
        $registro->setValorIsr($valoresIva['VALOR_ISR']);
        $registro->setValorRetieneIva($valoresIva['VALOR_RETIENE_IVA']);
        $registro->save();

        $detalle = OrdenProveedorDetalleQuery::create()
                ->filterByOrdenProveedorId($registro->getId())
                ->find();
        foreach ($detalle as $data) {
            $data = OrdenProveedorDetalleQuery::create()->findOneById($data->getId());
            $GasDe = ($valorGas * $data->getValorTotal()) / $registro->getValorTotal();
            $GasDe = round($GasDe, 2);
            $valoresIva = ParametroQuery::ObtenerIva($data->getValorTotal(), $excento, $registro->getAplicaIsr(), $registro->getExcentoIsr(), $tiporegi, false, $GasDe);
            //    $data->setSubTotal($valoresIva['VALOR_SIN_IVA']);
            $data->setTotalIva($valoresIva['IVA']);
            $data->setValorIsr($valoresIva['VALOR_ISR']);
            $data->setValorRetieneIva($valoresIva['VALOR_RETIENE_IVA']);
            $data->save();
        }
        $SUBTOTAL = Parametro::formato($registro->getSubTotal(), false);
        $IVA = Parametro::formato($registro->getIva(), false);

        $retorna = $SUBTOTAL . "|" . $IVA;
        echo $retorna;
        die();

//        echo "<pre>";
//        print_r($registro);
//        echo "<Pre>";
//        echo "<pre>";
//        print_r($valoresIva);
//        echo "</pre>";
//        $valoresIva = ParametroQuery::ObtenerIva($registro->getValorTotal(), $excento, $registro->getAplicaIsr(), $registro->getExcentoIsr(), $tiporegi,false,0);
//        echo "<pre>";
//        print_r($valoresIva);
//        echo "</pre>";  
//        echo "actualizado " . $registro->getId();
        die();
    }

    public function executeMuestraPaga(sfWebRequest $request) {
      
        error_reporting(-1);

        $token = $request->getParameter('token');
        $ordenPRove = OrdenProveedorQuery::create()->findOneByToken($token);
        sfContext::getInstance()->getUser()->setAttribute('tab', 4, 'seguridad');
        $this->redirect('orden_compra/muestra?token=' . $token);
        $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
    }

    public function partidaPago($ordenPago) {
        $MedioPago = MedioPagoQuery::create()->findOneByNombre($ordenPago->getTipoPago());
        $partidaId = Partida::Crea('Pago Proveedor ', $ordenPago->getCodigo(), $ordenPago->getValorTotal());
        // $cuentaContable = '2.1.1.2.001';
        $cuentaPartida = Partida::busca("PROVEEDOR COMPRA", 0, 2);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];

        $proveedorQ = ProveedorQuery::create()->findOneById($ordenPago->getProveedorId());
        $cuentaContableQ = CuentaErpContableQuery::create()->findOneByCuentaContable($proveedorQ->getCuentaContable());
        if ($cuentaContableQ) {
            $cuentaContable = $cuentaContableQ->getCuentaContable();
            $nombreCuenta = $cuentaContableQ->getNombre();
        }


        //   $nombreCuenta = Partida::cuenta($cuentaContable);
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe($ordenPago->getValorTotal());
        $partidaLinea->setHaber(0);
        $partidaLinea->setTipo(0);
        $partidaLinea->setGrupo("PROVEEDOR COMPRA");
        $partidaLinea->save();
//        $cuentaContable = $MedioPago->getCuentaContable();
//        $nombreCuenta = Partida::cuenta($cuentaContable);
        $cuentaPartida = Partida::busca($MedioPago->getCodigo(), 2, 2);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];


        if ($MedioPago->getBancoId()) {
            $cuentaContableQ = CuentaErpContableQuery::create()->findOneByCuentaContable($MedioPago->getBanco()->getCuentaContable());
            if ($cuentaContableQ) {
                $cuentaContable = $cuentaContableQ->getCuentaContable();
                $nombreCuenta = $cuentaContableQ->getNombre();
            }
        }

        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe(0);
        $partidaLinea->setHaber($ordenPago->getValorTotal());
        $partidaLinea->setTipo(2);
        $partidaLinea->setGrupo($MedioPago->getCodigo());
        $partidaLinea->save();
        $ordenPago->setPartidaNo($partidaId);
        $ordenPago->save();
        return $partidaId;
    }

    public function partidaInventario($ordenProveedor) {
        //    $ordenProveedor = OrdenProveedorQuery::create()->findOneByCodigo($codigo);
        $ordenProveedorDetalle = OrdenProveedorDetalleQuery::create()
                ->filterByOrdenProveedorId($ordenProveedor->getId())
                ->find();


        $TOTALIVA = 0;
        $TOTAL_GAS = $ordenProveedor->getImpuestoGas();
        $VALORtotal = 0;
        $partidaQ = new Partida();
        $partidaQ->setFechaContable($ordenProveedor->getFechaContabilizacion('Y-m-d'));
        $partidaQ->setUsuario($ordenProveedor->getUsuario());
        $partidaQ->setTipo('Orden Compra');
        $partidaQ->setCodigo($ordenProveedor->getCodigo());
        $partidaQ->setValor($ordenProveedor->getValorTotal());
        $partidaQ->setTiendaId($ordenProveedor->getTiendaId());
        $partidaQ->save();
        $VALOR_ISR = 0;
        $VALOR_RETIENE_IVA = 0;
        $VALOR_SIN_ISR = 0;
        $tiporegi = '';
        if ($ordenProveedor->getProveedorId()) {
            $tiporegi = $ordenProveedor->getProveedor()->getRegimenIsr();
        }


        foreach ($ordenProveedorDetalle as $registro) {
            if ($registro->getProductoId()) {
                $grupo = "PRODUCTO " . $registro->getProducto()->getCodigoSku();
                $cuentaPartida = Partida::busca($grupo, 1, 1);
                $cuentaContable = $cuentaPartida['cuenta'];
                $nombreCuenta = $cuentaPartida['nombre'];
            }
            if ($registro->getServicioId()) {
                $cuentaContableQ = CuentaErpContableQuery::create()->findOneByCuentaContable($registro->getServicio()->getCuentaContable());
                if ($cuentaContableQ) {
                    $cuentaContable = $cuentaContableQ->getCuentaContable();
                    $nombreCuenta = $cuentaContableQ->getNombre();
                }

                $grupo = "SERVICIO" . $registro->getServicio()->getCodigo();
                if (!$cuentaContableQ) {
                    $cuentaPartida = Partida::busca($grupo, 1, 1);
                    $cuentaContable = $cuentaPartida['cuenta'];
                    $nombreCuenta = $cuentaPartida['nombre'];
                }
            }
            $excento = false;
            if (!$registro->getOrdenProveedor()->getAplicaIva()) {
                $excento = true;
            }
            $valoresIva = ParametroQuery::ObtenerIva($registro->getValorTotal(), $excento, $registro->getOrdenProveedor()->getAplicaIsr(), $registro->getOrdenProveedor()->getExcentoIsr(), $tiporegi);
            $valor = $valoresIva['VALOR_SIN_IVA'];
            $TOTALIVA = $valoresIva['IVA'] + $TOTALIVA;
            $VALOR_ISR = $VALOR_ISR + $valoresIva['VALOR_ISR'];
            $VALOR_RETIENE_IVA = $VALOR_RETIENE_IVA + $valoresIva['VALOR_RETIENE_IVA'];
            $VALOR_SIN_ISR = $VALOR_SIN_ISR + $valoresIva['VALOR_SIN_ISR'];

            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaQ->getId());
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setDebe($valor);
            $partidaLinea->setHaber(0);
            $partidaLinea->setTipo(1);
            $partidaLinea->setGrupo($grupo);
            $partidaLinea->save();
        }






        $cuentaPartida = Partida::busca("IVA CREDITO", 0, 2);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        if ($TOTALIVA > 0) {
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaQ->getId());
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setDebe($TOTALIVA);
            $partidaLinea->setHaber(0);
            $partidaLinea->setGrupo("IVA CREDITO");
            $partidaLinea->save();
        }

        $cuentaPartida = Partida::busca("IMPUESTO GAS", 0, 2);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        if ($TOTAL_GAS > 0) {
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaQ->getId());
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setDebe($TOTAL_GAS);
            $partidaLinea->setHaber(0);
            $partidaLinea->setGrupo("IMPUESTO GAS");
            $partidaLinea->save();
        }


        if ($VALOR_RETIENE_IVA > 0) {
            ///  2031-08 VALOR_RETIENE_IVA
            $cuentaPartida = Partida::busca("RETENCIONES%DE%IVA", 0, 2);
            $cuentaContable = $cuentaPartida['cuenta'];
            $nombreCuenta = $cuentaPartida['nombre'];
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaQ->getId());
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setDebe(0);

            $partidaLinea->setHaber($VALOR_RETIENE_IVA);
            $partidaLinea->setGrupo('RETENCIONES DE IVA');
            $partidaLinea->save();
        }

        $cuentaPartida = Partida::busca("RENTA%POR%PAGAR", 0, 2);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        // VALOR_ISR  2030-08

        if ($VALOR_ISR > 0) {
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaQ->getId());
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setDebe(0);
            $partidaLinea->setHaber($VALOR_ISR);
            $partidaLinea->setGrupo("RENTA POR PAGAR");
            $partidaLinea->save();
        }


        $cuentaPartida = Partida::busca("PROVEEDOR COMPRA", 0, 2);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];

        $proveedorQ = ProveedorQuery::create()->findOneById($ordenProveedor->getProveedorId());
        $cuentaContableQ = CuentaErpContableQuery::create()->findOneByCuentaContable($proveedorQ->getCuentaContable());
        if ($cuentaContableQ) {
            $cuentaContable = $cuentaContableQ->getCuentaContable();
            $nombreCuenta = $cuentaContableQ->getNombre();
        }


        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaQ->getId());
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe(0);
        $partidaLinea->setHaber($VALOR_SIN_ISR + $TOTAL_GAS);
        $partidaLinea->setGrupo("PROVEEDOR COMPRA");
        $partidaLinea->save();

        $ordenProveedor->setValorImpuesto($VALOR_ISR + $VALOR_RETIENE_IVA);
        $ordenProveedor->setPartidaNo($partidaQ->getId());
        $ordenProveedor->save();
    }

    public function executeVista(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $token = $request->getParameter('token');
        $id = $request->getParameter('idv');
        $ordenQ = OrdenProveedorQuery::create()->findOneByToken($token);
        if (!$ordenQ) {
            $ordenQ = OrdenProveedorQuery::create()->findOneById($id);
        }
        $this->orden = $ordenQ;
        $this->lista = OrdenProveedorDetalleQuery::create()
                ->filterByOrdenProveedorId($ordenQ->getId())
                ->find();
    }

    public function executeMuestra(sfWebRequest $request) {
        
        error_reporting(-1);

        date_default_timezone_set("America/Guatemala");
        $token = $request->getParameter('token');
        $tab = 1;
        if ($request->getParameter('tab')) {
            $tab = $request->getParameter('tab');
        }
        $ordenQ = OrdenProveedorQuery::create()->findOneByToken($token);
        if (!$ordenQ) {
            $this->redirect('orden_compra/index');
        }
        if ($ordenQ->getEstatus() == "Autorizado") {
            if ($ordenQ->getDespacho()) {
                if (!$ordenQ->getValorPagado()) {
                    $tab = 6;
                }
            }
        }
        $this->tab = $tab;
        $this->orden = $ordenQ;
        $this->lista = OrdenProveedorDetalleQuery::create()
                ->filterByOrdenProveedorId($ordenQ->getId())
                ->find();
        $cuentaVivi = CuentaProveedorQuery::create()->findOneByOrdenProveedorId($ordenQ->getId());
        $this->pagos = OrdenProveedorPagoQuery::create()
                ->filterByOrdenProveedorId($ordenQ->getId())
                ->find();
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        //    $this->cuenta = CuentaProveedorQuery::create()->findOneById($this->id);
        $value['fecha'] = date('d/m/Y');
        if ($cuentaVivi) {
            $value['valor'] = round($cuentaVivi->getValorTotal() - $ordenQ->getValorImpuesto() - $cuentaVivi->getValorPagado(), 2);
        }
        sfContext::getInstance()->getUser()->setAttribute("proveedorId", $ordenQ->getProveedorId(), 'seguridad');

        $this->form = new SelePagoProveedorForm($value);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $valor = $valores['valor'];
                $NotaCredito = NotaCreditoQuery::create()->findOneById($valores['tipo_pago']);

                if ($NotaCredito) {
                    $valorNOta = $NotaCredito->getValorTotal() - $NotaCredito->getValorConsumido();  // restar lo que ya se uso
                    if ($valor > $valorNOta) {
                        sfContext::getInstance()->getUser()->setAttribute('tab', 4, 'seguridad');
                        $this->getUser()->setFlash('error', 'Valor de Ingreso  ' . $valor . " es mayor que valor saldo nota credito " . $valorNOta);
                        $this->redirect('orden_compra/muestra?token=' . $token);
                    }
                }


                $valorPagado = $cuentaVivi->getValorPagado() + $valor;
                $valorPagado = round($valorPagado, 2);
                $cuentaTotal = round($cuentaVivi->getValorTotal(), 2);
                if ($valorPagado > $cuentaTotal) {
                    sfContext::getInstance()->getUser()->setAttribute('tab', 4, 'seguridad');
                    $this->getUser()->setFlash('error', 'Valor de pago  ' . $valorPagado . " es mayor que valor documento " . $cuentaVivi->getValorTotal());
                    $this->redirect('orden_compra/muestra?token=' . $token);
                }
                $fechaInicio = $valores['fecha'];
                $fechaInicio = explode('/', $fechaInicio);
                $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
                $OperaPgo = new OrdenProveedorPago();
                $OperaPgo->setOrdenProveedorId($ordenQ->getId());
                $OperaPgo->setProveedorId($ordenQ->getProveedorId());
                $OperaPgo->setTipoPago($valores['tipo_pago']);
                $OperaPgo->setDocumento($valores['no_documento']);
                if ($NotaCredito) {
                    $OperaPgo->setTipoPago("Nota Crédito");
                    $OperaPgo->setDocumento($NotaCredito->getCodigo());
                    $valorTotalNota = $valor + $NotaCredito->getValorConsumido();
                    if (round($valorTotalNota, 2) >= round($NotaCredito->getValorTotal(), 2)) {
                        $NotaCredito->setEstatus("Procesada");
                        $NotaCredito->save();
                    }
                }
                if ($valores['banco_id']) {
                    $OperaPgo->setBancoId($valores['banco_id']);
                }
                $OperaPgo->setFecha($fechaInicio);
                $OperaPgo->setUsuario($usuarioQ->getUsuario());
                $OperaPgo->setFechaCreo(date('Y-m-d H:i:s'));
                $OperaPgo->setCuentaProveedorId($cuentaVivi->getId());
                $OperaPgo->setEmpresaId($empresaId);
                $OperaPgo->setValorTotal($valor);
                $OperaPgo->save();

                //* AQUI MOVIMIENTO_BANCO

               // $partidaNo = $this->partidaPago($OperaPgo);
                $valorPagado = $cuentaVivi->getValorPagado() + $valor;
                $cuentaVivi->setFecha(date('Y-m-d H:i:s'));
                $cuentaVivi->setValorPagado($valorPagado);
                $cuentaVivi->setFechaPago(date('Y-m-d H:i:s'));
                if (round($valorPagado, 2) >= round($cuentaVivi->getValorTotal(), 2)) {
                    $cuentaVivi->setPagado(true);
                }
                $cuentaVivi->save();
                $ordenQ->setValorPagado($valorPagado);
                if (round($valorPagado, 2) >= round($cuentaVivi->getValorTotal(), 2)) {
                    $cuentaVivi->setPagado(true);
                }
                //  $ordenQ->setUpdatedAt(sfContext::getInstance()->getUser()->getAttribute('usuarioNombre', null, 'seguridad'));
                $ordenQ->save();

                if ($valores['banco_id']) {
                    if (strtoupper($valores['tipo_pago']) <> 'CHEQUE') {
                        $movimiento = New MovimientoBanco();
                        $movimiento->setTipo('Orden Compra');
                        $movimiento->setTipoMovimiento($valores['tipo_pago']);
                        $movimiento->setBancoId($valores['banco_id']);
                        $movimiento->setValor($valor * -1);
                        $movimiento->setBancoOrigen($valores['banco_id']);
                        $movimiento->setDocumento($valores['no_documento']);
                        $movimiento->setFechaDocumento($cuentaVivi->getFechaPago('Y-m-d'));
                        $movimiento->setObservaciones("Orden Compra " . $ordenQ->getCodigo());
                        $movimiento->setEstatus("Confirmado");
                        $movimiento->setPartidaNo($partidaNo);
                        //$movimiento->setMedioPagoId();
                        $movimiento->setUsuario($usuarioQ->getUsuario());
                        $movimiento->save();
                    }
                }
//                                if ($cuentaVivi->getValorPagado() >=$cuentaVivi->getValorTotal()) {
//                                    
//                                    $cuentaVivi->setPagado(true);
//                                    $cuentaVivi->save();
//                                }
                sfContext::getInstance()->getUser()->setAttribute('tab', 4, 'seguridad');
                $this->getUser()->setFlash('exito', 'Pago realizado con exito ' . $OperaPgo->getCodigo());
                $this->redirect('orden_compra/muestra?token=' . $token);
            }
        }
    }

    public function executeConfirmar(sfWebRequest $request) {

        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $ordenQ = OrdenProveedorQuery::create()->findOneById($id);
        $tiendaId = $ordenQ->getTiendaId();
        $camposOblitatorios = CampoUsuarioQuery::create()
                ->filterByTipoDocumento('OrdenCompra')
                ->filterByTiendaId(null)
                ->filterByActivo(true)
                ->filterByRequerido(true)
                ->find();
        foreach ($camposOblitatorios as $regitr) {
            $datos = ValorUsuarioQuery::create()
                    ->filterByTipoDocumento('OrdenCompra')
                    ->filterByCampoUsuarioId($regitr->getId())
                    ->filterByNoDocumento($id)
                    ->findOne();
            if (!$datos) {
                $this->getUser()->setFlash('error', 'Debe completar información  ' . $regitr->getNombre());
                $this->redirect('orden_compra/index?tab=3&aler=' . $regitr->getId());
            }
            if (trim($datos->getValor()) == "") {
                $this->getUser()->setFlash('error', 'Debes completar información  ' . $regitr->getNombre());
                $this->redirect('orden_compra/index?tab=3&aler=' . $regitr->getId());
            }
        }

        $camposOblitatorios = CampoUsuarioQuery::create()
                ->filterByTipoDocumento('OrdenCompra')
                ->filterByTiendaId($ordenQ->getTiendaId())
                ->filterByActivo(true)
                ->filterByRequerido(true)
                ->find();
        foreach ($camposOblitatorios as $regitr) {
            $datos = ValorUsuarioQuery::create()
                    ->filterByTipoDocumento('OrdenCompra')
                    ->filterByNoDocumento($id)
                    ->findOne();
            if (!$datos) {
                $this->getUser()->setFlash('error', 'Debe completar información  ' . $regitr->getNombre());
                $this->redirect('orden_compra/index?tab=3&aler=' . $regitr->getId());
            }
            if (trim($datos->getValor()) == "") {
                $this->getUser()->setFlash('error', 'Debe completar información  ' . $regitr->getNombre());
                $this->redirect('orden_compra/index?tab=3&aler=' . $regitr->getId());
            }
        }
        if (!$ordenQ->getTiendaId()) {
            $this->getUser()->setFlash('error', 'Debe seleccionar tienda ');
            $this->redirect('orden_compra/index?id=');
        }

            if (($ordenQ->getEstatus() == 'Proceso') or  ($ordenQ->getEstatus() == 'Pendiente')) {
              sfContext::getInstance()->getUser()->setAttribute('OrdenId', null, 'seguridad');
                $ordenQ->setEstatus("Confirmada");
                $ordenQ->setFecha(date('Y-m-d H:i:s'));
                $ordenQ->setToken(sha1($ordenQ->getCodigo()));
                $ordenQ->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect('orden_compra/muestra?token=' . $token);
            }
        
        if ($ordenQ) {
            $tokenGuardado = sha1($ordenQ->getCodigo());
            if ($token == $tokenGuardado) {

                if ($ordenQ->getEstatus() == 'Autorizado') {
                    $productos = OrdenProveedorDetalleQuery::create()
                            ->filterByOrdenProveedorId($id)
                            ->filterByProductoId(null, Criteria::NOT_EQUAL)
                            ->find();
                    foreach ($productos as $reg) {
                        
                           if (!$reg->getCostoPromedio()) {
                            $reg->setCostoPromedio($reg->getCostoActual());
                            $reg->save();
                        }
                        
                        $productoExistencia = ProductoExistenciaQuery::create()
                                ->filterByTiendaId($tiendaId)
                                ->filterByProductoId($reg->getProductoId())
                                ->findOne();
                        if (!$productoExistencia) {
                            $productoExistencia = new ProductoExistencia();
                            $productoExistencia->setTiendaId($tiendaId);
                            $productoExistencia->setProductoId($reg->getProductoId());
                            $productoExistencia->setCantidad(0);
                            $productoExistencia->save();
                        }
                        $inicial = $productoExistencia->getCantidad();
                        $nuevoValor = $productoExistencia->getCantidad() + $reg->getCantidad();

                        $movimienoto = new ProductoMovimiento();
                        $movimienoto->setTiendaId($tiendaId);
                        $movimienoto->setProductoId($reg->getProductoId());
                        $movimienoto->setCantidad($reg->getCantidad());
                        $movimienoto->setIdentificador("ORDEN COMPRA " . $ordenQ->getCodigo());
                        $movimienoto->setTipo('INGRESO');
                        $movimienoto->setFecha(date('Y-m-d H:i:s'));
                        $movimienoto->setMotivo("Proveedor " . $ordenQ->getProveedor()->getNombre() . " Documento " . $ordenQ->getNoDocumento());
                        $movimienoto->setInicio($inicial);
                        $movimienoto->setEmpresaId($ordenQ->getEmpresaId());
                        $movimienoto->setFin($nuevoValor);
                        $movimienoto->setCosto($reg->getValorUnitario());
                                  $movimienoto->setCosto($reg->getCostoPromedio());
                        $movimienoto->save();
                        $productoExistencia->setCantidad($nuevoValor);
                        $productoExistencia->save();
                        
                            $productoQ = ProductoQuery::create()->findOneById($reg->getProductoId());
//                            $productoQ->setCostoProveedor($reg->getCostoActual());
//                            if ($reg->getCostoPromedio() >0) {
                            $productoQ->setCostoProveedor($reg->getCostoPromedio());
                            //  }
                            $productoQ->save();
                            
                    }


                    sfContext::getInstance()->getUser()->setAttribute('OrdenId', null, 'seguridad');
                    $ordenQ->setEstatus("Finalizada");
                    $ordenQ->setFecha(date('Y-m-d H:i:s'));
                    $ordenQ->setToken(sha1($ordenQ->getCodigo()));
                    $ordenQ->save();

                    $ordenQ->setDespacho(true);
                    $ordenQ->save();
                    if (!$ordenQ->getPartidaNo()) {
                        $this->partidaInventario($ordenQ);
                    }
                    $cuentaProveedor = CuentaProveedorQuery::create()->findOneByOrdenProveedorId($ordenQ->getId());
                    if (!$cuentaProveedor) {
                        $cuentaProveedor = new CuentaProveedor();
                        $cuentaProveedor->setOrdenProveedorId($ordenQ->getId());
                    }

                    $valorTota = $ordenQ->getValorTotal();  //- $ordenQ->getValorImpuesto();

                   
                    $valorTota = round($valorTota, 2);
                    $ordenQ->setValorTotal($valorTota);
                    $ordenQ->save();

                    $cuentaProveedor->setProveedorId($ordenQ->getProveedorId());
                    $cuentaProveedor->setFecha(date('Y-m-d'));
                    $cuentaProveedor->setDetalle("Orden Compra " . $ordenQ->getCodigo());
                    $cuentaProveedor->setValorTotal($valorTota);
                    $cuentaProveedor->setValorPagado(0);
                    $cuentaProveedor->save();

                    $this->redirect('orden_compra/muestra?token=' . $token);
                    $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                }
            }
        }
        $this->redirect('orden_compra/index');
    }

    public function executeManual(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $OrdenID = sfContext::getInstance()->getUser()->getAttribute('OrdenId', null, 'seguridad');
        $this->forma = new CreaOrdenLineForm();

        if ($request->isMethod('post')) {
            $this->forma->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->forma->isValid()) {
                $valores = $this->forma->getValues();

                $ordenProveedor = OrdenProveedorQuery::create()->findOneById($OrdenID);

                if ($ordenProveedor) {
                    $tiporegi = '';
                    if ($ordenProveedor->getProveedorId()) {
                        $tiporegi = $ordenProveedor->getProveedor()->getRegimenIsr();
                    }
                    $excenta = $ordenProveedor->getExcento();
                    $suma = $valores['valor_unitario'];
                    $valoresP = ParametroQuery::ObtenerIva($suma, $excenta, $ordenProveedor->getAplicaIsr(), $ordenProveedor->getExcentoIsr(), $tiporegi);
                    $iva = $valoresP['IVA'];
                    $valorSInIVa = $valoresP['VALOR_SIN_IVA'];
                    $ordenQ = new OrdenProveedorDetalle();
                    $ordenQ->setCantidad(1);
                    $ordenQ->setDetalle($valores['nombre']);
                    $ordenQ->setCodigo($OrdenID . "-" . rand(1, 9));
                    $ordenQ->setCantidad($valores['cantidad']);
                    $ordenQ->setValorTotal($suma);
                    $ordenQ->setValorUnitario($suma);
                    $ordenQ->setTotalIva($iva);
                    $ordenQ->setOrdenProveedorId($OrdenID);
                    $ordenQ->save();

                    $lista = OrdenProveedorDetalleQuery::create()
                            ->withColumn('sum(OrdenProveedorDetalle.ValorTotal)', 'TotalGeneral')
                            ->filterByOrdenProveedorId($OrdenID)
                            ->findOne();
                    $ordenProveedor->setSubTotal(0);
                    $ordenProveedor->setValorTotal(0);
                    $ordenProveedor->setIva(0);
                    if ($lista) {
                        $suma = $lista->getTotalGeneral();
                        $valores = ParametroQuery::ObtenerIva($suma, $excenta, $ordenProveedor->getAplicaIsr(), $ordenProveedor->getExcentoIsr(), $tiporegi);
                        $iva = $valores['IVA'];
                        $valorSInIVa = $valores['VALOR_SIN_IVA'];
                        $ordenProveedor->setSubTotal($valorSInIVa);
                        $ordenProveedor->setValorTotal($suma);
                        $ordenProveedor->setIva($iva);
                    }
                    $ordenProveedor->save();

                    $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                }
            }
        }


        $this->redirect('orden_compra/index?tablista=3');
    }

    public function executeCantidad(sfWebRequest $request) {
        $OperacionId = sfContext::getInstance()->getUser()->getAttribute('OrdenId', null, 'seguridad');
        $ordenProveedor = OrdenProveedorQuery::create()->findOneById($OperacionId);
        $excenta = $ordenProveedor->getExcento();

        $tiporegi = '';
        if ($ordenProveedor->getProveedorId()) {
            $tiporegi = $ordenProveedor->getProveedor()->getRegimenIsr();
        }

        $cantidad = $request->getParameter('id');
        $ListaId = $request->getParameter('idv');
        $listaProducto = OrdenProveedorDetalleQuery::create()
                ->filterById($ListaId)
                ->findOne();
        $valor = $listaProducto->getValorUnitario();
        $retorna = $cantidad * $valor;
        $listaProducto->setCantidad($cantidad);
        $listaProducto->setValorTotal($retorna);
        $listaProducto->save();
        $lista = OrdenProveedorDetalleQuery::create()
                ->withColumn('sum(OrdenProveedorDetalle.ValorTotal)', 'TotalGeneral')
                ->filterByOrdenProveedorId($OperacionId)
                ->findOne();
        if ($lista) {
            $suma = $lista->getTotalGeneral();

            $valores = ParametroQuery::ObtenerIva($suma, $excenta, $ordenProveedor->getAplicaIsr(), $ordenProveedor->getExcentoIsr(), $tiporegi);
            $iva = $valores['IVA'];
            $valorSInIVa = $valores['VALOR_SIN_IVA'];
        }
        $retorna = "<strong>" . number_format($retorna, 2) . "</strong>";
        $retorna .= '|' . number_format($suma, 2) . "|" . number_format($iva, 2) . "|" . number_format($valorSInIVa, 2);
        $ordenProveedor->setSubTotal($valorSInIVa);
        $ordenProveedor->setValorTotal($suma);
        $ordenProveedor->setIva($iva);
        $ordenProveedor->setValorIsr($valores['VALOR_ISR']);
        $ordenProveedor->setValorRetieneIva($valores['VALOR_RETIENE_IVA']);
        $ordenProveedor->save();
        echo $retorna;
        die();
    }

    public function executeDetalle(sfWebRequest $request) {
        $valor = $request->getParameter('id');
        $ListaId = $request->getParameter('idv');
        $listaProducto = OrdenProveedorDetalleQuery::create()
                ->filterById($ListaId)
                ->findOne();
        $listaProducto->setObservaciones($valor);
        $listaProducto->save();
        echo "actualizado " . $valor;
        die();
    }

    public function executeValor(sfWebRequest $request) {
        $OperacionId = sfContext::getInstance()->getUser()->getAttribute('OrdenId', null, 'seguridad');
        $ordenProveedor = OrdenProveedorQuery::create()->findOneById($OperacionId);
        $excenta = $ordenProveedor->getExcento();
        $tiporegi = '';
        if ($ordenProveedor->getProveedorId()) {
            $tiporegi = $ordenProveedor->getProveedor()->getRegimenIsr();
        }
        $valor = $request->getParameter('id');
        $ListaId = $request->getParameter('idv');
        $listaProducto = OrdenProveedorDetalleQuery::create()
//                ->filterByIngresoProductoId($OperacionId)
//                ->filterByProductoId($ListaId)
                ->filterById($ListaId)
                ->findOne();
        $productoId = $listaProducto->getProductoId();
        $cantidad = $listaProducto->getCantidad();
        $retorna = $cantidad * $valor;
        $listaProducto->setValorUnitario($valor);
        $listaProducto->setValorTotal($retorna);
        $listaProducto->save();
        $lista = OrdenProveedorDetalleQuery::create()
                ->withColumn('sum(OrdenProveedorDetalle.ValorTotal)', 'TotalGeneral')
                ->filterByOrdenProveedorId($OperacionId)
                ->findOne();
        if ($lista) {
            $suma = $lista->getTotalGeneral();

            $valores = ParametroQuery::ObtenerIva($suma, $excenta, $ordenProveedor->getAplicaIsr(), $ordenProveedor->getExcentoIsr(), $tiporegi);
            $iva = $valores['IVA'];
            $valorSInIVa = $valores['VALOR_SIN_IVA'];
        }
        $retorna = "<strong>" . number_format($retorna, 2) . "</strong>";
        $retorna .= '|' . number_format($suma, 2) . "|" . number_format($iva, 2) . "|" . number_format($valorSInIVa, 2);

        $ordenProveedor->setSubTotal($valorSInIVa);
        $ordenProveedor->setValorTotal($suma);
        $ordenProveedor->setIva($iva);
        $ordenProveedor->setValorIsr($valores['VALOR_ISR']);
        $ordenProveedor->setValorRetieneIva($valores['VALOR_RETIENE_IVA']);
        $ordenProveedor->save();
        echo $retorna;
        die();
    }

    public function executeEliminaLinea(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $OrdenID = sfContext::getInstance()->getUser()->getAttribute('OrdenId', null, 'seguridad');
        $ordenDetalle = OrdenProveedorDetalleQuery::create()
                ->filterByOrdenProveedorId($OrdenID)
                ->filterById($id)
                ->findOne();
        if ($ordenDetalle) {
            $OperacionId = $ordenDetalle->getOrdenProveedorId();
            $PRODUCTOid = $ordenDetalle->getProductoId();
            $ordenProveedor = OrdenProveedorQuery::create()->findOneById($OperacionId);
            $excenta = $ordenProveedor->getExcento();
            $ordenDetalle->delete();
            $lista = OrdenProveedorDetalleQuery::create()
                    ->withColumn('sum(OrdenProveedorDetalle.ValorTotal)', 'TotalGeneral')
                    ->filterByOrdenProveedorId($OperacionId)
                    ->findOne();
            $ordenProveedor->setSubTotal(0);
            $ordenProveedor->setValorTotal(0);
            $ordenProveedor->setIva(0);
            $tiporegi = '';
            if ($ordenProveedor->getProveedorId()) {
                $tiporegi = $ordenProveedor->getProveedor()->getRegimenIsr();
            }
            if ($lista) {
                $suma = $lista->getTotalGeneral();

                $valores = ParametroQuery::ObtenerIva($suma, $excenta, $ordenProveedor->getAplicaIsr(), $ordenProveedor->getExcentoIsr(), $tiporegi);
                $iva = $valores['IVA'];
                $valorSInIVa = $valores['VALOR_SIN_IVA'];
                $ordenProveedor->setSubTotal($valorSInIVa);
                $ordenProveedor->setValorTotal($suma);
                $ordenProveedor->setIva($iva);
                $ordenProveedor->setValorIsr($valores['VALOR_ISR']);
                $ordenProveedor->setValorRetieneIva($valores['VALOR_RETIENE_IVA']);
            }
            $ordenProveedor->save();

//            $prodQ = ProductoQuery::create()->filterByCreatedAt('ORDEN')->filterById($PRODUCTOid)->filterByActivo(false)->findOne();
//            if ($prodQ) {
//                $con = Propel::getConnection();
//                $con->beginTransaction();
//                try {
//                    $prodQ->delete();
//                    $con->commit();
//                } catch (Exception $e) {
//                    $con->rollback();
//                }
//            }
        }
        $this->redirect('orden_compra/index?id=');
    }

    public function executeServicio(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $OrdenID = sfContext::getInstance()->getUser()->getAttribute('OrdenId', null, 'seguridad');
        $producto = ServicioQuery::create()->findOneById($id);
        if ($producto) {
            $ordenQ = OrdenProveedorQuery::create()->findOneById($OrdenID);
            if ($ordenQ) {
                $ordenQ = new OrdenProveedorDetalle();
                $ordenQ->setCantidad(1);
                $ordenQ->setServicioId($producto->getId());
                $ordenQ->setDetalle($producto->getNombre());
                $ordenQ->setCodigo($producto->getCodigo());
                $ordenQ->setCantidad(1);
                $ordenQ->setValorTotal(0);
                $ordenQ->setValorUnitario(0);
                $ordenQ->setTotalIva(0);
                $ordenQ->setOrdenProveedorId($OrdenID);
                $ordenQ->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
            }
        }
        $this->redirect('orden_compra/index?id=');
    }

    public function executeProducto(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $OrdenID = sfContext::getInstance()->getUser()->getAttribute('OrdenId', null, 'seguridad');
        $producto = ProductoQuery::create()->findOneById($id);
        if ($producto) {
            $ordenQ = OrdenProveedorQuery::create()->findOneById($OrdenID);
            if ($ordenQ) {
                $ordenQ = new OrdenProveedorDetalle();
                $ordenQ->setCantidad(1);
                $ordenQ->setProductoId($producto->getId());
                $ordenQ->setDetalle($producto->getNombre());
                $ordenQ->setCodigo($producto->getCodigoSku());
                $ordenQ->setCantidad(1);
                $ordenQ->setValorTotal(0);
                $ordenQ->setValorUnitario(0);
                $ordenQ->setTotalIva(0);
                $ordenQ->setOrdenProveedorId($OrdenID);
                $ordenQ->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
            }
        }
        $this->redirect('orden_compra/index?id=');
    }

    public function executePropiUp(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $OrdenID = sfContext::getInstance()->getUser()->getAttribute('OrdenId', null, 'seguridad');
        $provpe = ProveedorQuery::create()->findOneById($id);
        $nombre = '';
        $nit = '';
        $credito = 30;
        $ordenQ = OrdenProveedorQuery::create()->findOneById($OrdenID);
        if ($ordenQ) {

            $ordenQ->setProveedorId(null);
            $ordenQ->save();
        }
        if ($provpe) {
            $ordenQ = OrdenProveedorQuery::create()->findOneById($OrdenID);
            if ($ordenQ) {
                $ordenQ->setProveedorId($id);
                $ordenQ->setNombre($provpe->getNombre());
                $ordenQ->setNit($provpe->getNit());
                $ordenQ->setDiaCredito($provpe->getDiasCredito());
                $ordenQ->save();
                $nombre = $ordenQ->getNombre();
                $nombre = str_replace("|", "", $nombre);
                $nit = $ordenQ->getNit();
                $diaCredito = $ordenQ->getDiaCredito();
            }
        }
        $listaRetorna = $nombre . "|" . $nit . "|" . $credito;
        echo $listaRetorna;
        die();
    }

    public function executePropi(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $OrdenID = sfContext::getInstance()->getUser()->getAttribute('OrdenId', null, 'seguridad');
        $provpe = ProveedorQuery::create()->findOneById($id);
        if ($provpe) {
            $ordenQ = OrdenProveedorQuery::create()->findOneById($OrdenID);
            if ($ordenQ) {
                $ordenQ->setProveedorId($id);
                $ordenQ->setNombre($provpe->getNombre());
                $ordenQ->setNit($provpe->getNit());
                $ordenQ->setDiaCredito($provpe->getDiasCredito());
                $ordenQ->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
            }
        }
        $this->redirect('orden_compra/index?id=');
    }

    public function executeNueva(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $posibles[] = 'Proceso';
        $posibles[] = 'Pendiente';
        $codigo = $request->getParameter('codigo');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioName = sfContext::getInstance()->getUser()->getAttribute('usuarioNombre', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $EmpresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $operacion = OrdenProveedorQuery::create()
                ->filterByUsuario($usuarioQ->getUsuario())
                ->filterByEstatus($posibles, Criteria::IN)
                ->findOne();
        if ($operacion) {
            $operacionDetalle = OrdenProveedorDetalleQuery::create()->filterByOrdenProveedorId($operacion->getId())->count();
            if ($operacionDetalle > 0) {
                $operacion = null;
            }
        }

        if ($codigo) {
            $operacion = OrdenProveedorQuery::create()->findOneByCodigo($codigo);
        }

        if (!$operacion) {
            $operacion = new OrdenProveedor();
            $operacion->setDiaCredito(60);
            $operacion->setUsuario($usuarioQ->getUsuario());
            $operacion->setEstatus('Proceso');
            $operacion->save();
        }
        $tokenGuardado = sha1($operacion->getCodigo());
        $operacion->setTiendaId(sfContext::getInstance()->getUser()->getAttribute("tienda", null, 'seguridad'));
        $operacion->setToken($tokenGuardado);
        $operacion->setUsuario($usuarioQ->getUsuario());
        $operacion->setFecha(date('Y-m-d H:i:s'));
        $operacion->setFechaDocumento(date('Y-m-d H:i:s'));
        $operacion->setDiaCredito($EmpresaQ->getDiasCredito());
        $operacion->setFechaContabilizacion(date('Y-m-d  H:i:s'));
        $operacion->save();
        sfContext::getInstance()->getUser()->setAttribute('OrdenId', $operacion->getId(), 'seguridad');
        $this->getUser()->setFlash('exito', 'Orden creada con exito ' . $operacion->getCodigo());
        $this->redirect('orden_compra/index');
    }

    public function executeIndex(sfWebRequest $request) {
        sfContext::getInstance()->getUser()->setAttribute('tab', null, 'seguridad');
        $id = sfContext::getInstance()->getUser()->getAttribute('OrdenId', null, 'seguridad');
        $tipoApara = TipoAparatoQuery::create()->find();
        foreach ($tipoApara as $reg) {
            $prudcto = ProductoQuery::create()
                    ->filterByNombre($reg->getDescripcion())
                    ->filterByCodigoSku($reg->getCodigo())
                    ->findOne();
            if (!$prudcto) {
                $prudcto = New Producto();
            }
            $prudcto->setTopVenta(true);
            $prudcto->setActivo(false);
            $prudcto->setNombre($reg->getDescripcion());
            $prudcto->setCodigoSku($reg->getCodigo());
            $prudcto->save();
        }

        $orden = OrdenProveedorQuery::create()->findOneById($id);
        $this->proveedores = ProveedorQuery::create()
                ->filterByTipoProveedor('Internacional')
                ->orderByNombre("Asc")->find();
        $provedorId = null;
        if ($orden) {
            $provedorId = $orden->getProveedorId();
        }

        $tablista = 1;
        if ($request->getParameter('tablista')) {
            $tablista = $request->getParameter('tablista');
        }
        $this->aler = $request->getParameter('aler');

        $this->provedorId = $provedorId;
        $this->tablista = $tablista;
        $this->orden = $orden;
        $this->proveedor = ProveedorQuery::create()->findOneById($provedorId);
        $this->id = $id;
        $default = null;
        $default['aplica_isr'] = false;
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $empreaq = EmpresaQuery::create()->findOneById($empresaId);
        if ($empreaq) {
            $default['aplica_isr'] = $empreaq->getRetieneIsr();
        }
        $default['exento_isr'] = true;
        $default['aplica_iva'] = true;
        if ($orden) {
            $default['no_documento'] = $orden->getNoDocumento();
            $default['fecha_documento'] = $orden->getFechaDocumento('d/m/Y');
            $default['fecha_contabilizacion'] = $orden->getFechaContabilizacion('d/m/Y');
            $default['dia_credito'] = $orden->getDiaCredito();
            $default['nit'] = $orden->getNit();
            $default['nombre'] = $orden->getNombre();
            $default['observaciones'] = $orden->getComentario();
            $default['exenta'] = $orden->getExcento();
            $default['serie'] = $orden->getSerie();
            $default['tienda_id'] = $orden->getTiendaId();
            $default['aplica_isr'] = $orden->getAplicaIsr();
            $default['aplica_iva'] = $orden->getAplicaIva();
            $default['exento_isr'] = $orden->getExcentoIsr();
        }
        $this->formProducto = new CreaProductoOrdenForm();
        $this->form = new CreaOrdenProveedorForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                if (!$orden) {
                    $this->redirect('orden_compra/index?id=');
                }

//                echo "<pre>";
//                print_r($valores);
//                die();
                $fecha_documento = $valores['fecha_documento'];
                $fecha_documento = explode('/', $fecha_documento);
                $fecha_documento = $fecha_documento[2] . '-' . $fecha_documento[1] . '-' . $fecha_documento[0];
                $fecha_contabilizacion = $valores['fecha_documento'];
                $fecha_contabilizacion = explode('/', $fecha_contabilizacion);
                $fecha_contabilizacion = $fecha_contabilizacion[2] . '-' . $fecha_contabilizacion[1] . '-' . $fecha_contabilizacion[0];
                $orden->setSerie($valores['serie']);
                $orden->setNoDocumento($valores['no_documento']);
                $orden->setDiaCredito($valores['dia_credito']);
//                $orden->setNit($valores['nit']);
//                $orden->setNombre($valores['nombre']);

                $provedorQ = ProveedorQuery::create()->findOneById($valores['proveedor']);
                if ($provedorQ) {
                    $orden->setNit($provedorQ->getNit());
                    $orden->setNombre($provedorQ->getNombre());
                }

                $orden->setAplicaIva($valores['aplica_iva']);
                $orden->setAplicaIsr($valores['aplica_isr']);
                $orden->setProveedorId($valores['proveedor']);
                $orden->setTiendaId(null);
                $orden->setExcentoIsr($valores['exento_isr']);
                if ($valores['tienda_id']) {
                    $orden->setTiendaId($valores['tienda_id']);
                }
                $orden->setComentario($valores['observaciones']);
                $orden->setExcento(false);
                if ($valores['exenta']) {
                    $orden->setExcento(true);
                }
                $orden->setFechaDocumento($fecha_documento);
                $orden->setFechaContabilizacion($fecha_contabilizacion);
                $orden->save();
                $lista = OrdenProveedorDetalleQuery::create()
                        ->withColumn('sum(OrdenProveedorDetalle.ValorTotal)', 'TotalGeneral')
                        ->filterByOrdenProveedorId($orden->getId())
                        ->findOne();
                $orden->setSubTotal(0);
                $orden->setValorTotal(0);
                $orden->setIva(0);
                $tiporegi = '';
                if ($orden->getProveedorId()) {
                    $tiporegi = $orden->getProveedor()->getRegimenIsr();
                }
                if ($lista) {
                    $suma = $lista->getTotalGeneral();
                    $valores = ParametroQuery::ObtenerIva($suma, $orden->getExcento(), $orden->getAplicaIsr(), $orden->getExcentoIsr(), $tiporegi);
                    $iva = $valores['IVA'];
                    $valorSInIVa = $valores['VALOR_SIN_IVA'];
                    $orden->setSubTotal($valorSInIVa);
                    $orden->setValorTotal($suma);
                    $orden->setIva($iva);
                }
                $orden->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect('orden_compra/index');
            }
        }
        $this->listado = OrdenProveedorDetalleQuery::create()
                ->filterByOrdenProveedorId($id)
                ->find();
        $this->servicios = ServicioQuery::create()
                ->filterByActivo(true)
                ->orderByNombre()
                ->find();
        $this->forma = new CreaOrdenLineForm();
        if ($request->isMethod('post')) {
            $this->forma->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->forma->isValid()) {
                $valores = $this->forma->getValues();
            }
        }
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $posibles[] = 'Pendiente';
        $posibles[] = 'Proceso';
        $ordenDetalle = OrdenProveedorDetalleQuery::create()
                ->useOrdenProveedorQuery()
                ->filterByEstatus($posibles, Criteria::IN)
                ->filterByUsuario($usuarioQ->getUsuario())
                ->endUse()
                ->groupByOrdenProveedorId()
                ->find();
        $this->pendientes = $ordenDetalle;

        $tab = 1;
        if ($request->getParameter('tab')) {
            $tab = $request->getParameter('tab');
        }

        $this->tab = $tab;
    }

    public function executePosponer(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $operacion = OrdenProveedorQuery::create()->findOneById($id);
        if ($operacion) {
            $operacion->setEstatus('Pendiente');
            $operacion->save();
            sfContext::getInstance()->getUser()->setAttribute('OrdenId', null, 'seguridad');
            $this->getUser()->setFlash('exito', 'Orden almacenada con exito ' . $operacion->getCodigo());
        }
        $this->redirect('orden_compra/index');
    }

}
