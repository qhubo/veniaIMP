<?php

class CreaOrdenLineForm extends sfForm {

    public function configure() {


    $this->setWidget('valor_unitario', new sfWidgetFormInputText(array(), array('class' => 'form-control',
        'step'=>'any',
        'type' => 'number',)));
        $this->setValidator('valor_unitario', new sfValidatorString(array('required' => true)));


        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,
            "placeholder" => "Nombre",)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));
        
                for ($i = 1; $i <= 10; $i++) {
            $listaO[$i]=$i;
        }
                 
        
        $this->setWidget('cantidad', new sfWidgetFormChoice(array("choices" => $listaO,), array("class" => "form-control")));
       
        $this->setValidator('cantidad', new sfValidatorString(array('required' => true)));
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
