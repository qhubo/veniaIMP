<?php

/**
 * cuenta_cliente actions.
 *
 * @package    plan
 * @subpackage cuenta_cliente
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cuenta_clienteActions extends sfActions
{
 public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionctaCliente', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
         if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['cliente'] = null;
            sfContext::getInstance()->getUser()->setAttribute('seleccionctaCliente', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaClienteForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('seleccionctaCliente', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionctaCliente', null, 'consulta'));
            }
        }
        $this->operaciones = $this->datos($valores);
    }
    
    
        public function datos($valores) {
        // $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionctaCliente', null, 'consulta'));
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $banco = $valores['cliente'];
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $operaciones = new OperacionQuery();
        $operaciones->where("Operacion.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Operacion.Fecha <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones = $operaciones->find();

        return $operaciones;
    }
}
