<?php

class CreaDocumentoEmpresa extends sfForm {

    public function configure() {


        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "Nombre",)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));
        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => false)));
  $this->setWidget("archivo", new sfWidgetFormInputFile(array(), array("class" => "file-upload btn btn-file-upload",)));
        $this->setValidator('archivo', new sfValidatorFile(array('required' => true), array()));
        
        
        

//        $tipo['Propietario'] = 'Monetario';
//       $tipo['Vivienda']='Ahorro';
//        $this->setWidget('tipo', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
//        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));
//          $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
//            'callback' => array($this, "valida")
//        )));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
