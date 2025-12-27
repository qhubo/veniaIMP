<?php

class CreaTrasladoForm extends sfForm {

    public function configure() {
        $this->setWidget('comentario', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('comentario', new sfValidatorString(array('required' => true)));
        $tipob=null;
        $tienda=TiendaQuery::create()->find();
         $tipob[null]="Seleccione";
        foreach ($tienda as $regi){
            $tipob[$regi->getId()]=$regi->getNombre();
        }
        $this->setWidget('bodega_origen', new sfWidgetFormChoice(array("choices" => $tipob,), array("class" => "form-control")));
        $this->setValidator('bodega_origen', new sfValidatorString(array('required' => true)));
        $this->setWidget('bodega_destino', new sfWidgetFormChoice(array("choices" => $tipob,), array("class" => "form-control")));
        $this->setValidator('bodega_destino', new sfValidatorString(array('required' => true)));
      
              $this->setWidget('producto_id', new sfWidgetFormInputText(array(), array('class' => 'form-control', 
        "style"=>"background-color:#F9FBFE ;" ,     'type' => 'hidden', 'placeHolder'=>'0')));
        $this->setValidator('producto_id', new sfValidatorString(array('required' => true)));
        
        
             $this->setWidget('cantidad', new sfWidgetFormInputText(array(), array('class' => 'form-control', 
              'type' => 'number', 'placeHolder'=>'0')));
        $this->setValidator('cantidad', new sfValidatorString(array('required' => true)));
        
      $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
            'callback' => array($this, "valida")
        )));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }
    
  public function valida(sfValidatorBase $validator, array $values) {

    $producto= ProductoQuery::create()->findOneById($values['producto_id']);
    $existenciaActual = $producto->getExistenciaBodega($values['bodega_origen']);  
    $cantidaSolicitad = $values['cantidad'];
     if ($values['bodega_origen'] ==$values['bodega_destino']) {
       throw new sfValidatorErrorSchema($validator, array("bodega_destino" => new sfValidatorError($validator, "Bodega Origen debe ser diferente a bodega destino")));
  }

  

 if ($cantidaSolicitad >$existenciaActual) {
       throw new sfValidatorErrorSchema($validator, array("bodega_origen" => new sfValidatorError($validator, "No Productos solcitado ".$cantidaSolicitad." no hay en existencia ")));
  }

   
  return $values;
 }


}