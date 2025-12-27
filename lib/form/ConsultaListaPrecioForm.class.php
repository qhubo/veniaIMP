<?php

class consultaListaPrecioForm extends sfForm {

    public function configure() {

        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));
        $tipoId = sfContext::getInstance()->getUser()->getAttribute('tipo_id', null, 'seguridad');
        $marcaId = sfContext::getInstance()->getUser()->getAttribute('marca_id', null, 'seguridad');
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $bodegaQuery = BodegaQuery::create()
                ->filterByEmpresaId($empresaId)
                ->orderByNombre()
                ->find();
        $tipo[''] = 'Todas las bodegas';
        foreach ($bodegaQuery as $List) {
            $tipo[$List->getId()] = $List->getNombre();
        }
        $criteriaMarca = new Criteria();
        $criteriaMarca->add(MarcaPeer::TIPO_APARATO_ID, $tipoId);
        $criteria = new Criteria();
        $criteria->add(ModeloPeer::MARCA_ID, $marcaId);
        $this->setWidget('bodega', new sfWidgetFormChoice(array(
            "choices" => $tipo,
                ), array("class" => "form-control")));
        $this->setValidator('bodega', new sfValidatorString(array('required' => true)));


        $filtro[] = 'COMBO';
        $filtro[] = 'RECETA';
        $proveedorQuery = TipoAparatoQuery::create()
                ->filterByEmpresaId($empresaId)
                ->filterByDescripcion($filtro, Criteria::NOT_IN)
                ->orderByDescripcion("Desc")
                ->find();
        $lineaTipo[null] = '[Seleccione]';
        foreach ($proveedorQuery as $regis) {
            $lineaTipo[$regis->getId()] = $regis->getDescripcion();
        }
        $this->setWidget('tipo', new sfWidgetFormChoice(array(
            "choices" => $lineaTipo,
                ), array("class" => "form-control")));
        $this->setWidget('marca', new sfWidgetFormPropelChoice(
                array('model' => 'Marca',
            'criteria' => $criteriaMarca,
            'add_empty' => '[ Seleccione ' . TipoAparatoQuery::marca() . ' ]',
            'order_by' => array('Descripcion', 'asc'),
                ), array('class' => 'form-control',)));



        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));

        $this->setValidator('marca', new sfValidatorString(array('required' => false)));

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
