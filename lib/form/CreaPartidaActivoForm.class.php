<?php

class CreaPartidaActivoForm extends sfForm {

    public function configure() {

        $this->setWidget('fecha', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fecha', new sfValidatorString(array('required' => true)));

        $this->setWidget('numero', new sfWidgetFormInputText(array(), array('readOnly'=>true, 'class' => 'form-control', 'max_length' => 150,)));
        $this->setValidator('numero', new sfValidatorString(array('required' => false)));

        
        $this->setWidget('detalle', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,)));
        $this->setValidator('detalle', new sfValidatorString(array('required' => false)));

        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
