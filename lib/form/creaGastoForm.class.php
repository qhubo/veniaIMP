<?php

class CreaGastoForm extends sfForm {

    public function configure() {


         $this->setWidget('exenta', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('exenta', new sfValidatorString(array('required' => false)));

        $this->setWidget('fecha_documento', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fecha_documento', new sfValidatorString(array('required' => true)));
       
        $vboedgas= ProyectoQuery::create()
                ->filterByActivo(true)
                ->orderByNombre()
                ->find();
        
        $tipoP[null]='[Seleccione]';
        foreach ($vboedgas  as $registro) {
        $tipoP[$registro->getId()]=$registro->getNombre();
            
        }
        
        $this->setWidget('proyecto_id', new sfWidgetFormChoice(array("choices" => $tipoP,), array("class" => "form-control")));
        $this->setValidator('proyecto_id', new sfValidatorString(array('required' => false)));
        
        
        
        $vboedgas= ProveedorQuery::create()
                ->filterByActivo(true)
                ->orderByNombre()
                ->find();
        
        $tipoProv[null]='[Seleccione]';
        foreach ($vboedgas  as $registro) {
        $tipoProv[$registro->getId()]=$registro->getNombre();            
        }
        
        $this->setWidget('proveedor_id', new sfWidgetFormChoice(array("choices" => $tipoProv,), array("class" => "form-control")));
        $this->setValidator('proveedor_id', new sfValidatorString(array('required' => true)));
        $listab = TiendaQuery::TiendaActivas();
               $vboedgas= TiendaQuery::create()
                   ->filterById($listab, Criteria::IN)
                       ->filterByActivo(true)
                ->orderByNombre()
                ->find();
        
        $tipo[null]='[Seleccione]';
        foreach ($vboedgas  as $registro) {
        $tipo[$registro->getId()]=$registro->getNombre();
            
        }
        
        $this->setWidget('tienda_id', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('tienda_id', new sfValidatorString(array('required' => false)));
        
        
        
        $this->setWidget('dia_credito', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number',)));
        $this->setValidator('dia_credito', new sfValidatorString(array('required' => true)));

        
        
        $tipoDo['FACTURA']='FACTURA';
        $tipoDo['RECIBO']='RECIBO';
        $tipoDo['ORDEN']='ORDEN';
        $tipoDo['OTRO']='OTRO';
          
        $this->setWidget('tipo_documento', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('tipo_documento', new sfValidatorString(array('required' => true)));
        
        
    
        $this->setWidget('documento', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,
            "placeholder" => "No Documento",)));
        $this->setValidator('documento', new sfValidatorString(array('required' => true)));


 
        
        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce','rows'=>2)));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => false)));
   
 
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
