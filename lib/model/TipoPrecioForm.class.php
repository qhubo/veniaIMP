<?php


class TipoPrecioForm extends sfForm {

    public function configure() {
  
                          
        $this->setWidget('codigo', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            "placeholder" => " ",
        )));
        $this->setValidator('codigo', new sfValidatorString(array('required' => false)));
      
        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            "placeholder" => "Ingrese nombre ",
        )));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));

  
             
          $this->setWidget('activo', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
