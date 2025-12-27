<?php

/**
 * BancoSaldo form base class.
 *
 * @method BancoSaldo getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseBancoSaldoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'codigo'               => new sfWidgetFormInputText(),
      'banco_id'             => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'moneda_id'            => new sfWidgetFormPropelChoice(array('model' => 'Moneda', 'add_empty' => true)),
      'nombre'               => new sfWidgetFormInputText(),
      'saldo'                => new sfWidgetFormInputText(),
      'ultima_actualizacion' => new sfWidgetFormDateTime(),
      'ultimo_movimiento'    => new sfWidgetFormInputText(),
      'empresa_id'           => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'banco_id'             => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
      'moneda_id'            => new sfValidatorPropelChoice(array('model' => 'Moneda', 'column' => 'id', 'required' => false)),
      'nombre'               => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'saldo'                => new sfValidatorNumber(array('required' => false)),
      'ultima_actualizacion' => new sfValidatorDateTime(array('required' => false)),
      'ultimo_movimiento'    => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'empresa_id'           => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('banco_saldo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BancoSaldo';
  }


}
