<?php

class NumeroProductoFormUbicaForm extends sfForm {

    public function configure() {



        $lineaProve['NO'] = 'NO ACTUALIZA VALORES A CEROS';
        $lineaProve['SI'] = 'ACTUALIZA LOS VALORES A CEROS';
        $this->setWidget('tipo_carga', new sfWidgetFormChoice(array(
                    "choices" => $lineaProve,
                        ), array("class" => "form-control")));
        $this->setValidator('tipo_carga', new sfValidatorString(array('required' => false)));

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));
        $operaciones = new ProductoQuery();
        $productos = $operaciones->find();
        foreach ($productos as $lis) {

            $this->setWidget('numero_' . $lis->getId(), new sfWidgetFormInputText(array(), array('class' => 'form-control input-circle', "placeholder" => "0", "type" => 'number' )));
            $this->setValidator('numero_' . $lis->getId(), new sfValidatorString(array('required' => false)));
       for ($i = 1; $i <= 3; $i++) {
            $this->setWidget('numero_' . $lis->getId() . "_" . $i, new sfWidgetFormInputText(array(), array('class' => 'form-control input-circle', "placeholder" => "0", "type" => 'number' )));
            $this->setValidator('numero_' . $lis->getId() . "_" . $i, new sfValidatorString(array('required' => false)));
           
       }
            
            
            $this->setWidget('ubica_' . $lis->getId(), new sfWidgetFormInputText(array(), array('class' => 'form-control input-circle')));
            $this->setValidator('ubica_' . $lis->getId(), new sfValidatorString(array('required' => false)));

            for ($i = 1; $i <= 3; $i++) {
                $this->setWidget('ubica_' . $lis->getId() . "_" . $i, new sfWidgetFormInputText(array(), array('class' => 'form-control input-circle')));
                $this->setValidator('ubica_' . $lis->getId() . "_" . $i, new sfValidatorString(array('required' => false)));
            }
        }

        $this->widgetSchema->setNameFormat('registro[%s]');
    }

}
