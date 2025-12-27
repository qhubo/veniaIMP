<?php

/**
 * CuentaProveedor form base class.
 *
 * @method CuentaProveedor getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseCuentaProveedorForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'empresa_id'         => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'orden_proveedor_id' => new sfWidgetFormPropelChoice(array('model' => 'OrdenProveedor', 'add_empty' => true)),
      'proveedor_id'       => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'fecha'              => new sfWidgetFormDate(),
      'detalle'            => new sfWidgetFormInputText(),
      'valor_total'        => new sfWidgetFormInputText(),
      'fecha_pago'         => new sfWidgetFormDate(),
      'valor_pagado'       => new sfWidgetFormInputText(),
      'cuenta_contable'    => new sfWidgetFormInputText(),
      'pagado'             => new sfWidgetFormInputCheckbox(),
      'updated_by'         => new sfWidgetFormInputText(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'gasto_id'           => new sfWidgetFormPropelChoice(array('model' => 'Gasto', 'add_empty' => true)),
      'contrasena_no'      => new sfWidgetFormInputText(),
      'seleccionado'       => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'         => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'orden_proveedor_id' => new sfValidatorPropelChoice(array('model' => 'OrdenProveedor', 'column' => 'id', 'required' => false)),
      'proveedor_id'       => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'fecha'              => new sfValidatorDate(array('required' => false)),
      'detalle'            => new sfValidatorString(array('max_length' => 350, 'required' => false)),
      'valor_total'        => new sfValidatorNumber(array('required' => false)),
      'fecha_pago'         => new sfValidatorDate(array('required' => false)),
      'valor_pagado'       => new sfValidatorNumber(array('required' => false)),
      'cuenta_contable'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'pagado'             => new sfValidatorBoolean(array('required' => false)),
      'updated_by'         => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
      'gasto_id'           => new sfValidatorPropelChoice(array('model' => 'Gasto', 'column' => 'id', 'required' => false)),
      'contrasena_no'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'seleccionado'       => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cuenta_proveedor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CuentaProveedor';
  }


}
