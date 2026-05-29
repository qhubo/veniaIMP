<?php

class ListaEmpaqueUniForm extends sfForm {

    public function configure() {


        $this->setWidget('titulo', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "Titulo",)));
        $this->setValidator('titulo', new sfValidatorString(array('required' => true)));
               $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
