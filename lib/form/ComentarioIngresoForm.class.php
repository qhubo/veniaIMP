
<?php

class ComentarioIngresoForm extends sfForm {

    public function configure() {
            $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control', 'rows' => 2)));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => false)));
    
  
     
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}