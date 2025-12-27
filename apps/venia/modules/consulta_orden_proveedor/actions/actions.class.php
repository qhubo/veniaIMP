<?php

/**
 * consulta_orden_proveedor actions.
 *
 * @package    plan
 * @subpackage consulta_orden_proveedor
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class consulta_orden_proveedorActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

                 $acceso = MenuSeguridad::Acceso('consulta_orden_proveedor');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('dataProve', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['usuario'] = trim($usuarioQue->getUsuario());
            sfContext::getInstance()->getUser()->setAttribute('dataProve', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('dataProve', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('dataProve', null, 'consulta'));
                $this->redirect('consulta_orden_proveedor/index?id=');
            }
        }
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '01:00';
        $valores['fin'] = '23:00';

     
            $registros = new OrdenProveedorQuery();
            if ($valores['usuario']) {

                $registros->filterByUsuario($valores['usuario']);
            }
            $registros->where("OrdenProveedor.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'");
            $registros->where("OrdenProveedor.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'");
            $this->registros = $registros->find();

// $this->registros = OrdenProveedorQuery::create()
//         ->find();
//      
       
    }
    
}
    