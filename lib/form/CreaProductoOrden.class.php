<?php

class CreaProductoOrdenForm extends sfForm {

    public function configure() {
     $lineaMarca[null] = '[ Seleccione  ]';
     $marcaQ = MarcaProductoQuery::create()->find();
     foreach ($marcaQ as $regis) {
            $lineaMarca[$regis->getNombre()] = $regis->getNombre();
        }
      $this->setWidget('marcaProducto', new sfWidgetFormChoice(array( "choices" => $lineaMarca ), array("class" => "form-control")));
      $this->setValidator('marcaProducto', new sfValidatorString(array('required' => false)));

      $this->setWidget('caracteristica', new sfWidgetFormInputText(array(), array('class' => 'form-control',  )));
      $this->setValidator('caracteristica', new sfValidatorString(array('required' => false)));
 
      $this->setWidget('codigo_arancel', new sfWidgetFormInputText(array(), array('class' => 'form-control',)));
      $this->setValidator('codigo_arancel', new sfValidatorString(array('required' => false)));
        
      $this->setWidget('origen', new sfWidgetFormInputText(array(), array('class' => 'form-control',)));
      $this->setValidator('origen', new sfValidatorString(array('required' => false)));
      $this->setWidget('nombre_ingles', new sfWidgetFormInputText(array(), array('class' => 'form-control',  "placeholder" => "Ingrese nombre ingles" )));
      $this->setValidator('nombre_ingles', new sfValidatorString(array('required' => false)));
        
      $this->setWidget('codigo_sku', new sfWidgetFormInputText(array(), array('class' => 'form-control required', )));
      $this->setValidator('codigo_sku', new sfValidatorString(array('required' => false)));  
      $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control required', "placeholder" => "Ingrese nombre producto", )));
      $this->setValidator('nombre', new sfValidatorString(array('required' => false)));
        
        $filtro[] = 'COMBO';
        $filtro[] = 'RECETA';
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $proveedorQuery = TipoAparatoQuery::create()
                ->filterByEmpresaId($empresaId)
               ->filterByDescripcion($filtro, Criteria::NOT_IN)
                ->orderByDescripcion("Desc")
                ->find();
        $lineaTipo[null] = '[Seleccione]';
        foreach ($proveedorQuery as $regis) {
            $lineaTipo[$regis->getId()] = $regis->getDescripcion();
        }
        $this->setWidget('tipo', new sfWidgetFormChoice(array("choices" => $lineaTipo,), array("class" => "form-control required")));
        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));     
        
  
        $this->setWidget('codigo_proveedor', new sfWidgetFormInputText(array(), array('class' => 'form-control',
        )));
        $this->setValidator('codigo_proveedor', new sfValidatorString(array('required' => false)));
        $this->setWidget('precio', new sfWidgetFormInputText(array(), array('class' => 'form-control required',
            'type' => 'number', 'step' => 'any'
        )));
        $this->setValidator('precio', new sfValidatorString(array('required' => false)));
        $this->setWidget('existencia', new sfWidgetFormInputText(array(), array('class' => 'form-control required', 'type' => 'number')));
        $this->setValidator('existencia', new sfValidatorString(array('required' => false)));
        $this->setWidget('costo', new sfWidgetFormInputText(array(), array('class' => 'form-control required', 'type' => 'number', 'step' => 'any' )));
        $this->setValidator('costo', new sfValidatorString(array('required' => false)));
       
       
        
        
        
        

   
        $this->setWidget('costo_fabrica', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number', 'step' => 'any' )));
        $this->setValidator('costo_fabrica', new sfValidatorString(array('required' => false)));
        $this->setWidget('costo_cif', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number', 'step' => 'any' )));
        $this->setValidator('costo_cif', new sfValidatorString(array('required' => false)));
        $this->setWidget('peso', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number', 'step' => 'any'      )));
        $this->setValidator('peso', new sfValidatorString(array('required' => false)));
        $this->setWidget('alto', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number', 'step' => 'any')));
        $this->setValidator('alto', new sfValidatorString(array('required' => false)));
        $this->setWidget('ancho', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number', 'step' => 'any')));
        $this->setValidator('ancho', new sfValidatorString(array('required' => false)));
        $this->setWidget('largo', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number', 'step' => 'any')));
        $this->setValidator('largo', new sfValidatorString(array('required' => false)));
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
