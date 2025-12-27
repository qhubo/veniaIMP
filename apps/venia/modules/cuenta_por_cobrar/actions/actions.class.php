<?php

class cuenta_por_cobrarActions extends sfActions {

    
      public function executeEliminapago(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&$dirh =
    $operacionQ= OperacionPagoQuery::create()->findOneById($id);
   $OperacionId= $operacionQ->getId();
    $operacionQ->delete();
                  $this->getUser()->setFlash('error', "Cheque eliminado con exito");
            $this->redirect('cuenta_por_cobrar/caja?id=' . $OperacionId);
      }
    
  public function executeNota(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&$dirh =
        $documento =$request->getParameter('documento');
        $estatus[]='Nueva';
        $estatus[]='Procesada';
        $notaCredito = NotaCreditoQuery::create()
                ->filterByTipoNota('CLIENTE')
                ->filterByEstatus($estatus, Criteria::IN )
                ->filterByCodigo($documento)
                ->findOne();
        $valor=0;
        if ($notaCredito) {
           $valor= $notaCredito->getValorTotal();
        }
        echo $valor;
        die();
        }
    
    public function executeConfirmarCheque(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&$dirh =
        $deposito = $request->getParameter('deposito');
         $bancoId = $request->getParameter('banco');
         $OperaPgo = OperacionPagoQuery::create()->findOneById($id);
        $OperacionId = $OperaPgo->getOperacionId();
        if (trim($deposito)=="") {
            $this->getUser()->setFlash('error', "Debe ingresar numero de deposito");
            $this->redirect('cuenta_por_cobrar/caja?id=' . $OperacionId);
        }
        if (!$bancoId) {
            $this->getUser()->setFlash('error', "Debe ingresar banco");
            $this->redirect('cuenta_por_cobrar/caja?id=' . $OperacionId);
            
        }   
            

       
        $operacion = $OperaPgo->getOperacion();
        $valor = $OperaPgo->getValor();
        $valorPagado = round($operacion->getValorPagado(), 2) + round($valor, 2);
        if (round($valorPagado, 2) > round($operacion->getValorTotal(), 2)) {
            sfContext::getInstance()->getUser()->setAttribute('tab', 4, 'seguridad');
            $this->getUser()->setFlash('error', 'Valor de pago  ' . $valorPagado . " es mayor que valor documento " . $operacion->getValorTotal());
            $this->redirect('cuenta_por_cobrar/caja?id=' . $OperacionId);
        }
        $valorPagado = $operacion->getValorPagado() + $valor;
        $OperaPgo->setFechaCreo(date('Y-m-d H:i:s'));
        $OperaPgo->setTipo('DEPOSITO');
        $OperaPgo->setBancoId($bancoId);
        $OperaPgo->setDocumento($deposito);
        if ($valorPagado >= $operacion->getValorTotal()) {
            $operacion->setPagado(true);
        }
        $OperaPgo->save();
        $operacion->setValorPagado($valorPagado);
        $operacion->save();
        $this->partidaPago($OperaPgo);
        if ($OperaPgo->getBancoId()) {
            $movimiento = New MovimientoBanco();
            $movimiento->setTipo('Pago');
            $movimiento->setTipoMovimiento($OperaPgo->getTipo());
            $movimiento->setBancoOrigen($OperaPgo->getBancoId());
            $movimiento->setDocumento($OperaPgo->getDocumento());
            $movimiento->setBancoId($OperaPgo->getBancoId());
            $movimiento->setFechaDocumento($OperaPgo->getFechaDocumento('Y-m-d H:i'));
            $movimiento->setValor($OperaPgo->getValor());
            $movimiento->setObservaciones("Pago Operacion " . $operacion->getCodigo());
            $movimiento->setEstatus("Confirmado");
            $movimiento->setUsuario($OperaPgo->getUsuario());
            $movimiento->save();
            $cxc = New CuentaBanco();
            $cxc->setBancoId($OperaPgo->getBancoId());
            $cxc->setOperacionPagoId($OperaPgo->getId());
            $cxc->setValor($OperaPgo->getValor());
            $cxc->setFecha($OperaPgo->getFechaCreo('Y-m-d'));
            $cxc->setDocumento($OperaPgo->getDocumento());
            $cxc->setUsuario($OperaPgo->getUsuario());
            $cxc->setCreatedAt($OperaPgo->getFechaCreo());
            $cxc->setObservaciones($OperaPgo->getTipo());
            $cxc->save();
        }
        sfContext::getInstance()->getUser()->setAttribute('tab', 4, 'seguridad');
        $this->getUser()->setFlash('exito', 'Pago realizado con exito ' . $OperaPgo->getId());
        if ($valorPagado >= $operacion->getValorTotal()) {
            $this->redirect('cuenta_por_cobrar/index?id=' . $OperaPgo->getId());
        }
        $this->redirect('cuenta_por_cobrar/caja?id=' . $OperacionId);
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        $this->id = $request->getParameter('id'); //=155555&$dirh =
        $acceso = MenuSeguridad::Acceso('lista_cobro');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        $this->prover = $request->getParameter('prover');
        $this->operacionPago = OperacionPagoQuery::create()->findOneById($this->id);
        $registros = OperacionQuery::create()
                ->filterByClienteId(null, Criteria::NOT_EQUAL)
                ->filterByPagado(false)
                ->filterByValorPagado(0, Criteria::GREATER_THAN)
                ->find();
        foreach ($registros as $deta) {
            $valorTotal = round($deta->getValorTotal(), 2);
            $valorPagado = round($deta->getValorPagado(), 2);
            if ($valorPagado == $valorTotal) {
                $deta->setPagado(true);
                $deta->save();
            }
        }
        $this->bancos = BancoQuery::create()->find();
        $registros = new OperacionQuery();
        $registros->filterByEstatus('Cuenta Cobrar');
        $registros->filterByPagado(false);
        if ($this->prover) {
            $registros->filterByClienteId($this->prover);
        }
        $this->operaciones = $registros->find();
        $proveedores = OperacionQuery::create()
                ->filterByEstatus('Cuenta Cobrar')
                ->useClienteQuery()
                ->endUse()
                ->groupByClienteId()
                ->filterByPagado(false)
                ->orderBy("Cliente.Nombre", 'Asc')
                ->find();
        $seleccion = null;
        foreach ($proveedores as $registro) {
            $seleccion[$registro->getClienteId()] = $registro->getCliente()->getNombre();
        }
        $this->seleccion = $seleccion;
        $this->totalSuma = $this->suma($this->prover);
    }

