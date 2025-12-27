<?php

class ConsultaFechaBancoForm extends sfForm {
    public function configure() {
        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), 
                array('class' => 'form-control', 'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
       $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
           'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));
        
        $opcione[null]='[Seleccione Banco]';
        $Bancos = BancoQuery::create()
                ->orderByNombre()
                ->find();
        foreach ($Bancos as $regist) {
            $opcione[$regist->getId()]=$regist->getNombre();
        }
        
 
               $opcionesta[null]='[Todos los Estatus]';
               $opcionesta['Procesado']='Procesado';
               $opcionesta['Anulado']='Anulado';
 
         $this->setWidget('estatus', new sfWidgetFormChoice(array(
            "choices" => $opcionesta,
                ), array("class" => " form-control")));
        
        $this->setValidator('estatus', new sfValidatorString(array('required' => false)));
        
        
              $this->setWidget('banco', new sfWidgetFormChoice(array(
            "choices" => $opcione,
                ), array("class" => "mi-selector  form-control")));
        
        $this->setValidator('banco', new sfValidatorString(array('required' => true)));
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}