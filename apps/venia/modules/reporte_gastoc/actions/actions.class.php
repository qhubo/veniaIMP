<?php

/**
 * reporte_gastoc actions.
 *
 * @package    plan
 * @subpackage reporte_gastoc
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporte_gastocActions extends sfActions
{
    public function executeVista(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $token = $request->getParameter('id');
        $ordenQ = GastoCajaQuery::create()->findOneById($token);
     

        $this->orden = $ordenQ;
        $this->lista = GastoCajaDetalleQuery::create()
                ->filterByGastoCajaId($ordenQ->getId())
                ->find();

        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        //    $this->cuenta = CuentaProveedorQuery::create()->findOneById($this->id);
        $value['fecha'] = date('d/m/Y');
    }

  public function executeIndex(sfWebRequest $request)
  {
      
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaGasto', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
         

            sfContext::getInstance()->getUser()->setAttribute('datoconsultaGasto', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsultaGasto', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaGasto', null, 'consulta'));
              $this->redirect('reporte_gastoc/index?id=1');
                
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
       
        $this->registrosCaja = GastoCajaQuery::create()
                ->filterByEstatus('Confirmado')
                ->where("GastoCaja.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("GastoCaja.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->find();       

  }
}
