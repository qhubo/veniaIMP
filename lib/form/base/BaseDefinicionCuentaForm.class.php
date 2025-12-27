<?php

/**
 * DefinicionCuenta form base class.
 *
 * @method DefinicionCuenta getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseDefinicionCuentaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'grupo'           => new sfWidgetFormInputText(),
      'tipo'            => new sfWidgetFormInputText(),
      'cuenta_contable' => new sfWidgetFormInputText(),
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'detalle'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'grupo'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'tipo'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'cuenta_contable' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'empresa_id'      => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'detalle'         => new sfValidatorString(array('max_length' => 150, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('definicion_cuenta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DefinicionCuenta';
  }


}
