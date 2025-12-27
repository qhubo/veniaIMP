<?php

/**
 * CuentaErpContable form base class.
 *
 * @method CuentaErpContable getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseCuentaErpContableForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'tipo'            => new sfWidgetFormInputText(),
      'campo'           => new sfWidgetFormInputText(),
      'nombre'          => new sfWidgetFormInputText(),
      'cuenta_contable' => new sfWidgetFormInputText(),
      'fecha_inicio'    => new sfWidgetFormDate(),
      'saldo_inicio'    => new sfWidgetFormInputText(),
      'created_by'      => new sfWidgetFormInputText(),
      'updated_by'      => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'tipo'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'campo'           => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'nombre'          => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'cuenta_contable' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_inicio'    => new sfValidatorDate(array('required' => false)),
      'saldo_inicio'    => new sfValidatorNumber(array('required' => false)),
      'created_by'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
      'empresa_id'      => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cuenta_erp_contable[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CuentaErpContable';
  }


}
