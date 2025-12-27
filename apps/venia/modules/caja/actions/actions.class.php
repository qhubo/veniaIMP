<?php

/**
 * caja actions.
 *
 * @package    plan
 * @subpackage caja
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cajaActions extends sfActions {

    public function executeGrabaNit(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $vivi = $request->getParameter('vivi');
        $viviendaQ = ViviendaQuery::create()->findOneById($vivi);

        if ($viviendaQ) {
            $viviendaQ->setNitFatura($id);
            $viviendaQ->save();
        }
        echo $id;
        die();
    }

    public function executeGrabaNombre(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $vivi = $request->getParameter('vivi');
        $viviendaQ = ViviendaQuery::create()->findOneById($vivi);

        if ($viviendaQ) {
            $viviendaQ->setNombreFactura($id);
            $viviendaQ->save();
        }
        echo $id;
        die();
    }

    public function executeNitfactura(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $vivi = $request->getParameter('vivi');
        $propietario = PropietarioQuery::create()->findOneById($id);
        $return = 'CF';
        $viviendaQ = ViviendaQuery::create()->findOneById($vivi);
        if ($propietario) {

            if ($viviendaQ) {
                $viviendaQ->setNombreFactura($propietario->getNombreFactura());
                $viviendaQ->setNitFatura($propietario->getNitFactura());
                $viviendaQ->setTemporal($id);
                $viviendaQ->save();
                $return = $propietario->getNitFactura();
            }
        }
        if ($viviendaQ) {
            $viviendaQ->setNitFatura($return);
            $viviendaQ->save();
        }
        echo $return;
        die();
    }

    public function executeNombrefactura(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $vivi = $request->getParameter('vivi');
        $propietario = PropietarioQuery::create()->findOneById($id);
        $return = 'Consumidor Final';
        $viviendaQ = ViviendaQuery::create()->findOneById($vivi);
        if ($propietario) {

            if ($viviendaQ) {
                $viviendaQ->setNombreFactura($propietario->getNombreFactura());
                $viviendaQ->setNitFatura($propietario->getNitFactura());
                $viviendaQ->setTemporal($id);
                $viviendaQ->save();
                $return = $propietario->getNombreFactura();
            }
        }

        if ($viviendaQ) {
            $viviendaQ->setNombreFactura($return);
            $viviendaQ->save();
        }
        echo $return;
        die();
    }

    public function executeElimina(sfWebRequest $request) {
        $Id = $request->getParameter('id');
        $cuentavivien = CuentaViviendaQuery::create()->findOneById($Id);
        if ($cuentavivien) {
            $cuentavivien->delete();
        }
        $this->getUser()->setFlash('error', 'Elimina servicio con exito ');
        $this->redirect('caja/index');
    }

    public function executeAgregaSer(sfWebRequest $request) {
              date_default_timezone_set("America/Guatemala");
        $servicioId = $request->getParameter('id');
        $viviendaId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'vivienda');
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $servivioQ = ServicioQuery::create()->findOneById($servicioId);
        $cuentaVIVI = new CuentaVivienda();
        $cuentaVIVI->setEmpresaId($empresaId);
        $cuentaVIVI->setViviendaId($viviendaId);
        $cuentaVIVI->setServicioId($servicioId);
        $cuentaVIVI->setDetalle($servivioQ->getNombre());
        $cuentaVIVI->setFecha(date('Y-m-d H:i:s'));
        $mes = date('m');
        $ano = date('Y');
        $cuentaVIVI->setNumero("Agregado");
        $cuentaVIVI->setMes($mes);
        $cuentaVIVI->setAnio($ano);
        $cuentaVIVI->setValor($servivioQ->getValorFijo());
        $cuentaVIVI->setTemporal(true);
        $cuentaVIVI->save();
        $this->getUser()->setFlash('exito', 'Servicio agregado con exito ');
        $this->redirect('caja/index');
    }

    public function executeAgrega(sfWebRequest $request) {
        $this->servicios = ServicioQuery::create()->find();
    }

    public function executeMuestra(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $this->Operacion = OperacionQuery::create()->findOneById($id);
        $this->Pago = OperacionPagoQuery::create()->filterByOperacionId($id)->findOne();
        $this->Detalle = OperacionDetalleQuery::create()->filterByOperacionId($id)->find();
        if (!$this->Operacion) {
            $this->redirect('caja/index');
        }
    }

    public function executeVivi(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $cuenta = CuentaViviendaQuery::create()
                ->filterByViviendaId($id)
                ->filterByPagado(false)
                ->filterByTemporal(true)
                ->find();
        foreach ($cuenta as $reg) {
            $reg->setTemporal(false);
            $reg->save();
        }
        sfContext::getInstance()->getUser()->setAttribute('usuario', $id, 'vivienda');
        $this->getUser()->setFlash('exito', 'Vivienda Seleccionada ');
        $this->redirect('caja/index?id=' . $id);
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $this->cuenta = null;
        $viviendaId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'vivienda');
        //************SETEAR TEMPORAL VIVI
        $this->vivienda = $viviendaId;
        $this->nombre = '';
        $this->nit = '';
        $this->propi = null;
        $viviendaQ = ViviendaQuery::create()->findOneById($viviendaId);
        $this->viviendaQ = $viviendaQ;
        if ($viviendaQ) {
            $this->nombre = $viviendaQ->getNombreFactura();
            $this->nit = $viviendaQ->getNitFatura();
        }
        $em = 1;
        if ($request->getParameter('em')) {
            sfContext::getInstance()->getUser()->setAttribute('caja', $request->getParameter('em'), 'seleccion');
            $cuenta = CuentaViviendaQuery::create()
                    ->filterByViviendaId($viviendaId)
                    ->filterByPagado(false)
                    ->filterByTemporal(true)
                    ->find();
            foreach ($cuenta as $reg) {
                $reg->setTemporal(false);
                $reg->save();
            }
        }
        $em = sfContext::getInstance()->getUser()->getAttribute('caja', null, 'seleccion');
        $this->em = $em;


        if ($em == 1) {
            $this->cuenta = CuentaViviendaQuery::create()
                    ->filterByMes(date('m'))
                    ->filterByAnio(date('Y'))
                    ->filterByPagado(false)
                    ->filterByViviendaId($viviendaId)
                    ->orderBy("CuentaVivienda.Fecha", "Asc")
                    ->find();
        }
        if ($em == 2) {
            $this->cuenta = CuentaViviendaQuery::create()
                    ->filterByPagado(false)
                    ->filterByViviendaId($viviendaId)
                    ->orderBy("CuentaVivienda.Fecha", "Asc")
                    ->where("CuentaVivienda.Fecha <= '" . date('Y-m-d') . "'")
                    ->find();
        }
        if ($em == 3) {
            $this->cuenta = CuentaViviendaQuery::create()
                    ->filterByPagado(false)
                    ->filterByViviendaId($viviendaId)
                    ->orderBy("CuentaVivienda.Fecha", "Asc")
                    ->find();
        }
        $gradTOTAL = CuentaViviendaQuery::Pago($viviendaId);
        $this->grandTotal = $gradTOTAL;
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $this->listaPago = null;
        $value['fecha'] = date('d/m/Y');
        $value['viviendaId'] = $viviendaId;
        $this->form = new SeleMedioPagoForm($value);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $fechaInicio = $valores['fecha'];
                $fechaInicio = explode('/', $fechaInicio);
                $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
                $TEMPOQ = PropietarioQuery::create()->findOneById($viviendaQ->getTemporal());
                $operacion = new Operacion();
                $operacion->setEmpresaId($empresaId);
                $operacion->setFecha(date('Y-m-d H:i:s'));
                $operacion->setViviendaId($viviendaId);
                $operacion->setUsuario($usuarioQ->getUsuario());
                $operacion->setNit('CF');
                $operacion->setCorreo($viviendaQ->getCorreo());
               
                if ($TEMPOQ) {
                $operacion->setNit($TEMPOQ->getNitFactura());
                $operacion->setNombre($TEMPOQ->getNombreFactura());
                
                }

                if ($viviendaQ->getNitFatura()) {
                    $operacion->setNit($viviendaQ->getNitFatura());
                }
                if ($viviendaQ->getNombreFactura()) {
                    $operacion->setNombre($viviendaQ->getNombreFactura());
                }

                if ($TEMPOQ) {
                $operacion->setCorreo($TEMPOQ->getCorreoFactura());
                }
                $operacion->setValorTotal(0);
                $operacion->save();
                //*** PROCESO PAGO                
                $ListaDo = CuentaViviendaQuery::create()
                        ->filterByTemporal(true)
                        ->filterByPagado(false)
                        ->filterByViviendaId($viviendaId)
                        ->find();

                $valorTotal = 0;
                foreach ($ListaDo as $cuenta) {
                    $cuenta = CuentaViviendaQuery::create()->findOneById($cuenta->getId());
                    $valor = $cuenta->getValor() + $cuenta->getValorMora();
                    $detalle = new OperacionDetalle();
                    $detalle->setCuentaViviendaId($cuenta->getId());
                    $detalle->setOperacionId($operacion->getId());
                    $detalle->setDetalle($cuenta->getDetalle());
                    $detalle->setCantidad(1);
                    $detalle->setValorTotal($valor);
                    $detalle->setValorUnitario($valor);
                    $detalle->setServicioId($cuenta->getServicioId());
                    $detalle->setMes(date('m'));
                    $detalle->setAnio(date('Y'));
                    $detalle->save();
                    $valorTotal = $valor + $valorTotal;
                    $cuenta->setPagado(true);
                    $cuenta->setValorPagado($valor);
                    $cuenta->setUsuarioPago($usuarioQ->getUsuario());
                    $cuenta->setFechaPago(date('Y-m-d H:i:s'));
                    $cuenta->setCodigoPago($operacion->getCodigo());
                    $cuenta->save();
                }
                $operacion->setValorTotal($valorTotal);
                $operacion->save();
                $operacionPago = new OperacionPago();
                $operacionPago->setOperacionId($operacion->getId());
                $operacionPago->setFechaDocumento($fechaInicio);
                $operacionPago->setDocumento($valores['no_documento']);
                $operacionPago->setTipo($valores['tipo_pago']);
                $operacionPago->setValor($valorTotal);
                if ($valores['banco_id']) {
                    $operacionPago->setBancoId($valores['banco_id']);
                }
                $operacionPago->save();
                sfContext::getInstance()->getUser()->setAttribute('usuario', null, 'vivienda');
                $this->getUser()->setFlash('exito', 'Pago realizado con exito ');
                $this->redirect('cuenta_vivienda/muestra?id=' . $operacion->getCodigo());
                
                $this->redirect('caja/muestra?id=' . $operacion->getId());
            }
        }
        $this->Propietarios = PropietarioViviendaQuery::create()
                ->filterByViviendaId(null, Criteria::NOT_EQUAL)
                ->filterByViviendaId($viviendaId)
                ->find();
        if ($viviendaQ) {
            $propi = $viviendaQ->getTemporal();
            $this->propi = $propi;
        }
        if (count($this->Propietarios) == 1) {
            $Propiq = PropietarioViviendaQuery::create()->findOneByViviendaId($viviendaId);
            if ($Propiq) {
                $propi = $Propiq->getPropietarioId();
                $this->propi = $propi;
                if ($viviendaQ) {
                    $viviendaQ->setTemporal($propi);
                    $viviendaQ->save();
                }
            }
        }

        $DetalleFactura = "CF";
        $PropietarioQ = PropietarioQuery::create()->findOneById($this->propi);
        if ($PropietarioQ) {
            $DetalleFactura = "<strong> Nombre </strong>" . $PropietarioQ->getNombreFactura() . " <strong>Nit </strong> " . $PropietarioQ->getNitFactura();
        }
        $this->detalleFactura = $DetalleFactura;
    }

    public function executeFactura(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $vivi = $request->getParameter('vivi');
        $propietario = PropietarioQuery::create()->findOneById($id);
        $return = 'CF';
        if ($propietario) {
            $viviendaQ = ViviendaQuery::create()->findOneById($vivi);
            if ($viviendaQ) {
                $viviendaQ->setTemporal($id);
                $viviendaQ->save();
            }
            $return = "<strong> Nombre </strong>" . $propietario->getNombreFactura() . " <strong>Nit </strong> " . $propietario->getNitFactura();
        }
        echo $return;
        die();
    }

    public function executeCheck(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $vivi = $request->getParameter('vivi');
        $cuentaVivienda = CuentaViviendaQuery::create()->findOneById($id);
        $viviendaId = 0;
        if ($cuentaVivienda) {
            $cuentaVivienda->setTemporal(true);
            $cuentaVivienda->save();
            $viviendaId = $cuentaVivienda->getViviendaId();
        }
        $gradTOTAL = CuentaViviendaQuery::Pago($viviendaId);
        $gradTOTAL = number_format($gradTOTAL, 2);
        $gradTOTAL = "<h3>" . $gradTOTAL . "</h3>";
        ECHO $gradTOTAL;
        die();
    }

    public function executeUncheck(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $cuentaVivienda = CuentaViviendaQuery::create()->findOneById($id);
        if ($cuentaVivienda) {
            $cuentaVivienda->setTemporal(false);
            $cuentaVivienda->save();
            $viviendaId = $cuentaVivienda->getViviendaId();
        }
        $gradTOTAL = CuentaViviendaQuery::Pago($viviendaId);
        $gradTOTAL = number_format($gradTOTAL, 2);
        $gradTOTAL = "<h3>" . $gradTOTAL . "</h3>";
        ECHO $gradTOTAL;

        die();
    }

}
