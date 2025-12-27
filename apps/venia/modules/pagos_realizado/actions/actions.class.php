<?php

/**
 * pagos_realizado actions.
 *
 * @package    plan
 * @subpackage pagos_realizado
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pagos_realizadoActions extends sfActions {

    public function executeVista(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $ventaRsumida = GastoPagoQuery::create()->findOneById($id);
        $this->vista = $ventaRsumida;
    }

    public function executeEliminar(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $gastoPago = GastoPagoQuery::create()->findOneById($id);
            $partidaId = $gastoPago->getPartidaNo();
            $NotaCredito = NotaCreditoQuery::create()->findOneById($gastoPago->getTipoPago());
            if ($NotaCredito) {
                $NotaCredito->setEstatus('Nuevo');
                $NotaCredito->save();
            }
            $movimientoBanco = MovimientoBancoQuery::create()
                    ->filterByBancoId($gastoPago->getBancoId())
                    ->filterByTipo('Gasto')
                    ->filterByDocumento($gastoPago->getDocumento())
                    ->filterByFechaDocumento($gastoPago->getFecha('Y-m-d'))
                    ->filterByUsuario($gastoPago->getUsuario())
                    ->findOne();

//            echo "<pre>";
//            print_r($movimientoBanco);
//            die();
            if ($movimientoBanco) {
                $movimientoBanco->delete();
            }
            $cuentaVivi = CuentaProveedorQuery::create()->findOneByGastoId($gastoPago->getGastoId());
            $valorPagado = $cuentaVivi->getValorPagado() - $gastoPago->getValorTotal();
            $cuentaVivi->setPagado(false);
            $cuentaVivi->setValorPagado($valorPagado);
            $cuentaVivi->save();
            $orden = GastoQuery::create()->findOneById($gastoPago->getGastoId());
            $valorPagado = $orden->getValorPagado() - $gastoPago->getValorTotal();
            $orden->setValorPagado($valorPagado);
            $orden->save();
            $codigo = $gastoPago->getCodigo();
            $gastoPago->delete();
            $con->commit();
            $this->getUser()->setFlash('error', 'Gasto eliminado con exito ' . $codigo);
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('consulta_gasto_proveedor/index');
        }

        $partidaQ = PartidaDetalleQuery::create()
                ->filterByPartidaId($partidaId)
                ->find();
        if ($partidaQ) {
            $partidaQ->delete();
        }
        $partidaM = PartidaQuery::create()->findOneById($partidaId);
        if ($partidaM) {
            $partidaM->delete();
        }
        $this->redirect('pagos_realizado/index');
    }

    public function executeIndex(sfWebRequest $request) {
        $acceso = MenuSeguridad::Acceso('pagos_realizado');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
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
                $this->redirect('pagos_realizado/index?id=1');
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
        $this->registros = GastoPagoQuery::create()
                ->where("GastoPago.Fecha >= '" . $fechaInicio . "'")
                ->where("GastoPago.Fecha <= '" . $fechaFin . " 23:00" . "'")
                ->find();
    }

}
