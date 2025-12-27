<?php

class CreaNotaFacturaForm extends sfForm {

    public function configure() {


        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => true)));

             $this->setWidget('valor', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                   'placeholder' => '00.00',  'type'=>'number', 'step'=>'any')));

        $this->setValidator('valor', new sfValidatorString(array('required' => true)));

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
