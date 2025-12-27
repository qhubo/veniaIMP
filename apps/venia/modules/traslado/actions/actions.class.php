<?php

class trasladoActions extends sfActions {

    public function executeNuevo(sfWebRequest $request) {
//        $this->registros = TrasladoProductoQuery::create()->filterByEstatus('Nuevo')->find();
        
    }
    
    
    public function executeIndex(sfWebRequest $request) {
        $this->registros = TrasladoProductoQuery::create()->filterByEstatus('Nuevo')->find();
        
    }

    public function executeTraslada(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $this->id = $id;
        $this->producto = ProductoQuery::create()->findOneById($id);
        $this->tiendas = TiendaQuery::create()->find();
        $default['producto_id'] = $id;
        $default['bodega_destino'] = $usuarioQ->getTiendaId();
        ;
        $default['cantidad'] = 1;

        $this->form = new CreaTrasladoForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $registro = new TrasladoProducto();
                $registro->setProductoId($id);
                $registro->setBodegaOrigen($valores['bodega_origen']);
                $registro->setBodegaDestino($valores['bodega_destino']);
                $registro->setCantidad($valores['cantidad']);
                $registro->setComentario($valores['comentario']);
                $registro->setEstatus('Nuevo');
                $registro->setFecha(date('Y-m-d H:i:s'));
                $registro->setUsuario($usuarioQ->getUsuario());
                $registro->save();
                $this->getUser()->setFlash('exito', 'Traslado Solicitado con exito  ');
                $this->redirect('traslado/index');
            }
        }
    }

}
