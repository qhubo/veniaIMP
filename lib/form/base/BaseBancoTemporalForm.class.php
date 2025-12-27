<?php

/**
 * BancoTemporal form base class.
 *
 * @method BancoTemporal getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseBancoTemporalForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'empresa_id'             => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'fecha'                  => new sfWidgetFormDate(),
      'banco_id'               => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'saldo_banco'            => new sfWidgetFormInputText(),
      'deposito_transito'      => new sfWidgetFormInputText(),
      'nota_credito_transito'  => new sfWidgetFormInputText(),
      'cheques_circulacion'    => new sfWidgetFormInputText(),
      'nota_debito_transito'   => new sfWidgetFormInputText(),
      'saldo_libros'           => new sfWidgetFormInputText(),
      'deposito_registrar'     => new sfWidgetFormInputText(),
      'nota_credito_registrar' => new sfWidgetFormInputText(),
      'cheques_registrar'      => new sfWidgetFormInputText(),
      'nota_debito_registrar'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'             => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'fecha'                  => new sfValidatorDate(array('required' => false)),
      'banco_id'               => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
      'saldo_banco'            => new sfValidatorNumber(array('required' => false)),
      'deposito_transito'      => new sfValidatorNumber(array('required' => false)),
      'nota_credito_transito'  => new sfValidatorNumber(array('required' => false)),
      'cheques_circulacion'    => new sfValidatorNumber(array('required' => false)),
      'nota_debito_transito'   => new sfValidatorNumber(array('required' => false)),
      'saldo_libros'           => new sfValidatorNumber(array('required' => false)),
      'deposito_registrar'     => new sfValidatorNumber(array('required' => false)),
      'nota_credito_registrar' => new sfValidatorNumber(array('required' => false)),
      'cheques_registrar'      => new sfValidatorNumber(array('required' => false)),
      'nota_debito_registrar'  => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('banco_temporal[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BancoTemporal';
  }


}
