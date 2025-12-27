<?php

class CreaAnulaForm extends sfForm {

    public function configure() {


        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => true)));

       
        $this->setWidget('confirma', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('confirma', new sfValidatorString(array('required' => true)));
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
