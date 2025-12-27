<?php

/**
 * reporte_cotizacion actions.
 *
 * @package    plan
 * @subpackage reporte_cotizacion
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporte_cotizacionActions extends sfActions
{
   public function executeIndex(sfWebRequest $request)
  {
      
      date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsulta', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
         

            sfContext::getInstance()->getUser()->setAttribute('datoconsulta', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsulta', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsulta', null, 'consulta'));
                 $this->redirect('reporte_cotizacion/index?id=');
                
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
        $this->registros = OrdenCotizacionQuery::create()
                ->where("OrdenCotizacion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("OrdenCotizacion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->find();
        
        
// $this->registros = OrdenProveedorQuery::create()
//         ->find();
//      
  }
}
