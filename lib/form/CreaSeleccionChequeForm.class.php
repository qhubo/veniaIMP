<?php

class CreaSeleccionChequeForm extends sfForm {

    public function configure() {


        $this->setWidget('banco', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'max_length' => 150, 'readonly' =>true)));
        $this->setValidator('banco', new sfValidatorString(array('required' => true)));
        
        $tipoB[null]='[Seleccione]';
        $bancoId =   sfContext::getInstance()->getUser()->getAttribute("banco", null, 'seleccion');
        $formatoQuery = DocumentoChequeQuery::create()
                ->filterByBancoId($bancoId)
                ->find();
        
        foreach ($formatoQuery as $registro) {
            $tipoB[$registro->getId()]=$registro->getTitulo();
        }
               
        
         $this->setWidget('nombre_beneficiario', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'text',)));
        $this->setValidator('nombre_beneficiario', new sfValidatorString(array('required' => false)));

        
        
            $this->setWidget('formato', new sfWidgetFormChoice(array("choices" => $tipoB,), array("class" => "form-control")));
        $this->setValidator('formato', new sfValidatorString(array('required' => true)));
   

        $this->setWidget('cheque', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'type' => 'number', )));
        $this->setValidator('cheque', new sfValidatorString(array('required' => true)));
        
                $this->setWidget('no_negociable', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('no_negociable', new sfValidatorString(array('required' => false)));
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
