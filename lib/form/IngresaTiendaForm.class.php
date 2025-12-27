<?php

class IngresoTiendaForm extends sfForm {

    public function configure() {
        $DepartamentoId = sfContext::getInstance()->getUser()->getAttribute("departamento", null, 'seleccion');
        $criteriaMunicipio = new Criteria();
        $criteriaMunicipio->add(MunicipioPeer::DEPARTAMENTO_ID, $DepartamentoId);

        $this->setWidget(
                "archivo", new sfWidgetFormInputFile(array(), array(
            "class" => "file-upload btn btn-file-upload",
        )));
        $this->setValidator('archivo', new sfValidatorFile(array('required' => false), array()));

        $this->setWidget('codigo', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
        $this->setValidator('codigo', new sfValidatorString(array('required' => false)));

        $tipo[null]='Seleccione';
        $tipo['Venta']='Venta';
        $tipo['Bodega']='Bodega';
        
                
        $this->setWidget('tipo', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));



        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control ', "placeholder" => "Nombre")));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));

        $this->setWidget('codigo_establecimiento', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
        $this->setValidator('codigo_establecimiento', new sfValidatorString(array('required' => false)));
        $this->setValidator('direccion', new sfValidatorString(array('required' => FALSE)));
        $this->setWidget('direccion', new sfWidgetFormInputText(array(), array('class' => 'form-control ', "placeholder" => "Dirección")));

        $this->setWidget('telefono', new sfWidgetFormInputText(array("type" => 'number'), array('class' => 'form-control ', "placeholder" => "0000-0000")));

        $this->setValidator('telefono', new sfValidatorString(array('required' => FALSE)));

        $this->setWidget('correo', new sfWidgetFormInputText(array(), array('class' => 'form-control ', 'type' => "email", "placeholder" => "correo@correo.com")));
        $this->setValidator('correo', new sfValidatorString(array('required' => FALSE)));

        $this->setWidget('nombre_comercial', new sfWidgetFormInputText(array(), array('class' => 'form-control ', "placeholder" => "Nombre comercial")));
        $this->setValidator('nombre_comercial', new sfValidatorString(array('required' => true)));

        $this->setWidget('activo', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// cje
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));

        $this->setWidget('activa_buscador', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// cje
        $this->setValidator('activa_buscador', new sfValidatorString(array('required' => false)));
        
        

        $this->setWidget('departamento', new sfWidgetFormPropelChoice(array('model' => 'Departamento'
            , 'order_by' => array('Nombre', 'asc'), 'add_empty' => '[ Seleccione Departamento ]',
                ), array('class' => 'form-control ',
            'add_empty' => '[ Seleccione Departamento ]',
                )
        ));
        $this->setWidget('municipio', new sfWidgetFormPropelChoice(array('model' => 'Municipio'
            , 'criteria' => $criteriaMunicipio, 'order_by' => array('Descripcion', 'asc'),
                ), array('class' => 'form-control',
                )
        ));
        $this->setValidator('municipio', new sfValidatorString(array('required' => false)));
        $this->setValidator('departamento', new sfValidatorString(array('required' => false)));

  
                    $this->setWidget('nit', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'max_length' => 50,)));
        $this->setValidator('nit', new sfValidatorString(array('required' => false)));

        
        
        
              $this->setWidget('feel_usuario', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'max_length' => 50,)));
        $this->setValidator('feel_usuario', new sfValidatorString(array('required' => false)));

        
                 
         $this->setWidget('feel_token', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'max_length' => 150,)));
        $this->setValidator('feel_token', new sfValidatorString(array('required' => false)));
        
        
          $this->setWidget('feel_llave', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'max_length' => 150,)));
        $this->setValidator('feel_llave', new sfValidatorString(array('required' => false)));
        
        


        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
