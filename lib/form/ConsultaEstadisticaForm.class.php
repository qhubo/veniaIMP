<?php

class consultaEstadisticaForm extends sfForm {

    public function configure() {
        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));
        

        $this->setWidget('nombrebuscar', new sfWidgetFormInputText(array(), array('class' => 'form-control input-circle',
"placeholder"=>"buscar..."
        )));
        $this->setValidator('nombrebuscar', new sfValidatorString(array('required' => false)));


        $this->setWidget('tipo', new sfWidgetFormPropelChoice(
                array('model' => 'TipoAparato',
            'add_empty' => '[ Seleccione ' . TipoAparatoQuery::tipo() . ' ]',
            'order_by' => array('Descripcion', 'asc'),
                ), array('class' => 'form-control',
        )));
        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));
        $this->setWidget('marca', new sfWidgetFormPropelChoice(
                array('model' => 'Marca',
            'add_empty' => '[ Seleccione ' . TipoAparatoQuery::marca() . ' ]',
            'order_by' => array('Descripcion', 'asc'),
                ), array('class' => 'form-control',
        )));
        $this->setValidator('marca', new sfValidatorString(array('required' => false)));
        $this->setWidget('modelo', new sfWidgetFormPropelChoice(
                array('model' => 'Modelo',
            'add_empty' => '[ Seleccione ' . TipoAparatoQuery::modelo() . ' ]',
            'order_by' => array('Descripcion', 'asc'),
                ), array('class' => 'form-control',
        )));
        $this->setValidator('modelo', new sfValidatorString(array('required' => false)));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
