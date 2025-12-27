<?php

/**
 * cuenta_banco actions.
 *
 * @package    plan
 * @subpackage cuenta_banco
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cuenta_bancoActions extends sfActions
{
    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
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
              $this->redirect('cuenta_banco/index');
                
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
        $operaciones = new CuentaBancoQuery();
        $operaciones->where("CuentaBanco.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("CuentaBanco.Fecha <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->filterByBancoId($banco);
        $operaciones = $operaciones->find();

        return $operaciones;
    }

}
