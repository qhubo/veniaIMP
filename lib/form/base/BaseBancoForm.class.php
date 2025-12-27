<?php

/**
 * Banco form base class.
 *
 * @method Banco getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseBancoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'          => new sfWidgetFormInputText(),
      'nombre'          => new sfWidgetFormInputText(),
      'cuenta'          => new sfWidgetFormInputText(),
      'tipo_banco'      => new sfWidgetFormInputText(),
      'observaciones'   => new sfWidgetFormTextarea(),
      'activo'          => new sfWidgetFormInputCheckbox(),
      'cuenta_contable' => new sfWidgetFormInputText(),
      'nombre_banco_id' => new sfWidgetFormPropelChoice(array('model' => 'NombreBanco', 'add_empty' => true)),
      'pago_cheque'     => new sfWidgetFormInputCheckbox(),
      'dolares'         => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'      => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'codigo'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre'          => new sfValidatorString(array('max_length' => 150)),
      'cuenta'          => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'tipo_banco'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'observaciones'   => new sfValidatorString(array('required' => false)),
      'activo'          => new sfValidatorBoolean(array('required' => false)),
      'cuenta_contable' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre_banco_id' => new sfValidatorPropelChoice(array('model' => 'NombreBanco', 'column' => 'id', 'required' => false)),
      'pago_cheque'     => new sfValidatorBoolean(array('required' => false)),
      'dolares'         => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('banco[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Banco';
  }


}
