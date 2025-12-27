<?php

/**
 * CuentaBanco form base class.
 *
 * @method CuentaBanco getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseCuentaBancoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'banco_id'            => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'movimiento_banco_id' => new sfWidgetFormPropelChoice(array('model' => 'MovimientoBanco', 'add_empty' => true)),
      'valor'               => new sfWidgetFormInputText(),
      'fecha'               => new sfWidgetFormDate(),
      'documento'           => new sfWidgetFormInputText(),
      'observaciones'       => new sfWidgetFormInputText(),
      'usuario'             => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'estatus'             => new sfWidgetFormInputText(),
      'operacion_pago_id'   => new sfWidgetFormPropelChoice(array('model' => 'OperacionPago', 'add_empty' => true)),
      'empresa_id'          => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'banco_id'            => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
      'movimiento_banco_id' => new sfValidatorPropelChoice(array('model' => 'MovimientoBanco', 'column' => 'id', 'required' => false)),
      'valor'               => new sfValidatorNumber(array('required' => false)),
      'fecha'               => new sfValidatorDate(array('required' => false)),
      'documento'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'observaciones'       => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'usuario'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'updated_at'          => new sfValidatorDateTime(array('required' => false)),
      'estatus'             => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'operacion_pago_id'   => new sfValidatorPropelChoice(array('model' => 'OperacionPago', 'column' => 'id', 'required' => false)),
      'empresa_id'          => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cuenta_banco[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CuentaBanco';
  }


}
