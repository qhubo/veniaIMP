<?php

/**
 * carga_producto actions.
 *
 * @package    plan
 * @subpackage carga_producto
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class carga_productoActions extends sfActions {

    public function executeEliminaProd(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $empresa = EmpresaQuery::create()->findOneById($id);
        $tokenPro = '';
        if ($empresa) {
            $tokenPro = md5($empresa->getCodigo());
        }
        if ($tokenPro <> $token) {
            $this->getUser()->setFlash('error', 'Token de registro incorrecto !Intentar Nuevamente');
            $this->redirect('carga_producto/index');
        }

        $con = Propel::getConnection();
        $con->beginTransaction();
        try {



            $comboProdu = ProductoQuery::create()->filterByEmpresaId($id)->filterByComboProductoId(0, Criteria::GREATER_THAN)->find();
            foreach ($comboProdu as $reg) {
                $pro = ProductoQuery::create()->findOneById($reg->getId());
                $pro->setComboProductoId(null);
                $pro->save();
            }

            $RecetaProdu = ProductoQuery::create()->filterByEmpresaId($id)->filterByRecetaProductoId(0, Criteria::GREATER_THAN)->find();
            foreach ($comboProdu as $reg) {
                $pro = ProductoQuery::create()->findOneById($reg->getId());
                $pro->setRecetaProductoId(null);
                $pro->save();
            }

            $combos = ComboProductoQuery::create()->filterByEmpresaId($id)->find();
            foreach ($combos as $data) {
                $com = ComboProductoQuery::create()->findOneById($data->getId());
                $productoQ = ProductoQuery::create()->findOneByComboProductoId($data->getId());
                if ($productoQ) {
                    $productoQ->setComboProductoId(null);
                    $productoQ->save();
                }


                $detalles = ComboProductoDetalleQuery::create()->filterByComboProductoId($data->getId())->find();
                foreach ($detalles as $deta) {
                    $listaDe = ListaComboDetalleQuery::create()->filterByComboProductoDetalleId($deta->getId())->find();
                    if ($listaDe) {
                        $listaDe->delete();
                    }
                    $deta->delete();
                }
                $com->delete();
            }

            $combos = RecetaProductoQuery::create()->filterByEmpresaId($id)->find();
//            echo "<pre>";
//            print_r($combos);
//            die();
            foreach ($combos as $data) {
                $com = RecetaProductoQuery::create()->findOneById($data->getId());
                $productoQ = ProductoQuery::create()->findOneByRecetaProductoId($data->getId());
                if ($productoQ) {
                    $productoQ->setRecetaProductoId(null);
                    $productoQ->save();
                }
                $detalles = RecetaProductoDetalleQuery::create()->filterByRecetaProductoId($data->getId())->find();
                foreach ($detalles as $deta) {
                    $listaDe = ListaRecetaDetalleQuery::create()->filterByRecetaProductoDetalleId($deta->getId())->find();
                    if ($listaDe) {
                        $listaDe->delete();
                    }
                    $deta->delete();
                }
                $com->delete();
            }



            $codigo = $empresa->getCodigo();
//            $productoMovimiento = ProductoQuery::create()
//                    ->filterByMarcaId($producto->getTipoAparatoId())
//                    ->find();
//            foreach ($productoMovimiento as $reg) {
//                $reg->setMarcaId(null);
//                $reg->save();
//            }

            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', ' uno  ' . $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('carga_producto/index');
        }

        $con2 = Propel::getConnection();
        $con2->beginTransaction();
        try {
            $cantidad = 0;
            $ListaPro = ProductoQuery::create()->filterByEmpresaId($id)->find();
            foreach ($ListaPro as $Producto) {
                $ingesoProducto = OperacionDetalleQuery::create()->filterByProductoId($Producto->getId())->find();
                foreach ($ingesoProducto as $detalle) {
                    $detalle->setProductoId(null);
                    $detalle->save();
                }
//                    $ingesoProductoPro = IngresoProductoDetalleQuery::create()->filterByProductoId($Producto->getId())->find();
//                if ($ingesoProductoPro) {
//                    $ingesoProductoPro->delete();
//                }

                $ingesoProductoPro = IngresoProductoDetalleProQuery::create()->filterByProductoId($Producto->getId())->find();
                if ($ingesoProductoPro) {
                    $ingesoProductoPro->delete();
                }

                $SalidaProducto = SalidaProductoDetalleQuery::create()->filterByProductoId($Producto->getId())->find();
                if ($SalidaProducto) {
                    $SalidaProducto->delete();
                }
                $movimeinto = ProductoMovimientoQuery::create()->filterByProductoId($Producto->getId())->find();
                if ($movimeinto) {
                    $movimeinto->delete();
                }

                $precio = ProductoPrecioQuery::create()->filterByProductoId($Producto->getId())->find();
                if ($precio) {
                    $precio->delete();
                }

                $existePro = ProductoExistenciaQuery::create()->filterByProductoId($Producto->getId())->find();
                if ($existePro) {
                    $existePro->delete();
                }

                $Producto->delete();
                $cantidad++;
            }

            $modelos = ModeloQuery::create()->filterByEmpresaId($id)->find();
            if ($modelos) {
                $modelos->delete();
            }
            $marcas = MarcaQuery::create()->filterByEmpresaId($id)->find();
            if ($marcas) {
                $marcas->delete();
            }

            $tipos = TipoAparatoQuery::create()->filterByEmpresaId($id)->find();
            if ($tipos) {
                $tipos->delete();
            }

            $con2->commit();
        } catch (Exception $e) {
            $con2->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('carga_producto/index');
        }


        $this->getUser()->setFlash('exito', 'Productos Eliminados ' . $cantidad . ' -> Empresa ' . $codigo . ' eliminado con exito');
        $this->redirect('carga_producto/index');
    }

    public function executeMuestra(sfWebRequest $request) {
        
    }

    public function executeCarga(sfWebRequest $request) {
        $this->getResponse()->setContentType('charset=utf-8');
        $id = $request->getParameter('id');
        $this->id = $id;
        $datos = ProveedorPeer::pobladatos($id);
        if (!$datos['valido']) {
            $texto = $datos['pendiente'];
            $textol = implode(' , ', $texto);
            $this->getUser()->setFlash('error', 'Las siguiente columnas no fueron encontradas: ' . $textol);
            $this->redirect('carga_producto/index');
        }
        $this->datos = $datos['datos'];
//        echo "<pre>";
//        print_r($this->datos);
//        die();
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $this->usuario = UsuarioQuery::create()->findOneById($usuarioId);
    }

    public function executeIndex(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $this->empresa = EmpresaQuery::create()->findOneById($empresaId);
        $nombre = null;
        $listado = "";

        if ($nombre) {
            $listado = implode(",", $nombre);
        }
        $this->listado = $listado;
        $admin = sfContext::getInstance()->getUser()->getAttribute('administrador', null, 'seguridad');
        //   if (!$admin){
        //    $this->redirect('inicio/index');
        //  }
    }

    public function executeReporte(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $nombreempresa = "Modelo";
        $nombreEMpresa = 'VENIA LINK';
        $pestanas[] = 'Carga';
        $nombre = "Modelo";

        $filename = "Archivo_Carga_Producto_" . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("TIPO DE ARCHIVO ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->getCell("B1")->setValueExplicit("Archivo carga producto " . strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B1:D1");
        $hoja->getCell("H1")->setValueExplicit("Valores Permitidos perecedero SI / No   Cualquier valor difente a SI incluso vacio se grabara NO ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("H1:L1");
        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');
        $encabezados[] = array("Nombre" => 'codigo_sku', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'codigo_barras', "width" => 35, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'codigo_arancel', "width" => 35, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'codigo_grupo', "width" => 30, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'grupo', "width" => 30, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'codigo_subgrupo', "width" => 30, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'subgrupo', "width" => 30, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'codigo_proveedor', "width" => 30, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Proveedor', "width" => 30, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Marca', "width" => 42, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'CARACTERISTICAS', "width" => 42, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'nombre', "width" => 42, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'descripcion', "width" => 42, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'nombre ingles', "width" => 42, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'precio', "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'costo', "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'EXISTENCIA', "width" => 15, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => 'alto', "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'ancho', "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'largo', "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'peso', "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'costo fabrica', "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'costo cif', "width" => 15, "align" => "left", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $hoja->getStyle('A2:P2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('#E7E5E5');
        $hoja->getStyle('F')->getAlignment()->setWrapText(true);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        //          die();
        $xl->save('php://output');
        die();
        throw new sfStopException();
    }

    public function executeProcesa(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $this->getResponse()->setContentType('charset=utf-8');
        $datos = ProveedorPeer::pobladatos($id);
        $arrayProducto[] = 0;
        $cantidaProducto = 0;
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $logErro = null;
//        echo "<pre>";
//        print_r($datos);
//        die();
        $posicion = 1;
        foreach ($datos['datos'] as $valores) {
            $posicion++;
            $valores['TIPOID'] = null;
            $valores['MARCAID'] = null;
            $valores['MODELOID'] = null;
            $valores['PROVEEDORID'] = null;
            try {
                $con2 = Propel::getConnection();
                $con2->beginTransaction();
                if (trim($valores['GRUPO']) <> "") {
                    $TIPOQuery = TipoAparatoQuery::create()
                            ->filterByEmpresaId($empresaId)
                            ->filterByDescripcion($valores['GRUPO'])
                            ->findOne();
                    if ($TIPOQuery) {
                        if (trim($valores['COD_GRUPO']) <> "") {
                            $TIPOQuery->setCodigo($valores['COD_GRUPO']);
                            $TIPOQuery->save();
                        }
                    }

                    if (!$TIPOQuery) {
                        $TIPOQuery = new TipoAparato();
                        $TIPOQuery->setEmpresaId($empresaId);
                        $TIPOQuery->setDescripcion($valores['GRUPO']);
                    }
                }
                if (trim($valores['COD_GRUPO']) <> "") {
                    $TIPOQuery = TipoAparatoQuery::create()
                            ->filterByEmpresaId($empresaId)
                            ->filterByCodigo($valores['COD_GRUPO'])
                            ->findOne();

                    if (!$TIPOQuery) {
                        $TIPOQuery = new TipoAparato();
                        $TIPOQuery->setEmpresaId($empresaId);
                        $TIPOQuery->setCodigo($valores['COD_GRUPO']);
                        $TIPOQuery->setDescripcion($valores['GRUPO']);
                    }
                }
                $TIPOQuery->save();
                $valores['TIPOID'] = $TIPOQuery->getId();
                $MARCAQuery = null;
                if ($valores['TIPOID']) {
                    if (trim($valores['COD_SUBGRUPO']) <> "") {
                        $MARCAQuery = MarcaQuery::create()
                                ->filterByEmpresaId($empresaId)
                                ->filterByTipoAparatoId($valores['TIPOID'])
                                ->filterByCodigo($valores['COD_SUBGRUPO'])
                                ->findOne();
                        if (!$MARCAQuery) {
                            $MARCAQuery = new Marca();
                            $MARCAQuery->setEmpresaId($empresaId);
                            $MARCAQuery->setTipoAparatoId($valores['TIPOID']);
                            $MARCAQuery->setDescripcion($valores['SUBGRUPO']);
                            $MARCAQuery->setCodigo($valores['COD_SUBGRUPO']);
                        }
                    }
                    if ($MARCAQuery) {
                        $MARCAQuery->save();
                        $valores['MARCAID'] = $MARCAQuery->getId();
                    }
                }
                $MODELOQuery = null;
                $PROVEEDORQuery = null;
                if (trim($valores['PROVEEDOR']) <> "") {
                    $PROVEEDORQuery = ProveedorQuery::create()
                            ->filterByEmpresaId($empresaId)
                            ->filterByNombre($valores['PROVEEDOR'])
                            ->findOne();
                    if (!$PROVEEDORQuery) {
                        $PROVEEDORQuery = new Proveedor();
                        $PROVEEDORQuery->setEmpresaId($empresaId);
                        $PROVEEDORQuery->setNombre($valores['PROVEEDOR']);
                    }
                }
                if (trim($valores['COD_PROVEEDOR']) <> "") {
                    $PROVEEDORQuery = ProveedorQuery::create()
                            ->filterByEmpresaId($empresaId)
                            ->filterByCodigo($valores['COD_PROVEEDOR'])
                            ->findOne();
                    if (!$PROVEEDORQuery) {
                        $PROVEEDORQuery = new Proveedor();
                        $PROVEEDORQuery->setEmpresaId($empresaId);
                        $PROVEEDORQuery->setNombre($valores['PROVEEDOR']);
                        $PROVEEDORQuery->setCodigo($valores['COD_PROVEEDOR']);
                    }
                }
                if (($valores['PROVEEDOR']) && ($valores['COD_PROVEEDOR'])) {
                    if ($PROVEEDORQuery) {
                        $PROVEEDORQuery->save();
                        $valores['PROVEEDORID'] = $PROVEEDORQuery->getId();
                    }
                }
                $con2->commit();
            } catch (Exception $e) {
                $con2->rollback();
                if ($e->getMessage()) {
                    $mensaje = $e->getMessage();
                    $mensaje = str_replace('Unable', '', $mensaje);
                    $mensaje = str_replace('execute', '', $mensaje);
                    $mensaje = str_replace(' to ', '', $mensaje);
                    $imposibleIngresar = '';
                    if (!$TIPOQuery) {
                        $imposibleIngresar .= " Grupo " . $valores['GRUPO'];
                        $valores['TIPOID'] = null;
                    }
                    if (!$MARCAQuery) {
                        $imposibleIngresar .= " SubGrupo " . $valores['SUBGRUPO'];
                        $valores['MARCAID'] = null;
                        $valores['MODELOID'] = null;
                    }
                    if (!$MODELOQuery) {
                        $imposibleIngresar .= " Categoria " . $valores['CATEGORIA'];
                        $valores['MODELOID'] = null;
                        $valores['MARCAID'] = null;
                    }
                    $mensaje = $imposibleIngresar . " " . $mensaje;
                    if ($imposibleIngresar) {
                        $mensaje = $imposibleIngresar;
                    }
                    $logErro[$valores['LINEA']] = 'LINEA ' . $valores['LINEA'] . " -- " . substr($mensaje, 0, 300);
                    //   $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente ' . $cant);
                    // $this->redirect('carga_producto/index');
                }
            }

            if ($valores['TIPOID']) {
                try {
                    $con = Propel::getConnection();
                    $con->beginTransaction();
                    $nuevo = ProductoQuery::create()->findOneByCodigoSku($valores['CODIGO_SKU']);
                    if (!$nuevo) {
                        $nuevo = new Producto();
                    }
                    $nuevo->setRecetaProductoId(null);
                    $nuevo->setComboProductoId(null);
                    $nuevo->setEmpresaId($empresaId);
                    $nuevo->setMarcaId(null);
                    $nuevo->setModeloId(null);
                    $nuevo->setCostoProveedor(0);
                    $nuevo->setExistencia(0);
                    $nuevo->setPrecio(0);
                    $nuevo->setCodigoSku($valores['CODIGO_SKU']);
                    $nuevo->setCodigoBarras($valores['CODIGOBARRAS']);
                    $nuevo->setCodigoArancel($valores['CODIGO_ARANCEL']);
                    $nuevo->setTipoAparatoId($valores['TIPOID']); // => 3
                    if ($valores['MARCAID']) {
                        $nuevo->setMarcaId($valores['MARCAID']); // => 3
                    }
                    $nuevo->setCodigoProveedor($valores['COD_PROVEEDOR']);
                    if ($valores['PROVEEDORID']) {
                        $nuevo->setProveedorId($valores['PROVEEDORID']);
                    }
                    $MARCAQ = MarcaProductoQuery::create()->findOneByNombre($valores['MARCA']);
                    if (!$MARCAQ) {
                        $MARCAQ = new MarcaProducto();
                        $MARCAQ->setNombre($valores['MARCA']);
                        $MARCAQ->save();
                    }
               
                    $nuevo->setMarcaProducto($valores['MARCA']); // => silver rock
                    $nuevo->setCaracteristica($valores['CARACTERISTICAS']);
                    $nuevo->setNombre($valores['NOMBRE']); // => silver rock
                    $nuevo->setDescripcion($valores['DESCRIPCION']); // => Descripcion\
                    $nuevo->setNombreIngles($valores['NOMBRE_INGLES']); // => silver rock
                    $nuevo->setTercero(false);
                    $nuevo->setPrecio($valores['PRECIO']);
                    $nuevo->setCostoProveedor($valores['COSTO']);
                    $nuevo->setAlto($valores['ALTO']);
                    $nuevo->setAncho($valores['ANCHO']); // => 5
                    $nuevo->setPeso($valores['PESO']);
                    $nuevo->setLargo($valores['LARGO']); // => 5
                    $nuevo->setCostoFabrica($valores['COSTO_FABRICA']); // => 5
                    $nuevo->setCostoCif($valores['COSTO_CIF']); // => 5
                    $nuevo->save();
//                echo "<pre>";
//                print_r($nuevo);
//                die();
                    //    }
                    $cantidaProducto++;
                    $con->commit();
                    $productoID = $nuevo->getId();
                } catch (Exception $e) {
                    $con->rollback();
                    $productoID = null;
                    if ($e->getMessage()) {
                        $mensaje = $e->getMessage();

                        $mensaje = str_replace('Unable', '', $mensaje);
                        $mensaje = str_replace('execute', '', $mensaje);
                        $mensaje = str_replace(' to ', '', $mensaje);

//                       echo "<pre>";
//                    print_r($MARCAQuery);
//                    echo "<pre>";
//                    print_r($nuevo);
//                    die();

                        $logErro[$valores['LINEA']] = 'LINEA ' . $valores['LINEA'] . " -- " . substr($mensaje, 0, 4260);
                        //    echo $e->getMessage();
                        $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente ' . $cant);
                        $this->redirect('carga_producto/index');
                    }
                }
                /////
                if ($productoID) {

                    $CANTIDAD = $valores['EXISTENCIA'];
                    if ($CANTIDAD > 0) {
                        $bodegaId = $usuarioQue->getTiendaId();
                        if (!$bodegaId) {
                            $BodegaQ = TiendaQuery::create()->findOne();
                            $bodegaId = $BodegaQ->getId();
                        }
                        ProductoMovimientoQuery::Ingreso($productoID, $CANTIDAD, 'INCARGA', "Ingreso Inventario");
                        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
                        ProductoExistenciaQuery::Actualiza($productoID, $CANTIDAD, $bodegaId);
                        $ListaProductos = ProductoExistenciaQuery::create()
                                ->filterByProductoId($productoID)
                                ->withColumn('sum(ProductoExistencia.Cantidad)', 'ValorTotal')
                                ->findOne();
                        $nuevaExistencia = $ListaProductos->getValorTotal();
                        $nuevo->setExistencia($nuevaExistencia);
                        $nuevo->save();
                    }
                }
            }
        }


        if ($logErro) {
            $MENSA = "";
            foreach ($logErro as $te) {
                $MENSA .= " " . $te . ",";
            }
            $this->getUser()->setFlash('error', $MENSA . "  Producto NO cargados " . count($logErro));
        }
        $this->getUser()->setFlash('exito', ' Producto ingresados con exito ' . $cantidaProducto);
        $this->redirect('carga_producto/index');
    }

}
