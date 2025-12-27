<?php

class ConfirmaIngresoForm extends sfForm {

    public function configure() {
        
     $id= sfContext::getInstance()->getUser()->getAttribute("Confirma",null, 'Id');
     $productos = SalidaProductoDetalleQuery::create()
                ->filterBySalidaProductoId($id)
                ->find();
     
        foreach ($productos as $lis) {
            $this->setWidget('numero_' . $lis->getId(), new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
            $this->setValidator('numero_' . $lis->getId(), new sfValidatorString(array('required' => false)));

        }
     
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
