<?php

class grabaEgresoForm extends sfForm {

    public function configure() {
         $this->setWidget('observaciones', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Observaciones',)));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => true)));
       
     
        $this->setWidget('valor', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => 0,
                    'onkeypress' => 'validate(event)',
                    'xtype' => 'number', 'step' => 'any')));
        $this->setValidator('valor', new sfValidatorString(array('required' => true)));
      
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
