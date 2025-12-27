<?php

class CreaNotaCreForm extends sfForm {

    public function configure() {

$tipol['FACTURA']='Factura';
$tipol['Recibo']='Recibo';
   $this->setWidget('tipo', new sfWidgetFormChoice(array(
            "choices" => $tipol,
                ), array("class" => " form-control  mi-selector ")));
        
        $this->setValidator('tipo', new sfValidatorString(array('required' => true)));
        
        
        
        $proveddores = ProveedorQuery::create()
                ->orderByNombre()
                ->filterByActivo(true)
                ->find();
        $listaP[null]='[Seleccione Proveedor]';       
        foreach ($proveddores as $deta) {
           $listaP[$deta->getId()]=$deta->getNombre();            
        }
        
        
         $this->setWidget('proveedor_id', new sfWidgetFormChoice(array(
            "choices" => $listaP,
                ), array("class" => " form-control  mi-selector ")));
        
        $this->setValidator('proveedor_id', new sfValidatorString(array('required' => true)));
        
        
        

        $this->setWidget('referencia_factura', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Factura', 'max_length' => 150,)));
        $this->setValidator('referencia_factura', new sfValidatorString(array('required' => true)));

        $this->setWidget('concepto', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('concepto', new sfValidatorString(array('required' => true)));

        $this->setWidget('valor', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'onkeypress' => 'validate(event)', 'placeholder' => '00.00', 'max_length' => 150,)));
        $this->setValidator('valor', new sfValidatorString(array('required' => true)));

        $this->setWidget("archivo", new sfWidgetFormInputFile(array(), array()));
        $this->setValidator('archivo', new sfValidatorFile(array('required' => false), array()));

        $this->setWidget('aplica_iva', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('aplica_iva', new sfValidatorString(array('required' => false)));

        
         $this->setWidget('porcentaje_retenie', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'onkeypress' => 'validate(event)', 'placeholder' => '0', 'max_length' => 150,)));
        $this->setValidator('porcentaje_retenie', new sfValidatorString(array('required' => false)));

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }
    
    


}
