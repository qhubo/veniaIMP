<?php

class consultaProductoActualiForm extends sfForm {

    public function configure() {

        $listab = TiendaQuery::TiendaActivas();
        $tiendaQuery = TiendaQuery::create()
                ->orderByNombre("Desc")
                ->filterByCodigo('01')
               // ->filterById($listab, Criteria::IN)
                //  ->filterByActivo(true)
                ->find();
        $lineaTienda = null;
        foreach ($tiendaQuery as $regis) {
            $lineaTienda[$regis->getId()] = $regis->getNombre();
        }
        $this->setWidget('tienda', new sfWidgetFormChoice(array("choices" => $lineaTienda,), array("class" => "form-control")));
        $this->setValidator('tienda', new sfValidatorString(array('required' => false)));



        $tipo[0] = 'No publicados';
        $tipo[1] = 'Publicado Web';
        $tipo[2] = 'Todos los Productos';
        $this->setWidget('estatus', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('estatus', new sfValidatorString(array('required' => false)));

        $this->setWidget('nombrebuscar', new sfWidgetFormInputText(array(), array('class' => 'form-control input-circle',
                    "placeholder" => "buscar..."
        )));
        $this->setValidator('nombrebuscar', new sfValidatorString(array('required' => false)));


        $filtro[] = 'COMBO';
        $filtro[] = 'RECETA';

        $filtro[] = 'COMBO';
        $filtro[] = 'RECETA';
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $proveedorQuery = TipoAparatoQuery::create()
               ->filterByEmpresaId($empresaId)
                ->filterByDescripcion($filtro, Criteria::NOT_IN)
                ->orderByDescripcion("Desc")
                ->find();
        $lineaProve[null] = '[Seleccione]';
        foreach ($proveedorQuery as $regis) {
                  $lineaProve[$regis->getId()] = $regis->getDescripcion();
        }
        $this->setWidget('tipo', new sfWidgetFormChoice(array("choices" => $lineaProve,), array("class" => "form-control")));
        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));

        $marc = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'TipoId');
        $Marcaid = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'MarcaId');



        $proveedorQuery = MarcaQuery::create()
                ->filterByEmpresaId($empresaId)
                ->filterByTipoAparatoId($marc)
                ->orderByDescripcion("Desc")
                ->find();
        $lineaProve = null;
        $lineaProve[null] = '[Seleccione]';
        foreach ($proveedorQuery as $regis) {
            $lineaProve[$regis->getId()] = $regis->getDescripcion();
        }
        $this->setWidget('marca', new sfWidgetFormChoice(array("choices" => $lineaProve,), array("class" => "form-control")));
        $this->setValidator('marca', new sfValidatorString(array('required' => false)));

        $proveedorQuery = ModeloQuery::create()
                ->filterByMarcaId($Marcaid)
                ->filterByEmpresaId($empresaId)
                ->orderByDescripcion("Desc")
                ->find();
        $lineaProve = null;
        $lineaProve[null] = '[Seleccione]';
        foreach ($proveedorQuery as $regis) {
            $lineaProve[$regis->getId()] = $regis->getDescripcion();
        }
        $this->setWidget('modelo', new sfWidgetFormChoice(array("choices" => $lineaProve,), array("class" => "form-control")));
        $this->setValidator('modelo', new sfValidatorString(array('required' => false)));


        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
