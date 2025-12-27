<?php

/**
 * movimiento_conciliado actions.
 *
 * @package    plan
 * @subpackage movimiento_conciliado
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class movimiento_conciliadoActions extends sfActions
{
    
     public function executeRevertir(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $cliente = MovimientoBancoQuery::create()->findOneById($id);
        $tokenPro = '';
        if ($cliente) {
            $tokenPro = sha1($cliente->getId());
        }
        if ($tokenPro <> $token) {
            $this->getUser()->setFlash('error', 'Token  incorrecto !Intentar Nuevamente');
            $this->redirect('movimiento_conciliado/index');
        }

   $existe = CuentaBancoQuery::create()->findOneByMovimientoBancoId($cliente->getId());
   if ($existe) {
       $existe->delete();
   }
        $cliente->setConfirmadoBanco(false);
        $cliente->setFechaConfirmoBanco(null);
        $cliente->setUsuarioConfirmoBanco('');
        $cliente->save();
        
          $this->getUser()->setFlash('exito', 'Movimiento revertido con exito');
         $this->redirect('movimiento_conciliado/index');
    }

    
    
    
public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
                               $acceso = MenuSeguridad::Acceso('movimiento_conciliado');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
        
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionctaBanco', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
         if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['banco'] = null;
            sfContext::getInstance()->getUser()->setAttribute('seleccionctaBanco', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaEstadoCuentaBancoForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('seleccionctaBanco', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionctaBanco', null, 'consulta'));
              $this->redirect('movimiento_conciliado/index');
                
            }
        }
        
          $bancoQur = BancoQuery::create()->findOneById($valores['banco']);
        $this->saldo=0;
        if ($bancoQur) {
            $this->saldo=$bancoQur->getSaldo();
        }
          
        $this->banco = $bancoQur;
                  
        
        $this->operaciones = $this->datos($valores);
    }
    
    public function datos($valores) {
        // $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionctaBanco', null, 'consulta'));
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $banco = $valores['banco'];
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $operaciones = new MovimientoBancoQuery();
        $operaciones->where("MovimientoBanco.FechaConfirmoBanco >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("MovimientoBanco.FechaConfirmoBanco <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->filterByBancoId($banco);
        $operaciones->filterByConfirmadoBanco(true);
        $operaciones = $operaciones->find();

        return $operaciones;
    }
}
