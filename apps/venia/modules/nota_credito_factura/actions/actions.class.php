<?php

class nota_credito_facturaActions extends sfActions {

    public function executeEliminar(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioq = UsuarioQuery::create()->findOneById($usuarioId);
        $OperacionId = $request->getParameter('id'); //=155555&$dirh =
        $nota = NotaCreditoQuery::create()->findOneById($OperacionId);
        $partidadDetalle = PartidaDetalleQuery::create()->filterByPartidaId($nota->getPartidaNo())->find();
        if ($partidadDetalle) {
            $partidadDetalle->delete();
        }
        $partida = PartidaQuery::create()->findOneById($nota->getPartidaNo()); ///->find();
        if ($partida) {
            $partida->delete();
        }
        $nota->setEstatus('Anulado');
        $nota->setDocumento('');
        $nota->setConcepto('Anulado por usuario ' . $usuarioq->getUsuario() . " fecha " . date('d/m/Y'));
        $nota->save();
        $this->getUser()->setFlash('error', 'Nota credito anulada con exito');
        $this->redirect('nota_credito_factura/historial');
    }

    public function executeReenviar(sfWebRequest $request) {
        $OperacionId = $request->getParameter('id'); //=155555&$dirh =
        $operacionQ = OperacionQuery::create()->findOneById($OperacionId);
        $returna = Operacion::NotaFel($OperacionId);
        if (trim($returna['ERROR']) <> "") {
            $this->getUser()->setFlash('error', 'ERROR FEL ' . $returna['ERROR']);
        }
        if (trim($returna['CONTIGENCIA']) <> "") {
            $this->getUser()->setFlash('error', 'FACTURA EN CONTINGENCIA ' . $returna['CONTIGENCIA']);
        }
        if (trim($returna['UUID']) <> "") {
            $this->getUser()->setFlash('exito', 'FACTURA FEL creada con exito ' . $returna['UUID']);
        }
        $notaQ = NotaCreditoQuery::create()->findOneByDocumento($operacionQ->getCodigo());
        $notaID = null;
        if ($notaQ) {
            $notaID = $notaQ->getId();
        }
        $this->redirect('nota_credito_factura/index?id=' . $notaID);
    }

