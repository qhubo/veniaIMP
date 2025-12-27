<?php

class ConsultaCampoForm extends sfForm {

    public function configure() {


        $this->setWidget('texto', new sfWidgetFormInputText(array(), array('class' => 'form-control')));
        $this->setValidator('texto', new sfValidatorString(array('required' => true)));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
