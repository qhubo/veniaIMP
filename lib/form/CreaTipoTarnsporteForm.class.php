<?php


class CreaTipoTarnsporteForm extends sfForm {

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

          $this->setWidget('descripcion', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            "placeholder" => " ",
        )));
        $this->setValidator('descripcion', new sfValidatorString(array('required' => false)));
         
            $this->setWidget('descripcion', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            "placeholder" => " ",
        )));
        $this->setValidator('descripcion', new sfValidatorString(array('required' => false)));
  
              
            $this->setWidget('telefono', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            "placeholder" => " ",
        )));
        $this->setValidator('telefono', new sfValidatorString(array('required' => false)));
         
        
        
        
        
            $this->setWidget('clave', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            "placeholder" => " ",
        )));
        $this->setValidator('clave', new sfValidatorString(array('required' => false)));
         
        
              $this->setWidget('clave_2', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            "placeholder" => " ",
        )));
        $this->setValidator('clave_2', new sfValidatorString(array('required' => false)));
       
               $this->setWidget('direccion', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            "placeholder" => " ",
        )));
        $this->setValidator('direccion', new sfValidatorString(array('required' => false)));
         
                $this->setWidget('correo', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            "placeholder" => " ",
        )));
        $this->setValidator('correo', new sfValidatorString(array('required' => false)));
       
        
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
