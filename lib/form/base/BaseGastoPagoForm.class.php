<?php

/**
 * GastoPago form base class.
 *
 * @method GastoPago getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseGastoPagoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'codigo'              => new sfWidgetFormInputText(),
      'empresa_id'          => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'proveedor_id'        => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'gasto_id'            => new sfWidgetFormPropelChoice(array('model' => 'Gasto', 'add_empty' => true)),
      'tipo_pago'           => new sfWidgetFormInputText(),
      'documento'           => new sfWidgetFormInputText(),
      'fecha'               => new sfWidgetFormDate(),
      'valor_total'         => new sfWidgetFormInputText(),
      'usuario'             => new sfWidgetFormInputText(),
      'fecha_creo'          => new sfWidgetFormDateTime(),
      'cuenta_proveedor_id' => new sfWidgetFormPropelChoice(array('model' => 'CuentaProveedor', 'add_empty' => true)),
      'banco_id'            => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'created_by'          => new sfWidgetFormInputText(),
      'updated_by'          => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'cuenta_contable'     => new sfWidgetFormInputText(),
      'partida_no'          => new sfWidgetFormInputText(),
      'cheque_id'           => new sfWidgetFormPropelChoice(array('model' => 'Cheque', 'add_empty' => true)),
      'temporal'            => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'empresa_id'          => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'proveedor_id'        => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'gasto_id'            => new sfValidatorPropelChoice(array('model' => 'Gasto', 'column' => 'id', 'required' => false)),
      'tipo_pago'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'documento'           => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'fecha'               => new sfValidatorDate(array('required' => false)),
      'valor_total'         => new sfValidatorNumber(array('required' => false)),
      'usuario'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_creo'          => new sfValidatorDateTime(array('required' => false)),
      'cuenta_proveedor_id' => new sfValidatorPropelChoice(array('model' => 'CuentaProveedor', 'column' => 'id', 'required' => false)),
      'banco_id'            => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
      'created_by'          => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'          => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'cuenta_contable'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'partida_no'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'cheque_id'           => new sfValidatorPropelChoice(array('model' => 'Cheque', 'column' => 'id', 'required' => false)),
      'temporal'            => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('gasto_pago[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'GastoPago';
  }


}