    public function suma($prove) {
        $valorTotal = 0;
        $movimient = new OperacionQuery();
        $movimient->filterByPagado(false);
        $movimient->filterByEstatus('Cuenta Cobrar');
        if ($prove) {
            $movimient->filterByClienteId($prove);
        }
        $movimient->withColumn('sum(Operacion.ValorTotal)', 'ValorTotalTotal');
        $movimient->withColumn('sum(Operacion.ValorPagado)', 'ValorPagadoPagado');
        $movimiento = $movimient->findOne();
        if ($movimiento) {
            if ($movimiento->getValorTotal()) {
                $valorTotal = $movimiento->getValorTotalTotal() - $movimiento->getValorPagadoPagado();
            }
        }
        return $valorTotal;
    }

    public function executeCaja(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $OperacionId = $request->getParameter('id'); //=155555&$dirh =
        $operacion = OperacionQuery::create()->findOneById($OperacionId);
        $this->operacion = OperacionQuery::create()->findOneById($OperacionId);
        $this->detalle = OperacionDetalleQuery::create()->filterByOperacionId($OperacionId)->find();
        $listaNo[] = 'CXC COBRAR';
        $listaNo[] = 'CHEQUE PREFECHADO';
        $listaNo[] = 'CHEQUEPREFECHADO';
        $this->pagos = OperacionPagoQuery::create()->filterByTipo($listaNo, Criteria::NOT_IN)->filterByOperacionId($OperacionId)->find();
        $listaN[] = 'CHEQUE PREFECHADO';
        $listaN[] = 'CHEQUEPREFECHADO';
        $this->prefechado = OperacionPagoQuery::create()->filterByTipo($listaN, Criteria::IN)->filterByOperacionId($OperacionId)->find();
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $value['fecha'] = date('d/m/Y');
        $value['factura_electronica'] = true;
        $this->form = new SelePagoCxcCobrarForm($value);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();

                    $banco_id=$valores['banco_id'];
                if ($banco_id) {
                   $documento =$valores['no_documento'];
                   $operacionPago = OperacionPagoQuery::create()
                           ->filterByBancoId($banco_id)
                           ->filterByDocumento($documento)
                           ->findOne();
                   if ($operacionPago) {
                                   $this->getUser()->setFlash('error', 'Numero de documento ya fue utilizado para este banco recibo  '.$operacionPago->getCodigo());
                     $this->redirect('cuenta_por_cobrar/caja?id=' . $OperacionId);
                   }
                    
                }
                   
                
                $valor = $valores['valor'];
                $tipoPago = $valores['tipo_pago'];
                $tipoPago = str_replace(" ", "", $tipoPago);
                $tipoPago = strtoupper(trim($tipoPago));
                $fechaInicio =null;
                if ($tipoPago == "CHEQUEPREFECHADO") {
                    $fechaInicio = $valores['fecha'];
                    $fechaInicio = explode('/', $fechaInicio);
                    $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
                    $OperaPgo = new OperacionPago();
                    $OperaPgo->setOperacionId($operacion->getId());
                    $OperaPgo->setTipo($valores['tipo_pago']);
                    $OperaPgo->setDocumento($valores['no_documento']);
                    if ($valores['banco_id']) {
                        $OperaPgo->setBancoId($valores['banco_id']);
                    }
                    $OperaPgo->setFechaDocumento($fechaInicio);
                    $OperaPgo->setUsuario($usuarioQ->getUsuario());
                    $OperaPgo->setFechaCreo(date('Y-m-d H:i:s'));
                    $OperaPgo->setValor($valor);
                    $OperaPgo->setComision($valores['comision']);
                    $OperaPgo->setVuelto($valores['vuelto']);
                    $OperaPgo->save();
                    $this->getUser()->setFlash('exito', 'Cheque Prefechado ingresado con exito' . $OperaPgo->getId());
                    $this->redirect('cuenta_por_cobrar/caja?id=' . $OperacionId);
           //         die();
                }

             
//                echo "<pre>";
//                print_r($valores);
//                die();
                
                $valorPagado = round($operacion->getValorPagado(), 2) + round($valor, 2)-$valores['vuelto'];
//                echo $valorPagado;
//                echo "<pre>";
//                print_r($valores);
//                die();
                if (round($valorPagado, 2) > round($operacion->getValorTotal(), 2)) {
                    sfContext::getInstance()->getUser()->setAttribute('tab', 4, 'seguridad');
                    $this->getUser()->setFlash('error', 'Valor de pago  ' . $valorPagado . " es mayor que valor documento " . $operacion->getValorTotal());
                    $this->redirect('cuenta_por_cobrar/caja?id=' . $OperacionId);
                }
              //  if ($operacion->getCliente()->getCodigo() == 'CONTRAENTREGA') {
                    $valorSuma = round($valores['valor'] + $valores['comision'], 2);
                    $valorTotal = round($operacion->getValorTotal(), 2);
                 //   if ($valorSuma > $valorTotal+ $valores['']) {
                  //      $this->getUser()->setFlash('error', 'Valor Total  ' . $valorTotal . " debe ser igual a valor comision y valor pago " . $valorSuma);
                   //     $this->redirect('cuenta_por_cobrar/caja?id=' . $OperacionId);
                   // }
              if ($tipoPago == "NOTACREDITO") {
                    $notaCredito = NotaCreditoQuery::create()->findOneByCodigo($valores['no_documento']);
                    if (!$notaCredito) {
                       $this->getUser()->setFlash('error', 'Nota credito no encontrada ' . $valores['no_documento']);
                       $this->redirect('cuenta_por_cobrar/caja?id=' . $OperacionId);
                    }
                    $valorCOnsumido =$notaCredito->getValorPagado() +$valor;
                    $notaCredito->setValorPagado($valorCOnsumido);
                    $notaCredito->setDocumentoCanje($operacion->getCodigo());
                    $notaCredito->setEstatus('Canjeado');
                    $notaCredito->save();
            }
              
            
            if ($valores['fecha']) {
                      $fechaInicio = $valores['fecha'];
                    $fechaInicio = explode('/', $fechaInicio);
                    $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
            } else {
                $fechaInicio=date('Y-m-d');
            }
                    

                $OperaPgo = new OperacionPago();
                $OperaPgo->setOperacionId($operacion->getId());
                $OperaPgo->setTipo($valores['tipo_pago']);
                $OperaPgo->setDocumento($valores['no_documento']);
                if ($valores['banco_id']) {
                    $OperaPgo->setBancoId($valores['banco_id']);
                }
                $OperaPgo->setFechaDocumento($fechaInicio);
                $OperaPgo->setUsuario($usuarioQ->getUsuario());
                $OperaPgo->setFechaCreo(date('Y-m-d H:i:s'));
                $OperaPgo->setValor($valor);
                $OperaPgo->setComision($valores['comision']);
                $OperaPgo->setVuelto($valores['vuelto']);
                $OperaPgo->setCxcCobrar($operacion->getCodigo());
                $OperaPgo->save();

                $valorPagado = $operacion->getValorPagado() + $valor + $valores['comision'];
                $OperaPgo->setFechaCreo(date('Y-m-d H:i:s'));
                if ($valorPagado >= $operacion->getValorTotal()) {
                    $operacion->setPagado(true);
                    $detalle = OperacionDetalleQuery::create()
                            ->filterByOperacionId($operacion->getId())
                            ->useProductoQuery()
                            ->filterByTercero(true)
                            ->endUse()
                            ->count();
                    if ($detalle > 0) {
                        $operacion->setEstatus('Entrega');
                        $operacion->save();
                    }
                }
                $operacion->setValorPagado($valorPagado);
                $operacion->save();

                $this->partidaPago($OperaPgo);
                if ($OperaPgo->getBancoId()) {
                    $movimiento = New MovimientoBanco();
                    $movimiento->setTipo('Pago');
                    $movimiento->setTipoMovimiento($OperaPgo->getTipo());
                    $movimiento->setBancoOrigen($OperaPgo->getBancoId());
                    $movimiento->setDocumento($OperaPgo->getDocumento());
                    $movimiento->setBancoId($OperaPgo->getBancoId());
                    $movimiento->setFechaDocumento($OperaPgo->getFechaDocumento('Y-m-d H:i'));
                    $movimiento->setValor($OperaPgo->getValor());
                    $movimiento->setObservaciones("Pago Operacion " . $operacion->getCodigo());
                    $movimiento->setEstatus("Confirmado");
                    $movimiento->setUsuario($OperaPgo->getUsuario());
                    $movimiento->save();

                    $cxc = New CuentaBanco();
                    $cxc->setBancoId($OperaPgo->getBancoId());
                    $cxc->setOperacionPagoId($OperaPgo->getId());
                    $cxc->setValor($OperaPgo->getValor());
                    $cxc->setFecha($OperaPgo->getFechaCreo('Y-m-d'));
                    $cxc->setDocumento($OperaPgo->getDocumento());
                    $cxc->setUsuario($OperaPgo->getUsuario());
                    $cxc->setCreatedAt($OperaPgo->getFechaCreo());
                    $cxc->setObservaciones($OperaPgo->getTipo());
                    $cxc->save();
                }
                sfContext::getInstance()->getUser()->setAttribute('tab', 4, 'seguridad');
                $this->getUser()->setFlash('exito', 'Pago realizado con exito ' . $OperaPgo->getId());
 
                if ($valorPagado >= $operacion->getValorTotal()) {
                    $this->redirect('cuenta_por_cobrar/index?id=' . $OperaPgo->getId());
                }
                $this->redirect('cuenta_por_cobrar/index?id=' . $OperacionId);
                  }
            }

        $this->partidaQ = PartidaQuery::create()->filterByConfirmada(false)->findOneByCodigo($operacion->getCodigo());
    }

    public function partidaPago($ordenPago) {
           $cuentaContable = null;
        $comision = $ordenPago->getComision();
        $vuelto = $ordenPago->getVuelto();
        $ban='';
        $MedioPago = MedioPagoQuery::create()->findOneByNombre($ordenPago->getTipo());
        if (!$MedioPago) {
            $MedioPago = new MedioPago();
            $MedioPago->setNombre($ordenPago->getTipo());
            $MedioPago->setActivo(true);
            $MedioPago->save();
        }
        $partidaId = Partida::Crea('PagoVentaCobrar ', $ordenPago->getId(), $ordenPago->getValor() + $ordenPago->getComision());
        $MEDIP = MedioPagoQuery::create()->findOneByNombre($ordenPago->getTipo());
        if ($MEDIP) {
            $cuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($MEDIP->getCuentaContable());
            if ($cuentaQ) {
                $cuentaContable = $cuentaQ->getCuentaContable();
                $nombreCuenta = $cuentaQ->getNombre();
            }
        }
        if ($ordenPago->getBancoId()) {
            $ban = substr($ordenPago->getBanco()->getNombre(), 4);
        }
        if (!$cuentaContable) {
            $cuentaPartida = Partida::busca("VENTA " . $ordenPago->getTipo() . " " . $ban, 0, 2);
            $cuentaContable = $cuentaPartida['cuenta'];
            $nombreCuenta = $cuentaPartida['nombre'];
        }
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe($ordenPago->getValor());
        $partidaLinea->setHaber(0);
        $partidaLinea->setTipo(2);
        $partidaLinea->setGrupo("VENTA " . $ordenPago->getTipo() . " " . $ban);
        $partidaLinea->save();
        $ordenPago->setPartidaNo($partidaId);
        $ordenPago->save();

        if ($comision > 0) {
            $cuentaPartida = Partida::busca("COMISION VENTA");
            $cuentaContable = $cuentaPartida['cuenta'];
            $nombreCuenta = $cuentaPartida['nombre'];
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaId);
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setDebe($comision);
            $partidaLinea->setHaber(0);
            $partidaLinea->setTipo(2);
            $partidaLinea->setGrupo("COMISION VENTA");
            $partidaLinea->save();
        }
       if ($vuelto > 0) {
            $cuentaPartida = Partida::busca("VUELTO VENTA");
            $cuentaContable = $cuentaPartida['cuenta'];
            $nombreCuenta = $cuentaPartida['nombre'];
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaId);
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setDebe(0);
            $partidaLinea->setHaber($vuelto);
            $partidaLinea->setTipo(2);
            $partidaLinea->setGrupo("VUELTO VENTA");
            $partidaLinea->save();
        }

        



        // $cuentaContable = '2.1.1.2.001';
        $cuentaPartida = Partida::busca("CLIENTES POR COBRAR", 0, 2);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        //   $nombreCuenta = Partida::cuenta($cuentaContable);
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaId);
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe(0);
        $partidaLinea->setHaber($ordenPago->getValor() + $ordenPago->getComision()-$ordenPago->getVuelto());
        $partidaLinea->setTipo(0);
        $partidaLinea->setGrupo("CLIENTES POR COBRAR");
        $partidaLinea->save();
    }

    public function executeReporte(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $prover = $request->getParameter('prover');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = $EmpresaQuery->getNombre();
        $pestanas[] = 'Cuentas por Cobrar';
        $filename = "Cuentas por cobrar _" . $nombreempresa . date("d_m_Y");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $hoja = $xl->setActiveSheetIndex(0);
        //CABECERA  Y FILTRO
        $hoja->getRowDimension('1')->setRowHeight(15);
        $hoja->getRowDimension('2')->setRowHeight(20);
        $hoja->mergeCells("A1:A2");
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit(strtoupper($nombreempresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(13);
        // $hoja->getStyle("B1")->applyFromArray($styleArray);
        $hoja->getCell("C1")->setValueExplicit("Cuentas por cobrar al  " . date('d/m/Y'), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C1")->getFont()->setBold(true);
        $hoja->getStyle("C1")->getFont()->setSize(10);
        $fila = 3;
        $columna = 0;
        $encabezados = null;
        $encabezados[] = array("Nombre" => strtoupper("Código"), "width" => 12, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Tienda"), "width" => 25, "align" => "left", "format" => "#,##0");

        $encabezados[] = array("Nombre" => strtoupper("Fecha"), "width" => 18, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Cliente"), "width" => 45, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Nit"), "width" => 20, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Valor"), "width" => 20, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Valor Prefechado"), "width" => 20, "align" => "rigth", "format" => "#,##0.00");

        $encabezados[] = array("Nombre" => strtoupper("Valor Pagado"), "width" => 20, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Saldo"), "width" => 20, "align" => "rigth", "format" => "#,##0.00");

        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $registros = new OperacionQuery();
        $registros->filterByEstatus('Cuenta Cobrar');
        $registros->filterByPagado(false);
        if ($prover) {
            $registros->filterByClienteId($prover);
        }
        $this->registros = $registros->find();


        $total = 0;
        foreach ($this->registros as $deta) {
            $fila++;
            $total = $total + ($deta->getValorTotal() - $deta->getValorPagado());
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $deta->getCodigo());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $deta->getTienda());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $deta->getFecha('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $deta->getNombre());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $deta->getNit());  // ENTERO

            $datos[] = array("tipo" => 2, "valor" => $deta->getValorTotal());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $deta->getValorPrefechado());  // ENTERO   
            $datos[] = array("tipo" => 2, "valor" => $deta->getValorPagado());  // ENTERO          
            $datos[] = array("tipo" => 2, "valor" => $deta->getValorTotal() - $deta->getValorPagado());

            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;
//        $hoja->getCell("E" . $fila)->setValueExplicit("TOTALES ", PHPExcel_Cell_DataType::TYPE_STRING);
//        $hoja->getStyle("E" . $fila)->getFont()->setBold(true);
//        $hoja->getStyle("E" . $fila)->getFont()->setSize(12);
//        //$hoja->mergeCells("F" . $fila . ":G" . $fila);
//        $hoja->getCell("H" . $fila)->setValueExplicit(round($TOTAL, 2), PHPExcel_Cell_DataType::TYPE_NUMERIC);
//        $hoja->getStyle("H" . $fila)->getFont()->setBold(true);
//        $hoja->getStyle("H" . $fila)->getFont()->setSize(12);
//        $fila++;
//        $LetraFin = UsuarioQuery::numeroletra(7);
//        $hoja->getCell("A" . $fila)->setValueExplicit("ULTIMA LINEA", PHPExcel_Cell_DataType::TYPE_STRING);
//        $hoja->mergeCells("B" . $fila . ":" . $LetraFin . $fila);

        $hoja = $xl->setActiveSheetIndex(0);
        $prove = ClienteQuery::create()->findOneById($prover);
        if ($prove) {
            $filename .= "  Cliente " . $prove->getNombre();
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeVuelto(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&$dirh =
        $val = $request->getParameter('val'); //=155555&$dirh =
        $operacion = OperacionQuery::create()->findOneById($id);
        $valorPagado = round($operacion->getValorPagado(), 2) + round($val, 2);
        $valorTOTAL = $valorPagado - $operacion->getValorTotal();
        $total = 0;
        if ($valorTOTAL > 0) {
            $total = round($valorTOTAL,2);
        }
        echo $total;
        die();
    }

}
