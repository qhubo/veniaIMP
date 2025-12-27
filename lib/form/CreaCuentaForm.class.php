<?php

class CreaCuentaForm extends sfForm {

    public function configure() {


        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "Nombre",)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));
        $this->setWidget('cuenta', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,)));
        $this->setValidator('cuenta', new sfValidatorString(array('required' => true)));
        $this->setWidget('tipo', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,)));
        $this->setValidator('tipo', new sfValidatorString(array('required' => true)));
        $this->setWidget('grupo', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,)));
        $this->setValidator('grupo', new sfValidatorString(array('required' => false)));


        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
