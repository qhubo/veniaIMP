<?php

/**
 * reporte_partida actions.
 *
 * @package    plan
 * @subpackage reporte_partida
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporte_partidaActions extends sfActions {

    
        public function executeRevisa(sfWebRequest $request) {


        $acceso = MenuSeguridad::Acceso('reporte_partida');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }



        $this->id = $request->getParameter('id');
        $this->partidaPen = PartidaQuery::create()->findOneById($this->id);

        if ($request->isMethod('post')) {
            $this->redirect('reporte_partida/index');
        }
    }
    
    
    public function executeConfirma(sfWebRequest $request) {


        $acceso = MenuSeguridad::Acceso('reporte_partida');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }



        $this->id = $request->getParameter('id');
        $this->partidaPen = PartidaQuery::create()->findOneById($this->id);

        if ($request->isMethod('post')) {
            $this->redirect('reporte_partida/index');
        }
    }

    public function executeElimina(sfWebRequest $request) {
        $acceso = MenuSeguridad::Acceso('reporte_partida');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }

        $this->id = $request->getParameter('id');
        $partida = PartidaQuery::create()->findOneById($this->id);
        if ($partida) {
            $PARTIDAaPERTURA = '2022000001';
            $asientoAPERTURA = Parametro::CabeceraPartida($PARTIDAaPERTURA);
            $this->getUser()->setFlash('error', 'Partida ' . $partida->getCodigo() . " NO ACTIVA");
            Parametro::PartidaAgrupaDetalle($asientoAPERTURA, $PARTIDAaPERTURA, $partida->getMes(), $partida->getAno());
            $partida->setConfirmada(false);
            $partida->save();
        }
        $this->redirect('reporte_partida/index');
    }

    public function executeProcesa(sfWebRequest $request) {
        $this->id = $request->getParameter('id');
        $partida = PartidaQuery::create()->findOneById($this->id);
        if ($partida) {
            $PARTIDAaPERTURA = '2022000001';            // $asientoAPERTURA = Parametro::CabeceraPartida($PARTIDAaPERTURA);
            // Parametro::PartidaAgrupaDetalle($asientoAPERTURA, $PARTIDAaPERTURA, $partida->getMes(), $partida->getAno());
            $this->getUser()->setFlash('exito', 'Partida ' . $partida->getCodigo() . " activada con exito");
        }
        $this->redirect('reporte_partida/index');
    }

    public function executePartida(sfWebRequest $request) {
        $this->id = $request->getParameter('id');    }

    public function executeIndex(sfWebRequest $request) {
        $acceso = MenuSeguridad::Acceso('reporte_partida');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        date_default_timezone_set("America/Guatemala");
        if ($request->getParameter('med')) {
            sfContext::getInstance()->getUser()->setAttribute('med', $request->getParameter('med'), 'consulta');
        }
        if ($request->getParameter('med') == 99) {
            sfContext::getInstance()->getUser()->setAttribute('med', null, 'consulta');
        }
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoPart', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $bodegaId = null;
        if ($usuarioQue) {
            $bodegaId = $usuarioQue->getTiendaId();
        }
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('seleccionDatoPart', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('seleccionDatoPart', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoPart', null, 'consulta'));
                $this->redirect('reporte_partida/index');
            }
        }


        $this->operaciones = $this->datos($valores);

        $med = sfContext::getInstance()->getUser()->getAttribute('med', null, 'consulta');
        ;
        $partidaPe = new PartidaQuery();
        $partidaPe->filterByConfirmada(false);
        if ($med) {
            $partidaPe->filterByTiendaId($med);
        }
        $this->pendientes = $partidaPe->find();
        $listab = TiendaQuery::TiendaActivas();
        $this->tiendas = TiendaQuery::create()
                ->orderByNombre()
                ->filterById($listab, Criteria::IN)
                ->filterByActivo(true)
                ->find();

        //  die();
    }

    public function datos($valores) {
        // $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('selecciondato', null, 'consulta'));
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $operaciones = PartidaQuery::create();
        $operaciones->where("Partida.FechaContable >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Partida.FechaContable <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones = $operaciones->find();

        return $operaciones;
    }

}
