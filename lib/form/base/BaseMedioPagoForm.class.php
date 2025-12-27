<?php

/**
 * MedioPago form base class.
 *
 * @method MedioPago getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseMedioPagoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'           => new sfWidgetFormInputText(),
      'nombre'           => new sfWidgetFormInputText(),
      'activo'           => new sfWidgetFormInputCheckbox(),
      'cuenta_contable'  => new sfWidgetFormInputText(),
      'orden'            => new sfWidgetFormInputText(),
      'pos'              => new sfWidgetFormInputCheckbox(),
      'aplica_mov_banco' => new sfWidgetFormInputCheckbox(),
      'created_by'       => new sfWidgetFormInputText(),
      'updated_by'       => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'aplica_cuotas'    => new sfWidgetFormInputCheckbox(),
      'numero_cuotas'    => new sfWidgetFormInputText(),
      'comision'         => new sfWidgetFormInputText(),
      'retiene_isr'      => new sfWidgetFormInputCheckbox(),
      'pide_banco'       => new sfWidgetFormInputCheckbox(),
      'banco_id'         => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'pago_proveedor'   => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'codigo'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre'           => new sfValidatorString(array('max_length' => 150)),
      'activo'           => new sfValidatorBoolean(array('required' => false)),
      'cuenta_contable'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'orden'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'pos'              => new sfValidatorBoolean(array('required' => false)),
      'aplica_mov_banco' => new sfValidatorBoolean(array('required' => false)),
      'created_by'       => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'       => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
      'aplica_cuotas'    => new sfValidatorBoolean(array('required' => false)),
      'numero_cuotas'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'comision'         => new sfValidatorNumber(array('required' => false)),
      'retiene_isr'      => new sfValidatorBoolean(array('required' => false)),
      'pide_banco'       => new sfValidatorBoolean(array('required' => false)),
      'banco_id'         => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
      'pago_proveedor'   => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('medio_pago[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MedioPago';
  }


}
