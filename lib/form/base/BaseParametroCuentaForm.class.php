<?php

/**
 * ParametroCuenta form base class.
 *
 * @method ParametroCuenta getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseParametroCuentaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'tipo'           => new sfWidgetFormInputText(),
      'empresa_id'     => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'cuenta_default' => new sfWidgetFormInputText(),
      'created_by'     => new sfWidgetFormInputText(),
      'updated_by'     => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'tipo'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'empresa_id'     => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'cuenta_default' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_by'     => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'     => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('parametro_cuenta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ParametroCuenta';
  }


}
