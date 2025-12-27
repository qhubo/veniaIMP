<?php
class EditaFichaForm extends sfForm {
     public function configure() {

         
         

        $this->setWidget('primer_nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 50,            "placeholder" => "Nombres",)));
        $this->setValidator('primer_nombre', new sfValidatorString(array('required' => true)));


        $this->setWidget('correo', new sfWidgetFormInputText(array(), array('class' => 'form-control', "type" => "email",   "placeholder" => "cuenta@correo.com",     )));
        $this->setValidator('correo', new sfValidatorString(array('required' => true)));
 $this->setWidget(
        
               "archivo" , new sfWidgetFormInputFile(array(), array(
      //      "class" => "file-upload", 
           )));
       
        $this->setValidator('archivo',  new sfValidatorFile(array('required' => false), array()) );
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }


}