    public function executeHistorial(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $acceso = MenuSeguridad::Acceso('nota_credito');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        date_default_timezone_set("America/Guatemala");
        $acceso = MenuSeguridad::Acceso('nota_credito');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBanco', null, 'consulta'));
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('datoconsultaBanco', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaReporteCajaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsultaBanco', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBanco', null, 'consulta'));
                $this->redirect('nota_credito_factura/historial');
            }
        }
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '00:00';
        $valores['fin'] = '23:00';
        $this->operaciones = NotaCreditoQuery::create()
                ->filterByTipoNota('CLIENTE')
                ->orderByFecha("Desc")
                ->where("NotaCredito.Fecha  >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("NotaCredito.Fecha  <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->find();
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $acceso = MenuSeguridad::Acceso('nota_credito');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBanco', null, 'consulta'));
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['busqueda'] = '';
            sfContext::getInstance()->getUser()->setAttribute('datoconsultaBanco', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFacturaNotaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsultaBanco', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBanco', null, 'consulta'));
                $this->redirect('nota_credito_factura/index?id=');
            }
        }
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '00:00';
        $valores['fin'] = '23:00';
        $operaciones = new OperacionQuery();
        $operaciones->where("Operacion.Fecha  >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'");
        $operaciones->where("Operacion.Fecha  <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'");
        if ($valores['busqueda'] <> "") {
            $bus = "%" . $valores['busqueda'] . "%";
            $operaciones->where("(Operacion.Nombre like '" . $bus . "' or Operacion.Nit like '" . $bus . "')");
        }
        $this->operaciones = $operaciones->find();
        $this->partidaPen = PartidaQuery::create()
                ->filterByConfirmada(0)
                ->filterByTipo('Nota Cliente')
                ->findOne();

        $Id = $request->getParameter('id');
        $notaCredito = NotaCreditoQuery::create()->findOneById($Id);
        $this->notaCredito = $notaCredito;
        $operacion = null;
        if ($notaCredito) {
            $operacion = OperacionQuery::create()->findOneByCodigo($notaCredito->getDocumento());
        }
        $this->operacion = $operacion;
    }

    public function executeNueva(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioq = UsuarioQuery::create()->findOneById($usuarioId);
        $OperacionId = $request->getParameter('id'); //=155555&$dirh =
        $this->operacion = OperacionQuery::create()->findOneById($OperacionId);
        $operacion = OperacionQuery::create()->findOneById($OperacionId);
        $this->detalle = OperacionDetalleQuery::create()->filterByOperacionId($OperacionId)->find();
        $this->pagos = OperacionPagoQuery::create()->filterByOperacionId($OperacionId)->find();
        $this->form = new CreaNotaFacturaForm(null);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $nuevo = new NotaCredito();
                $nuevo->setTipoDocumento('FACTURA');
                $nuevo->setFecha(date('Y-m-d H:i:s'));
                $nuevo->setClienteId($operacion->getClienteId());
                $ClienteQ = ClienteQuery::create()->findOneById($operacion->getClienteId());
                $nuevo->setNombre($operacion->getNombre());
                if ($ClienteQ) {
                    $nuevo->setNombre($ClienteQ->getNombre());
                }
                $nuevo->setDocumento($operacion->getCodigo());  // => 5458488
                $excento = false;
                $valoresIva = ParametroQuery::ObtenerIva($valores['valor']);
                $nuevo->setValorTotal($valores['valor']); // => 390
                $nuevo->setSubTotal($valoresIva['VALOR_SIN_IVA']);
                $nuevo->setIva($valoresIva['IVA']);
                $nuevo->setConcepto($valores['observaciones']);  // => Devolucion en repuesto fact xela 102-1230
                $nuevo->setEstatus('Nueva');
                $nuevo->setUsuario($usuarioq->getUsuario());
                $nuevo->setCreatedBy($usuarioq->getUsuario());
                $nuevo->setCreatedAt(date('Y-m-d H:i:s'));
                $nuevo->setTipoNota('CLIENTE');
                $nuevo->save();
                //* AQUI MOVIMIENTO_BANCO
                $this->partida($nuevo);
                $resultado = Operacion::NotaFel($OperacionId);
                $firma = $operacion->getAnulaFaceFirma();
                $nuevo->setFaceFirma($firma);
                if ($firma) {
                    $nuevo->setEstatus("Procesada");
                }
                $nuevo->save();
                $this->getUser()->setFlash('exito', 'Nota Credito  realizada con exito  # ' . $nuevo->getCodigo());
                $this->redirect('nota_credito_factura/index?id=' . $nuevo->getId());
            }
        }
    }

    public function partida($nota) {
        $partidaQ = new Partida();
        $partidaQ->setFechaContable($nota->getFecha('Y-m-d'));
        $partidaQ->setUsuario($nota->getUsuario());
        $partidaQ->setTipo('Nota Cliente');
        $partidaQ->setCodigo($nota->getCodigo());
        $partidaQ->setValor($nota->getValorTotal());
        // $partidaQ->setTiendaId($egreso->getTiendaId());
        //  $partidaQ->setMedioPagoId($egreso->getMedioPagoId());
        $partidaQ->save();
        $Deposito = $nota->getValorTotal();
        $tienda = '';

        $valoresIva = ParametroQuery::ObtenerIva($nota->getValorTotal());
        $VALORSINIVA = $valoresIva['VALOR_SIN_IVA'];
        $IVA = $valoresIva['IVA'];

        //4010-08	VENTAS Periferico	4010-08
        $cuentaPartida = Partida::busca("DEVOLUCION NOTA", 0, 1);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaQ->getId());
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe($VALORSINIVA);
        $partidaLinea->setHaber(0);
        $partidaLinea->setGrupo("DEVOLUCION NOTA");
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();
        $nota->setPartidaNo($partidaQ->getId());
        $nota->save();
        $cuentaPartida = Partida::busca("IVA%NOTA%", 0, 1);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        
               $cuentaPartida = Partida::busca("DEVOLUCION NOTA", 0, 1);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaQ->getId());
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe($VALORSINIVA);
        $partidaLinea->setHaber(0);
        $partidaLinea->setGrupo("DEVOLUCION NOTA");
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();
        $nota->setPartidaNo($partidaQ->getId());
        $nota->save();
        $cuentaPartida = Partida::busca("IVA%NOTA%", 0, 1);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaQ->getId());
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe($IVA);
        $partidaLinea->setHaber(0);
        $partidaLinea->setGrupo("IVA NOTA");
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();
        $cuentaPartida = Partida::busca("NOTA DEPOS", 0, 1);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaQ->getId());
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe(0);
        $partidaLinea->setHaber($Deposito);
        $partidaLinea->setGrupo("NOTA DEPOS");
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();
    }

}
