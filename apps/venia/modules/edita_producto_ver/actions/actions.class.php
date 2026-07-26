<?php
class edita_producto_verActions extends sfActions {
    public function executeFoto(sfWebRequest $request) {
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
            $marca_producto=$valores['marca_producto'];
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
            if ($marca_producto) {
                $operaciones->filterByMarcaProducto($marca_producto);
            }
            $this->productos = $operaciones->find();
        }

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
            $valores['origen'] = $producto->getOrigen(); //
            $valores['descripcion'] = $producto->getDescripcion(); // > aa
            $valores['tipo'] = $producto->getTipoAparatoId(); // 4
            $valores['marca'] = $producto->getMarcaId(); //
            $valores['codigo_barras'] = $producto->getCodigoBarras(); //
            $valores['modelo'] = $producto->getModeloId(); //
            $valores['codigo_proveedor'] = $producto->getCodigoProveedor(); //
            $valores['proveedor'] = $producto->getProveedorId(); //
            $valores['estatus'] = $producto->getEstatus(); // 0
            $valores['tercero'] = $producto->getTercero(); //
            $valores['activo'] = $producto->getActivo(); //
            $valores['promocional'] = $producto->getPromocional();
            $valores['unidad_medida_costo'] = $producto->getUnidadMedidaCosto();
            $valores['unidad_medida'] = $producto->getUnidadMedida();
            $valores['top_venta'] = $producto->getTopVenta();
            $valores['salida'] = $producto->getSalida();
            $valores['afecto_inventario'] = $producto->getAfectoInventario();
            $valores['traslado'] = $producto->getTraslado();
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
        $this->form = new EditaProductoVerForm($valores);
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
                    $nuevo->setOrigen($valores['origen']);
                    $nuevo->setMarcaId(null);
                    $nuevo->setModeloId(null);
                    if ($valores['codigo_sku']) {
                        $nuevo->setCodigoSku($valores['codigo_sku']);
                    }
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
                    $nuevo->setActivo($valores['activo']); // $producto; //
                    $nuevo->setNombreIngles($valores['nombre_ingles']);
                    $nuevo->setCaracteristica($valores['caracteristica']);
                    $nuevo->setMarcaProducto($valores['marcaProducto']);
                    $nuevo->setCodigoArancel($valores['codigo_arancel']);
                    $nuevo->setCodigoProveedor($valores['codigo_proveedor']);
                    $nuevo->setPeso($valores['peso']);
                    $nuevo->setAlto($valores['alto']);
                    $nuevo->setAncho($valores['ancho']);
                    $nuevo->setLargo($valores['largo']);
                    if ($valores['proveedor']) {
                    $nuevo->setProveedorId($valores['proveedor']);; //
                    }
                    $nuevo->save();
                    $con->commit();
                } catch (Exception $e) {
                    $con->rollback();
                    if ($e->getMessage()) {
                        $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente ');
                        $this->redirect('edita_producto_ver/muestra?id=' . $id);
                    }
                }
                $imagen = $valores['archivo'];
//                echo "<pre>";
//                print_r($valores['archivo']);
//                die();
                if ($imagen) {
                    $nombre = "IMAGEN" . sha1(rand(1, 10) . date('YmdHi'));
                    $filename = $nombre . date("ymd") . $imagen->getExtension($imagen->getOriginalExtension());
                    $imagen->save($carpetaArchivos . 'producto/' . DIRECTORY_SEPARATOR . $filename);
                    $nuevo->setImagen('/uploads/producto/' . $filename);
                    $nuevo->save();
                    $this->getUser()->setFlash('exito', ' Imagen cargada con exito  ');
                }
                $this->getUser()->setFlash('exito', 'Producto  con  SKU ' . $nuevo->getCodigoSku() . ' actualizado con exito ');
                $this->redirect('edita_producto_ver/muestra?id=' . $nuevo->getId());
            }
        }
    }

}
