<?php

class EditaProductoForm extends sfForm {

    public function configure() {

          $this->setWidget( "archivo", new sfWidgetFormInputFile(array(), array('label'=>'label', 'accept' => 'image/png, image/jpeg', )));
   
        $this->setValidator('archivo',  new sfValidatorFile(array('required' => false), array()) );
        
        
        $tipoId = sfContext::getInstance()->getUser()->getAttribute('tipo_id', null, 'seguridad');
        $marcaId = sfContext::getInstance()->getUser()->getAttribute('marca_id', null, 'seguridad');

        $criteriaMarca = new Criteria();
        $criteriaMarca->add(MarcaPeer::TIPO_APARATO_ID, $tipoId);


        $criteria = new Criteria();
        $criteria->add(ModeloPeer::MARCA_ID, $marcaId);

        $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad');
        if (!$proveedor_id) {
            $lineaProve[null] = '[ Seleccione Proveedor ]';
            $proveedorQuery = ProveedorQuery::create()
                    ->filterByActivo(true)
                    ->orderByNombre("Desc")
                    ->find();
        } else {
         $proveedorQuery = ProveedorQuery::create()
                    ->filterById($proveedor_id)
                    ->orderByNombre("Desc")
                    ->find();
        }
        foreach ($proveedorQuery as $regis) {
            $lineaProve[$regis->getId()] = $regis->getNombre();
        }

        $this->setWidget('proveedor', new sfWidgetFormChoice(array( "choices" => $lineaProve ), array("class" => "form-control")));
        $this->setValidator('proveedor', new sfValidatorString(array('required' => false)));
 $lineaMarca[null] = '[ Seleccione  ]';
$marcaQ = MarcaProductoQuery::create()->find();
     foreach ($marcaQ as $regis) {
            $lineaMarca[$regis->getNombre()] = $regis->getNombre();
        }
        
        $this->setWidget('marcaProducto', new sfWidgetFormChoice(array( "choices" => $lineaMarca ), array("class" => "form-control")));
        $this->setValidator('marcaProducto', new sfValidatorString(array('required' => false)));

        
        
        
        $this->setWidget('link_descarga', new sfWidgetFormInputText(array(), array('class' => 'form-control',)));
        $this->setValidator('link_descarga', new sfValidatorString(array('required' => false)));
        
        $this->setWidget('caracteristica', new sfWidgetFormInputText(array(), array('class' => 'form-control',  )));
        $this->setValidator('caracteristica', new sfValidatorString(array('required' => false)));

  $this->setWidget('codigo_arancel', new sfWidgetFormInputText(array(), array('class' => 'form-control',)));
        $this->setValidator('codigo_arancel', new sfValidatorString(array('required' => false)));
        

        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            "placeholder" => "Ingrese nombre producto",
        )));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));
        
         $this->setWidget('nombre_ingles', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            "placeholder" => "Ingrese nombre ingles",
        )));
        $this->setValidator('nombre_ingles', new sfValidatorString(array('required' => false)));
        

        $this->setWidget('descripcion', new sfWidgetFormTextarea(array(), array('class' => 'form-control EditorMce')));
        $this->setValidator('descripcion', new sfValidatorString(array('required' => false)));

        $this->setWidget('descripcion_corta', new sfWidgetFormTextarea(array(), array('class' => 'form-control EditorMce')));
        $this->setValidator('descripcion_corta', new sfValidatorString(array('required' => false)));

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
                $this->setWidget('tipo', new sfWidgetFormChoice(array(
            "choices" => $lineaTipo,
                ), array("class" => "form-control")));
        $this->setValidator('tipo', new sfValidatorString(array('required' => true)));
        $this->setWidget('marca', new sfWidgetFormPropelChoice(
                array('model' => 'Marca',
            'criteria' => $criteriaMarca,
            'add_empty' => '[ Seleccione ' . TipoAparatoQuery::marca() . ' ]',
            'order_by' => array('Descripcion', 'asc'),
                ), array('class' => 'form-control',
        )));
        $this->setValidator('marca', new sfValidatorString(array('required' => false)));
        $this->setWidget('modelo', new sfWidgetFormPropelChoice(
                array('model' => 'Modelo',
            'criteria' => $criteria,
            'add_empty' => '[ Seleccione ' . TipoAparatoQuery::modelo() . ' ]',
            'order_by' => array('Descripcion', 'asc'),
                ), array('class' => 'form-control',
        )));
        $this->setValidator('modelo', new sfValidatorString(array('required' => false)));
        $this->setWidget('codigo_sku', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                //         "placeholder" => "Ingrese nombre producto",
             "placeholder" => "* Código Automatico ",
        )));
        $this->setValidator('codigo_sku', new sfValidatorString(array('required' => false)));
        $this->setWidget('codigo_barras', new sfWidgetFormInputText(array(), array('class' => 'form-control',)));
        $this->setValidator('codigo_barras', new sfValidatorString(array('required' => false)));
        $this->setWidget('codigo_proveedor', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                //         "placeholder" => "Ingrese nombre producto",
        )));
        $this->setValidator('codigo_proveedor', new sfValidatorString(array('required' => false)));
        $this->setWidget('precio', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'type' => 'number', 'step' => 'any'
                //         "placeholder" => "Ingrese nombre producto",
        )));
        $this->setValidator('precio', new sfValidatorString(array('required' => true)));
        $this->setWidget('existencia', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'type' => 'number'
                //         "placeholder" => "Ingrese nombre producto",
        )));

        $this->setValidator('existencia', new sfValidatorString(array('required' => false)));
        $this->setWidget('costo', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number', 'step' => 'any' )));
        $this->setValidator('costo', new sfValidatorString(array('required' => false)));
        $this->setWidget('costo_fabrica', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number', 'step' => 'any' )));
        $this->setValidator('costo_fabrica', new sfValidatorString(array('required' => false)));
        $this->setWidget('costo_cif', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number', 'step' => 'any' )));
        $this->setValidator('costo_cif', new sfValidatorString(array('required' => false)));

        
        $this->setWidget('peso', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'type' => 'number', 'step' => 'any'
                //         "placeholder" => "Ingrese nombre producto",
        )));
        $this->setValidator('peso', new sfValidatorString(array('required' => false)));
        $tipo[0] = 'No publicar';
        $tipo[1] = 'Publicado Web';
        $this->setWidget('estatus', new sfWidgetFormChoice(array(
            "choices" => $tipo,
                ), array("class" => "form-control")));
        $this->setValidator('estatus', new sfValidatorString(array('required' => false)));

        $this->setWidget('tercero', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('tercero', new sfValidatorString(array('required' => false)));


        $this->setWidget('factura_servicio', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('factura_servicio', new sfValidatorString(array('required' => false)));


        $this->setWidget('activo', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));
        $this->setWidget('meta_title', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                //         "placeholder" => "Ingrese nombre producto",
        )));

        $this->setValidator('meta_title', new sfValidatorString(array('required' => false)));

        $this->setWidget('meta_key', new sfWidgetFormTextarea(array(), array('class' => 'form-control')));
        $this->setValidator('meta_key', new sfValidatorString(array('required' => false)));
        $this->setWidget('meta_des', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                //         "placeholder" => "Ingrese nombre producto",
        )));
        $this->setValidator('meta_des', new sfValidatorString(array('required' => false)));
        $this->setWidget('garantia_admin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'type' => 'number', 'step' => 'any'
                //         "placeholder" => "Ingrese nombre producto",
        )));
        $this->setValidator('garantia_admin', new sfValidatorString(array('required' => false)));
        $this->setWidget('garantia_trans', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'type' => 'number', 'step' => 'any'
                //         "placeholder" => "Ingrese nombre producto",
        )));

        $this->setValidator('garantia_trans', new sfValidatorString(array('required' => false)));
        $this->setWidget('dia_garantia', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'type' => 'number'
                //         "placeholder" => "Ingrese nombre producto",
        )));

        $this->setValidator('dia_garantia', new sfValidatorString(array('required' => false)));

        $this->setWidget('alerta_minima', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'type' => 'number'
                //         "placeholder" => "Ingrese nombre producto",
        )));

        $this->setValidator('alerta_minima', new sfValidatorString(array('required' => false)));
        $this->setWidget('dimension', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                //         "placeholder" => "Ingrese nombre producto",
        )));
        $this->setValidator('dimension', new sfValidatorString(array('required' => false)));




        $this->setWidget('alto', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number', 'step' => 'any')));
        $this->setValidator('alto', new sfValidatorString(array('required' => false)));

        $this->setWidget('ancho', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number', 'step' => 'any')));
        $this->setValidator('ancho', new sfValidatorString(array('required' => false)));

        $this->setWidget('largo', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number', 'step' => 'any')));
        $this->setValidator('largo', new sfValidatorString(array('required' => false)));

        
           $this->setWidget('activo', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));
     
           $this->setWidget('promocional', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('promocional', new sfValidatorString(array('required' => false)));

           $this->setWidget('top_venta', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('top_venta', new sfValidatorString(array('required' => false)));

           $this->setWidget('salida', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('salida', new sfValidatorString(array('required' => false)));

           $this->setWidget('afecto_inventario', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('afecto_inventario', new sfValidatorString(array('required' => false)));

           $this->setWidget('traslado', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('traslado', new sfValidatorString(array('required' => false)));
        
        
        
        $this->setWidget('unidad_medida', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                //         "placeholder" => "Ingrese nombre producto",
        )));
        $this->setValidator('unidad_medida', new sfValidatorString(array('required' => false)));
        
              $this->setWidget('unidad_medida_costo', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                //         "placeholder" => "Ingrese nombre producto",
        )));
        $this->setValidator('unidad_medida_costo', new sfValidatorString(array('required' => false)));
        
        
        
//        $this->setWidget('texto_uno', new sfWidgetFormTextarea(array(), array('class' => 'form-control')));
//        $this->setValidator('texto_uno', new sfValidatorString(array('required' => false)));
//
//        $this->setWidget('texto_dos', new sfWidgetFormTextarea(array(), array('class' => 'form-control')));
//        $this->setValidator('texto_dos', new sfValidatorString(array('required' => false)));
//        $this->setWidget('texto_tres', new sfWidgetFormTextarea(array(), array('class' => 'form-control')));
//        $this->setValidator('texto_tres', new sfValidatorString(array('required' => false)));
//
//
//        $this->setWidget(
//                "archivo", new sfWidgetFormInputFile(array(), array(
//            "class" => "file-upload btn btn-file-upload",
//        )));
//
//
//
//        $this->setValidator('archivo', new sfValidatorFile(array('required' => false), array()));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
