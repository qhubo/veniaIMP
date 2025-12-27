<?php

/**
 * SaldoBanco form base class.
 *
 * @method SaldoBanco getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseSaldoBancoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'fecha'             => new sfWidgetFormDate(),
      'saldo_libro'       => new sfWidgetFormInputText(),
      'banco_id'          => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'usuario'           => new sfWidgetFormInputText(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'saldo_banco'       => new sfWidgetFormInputText(),
      'saldo_conciliado'  => new sfWidgetFormInputText(),
      'diferencia'        => new sfWidgetFormInputText(),
      'fecha_docu'        => new sfWidgetFormDate(),
      'deposito_transito' => new sfWidgetFormInputText(),
      'nota_credito'      => new sfWidgetFormInputText(),
      'cheques_circula'   => new sfWidgetFormInputText(),
      'nota_transito'     => new sfWidgetFormInputText(),
      'diferencial'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'fecha'             => new sfValidatorDate(array('required' => false)),
      'saldo_libro'       => new sfValidatorNumber(array('required' => false)),
      'banco_id'          => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
      'usuario'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at'        => new sfValidatorDateTime(array('required' => false)),
      'updated_at'        => new sfValidatorDateTime(array('required' => false)),
      'saldo_banco'       => new sfValidatorNumber(array('required' => false)),
      'saldo_conciliado'  => new sfValidatorNumber(array('required' => false)),
      'diferencia'        => new sfValidatorNumber(array('required' => false)),
      'fecha_docu'        => new sfValidatorDate(array('required' => false)),
      'deposito_transito' => new sfValidatorNumber(array('required' => false)),
      'nota_credito'      => new sfValidatorNumber(array('required' => false)),
      'cheques_circula'   => new sfValidatorNumber(array('required' => false)),
      'nota_transito'     => new sfValidatorNumber(array('required' => false)),
      'diferencial'       => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('saldo_banco[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SaldoBanco';
  }


}
