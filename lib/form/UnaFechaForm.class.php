<?php

class UnaFechaForm extends sfForm {

    public function configure() {

        $this->setWidget('fecha', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fecha', new sfValidatorString(array('required' => true)));
       
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
