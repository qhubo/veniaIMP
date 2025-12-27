<?php

class ConsultaFechaNotaForm extends sfForm {

    public function configure() {
        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), 
                array('class' => 'form-control', 'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
       $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
           'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));
        
        $opcion['firmada']='Firmada';
        $opcion['pendiente']='Pendiente';
        
        $this->setWidget('estado', new sfWidgetFormChoice(array(
            "choices" => $opcion,
                ), array("class" => "form-control")));

        $this->setValidator('estado', new sfValidatorString(array('required' => false)));
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}