<?php

/**
 * cuenta_default actions.
 *
 * @package    plan
 * @subpackage cuenta_default
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cuenta_defaultActions extends sfActions {

  
      public function executeEditar(sfWebRequest $request) {
          $id = $request->getParameter('id');
          $this->registro = DefinicionCuentaQuery::create()->findOneById($id);
          $this->listaCuentas = CuentaErpContableQuery::create()->find();
          $id = $request->getParameter('id');    
          $cuenta =$request->getParameter('cuenta');
          if ($cuenta <> '') {
              $registro = DefinicionCuentaQuery::create()->findOneById($id);
              $registro->setCuentaContable($cuenta);
              $registro->save();
                     $this->getUser()->setFlash('exito', 'Registro actualizada con exito ');
                $this->redirect('cuenta_default/editar?id=' . $id);
          }
                
      }
    public function executeIndex(sfWebRequest $request) {
           $modulo = 'cuenta_default';
                     $acceso = MenuSeguridad::Acceso('cuenta_default');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
       $this->cuentas = DefinicionCuentaQuery::create()
                ->filterByGrupo('', Criteria::NOT_EQUAL)
                ->find();
        $this->listaCuentas = CuentaErpContableQuery::create()->find();
    }
    
    public function executeActuaCuenta(sfWebRequest $request) {
          $id = $request->getParameter('id');
          $valor = $request->getParameter('valor');
        $DefinicionCuenta = DefinicionCuentaQuery::create()->findOneById($id);
        if ($DefinicionCuenta){
            $DefinicionCuenta->setCuentaContable($valor);
            $DefinicionCuenta->save();
            echo "<font color ='#FFCC00'> Valor Actualizado </font> ";
        }
     die();     
    }
    

}
