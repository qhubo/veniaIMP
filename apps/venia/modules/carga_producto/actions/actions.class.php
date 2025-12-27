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

        // $this->getUser()->setFlash('exito',' !Intentar Nuevamente ');
        $this->datos = $datos['datos'];
//        echo "<pre>";
//        print_r($this->datos);
//        die();
    //    $this->datos=null;
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $this->usuario = UsuarioQuery::create()->findOneById($usuarioId);
        //   die();
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
        $encabezados[] = array("Nombre" =>  'codigo_sku', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" =>  'codigo_barras', "width" => 35, "align" => "left", "format" => "@");

        $encabezados[] = array("Nombre" =>  'codigo_grupo', "width" => 30, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" =>  'grupo', "width" => 30, "align" => "left", "format" => "@");

        $encabezados[] = array("Nombre" =>  'codigo_subgrupo', "width" => 30, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" =>  'subgrupo', "width" => 30, "align" => "left", "format" => "@");

        $encabezados[] = array("Nombre" =>  'codigo_categoria', "width" => 30, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" =>  'categoria', "width" => 30, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" =>  'nombre', "width" => 42, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" =>  'descripcion', "width" => 42, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" =>  'perecedero', "width" => 22, "align" => "left", "format" => "@");

        $encabezados[] = array("Nombre" =>  'precio', "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" =>  'codigo_proveedor', "width" => 22, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" =>  'proveedor', "width" => 42, "align" => "left", "format" => "@");
//        $encabezados[] = array("Nombre" =>  'unidad_costo', "width" => 15, "align" => "left", "format" => "#,##0.00");

        $encabezados[] = array("Nombre" =>  'costo', "width" => 15, "align" => "left", "format" => "#,##0.00");
     $encabezados[] = array("Nombre" =>  'cantidad', "width" => 15, "align" => "left", "format" => "#,##0.00");








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
//        die()
        $posicion = 1;
        foreach ($datos['datos'] as $valores) {
            $posicion++;
            $valores['TIPOID'] = null;
            $valores['MARCAID'] = null;
            $valores['MODELOID'] = null;
            $valores['PROVEEDORID'] = null;
            $tipoComponente = false;
            try {
                $con2 = Propel::getConnection();
                $con2->beginTransaction();
                if (strtoupper($valores['GRUPO']) == 'RECIPE') {
                    $valores['GRUPO'] = 'RECETA';
                }

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

                $TIPOQuery->setReceta($tipoComponente);
                $TIPOQuery->save();
                $valores['TIPOID'] = $TIPOQuery->getId();
                $MARCAQuery = null;
                if (trim($valores['SUBGRUPO']) <> "") {
                    $MARCAQuery = MarcaQuery::create()
                            ->filterByEmpresaId($empresaId)
                            ->filterByTipoAparatoId($valores['TIPOID'])
                            ->filterByDescripcion($valores['SUBGRUPO'])
                            ->findOne();
                    if ($MARCAQuery) {
                        if (trim($valores['COD_SUBGRUPO']) <> "") {
                            $MARCAQuery->setCodigo($valores['COD_SUBGRUPO']);
                            $MARCAQuery->save();
                        }
                    }
                    if (!$MARCAQuery) {
                        $MARCAQuery = new Marca();
                        $MARCAQuery->setEmpresaId($empresaId);
                        $MARCAQuery->setTipoAparatoId($valores['TIPOID']);
                        $MARCAQuery->setDescripcion($valores['SUBGRUPO']);
                    }
                }

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
                if (trim($valores['CATEGORIA']) <> "") {
                    $MODELOQuery = ModeloQuery::create()
                            ->filterByEmpresaId($empresaId)
                            ->filterByMarcaId($valores['MARCAID'])
                            ->filterByDescripcion($valores['CATEGORIA'])
                            ->findOne();
                    if ($MODELOQuery) {
                        if (trim($valores['COD_CATEGORIA']) <> "") {
                            $MODELOQuery->setCodigo($valores['COD_CATEGORIA']);
                            $MODELOQuery->save();
                        }
                    }
                    if (!$MODELOQuery) {
                        $MODELOQuery = new Modelo();
                        $MODELOQuery->setEmpresaId($empresaId);
                        $MODELOQuery->setMarcaId($valores['MARCAID']);
                        $MODELOQuery->setDescripcion($valores['CATEGORIA']);
                        $MODELOQuery->save();
                    }
                    $valores['MODELOID'] = $MODELOQuery->getId();
                }
                if (trim($valores['COD_CATEGORIA']) <> "") {
                    $MODELOQuery = ModeloQuery::create()
                            ->filterByEmpresaId($empresaId)
                            ->filterByMarcaId($valores['MARCAID'])
                            ->filterByCodigo($valores['COD_CATEGORIA'])
                            ->findOne();
                    if (!$MODELOQuery) {
                        $MODELOQuery = new Modelo();
                        $MODELOQuery->setEmpresaId($empresaId);
                        $MODELOQuery->setMarcaId($valores['MARCAID']);
                        $MODELOQuery->setDescripcion($valores['CATEGORIA']);
                        $MODELOQuery->setCodigo($valores['COD_CATEGORIA']);
                    }
                }
                if ($MODELOQuery) {
                    $MODELOQuery->save();
                    $valores['MODELOID'] = $MODELOQuery->getId();
                }

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
                        //   $PROVEEDORQuery->save();
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
                    $ComboId = null;
                    if (strtoupper(trim($valores['GRUPO'])) == 'COMBO') {
                       $ComboQ= ComboProductoQuery::create()
                               ->filterByEmpresaId($empresaId)
                               ->filterByCodigoSku($valores['CODIGO'])
                               ->findOne();
               
                       if (!$ComboQ) {
                          $ComboQ = new ComboProducto();   
                       }
             
                      
                        $ComboQ->setNombre($valores['NOMBRE']);
                        $ComboQ->setActivo(true);
                        $ComboQ->setDescripcion($valores['DESCRIPCION']);
                        $ComboQ->setCodigoSku($valores['CODIGO']);
                        $ComboQ->setCodigoBarras($valores['CODIGOBARRAS']);
                        $ComboQ->setPrecio($valores['PRECIO']);
                        $ComboQ->setPrecioVariable(false);
                        $ComboQ->setEmpresaId($empresaId);
                        $ComboQ->save();
                        $ComboId = $ComboQ->getId();
                    }
                    $RecetaId = null;
                    if (strtoupper(trim($valores['GRUPO'])) == 'RECETA') {
                            $recetaQ= RecetaProductoQuery::create()
                               ->filterByEmpresaId($empresaId)
                               ->filterByCodigoSku($valores['CODIGO'])
                               ->findOne();
                            if (!$recetaQ) {
                        $recetaQ = new RecetaProducto();
                            }
                        $recetaQ->setNombre($valores['NOMBRE']);
                        $recetaQ->setDescripcion($valores['DESCRIPCION']);
                        $recetaQ->setActivo(true);
                        $recetaQ->setCodigoSku($valores['CODIGO']);
                        $recetaQ->setCodigoBarras($valores['CODIGOBARRAS']);
                        $recetaQ->setPrecio($valores['PRECIO']);
                        $recetaQ->setPrecioVariable(false);
                        $recetaQ->setEmpresaId($empresaId);
                        $recetaQ->save();
                        $RecetaId = $recetaQ->getId();
                    }



                    //               $cant++;
//                $valores['TIPOID'] = null;
//                $valores['MARCAID'] = null;
//                $valores['MODELOID'] = null;
                    $nuevo = ProductoQuery::create()->findOneByCodigoSku($valores['CODIGO']);
                    if (!$nuevo) {
                        $nuevo = new Producto();
                    }
                    if ($RecetaId) {
                        $nuevo->setRecetaProductoId($RecetaId);
                    }
                    if ($ComboId) {
                        $nuevo->setComboProductoId($ComboId);
                    }
                    $nuevo->setEmpresaId($empresaId);
                    $nuevo->setMarcaId(null);
                    $nuevo->setModeloId(null);
                    $nuevo->setCostoProveedor(0);
                    $nuevo->setExistencia(0);
                    $nuevo->setPrecio(0);
                    $nuevo->setCodigoSku($valores['CODIGO']);
                    $nuevo->setCodigoBarras($valores['CODIGOBARRAS']);
                    $nuevo->setNombre($valores['NOMBRE']." ".$valores['DESCRIPCION']); // => silver rock
                    $nuevo->setDescripcion($valores['DESCRIPCION']); // => Descripcion\
                    $nuevo->setUnidadMedidaCosto($valores['UNIDAD_COSTO']);
                    $nuevo->setUnidadMedidaCosto($valores['UNIDAD_COSTO']);
                    $nuevo->setTipoAparatoId($valores['TIPOID']); // => 3
                    $nuevo->setTercero(false);
                    
                      if ($valores['PERECEDERO'] == 'SI') {
                        $nuevo->setTercero(true);
                    }
                    if ($valores['MARCAID']) {
                        $nuevo->setMarcaId($valores['MARCAID']); // => 3
                    }

                    if ($valores['MODELOID']) {
                        $nuevo->setModeloId($valores['MODELOID']); // => 5
                    }

//                    if ($valores['PROMOCIONAL'] == 'SI') {
//                        $nuevo->setPromocional(true);
//                    }
//                    if ($valores['TOP_VENTA'] == 'SI') {
//                        $nuevo->setTopVenta(true);
//                    }
//                    if ($valores['TRASLADO'] == 'SI') {
//                        $nuevo->setTraslado(true);
//                    }
                  
//                    if ($valores['AFECTO_INVENTARIO'] == 'SI') {
//                        $nuevo->setAfectoInventario(TRUE);
//                    }
                    $nuevo->setCodigoProveedor($valores['COD_PROVEEDOR']);
                    if ($valores['PROVEEDORID']) {
                        $nuevo->setProveedorId($valores['PROVEEDORID']);
                    }
                    $nuevo->setCostoProveedor($valores['COSTO']);
                    $nuevo->setUnidadMedida($valores['UNIDAD']);
                    $nuevo->setPrecio($valores['PRECIO']);
                    $nuevo->setDescripcion($valores['DESCRIPCION']); // => 5
                    $nuevo->save();
//                echo "<pre>";
//                print_r($nuevo);
//                die();
                    //    }
                    $cantidaProducto++;
                    $con->commit();
                    $productoID=$nuevo->getId();
                } catch (Exception $e) {
                    $con->rollback();
                    $productoID=null;
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
                if ($productoID){
                    $CANTIDAD = $valores['CANTIDAD'];
                    if ($CANTIDAD >0) {
                    $bodegaId=$usuarioQue->getTiendaId();
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
