<?php
/**
 * crea_combo actions.
 *
 * @package    plan
 * @subpackage crea_combo
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class crea_comboActions extends sfActions {

   
   public function executeActualizaCosto(sfWebRequest $request) {
 $id = $request->getParameter('id');
        $REcetaDetalle = ComboProductoDetalleQuery::create()
                ->filterByComboProductoId($id)
                ->find();
        foreach ($REcetaDetalle as $RECE) {

            $detalle = ComboProductoDetalleQuery::create()->findOneById($RECE->getId());
            
            $productoQ = ProductoQuery::create()->findOneById($detalle->getProductoDefault());
            if ($productoQ) {
            $PRODUCTOiD= $productoQ->getId();
//            echo $PRODUCTOiD;
//            echo "<br>";
            $producto = ProductoQuery::create()->findOneById($PRODUCTOiD);
            $costo = $producto->getCostoProveedor();
            $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodega');
            $costoProm = $producto->getCostoPromedio($bodegaId, '2019-01-01', date('Y-m-d'));
            if ($costoProm == 0) {
                $costoProm = $costo;
            }
            $costoU = $costo * $detalle->getCantidadMedida();
            $CostoP = $costoProm *$detalle->getCantidadMedida();
             $productoQ->getCodigoSku()." - ".$costoU." ".$CostoP." =? ".$detalle->getCantidadMedida();
         
            $detalle->setCostoUnidad($costoU);
            $detalle->setCostoUnidadPro($CostoP);
            $detalle->save();
  
            }
            
        }
 
        $this->getUser()->setFlash('exito', 'Costos Actualizados autorización');
        $this->redirect('crea_combo/muestra?id=' . $id);
    }
    
    public function executeConfirmar(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id'); //=155555&
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $cotizacion = ComboProductoQuery::create()->findOneById($id);
        if ($cotizacion) {
            $cotizacion->setEstatus("Enviada");
            $cotizacion->setUsuarioCreo($usuarioQ->getUsuario());
            $cotizacion->setFechaCreo(date('Y-m-d H:i:s'));
            $cotizacion->save();
        }
        $this->getUser()->setFlash('exito', 'Producto enviada a proceso de autorización');
        $this->redirect('crea_combo/muestra?id=' . $id);
    }

    public function executeReporte(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&

        $receta = ComboProductoQuery::create()->findOneById($id);
        $detalle = ComboProductoDetalleQuery::create()
                        ->orderByOrden()
                        ->filterByComboProductoId($id)->find();


        $html = $this->getPartial('crea_combo/reporte', array("muestra" => 0,
            'receta' => $receta, 'detalle' => $detalle,));
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Comandss');
        $pdf->SetTitle('COMBO PRODUCTO ' . $receta->getCodigoSku());
        $pdf->SetSubject('Combo Producto');
        $pdf->SetKeywords('Restaurante, receta, medida'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetMargins(6, 5, 0, true);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetHeaderMargin(0.1);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont('courier', '', 10);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $pdf->Output('COMBO PRODUCTO' . $receta->getCodigoSku() . '.pdf', 'I');
        die();
    }

    public function executeEliminaCom(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
//        $Detalle = OperacionDetalleQuery::create()->filterByComboProductoId($id)->find();
//        foreach ($Detalle as $reg) {
//            $data = OperacionDetalleQuery::create()->findOneById($reg->getId());
//            $data->setComboProductoId(null);
//            $data->save();
//        }
        $Detalle = ListaComboDetalleQuery::create()->filterByComboProductoDetalleId($id)->find();
        if ($Detalle) {
            $Detalle->delete();
        }
        $cliente = ComboProductoDetalleQuery::create()->findOneById($id);
        $ComboId = $cliente->getComboProductoId();
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            
//            $producto = ProductoQuery::create()->findOneByComboProductoId($ComboId);
//            $producto->setComboProductoId(null);
//            $producto->save();
            $cliente->delete();
            $con->commit();
            $this->getUser()->setFlash('error', 'Componente eliminado con exito');
            $this->redirect('crea_combo/muestra?id=' . $ComboId);
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('crea_combo/muestra?id=' . $ComboId);
        }
    }

    public function executeEliminaLista(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $lsitaPro = ListaComboDetalleQuery::create()->findOneById($id);
        $comid = $lsitaPro->getComboProductoDetalle()->getComboProductoId();
        if ($lsitaPro) {
            $lsitaPro->delete();
        }
        $this->getUser()->setFlash('error', 'Producto eliminado con exito');
        $this->redirect('crea_combo/muestra?id=' . $comid);
    }

    public function executeProducto(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $recetaProductoDetalle = ComboProductoDetalleQuery::create()->findOneById($id);
        $marcaId = $recetaProductoDetalle->getMarcaId();
        $this->receta = $recetaProductoDetalle;
        $Productos = ProductoQuery::create()
                ->orderByNombre()
                ->filterByTipoAparatoId($recetaProductoDetalle->getSeleccion())
                ->find();
        $this->Productos = $Productos;
        if ($request->isMethod('post')) {
            $valor = $request->getParameter('em');
            $precio = $request->getParameter('precio_d');

            if ($valor > 0) {

                $detalle = new ListaComboDetalle();
                $detalle->setComboProductoDetalleId($id);
                $detalle->setProductoId($valor);
                $detalle->setPrecio($precio);
                $detalle->save();
                $this->getUser()->setFlash('exito', 'Producto agregado con exito');
            } else {
                $this->getUser()->setFlash('error', 'Ningun producto seleccinado');
            }
            $this->redirect('crea_combo/muestra?id=' . $recetaProductoDetalle->getComboProductoId());
        }
//        echo "<pre>";
//        print_r($Productos);
//        die();
    }

    public function executeMontoAdicional(sfWebRequest $request) {
        $precio = $request->getParameter('id');
        $id = $request->getParameter('idv');
        $operacionDetalle = ListaComboDetalleQuery::create()->findOneById($id);
        $operacionDetalle->setPrecio($precio);
        $operacionDetalle->save();
        echo $precio;
        die();
    }

    public function executeMonto(sfWebRequest $request) {
        $precio = $request->getParameter('id');
        $id = $request->getParameter('idv');
        $operacionDetalle = ComboProductoDetalleQuery::create()->findOneById($id);
        $operacionDetalle->setPrecio($precio);
        $operacionDetalle->save();
        $opera = ComboProductoDetalleQuery::create()
                ->filterByComboProductoId($operacionDetalle->getComboProductoId())
                ->withColumn('sum(ComboProductoDetalle.Precio)', 'TotalValor')
                ->findOne();
        $va = number_format($opera->getTotalValor(), 2);
        echo $va;
        die();
    }

    public function executeSube(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $operacionDetalle = ComboProductoDetalleQuery::create()->findOneById($id);
        $recetaId = $operacionDetalle->getComboProductoId();
        $ordenActual = $operacionDetalle->getOrden();
        $operaciones = ComboProductoDetalleQuery::create()
                ->orderByOrden()
                ->find();
        foreach ($operaciones as $lista) {
            $esteOrden = $lista->getOrden();
            $nuevoOrden = $esteOrden;
            if ($ordenActual == $esteOrden) {
                $nuevoOrden = $esteOrden - 1;
            }
            if (($ordenActual - 1) == $esteOrden) {
                $nuevoOrden = $esteOrden + 1;
            }
            $lista->setOrden($nuevoOrden);
            $lista->save();
        }
        $this->redirect('crea_combo/muestra?id=' . $recetaId);
    }

    public function executeBaja(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $operacionDetalle = ComboProductoDetalleQuery::create()->findOneById($id);
        $recetaId = $operacionDetalle->getComboProductoId();
        $ordenActual = $operacionDetalle->getOrden();
        $operaciones = ComboProductoDetalleQuery::create()
                ->orderByOrden()
                ->find();
        foreach ($operaciones as $lista) {
            $esteOrden = $lista->getOrden();
            $nuevoOrden = $esteOrden;
            if ($ordenActual == $esteOrden) {
                $nuevoOrden = $esteOrden + 1;
            }
            if (($ordenActual + 1) == $esteOrden) {
                $nuevoOrden = $esteOrden - 1;
            }
            $lista->setOrden($nuevoOrden);
            $lista->save();
        }
        $this->redirect('crea_combo/muestra?id=' . $recetaId);
    }

    public function executeElimina(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $cliente = ComboProductoQuery::create()->findOneById($id);
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $producto = ProductoQuery::create()->findOneByComboProductoId($id);
            if ($producto) {
                $productoE = ProductoExistenciaQuery::create()->filterByProductoId($producto->getId())->find();
                if ($productoE) {
                    $productoE->delete();
                }
                $productoE = ProductoMovimientoQuery::create()->filterByProductoId($producto->getId())->find();
                if ($productoE) {
                    $productoE->delete();
                }
                $producto->delete();
            }
//            $productoE = ProductoExistenciaQuery::create()->filterByProductoId($producto->getId())->find();
//            if ($productoE) {
//                $productoE->delete();
//            }

            $detalle = ComboProductoDetalleQuery::create()
                    ->filterByComboProductoId($id)
                    ->find();
            foreach ($detalle as $de){
                $lista = ListaComboDetalleQuery::create()
                        ->filterByComboProductoDetalleId($de->getId())
                        ->find();
                foreach ($lista as $dd) {
                    $dd->delete();
                }
                $de->delete();
                
            }

            $cliente->delete();
            $con->commit();
            $this->getUser()->setFlash('error', 'Campo ' . $cliente->getId() . ' eliminado con exito');
            $this->redirect('crea_combo/index');
        }
        catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('crea_combo/index');
        }
    }

    public function executeIndex(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $this->combos = ComboProductoQuery::create()->filterByEmpresaId($empresaId)->find();
    }

    public function ordena($id) {
        $categoriaA = ComboProductoDetalleQuery::create()->filterByComboProductoId($id)->orderByOrden("Asc")->find();
        $con = 0;
        foreach ($categoriaA as $regi) {
            $con++;
            $regi->setUltimo(false);
            $regi->setOrden($con);
            if ($con == count($categoriaA)) {
                $regi->setUltimo(true);
            }
            $regi->save();
        }
    }

    public function executeMuestra(sfWebRequest $request) {
                        $this->costo =0;
        $this->unidad ='';
        $this->costo_unidad ='';
        $this->costo2 =0;
        $this->unidad2 ='';
       $this->costo_unidad2 ='';
        $id = $request->getParameter('id');
        $carpetaArchivos = sfConfig::get('sf_upload_dir'); // $ParametroConexion['ruta'];
        $carpetaArchivos .= DIRECTORY_SEPARATOR;
        $val = 0;
        if ($request->getParameter('val')) {
            $val = $request->getParameter('val');
        }
        $c = $request->getParameter('c');
        $this->val = $val;

        $tab = 2;
        if ($request->getParameter('tab')) {
            $tab = $request->getParameter('tab');
        }
        $campoQuer = ComboProductoDetalleQuery::create()->findOneById($val);
        if ($campoQuer) {
            $id = $campoQuer->getComboProductoId();
        }

        if (!$id) {
            $tab = 1;
        }
        $this->tab = $tab;
        $this->id = $id;
        $recetaQ = ComboProductoQuery::create()->findOneById($id);
              $this->estatus='';
                if ($recetaQ) {
            $this->estatus=$recetaQ->getEstatus();
        }
        $this->combo = $recetaQ;
        $this->ordena($id);
        $this->catalogo = ComboProductoQuery::create()->findOneById($id);
        $default['activo'] = true;
        $default['obligatorio'] = true;

        if ($campoQuer) {
            sfContext::getInstance()->getUser()->setAttribute("usuario", $campoQuer->getMarcaId(), 'marca');
            sfContext::getInstance()->getUser()->setAttribute("usuario", $campoQuer->getSeleccion(), 'tipo');
            $default['tipo_aparato_id'] = $campoQuer->getSeleccion();
            $default['marca_id'] = $campoQuer->getMarcaId();
            $default['obligatorio'] = $campoQuer->getObligatorio();
            $default['producto_id'] = $campoQuer->getProductoDefault();
            $default['precio'] = $campoQuer->getPrecio();
                        $default['unidad_medida']=$campoQuer->getUnidadMedida();
            $default['cantidad_medida']=$campoQuer->getCantidadMedida();
            $default['costo_unidad']=$campoQuer->getCostoUnidad();
            $default['costo_pro']=$campoQuer->getCostoProducto(); 
                 
        $this->unidad =$campoQuer->getUnidadMedida();
             $this->costo_unidad =$campoQuer->getCostoUnidad();
                $this->costo =$campoQuer->getCostoProducto(); 
             $this->costo_unidad2 =$campoQuer->getCostoUnidadPro();
                $this->costo2 =$campoQuer->getCostoPromedio(); 
                
             
            // $default['descripcion'] = $campoQuer->getDescripcion();
        }

        $this->forma = new ComboProductoCreaSeleForm($default);
        $this->campos = ComboProductoDetalleQuery::create()->orderByOrden()->filterByComboProductoId($id)->find();
        if ($c) {
            if ($request->isMethod('post')) {
                $this->forma->bind($request->getParameter("ingreso"));
                if ($this->forma->isValid()) {
                    $valores = $this->forma->getValues();
//                    echo "<pre>";
//                    print_r($valores);
//                    die();
                    
                    $productoV =$valores['producto_id'];
                    $arrayPro = explode("-", $productoV);
                    $valores['producto_id']=$arrayPro[1];
//                    
//                    echo "<pre>";
//                    print_r($valores);
//                    die();
                    $nuevoCampo = new ComboProductoDetalle();
                    if ($campoQuer) {
                        $nuevoCampo = $campoQuer;
                    }
                    $nuevoCampo->setComboProductoId($id);
                    $nuevoCampo->setSeleccion($valores['tipo_aparato_id']);
                    if ($valores['marca_id']) {
                    $nuevoCampo->setMarcaId($valores['marca_id']);
                    }
                    $nuevoCampo->setObligatorio($valores['obligatorio']);
                    $nuevoCampo->setProductoDefault($valores['producto_id']);
                    $nuevoCampo->setUnidadMedida($valores['unidad_medida']);
                    $nuevoCampo->setCantidadMedida($valores['cantidad_medida']);
                    $nuevoCampo->setCostoUnidad($valores['costo_unidad']);
                    $nuevoCampo->setCostoProducto($valores['costo_pro']);
                  
                      $nuevoCampo->setCostoUnidadPro($valores['costo_unidad2']);
                    $nuevoCampo->setCostoPromedio($valores['costo_pro2']);
                  
                    
                   // $nuevoCampo->setDescripcion($valores['descripcion']);
                    $nuevoCampo->setPrecio($valores['precio']);
                    $con = Propel::getConnection();
                    $con->beginTransaction();
                    try {
                        $this->getUser()->setFlash('exito', 'Campo agregado exitosamente');
                        $nuevoCampo->save();
                        $con->commit();
                    } catch (Exception $e) {
                        $con->rollback();
                        if ($e->getMessage()) {
                            $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente ');
                        }
                    }

                    $this->redirect("crea_combo/muestra?id=" . $id);
                }
            }
        }
        $default = null;
        $default['activo'] = true;
        if ($recetaQ) {
            $default['nombre'] = $recetaQ->getNombre();
            // $default['vence'] = $recetaQ->getVence();
            $default['activo'] = $recetaQ->getActivo();
            //  $default['fechaFin'] = $recetaQ->getFechaFin('d/m/Y');
            $default['precio_variable'] = $recetaQ->getPrecioVariable();
            $default['precio'] = $recetaQ->getPrecio();
            $default['codigo_sku'] = $recetaQ->getCodigoSku();
            $default['codigo_barras'] = $recetaQ->getCodigoBarras();
        }
            $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
   
        $this->form = new CreaComboForm($default);
        if (!$c) {
            if ($request->isMethod('post')) {
                $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
                if ($this->form->isValid()) {
                    $valores = $this->form->getValues();
                    
             
                    
                    $this->getUser()->setFlash('exito', 'Combo actualizado con exito');
                    $nuevo = 0;
                    $con = Propel::getConnection();
                    $con->beginTransaction();
                    try {
                        if (!$recetaQ) {
                            $nuevo = 1;
                            $recetaQ = new ComboProducto();
                            $recetaQ->setNombre($valores['nombre']);
                            $recetaQ->save();
                            $this->getUser()->setFlash('exito', 'Combo creado  con exito');
                        }

                        $recetaQ->setActivo($valores['activo']);
                        $recetaQ->setPrecio($valores['precio']);
                        $recetaQ->setCodigoSku($valores['codigo_sku']);
                        $recetaQ->setCodigoBarras($valores['codigo_barras']);
                        $recetaQ->setPrecio($valores['precio']);
                        $recetaQ->setPrecioVariable($valores['precio_variable']);
                        $recetaQ->save();
             
                        $recetaId = $recetaQ->getId();
                        $producto = ProductoQuery::create()->findOneByComboProductoId($recetaId);
                        if (!$producto) {
                            $tipo = TipoAparatoQuery::create()
                                    ->filterByEmpresaId($empresaId)
                                    ->filterByDescripcion('COMBO')
                                    ->findOne();
                            if (!$tipo) {
                                $tipo = New TipoAparato();
                                $tipo->setEmpresaId($empresaId);
                                $tipo->setActivo(false);
                                $tipo->setDescripcion('COMBO');
                                $tipo->save();
                            }
                            $producto = new Producto();
                            $producto->setTipoAparatoId($tipo->getId());
                        }
                        $producto->setNombre($recetaQ->getNombre());
                        $producto->setDescripcion($recetaQ->getDescripcion());
                        $producto->setActivo($recetaQ->getActivo());
                        $producto->setComboProductoId($recetaQ->getId());
                        $producto->setTopVenta(true);
                        $producto->setTraslado(false);
                        $producto->setPromocional(false);
                        $producto->setExistencia(0);
                        $producto->setCodigoSku($valores['codigo_sku']);
                        $producto->setPrecio($valores['precio']);
                        $producto->setCodigoBarras($valores['codigo_barras']);
                        $producto->setAfectoInventario($valores['afecto_inventario']);
                        $producto->save();
                        if ($valores['codigo_sku'] == "") {
                            $recetaQ->setCodigoSku($producto->getCodigoSku());
                            $recetaQ->save();
                        }

                        $imagen = $valores['archivo'];
                        if ($imagen) {
                            $nombre = "IMAGEN" . sha1(rand(1, 10) . date('YmdHi'));
                            $filename = $nombre . date("ymd") . $imagen->getExtension($imagen->getOriginalExtension());
                            $imagen->save($carpetaArchivos . 'producto/' . DIRECTORY_SEPARATOR . $filename);
                            $producto->setImagen('/uploads/producto/' . $filename);
                            $producto->save();
                            $recetaQ->setImagen('/uploads/producto/' . $filename);
                            $recetaQ->save();
                        }
                        $con->commit();
                    } catch (Exception $e) {
                        $con->rollback();
                        if ($e->getMessage()) {
                            $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente ');
                        }
                    }
                    if ($nuevo) {
                        //       $this->redirect('crea_combo/asignacionCampos?id=' . $recetaId);
                    }
                    $this->redirect('crea_combo/muestra?id=' . $recetaId);
                }
            }
        }
          
    }

}
