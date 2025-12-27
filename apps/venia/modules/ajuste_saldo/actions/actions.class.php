<?php

/**
 * ajuste_saldo actions.
 *
 * @package    plan
 * @subpackage ajuste_saldo
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ajuste_saldoActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeNueva(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $default['fecha_movimiento'] = date('d/m/Y');
        $this->form = new IngresoAjusteForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $fecha_documento = $valores['fecha_movimiento'];
                $fecha_documento = explode('/', $fecha_documento);
                $fecha_documento = $fecha_documento[2] . '-' . $fecha_documento[1] . '-' . $fecha_documento[0];


                $movimiento = New MovimientoBanco();
                $movimiento->setTipo('Ajuste');
                $movimiento->setTipoMovimiento('Ajuste');
                $movimiento->setDocumento($valores['referencia']);
                $movimiento->setBancoOrigen($valores['banco_destino']);
                $movimiento->setBancoId($valores['banco_destino']);
                $movimiento->setFechaDocumento($fecha_documento);
                $movimiento->setValor($valores['monto']);
                $movimiento->setObservaciones($valores['observaciones']);
                $movimiento->setEstatus("Confirmado");
                $movimiento->setUsuario($usuarioQ->getUsuario());
//                           echo "<pre>";
//             print_r($movimiento);
//             die();
                $movimiento->save();
                
                  $cxc = New CuentaBanco();
                $cxc->setBancoId($movimiento->getBancoId());
                $cxc->setMovimientoBancoId($movimiento->getId());
                $cxc->setValor($movimiento->getValor() * -1);
                $cxc->setFecha($movimiento->getCreatedAt());
                $cxc->setDocumento($movimiento->getDocumento());
                $cxc->setUsuario($movimiento->getUsuario());
                $cxc->setCreatedAt($movimiento->getCreatedAt());
                $cxc->setObservaciones($movimiento->getTipo());
                $cxc->save();
                
                
                $this->getUser()->setFlash('exito', 'Ajuste ingresada con exito ');
                $this->redirect('ajuste_saldo/index?id=');
            }
        }
    }

    public function executeIndex(sfWebRequest $request) {

        date_default_timezone_set("America/Guatemala");
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
                $this->redirect('ajuste_saldo/index?id=');
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
        $this->operaciones = MovimientoBancoQuery::create()
                ->orderByFechaDocumento("Desc")
                ->filterByTipo('Ajuste')
                ->where("MovimientoBanco.FechaDocumento >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("MovimientoBanco.FechaDocumento <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->find();


        $this->bancos = BancoQuery::create()
                ->filterByActivo(true)
                ->find();
    }

}
