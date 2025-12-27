<?php

class CreaNuevoChequeForm extends sfForm {

    public function configure() {


        $bancoQuer = BancoQuery::create()
                 ->filterByActivo(true)
                ->orderByNombre("Desc")
                ->find();
        
    $tipoC[null]='[Seleccione]';
    
     foreach ($bancoQuer as $registro) {
            $tipoC[$registro->getId()]=$registro->getNombre();
        }
        
        $this->setValidator('banco', new sfValidatorString(array('required' => true)));
        
            $this->setWidget('banco', new sfWidgetFormChoice(array("choices" => $tipoC,), array("class" => "form-control")));
        
        
        $tipoB[null]='[Seleccione]';
        $bancoId =   sfContext::getInstance()->getUser()->getAttribute("banco", null, 'seleccion');
        $formatoQuery = DocumentoChequeQuery::create()
                ->filterByBancoId($bancoId)
                ->find();
        
        foreach ($formatoQuery as $registro) {
            $tipoB[$registro->getId()]=$registro->getTitulo();
        }
               
        
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
