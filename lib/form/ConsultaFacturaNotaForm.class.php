<?php

class ConsultaFacturaNotaForm extends sfForm {

    public function configure() {
        
        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
     
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));
        
     $this->setWidget('busqueda', new sfWidgetFormInputText(array(), array('class' => 'form-control')));
        $this->setValidator('busqueda', new sfValidatorString(array('required' => false)));

       
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
