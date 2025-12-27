<?php

/**
 * cuenta_proveedor actions.
 *
 * @package    plan
 * @subpackage cuenta_proveedor
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cuenta_proveedorActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        
                 $acceso = MenuSeguridad::Acceso('cuenta_proveedor');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionctaProve', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
         if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['proveedor'] = null;
            sfContext::getInstance()->getUser()->setAttribute('seleccionctaProve', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaProveedorForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('seleccionctaProve', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionctaProve', null, 'consulta'));
            $this->redirect('cuenta_proveedor/index');
                }
        }
        $provedorQur = ProveedorQuery::create()->findOneById($valores['proveedor']);
        $this->saldo=0;
        if ($provedorQur) {
            $this->saldo=$provedorQur->getSaldo();
        }
          
        $this->proveedor = $provedorQur;
                  
        $this->operaciones = $this->datos($valores);
    }
    
    
        public function datos($valores) {
        // $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionctaProve', null, 'consulta'));
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $proveedor = $valores['proveedor'];
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $operaciones = new CuentaProveedorQuery();
        $operaciones->filterByProveedorId($proveedor);
        $operaciones->where("CuentaProveedor.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("CuentaProveedor.Fecha <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones = $operaciones->find();

        return $operaciones;
    }

}
