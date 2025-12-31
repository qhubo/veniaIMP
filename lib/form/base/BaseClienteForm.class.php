<?php

/**
 * Cliente form base class.
 *
 * @method Cliente getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseClienteForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'empresa_id'           => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'               => new sfWidgetFormInputText(),
      'nombre'               => new sfWidgetFormInputText(),
      'pequeno_contribuye'   => new sfWidgetFormInputCheckbox(),
      'regimen_isr'          => new sfWidgetFormInputCheckbox(),
      'direccion'            => new sfWidgetFormInputText(),
      'telefono'             => new sfWidgetFormInputText(),
      'correo_electronico'   => new sfWidgetFormInputText(),
      'observaciones'        => new sfWidgetFormTextarea(),
      'nit'                  => new sfWidgetFormInputText(),
      'dias_credito'         => new sfWidgetFormInputText(),
      'tipo_referencia'      => new sfWidgetFormInputText(),
      'activo'               => new sfWidgetFormInputCheckbox(),
      'tiene_credito'        => new sfWidgetFormInputCheckbox(),
      'avenida_calle'        => new sfWidgetFormInputText(),
      'zona'                 => new sfWidgetFormInputText(),
      'departamento_id'      => new sfWidgetFormPropelChoice(array('model' => 'Departamento', 'add_empty' => true)),
      'municipio_id'         => new sfWidgetFormPropelChoice(array('model' => 'Municipio', 'add_empty' => true)),
      'contacto'             => new sfWidgetFormInputText(),
      'correo_contacto'      => new sfWidgetFormInputText(),
      'imagen'               => new sfWidgetFormInputText(),
      'telefono_contacto'    => new sfWidgetFormInputText(),
      'tipificacion'         => new sfWidgetFormInputText(),
      'fecha'                => new sfWidgetFormDateTime(),
      'tipo_producto'        => new sfWidgetFormInputText(),
      'porcentaje_negociado' => new sfWidgetFormInputText(),
      'limite_credito'       => new sfWidgetFormInputText(),
      'pais_id'              => new sfWidgetFormPropelChoice(array('model' => 'Pais', 'add_empty' => true)),
      'nombre_facturar'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'           => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'codigo'               => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'nombre'               => new sfValidatorString(array('max_length' => 260)),
      'pequeno_contribuye'   => new sfValidatorBoolean(array('required' => false)),
      'regimen_isr'          => new sfValidatorBoolean(array('required' => false)),
      'direccion'            => new sfValidatorString(array('max_length' => 160, 'required' => false)),
      'telefono'             => new sfValidatorString(array('max_length' => 260, 'required' => false)),
      'correo_electronico'   => new sfValidatorString(array('max_length' => 160, 'required' => false)),
      'observaciones'        => new sfValidatorString(array('required' => false)),
      'nit'                  => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'dias_credito'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tipo_referencia'      => new sfValidatorString(array('max_length' => 120, 'required' => false)),
      'activo'               => new sfValidatorBoolean(array('required' => false)),
      'tiene_credito'        => new sfValidatorBoolean(array('required' => false)),
      'avenida_calle'        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'zona'                 => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'departamento_id'      => new sfValidatorPropelChoice(array('model' => 'Departamento', 'column' => 'id', 'required' => false)),
      'municipio_id'         => new sfValidatorPropelChoice(array('model' => 'Municipio', 'column' => 'id', 'required' => false)),
      'contacto'             => new sfValidatorString(array('max_length' => 160, 'required' => false)),
      'correo_contacto'      => new sfValidatorString(array('max_length' => 160, 'required' => false)),
      'imagen'               => new sfValidatorString(array('max_length' => 160, 'required' => false)),
      'telefono_contacto'    => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'tipificacion'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'fecha'                => new sfValidatorDateTime(array('required' => false)),
      'tipo_producto'        => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'porcentaje_negociado' => new sfValidatorNumber(array('required' => false)),
      'limite_credito'       => new sfValidatorNumber(array('required' => false)),
      'pais_id'              => new sfValidatorPropelChoice(array('model' => 'Pais', 'column' => 'id', 'required' => false)),
      'nombre_facturar'      => new sfValidatorString(array('max_length' => 260, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cliente[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cliente';
  }


}
