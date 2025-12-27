<?php

/**
 * proceso actions.
 *
 * @package    plan
 * @subpackage proceso
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class procesoActions extends sfActions {

    public function GrabaVariosPagos($prove, $numeroDocumento, $BancoId, $fechaInicio) {
        date_default_timezone_set("America/Guatemala");
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $cuentasPagar = CuentaProveedorQuery::create()
                ->filterByPagado(false)
                ->filterBySeleccionado(true)
                ->filterByProveedorId($prove)
                ->find();
        $VALOR_TOTAL = 0;
        $gastoId = null;
        $ordenID = null;
        foreach ($cuentasPagar as $cuenta) {
            $cuenta = CuentaProveedorQuery::create()->findOneById($cuenta->getId());
            $Saldo = $cuenta->getValorTotal() - $cuenta->getValorPagado();
            $listaCodigo[] = $cuenta->getCodigo();
            $VALOR_TOTAL = $VALOR_TOTAL + $Saldo;
            $VALOR_TOTAL = round($VALOR_TOTAL, 2);
            if ($cuenta->getGastoId()) {
                $OperaPgo = new GastoPago();
                $OperaPgo->setGastoId($cuenta->getGastoId());
                $OperaPgo->setProveedorId($prove);
                $OperaPgo->setTipoPago("DEPOSITO");
                $OperaPgo->setDocumento($numeroDocumento);
                $OperaPgo->setBancoId($BancoId);
                $OperaPgo->setFecha($fechaInicio);
                $OperaPgo->setUsuario($usuarioQ->getUsuario());
                $OperaPgo->setFechaCreo(date('Y-m-d H:i:s'));
                $OperaPgo->setCuentaProveedorId($cuenta->getId());
                $OperaPgo->setValorTotal($Saldo);
                $OperaPgo->save();
                $gastoId[] = $OperaPgo->getId();
            }
            if ($cuenta->getOrdenProveedorId()) {
                $OperaPgo = new OrdenProveedorPago();
                $OperaPgo->setOrdenProveedorId($cuenta->getOrdenProveedorId());
                $OperaPgo->setProveedorId($prove);
                $OperaPgo->setTipoPago("DEPOSITO");
                $OperaPgo->setDocumento($numeroDocumento);
                $OperaPgo->setBancoId($BancoId);
                $OperaPgo->setFecha($fechaInicio);
                $OperaPgo->setUsuario($usuarioQ->getUsuario());
                $OperaPgo->setFechaCreo(date('Y-m-d H:i:s'));
                $OperaPgo->setCuentaProveedorId($cuenta->getId());
                $OperaPgo->setValorTotal($Saldo);
                $OperaPgo->save();
                $ordenID[] = $OperaPgo->getId();
            }


            $cuenta->setFecha(date('Y-m-d H:i:s'));
            $cuenta->setValorPagado($cuenta->getValorTotal());
            $cuenta->setFechaPago(date('Y-m-d H:i:s'));
            $cuenta->setPagado(true);
            $cuenta->save();
        }
        $lisado = implode(",", $listaCodigo);
        $MedioPago = MedioPagoQuery::create()->findOneByNombre("DEPOSITO");
        $partidaId = Partida::Crea('Pago Gasto ', $OperaPgo->getCodigo(), $VALOR_TOTAL);
        $partidaQ = PartidaQuery::create()->findOneById($partidaId);
        $partidaQ->setDetalle($lisado . " " . " Valor  Q " . $VALOR_TOTAL);
        //  $partidaQ->setConfirmada(true);
        $partidaQ->save();
        $cuentaPartida = Partida::busca("PROVEEDOR COMPRA", 0, 2);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe($VALOR_TOTAL);
        $partidaLinea->setHaber(0);
        $partidaLinea->setTipo(0);
        $partidaLinea->setGrupo("PROVEEDOR COMPRA");
        $partidaLinea->save();
        $cuentaPartida = Partida::busca($MedioPago->getCodigo(), 2, 2);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        if ($MedioPago->getCuentaContable() <> "") {
            $cuentaContable = $MedioPago->getCuentaContable();
            $cuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($cuentaContable);
            $nombreCuenta = $cuentaQ->getNombre();
        }
        if ($OperaPgo->getBancoId()) {
            $cuentaContable = $OperaPgo->getBanco()->getCuentaContable();
            $cuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($cuentaContable);
            $nombreCuenta = $cuentaQ->getNombre();
        }
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe(0);
        $partidaLinea->setHaber($VALOR_TOTAL);
        $partidaLinea->setTipo(2);
        $partidaLinea->setGrupo($MedioPago->getCodigo());
        $partidaLinea->save();
        if ($gastoId) {
            $gastosV = GastoPagoQuery::create()->filterById($gastoId, Criteria::IN)->find();
            foreach ($gastosV as $cuenta) {
                $cuenta->setPartidaNo($partidaId);
                $cuenta->save();
            }
        }
        if ($ordenID) {
            $gastosV = OrdenProveedorPagoQuery::create()->filterById($gastoId, Criteria::IN)->find();
            foreach ($gastosV as $cuenta) {
                $cuenta->setPartidaNo($partidaId);
                $cuenta->save();
            }
        }
        $movimiento = New MovimientoBanco();
        $movimiento->setTipo('Gasto');
        $movimiento->setTipoMovimiento("DEPOSITO");
        $movimiento->setBancoId($BancoId);
        $movimiento->setValor($VALOR_TOTAL * -1);
        $movimiento->setBancoOrigen($BancoId);
        $movimiento->setDocumento($numeroDocumento);
        $movimiento->setFechaDocumento($fechaInicio);
        $movimiento->setObservaciones("Orden Gasto " . $lisado);
        $movimiento->setEstatus("Confirmado");
        //$movimiento->setMedioPagoId();
        $movimiento->setUsuario($usuarioQ->getUsuario());
        $movimiento->save();
        $partidaQ->setConfirmada(true);
        $partidaQ->save();
    }

    public function partidaPago($devolucion) {
        $tienda = '';
        $tiendaID = sfContext::getInstance()->getUser()->getAttribute("tienda", null, 'seguridad');
        $tiendaQ = TiendaQuery::create()->findOneById($tiendaID);
        if ($tiendaQ) {
            $tienda = $tiendaQ->getNombre();
        }
        $partidaId = Partida::Crea('Orden Devolución', $devolucion->getId(), $devolucion->getValor());
        $devolucion->setPartidaNo($partidaId);
        $valorDevolucion = $devolucion->getValor();
        $valorOtros = 0;
        if ($devolucion->getPorcentajeRetenie()) {
            $por = $devolucion->getPorcentajeRetenie();
            $valorDevolucion = round(($devolucion->getValor() * (100 - $por)) / 100, 2);
            $valorOtros = round(($devolucion->getValor() * $por) / 100, 2);
        }

        $devolucion->setValorOtros($valorOtros);
        $devolucion->save();
        $cuentaPartida = Partida::busca("DEVOLUCION " . $devolucion->getPagoMedio(), 1, 2);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        //   $nombreCuenta = Partida::cuenta($cuentaContable);


        $valoresIva = ParametroQuery::ObtenerIva($devolucion->getValor(), false, false);
        $VALORSINIVA = $valoresIva['VALOR_SIN_IVA'];
        $IVA = $valoresIva['IVA'];
        $cuentaPartida = Partida::busca("DEVOLUCION VENTA", 0, 1, '', $tienda);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe($VALORSINIVA);
        $partidaLinea->setHaber(0);
        $partidaLinea->setTipo(0);
        $partidaLinea->setGrupo('DEVOLUCION VENTA');
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();

        $cuentaPartida = Partida::busca("IVA%PAGAR%", 0, 1);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $cuentaContable = '2035-08';
        $nombreCuenta = 'IVA POR PAGAR';
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setHaber(0);
        $partidaLinea->setDebe($IVA);
        $partidaLinea->setGrupo("IVA POR PAGAR");
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();

        if ($valorOtros > 0) {
            $cuentaPartida = Partida::busca("OTROS%INGRESOS", 1, 2);
            $cuentaContable = $cuentaPartida['cuenta'];
            $nombreCuenta = $cuentaPartida['nombre'];
            //   $nombreCuenta = Partida::cuenta($cuentaContable);
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaId);
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setHaber($valorOtros);
            $partidaLinea->setDebe(0);
            $partidaLinea->setTipo(1);
            $partidaLinea->setGrupo('OTROS INGRESOS');
            $partidaLinea->save();
        }
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setHaber($valorDevolucion);
        $partidaLinea->setDebe(0);
        $partidaLinea->setTipo(1);
        $partidaLinea->setGrupo("DEVOLUCION" . $devolucion->getPagoMedio());
        $partidaLinea->save();
    }

    public function executeTest(sfWebRequest $request) {
        
    }

    public function executeConfirmaPartida(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $link = sfContext::getInstance()->getUser()->getAttribute("ruta", null, 'seguridad');

        $rutas = explode("/", $link);
        $nuevolink = '';
        $con = 0;
        $cant = count($rutas);
        if ($cant == 1) {
            //  $link = $link . "/index";
            $rutas = explode("/", $link);
        }

        foreach ($rutas as $lin) {
            $con++;
            $sep = '/';
            if ($con == 2) {
                $sep = "?";
            }
            if ($con == 3) {
                $sep = "=";
            }
            if ($con == count($rutas)) {
                $sep = '';
            }
            $nuevolink .= $lin . $sep;
        }
//        echo $cant;
//        echo " <br> <hr>";
        if ($cant == 1) {
            $nuevolink = str_replace("?", "/index?", $nuevolink);
        }
        $rutas = explode("/", $nuevolink);
        $cant = count($rutas);
        if ($cant == 1) {
            $nuevolink = $nuevolink . "/index";
        }


        $partidaDetalle = PartidaDetalleQuery::create()
                ->filterByPartidaId($id)
                ->find();
        $pendientes = 0;
        foreach ($partidaDetalle as $reg) {
            if (trim($reg->getCuentaContable()) == '') {
                $pendientes++;
            }
        }
        if ($pendientes > 0) {
            $this->getUser()->setFlash('error', 'Existen ' . $pendientes . ' registros pendientes de cuenta contable  ');
        }
        IF ($pendientes == 0) {
            $partidaQ = PartidaQuery::create()->findOneById($id);
            $partidaQ->setConfirmada(true);
            $partidaQ->save();
            $partidadDetalle = PartidaDetalleQuery::create()
                    ->filterByCuentaContable()
                    ->filterByGrupo()
                    ->filterByPartidaId($partidaQ->getId())
                    ->find();
            foreach ($partidadDetalle as $dete) {
                $definicionPar = DefinicionCuentaQuery::create()
                        ->filterByTipo($dete->getTipo())
                        ->filterByGrupo($dete->getGrupo())
                        ->findOne();
                if ($dete->getAdicional() <> '') {
                    $definicionPar = DefinicionCuentaQuery::create()
                            ->filterByDetalle($dete->getAdicional())
                            ->filterByTipo($dete->getTipo())
                            ->filterByGrupo($dete->getGrupo())
                            ->findOne();
                }
                if (!$definicionPar) {
                    $definicionPar = New DefinicionCuenta();
                    $definicionPar->setTipo($dete->getTipo());
                    $definicionPar->setGrupo($dete->getGrupo());
                    if ($dete->getAdicional() <> '') {
                        $definicionPar->getDetalle($dete->getAdicional());
                    }
                    $definicionPar->save();
                }
                $definicionPar->setCuentaContable($partidaDetalle->getCuentaContable());
                $definicionPar->save();
            }



            if (substr($nuevolink, 0, 20) == 'libro_mayor/confirma') {
                $nuevolink = ' libro_mayor/index';
            }


            if ($nuevolink == 'reporte_partida/index') {
                $nuevolink = 'reporte_partida/procesa?id=' . $partidaQ->getId();
            }
            if (substr($nuevolink, 0, 24) == 'reporte_partida/confirma') {
                $nuevolink = 'reporte_partida/procesa?id=' . $partidaQ->getId();
            }

            if (substr($nuevolink, 0, 23) == 'reporte_tienda/confirma') {
                $nuevolink = 'reporte_tienda/index?id=' . $partidaQ->getId();
            }
        }



        $this->redirect($nuevolink);
    }

    public function executeActuaCuenta(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $valor = $request->getParameter('valor');
        $detalle = PartidaDetalleQuery::create()->findOneById($id);
//        //  tipo 1 producto
        echo $detalle->getGrupo() . " -- " . $detalle->getTipo() . " --  ";
        $DefineCuenta = DefinicionCuentaQuery::create()
                ->filterByGrupo($detalle->getGrupo())
                ->filterByTipo($detalle->getTipo())
                ->findOne();
        if ($detalle->getAdicional() <> '') {
            $DefineCuenta = DefinicionCuentaQuery::create()
                    ->filterByDetalle($detalle->getAdicional())
                    ->filterByGrupo($detalle->getGrupo())
                    ->filterByTipo($detalle->getTipo())
                    ->findOne();
        }
        if (!$DefineCuenta) {
            echo $detalle->getTipo() . " -- >";
            $DefineCuenta = new DefinicionCuenta();
            $DefineCuenta->setGrupo($detalle->getGrupo());
            $DefineCuenta->setTipo($detalle->getTipo());
            if ($detalle->getAdicional() <> '') {
                $DefineCuenta->setDetalle($detalle->getAdicional());
            }
            $DefineCuenta->save();
        }
        $DefineCuenta->setCuentaContable($valor);
        $DefineCuenta->save();

        $detalle->setCuentaContable($valor);
        $detalle->setDetalle(Partida::cuenta($valor));
        $detalle->save();

        echo "actualizado ";
        die();
    }

    public function executePartida(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $partida = PartidaQuery::create()->findOneById($id);
        $this->partida = PartidaQuery::create()->findOneById($id);
        $this->partidaDeta = PartidaDetalleQuery::create()->filterByPartidaId($id)->find();
        $this->cuentasUno = CuentaErpContableQuery::create()
                        ->filterByTipo(1)->find();
        $this->cuentasDos = CuentaErpContableQuery::create()
                        ->filterByTipo(2)->find();
    }

    public function suma($prove) {
        $valorTotal = 0;
        $movimient = new CuentaProveedorQuery();
        $movimient->filterByPagado(false);
        $movimient->filterBySeleccionado(true);
        if ($prove) {
            $movimient->filterByProveedorId($prove);
        }
        $movimient->withColumn('sum(CuentaProveedor.ValorTotal)', 'ValorTotalTotal');
        $movimient->withColumn('sum(CuentaProveedor.ValorPagado)', 'ValorPagadoPagado');
        $movimiento = $movimient->findOne();
        if ($movimiento) {
            if ($movimiento->getValorTotal()) {
                $valorTotal = $movimiento->getValorTotalTotal() - $movimiento->getValorPagadoPagado();
            }
        }
        return $valorTotal;
    }

    public function executeConfirma(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $token = $request->getParameter('token');
        $tipo = $request->getParameter('tipo');
        $this->token = $token;
        $this->tipo = $tipo;
        sfContext::getInstance()->getUser()->setAttribute("grabaPago", 0, 'seguridad');
        $modulo = 'inicio';
        $retenido = 0;
        $cola = '';
        $this->pideConfirma = false;
        switch ($tipo) {
            case "cuentapagar":
                $modulo = 'cxc_por_pagar';
                $cola = "?prover=" . $token;
                sfContext::getInstance()->getUser()->setAttribute("grabaPago", true, 'seguridad');
                $registro = CuentaProveedorQuery::create()->filterBySeleccionado(true)
                        ->filterByPagado(false)
                        ->filterByProveedorId($token)
                        ->findOne();
                $default['tipo'] = $registro->getProveedor()->getNombre();
                $default['codigo'] = "DEPOSITO"; // $registro->getCodigo();
                $default['valor'] = Parametro::formato($this->suma($token), false);
                break;
            case "ordencompra":
                $modulo = 'con_ordencompra';
                $registro = OrdenProveedorQuery::create()->findOneByToken($token);
                $default['tipo'] = 'Orden Compra';
                $default['codigo'] = $registro->getCodigo();
                $default['valor'] = Parametro::formato($registro->getValorTotal(), false);
                break;
            case "ordencotizacion":
                $modulo = 'orden_cotizacion';
                $registro = OrdenCotizacionQuery::create()->findOneByToken($token);
                $default['tipo'] = 'Cotización';
                $default['codigo'] = $registro->getCodigo();
                $default['valor'] = Parametro::formato($registro->getValorTotal(), false);
                break;
            case "boleta":
                $this->pideConfirma = true;
                $modulo = 'confirma_boleta';
                $registro = SolicitudDepositoQuery::create()->findOneByCodigo($token);
                $default['tipo'] = 'Deposito Realizado';
                $default['observaciones'] = 'Boleta ' . $registro->getBoleta();
                $default['codigo'] = $registro->getCodigo();
                $default['valor'] = Parametro::formato($registro->getTotal(), false);
                break;
            case "creacheque":
                $modulo = 'crea_cheque';
                $registro = ChequeQuery::create()->findOneById($token);
                $default['tipo'] = $registro->getBanco()->getNombre();
                $default['codigo'] = 'Cheque ' . $registro->getNumero();
                $default['valor'] = Parametro::formato($registro->getValor(), false);
                break;
            case "solicitud":
                $modulo = 'cola_solicitud';
                $registro = SolicitudDevolucionQuery::create()->findOneById($token);
                $default['tipo'] = "Solicitud";
                $default['codigo'] = $registro->getCodigo();
                $default['valor'] = Parametro::formato($registro->getValor(), false);
                break;
            case "ordendevolucion":
                $modulo = 'pro_orden_devolucion';
                $registro = OrdenDevolucionQuery::create()->findOneByToken($token);
                $partidaQ = PartidaQuery::create()->findOneById($registro->getPartidaNo());
                if ($partidaQ) {
                    $partidaQ->setTipo("Devolución");
                    $partidaQ->save();
                }
                $default['tipo'] = 'Devolución';
                $default['codigo'] = $registro->getCodigo();
                $default['valor'] = Parametro::formato($registro->getValor(), false);
                $retenido = $registro->getValorOtros();
                break;
            case "ordendevolucionentrega":
                $modulo = 'vista_devolucion';
                $registro = OrdenDevolucionQuery::create()->findOneByToken($token);
                $default['tipo'] = 'Devolución';
                $default['codigo'] = $registro->getCodigo();
                $default['valor'] = Parametro::formato($registro->getValor(), false);
                $retenido = $registro->getValorOtros();
                break;
            case "traslado":
                $modulo = 'traslado';
                $cola = "?codigo=" . $token;
                sfContext::getInstance()->getUser()->setAttribute("grabaPago", false, 'seguridad');
                $registro = TrasladoProductoQuery::create()->findOneByCodigo($token);
                $default['tipo'] = $registro->getProducto()->getNombre();
                $default['codigo'] = "TRASLADO DE " . $registro->getOrigen(); // $registro->getCodigo();
                $default['valor'] = $registro->getCantidad();
                $default['observaciones'] = $registro->getProducto()->getNombre() . "  Cantidad " . $registro->getCantidad() . " Bodega Origen " . $registro->getOrigen() . " Bodega Destino " . $registro->getDestino();

                break;
        }
        $this->retenido = $retenido;
        $this->grabaPago = sfContext::getInstance()->getUser()->getAttribute("grabaPago", null, 'seguridad');

        $default['usuario'] = sfContext::getInstance()->getUser()->getAttribute('usuarioNombre', null, 'seguridad');
        $default['fecha'] = date('d/m/Y');
        $this->form = new ProcesoGrabaForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $valores = $this->form->getValues();
                if ($this->grabaPago) {
                    if ($valores['banco_id'] == "") {
                        $this->getUser()->setFlash('error', 'Para procesar el pago debe ingresar banco');
                        $this->redirect($modulo . '/index' . $cola);
                    }
                    if ($valores['no_documento'] == "") {
                        $this->getUser()->setFlash('error', 'Para procesar el pago debe ingresar No Documento');
                        $this->redirect($modulo . '/index' . $cola);
                    }
                }
                if ($this->pideConfirma) {
                    if ($valores['no_confirmacion'] == "") {
                        $this->getUser()->setFlash('error', 'Para confirmar debe ingresar No Documento Banco');
                        $this->redirect($modulo . '/index' . $cola);
                    }
                }
                $observaciones = $valores['observaciones'];
                $observaciones = trim($observaciones);
                if ($observaciones == "") {
                    $this->getUser()->setFlash('error', 'Para procesar se necesita  ingresar las observaciones ');
                    $this->redirect($modulo . '/index' . $cola);
                }
                if ($tipo == "traslado") {

                    ProductoMovimientoQuery::Salida($registro->getProductoId(), $registro->getCantidad(), 'TRASLADO SALIDA', $registro->getBodegaOrigen(), $registro->getCodigo() . "-" . $registro->getId(), null, null);
                    ProductoExistenciaQuery::Resta($registro->getProductoId(), $registro->getCantidad(), $registro->getBodegaOrigen());
                    $ListaProductos = ProductoExistenciaQuery::create()
                            ->filterByEmpresaId($registro->getEmpresaId())
                            ->filterByProductoId($registro->getProductoId())
                            ->withColumn('sum(ProductoExistencia.Cantidad)', 'ValorTotal')
                            ->findOne();
                    $nuevaExistencia = $ListaProductos->getValorTotal();
                    $productoQuery= $registro->getProducto();
                    $productoQuery->setExistencia($nuevaExistencia);
                    $productoQuery->save();
                    
                    
                     ProductoMovimientoQuery::Ingreso($registro->getProductoId(), $registro->getCantidad(), $registro->getCodigo(), 'TRASLADO INGRESO', date('Y-m-d'), $registro->getBodegaDestino());
                     ProductoExistenciaQuery::Resta($registro->getProductoId(), $registro->getCantidad() * -1, $registro->getBodegaDestino());
                     $ListaProductos = ProductoExistenciaQuery::create()
                               ->filterByEmpresaId($registro->getEmpresaId())
                              ->filterByProductoId($registro->getProductoId())
                                ->withColumn('sum(ProductoExistencia.Cantidad)', 'ValorTotal')
                                ->findOne();
                     $nuevaExistencia = $ListaProductos->getValorTotal();
                     $productoQuery->setExistencia($nuevaExistencia);
                     $productoQuery->save();
                        
                    



                    $registro->setUsuarioConfirmo($valores['usuario']);
                    $registro->setFechaConfirmo(date('Y-m-d H:i:s'));
                    $registro->setEstatus('Autorizado');
                    $registro->save();
                    $this->getUser()->setFlash('exito', ' Traslado realizado con exito ' . $valores['observaciones']);
                    $this->redirect($modulo . '/index' . $cola);
                }


                BitacoraDocumento::grabacion($valores['tipo'], $valores['codigo'], 'Confirmacion', $observaciones);
                if ($tipo == "boleta") {
                    $registro->setUpdatedAt(date('Y-m-d H:i'));
                    $registro->setUsuarioConfirmo($valores['usuario']);
                    $registro->setFechaConfirmo(date('Y-m-d H:i:s'));
                    $registro->setEstatus('Autorizado');
                    $registro->setDocumentoConfirmacion($valores['no_confirmacion']);
                    $registro->save();
                    $this->getUser()->setFlash('exito', ' Solicitud Boleta ' . $valores['codigo'] . " confirmada  con éxito");
                    $this->redirect($modulo . '/index');
                }

                if ($tipo == "cuentapagar") {
                    $this->GrabaVariosPagos($token, $valores['no_documento'], $valores['banco_id'], $valores['fecha']);
                    $this->getUser()->setFlash('exito', ' Pago ' . $valores['tipo'] . "  con " . $valores['codigo'] . " registrado con éxito");
                    $this->redirect($modulo . '/index' . $cola);
                }

                if ($tipo <> "ordendevolucionentrega") {
                    $registro->setUsuarioConfirmo($valores['usuario']);
                    $registro->setFechaConfirmo(date('Y-m-d H:i:s'));
                    $registro->setEstatus('Autorizado');
                    $registro->save();
                }
                $this->getUser()->setFlash('exito', ' ' . $valores['tipo'] . "  " . $valores['codigo'] . " autorizado con éxito");
                if ($tipo == "ordendevolucionentrega") {
                    $registro->setEstatus('Entregado');
                    $usu = $registro->getUsuarioConfirmo() . "_" . $valores['usuario'];
                    $registro->setUsuarioConfirmo($usu);
                    $registro->save();
                    $this->getUser()->setFlash('exito', ' ' . $valores['tipo'] . "  " . $valores['codigo'] . " autorizado con éxito");
//                    $solict = SolicitudDevolucionQuery::create()->findOneById($registro->getSolicitudDevolucionId());
//                    if ($solict) {
//                        $solict->setEstatus("Entregado");
//                        $solict->save();
//                    }
                    $this->getUser()->setFlash('exito', ' ' . $valores['tipo'] . "  " . $valores['codigo'] . " entregada con éxito");
                }


                if ($tipo == "ordencotizacion") {
                    $idv = OrdenCotizacionQuery::ProcesaAuto($registro);
                    sfContext::getInstance()->getUser()->setAttribute("lista", true, 'seguridad');
                    $this->redirect($modulo . '/muestra?token=' . $token);
                }
                if ($tipo == "ordendevolucion") {
                    $registro = OrdenDevolucionQuery::create()->findOneByToken($token);
                    $tipoMo = strtoupper(trim(str_replace(" ", "", $registro->getPagoMedio())));
                    $productoQuery = $registro->getProducto();

                    if ($productoQuery) {
                        $bodegaId = $registro->getTiendaId(); // ->getTiendaId();
                        $empresaId = $registro->getEmpresaId();
                        $clave = $productoQuery->getId();

                        ProductoMovimientoQuery::Ingreso($clave, $registro->getCantidad(), $registro->getCodigo(), 'DEVOLUCION', date('Y-m-d'), $registro->getTiendaId());
                        ProductoExistenciaQuery::Resta($clave, $registro->getCantidad() * -1, $bodegaId);
                        $ListaProductos = ProductoExistenciaQuery::create()
                                ->filterByEmpresaId($empresaId)
                                ->filterByProductoId($clave)
                                ->withColumn('sum(ProductoExistencia.Cantidad)', 'ValorTotal')
                                ->findOne();
                        $nuevaExistencia = $ListaProductos->getValorTotal();
                        $productoQuery->setExistencia($nuevaExistencia);
                        $productoQuery->save();
                    }





//                    if ($tipoMo == "CHEQUE") {
                    $this->partidaPago($registro);
//                    }
                }
                $this->redirect($modulo . '/index');
            }
        }
    }

    public function executeRechaza(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $token = $request->getParameter('token');
        $tipo = $request->getParameter('tipo');
        $this->token = $token;
        $this->tipo = $tipo;
        $modulo = 'inicio';
        $retenido = 0;
        switch ($tipo) {
            case "ordencompra":
                $registro = OrdenProveedorQuery::create()->findOneByToken($token);
                $default['tipo'] = 'Orden Compra';
                $default['codigo'] = $registro->getCodigo();
                $default['valor'] = Parametro::formato($registro->getValorTotal());
                $modulo = 'con_ordencompra';
                break;
            case "ordencomprafinal":
                $registro = OrdenProveedorQuery::create()->findOneByToken($token);
                $default['tipo'] = 'Orden Compra';
                $default['codigo'] = $registro->getCodigo();
                $default['valor'] = Parametro::formato($registro->getValorTotal());
                $modulo = 'consulta_orden_proveedor';
                break;
            case "ordencotizacion":
                $modulo = 'con_ordencotiza';
                $registro = OrdenCotizacionQuery::create()->findOneByToken($token);
                $default['tipo'] = 'Cotización';
                $default['codigo'] = $registro->getCodigo();
                $default['valor'] = Parametro::formato($registro->getValorTotal());
                break;
            case "creacheque":
                $modulo = 'crea_cheque';
                $registro = ChequeQuery::create()->findOneById($token);
                $default['tipo'] = $registro->getBanco()->getNombre();
                $default['codigo'] = 'Cheque ' . $registro->getNumero();
                $default['valor'] = Parametro::formato($registro->getValor());
                break;
            case "gasto":
                $modulo = 'consulta_gasto_proveedor';
                $registro = GastoQuery::create()->findOneById($token);
                $default['tipo'] = "Gasto";
                $default['codigo'] = $registro->getCodigo();
                $default['valor'] = Parametro::formato($registro->getValorTotal());
                break;
            case "pago":
                $modulo = 'pagos_realizado';
                $registro = GastoPagoQuery::create()->findOneById($token);
                $default['tipo'] = "Pago Gasto";
                $default['codigo'] = $registro->getCodigo();
                $default['valor'] = Parametro::formato($registro->getValorTotal());
                break;
            case "solicitud":
                $modulo = 'cola_solicitud';
                $registro = SolicitudDevolucionQuery::create()->findOneById($token);
                $default['tipo'] = "Solicitud";
                $default['codigo'] = $registro->getCodigo();
                $default['valor'] = Parametro::formato($registro->getValor());
                break;
            case "ordendevolucion":
                $modulo = 'pro_orden_devolucion';
                $registro = OrdenDevolucionQuery::create()->findOneByToken($token);
                $default['tipo'] = 'Devolución';
                $default['codigo'] = $registro->getCodigo();
                $default['valor'] = Parametro::formato($registro->getValor(), false);
                $retenido = $registro->getValorOtros();

                break;
            case "debito":
                $modulo = 'debito_banco';
                $registro = MovimientoBancoQuery::create()->findOneById($token);
                $default['tipo'] = "Debito Banco " . $registro->getBancoRelatedByBancoId()->getNombre();
                $default['codigo'] = $registro->getDocumento();
                $default['valor'] = Parametro::formato($registro->getValor());
                break;
            case "anular":
                $modulo = 'venta_resumida';
                $registro = VentaResumidaQuery::create()->findOneById($token);
                $default['tipo'] = "Venta Resumida " . $registro->getId();
                $default['codigo'] = $registro->getDocumento();
                $default['valor'] = Parametro::formato($registro->getValorDeposito());
                break;
            case "boleta":
                $modulo = 'confirma_boleta';
                $registro = SolicitudDepositoQuery::create()->findOneByCodigo($token);
                $default['tipo'] = 'Deposito Realizado';
                $default['codigo'] = $registro->getCodigo();
                $default['valor'] = Parametro::formato($registro->getTotal(), false);
                break;
            case "traslado":
                $modulo = 'traslado';
                $cola = "?codigo=" . $token;
                sfContext::getInstance()->getUser()->setAttribute("grabaPago", false, 'seguridad');
                $registro = TrasladoProductoQuery::create()->findOneByCodigo($token);
                $default['tipo'] = $registro->getProducto()->getNombre();
                $default['codigo'] = "TRASLADO DE " . $registro->getOrigen(); // $registro->getCodigo();
                $default['valor'] = $registro->getCantidad();
                break;
        }
        $this->retenido = $retenido;
        $default['usuario'] = sfContext::getInstance()->getUser()->getAttribute('usuarioNombre', null, 'seguridad');
        $default['fecha'] = date('d/m/Y');
        $this->form = new ProcesoGrabaForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $observaciones = $valores['observaciones'];
                $observaciones = trim($observaciones);
                if ($observaciones == "") {
                    $this->getUser()->setFlash('error', 'Para procesar se necesita  ingresar las observaciones ');
                    $this->redirect($modulo . '/index');
                }


                if ($tipo == "traslado") {
                    $registro->setComentario($valores['observaciones']);
                    $registro->setUsuarioConfirmo($valores['usuario']);
                    $registro->setFechaConfirmo(date('Y-m-d H:i:s'));
                    $registro->setEstatus('Rechazada');
                    $registro->save();
                    $this->getUser()->setFlash('alerta', '  ' . $valores['tipo'] . "  " . $valores['codigo'] . " rechazada con éxito");
                    $this->redirect($modulo . '/index');
                }

                BitacoraDocumento::grabacion($valores['tipo'], $valores['codigo'], 'Rechazo', $observaciones . " =>" . serialize($registro));


                if (($tipo <> "debito") && ($tipo <> "creacheque") && ($tipo <> "gasto") && ($tipo <> "pago") && ($tipo <> "solicitud")) {

                    if ($tipo <> "anular") {
                        $registro->setUsuarioConfirmo($valores['usuario']);
                        $registro->setFechaConfirmo(date('Y-m-d H:i:s'));
                        $registro->setEstatus('Rechazado');
                        $registro->save();
                    }

                    if ($tipo == "boleta") {
                        $registro->setUsuarioConfirmo($valores['usuario']);
                        $registro->setFechaConfirmo(date('Y-m-d H:i:s'));
                        $registro->setEstatus('Rechazado');
                        $registro->save();
                    }
                }
                if ($tipo == "creacheque") {
                    $this->anula_cheque($token);
                }
                if ($tipo == "debito") {
                    $partidaId = $registro->getPartidaNo();
                    $movientoA = MovimientoBancoQuery::create()
                            ->filterByPartidaNo($partidaId)
                            ->filterById($registro->getId(), Criteria::NOT_EQUAL)
                            ->findOne();
                    if ($movientoA) {
                        $cuentaBanco = CuentaBancoQuery::create()->findOneByMovimientoBancoId($movientoA->getId());
                        if ($cuentaBanco) {
                            $cuentaBanco->delete();
                        }
                        $movientoA->delete();
                    }
                    $partidaDe = PartidaDetalleQuery::create()
                            ->filterByPartidaId($partidaId)
                            ->find();
                    if ($partidaDe) {
                        $partidaDe->delete();
                    }
                    $partidaQ = PartidaQuery::create()->findOneById($partidaId);
                    if ($partidaQ) {
                        $partidaQ->delete();
                    }
                    $cuentaBanco = CuentaBancoQuery::create()->findOneByMovimientoBancoId($registro->getId());
                    if ($cuentaBanco) {
                        $cuentaBanco->delete();
                    }
                    $registro->delete();
                    $this->getUser()->setFlash('alerta', '  ' . $valores['tipo'] . "  " . $valores['codigo'] . " eliminado con éxito partida (" . $partidaId . ")");
                    $this->redirect($modulo . '/index');
                }
                if ($tipo == "creacheque") {
                    $this->anula_cheque($token);
                }
                if ($tipo == "gasto") {
                    $this->anula_gasto($token);
                }
                if ($tipo == "pago") {
                    $this->anula_pago($token);
                }
                if ($tipo == "solicitud") {
                    $registro = SolicitudDevolucionQuery::create()->findOneById($token);
                    $registro->setEstatus("Rechazado");
                    $registro->save();
                }
                if ($tipo == "ordencomprafinal") {
                    $this->anula_orden($token);
                }

                if ($tipo == "anular") {
                    $this->EliminaVenta($token);
                }


                if ($tipo == "ordendevolucion") {
                    $registro = OrdenDevolucionQuery::create()->findOneByToken($token);
                    $partidaNo = $registro->getPartidaNo();
                    $partidaDetalle = PartidaDetalleQuery::create()
                            ->filterByPartidaId($partidaNo)
                            ->find();

                    if ($partidaDetalle) {
                        $partidaDetalle->delete();
                    }
                    $partidaQ = PartidaQuery::create()->findOneById($partidaNo);
                    if ($partidaQ) {
                        $partidaQ->delete();
                    }
                }

                $this->getUser()->setFlash('alerta', '  ' . $valores['tipo'] . "  " . $valores['codigo'] . " rechazada con éxito");
                $this->redirect($modulo . '/index');
            }
        }
    }

    public function anula_orden($token) {
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $Orden = OrdenProveedorQuery::create()->findOneByToken($token);
            $cuentaProveedor = CuentaProveedorQuery::create()->findOneByOrdenProveedorId($Orden->getId());
            if ($cuentaProveedor) {
                $cuentaProveedor->delete();
            }

            $codigo = $Orden->getCodigo();
            $gastoDetalle = OrdenProveedorDetalleQuery::create()
                    ->filterByOrdenProveedorId($Orden->getId())
                    ->find();
            if ($gastoDetalle) {
                $gastoDetalle->delete();
            }
            $Orden->delete();
            $con->commit();
            $this->getUser()->setFlash('error', 'Orden eliminado con exito ' . $codigo);
            $partidaId = $Orden->getPartidaNo();
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('consulta_orden_proveedor/index');
        }

        $partidaQ = PartidaDetalleQuery::create()
                ->filterByPartidaId($partidaId)
                ->find();
        if ($partidaQ) {
            $partidaQ->delete();
        }
        $partidaM = PartidaQuery::create()->findOneById($partidaId);
        if ($partidaM) {
            $partidaM->delete();
        }
        $this->redirect('consulta_orden_proveedor/index');
    }

    public function anula_cheque($id) {
        $cheque = ChequeQuery::create()->findOneById($id);
        $gastos = GastoPagoQuery::create()
                ->filterByChequeId($cheque->getId())
                ->find();
        foreach ($gastos as $regist) {
            $regist->setChequeId(null);
            $regist->setTemporal(false);
            $regist->save();
        }

        $gastos = OrdenProveedorPagoQuery::create()
                ->filterByChequeId($cheque->getId())
                ->find();
        foreach ($gastos as $regist) {
            $regist->setChequeId(null);
            $regist->setTemporal(false);
            $regist->save();
        }
        $cheque->setEstatus('Anulado');
        $cheque->save();
        $movimientoBanco = MovimientoBancoQuery::create()
                ->filterByBancoId($cheque->getBancoId())
                ->filterByDocumento($cheque->getNumero())
                ->filterByTipo('Cheque')
                ->findOne();

        if ($movimientoBanco) {

//           $partidaId = $movimientoBanco->getPartidaNo();
//           if ($partidaId) {
//                    $partidaQ = PartidaDetalleQuery::create()
//                    ->filterByPartidaId($partidaId)
//                    ->find();
//            if ($partidaQ) {
//                $partidaQ->delete();
//            }
//            $partidaQ = PartidaQuery::create()->findOneById($partidaId);
//            if ($partidaQ) {
//                $partidaQ->delete();
//            }
//           }  
//           

            $movimientoBanco->delete();
            $cuentbanco = CuentaBancoQuery::create()->findOneByMovimientoBancoId($movimientoBanco->getId());
            if ($cuentbanco) {
                $cuentbanco->delete();
            }
        }

        $nocheque = $cheque->getNumero();
        $ordenDevolucion = OrdenDevolucionQuery::create()->findOneById($cheque->getOrdenDevolucionId());

        if ($ordenDevolucion) {

            $partidaId = $ordenDevolucion->getPartidaNo();
            $partidaQ = PartidaDetalleQuery::create()
                    ->filterByPartidaId($partidaId)
                    ->find();
            if ($partidaQ) {
                $partidaQ->delete();
            }
            $partidaQ = PartidaQuery::create()->findOneById($partidaId);
            if ($partidaQ) {
                $partidaQ->delete();
            }
            $this->getUser()->setFlash('exito', 'Devolucion anualada  # ' . $ordenDevolucion->getCodigo() . " Cheque no " . $nocheque);

            $ordenDevolucion->setEstatus("ANULADO");
            $ordenDevolucion->save();
        }
    }

    public function anula_gasto($id) {
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $gastoOrden = GastoQuery::create()->findOneById($id);
            $cuentaProveedor = CuentaProveedorQuery::create()->findOneByGastoId($gastoOrden->getId());
            $cuentaProveedor->delete();
            $codigo = $gastoOrden->getCodigo();
            $gastoDetalle = GastoDetalleQuery::create()
                    ->filterByGastoId($id)
                    ->find();
            if ($gastoDetalle) {
                $gastoDetalle->delete();
            }
            $gastoOrden->delete();
            $con->commit();
            $this->getUser()->setFlash('error', 'Gasto eliminado con exito ' . $codigo);
            $partidaId = $gastoOrden->getPartidaNo();
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('consulta_gasto_proveedor/index');
        }

        $partidaQ = PartidaDetalleQuery::create()
                ->filterByPartidaId($partidaId)
                ->find();
        if ($partidaQ) {
            $partidaQ->delete();
        }
        $partidaM = PartidaQuery::create()->findOneById($partidaId);
        if ($partidaM) {
            $partidaM->delete();
        }
        $this->redirect('consulta_gasto_proveedor/index');
    }

    public function anula_pago($id) {
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $gastoPago = GastoPagoQuery::create()->findOneById($id);
            $partidaId = $gastoPago->getPartidaNo();
            $numeroDOc = $gastoPago->getDocumento();
            $BancoDoc = $gastoPago->getBancoId();
            $NotaCredito = NotaCreditoQuery::create()->findOneById($gastoPago->getTipoPago());
            if ($NotaCredito) {
                $NotaCredito->setEstatus('Nuevo');
                $NotaCredito->save();
            }

            $movimientoBanco = MovimientoBancoQuery::create()
                    ->filterByBancoId($gastoPago->getBancoId())
                    ->filterByTipo('Gasto')
                    ->filterByDocumento($gastoPago->getDocumento())
                    ->filterByFechaDocumento($gastoPago->getFecha('Y-m-d'))
                    ->filterByUsuario($gastoPago->getUsuario())
                    ->findOne();
            if ($movimientoBanco) {
                $cuentaBanco = CuentaBancoQuery::create()->findOneByMovimientoBancoId($movimientoBanco->getId());
                if ($cuentaBanco) {
                    $cuentaBanco->delete();
                }
            }
//            echo "<pre>";
//            print_r($movimientoBanco);
//            die();
            if ($movimientoBanco) {
                $movimientoBanco->delete();
            }
            $cuentaVivi = CuentaProveedorQuery::create()->findOneByGastoId($gastoPago->getGastoId());
            $valorPagado = $cuentaVivi->getValorPagado() - $gastoPago->getValorTotal();
            $cuentaVivi->setPagado(false);
            $cuentaVivi->setValorPagado($valorPagado);
            $cuentaVivi->save();
            $orden = GastoQuery::create()->findOneById($gastoPago->getGastoId());
            $valorPagado = $orden->getValorPagado() - $gastoPago->getValorTotal();
            $orden->setValorPagado($valorPagado);
            $orden->save();
            $codigo = $gastoPago->getCodigo();
            $gastoPago->delete();
            $con->commit();
            $this->getUser()->setFlash('error', 'Gasto eliminado con exito ' . $codigo);
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('pagos_realizado/index');
        }

        $partidaQ = PartidaDetalleQuery::create()
                ->filterByPartidaId($partidaId)
                ->find();
        if ($partidaQ) {
            $partidaQ->delete();
        }
        $partidaM = PartidaQuery::create()->findOneById($partidaId);
        if ($partidaM) {
            $partidaM->delete();
        }

//        $pendientes = GastoPagoQuery::create()
//                ->filterByTipoPago("DEPOSITO")
//                ->filterByPartidaNo($partidaId)
//                ->filterByDocumento($numeroDOc)
//                ->filterByBancoId($BancoDoc)
//                ->find();
//        foreach ($pendientes as $data) {
//            $data->delete();
//        }
        $this->redirect('pagos_realizado/index');
    }

    public function EliminaVenta($id) {
//        $id = $request->getParameter('id');
//        $token = $request->getParameter('token');
        $opera = VentaResumidaQuery::create()->findOneById($id);
        $tiendaID = $opera->getTiendaId();
        $fecha = $opera->getFecha('d/m/Y');
//        $tokenPro = '';
//        if ($opera) {
//            $tokenPro = md5($opera->getId());
//        }
//        if ($tokenPro <> $token) {
//            $this->getUser()->setFlash('error', 'Token  incorrecto !Intentar Nuevamente');
//            $this->redirect('venta_resumida/index');
//        }
        $partidaId = $opera->getPartidaNo();

        $con = Propel::getConnection();
        $con->beginTransaction();

        try {
            $ventaREsumidaDetalle = VentaResumidaLineaQuery::create()
                    ->filterByVentaResumidaId($id)
                    ->find();
            foreach ($ventaREsumidaDetalle as $registro) {

                $movimientoBanco = MovimientoBancoQuery::create()->findOneByVentaResumidaLineaId($registro->getId());

                if ($movimientoBanco) {
                    $cuentaBanco = CuentaBancoQuery::create()
                            ->filterByMovimientoBancoId($movimientoBanco->getId())
                            ->find();
                    if ($cuentaBanco) {
                        $cuentaBanco->delete();
                    }

                    $movimientoBanco->delete();
                }
            }

            if ($ventaREsumidaDetalle) {
                $ventaREsumidaDetalle->delete();
            }
            $codigo = $opera->getMedioPago()->getNombre();
            $opera->delete();
            $con->commit();
            $this->getUser()->setFlash('error', 'Movimiento ' . $codigo . ' eliminado con exito');
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('venta_resumida/index?tiendaver=' . $tiendaID . "&fecha=" . $fecha);
        }
        $partidaQ = PartidaDetalleQuery::create()
                ->filterByPartidaId($partidaId)
                ->find();
//        echo "<pre>";
//        print_r($partidaQ);
//        echo "</pre>";
//        die();
        if ($partidaQ) {
            $partidaQ->delete();
        }
        $partidaQ = PartidaQuery::create()->findOneById($partidaId);
        if ($partidaQ) {
            $partidaQ->delete();
        }

        $this->redirect('venta_resumida/index?tiendaver=' . $tiendaID . "&fecha=" . $fecha);
    }

}
