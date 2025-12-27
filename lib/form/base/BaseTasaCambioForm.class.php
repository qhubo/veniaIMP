<?php

/**
 * TasaCambio form base class.
 *
 * @method TasaCambio getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseTasaCambioForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'    => new sfWidgetFormInputHidden(),
      'fecha' => new sfWidgetFormDate(),
      'valor' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'fecha' => new sfValidatorDate(array('required' => false)),
      'valor' => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tasa_cambio[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TasaCambio';
  }


}
