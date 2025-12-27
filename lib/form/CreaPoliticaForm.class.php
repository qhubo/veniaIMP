<?php

class CreaPoliticaForm extends sfForm {

    public function configure() {


        $this->setWidget('titulo', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'max_length' => 150, "placeholder" => "Titulo",)));
        $this->setValidator('titulo', new sfValidatorString(array('required' => true)));
        
        
        
        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(),
                array('class' => 'form-control wysihtml5','rows' => 15)));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => false)));
        
        
        
        
        $this->setWidget('activo', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));
        
        
        $bancoq = BancoQuery::create()->filterByActivo(true)->find();
        $tipoB[null]='[Seleccione Banco]';
        foreach($bancoq as $regi) {
            $tipoB[$regi->getId()]=$regi->getNombre();
        }
        
        
        
        $this->setWidget('banco', new sfWidgetFormChoice(array("choices" => $tipoB,), array("class" => "form-control")));
        $this->setValidator('banco', new sfValidatorString(array('required' => true)));
   
        
        

  

       
        $tipo['NoNegociable']='No Negociable';
        $tipo['Negociable']="Negociable";
        $tipo['Ambas']='Ambas';
        
              $this->setWidget('tipo_negociable', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('tipo_negociable', new sfValidatorString(array('required' => true)));
   
 
        
              $this->setWidget('ancho', new sfWidgetFormInputText(array(), array('class' => 'form-control',
      'type'=>'number'  )));
        $this->setValidator('ancho', new sfValidatorString(array('required' => true)));
        
              $this->setWidget('alto', new sfWidgetFormInputText(array(), array('class' => 'form-control',
      'type'=>'number'  )));
        $this->setValidator('alto', new sfValidatorString(array('required' => true)));
        
              $this->setWidget('correlativo', new sfWidgetFormInputText(array(), array('class' => 'form-control',
      'type'=>'number'  )));
        $this->setValidator('correlativo', new sfValidatorString(array('required' => true)));
        
        
        
                      $this->setWidget('margen_superior', new sfWidgetFormInputText(array(), array('class' => 'form-control',
      'type'=>'number'  )));
        $this->setValidator('margen_superior', new sfValidatorString(array('required' => true)));

                      $this->setWidget('margen_izquierdo', new sfWidgetFormInputText(array(), array('class' => 'form-control',
      'type'=>'number'  )));
        $this->setValidator('margen_izquierdo', new sfValidatorString(array('required' => true)));

        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
