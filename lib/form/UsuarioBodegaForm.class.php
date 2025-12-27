
<?php

class UsuarioBodegaForm extends sfForm {
    public function configure() {
        
     $productos = TiendaQuery::create()->find();
     
        foreach ($productos as $lis) {
            $this->setWidget('numero_' . $lis->getId(), new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
            $this->setValidator('numero_' . $lis->getId(), new sfValidatorString(array('required' => false)));
        }
     
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }
}