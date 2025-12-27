<?php

class CreaVendedorForm extends sfForm {

    public function configure() {

        $tiendaComision= TiendaComisionQuery::create()
                ->find();
        $opcion[null]='[Seleccione]';
        foreach($tiendaComision as $regi) {
            $opcion[$regi->getNombreTienda()]=$regi->getNombreTienda();
        }
        
        
        $this->setWidget('tienda_comision', new sfWidgetFormChoice(array("choices" => $opcion,), array("class" => " form-control")));
        $this->setValidator('tienda_comision', new sfValidatorString(array('required' => false)));
        

        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "Nombre",)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));

              
        $this->setWidget('codigo_planilla', new sfWidgetFormInputText(array(), array('class' => 'form-control', 
            'max_length' => 150, "placeholder" => "Codigo Planilla",)));
        $this->setValidator('codigo_planilla', new sfValidatorString(array('required' => true)));
        
        
        $this->setWidget('codigo', new sfWidgetFormInputText(array(), array('class' => 'form-control', 
            'max_length' => 150, "placeholder" => "Codigo Powerlink",)));
        $this->setValidator('codigo', new sfValidatorString(array('required' => true)));
        
      $this->setWidget('activo', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));
      
        
        $this->setWidget('encargado_tienda', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('encargado_tienda', new sfValidatorString(array('required' => false)));
        
        
        $this->setWidget('porcentaje_comision', new sfWidgetFormInputText(array(), array('class' => 'form-control',)));
        $this->setValidator('porcentaje_comision', new sfValidatorString(array('required' => false)));
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
