<?php

class EditaMarcaProductoForm extends sfForm {

    public function configure() {
  
 

        $this->setWidget('descripcion', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            "placeholder" => "Ingrese nombre ",
        )));
        $this->setValidator('descripcion', new sfValidatorString(array('required' => true)));

        
           $this->setWidget('activo', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));
     

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
