<?php

/**
 * BitacoraCambio form base class.
 *
 * @method BitacoraCambio getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseBitacoraCambioForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'tipo'           => new sfWidgetFormInputText(),
      'observaciones'  => new sfWidgetFormInputText(),
      'fecha'          => new sfWidgetFormDateTime(),
      'usuario'        => new sfWidgetFormInputText(),
      'revisado'       => new sfWidgetFormInputCheckbox(),
      'usuario_reviso' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'tipo'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'observaciones'  => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'fecha'          => new sfValidatorDateTime(array('required' => false)),
      'usuario'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'revisado'       => new sfValidatorBoolean(array('required' => false)),
      'usuario_reviso' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('bitacora_cambio[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BitacoraCambio';
  }


}
