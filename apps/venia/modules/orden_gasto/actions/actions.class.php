<?php

/**
 * orden_gasto actions.
 *
 * @package    plan
 * @subpackage orden_gasto
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class orden_gastoActions extends sfActions {

    public function executeValor(sfWebRequest $request) {
        $OperacionId = sfContext::getInstance()->getUser()->getAttribute('GastoId', null, 'seguridad');
        $ordenProveedor = GastoQuery::create()->findOneById($OperacionId);
        $cuenta = $request->getParameter('cuenta');
        $tipoReg = '';
        if ($ordenProveedor->getProveedorId()) {
            $tipoReg = $ordenProveedor->getProveedor()->getRegimenIsr();
        }
        $excenta = $ordenProveedor->getExcento();
        $valor = $request->getParameter('id');
        $cantidad = $request->getParameter('idca');
        $ListaId = $request->getParameter('idv');
        $valor = $valor * $cantidad;
        // rev
        $valoresIVA = ParametroQuery::ObtenerIva($valor, $excenta, $ordenProveedor->getAplicaIsr(), $ordenProveedor->getExcentoIsr(), $tipoReg, $ordenProveedor->getRetieneIva());
        $iva = $valoresIVA['IVA'];
        $valorSInIVa = $valoresIVA['VALOR_SIN_IVA'];
        $IVAIDP = $iva;
        $valorSInIVaIDP = $valorSInIVa;
        if ($cuenta == '61203047') {
            $iva = 0;
            $valorSInIVa = $valor;
        }
        if ($cuenta != '61203047') {
            $IVAIDP = 0;
            $valorSInIVaIDP = 0;
        }

        $valorSInIVa = number_format((float) ($valorSInIVa), 2, '.', '');
        $iva = number_format((float) ($iva), 2, '.', '');
        $retorna = "<strong>" . $valorSInIVa . "</strong>";
        $retorna .= '|' . $iva;

//        echo $retorna;
//        die();
        if ($ListaId > 0) {
            $listaProducto = GastoDetalleQuery::create()
//                ->filterByIngresoProductoId($OperacionId)
//                ->filterByProductoId($ListaId)
                    ->filterById($ListaId)
                    ->findOne();


            $suma = $listaProducto->getValorTotal();
            // rev
            $valoresIVA = ParametroQuery::ObtenerIva($suma, $excenta, $ordenProveedor->getAplicaIsr(), $ordenProveedor->getExcentoIsr(), $tipoReg, $ordenProveedor->getRetieneIva());
            $iva = $valoresIVA['IVA'] + $IVAIDP;
            $valorSInIVa = $valoresIVA['VALOR_SIN_IVA'] + $valorSInIVaIDP;
            $listaProducto->setSubTotal($valorSInIVa);
            $listaProducto->setIva($iva);
            $listaProducto->save();
            $lista = GastoDetalleQuery::create()
                    ->withColumn('sum(GastoDetalle.ValorTotal)', 'TotalGeneral')
                    ->filterByGastoId($OperacionId)
                    ->findOne();
            $ordenProveedor->setValorTotal(0);
            $ordenProveedor->setSubTotal(0);
            $ordenProveedor->setIva(0);
            $ordenProveedor->setValorIsr(0);
            $ordenProveedor->setValorRetieneIva(0);
            $ordenProveedor->save();

            if ($lista) {

                $suma = $lista->getTotalGeneral();
                // rev
                $valoresIVA = ParametroQuery::ObtenerIva($suma, $excenta, $ordenProveedor->getAplicaIsr(), $ordenProveedor->getExcentoIsr(), $tipoReg, $ordenProveedor->getRetieneIva());
                $iva = $valoresIVA['IVA'] + $iva;
                $valorSInIVa = $valoresIVA['VALOR_SIN_IVA'] + $valorSInIVaIDP;
                $ordenProveedor->setValorTotal($suma);
                $ordenProveedor->setSubTotal($valorSInIVa);
                $ordenProveedor->setIva($iva);
                $ordenProveedor->setValorIsr($valoresIVA['VALOR_ISR']);
                $ordenProveedor->setValorRetieneIva($valoresIVA['VALOR_RETIENE_IVA']);
                $ordenProveedor->save();
            }
            $retorna = "<strong>" . number_format($listaProducto->getSubTotal(), 2) . "</strong>";
            $retorna .= '|' . number_format($listaProducto->getIva(), 2) . "|" . number_format($iva, 2) . "|" . number_format($valorSInIVa, 2);
        }
        echo $retorna;
        die();
    }

    public function executeActua(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $ordenProve = OrdenProveedorQuery::create()->findOneById($id);
        $tipo = $request->getParameter('tipo');
        $valo = $request->getParameter('val');
        if ($tipo == 1) {
            $ordenProve->setSerie($valo);
        }
        if ($tipo == 2) {
            $ordenProve->setNoDocumento($valo);
        }

        if ($tipo == 3) {
            $ordenProve->setProveedorId($valo);
        }

        if ($tipo == 4) {
            $ordenProve->setComentario($valo);
        }

        if ($tipo == 5) {
            $ordenProve->setDiaCredito($valo);
        }

        if ($tipo == 6) {
            $fecha_documento = explode('/', $valo);
            $fecha_documento = $fecha_documento[2] . '-' . $fecha_documento[1] . '-' . $fecha_documento[0];

            $ordenProve->setFechaDocumento($fecha_documento);
        }

        $ordenProve->save();
        die();
    }

    public function executeElimina(sfWebRequest $request) {
        
    }

    public function executeValorPendiente(sfWebRequest $request) {
        $val = $request->getParameter('val');
        $id = $request->getParameter('id');

        $ordenGasto = GastoQuery::create()->findOneById($id);
        $retorna = $ordenGasto->getValorTotal();
        $ordenValor = CuentaProveedorQuery::create()->findOneByGastoId($id);
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

    public function executeValorDocumento(sfWebRequest $request) {
        $val = $request->getParameter('val');
        $retorna = '';
        $notaCredito = NotaCreditoQuery::create()->findOneById($val);
        if ($notaCredito) {
            $retorna = $notaCredito->getCodigo();
        }
        echo $retorna;
        die();
    }

    public function executeMuestraPaga(sfWebRequest $request) {
        $token = $request->getParameter('token');
        $ordenPRove = GastoQuery::create()->findOneByToken($token);
        sfContext::getInstance()->getUser()->setAttribute('tab', 4, 'seguridad');
        $this->redirect('orden_gasto/muestra?token=' . $token);
        $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
    }

    public function partidaInventario($ordenProveedor) {
        date_default_timezone_set("America/Guatemala");
        $TOTALIVA = 0;
        $VALORtotal = 0;
        $partidaQ = new Partida();
        $partidaQ->setFechaContable($ordenProveedor->getFecha('Y-m-d'));
        $partidaQ->setUsuario($ordenProveedor->getUsuario());
        $partidaQ->setTipo('Gasto');
        $partidaQ->setCodigo($ordenProveedor->getCodigo());
        $partidaQ->setValor($ordenProveedor->getValorTotal());
        $partidaQ->setTiendaId($ordenProveedor->getTiendaId());
        $partidaQ->save();
        $ordenProveedorDetalle = GastoDetalleQuery::create()
                ->filterByGastoId($ordenProveedor->getId())
                ->find();

        $TOTALIVA = 0;
        $VALORtotal = 0;
        $VALOR_ISR = 0;
        $VALOR_RETIENE_IVA = 0;
        $VALOR_SIN_ISR = 0;
        $VALOR_RETENIDO_IVA = 0;
        foreach ($ordenProveedorDetalle as $registro) {
            $VALORtotal = $VALORtotal + $registro->getValorTotal();
            //$cuenContable = ($registro->getProducto()->getTipoAparato()->getCuentaContable());
//            $grupo = $registro->getCuentaContable();
//            $cuentaPartida = Partida::busca($grupo, 1, 1);
//            $cuentaContable = $cuentaPartida['cuenta'];
//            $nombreCuenta = $cuentaPartida['nombre'];
            $cuentaContable = $registro->getCuentaContable();
            $nombreCuenta = Partida::cuenta($cuentaContable);
            $valor = $registro->getValorTotal();
            $excento = false;
            if (!$registro->getGasto()->getAplicaIva()) {
                $excento = true;
            }
            $valoresIva = ParametroQuery::ObtenerIva($registro->getValorTotal(), $excento, $registro->getGasto()->getAplicaIsr(), $registro->getGasto()->getExcentoIsr(), $ordenProveedor->getProveedor()->getRegimenIsr(), $ordenProveedor->getRetieneIva());
            if ($cuentaContable == '61203047') {
                $valoresIva['IVA'] = 0;
                $valoresIva['VALOR_SIN_IVA'] = $registro->getValorTotal();
            }


            $valor = $valoresIva['VALOR_SIN_IVA'];
            $TOTALIVA = $valoresIva['IVA'] + $TOTALIVA;
            $VALOR_ISR = $VALOR_ISR + $valoresIva['VALOR_ISR'];
            $VALOR_RETIENE_IVA = $VALOR_RETIENE_IVA + $valoresIva['VALOR_RETIENE_IVA'];
            $VALOR_SIN_ISR = $VALOR_SIN_ISR + $valoresIva['VALOR_SIN_ISR'];
            $VALOR_RETENIDO_IVA = $VALOR_RETENIDO_IVA + $valoresIva['VALOR_RETENIDO_IVA'];
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaQ->getId());
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setDebe($valor);
            $partidaLinea->setHaber(0);
            $concepto = trim($registro->getConcepto());
            $concepto = str_replace(" ", "", $concepto);
            $concepto = trim($concepto);
            $concepto = substr($concepto, 0, 50);
            $partidaLinea->setGrupo($concepto);
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
            $partidaLinea->setGrupo("RETENCIONES DE IVA");
            $partidaLinea->save();
        }
        if ($VALOR_RETENIDO_IVA > 0) {
            ///  2031-08 VALOR_RETIENE_IVA
            $cuentaPartida = Partida::busca("IVA%RETENIDO", 0, 2);
            $cuentaContable = $cuentaPartida['cuenta'];
            $nombreCuenta = $cuentaPartida['nombre'];
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaQ->getId());
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setDebe(0);

            $partidaLinea->setHaber($VALOR_RETENIDO_IVA);
            $partidaLinea->setGrupo("IVARETENIDO");
            $partidaLinea->save();
        }


        $cuentaPartida = Partida::busca("RENTA%POR%PAGAR ", 0, 2);
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
            //  $partidaLinea->setGrupo($concepto);
            $partidaLinea->save();
        }
        $cuentaPartida = Partida::busca("PROVEEDOR COMPRA", 0, 2);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];

        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaQ->getId());
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe(0);
        $partidaLinea->setHaber($VALOR_SIN_ISR - $VALOR_RETENIDO_IVA);
        $partidaLinea->setGrupo("PROVEEDOR COMPRA");
        $partidaLinea->save();
        $ordenProveedor->setValorImpuesto($VALOR_ISR + $VALOR_RETIENE_IVA + $VALOR_RETENIDO_IVA);
        $ordenProveedor->setPartidaNo($partidaQ->getId());
        $ordenProveedor->save();
    }

    public function partidaPago($ordenPago) {
        $MedioPago = MedioPagoQuery::create()->findOneByNombre($ordenPago->getTipoPago());
        $partidaId = Partida::Crea('Pago Gasto ', $ordenPago->getCodigo(), $ordenPago->getValorTotal());
        // $cuentaContable = '2.1.1.2.001';
        $cuentaPartida = Partida::busca("PROVEEDOR COMPRA", 0, 2);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
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
        if ($MedioPago->getCuentaContable() <> "") {
            $cuentaContable = $MedioPago->getCuentaContable();
            $cuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($cuentaContable);
            $nombreCuenta = $cuentaQ->getNombre();
        }

        if (TRIM(strtoupper($MedioPago->getNombre())) == "DEPOSITO") {
            if ($ordenPago->getBancoId()) {
//          echo "aqui banco";
                if ($ordenPago->getBanco()->getCuentaContable()) {
                    $cuentaContable = $ordenPago->getBanco()->getCuentaContable();
                    $cuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($cuentaContable);
                    $nombreCuenta = $cuentaQ->getNombre();
//        echo $cuentaContable;
//        echo "<br>";
                }
            }
        }
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe(0);
        $partidaLinea->setHaber(round($ordenPago->getValorTotal(), 2));
        $partidaLinea->setTipo(2);
        $partidaLinea->setGrupo($MedioPago->getCodigo());
        $partidaLinea->save();
        $ordenPago->setPartidaNo($partidaId);
        $ordenPago->save();
    }

    public function executeConfirmar(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $ordenQ = GastoQuery::create()->findOneById($id);
        sfContext::getInstance()->getUser()->setAttribute('GastoId', null, 'seguridad');
        if ($ordenQ) {
            $tokenGuardado = sha1($ordenQ->getCodigo());
            if ($token == $tokenGuardado) {
                $ordenQ->setEstatus("Confirmada");
                $ordenQ->setFecha(date('Y-m-d H:i:s'));
                $ordenQ->setToken(sha1($ordenQ->getCodigo()));
                $ordenQ->save();
                if (!$ordenQ->getPartidaNo()) {
                    $this->partidaInventario($ordenQ);
                }

                $cuentaProveedor = CuentaProveedorQuery::create()->findOneByGastoId($ordenQ->getId());
                if (!$cuentaProveedor) {
                    $cuentaProveedor = new CuentaProveedor();
                    $cuentaProveedor->setGastoId($ordenQ->getId());
                }
                $valorPagar = $ordenQ->getValorTotal() - $ordenQ->getValorImpuesto();
                $valorPagar = round($valorPagar, 2);
                $cuentaProveedor->setProveedorId($ordenQ->getProveedorId());
                $cuentaProveedor->setFecha(date('Y-m-d'));
                $cuentaProveedor->setDetalle("Gasto " . $ordenQ->getCodigo());
                $cuentaProveedor->setValorTotal($valorPagar);
                $cuentaProveedor->setValorPagado(0);
                $cuentaProveedor->save();

                $this->redirect('orden_gasto/muestra?token=' . $token);
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
            }
        }
        $this->redirect('orden_gasto/index');
    }

    public function executePosponer(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $operacion = GastoQuery::create()->findOneById($id);
        if ($operacion) {
            $operacion->setEstatus('Pendiente');
            $operacion->save();
            sfContext::getInstance()->getUser()->setAttribute('GastoId', null, 'seguridad');
            $this->getUser()->setFlash('exito', 'Orden almacenada con exito ' . $operacion->getCodigo());
        }
        $this->redirect('orden_gasto/index');
    }

    public function executeVista(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $this->lin = 0;
        $this->tab = 1;
        $cajaid = $request->getParameter('cajaid');
        $linea = $request->getParameter('linea');
        $this->lineas = null;
        if ($linea) {
            $this->lin = $linea;
            $gastoDeta = GastoCajaDetalleQuery::create()->findOneById($linea);
            if ($gastoDeta) {
                $cajaid = "Caja" . $gastoDeta->getGastoCajaId();
                $this->lineas = GastoCajaDetalleQuery::create()->filterByGastoCajaId($gastoDeta->getGastoCajaId())->find();
                $this->tab = 3;
            }
        }

        $ordeCa = GastoQuery::create()->findOneByCodigo($cajaid);
        $token = $request->getParameter('token');
        if ($ordeCa) {
//            echo "<pre>";
//            print_r($ordeCa);
//            die();
            $token = $ordeCa->getToken();
        }



        $ordenQ = GastoQuery::create()->findOneByToken($token);
        if ($request->getParameter('id')) {
            $ordenQ = GastoQuery::create()->findOneById($request->getParameter('id'));
        }


        if (!$ordenQ) {
            $this->redirect('orden_gasto/index');
        }

        $this->orden = $ordenQ;
        $this->lista = GastoDetalleQuery::create()
                ->filterByGastoId($ordenQ->getId())
                ->find();
        $this->cuenta = CuentaProveedorQuery::create()->findOneByGastoId($ordenQ->getId());
        $this->ocultaPago = false;
        if ($this->cuenta) {
            $this->ocultaPago = $this->cuenta->getPagado();
        }

        $this->pagos = GastoPagoQuery::create()
                ->filterByGastoId($ordenQ->getId())
                ->find();
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        //    $this->cuenta = CuentaProveedorQuery::create()->findOneById($this->id);
        $value['fecha'] = date('d/m/Y');
    }

    public function executeMuestra(sfWebRequest $request) {
        error_reporting(-1);
        $this->partidas = null;

        date_default_timezone_set("America/Guatemala");
        $token = $request->getParameter('token');
        $ordenQ = GastoQuery::create()->findOneByToken($token);
        if (!$ordenQ) {
            $this->redirect('orden_gasto/index');
        }

        $gastoPago = GastoPagoQuery::create()
                ->filterByGastoId($ordenQ->getId())
                ->find();

        $this->orden = $ordenQ;
        $this->lista = GastoDetalleQuery::create()
                ->filterByGastoId($ordenQ->getId())
                ->find();
        $this->cuenta = CuentaProveedorQuery::create()->findOneByGastoId($ordenQ->getId());
        $this->ocultaPago = false;
        if ($this->cuenta) {
            $this->ocultaPago = $this->cuenta->getPagado();
        }
        sfContext::getInstance()->getUser()->setAttribute("proveedorId", $ordenQ->getProveedorId(), 'seguridad');
        $this->pagos = GastoPagoQuery::create()
                ->filterByGastoId($ordenQ->getId())
                ->find();
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        //    $this->cuenta = CuentaProveedorQuery::create()->findOneById($this->id);
        $cuentaVivi = CuentaProveedorQuery::create()->findOneByGastoId($ordenQ->getId());

        $value['fecha'] = date('d/m/Y');
        $value['aplica_isr'] = true;
        $value['aplica_iva'] = true;
        $value['valor'] = round(($cuentaVivi->getValorTotal() - $cuentaVivi->getValorPagado()), 2);
//        if ($ordenQ) {
//         $value['aplica_isr']=$ordenQ->getAplicaIsr();
//         $value['aplica_iva']=$ordenQ->getAplicaIva();
//        }
        $this->form = new SelePagoProveedorForm($value);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($valores);
//                die();
                $valor = $valores['valor'];
                $NotaCredito = NotaCreditoQuery::create()->findOneById($valores['tipo_pago']);

                if ($NotaCredito) {
                    $valorNOta = $NotaCredito->getValorTotal() - $NotaCredito->getValorConsumido();  // restar lo que ya se uso
                    if ($valor > $valorNOta) {
                        sfContext::getInstance()->getUser()->setAttribute('tab', 4, 'seguridad');
                        $this->getUser()->setFlash('error', 'Valor de Ingreso  ' . $valor . " es mayor que valor saldo nota credito " . $valorNOta);
                        $this->redirect('orden_gasto/muestra?token=' . $token);
                    }
                }

                $valorPagado = $cuentaVivi->getValorPagado() + $valor;

                if ($valorPagado > (round($cuentaVivi->getValorTotal(), 2))) {
                    sfContext::getInstance()->getUser()->setAttribute('tab', 4, 'seguridad');
                    $this->getUser()->setFlash('error', 'Valor de pago  ' . $valorPagado . " es mayor que valor documento " . $cuentaVivi->getValorTotal());
                    $this->redirect('orden_gasto/muestra?token=' . $token);
                }
                $fechaInicio = $valores['fecha'];
                $fechaInicio = explode('/', $fechaInicio);
                $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
                $OperaPgo = new GastoPago();
                $OperaPgo->setGastoId($ordenQ->getId());
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
//                if ($NotaCredito) {
//                 //   $OperaPgo->setTipoPago("Nota Crédito") ;
//                   // $OperaPgo->setDocumento($NotaCredito->getCodigo());
//                            ¨
//                }
                if ($valores['banco_id']) {
                    $OperaPgo->setBancoId($valores['banco_id']);
                }
                //* AQUI MOVIMIENTO_BANCO
                $OperaPgo->setFecha($fechaInicio);
                $OperaPgo->setUsuario($usuarioQ->getUsuario());
                $OperaPgo->setFechaCreo(date('Y-m-d H:i:s'));
                $OperaPgo->setCuentaProveedorId($cuentaVivi->getId());
                $OperaPgo->setEmpresaId($empresaId);
                $OperaPgo->setValorTotal($valor);
                $OperaPgo->save();
                $this->partidaPago($OperaPgo);
                $valorPagado = $cuentaVivi->getValorPagado() + $valor;
                $cuentaVivi->setFecha(date('Y-m-d H:i:s'));
                $cuentaVivi->setValorPagado($valorPagado);
                $cuentaVivi->setFechaPago(date('Y-m-d H:i:s'));
                if (round($valorPagado, 2) >= round($ordenQ->getValorTotal(), 2)) {
                    $cuentaVivi->setPagado(true);
                }
                $cuentaVivi->save();
                $ordenQ->setValorPagado($valorPagado);
                if (round($valorPagado, 2) >= round($cuentaVivi->getValorTotal(), 2)) {
                    $cuentaVivi->setPagado(true);
                }
                //  $ordenQ->setUpdatedAt(sf'Context::getInstance()->getUser()->getAttribute('usuarioNombre', null, 'seguridad'));
                $ordenQ->save();
                // *** aqui  
                if ($valores['banco_id']) {
                    if (strtoupper($valores['tipo_pago']) <> 'CHEQUE') {
                        $movimiento = New MovimientoBanco();
                        $movimiento->setTipo('Gasto');
                        $movimiento->setTipoMovimiento($valores['tipo_pago']);
                        $movimiento->setBancoId($valores['banco_id']);
                        $movimiento->setValor($valor * -1);
                        $movimiento->setBancoOrigen($valores['banco_id']);
                        $movimiento->setDocumento($valores['no_documento']);
                        $movimiento->setFechaDocumento($cuentaVivi->getFechaPago('Y-m-d'));
                        $movimiento->setObservaciones("Orden Gasto " . $ordenQ->getCodigo());
                        $movimiento->setEstatus("Confirmado");
                        //$movimiento->setMedioPagoId();
                        $movimiento->setUsuario($usuarioQ->getUsuario());
                        $movimiento->save();
                    }
                }


                sfContext::getInstance()->getUser()->setAttribute('tab', 4, 'seguridad');
                $this->getUser()->setFlash('exito', 'Pago realizado con exito ' . $OperaPgo->getCodigo());

                $this->redirect('orden_gasto/muestra?token=' . $token);
            }
        }
    }

    public function executeEliminaLinea(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $OrdenID = sfContext::getInstance()->getUser()->getAttribute('GastoId', null, 'seguridad');
        $ordenDetalle = GastoDetalleQuery::create()
                ->filterByGastoId($OrdenID)
                ->filterById($id)
                ->findOne();
        if ($ordenDetalle) {
            $OperacionId = $ordenDetalle->getGastoId();
            $ordenProveedor = GastoQuery::create()->findOneById($OperacionId);

            $tipoReg = '';
            if ($ordenProveedor->getProveedorId()) {
                $tipoReg = $ordenProveedor->getProveedor()->getRegimenIsr();
            }
            $excenta = $ordenProveedor->getExcento();
            $ordenDetalle->delete();
            $lista = GastoDetalleQuery::create()
                    ->withColumn('sum(GastoDetalle.ValorTotal)', 'TotalGeneral')
                    ->filterByGastoId($OperacionId)
                    ->findOne();
            $ordenProveedor->setSubTotal(0);
            $ordenProveedor->setValorTotal(0);
            $ordenProveedor->setIva(0);
            $ordenProveedor->setValorIsr(0);
            $ordenProveedor->setValorRetieneIva(0);
            if ($lista) {
                $suma = $lista->getTotalGeneral();
//rev
                $valores = ParametroQuery::ObtenerIva($suma, $excenta, $ordenProveedor->getAplicaIsr(), $ordenProveedor->getExcentoIsr(), $tipoReg, $ordenProveedor->getRetieneIva());
                $iva = $valores['IVA'];
                $valorSInIVa = $valores['VALOR_SIN_IVA'];
                $ordenProveedor->setSubTotal($valorSInIVa);
                $ordenProveedor->setValorTotal($suma);
                $ordenProveedor->setIva($iva);
                $ordenProveedor->setValorIsr($valores['VALOR_ISR']);
                $ordenProveedor->setValorRetieneIva($valores['VALOR_RETIENE_IVA']);
                $ordenProveedor->setValorRetenidoIva($valores['VALOR_RETENIDO_IVA']);
            }
            $ordenProveedor->save();
            $this->getUser()->setFlash('error', 'Registro eliminado  con exito ');
        }
        $this->redirect('orden_gasto/index?id=');
    }

    public function executeObservaciones(sfWebRequest $request) {
        $OperacionId = sfContext::getInstance()->getUser()->getAttribute('GastoId', null, 'seguridad');
        $ordenProveedor = GastoQuery::create()->findOneById($OperacionId);
        $valor = $request->getParameter('id');
        $ordenProveedor->setObservaciones($valor);
        $ordenProveedor->save();
        echo "actualizado";
        die();
    }

    public function executeNueva(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $posibles[] = 'Proceso';
        $posibles[] = 'Pendiente';
        $codigo = $request->getParameter('codigo');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $EmpresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $operacion = GastoQuery::create()
                ->filterByUsuario($usuarioQ->getUsuario())
                ->filterByEstatus($posibles, Criteria::IN)
                ->findOne();
        if ($operacion) {
            $operacionDetalle = GastoDetalleQuery::create()->filterByGastoId($operacion->getId())->count();
            if ($operacionDetalle > 0) {
                $operacion = null;
            }
        }
        if ($codigo) {
            $operacion = GastoQuery::create()->findOneByCodigo($codigo);
        }
        if (!$operacion) {
            $operacion = new Gasto();
            $operacion->setUsuario($usuarioQ->getUsuario());
            $operacion->setEstatus('Proceso');
            $operacion->save();
        }
        $tokenGuardado = sha1($operacion->getCodigo());
        $operacion->setToken($tokenGuardado);
        $operacion->setUsuario($usuarioQ->getUsuario());
        $operacion->setFecha(date('Y-m-d H:i:s'));
        // $operacion->setFechaDocumento(date('Y-m-d H:i:s'));
        $operacion->setDiasCredito($EmpresaQ->getDiasCredito());
        // $operacion->setFechaContabilizacion(date('Y-m-d  H:i:s'));
        $operacion->save();
        sfContext::getInstance()->getUser()->setAttribute('GastoId', $operacion->getId(), 'seguridad');
        $this->getUser()->setFlash('exito', 'Gasto iniciado con exito ' . $operacion->getCodigo());
        $this->redirect('orden_gasto/index');
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        $id_detalle = $request->getParameter('id');
        $this->tab = 1;
        if ($request->getParameter('tab')) {
            $this->tab = $request->getParameter('tab');
        }
        $agrega = $request->getParameter('agrega');
        $paraemtro = ParametroCuentaQuery::create()->findOneByTipo('Gasto');
        $id = sfContext::getInstance()->getUser()->getAttribute('GastoId', null, 'seguridad');
        $orden = GastoQuery::create()->findOneById($id);
        $provedorId = null;
        if ($orden) {
            $provedorId = $orden->getProveedorId();
        }

        $tablista = 1;
        if ($request->getParameter('tablista')) {
            $tablista = $request->getParameter('tablista');
        }
        $this->tablista = $tablista;
        $this->orden = $orden;
        $this->proveedor = ProveedorQuery::create()->findOneById($provedorId);
        $this->id = $id;
        $default = null;
        if ($paraemtro) {
            $default['cuenta'] = $paraemtro->getCuentaDefault();
        }
        $default['aplica_isr'] = false;
        $default['exento_isr'] = true;
        $default['aplica_iva'] = true;
        $default['aplica_isr'] = false;
        $default['exento_isr'] = false;
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $empreaq = EmpresaQuery::create()->findOneById($empresaId);
        if ($empreaq) {
            $default['aplica_isr'] = $empreaq->getRetieneIsr();
            // $default['exento_isr'] = $empreaq->getEIsr();
        }

        $default['tienda_id'] = sfContext::getInstance()->getUser()->getAttribute("tienda", null, 'seguridad');
        if ($orden) {
            $default['documento'] = $orden->getDocumento();
            $default['fecha_documento'] = $orden->getFecha('d/m/Y');
            $default['tipo_documento'] = $orden->getTipoDocumento();
            $default['dia_credito'] = $orden->getDiasCredito();
            $default['proveedor_id'] = $orden->getProveedorId();
            $default['proyecto_id'] = $orden->getProyectoId();
            $default['observaciones'] = $orden->getObservaciones();
            $default['exenta'] = $orden->getExcento();
            $default['tienda_id'] = $orden->getTiendaId();
            $default['exento_isr'] = $orden->getExcentoIsr();
            $default['aplica_isr'] = $orden->getAplicaIsr();
            $default['aplica_iva'] = $orden->getAplicaIva();
            $default['retiene_iva'] = $orden->getRetieneIva();
        }

        $lineas = GastoDetalleQuery::create()
                ->filterByGastoId($id)
                ->count();

        $ordenDetalle = GastoDetalleQuery::create()->findOneById($id_detalle);
        if ($ordenDetalle) {
            $default['valor'] = $ordenDetalle->getValorTotal();
            $default['cantidad'] = $ordenDetalle->getCantidad();
            $default['nombre'] = $ordenDetalle->getConcepto();
            $default['cuenta_contable'] = $ordenDetalle->getCuentaContable();
        }

        $detalles = GastoDetalleQuery::create()
                ->filterByGastoId($id)
                ->filterById($id_detalle, Criteria::NOT_EQUAL)
                ->find();
        $this->detalles = $detalles;

        $this->form = new CreaGastoCompletoForm($default);

        $this->lineas = $lineas;
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($orden);
//                echo "</pre>";
//                
//                echo "<pre>";
//                print_r($valores);
//                echo "</pre>";
//                die();

                if (!$orden) {
                    $this->redirect('orden_gasto/index?id=');
                }
                $fecha_documento = $valores['fecha_documento'];
                $fecha_documento = explode('/', $fecha_documento);
                $fecha_documento = $fecha_documento[2] . '-' . $fecha_documento[1] . '-' . $fecha_documento[0];
                $orden->setFecha($fecha_documento);
                $orden->setTipoDocumento($valores['tipo_documento']);
                $orden->setDocumento($valores['documento']);
                $orden->setDiasCredito($valores['dia_credito']);
                $orden->setProveedorId($valores['proveedor_id']);
                $orden->setProyectoId(null);
                $orden->setAplicaIva($valores['aplica_iva']);
                $orden->setAplicaIsr($valores['aplica_isr']);
                $orden->setExcentoIsr($valores['exento_isr']);
                $orden->setRetieneIva($valores['retiene_iva']);

                if ($valores['proyecto_id']) {
                    $orden->setProyectoId($valores['proyecto_id']);
                }
                $orden->setTiendaId(null);
                if ($valores['tienda_id']) {
                    $orden->setTiendaId($valores['tienda_id']);
                }
                $orden->setObservaciones($valores['observaciones']);
                $orden->setExcento(false);
                if ($valores['exenta']) {
                    $orden->setExcento(true);
                }
                $orden->setFecha($fecha_documento);
                $orden->save();

                $tipoReg = '';
                if ($orden->getProveedorId()) {
                    $tipoReg = $orden->getProveedor()->getRegimenIsr();
                }

                $USAIDP = 0;

                $listados = GastoDetalleQuery::create()
                        ->filterByGastoId($orden->getId())
                        ->find();
                $TOTALTiva = 0;
                $TOTALTSINiva = 0;
                foreach ($listados as $registr) {
                    $suma = $registr->getValorTotal();
                    //rev
                    $valoresIVA = ParametroQuery::ObtenerIva($suma, $orden->getExcento(), $orden->getAplicaIsr(), $orden->getExcentoIsr(), $tipoReg, $orden->getRetieneIva());
                    $iva = $valoresIVA['IVA'];
                    $valorSInIVa = $valoresIVA['VALOR_SIN_IVA'];

                    $IVAIDP = $iva;
                    $valorSInIVaIDP = $valorSInIVa;
                    if ($registr->getCuentaContable() == "61203047") {
                        $USAIDP = 1;
                        $iva = 0;
                        $valorSInIVa = $suma;
                    }
                    if ($registr->getCuentaContable() != "61203047") {
                        $IVAIDP = 0;
                        $valorSInIVaIDP = 0;
                    }

                    $TOTALTiva = $iva + $TOTALTiva;
                    $TOTALTSINiva = $valorSInIVa + $TOTALTSINiva;
                    $registr->setSubTotal($valorSInIVa);
                    $registr->setValorTotal($suma);
                    $registr->setIva($iva);
                    $registr->save();
                }

//                
//die();

                $idseleccion = 0;
                if ($valores['nombre'] <> '') {
                    if ($valores['cuenta_contable'] <> '') {
                        if (($valores['cantidad'] > 0) && ($valores['valor'] > 0)) {
                            if (!$ordenDetalle) {
                                $ordenDetalle = new GastoDetalle();
                            }
                            $ordenDetalle->setGastoId($orden->getId());
                            $ordenDetalle->setConcepto($valores['nombre']);
                            $ordenDetalle->setCuentaContable($valores['cuenta_contable']);
                            $ordenDetalle->setCantidad($valores['cantidad']);
                            $suma = $valores['valor'];
                            //  rev
                            $valoresIVA = ParametroQuery::ObtenerIva($suma, $orden->getExcento(), $orden->getAplicaIsr(), $orden->getExcentoIsr(), $tipoReg, $orden->getRetieneIva());
                            $iva = $valoresIVA['IVA'];
                            $valorSInIVa = $valoresIVA['VALOR_SIN_IVA'];
                            if ($valores['cuenta_contable'] == "61203047") {
                                $iva = 0;
                                $valorSInIVa = $suma;
                            }

                            $ordenDetalle->setSubTotal($valorSInIVa);
                            $ordenDetalle->setValorTotal($suma);
                            $ordenDetalle->setIva($iva);
                            $ordenDetalle->save();
                            $idseleccion = $ordenDetalle->getId();
                        }
                    }
                }

                if ($id_detalle) {
                    $idseleccion = 0;
                }

                $lista = GastoDetalleQuery::create()
                        ->withColumn('sum(GastoDetalle.ValorTotal)', 'TotalGeneral')
                        ->filterByGastoId($orden->getId())
                        ->findOne();
                $orden->setSubTotal(0);
                $orden->setValorTotal(0);
                $orden->setIva(0);
                if ($lista) {
                    $suma = $lista->getTotalGeneral();
                    //rev
                    $valoresIVA = ParametroQuery::ObtenerIva($suma, $orden->getExcento(), $orden->getAplicaIsr(), $orden->getExcentoIsr(), $tipoReg, $orden->getRetieneIva());
                    $iva = $valoresIVA['IVA'];
                    $valorSInIVa = $valoresIVA['VALOR_SIN_IVA'];
                    $orden->setSubTotal($valorSInIVa);
                    $orden->setValorTotal($suma);
                    $orden->setValorIsr($valoresIVA['VALOR_ISR']);
                    $orden->setValorRetieneIva($valoresIVA['VALOR_RETIENE_IVA']);
                    $orden->setValorRetenidoIva($valoresIVA['VALOR_RETENIDO_IVA']);
                    $orden->setIva($iva);
                    if ($USAIDP) {

                        $orden->setIva($TOTALTiva);
                        $orden->setSubTotal($TOTALTSINiva);
                    }
                }
                $orden->save();

                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect('orden_gasto/index?id=' . $idseleccion);
            }
        }

        $posibles[] = 'Pendiente';
        $posibles[] = 'Proceso';
        $ordenPendientes = GastoDetalleQuery::create()
                ->useGastoQuery()
                ->filterByEstatus($posibles, Criteria::IN)
                ->endUse()
                ->groupByGastoId()
                ->find();
        $this->pendientes = $ordenPendientes;

        $muestralinea = 0;
        if ($lineas == 0) {
            $muestralinea = 1;
        }
        $subtotal = 0;
        $iva = 0;
        if ($ordenDetalle) {
            $muestralinea = 1;
            $subtotal = $ordenDetalle->getSubTotal();
            $iva = $ordenDetalle->getIva();
        }
        if ($agrega) {
            $muestralinea = 1;
        }
        $this->muestalinea = $muestralinea;
        $this->id_detalle = $id_detalle;
        $this->subtotal = $subtotal;
        $this->iva = $iva;
        $this->agrega = $agrega;
    }

}
