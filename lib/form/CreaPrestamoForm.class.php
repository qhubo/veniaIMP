<?php

class CreaPrestamoForm extends sfForm {

    public function configure() {

 
        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "Nombre",)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));

        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => false)));
        
        $this->setWidget('valor', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number',)));
        $this->setValidator('valor', new sfValidatorString(array('required' => true)));

       $this->setWidget('fecha_inicio', new sfWidgetFormInputText(array(),
                        array('class' => 'form-control',    'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fecha_inicio', new sfValidatorString(array('required' => true)));
        
        
        $tipoDo['$']='Dolares';
        $tipoDo['Q']='Quetzales';
        $this->setWidget('moneda', new sfWidgetFormChoice(array("choices" => $tipoDo,), array("class" => "form-control")));
        $this->setValidator('moneda', new sfValidatorString(array('required' => true)));
        
        
         $this->setWidget('tasa_interes', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'onkeypress' => 'validate(event)', 'placeholder' => '0.00', )));
        $this->setValidator('tasa_interes', new sfValidatorString(array('required' => true)));
        
        
        
        
//          $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
//            'callback' => array($this, "valida")
//        )));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
