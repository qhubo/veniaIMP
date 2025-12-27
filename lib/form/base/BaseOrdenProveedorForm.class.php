<?php

/**
 * OrdenProveedor form base class.
 *
 * @method OrdenProveedor getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseOrdenProveedorForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'codigo'                => new sfWidgetFormInputText(),
      'empresa_id'            => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'proveedor_id'          => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'nit'                   => new sfWidgetFormInputText(),
      'nombre'                => new sfWidgetFormInputText(),
      'no_documento'          => new sfWidgetFormInputText(),
      'fecha_documento'       => new sfWidgetFormDate(),
      'fecha_contabilizacion' => new sfWidgetFormDate(),
      'fecha'                 => new sfWidgetFormDateTime(),
      'dia_credito'           => new sfWidgetFormInputText(),
      'excento'               => new sfWidgetFormInputCheckbox(),
      'usuario'               => new sfWidgetFormInputText(),
      'estatus'               => new sfWidgetFormInputText(),
      'comentario'            => new sfWidgetFormInputText(),
      'sub_total'             => new sfWidgetFormInputText(),
      'iva'                   => new sfWidgetFormInputText(),
      'valor_total'           => new sfWidgetFormInputText(),
      'partida_no'            => new sfWidgetFormInputText(),
      'tienda_id'             => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'serie'                 => new sfWidgetFormInputText(),
      'token'                 => new sfWidgetFormInputText(),
      'usuario_confirmo'      => new sfWidgetFormInputText(),
      'fecha_confirmo'        => new sfWidgetFormDateTime(),
      'despacho'              => new sfWidgetFormInputCheckbox(),
      'valor_pagado'          => new sfWidgetFormInputText(),
      'aplica_isr'            => new sfWidgetFormInputCheckbox(),
      'aplica_iva'            => new sfWidgetFormInputCheckbox(),
      'valor_impuesto'        => new sfWidgetFormInputText(),
      'excento_isr'           => new sfWidgetFormInputCheckbox(),
      'valor_isr'             => new sfWidgetFormInputText(),
      'valor_retiene_iva'     => new sfWidgetFormInputText(),
      'confrontado_sat'       => new sfWidgetFormInputCheckbox(),
      'no_sat'                => new sfWidgetFormInputText(),
      'impuesto_gas'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'empresa_id'            => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'proveedor_id'          => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'nit'                   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre'                => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'no_documento'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_documento'       => new sfValidatorDate(array('required' => false)),
      'fecha_contabilizacion' => new sfValidatorDate(array('required' => false)),
      'fecha'                 => new sfValidatorDateTime(array('required' => false)),
      'dia_credito'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'excento'               => new sfValidatorBoolean(array('required' => false)),
      'usuario'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'estatus'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'comentario'            => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'sub_total'             => new sfValidatorNumber(array('required' => false)),
      'iva'                   => new sfValidatorNumber(array('required' => false)),
      'valor_total'           => new sfValidatorNumber(array('required' => false)),
      'partida_no'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tienda_id'             => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'serie'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'token'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'usuario_confirmo'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_confirmo'        => new sfValidatorDateTime(array('required' => false)),
      'despacho'              => new sfValidatorBoolean(array('required' => false)),
      'valor_pagado'          => new sfValidatorNumber(array('required' => false)),
      'aplica_isr'            => new sfValidatorBoolean(array('required' => false)),
      'aplica_iva'            => new sfValidatorBoolean(array('required' => false)),
      'valor_impuesto'        => new sfValidatorNumber(array('required' => false)),
      'excento_isr'           => new sfValidatorBoolean(array('required' => false)),
      'valor_isr'             => new sfValidatorNumber(array('required' => false)),
      'valor_retiene_iva'     => new sfValidatorNumber(array('required' => false)),
      'confrontado_sat'       => new sfValidatorBoolean(array('required' => false)),
      'no_sat'                => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'impuesto_gas'          => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('orden_proveedor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenProveedor';
  }


}
