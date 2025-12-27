<?php
class ComboProductoCreaSeleForm extends sfForm {
    public function configure() {
              $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
          $this->setWidget('precio', new sfWidgetFormInputText(array(), array('class' => 'form-control',
              'step'=>'any', 'type'=>'number','placeholder'=>'0.00'      )));
        $this->setValidator('precio', new sfValidatorString(array('required' => false)));

//        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
//        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));
        $this->setWidget('activo', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));
     //   $filtro[]='RECETA';
        $filtro[]='COMBO';
        $proveedorQuery = TipoAparatoQuery::create()
                                ->filterByEmpresaId($empresaId)

                ->filterByDescripcion($filtro, Criteria::NOT_IN)
                //->filterByActivo(true)
                ->orderByDescripcion("Asc")
                ->find();
        $lineaProve[null] = '[Seleccione]';
        foreach ($proveedorQuery as $regis) {
            $lineaProve[$regis->getId()] = $regis->getDescripcion();
        }
        $this->setWidget('tipo_aparato_id', new sfWidgetFormChoice(array(
            "choices" => $lineaProve,
                ), array("class" => "form-control")));
        $this->setValidator('tipo_aparato_id', new sfValidatorString(array('required' => true)));
        $lineaProve = null;
        $marcaid = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'tipo');
        $proveedorQuery = MarcaQuery::create()
                ->filterByTipoAparatoId($marcaid)
                ->orderByDescripcion("Desc")
                ->find();
        $lineaProve[null] = '[Seleccione]';
        foreach ($proveedorQuery as $regis) {
            $lineaProve[$regis->getId()] = $regis->getDescripcion();
        }
        $this->setWidget('obligatorio', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('obligatorio', new sfValidatorString(array('required' => false)));
        $this->setWidget('marca_id', new sfWidgetFormChoice(array(
            "choices" => $lineaProve,
                ), array("class" => "form-control")));
        $this->setValidator('marca_id', new sfValidatorString(array('required' => false)));
        $line[null] = '[Seleccione]';
         $Seleccion=   sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'tipo');
         $proveedorQuery = ProductoQuery::create()
                ->filterByTipoAparatoId($Seleccion)
                ->orderByNombre("Asc")
                ->find();
            
        $marcaid = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'marca');
        if ($marcaid) {
        $proveedorQuery = ProductoQuery::create()
                ->filterByMarcaId($marcaid)
                ->orderByNombre("Asc")
                ->find();
        }
        foreach ($proveedorQuery as $regis) {
            $line[$regis->getId()] = $regis->getNombre()." ". substr($regis->getDescripcion(), 0,100);;
        }
        $this->setWidget('producto_id', new sfWidgetFormChoice(array(
            "choices" => $line,
                ), array("class" => "form-control")));
        $this->setValidator('producto_id', new sfValidatorString(array('required' => true)));
        
        
          $this->setWidget('cantidad_pro', new sfWidgetFormInputText(array(), array('class' => 'form-control',
              'step'=>'any', 'type'=>'number','placeholder'=>'0.00'      )));
        $this->setValidator('cantidad_pro', new sfValidatorString(array('required' => false)));

        $this->setWidget('cantidad_medida', new sfWidgetFormInputText(array(), array('class' => 'form-control',
              'step'=>'any', 'type'=>'number','placeholder'=>'0.00'      )));
        $this->setValidator('cantidad_medida', new sfValidatorString(array('required' => false)));
        
        
        $this->setWidget('costo_unidad', new sfWidgetFormInputText(array(), array('class' => 'form-control',
              'step'=>'any', 'type'=>'number','placeholder'=>'0.00'      )));
        $this->setValidator('costo_unidad', new sfValidatorString(array('required' => false)));

        
        $this->setWidget('costo_pro', new sfWidgetFormInputText(array(), array('class' => 'form-control',
              'step'=>'any', 'type'=>'number','placeholder'=>'0.00'      )));
        $this->setValidator('costo_pro', new sfValidatorString(array('required' => false)));
        



        $this->setWidget('costo_unidad2', new sfWidgetFormInputText(array(), array('class' => 'form-control',
              'step'=>'any', 'type'=>'number','placeholder'=>'0.00'      )));
        $this->setValidator('costo_unidad2', new sfValidatorString(array('required' => false)));

        
        $this->setWidget('costo_pro2', new sfWidgetFormInputText(array(), array('class' => 'form-control',
              'step'=>'any', 'type'=>'number','placeholder'=>'0.00'      )));
        $this->setValidator('costo_pro2', new sfValidatorString(array('required' => false)));
        
        
        
        $this->setWidget('unidad_medida', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             )));
        $this->setValidator('unidad_medida', new sfValidatorString(array('required' => false)));
        
        $this->widgetSchema->setNameFormat('ingreso[%s]');
    }
}