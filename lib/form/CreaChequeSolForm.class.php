<?php

class CreaChequeSolForm extends sfForm {

    public function configure() {

$tipol['Pago Planlla']='Pago Planilla';
$tipol['Otros']='Otros';
   $this->setWidget('tipo', new sfWidgetFormChoice(array(
            "choices" => $tipol,
                ), array("class" => " form-control  mi-selector ")));
        
        $this->setValidator('tipo', new sfValidatorString(array('required' => true)));
        
         $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'placeholder' => 'Nombre Beneficiario', 'max_length' => 150,)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));

        
       

        $this->setWidget('referencia', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Referencia', 'max_length' => 150,)));
        $this->setValidator('referencia', new sfValidatorString(array('required' => true)));

        $this->setWidget('motivo', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('motivo', new sfValidatorString(array('required' => true)));

        $this->setWidget('valor', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'onkeypress' => 'validate(event)', 'placeholder' => '00.00', 'max_length' => 150,)));
        $this->setValidator('valor', new sfValidatorString(array('required' => true)));

       
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }
    
    


}
