<?php

/**
 * orden_cotizacion actions.
 *
 * @package    plan
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class orden_cotizacionActions extends sfActions {

    public function executeEliminaOR(sfWebRequest $request) {
        error_reporting(-1);
        $id = $request->getParameter('id');
        $ordendet = OrdenCotizacionDetalleQuery::create()->filterByOrdenCotizacionId($id)->find();
        if ($ordendet) {
            $ordendet->delete();
        }
        $ordendet = OrdenUbicacionQuery::create()->filterByOrdenCotizacionId($id)->find();
        if ($ordendet) {
            $ordendet->delete();
        }
        $ordenQ = OrdenCotizacionQuery::create()->findOneById($id);
        if ($ordenQ) {
            $this->getUser()->setFlash('error', 'Registro eliminado con exito');
            $ordenQ->delete();
        }
        $this->redirect('orden_cotizacion/index');
    }

    public function executeReceta(sfWebRequest $request) {
        $id = $request->getParameter('id');

        $receta = RecetarioQuery::create()->findOneById($id);
        if (!$receta) {
            $this->redirect('recetario/lista');
        }
        $recetaDetalle = RecetarioDetalleQuery::create()
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->filterByRecetarioId($receta->getId())
                ->find();

        date_default_timezone_set("America/Guatemala");
        $fecha_actual = date("Y-m-d");
        $fecha_vencimiento = date("Y-m-d", strtotime($fecha_actual . "+ 30 day"));
        $posibles[] = 'Proceso';
        $posibles[] = 'Pendiente';
        $codigo = $request->getParameter('codigo');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $EmpresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $operacion = OrdenCotizacionQuery::create()
                ->filterByUsuario($usuarioQ->getUsuario())
                ->filterByEstatus($posibles, Criteria::IN)
                ->findOne();
        if ($operacion) {
            $operacionDetalle = OrdenCotizacionDetalleQuery::create()->filterByOrdenCotizacionId($operacion->getId())->count();
            if ($operacionDetalle > 0) {
                $operacion = null;
            }
        }
        if ($codigo) {
            $operacion = OrdenCotizacionQuery::create()->findOneByCodigo($codigo);
        }
        if (!$operacion) {
            $operacion = new OrdenCotizacion();
            $operacion->setTiendaId(sfContext::getInstance()->getUser()->getAttribute("tienda", null, 'seguridad'));
            $operacion->setUsuario($usuarioQ->getUsuario());
            $operacion->setEstatus('Proceso');
            $operacion->save();
        }
        $tokenGuardado = sha1($operacion->getCodigo());
        $operacion->setToken($tokenGuardado);
        $operacion->setUsuario($usuarioQ->getUsuario());

        // receta
        $operacion->setFecha(date('Y-m-d H:i:s'));
        $operacion->setFechaDocumento(date('Y-m-d H:i:s'));
        $operacion->setFechaVencimiento($fecha_vencimiento);
        $operacion->setClienteId($receta->getClienteId());
        $operacion->setNit($receta->getCliente()->getNit());
        $operacion->setNombre($receta->getCliente()->getNombre());
        $operacion->setTiendaId($usuarioQ->getTiendaId());
        $operacion->setTelefono($receta->getCliente()->getTelefono());
        $operacion->setDireccion($receta->getCliente()->getDireccion());
        $operacion->setCorreo($receta->getCliente()->getCorreoElectronico());
        $operacion->setRecetarioId($receta->getId());
        $operacion->setComentario("receta  #" . $receta->getId() . "  Prescrita " . $receta->getUsuario());
        $operacion->save();

        foreach ($recetaDetalle as $reg) {
            $producto = $reg->getProducto();
            if ($producto->getComboProductoId()) {

                $can = OrdenCotizacionDetalleQuery::create()->filterByOrdenCotizacionId($operacion->getId())->count();
                $comboProductoDetalle = ComboProductoDetalleQuery::create()->filterByComboProductoId($producto->getComboProductoId())->find();
                foreach ($comboProductoDetalle as $combo) {
                    $comboId = $combo->getComboProducto()->getId() . "_" . $can;
                    $id = $combo->getProductoDefault();
                    $producto = ProductoQuery::create()->findOneById($id);
                    if ($producto) {
                        $contador++;
                        $precio = 0;
                        if ($contador == 1) {
                            $precio = $combo->getComboProducto()->getPrecio();
                        }

                        $valoresIva = ParametroQuery::ObtenerIva(($precio * $combo->getCantidadMedida()), false);
                        $valor = $valoresIva['VALOR_SIN_IVA'];
                        $TOTALIVA = $valoresIva['IVA'];
                        $ordenQD = new OrdenCotizacionDetalle();
                        $ordenQD->setCantidad($combo->getCantidadMedida());
                        $ordenQD->setProductoId($producto->getId());
                        $ordenQD->setDetalle("Combo " . $combo->getComboProducto()->getNombre() . " " . $producto->getNombre());
                        $ordenQD->setCodigo($producto->getCodigoSku());
                        $ordenQD->setComboNumero($comboId);
                        $ordenQD->setValorTotal($precio * $combo->getCantidadMedida());
                        $ordenQD->setValorUnitario($precio);
                        $ordenQD->setTotalIva($TOTALIVA);
                        $ordenQD->setOrdenCotizacionId($operacion->getId());
                        $ordenQD->save();
                        $lista = OrdenCotizacionDetalleQuery::create()
                                ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalGeneral')
                                ->filterByOrdenCotizacionId($operacion->getId())
                                ->findOne();
                        $suma = $lista->getTotalGeneral();
                        $valores = ParametroQuery::ObtenerIva($suma, false);
                        $iva = $valores['IVA'];
                        $valorSInIVa = $valores['VALOR_SIN_IVA'];
                        $operacion->setSubTotal($valorSInIVa);
                        $operacion->setValorTotal($suma);
                        $operacion->setIva($iva);
                        $operacion->save();
                    }
                }
            }
            if (!$producto->getComboProductoId()) {
                $valoresIva = ParametroQuery::ObtenerIva($producto->getPrecio(), false);
                $valor = $valoresIva['VALOR_SIN_IVA'];
                $TOTALIVA = $valoresIva['IVA'];
                $ordenQD = new OrdenCotizacionDetalle();
                $ordenQD->setCantidad(1);
                $ordenQD->setProductoId($producto->getId());
                $ordenQD->setDetalle($producto->getNombre());
                $ordenQD->setCodigo($producto->getCodigoSku());
                $ordenQD->setCantidad(1);
                $ordenQD->setValorTotal($producto->getPrecio());
                $ordenQD->setValorUnitario($producto->getPrecio());
                $ordenQD->setTotalIva($TOTALIVA);
                $ordenQD->setOrdenCotizacionId($operacion->getId());
                $ordenQD->save();
                $lista = OrdenCotizacionDetalleQuery::create()
                        ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalGeneral')
                        ->filterByOrdenCotizacionId($operacion->getId())
                        ->findOne();
                $suma = $lista->getTotalGeneral();

                $valores = ParametroQuery::ObtenerIva($suma, false);
                $iva = $valores['IVA'];
                $valorSInIVa = $valores['VALOR_SIN_IVA'];
                $operacion->setSubTotal($valorSInIVa);
                $operacion->setValorTotal($suma);
                $operacion->setIva($iva);
                $operacion->save();
            }
        }
        //    die('x');
        sfContext::getInstance()->getUser()->setAttribute('CotizacionId', $operacion->getId(), 'seguridad');
        $this->getUser()->setFlash('exito', 'Orden creada con exito ' . $operacion->getCodigo());
        $this->redirect('orden_cotizacion/index');
    }

    public function executeCombo(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $OrdenID = sfContext::getInstance()->getUser()->getAttribute('CotizacionId', null, 'seguridad');
        $ordenQ = OrdenCotizacionQuery::create()->findOneById($OrdenID);
        $id = $request->getParameter('id');
        $comboProducto = ComboProductoQuery::create()->findOneById($id);
        $comboProductoDetalle = ComboProductoDetalleQuery::create()
                ->filterByComboProductoId($id)
                ->find();
        $existevalida = true;
        foreach ($comboProductoDetalle as $combo) {
            $id = $combo->getProductoDefault();
            $producto = ProductoQuery::create()->findOneById($id);
            $existencia = $producto->getExistenciaBodega($ordenQ->getTiendaId());
            if ($existencia <= $combo->getCantidadMedida()) {
                $this->getUser()->setFlash('error', 'No hay existencia para el producto seleccionado ' . $producto->getCodigoSku());
                $this->redirect('orden_cotizacion/index?id=');
            }
        }






        $contador = 0;
        if ($ordenQ) {
            $can = OrdenCotizacionDetalleQuery::create()->filterByOrdenCotizacionId($OrdenID)->count();
            foreach ($comboProductoDetalle as $combo) {
                $comboId = $comboProducto->getId() . "_" . $can;
                $id = $combo->getProductoDefault();
                $producto = ProductoQuery::create()->findOneById($id);
                if ($producto) {
                    $contador++;
                    $precio = 0;
                    if ($contador == 1) {
                        $precio = $comboProducto->getPrecio();
                    }
                    $valoresIva = ParametroQuery::ObtenerIva(($precio * $combo->getCantidadMedida()), false);
                    $valor = $valoresIva['VALOR_SIN_IVA'];
                    $TOTALIVA = $valoresIva['IVA'];
                    $ordenQD = new OrdenCotizacionDetalle();
                    $ordenQD->setCantidad($combo->getCantidadMedida());
                    $ordenQD->setProductoId($producto->getId());
                    $ordenQD->setDetalle("Combo " . $comboProducto->getNombre() . " " . $producto->getNombre());
                    $ordenQD->setCodigo($producto->getCodigoSku());
                    $ordenQD->setComboNumero($comboId);
                    $ordenQD->setValorTotal($precio * $combo->getCantidadMedida());
                    $ordenQD->setValorUnitario($precio);
                    $ordenQD->setTotalIva($TOTALIVA);
                    $ordenQD->setOrdenCotizacionId($OrdenID);
                    $ordenQD->setCostoUnitario($producto->getCostoProveedor());
                    $ordenQD->save();
                    $lista = OrdenCotizacionDetalleQuery::create()
                            ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalGeneral')
                            ->filterByOrdenCotizacionId($OrdenID)
                            ->findOne();
                    $suma = $lista->getTotalGeneral();
                    $valores = ParametroQuery::ObtenerIva($suma, false);
                    $iva = $valores['IVA'];
                    $valorSInIVa = $valores['VALOR_SIN_IVA'];
                    $ordenQ->setSubTotal($valorSInIVa);
                    $ordenQ->setValorTotal($suma);
                    $ordenQ->setIva($iva);
                    $ordenQ->save();
                    $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                }
            }
        }
        $this->redirect('orden_cotizacion/index?id=');
    }

    public function executeMuestra(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $token = $request->getParameter('token');
        $ordenQ = OrdenCotizacionQuery::create()->findOneByToken($token);
        if (!$ordenQ) {
            $this->redirect('orden_cotizacion/index');
        }

        $this->orden = $ordenQ;
        $this->lista = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($ordenQ->getId())
                ->find();
    }

    public function executeVista(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $token = $request->getParameter('token');
        $ordenQ = OrdenCotizacionQuery::create()->findOneByToken($token);
        $this->orden = $ordenQ;
        $this->lista = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($ordenQ->getId())
                ->find();
    }

    public function executeConfirmar(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $ordenQ = OrdenCotizacionQuery::create()->findOneById($id);

        $productos = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($id)
                ->find();
        foreach ($productos as $detalle) {
            if ($detalle->getProductoId()) {
                $existencia = $detalle->getProducto()->getExistenciaBodega($ordenQ->getTiendaId());
                $cantidaSOlicita = $detalle->getCantidad();
                if ($cantidaSOlicita > $existencia) {
                    $this->getUser()->setFlash('error', 'No hay existencia de ' . $cantidaSOlicita . ' para el producto seleccionado ' . $detalle->getDetalle());
                    $this->redirect('orden_cotizacion/index?id=');
                }

                if ($existencia <= 0) {
                    $this->getUser()->setFlash('error', 'No hay existencia para el producto seleccionado ' . $detalle->getDetalle());
                    $this->redirect('orden_cotizacion/index?id=');
                }
            }
        }
        sfContext::getInstance()->getUser()->setAttribute('CotizacionId', null, 'seguridad');
        if ($ordenQ) {
            $tokenGuardado = sha1($ordenQ->getCodigo());
            if ($token == $tokenGuardado) {
                $ordenQ->setSolicitarBodega(false);
                $ordenQ->setEstatus("Confirmada");
                if ($ordenQ->getTiendaId() <> 19) {
                    $ordenQ->setFecha(date('Y-m-d H:i:s'));
                }
                $ordenQ->setToken(sha1($ordenQ->getCodigo()));
                $ordenQ->save();
                $idv = OrdenCotizacionQuery::ProcesaAuto($ordenQ);
                $this->getUser()->setFlash('exito', 'Registro actualizado   con exito Grabacion de Pago ');
                $this->redirect('lista_cobro/caja?id=' . $idv);
            }
        }
        $this->redirect('orden_cotizacion/index');
    }

    public function executeManual(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $OrdenID = sfContext::getInstance()->getUser()->getAttribute('CotizacionId', null, 'seguridad');
        $this->forma = new CreaOrdenLineForm();
        if ($request->isMethod('post')) {
            $this->forma->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->forma->isValid()) {
                $valores = $this->forma->getValues();

                $ordenCliente = OrdenCotizacionQuery::create()->findOneById($OrdenID);
                if ($ordenCliente) {
                    $excenta = $ordenCliente->getExcento();
                    $suma = $valores['valor_unitario'];
                    $valoresP = ParametroQuery::ObtenerIva($suma, $excenta);
                    $iva = $valoresP['IVA'];
                    $valorSInIVa = $valoresP['VALOR_SIN_IVA'];
                    $ordenQ = new OrdenCotizacionDetalle();
                    $ordenQ->setCantidad(1);
                    $ordenQ->setDetalle($valores['nombre']);
                    $ordenQ->setCodigo($OrdenID . "-" . rand(1, 9));
                    $ordenQ->setCantidad($valores['cantidad']);
                    $ordenQ->setValorTotal($suma);
                    $ordenQ->setValorUnitario($suma);
                    $ordenQ->setTotalIva($iva);
                    $ordenQ->setOrdenCotizacionId($OrdenID);
                    $ordenQ->save();

                    $lista = OrdenCotizacionDetalleQuery::create()
                            ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalGeneral')
                            ->filterByOrdenCotizacionId($OrdenID)
                            ->findOne();
                    $ordenCliente->setSubTotal(0);
                    $ordenCliente->setValorTotal(0);
                    $ordenCliente->setIva(0);
                    if ($lista) {
                        $suma = $lista->getTotalGeneral();
                        $valores = ParametroQuery::ObtenerIva($suma, $excenta);
                        $iva = $valores['IVA'];
                        $valorSInIVa = $valores['VALOR_SIN_IVA'];
                        $ordenCliente->setSubTotal($valorSInIVa);
                        $ordenCliente->setValorTotal($suma);
                        $ordenCliente->setIva($iva);
                    }
                    $ordenCliente->save();

                    $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                }
            }
        }


        $this->redirect('orden_cotizacion/index?tablista=3');
    }

    public function executeCantidad(sfWebRequest $request) {
        $OperacionId = sfContext::getInstance()->getUser()->getAttribute('CotizacionId', null, 'seguridad');
        $ordenCliente = OrdenCotizacionQuery::create()->findOneById($OperacionId);
        $excenta = $ordenCliente->getExcento();

        $maximo = 9999;

        $cantidad = $request->getParameter('id');
        $ListaId = $request->getParameter('idv');
        $listaProducto = OrdenCotizacionDetalleQuery::create()
                ->filterById($ListaId)
                ->findOne();
        if ($listaProducto->getProductoId()) {
            $maximo = $listaProducto->getProducto()->getExistencia() - $listaProducto->getProducto()->getTransito(); //Bodega($ordenCliente->getTiendaId());
        }

        if ($cantidad > $maximo) {
            $cantidad = $maximo;
        }

        $valor = $listaProducto->getValorUnitario();
        $retorna = $cantidad * $valor;
        $listaProducto->setCantidad($cantidad);
        $listaProducto->setValorTotal($retorna);
        $listaProducto->save();
        $lista = OrdenCotizacionDetalleQuery::create()
                ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalGeneral')
                ->filterByOrdenCotizacionId($OperacionId)
                ->findOne();
        if ($lista) {
            $suma = $lista->getTotalGeneral();

            $valores = ParametroQuery::ObtenerIva($suma, $excenta);
            $iva = $valores['IVA'];
            $valorSInIVa = $valores['VALOR_SIN_IVA'];
        }
        $retorna = "<strong>" . number_format($retorna, 2) . "</strong>";
        $retorna .= '|' . number_format($suma, 2) . "|" . number_format($iva, 2) . "|" . number_format($valorSInIVa, 2) . "|" . $cantidad;
        $ordenCliente->setSubTotal($valorSInIVa);
        $ordenCliente->setValorTotal($suma);
        $ordenCliente->setIva($iva);
        $ordenCliente->save();
        echo $retorna;
        die();
    }

    public function executeValor(sfWebRequest $request) {
        $OperacionId = sfContext::getInstance()->getUser()->getAttribute('CotizacionId', null, 'seguridad');
        $ordenCliente = OrdenCotizacionQuery::create()->findOneById($OperacionId);
        $excenta = $ordenCliente->getExcento();

        $valor = $request->getParameter('id');
        $ListaId = $request->getParameter('idv');
        $listaProducto = OrdenCotizacionDetalleQuery::create()
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
        $lista = OrdenCotizacionDetalleQuery::create()
                ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalGeneral')
                ->filterByOrdenCotizacionId($OperacionId)
                ->findOne();
        if ($lista) {
            $suma = $lista->getTotalGeneral();

            $valores = ParametroQuery::ObtenerIva($suma, $excenta);
            $iva = $valores['IVA'];
            $valorSInIVa = $valores['VALOR_SIN_IVA'];
        }
        $retorna = "<strong>" . number_format($retorna, 2) . "</strong>";
        $retorna .= '|' . number_format($suma, 2) . "|" . number_format($iva, 2) . "|" . number_format($valorSInIVa, 2);

        $ordenCliente->setSubTotal($valorSInIVa);
        $ordenCliente->setValorTotal($suma);
        $ordenCliente->setIva($iva);
        $ordenCliente->save();
        echo $retorna;
        die();
    }

    public function executeEliminaLinea(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $OrdenID = sfContext::getInstance()->getUser()->getAttribute('CotizacionId', null, 'seguridad');
        $ordenDetalle = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($OrdenID)
                ->filterById($id)
                ->findOne();
        $Detalles = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($OrdenID)
                ->filterById($id)
                ->find();
        $combo = $ordenDetalle->getComboNumero();
        if ($combo <> "") {
            $Detalles = OrdenCotizacionDetalleQuery::create()
                    ->filterByOrdenCotizacionId($OrdenID)
                    ->filterByComboNumero($combo)
                    ->find();
        }



        foreach ($Detalles as $ordenDetalle) {
            $OperacionId = $ordenDetalle->getOrdenCotizacionId();
            $ordenCliente = OrdenCotizacionQuery::create()->findOneById($OperacionId);
            $excenta = $ordenCliente->getExcento();
            $ordenDetalle->delete();
            $lista = OrdenCotizacionDetalleQuery::create()
                    ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalGeneral')
                    ->filterByOrdenCotizacionId($OperacionId)
                    ->findOne();
            $ordenCliente->setSubTotal(0);
            $ordenCliente->setValorTotal(0);
            $ordenCliente->setIva(0);
            if ($lista) {
                $suma = $lista->getTotalGeneral();

                $valores = ParametroQuery::ObtenerIva($suma, $excenta);
                $iva = $valores['IVA'];
                $valorSInIVa = $valores['VALOR_SIN_IVA'];
                $ordenCliente->setSubTotal($valorSInIVa);
                $ordenCliente->setValorTotal($suma);
                $ordenCliente->setIva($iva);
            }
            $ordenCliente->save();
            $this->getUser()->setFlash('error', 'Registro eliminado  con exito ');
        }
        $this->redirect('orden_cotizacion/index?id=');
    }

    public function executeServicio(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $OrdenID = sfContext::getInstance()->getUser()->getAttribute('CotizacionId', null, 'seguridad');
        $producto = ServicioQuery::create()->findOneById($id);
        if ($producto) {
            $ordenQ = OrdenCotizacionQuery::create()->findOneById($OrdenID);
            if ($ordenQ) {
                $valoresIva = ParametroQuery::ObtenerIva($producto->getPrecio(), false);
                $valor = $valoresIva['VALOR_SIN_IVA'];
                $TOTALIVA = $valoresIva['IVA'];
                $ordenQD = new OrdenCotizacionDetalle();
                $ordenQD->setCantidad(1);
                $ordenQD->setServicioId($producto->getId());
                $ordenQD->setDetalle($producto->getNombre());
                $ordenQD->setCodigo($producto->getCodigo());
                $ordenQD->setCantidad(1);
                $ordenQD->setValorTotal($producto->getPrecio());
                $ordenQD->setValorUnitario($producto->getPrecio());
                $ordenQD->setTotalIva($TOTALIVA);
                $ordenQD->setOrdenCotizacionId($OrdenID);
                $ordenQD->save();
                $lista = OrdenCotizacionDetalleQuery::create()
                        ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalGeneral')
                        ->filterByOrdenCotizacionId($OrdenID)
                        ->findOne();
                $suma = $lista->getTotalGeneral();

                $valores = ParametroQuery::ObtenerIva($suma, false);
                $iva = $valores['IVA'];
                $valorSInIVa = $valores['VALOR_SIN_IVA'];
                $ordenQ->setSubTotal($valorSInIVa);
                $ordenQ->setValorTotal($suma);
                $ordenQ->setIva($iva);
                $ordenQ->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
            }
        }
        $this->redirect('orden_cotizacion/index?id=');
    }

    public function executeProducto(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $OrdenID = sfContext::getInstance()->getUser()->getAttribute('CotizacionId', null, 'seguridad');
        $producto = ProductoQuery::create()->findOneById($id);
        if ($producto) {
            $ordenQ = OrdenCotizacionQuery::create()->findOneById($OrdenID);
            if ($ordenQ) {

                $existecia = $producto->getExistencia();
                if ($existecia <= 0) {
                    $this->getUser()->setFlash('error', 'No hay existencia para el producto seleccionado ' . $producto->getCodigoSku());
                    $this->redirect('orden_cotizacion/index?id=');
                }

                $valoresIva = ParametroQuery::ObtenerIva($producto->getPrecio(), false);
                $valor = $valoresIva['VALOR_SIN_IVA'];
                $TOTALIVA = $valoresIva['IVA'];
                $ordenQD = new OrdenCotizacionDetalle();
                $ordenQD->setCantidad(1);
                $ordenQD->setProductoId($producto->getId());
                $ordenQD->setDetalle($producto->getNombre());
                $ordenQD->setCodigo($producto->getCodigoSku());
                $ordenQD->setCantidad(1);
                $ordenQD->setValorTotal($producto->getPrecio());
                $ordenQD->setValorUnitario($producto->getPrecio());
                $ordenQD->setTotalIva($TOTALIVA);
                $ordenQD->setOrdenCotizacionId($OrdenID);
                $ordenQD->setCostoUnitario($producto->getCostoProveedor());
                $ordenQD->save();
                $lista = OrdenCotizacionDetalleQuery::create()
                        ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalGeneral')
                        ->filterByOrdenCotizacionId($OrdenID)
                        ->findOne();
                $suma = $lista->getTotalGeneral();

                $valores = ParametroQuery::ObtenerIva($suma, false);
                $iva = $valores['IVA'];
                $valorSInIVa = $valores['VALOR_SIN_IVA'];
                $ordenQ->setSubTotal($valorSInIVa);
                $ordenQ->setValorTotal($suma);
                $ordenQ->setIva($iva);
                $ordenQ->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
            }
        }
        $this->redirect('orden_cotizacion/index?pro=');
    }

    public function executePropi(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $OrdenID = sfContext::getInstance()->getUser()->getAttribute('CotizacionId', null, 'seguridad');
        $provpe = ClienteQuery::create()->findOneById($id);
        if ($provpe->getFacturaPendiente() <> "") {
            $this->getUser()->setFlash('error', 'Imposible realizar proceso cliente posee factura pendiente de pago ' . $provpe->getFacturaPendiente());
            $this->redirect('orden_cotizacion/index?pro=');
        }

        if ($provpe) {
            $ordenQ = OrdenCotizacionQuery::create()->findOneById($OrdenID);
            if ($ordenQ) {
                $ordenQ->setClienteId($id);
                $ordenQ->setPaisId($provpe->getPaisId());
                $ordenQ->setNombre($provpe->getNombreFacturar());
                $ordenQ->setNit($provpe->getNit());
                $ordenQ->setDiaCredito($provpe->getDiasCredito());
                $ordenQ->setTelefono($provpe->getTelefono());
                $ordenQ->setCorreo($provpe->getCorreoElectronico());
                $ordenQ->setDireccion($provpe->getDireccion());
                $ordenQ->save();
//                echo "<pre>";
//                print_r($provpe);
//                die();

                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
            }
        }
        $this->redirect('orden_cotizacion/index?id=');
    }

    public function executeNueva(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $fecha_actual = date("Y-m-d");
//        die('-------');
        $fecha_vencimiento = date("Y-m-d", strtotime($fecha_actual . "+ 30 day"));
        $posibles[] = 'Proceso';
        $posibles[] = 'Pendiente';
        $codigo = $request->getParameter('codigo');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $EmpresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $operacion = OrdenCotizacionQuery::create()
                ->filterByTiendaId($usuarioQ->getTiendaId())
                ->filterByUsuario($usuarioQ->getUsuario())
                ->filterByEstatus($posibles, Criteria::IN)
                ->findOne();
        if ($operacion) {
            $operacionDetalle = OrdenCotizacionDetalleQuery::create()->filterByOrdenCotizacionId($operacion->getId())->count();
            if ($operacionDetalle > 0) {
                $operacion = null;
            }
        }

        if ($codigo) {
            $operacion = OrdenCotizacionQuery::create()->findOneByCodigo($codigo);
        }

        $tIENDAid = sfContext::getInstance()->getUser()->getAttribute("tienda", null, 'seguridad');
        if (!$tIENDAid) {
           
              $this->getUser()->setFlash('error', 'Seleccione tienda ' );
        $this->redirect('inicio/index');
        }
        if (!$operacion) {
            $operacion = new OrdenCotizacion();
            $operacion->setTiendaId($tIENDAid);
            $operacion->setUsuario($usuarioQ->getUsuario());
            $operacion->setEstatus('Proceso');
            $operacion->setFecha(date('Y-m-d H:i:s'));
            $operacion->save();
        }

        if ($tIENDAid <> 19) {
            $operacion->setFechaDocumento(date('Y-m-d H:i:s'));
            $operacion->setFecha(date('Y-m-d H:i:s'));
        }
        $tokenGuardado = sha1($operacion->getCodigo());
        $operacion->setToken($tokenGuardado);
        $operacion->setUsuario($usuarioQ->getUsuario());

        $operacion->setFechaVencimiento($fecha_vencimiento);
        $operacion->save();
        sfContext::getInstance()->getUser()->setAttribute('CotizacionId', $operacion->getId(), 'seguridad');
  
       
       $listaPendi= sfContext::getInstance()->getUser()->getAttribute('CotizacionIPendie', null, 'seguridad');
         if ($listaPendi) {
            sfContext::getInstance()->getUser()->setAttribute('CotizacionIPendie', null, 'seguridad');
            $this->getUser()->setFlash('error', 'No hay existencia para los producto(s) ' . $listaPendi);
        } else {
                  $this->getUser()->setFlash('exito', 'Orden creada con exito ' . $operacion->getCodigo());
        }
        
        $this->redirect('orden_cotizacion/index');
    }

    public function executeIndex(sfWebRequest $request) {

        date_default_timezone_set("America/Guatemala");
        $this->edit = $request->getParameter('edit');
        sfContext::getInstance()->getUser()->setAttribute("lista", false, 'seguridad');
        $id = sfContext::getInstance()->getUser()->getAttribute('CotizacionId', null, 'seguridad');
        $tIENDAid = sfContext::getInstance()->getUser()->getAttribute("tienda", null, 'seguridad');

        $orden = OrdenCotizacionQuery::create()
                ->filterByTiendaId($tIENDAid)
                ->findOneById($id);
        $clienteId = null;
        if ($orden) {
            $clienteId = $orden->getClienteId();
        }
        if (!$orden) {
            sfContext::getInstance()->getUser()->setAttribute("CotizacionId", null, 'seguridad');
        }

        $tablista = 1;
        if ($request->getParameter('tablista')) {
            $tablista = $request->getParameter('tablista');
        }


        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $this->tablista = $tablista;
        $this->orden = $orden;
        $this->cliente = ClienteQuery::create()->findOneById($clienteId);
        $this->id = $id;
        $default = null;
        if ($orden) {
            //  $default['no_documento'] = $orden->getNoDocumento();
            $default['fecha_documento'] = $orden->getFechaDocumento('d/m/Y');
            $default['fecha_contabilizacion'] = $orden->getFechaVencimiento('d/m/Y');
            $default['dia_credito'] = $orden->getDiaCredito();
            $default['nit'] = $orden->getNit();
            $default['nombre'] = $orden->getNombre();
            $default['observaciones'] = $orden->getComentario();
            $default['exenta'] = $orden->getExcento();
            $default['direccion'] = $orden->getDireccion();
            $default['telefono'] = $orden->getTelefono();
            $default['correo'] = $orden->getCorreo();
            $default['vendedor_id'] = $orden->getVendedorId();

            //$default['serie'] = $orden->getSerie();
            $default['tienda_id'] = $usuarioQ->getTiendaId();
        }
        $this->form = new CreaOrdenCotizacionForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                if (!$orden) {
                    $this->redirect('orden_cotizacion/index?id=');
                }


                $NIT = $valores['nit'];
                $NIT = str_replace(".", "", $NIT);
                $NIT = str_replace("/", "", $NIT);
                $NIT = str_replace("-", "", $NIT);
                $NIT = str_replace("_", "", $NIT);
                $NIT = str_replace(" ", "", $NIT);
                $NIT = strtoupper(TRIM($NIT));
                $CODIGO = '';
                if ($NIT <> "") {
                    if ($NIT <> 'CF') {
                        $operacion = OperacionQuery::create()
                                ->filterByPermiteFacturar(true, Criteria::NOT_EQUAL)
                                ->filterByNit($valores['nit'])
                                ->filterByPagado(false)
                                ->where("Operacion.Fecha < DATE_SUB(NOW(), INTERVAL 6 MONTH)")
                                ->findOne();
                        if ($operacion) {
                            $this->getUser()->setFlash('error', 'Imposible realizar proceso cliente posee factura pendiente de pago ' . $operacion->getCodigo());
                            $this->redirect('orden_cotizacion/index?pro=');
                        }

                        $operacion = OperacionQuery::create()
                                ->filterByPermiteFacturar(true, Criteria::NOT_EQUAL)
                                ->useClienteQuery()
                                ->filterByNit($valores['nit'])
                                ->endUse()
                                ->filterByPagado(false)
                                ->where("Operacion.Fecha < DATE_SUB(NOW(), INTERVAL 6 MONTH)")
                                ->findOne();
                        if ($operacion) {
                            $this->getUser()->setFlash('error', 'Imposible realizar proceso cliente posee factura pendiente de pago ' . $operacion->getCodigo());
                            $this->redirect('orden_cotizacion/index?pro=');
                        }
                    }
                }





//               echo "<pre>";
//               print_r($valores);
//               die();
                $fecha_documento = $valores['fecha_documento'];
                $fecha_documento = explode('/', $fecha_documento);
                $fecha_documento = $fecha_documento[2] . '-' . $fecha_documento[1] . '-' . $fecha_documento[0];
                $fecha_contabilizacion = $valores['fecha_documento'];
                $fecha_contabilizacion = explode('/', $fecha_contabilizacion);
                $fecha_contabilizacion = $fecha_contabilizacion[2] . '-' . $fecha_contabilizacion[1] . '-' . $fecha_contabilizacion[0];
                //   $orden->setSerie($valores['serie']);
                //   $orden->setNoDocumento($valores['no_documento']);
                $orden->setDiaCredito($valores['dia_credito']);
                $orden->setNit($valores['nit']);
                $orden->setNombre($valores['nombre']);
                $orden->setTiendaId(null);
                if ($valores['tienda_id']) {
                    $orden->setTiendaId($valores['tienda_id']);
                }
                $orden->setComentario($valores['observaciones']);
                $orden->setExcento(false);
//                if ($valores['exenta']) {
//                    $orden->setExcento(true);
//                }
                $orden->setVendedorId(null);
                if ($valores['vendedor_id']) {
                    $orden->setVendedorId($valores['vendedor_id']);
                }
                if ($orden->getTiendaId() == 19) {
                    $orden->setFecha($fecha_documento);
                }
                $orden->setFechaDocumento($fecha_documento);
                $orden->setFechaVencimiento($fecha_contabilizacion);
                $orden->setTelefono($valores['telefono']);
                $orden->setDireccion($valores['direccion']);
                $orden->setCorreo($valores['correo']);
                $orden->setUsuario($usuarioQ->getUsuario());
                $orden->save();
                $lista = OrdenCotizacionDetalleQuery::create()
                        ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalGeneral')
                        ->filterByOrdenCotizacionId($orden->getId())
                        ->findOne();
                $orden->setSubTotal(0);
                $orden->setValorTotal(0);
                $orden->setIva(0);
                if ($lista) {
                    $suma = $lista->getTotalGeneral();
                    $valores = ParametroQuery::ObtenerIva($suma, $orden->getExcento());
                    $iva = $valores['IVA'];
                    $valorSInIVa = $valores['VALOR_SIN_IVA'];
                    $orden->setSubTotal($valorSInIVa);
                    $orden->setValorTotal($suma);
                    $orden->setIva($iva);
                }
                $orden->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect('orden_cotizacion/index');
            }
        }
        $this->listado = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($id)
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
        $posibles[] = 'Pendiente';
        $posibles[] = 'Proceso';
        $posibles[] = 'Verificar';
        $ordenDetalle = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($id, Criteria::NOT_EQUAL)
                ->useOrdenCotizacionQuery()
              ->filterBySolicitarBodega(true)
                ->filterByTiendaId($tIENDAid)
                ->filterByUsuario($usuarioQ->getUsuario())
                ->filterByEstatus($posibles, Criteria::IN)
                ->endUse()
                ->groupByOrdenCotizacionId()
                ->find();
        $this->pendientes = $ordenDetalle;
        
//        echo "<pre>";
//        print_r($this->pendientes);
//        die();
    }
    

    public function executePosponer(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $operacion = OrdenCotizacionQuery::create()->findOneById($id);
        if ($operacion) {
            $operacion->setEstatus('Verificar');
            $operacion->setSolicitarBodega(true);
            $operacion->save();
            $ordenDetalle = OrdenCotizacionDetalleQuery::create()->filterByOrdenCotizacionId($id)->filterByProductoId(null, criteria::NOT_EQUAL)->find();
            foreach ($ordenDetalle as $pend) {
                $pend->setVerificado(false);
                $pend->save();
            }

//            echo "<pre>";
//            print_r($ordenDetalle);
//            die();
//            echo $ordenDetalle;
            if (count($ordenDetalle) == 0) {
                $Detalles = OrdenCotizacionDetalleQuery::create()->filterByOrdenCotizacionId($id)->filterByProductoId(null)->find();
//                   echo "<pre>";
//                   print_R($Detalles);

                foreach ($Detalles as $reg) {
                    $reg->setVerificado(true);
                    $reg->save();
                }
            }
//             die();
            sfContext::getInstance()->getUser()->setAttribute('CotizacionId', null, 'seguridad');
            $this->getUser()->setFlash('exito', 'Orden almacenada con exitoo! ' . $operacion->getCodigo());
        }
//        ->filterBySolicitarBodega(true)
//          ->filterByVerificado(true)

        $this->redirect('orden_cotizacion/index');
    }

}
