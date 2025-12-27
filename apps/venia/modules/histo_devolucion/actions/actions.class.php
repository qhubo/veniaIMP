<?php

/**
 * histo_devolucion actions.
 *
 * @package    plan
 * @subpackage histo_devolucion
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class histo_devolucionActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('consultaDEVO', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $fecha_actual = date("d-m-Y");
            $fecha = date("d/m/Y", strtotime($fecha_actual . "- 3 days"));
            $valores['fechaInicio'] = $fecha;
            $valores['fechaFin'] = date('d/m/Y');
            $valores['medio_pago'] = null;
            $valores['vendedor'] = null;
            sfContext::getInstance()->getUser()->setAttribute('consultaDEVO', serialize($valores), 'consulta');
        }
//        echo "<pre>";
//        print_r($valores);
//        die();
        $this->form = new ConsultaFechaSubmitForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('consultaDEVO', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('consultaDEVO', null, 'consulta'));
                $this->redirect('histo_devolucion/index?id=');
            }
        }

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->vendedor = $valores['vendedor'];
        $this->medio_pago= $valores['medio_pago'];
    }

}
