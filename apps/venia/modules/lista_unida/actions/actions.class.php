<?php

class lista_unidaActions extends sfActions {


    public function executeGuardarCotizaciones(sfWebRequest $request){
    $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
    $listaId = $request->getParameter('lista_empaque_unida_id');
    $existes = ListaEmpaqueUnidaDetalleQuery::create()
            ->filterByListaEmpaqueUnidaId($listaId)
            ->find();
      if ($existes) {
          $existes->delete();
      }
    $cotizaciones = $request->getParameter('cotizacion', array());
    foreach ($cotizaciones as $codigo) {
        $existe = ListaEmpaqueUnidaDetalleQuery::create()
            ->filterByListaEmpaqueUnidaId($listaId)
            ->filterByCodigo($codigo)
            ->findOne();
        if (!$existe) {
            $detalle = new ListaEmpaqueUnidaDetalle();
            $detalle->setEmpresaId($empresaId);
            $detalle->setListaEmpaqueUnidaId($listaId);
            $detalle->setCodigo($codigo);
            $detalle->save();
        }
    }

    $this->redirect( 'lista_unida/index?id='.$listaId);
}
    
    
    public function executeDetalle(sfWebRequest $request) {
        $this->detalles = OrdenCotizacionDetalleQuery::create()
                ->filterByConfirmado(true)
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->useOrdenCotizacionQuery()
                ->filterByEstatus('Confirmada')
                ->endUse()
                ->orderBy('BultoOrden')
                ->groupBy('OrdenCotizacionDetalle.CotizacionId')
                ->find();
    }

    public function executeElimina(sfWebRequest $request) {
        $modulo = 'lista_unida';
        $id = $request->getParameter('id');
        // die('a');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $REGISTRO = ListaEmpaqueUnidaQuery::create()->findOneById($id);
            $codigo = $REGISTRO->getTitulo();
            $REGISTRO->delete();

            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage());
            }
            $this->redirect($modulo . '/index');
        }
        $this->getUser()->setFlash('eliminar', $codigo);
        $this->redirect($modulo . '/index');
    }

    public function executeIndex(sfWebRequest $request) {
        $this->titulo = "Lista Empaque Unida";
        $this->registros = ListaEmpaqueUnidaQuery::create()->find();

    }

    public function executeMuestra(sfWebRequest $request) {
        $modulo = 'lista_unida';
        $this->titulo = 'BANCO';
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        sfContext::getInstance()->getUser()->setAttribute('usuario', null, 'nivel');
        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $default = null;
        $registro = ListaEmpaqueUnidaQuery::create()->findOneById($Id);
        if ($registro) {
            $default['titulo'] = $registro->getTitulo();
        }
        $this->registro = $registro;
        $this->form = new ListaEmpaqueUniForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $nuevo = new ListaEmpaqueUnida();
                if ($registro) {
                    $nuevo = $registro;
                }
                $nuevo->setUsuario($usuarioQ);
                $nuevo->setTitulo($valores['titulo']);
                $nuevo->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect($modulo . '/index?id=' . $nuevo->getId());
            }
        }
    }

}
