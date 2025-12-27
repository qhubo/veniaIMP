<?php
class CreaEmpresaForm extends sfForm {
     public function configure() {

         
                 $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                     'max_length' =>150,            "placeholder" => "Nombre Condominio",)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => false)));
                $this->setWidget('direccion', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                     'max_length' =>350,            "placeholder" => "Dirección",)));
        $this->setValidator('direccion', new sfValidatorString(array('required' => false)));
         
         
         
         $this->setWidget('nomenclatura', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'max_length' => 50,)));
        $this->setValidator('nomenclatura', new sfValidatorString(array('required' => false)));

         $this->setWidget('dias_credito', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'type'=>'number' )));
        $this->setValidator('dias_credito', new sfValidatorString(array('required' => false)));

        
         $this->setWidget('telefono', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'max_length' => 50,)));
        $this->setValidator('telefono', new sfValidatorString(array('required' => false)));
        
        

           $DepartamentoId= sfContext::getInstance()->getUser()->getAttribute("departamento", null, 'seleccion');
     $criteriaMunicipio = new Criteria();
        $criteriaMunicipio->add(MunicipioPeer::DEPARTAMENTO_ID, $DepartamentoId);
     $this->setWidget('departamento', new sfWidgetFormPropelChoice(array('model' => 'Departamento'
            , 'order_by' => array('Nombre', 'asc'),      'add_empty' => '[ Seleccione Departamento ]',
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
        
        
        $this->setWidget('mapa_geo', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('mapa_geo', new sfValidatorString(array('required' => false)));
        
        
        $this->setWidget("archivo", new sfWidgetFormInputFile(array(), array("class" => "file-upload btn btn-file-upload",)));
        $this->setValidator('archivo', new sfValidatorFile(array('required' => false), array()));
        
        
        
        
        $this->setWidget('contacto_nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control',       )));
        $this->setValidator('contacto_nombre', new sfValidatorString(array('required' => false)));
     
        
        
        $this->setWidget('contacto_correo', new sfWidgetFormInputText(array(), array('class' => 'form-control', "type" => "email",        )));
        $this->setValidator('contacto_correo', new sfValidatorString(array('required' => false)));
     
        $this->setWidget('contacto_telefono', new sfWidgetFormInputText(array(), array( "placeholder" => "Telefono", 'max_length' => 50, 'class' => 'form-control',        )));
        $this->setValidator('contacto_telefono', new sfValidatorString(array('required' => false)));
     
           $this->setWidget('contacto_movil', new sfWidgetFormInputText(array(), array( "placeholder" => "Movil",  'max_length' => 50, 'class' => 'form-control',        )));
        $this->setValidator('contacto_movil', new sfValidatorString(array('required' => false)));
        
     
              $this->setWidget('codigo_convenio', new sfWidgetFormInputText(array(), array(   'max_length' => 50, 'class' => 'form-control',        )));
        $this->setValidator('codigo_convenio', new sfValidatorString(array('required' => false)));
        
              $this->setWidget('codigo_proveedor', new sfWidgetFormInputText(array(), array(  'max_length' => 50, 'class' => 'form-control',        )));
        $this->setValidator('codigo_proveedor', new sfValidatorString(array('required' => false)));
        
        
        
        $tipo['Propietario'] = 'Propietario';
       $tipo['Vivienda']='Vivienda';
        $this->setWidget('tipo_cuenta', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('tipo_cuenta', new sfValidatorString(array('required' => false)));
        
        $this->setWidget('activo', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));
        
     $this->setWidget('retiene_isr', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setValidator('retiene_isr', new sfValidatorString(array('required' => false)));

 $this->setWidget('moneda_q', new sfWidgetFormInputText(array(), array( "placeholder" => "Mon", 'max_length' => 2, 'class' => 'form-control',        )));
        $this->setValidator('moneda_q', new sfValidatorString(array('required' => false)));
        
$this->setWidget('factura_electronica', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setWidget('pago_ach', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setWidget('pago_tarjeta', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setWidget('pago_deposito', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setWidget('pago_cheque', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setWidget('pago_efectivo', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setWidget('notifica_sms', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setWidget('notifica_whatapss', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setWidget('utiliza_sector', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setWidget('utiliza_amenida', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setWidget('utiliza_convocatoria', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setWidget('biblioteca_archivo', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setWidget('utiliza_votaciones', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setWidget('valida_proveedores', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setWidget('utiliza_ticket', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setValidator('factura_electronica', new sfValidatorString(array('required' => false)));
$this->setValidator('pago_ach', new sfValidatorString(array('required' => false)));
$this->setValidator('pago_tarjeta', new sfValidatorString(array('required' => false)));
$this->setValidator('pago_deposito', new sfValidatorString(array('required' => false)));
$this->setValidator('pago_cheque', new sfValidatorString(array('required' => false)));
$this->setValidator('pago_efectivo', new sfValidatorString(array('required' => false)));
$this->setValidator('notifica_sms', new sfValidatorString(array('required' => false)));
$this->setValidator('notifica_whatapss', new sfValidatorString(array('required' => false)));
$this->setValidator('utiliza_sector', new sfValidatorString(array('required' => false)));
$this->setValidator('utiliza_amenida', new sfValidatorString(array('required' => false)));
$this->setValidator('utiliza_convocatoria', new sfValidatorString(array('required' => false)));
$this->setValidator('biblioteca_archivo', new sfValidatorString(array('required' => false)));
$this->setValidator('utiliza_votaciones', new sfValidatorString(array('required' => false)));
$this->setValidator('valida_proveedores', new sfValidatorString(array('required' => false)));
$this->setValidator('utiliza_ticket', new sfValidatorString(array('required' => false)));
$this->setWidget('utiliza_encuesta', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
$this->setValidator('utiliza_encuesta', new sfValidatorString(array('required' => false)));

              $this->setWidget('maximo_usuario', new sfWidgetFormInputText(array(), array( "placeholder" => "",  'max_length' => 50, 'class' => 'form-control',        )));
        $this->setValidator('maximo_usuario', new sfValidatorString(array('required' => false)));  

 $this->setWidget('feel_nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'max_length' => 150,)));
        $this->setValidator('feel_nombre', new sfValidatorString(array('required' => false)));
        
         $this->setWidget('feel_establecimiento', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'max_length' => 50,)));
        $this->setValidator('feel_establecimiento', new sfValidatorString(array('required' => false)));

        
                 
         $this->setWidget('feel_usuario', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'max_length' => 50,)));
        $this->setValidator('feel_usuario', new sfValidatorString(array('required' => false)));

        
                 
         $this->setWidget('feel_token', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'max_length' => 150,)));
        $this->setValidator('feel_token', new sfValidatorString(array('required' => false)));
        
        
          $this->setWidget('feel_llave', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'max_length' => 150,)));
        $this->setValidator('feel_llave', new sfValidatorString(array('required' => false)));

//          $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
//            'callback' => array($this, "valida")
//        )));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }
  public function valida(sfValidatorBase $validator, array $values) {

  $tipoUsuario =$values['tipo'];     
  $gasolinera=$values['gasolinera'];
  $empresa =$values['empresa'];
  if ($tipoUsuario=='Gasolinera') {
      if (!$gasolinera) {
       throw new sfValidatorErrorSchema($validator, array("tipo" => new sfValidatorError($validator, "Debe seleccionar una gasolinera")));
      }
  }
 if ($tipoUsuario=='Empresa') {
      if (!$empresa) {
       throw new sfValidatorErrorSchema($validator, array("tipo" => new sfValidatorError($validator, "Debe seleccionar una empresa")));
      }
  }

   
  return $values;
 }

}