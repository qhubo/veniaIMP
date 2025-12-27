<?php

class ConsultaListaClienteForm extends sfForm {

    public function configure() {


        $this->setWidget('nombrebuscar', new sfWidgetFormInputText(array(), array('class' => 'form-control input-circle',
            "placeholder" => "buscar..."
        )));
        $this->setValidator('nombrebuscar', new sfValidatorString(array('required' => false)));


        $this->setWidget('departamento', new sfWidgetFormPropelChoice(
                array('model' => 'Departamento',
            'add_empty' => '[ Seleccione Departamento  ]',
            'order_by' => array('Nombre', 'asc'),
                ), array('class' => 'form-control',
        )));
        $this->setValidator('departamento', new sfValidatorString(array('required' => false)));

       $this->setWidget('cartera', new sfWidgetFormPropelChoice(
                array('model' => 'cartera',
            'add_empty' => '[ Cartera ]',
            'order_by' => array('Nombre', 'asc'),
                ), array('class' => 'form-control',
        )));
        $this->setValidator('cartera', new sfValidatorString(array('required' => false)));
        

        $this->setWidget('municipio', new sfWidgetFormPropelChoice(
                array('model' => 'Municipio',
            'add_empty' => '[ Seleccione Municipio ]',
            'order_by' => array('Descripcion', 'asc'),
                ), array('class' => 'form-control',
        )));
        $this->setValidator('municipio', new sfValidatorString(array('required' => false)));

        $opcionesP[null] = 'No filtrar Fecha';
        $opcionesP['Ingreso'] = 'Fecha Ingreso';
        $opcionesP['Compra'] = 'Fecha Ult. Compra';
        $this->setWidget('tipo_fecha', new sfWidgetFormChoice(array(
            "choices" => $opcionesP,
                ), array("class" => " form-control")));

        $this->setValidator('tipo_fecha', new sfValidatorString(array('required' => false)));


        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));


        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
