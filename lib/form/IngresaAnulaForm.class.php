<?php

class IngresaAnulaForm extends sfForm {

    public function configure() {


        $this->setWidget('codigo', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "",)));
        $this->setValidator('codigo', new sfValidatorString(array('required' => true)));

       $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), 
                array('class' => 'form-control', 'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' =>false)));

  $tipo[null] = '[Seleccione]';
        $tipo['Proveedor'] = 'Pago Proveedor';
       $tipo['Servicio']='Pago Recibido';
       $tipo['Incumplimiento']='Incumplimiento';
        $this->setWidget('tipo', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('tipo', new sfValidatorString(array('required' => true)));
//          $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
//            'callback' => array($this, "valida")
//        )));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
