<?php

/**
 * edita_producto actions.
 *
 * @package    plan
 * @subpackage edita_producto
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class edita_productoActions extends sfActions {

    public function executeProveedor(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $proveeor = ProveedorQuery::create()->findOneById($id);
        $coi = '';
        if ($proveeor) {
            $coi = $proveeor->getCodigo();
        }
        echo $coi;
        die();
    }

    public function executeCodigo(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $canti = ProductoQuery::create()
                ->filterByCodigoSku($id)
                ->count();
        $retun = 0;
        if ($canti > 0) {
            $retun = 1;
        }
        echo $retun;
        die();
    }

    public function executeActualizar(sfWebRequest $request) {
        $retorna = ProcesoTareaQuery::Productos();
        $this->getUser()->setFlash('exito', $retorna);
        $this->redirect('edita_producto/index');
    }

    public function executeFoto(sfWebRequest $request) {
//        $url = '<img width="100%"  src="https://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />';
//        $Id = $request->getParameter('id'); //=155555&
//        $this->id = $Id;
//        $this->registro = ProductoQuery::create()->findOneById($Id);
//        if ($this->registro->getImagen()) {
//            $url = '<img width="100%"  src="' . $this->registro->getImagen() . '" alt="" />';
//        }
//
//        $defa['promocional'] = $this->registro->getPromocional();
//        $defa['traslado'] = $this->registro->getTraslado();
//        $defa['top_venta'] = $this->registro->getTopVenta();
//        $defa['salida'] = $this->registro->getSalida();
//        $defa['opcion_combo'] = $this->registro->getOpcionCombo();
//        $defa['bodega_interna']= $this->registro->getBodegaInterna();
//        $this->form = new ListaImagenIngForm($defa);
//        $carpetaArchivos = sfConfig::get('sf_upload_dir'); // $ParametroConexion['ruta'];
//        $carpetaArchivos .= DIRECTORY_SEPARATOR;
//        if ($request->isMethod('post')) {
//            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
//            if ($this->form->isValid()) {
//                $valores = $this->form->getValues();
//                $registro = ProductoQuery::create()->findOneById($Id);
//                $registro->setBodegaInterna($valores['bodega_interna']);
//                $registro->setPromocional($valores['promocional']); //=$this->registro->getPromocional();
//                $registro->setTraslado($valores['traslado']); //==$this->registro->getTraslado();
//                $registro->setTopVenta($valores['top_venta']); //==$this->registro->getTopVenta();
//                $registro->setSalida($valores['salida']); //==$this->registro->getSalida();
//                $registro->setOpcionCombo($valores['opcion_combo']);  //==$this->registro->getOpcionCombo();
//
//                $registro->save();
//                $this->getUser()->setFlash('exito', ' Informacion actualizada con exito  ');
//                $imagen = $valores['imagen'];
//                if ($imagen) {
//                    $
//                     = "IMAGEN" . sha1(rand(1, 10) . date('YmdHi'));
//                    $filename = $nombre . date("ymd") . $imagen->getExtension($imagen->getOriginalExtension());
//                    $imagen->save($carpetaArchivos . 'producto/' . DIRECTORY_SEPARATOR . $filename);
//
//                    $registro->setImagen('/uploads/producto/' . $filename);
////                    echo '/uploads/producto/'  .$filename;
////                    die();
//                    $registro->save();
//                    $this->getUser()->setFlash('exito', ' Imagen cargada con exito  ');
//                }
//
//                $this->redirect('edita_producto/foto?id=' . $Id);
//            }
//        }
//        $this->url = $url;
    }

    public function executeElimina(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $producto = ProductoQuery::create()->findOneById($id);
        $tokenPro = '';
        if ($producto) {
            $tokenPro = md5($producto->getCodigoSku());
        }
        if ($tokenPro <> $token) {
            $this->getUser()->setFlash('error', 'Token de producto incorrecto !Intentar Nuevamente');
            $this->redirect('edita_producto/index');
        }

        $con = Propel::getConnection();
        $con->beginTransaction();
        try {

            $codigo = $producto->getCodigoSku();
//            $productoExistenica = OperacionDetalleQuery::create()
//                    ->filterByProductoId($producto->getId())
//                    ->find();
//            foreach ($productoExistenica as $lis) {
//                $lis->setProductoId(null);
//                $lis->save();
//            }

            $productoExistenica = ProductoExistenciaQuery::create()
                    ->filterByProductoId($producto->getId())
                    ->find();
            if ($productoExistenica) {
                $productoExistenica->delete();
            }

            $productoPrecio = ProductoPrecioQuery::create()
                    ->filterByProductoId($producto->getId())
                    ->find();
            if ($productoPrecio) {
                $productoPrecio->delete();
            }




            $operacionDetalle = OperacionDetalleQuery::create()
                    ->filterByProductoId($producto->getId())
                    ->find();
            foreach ($operacionDetalle as $de) {
                $de->setProductoId(null);
                $de->save();
            }


//            $productoExistenica = ProductoListaSalidaQuery::create()
//                    ->filterByProductoId($producto->getId())
//                    ->find();
//            if ($productoExistenica) {
//                $productoExistenica->delete();
//            }

            $productoMovimiento = ProductoMovimientoQuery::create()
                    ->filterByProductoId($producto->getId())
                    ->find();
            if ($productoMovimiento) {
                $productoMovimiento->delete();
            }

            $producto->delete();

            $con->commit();
            $this->getUser()->setFlash('error', 'Producto ' . $codigo . ' eliminado con exito');
            $this->redirect('edita_producto/index');
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('edita_producto/index');
        }
    }

    public function executeIndex(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $adminsitrador = sfContext::getInstance()->getUser()->getAttribute('administrador', null, 'seguridad');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $datos = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));
        $default['estatus'] = 2;
        $valores = null;
        if ($datos) {
            $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));
            $default = $valores;
        }
        $this->form = new consultaProductoForm($default);
//        $this->total = ProductoQuery::create()->filterByComboProductoId(null)->filterByRecetaProductoId(null)->count();
//        $this->productos = ProductoQuery::create()->filterByComboProductoId(null)->filterByRecetaProductoId(null)->find();
        $this->productos = null;
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'consultaproducto');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));
            }
        }


        if ($valores) {
            $nombre = $valores['producto']; // => 4555
            $tipo = $valores['tipo']; // => 4
            $marca = $valores['marca']; // =>
            $modelo = $valores['modelo']; // =>
            $estatus = $valores['estatus'];
            $operaciones = new ProductoQuery();
            $operaciones->filterByRecetaProductoId(null);
            $operaciones->filterByComboProductoId(null);
            if ($tipo) {
                $operaciones->filterByTipoAparatoId($tipo);
            }
//            if ($estatus == 0) {
//                $operaciones->filterByEstatus(0);
//            }
            if ($nombre <> "") {
                $operaciones->where("(Producto.CodigoSku like '%" . $nombre . "%' or Producto.Nombre like '%" . $nombre . "%')");
            }

            if ($estatus == 1) {
                $operaciones->filterByEstatus(1);
            }
            if ($marca) {
                $operaciones->filterByMarcaId($marca);
            }
            if ($modelo) {
                $operaciones->filterByModeloId($modelo);
            }
            $this->productos = $operaciones->find();
        }
        $this->totalB = count($this->productos);
    }

    public function executeMuestra(sfWebRequest $request) {
        sfContext::getInstance()->getUser()->setAttribute('tipo_id', null, 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('marca_id', null, 'seguridad');

        $carpetaArchivos = sfConfig::get('sf_upload_dir'); // $ParametroConexion['ruta'];
        $carpetaArchivos .= DIRECTORY_SEPARATOR;
        $id = $request->getParameter('id');
        $tab = $request->getParameter('tab');
        $this->tab = 1;
        if ($tab) {
            $this->tab = $tab;
        }
        $this->id = $id;
        $this->producto = ProductoQuery::create()->findOneById($id);
        $producto = ProductoQuery::create()->findOneById($id);
        $valores = null;
        $valores['activo'] = true;
        if ($producto) {
            $valores['codigo_sku'] = $producto->getCodigoSku();
            $valores['nombre'] = $producto->getNombre();
            $valores['descripcion'] = $producto->getDescripcion(); // > aa
            //     $valores['descripcion_corta'] = $producto->getDescripcionCorta(); //
            $valores['tipo'] = $producto->getTipoAparatoId(); // 4
            $valores['marca'] = $producto->getMarcaId(); //
            $valores['codigo_barras'] = $producto->getCodigoBarras(); //
            $valores['modelo'] = $producto->getModeloId(); //
            $valores['codigo_proveedor'] = $producto->getCodigoProveedor(); //
            $valores['costo'] = $producto->getCostoProveedor();
            $valores['precio'] = $producto->getPrecio(); // 2233
            //   $valores['peso'] = $producto->getCargoPesoLibraProducto(); //
            $valores['estatus'] = $producto->getEstatus(); // 0
            //  $valores['meta_title'] = $producto->getMetaTitulo(); //
            //  $valores['meta_key'] = $producto->getMetaKey(); //
            //   $valores['meta_des'] = $producto->getMetaDescripcion(); //
            //    $valores['garantia_admin'] = $producto->getGarantiaAdministrativo(); //
            //  $valores['garantia_trans'] = $producto->getGarantiaTransporte(); //
            //   $valores['dia_garantia'] = $producto->getDiaGarantia(); //
            //     $valores['alerta_minima'] = $producto->getAlertaMinimo(); //
            $valores['tercero'] = $producto->getTercero(); //
            $valores['activo'] = $producto->getActivo(); //
            //  $valores['factura_servicio'] = $producto->getFacturaServicio();
            //  $valores['link_descarga'] = $producto->getLinkDescarga();
            //  $valores['alto'] = $producto->getAlto();
            //  $valores['ancho'] = $producto->getAncho();
            //  $valores['largo'] = $producto->getLargo();
            $valores['promocional'] = $producto->getPromocional();
            $valores['unidad_medida_costo'] = $producto->getUnidadMedidaCosto();
            $valores['unidad_medida'] = $producto->getUnidadMedida();
            $valores['top_venta'] = $producto->getTopVenta();
            $valores['salida'] = $producto->getSalida();
            $valores['afecto_inventario'] = $producto->getAfectoInventario();
            $valores['traslado'] = $producto->getTraslado();
            $valores['costo_fabrica'] = $producto->getCostoFabrica();
            $valores['costo_cif'] = $producto->getCostoCif();
            $valores['peso'] = $producto->getPeso();
            $valores['caracteristica'] = $producto->getCaracteristica();
            $valores['marcaProducto'] = $producto->getMarcaProducto();
            $valores['codigo_arancel'] = $producto->getCodigoArancel();
            $valores['alto'] = $producto->getAlto();
            $valores['ancho'] = $producto->getAncho();
            $valores['largo'] = $producto->getLargo();
            $valores['nombre_ingles']=$producto->getNombreIngles();
            sfContext::getInstance()->getUser()->setAttribute('tipo_id', $producto->getTipoAparatoId(), 'seguridad');
            sfContext::getInstance()->getUser()->setAttribute('marca_id', $producto->getMarcaId(), 'seguridad');
        }
        $this->form = new EditaProductoForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($valores);
//                die();
                $con = Propel::getConnection();
                $con->beginTransaction();
                try {
                    $nuevo = $this->producto;
                    if (!$nuevo) {
                        $nuevo = new Producto();
                    }
                    $nuevo->setMarcaId(null);
                    $nuevo->setModeloId(null);
                    if ($valores['codigo_sku']) {
                        $nuevo->setCodigoSku($valores['codigo_sku']);
                    }
                    //           $nuevo->setFacturaServicio($valores['factura_servicio']);
                    $nuevo->setNombre($valores['nombre']); // $producto; // silver rock
                    $nuevo->setDescripcion($valores['descripcion']); // $producto; // Descripcion
                    //           $nuevo->setDescripcionCorta($valores['descripcion_corta']); // $producto; //
                    $nuevo->setTipoAparatoId($valores['tipo']); // $producto; // 3
                    if ($valores['marca']) {
                        $nuevo->setMarcaId($valores['marca']); // $producto; // 3
                    }
                    $nuevo->setTercero($valores['tercero']);  //
                    $nuevo->setCodigoBarras($valores['codigo_barras']); // $producto; //
                    if ($valores['modelo']) {
                        $nuevo->setModeloId($valores['modelo']); // $producto; // 5
                    }
                    $nuevo->setCodigoProveedor($valores['codigo_proveedor']); // $producto; //
                    if ($valores['precio']) {
                        $nuevo->setPrecio($valores['precio']); // $producto; // 50
                    }
                    if ($valores['costo']) {
                        $nuevo->setCostoProveedor($valores['costo']); // $producto; // 100
                    }
                    $nuevo->setUnidadMedida($valores['unidad_medida']);
                    $nuevo->setUnidadMedidaCosto($valores['unidad_medida_costo']);

                    //           $nuevo->setAncho($valores['ancho']);
                    //           $nuevo->setLargo($valores['largo']);
                    //           $nuevo->setAlto($valores['alto']);
                    //           $nuevo->setCargoPesoLibraProducto($valores['peso']); // $producto; //
                    $nuevo->setEstatus($valores['estatus']); // $producto; // 0
                    //           $nuevo->setMetaTitulo($valores['meta_title']); // $producto; //
                    //           $nuevo->setMetaKey($valores['meta_key']); // $producto; //
                    //           $nuevo->setMetaDescripcion($valores['meta_des']); // $producto; //
                    //           $nuevo->setGarantiaAdministrativo($valores['garantia_admin']); // $producto; //
                    // //           $nuevo->setGarantiaTransporte($valores['garantia_trans']); // $producto; //
                    //           $nuevo->setDiaGarantia($valores['dia_garantia']); // $producto; //
                    //           $nuevo->setAlertaMinimo($valores['alerta_minima']); // $producto; //
                    $nuevo->setActivo($valores['activo']); // $producto; //
                    //           $nuevo->setLinkDescarga($valores['link_descarga']);
                    $nuevo->setPromocional($valores['promocional']);
                    $nuevo->setTopVenta($valores['top_venta']);
                    $nuevo->setSalida($valores['salida']);
                    $nuevo->setAfectoInventario($valores['afecto_inventario']);
                    $nuevo->setTraslado($valores['traslado']);
                    $nuevo->setNombreIngles($valores['nombre_ingles']);
                    $nuevo->setCaracteristica($valores['caracteristica']);
                    $nuevo->setMarcaProducto($valores['marcaProducto']);
                    $nuevo->setCodigoArancel($valores['codigo_arancel']);
                    $nuevo->setCodigoProveedor($valores['codigo_proveedor']);
                    $nuevo->setCostoFabrica($valores['costo_fabrica']);
                    $nuevo->setCostoCif($valores['costo_cif']);
                    $nuevo->setPeso($valores['peso']);
                    $nuevo->setAlto($valores['alto']);
                    $nuevo->setAncho($valores['ancho']);
                    $nuevo->setLargo($valores['largo']);
                    
                    $nuevo->save();
                    $con->commit();
                } catch (Exception $e) {
                    $con->rollback();
                    if ($e->getMessage()) {
                        $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente ');
                        $this->redirect('edita_producto/muestra?id=' . $id);
                    }
                }
                $imagen = $valores['archivo'];
                if ($imagen) {
                    $nombre = "IMAGEN" . sha1(rand(1, 10) . date('YmdHi'));
                    $filename = $nombre . date("ymd") . $imagen->getExtension($imagen->getOriginalExtension());
                    $imagen->save($carpetaArchivos . 'producto/' . DIRECTORY_SEPARATOR . $filename);

                    $nuevo->setImagen('/uploads/producto/' . $filename);
//                    echo '/uploads/producto/'  .$filename;
//                    die();
                    $nuevo->save();
                    $this->getUser()->setFlash('exito', ' Imagen cargada con exito  ');
                }
//
//
                //   die();
                $this->getUser()->setFlash('exito', 'Producto  con  SKU ' . $nuevo->getCodigoSku() . ' actualizado con exito ');
                $this->redirect('edita_producto/muestra?id=' . $nuevo->getId());
            }
        }
    }

}
