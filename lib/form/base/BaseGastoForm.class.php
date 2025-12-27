<?php

/**
 * Gasto form base class.
 *
 * @method Gasto getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseGastoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'codigo'             => new sfWidgetFormInputText(),
      'usuario'            => new sfWidgetFormInputText(),
      'excento'            => new sfWidgetFormInputCheckbox(),
      'empresa_id'         => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'proyecto_id'        => new sfWidgetFormPropelChoice(array('model' => 'Proyecto', 'add_empty' => true)),
      'proveedor_id'       => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'orden_proveedor_id' => new sfWidgetFormPropelChoice(array('model' => 'OrdenProveedor', 'add_empty' => true)),
      'fecha'              => new sfWidgetFormDateTime(),
      'tienda_id'          => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'estatus'            => new sfWidgetFormInputText(),
      'dias_credito'       => new sfWidgetFormInputText(),
      'tipo_documento'     => new sfWidgetFormInputText(),
      'documento'          => new sfWidgetFormInputText(),
      'sub_total'          => new sfWidgetFormInputText(),
      'iva'                => new sfWidgetFormInputText(),
      'valor_total'        => new sfWidgetFormInputText(),
      'partida_no'         => new sfWidgetFormInputText(),
      'token'              => new sfWidgetFormInputText(),
      'observaciones'      => new sfWidgetFormTextarea(),
      'created_by'         => new sfWidgetFormInputText(),
      'updated_by'         => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'valor_pagado'       => new sfWidgetFormInputText(),
      'aplica_isr'         => new sfWidgetFormInputCheckbox(),
      'aplica_iva'         => new sfWidgetFormInputCheckbox(),
      'valor_impuesto'     => new sfWidgetFormInputText(),
      'excento_isr'        => new sfWidgetFormInputCheckbox(),
      'valor_isr'          => new sfWidgetFormInputText(),
      'valor_retiene_iva'  => new sfWidgetFormInputText(),
      'retiene_iva'        => new sfWidgetFormInputCheckbox(),
      'valor_retenido_iva' => new sfWidgetFormInputText(),
      'confrontado_sat'    => new sfWidgetFormInputCheckbox(),
      'no_sat'             => new sfWidgetFormInputText(),
      'valor_idp'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'usuario'            => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'excento'            => new sfValidatorBoolean(array('required' => false)),
      'empresa_id'         => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'proyecto_id'        => new sfValidatorPropelChoice(array('model' => 'Proyecto', 'column' => 'id', 'required' => false)),
      'proveedor_id'       => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'orden_proveedor_id' => new sfValidatorPropelChoice(array('model' => 'OrdenProveedor', 'column' => 'id', 'required' => false)),
      'fecha'              => new sfValidatorDateTime(array('required' => false)),
      'tienda_id'          => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'estatus'            => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'dias_credito'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tipo_documento'     => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'documento'          => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'sub_total'          => new sfValidatorNumber(array('required' => false)),
      'iva'                => new sfValidatorNumber(array('required' => false)),
      'valor_total'        => new sfValidatorNumber(array('required' => false)),
      'partida_no'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'token'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'observaciones'      => new sfValidatorString(array('required' => false)),
      'created_by'         => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'         => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
      'valor_pagado'       => new sfValidatorNumber(array('required' => false)),
      'aplica_isr'         => new sfValidatorBoolean(array('required' => false)),
      'aplica_iva'         => new sfValidatorBoolean(array('required' => false)),
      'valor_impuesto'     => new sfValidatorNumber(array('required' => false)),
      'excento_isr'        => new sfValidatorBoolean(array('required' => false)),
      'valor_isr'          => new sfValidatorNumber(array('required' => false)),
      'valor_retiene_iva'  => new sfValidatorNumber(array('required' => false)),
      'retiene_iva'        => new sfValidatorBoolean(array('required' => false)),
      'valor_retenido_iva' => new sfValidatorNumber(array('required' => false)),
      'confrontado_sat'    => new sfValidatorBoolean(array('required' => false)),
      'no_sat'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'valor_idp'          => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('gasto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Gasto';
  }


}
