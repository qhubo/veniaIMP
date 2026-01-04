<?php

/**
 * bodega_confirmo actions.
 *
 * @package    plan
 * @subpackage bodega_confirmo
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bodega_confirmoActions extends sfActions {

    public function executeMuestra(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('selecende', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $TIPO_USUARIO = strtoupper($usuarioQue->getTipoUsuario());
        $bodegaId = null;
        if ($usuarioQue) {
            $bodegaId = $usuarioQue->getTiendaId();
        }
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['usuario'] = null;
            $valores['usuario'] = $usuarioQue->getUsuario();
            $valores['bodega'] = $bodegaId;
            sfContext::getInstance()->getUser()->setAttribute('selecende', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('selecende', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('selecende', null, 'consulta'));
                $this->redirect('bodega_confirmo/muestra');
            }
        }
        $this->operaciones = $this->datos($valores);
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $TIPO_USUARIO = strtoupper($usuarioQ->getTipoUsuario());
              
       if ($TIPO_USUARIO=='ADMINISTRADOR') {
        $this->detalles = OrdenCotizacionDetalleQuery::create()
                ->useOrdenCotizacionQuery()
                ->filterByEstatus('Confirmada')
                ->endUse()
                ->groupByOrdenCotizacionId()
                ->withColumn('sum(OrdenCotizacionDetalle.Cantidad)', 'CantidadTotal')
                ->find();
           
       } else {
        $this->detalles = OrdenCotizacionDetalleQuery::create()
                ->useOrdenCotizacionQuery()
                ->filterByEstatus('Confirmada')
                ->filterByUsuario($usuarioQ->getUsuario())
                ->endUse()
                ->groupByOrdenCotizacionId()
                ->withColumn('sum(OrdenCotizacionDetalle.Cantidad)', 'CantidadTotal')
                ->find();
       }
    }

  
    public function datos($valores) {
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $bodega = $valores['bodega'];
        $usuario = $valores['usuario'];
     
        $operaciones = OperacionQuery::create();
        $listab = TiendaQuery::TiendaActivas(); // ctivas();
        $operaciones->where("Operacion.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Operacion.Fecha <= '" . $fechaFin . " 23:59:00" . "'");
        if ($usuario) {
            $operaciones->filterByUsuario($usuario);
        }
        if ($bodega) {
            $operaciones->filterByTiendaId($bodega);
        } else {
            $operaciones->filterByTiendaId($listab, Criteria::IN);
        }
//        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones = $operaciones->find();
        return $operaciones;
    }

}
