<?php

class ConsultaNumeroForm extends sfForm {

    public function configure() {
       
        $this->setWidget('numero', new sfWidgetFormInputText(array(), 
                array('class' => 'form-control', 'Placeholder' => 'No Factura')));
     
        $this->setValidator('numero', new sfValidatorString(array('required' => false)));
        
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}