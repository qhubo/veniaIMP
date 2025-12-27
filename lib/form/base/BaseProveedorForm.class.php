<?php

/**
 * Proveedor form base class.
 *
 * @method Proveedor getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseProveedorForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'empresa_id'           => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'               => new sfWidgetFormInputText(),
      'nombre'               => new sfWidgetFormInputText(),
      'razon_social'         => new sfWidgetFormInputText(),
      'pequeno_contribuye'   => new sfWidgetFormInputCheckbox(),
      'regimen_isr'          => new sfWidgetFormInputText(),
      'direccion'            => new sfWidgetFormInputText(),
      'sitio_web'            => new sfWidgetFormInputText(),
      'telefono'             => new sfWidgetFormInputText(),
      'correo_electronico'   => new sfWidgetFormInputText(),
      'observaciones'        => new sfWidgetFormTextarea(),
      'nit'                  => new sfWidgetFormInputText(),
      'dias_credito'         => new sfWidgetFormInputText(),
      'tipo_proveedor'       => new sfWidgetFormInputText(),
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
      'token_visa'           => new sfWidgetFormTextarea(),
      'token_visa_test'      => new sfWidgetFormTextarea(),
      'epay_terminal'        => new sfWidgetFormInputText(),
      'epay_merchant'        => new sfWidgetFormInputText(),
      'epay_user'            => new sfWidgetFormInputText(),
      'epay_key'             => new sfWidgetFormInputText(),
      'test_visa'            => new sfWidgetFormInputCheckbox(),
      'merchand_id'          => new sfWidgetFormInputText(),
      'org_id'               => new sfWidgetFormInputText(),
      'numero_cliente_vol'   => new sfWidgetFormInputText(),
      'retiene_iva'          => new sfWidgetFormInputCheckbox(),
      'retine_isr'           => new sfWidgetFormInputCheckbox(),
      'exento_isr'           => new sfWidgetFormInputCheckbox(),
      'cuenta_contable'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'           => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'codigo'               => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'nombre'               => new sfValidatorString(array('max_length' => 260)),
      'razon_social'         => new sfValidatorString(array('max_length' => 160, 'required' => false)),
      'pequeno_contribuye'   => new sfValidatorBoolean(array('required' => false)),
      'regimen_isr'          => new sfValidatorString(array('max_length' => 160, 'required' => false)),
      'direccion'            => new sfValidatorString(array('max_length' => 160, 'required' => false)),
      'sitio_web'            => new sfValidatorString(array('max_length' => 260, 'required' => false)),
      'telefono'             => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'correo_electronico'   => new sfValidatorString(array('max_length' => 160, 'required' => false)),
      'observaciones'        => new sfValidatorString(array('required' => false)),
      'nit'                  => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'dias_credito'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tipo_proveedor'       => new sfValidatorString(array('max_length' => 120, 'required' => false)),
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
      'token_visa'           => new sfValidatorString(array('required' => false)),
      'token_visa_test'      => new sfValidatorString(array('required' => false)),
      'epay_terminal'        => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'epay_merchant'        => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'epay_user'            => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'epay_key'             => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'test_visa'            => new sfValidatorBoolean(array('required' => false)),
      'merchand_id'          => new sfValidatorString(array('max_length' => 260, 'required' => false)),
      'org_id'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'numero_cliente_vol'   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'retiene_iva'          => new sfValidatorBoolean(array('required' => false)),
      'retine_isr'           => new sfValidatorBoolean(array('required' => false)),
      'exento_isr'           => new sfValidatorBoolean(array('required' => false)),
      'cuenta_contable'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('proveedor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Proveedor';
  }


}
