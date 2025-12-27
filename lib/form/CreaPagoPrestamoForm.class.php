<?php

class CreaPagoPrestamoForm extends sfForm {

    public function configure() {

        


        $this->setWidget('comentario', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('comentario', new sfValidatorString(array('required' => false)));
        
        $this->setWidget('valor_dolares', new sfWidgetFormInputText(array(), array('class' => 'form-control', 
          'step' =>'any',  'type' => 'number', 'placeHolder'=>'0.00')));
        $this->setValidator('valor_dolares', new sfValidatorString(array('required' => true)));

        
                $this->setWidget('valor_quetzales', new sfWidgetFormInputText(array(), array('class' => 'form-control', 
        "style"=>"background-color:#F9FBFE ;" ,  "readonly"=>true,     'type' => 'number', 'placeHolder'=>'0.00')));
        $this->setValidator('valor_quetzales', new sfValidatorString(array('required' => true)));
        
        
        
       $this->setWidget('fecha_inicio', new sfWidgetFormInputText(array(),
                        array('class' => 'form-control', "style"=>"background-color:#F9FBFE ;" ,  "readonly"=>true,  'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fecha_inicio', new sfValidatorString(array('required' => true)));
      
        
         $this->setWidget('fecha', new sfWidgetFormInputText(array(),
                        array('class' => 'form-control',    'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fecha', new sfValidatorString(array('required' => true)));
        
        
        
        
        $tipoDo['CALCULO INTERES']='CALCULO INTERES';
        $tipoDo['PAGO INTERES']='PAGO INTERES';
        $tipoDo['PAGO CAPITAL']='PAGO CAPITAL';
        $tipoDo['AJUSTE DIFERENCIAL']='AJUSTE DIFERENCIAL';
         $tipoDo['INGRESO PRESTAMO']='INGRESO PRESTAMO';
        $this->setWidget('tipo', new sfWidgetFormChoice(array("choices" => $tipoDo,), array("class" => "form-control")));
        $this->setValidator('tipo', new sfValidatorString(array('required' => true)));
        
        $tipob=null;
        $banco= BancoQuery::create()->filterByDolares(true)->find();
        foreach ($banco as $regi){
            $tipob[$regi->getId()]=$regi->getNombre();
        }
        
        $this->setWidget('banco_id', new sfWidgetFormChoice(array("choices" => $tipob,), array("class" => "form-control")));
        $this->setValidator('banco_id', new sfValidatorString(array('required' => false)));
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
