<?php

/**
 * reporte__corte actions.
 *
 * @package    plan
 * @subpackage reporte__corte
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporte_corteActions extends sfActions
{
    
        public function executeDetalle(sfWebRequest $request) {
        $OperacionId = $request->getParameter('id'); //=155555&$dirh =
         $this->operacion = CierreCajaQuery::create()->findOneById($OperacionId);
      
        $this->operaciones = OperacionQuery::create()->filterByCierreCajaId($OperacionId)->find();
        }
    public function executeMuestra(sfWebRequest $request) {
        $OperacionId = $request->getParameter('id'); //=155555&$dirh =
        $this->operacion = CierreCajaQuery::create()->findOneById($OperacionId);
        $this->detalle = CierreCheckQuery::create()->filterByCierreCajaId($OperacionId)->find();
        $this->pagos = CierreCajaValorQuery::create()->filterByCierreCajaId($OperacionId)->find();
    }
   public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsulta', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $bodegaId = null;
        if ($usuarioQue) {
            $bodegaId = $usuarioQue->getBodegaId();
        }
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['usuario'] = null;
            $tipoUsuario = sfContext::getInstance()->getUser()->getAttribute('tipoUsuario', null, 'seguridad');
            if ($tipoUsuario <> 'ADMINISTRADOR') {
                $valores['usuario'] = $usuarioId;
            }
            $valores['estado'] = 'Pagado';
            $valores['tipo_fecha'] = 'Pago';
            $valores['bodega'] = $bodegaId;
            sfContext::getInstance()->getUser()->setAttribute('datoconsulta', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaUsuarioEstadoForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsulta', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsulta', null, 'consulta'));
            }
        }


        $this->operaciones = $this->datos($valores);
    }
public function datos($valores) {
        // $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsulta', null, 'consulta'));
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $usuariof = $valores['usuario'];
        $tipo_fecha = $valores['tipo_fecha'];
        $bodega = $valores['bodega'];
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $operaciones = CierreCajaQuery::create();
        $listab = BodegaQuery::BodegaActivas();
        $operaciones->where("CierreCaja.FechaCalendario >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("CierreCaja.FechaCalendario <= '" . $fechaFin . " 23:59:00" . "'");
        if ($usuariof) {
            $operaciones->filterByUsuario($usuarioQue->getUsuario());
        }
        if ($bodega) {
            $operaciones->filterByBodegaId($bodega);
        } else {
            $operaciones->filterByBodegaId($listab, Criteria::IN);
        }

        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones = $operaciones->find();

        return $operaciones;
    }

}
