<?php

class CreaPerfilForm extends sfForm {

    public function configure() {


        $this->setWidget('descripcion', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "Nombre",)));
        $this->setValidator('descripcion', new sfValidatorString(array('required' => true)));
        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => false)));

   

        $this->setWidget('activo', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
