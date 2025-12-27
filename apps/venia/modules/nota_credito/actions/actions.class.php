<?php

/**
 * nota_credito actions.
 *
 * @package    plan
 * @subpackage nota_credito
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class nota_creditoActions extends sfActions {

    public function executeVista(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $ordenQ = NotaCreditoQuery::create()->findOneById($id);
//        if (!$ordenQ) {
//            $this->redirect('orden_gasto/index');
//        }
        $this->orden = $ordenQ;
    }

    public function partida($nota) {


        $partidaQ = new Partida();
        $partidaQ->setFechaContable($nota->getFecha('Y-m-d'));
        $partidaQ->setUsuario($nota->getUsuario());
        $partidaQ->setTipo('Nota Credito');
        $partidaQ->setCodigo($nota->getCodigo());
        $partidaQ->setValor($nota->getValorTotal());
        // $partidaQ->setTiendaId($egreso->getTiendaId());
        //  $partidaQ->setMedioPagoId($egreso->getMedioPagoId());
        $partidaQ->save();
        $Deposito = $nota->getValorTotal();
        $tienda = '';

        $cuentaPartida = Partida::busca("NOTA_PROVEEDOR", 0, 1);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaQ->getId());
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe($Deposito);
        $partidaLinea->setHaber(0);
        $partidaLinea->setGrupo("NOTA_PROVEEDOR");
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();

        $valoresIva = ParametroQuery::ObtenerIva($nota->getValorTotal());
        $VALORSINIVA = $valoresIva['VALOR_SIN_IVA'];
        $IVA = $valoresIva['IVA'];

        $cuentaPartida = Partida::busca("IVA%PAGAR%", 0, 1);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaQ->getId());
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe(0);
        $partidaLinea->setHaber($IVA);
        $partidaLinea->setGrupo("IVA POR PAGAR");
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();

        //4010-08	VENTAS Periferico	4010-08
        $cuentaPartida = Partida::busca("ACREDITA NOTA", 0, 1);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaQ->getId());
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe(0);
        $partidaLinea->setHaber($VALORSINIVA);
        $partidaLinea->setGrupo("ACREDITA NOTA");
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();
        $nota->setPartidaNo($partidaQ->getId());
        $nota->save();
    }

    public function executeNueva(sfWebRequest $request) {

        $acceso = MenuSeguridad::Acceso('nota_credito');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }


        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioq = UsuarioQuery::create()->findOneById($usuarioId);
        $default = null;
        $default['aplica_iva'] = true;
        $this->form = new CreaNotaCreForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $nuevo = new NotaCredito();
                $nuevo->setTipoDocumento($valores['tipo']);
                $nuevo->setFecha(date('Y-m-d H:i:s'));
                $nuevo->setProveedorId($valores['proveedor_id']);
                $proveQ = ProveedorQuery::create()->findOneById($valores['proveedor_id']);
                $nuevo->setNombre($proveQ->getNombre());
                $nuevo->setDocumento($valores['referencia_factura']);  // => 5458488
                $excento = false;
                if (!$default['aplica_iva']) {
                    $excento = true;
                }
                $valoresIva = ParametroQuery::ObtenerIva($valores['valor'], $excento, true, false, $proveQ->getRegimenIsr());
                $nuevo->setValorTotal($valores['valor']); // => 390
                $nuevo->setSubTotal($valoresIva['VALOR_SIN_IVA']);
                $nuevo->setIva($valoresIva['IVA']);
                $nuevo->setConcepto($valores['concepto']);  // => Devolucion en repuesto fact xela 102-1230
                $nuevo->setEstatus('Nuevo');
                $nuevo->setUsuario($usuarioq->getUsuario());
                $nuevo->setCreatedBy($usuarioq->getUsuario());
                $nuevo->setCreatedAt(date('Y-m-d H:i:s'));
                 $nuevo->setTipoNota('PROVEEDOR');

//                if ($valores["archivo"]) {
//                    $archivo = $valores["archivo"];
//                    $nombre = $archivo->getOriginalName();
//                    $nombre = str_replace(" ", "_", $nombre);
//                    $nombre = str_replace(".", "", $nombre);
//                    $filename = $nuevo->getId() . "_" . $nombre . date("ymdhis") . $archivo->getExtension($archivo->getOriginalExtension());
//                    $archivo->save(sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . 'devoluciones' . DIRECTORY_SEPARATOR . $filename);
//                    $nuevo->setArchivo($filename);
//                    $nuevo->save();
//                }
                $nuevo->save();
                $nuevo->save();
                //* AQUI MOVIMIENTO_BANCO
                $this->partida($nuevo);
                $this->getUser()->setFlash('exito', 'Nota Credito  realizada con exito  # ' . $nuevo->getCodigo());
                $this->redirect('nota_credito/index');
            }
        }
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
            sfContext::getInstance()->getUser()->setAttribute('datoconsultaBanco', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaReporteCajaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsultaBanco', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBanco', null, 'consulta'));
                $this->redirect('nota_credito/index?id=');
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
                ->filterByTipoNota('PROVEEDOR')
                ->orderByFecha("Desc")
                ->where("NotaCredito.Fecha  >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("NotaCredito.Fecha  <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->find();

        $this->partidaPen = PartidaQuery::create()
                ->filterByConfirmada(0)
                ->filterByTipo('Nota Credito')
                 ->findOne();
    }

}
