<?php

/**
 * CierreCajaValor form base class.
 *
 * @method CierreCajaValor getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseCierreCajaValorForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'cierre_caja_id' => new sfWidgetFormPropelChoice(array('model' => 'CierreCaja', 'add_empty' => true)),
      'medio_pago'     => new sfWidgetFormInputText(),
      'valor'          => new sfWidgetFormInputText(),
      'documento'      => new sfWidgetFormInputText(),
      'banco_id'       => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'cierre_caja_id' => new sfValidatorPropelChoice(array('model' => 'CierreCaja', 'column' => 'id', 'required' => false)),
      'medio_pago'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'valor'          => new sfValidatorNumber(array('required' => false)),
      'documento'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'banco_id'       => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cierre_caja_valor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CierreCajaValor';
  }


}
