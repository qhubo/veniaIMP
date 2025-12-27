<?php

class ConsultaFechaClienteForm extends sfForm {

    public function configure() {
        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), 
                array('class' => 'form-control', 'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
       $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
           'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));
        
        $opcione[null]='[Seleccione Cliente]';
        $Bancos = ClienteQuery::create()
                ->orderByNombre()
                ->find();
        foreach ($Bancos as $regist) {
            $opcione[$regist->getId()]=$regist->getNombre();
        }
        
 
      $this->setWidget('cliente', new sfWidgetFormChoice(array(
            "choices" => $opcione,
                ), array("class" => "mi-selector  form-control")));
        
        $this->setValidator('cliente', new sfValidatorString(array('required' => true)));
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}