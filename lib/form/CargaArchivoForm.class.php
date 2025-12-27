<?php
class CargaArchivoForm extends sfForm {
     public function configure() {
          $this->setWidget(
        "archivo" , new sfWidgetFormInputFile(array(), array(
      //      "class" => "file-upload", 
           )));
       
        $this->setValidator('archivo',  new sfValidatorFile(array('required' => false), array()) );
        
             $this->setWidget(
        "archivo2" , new sfWidgetFormInputFile(array(), array(
      //      "class" => "file-upload", 
           )));
       
        $this->setValidator('archivo2',  new sfValidatorFile(array('required' => false), array()) );
//        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
//            'callback' => array($this, "validaUsuario")
//        )));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }
//    public function validaUsuario(sfValidatorBase $validator, array $values) {
//        
//        $archivo = $values['archivo'];
//          if ($archivo){   
//        $extesnsion=substr($archivo->getOriginalName(),-4);
//    
//        if ($extesnsion  <> '.xls'){
//            $msg = 'La extension del archivo debe de ser xls';
//                throw new sfValidatorErrorSchema($validator, array("archivo" => new sfValidatorError($validator, $msg)));
//            }
//        }
//        return $values;
//    }
}