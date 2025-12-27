<?php

/**
 * UsuarioLogueo form base class.
 *
 * @method UsuarioLogueo getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseUsuarioLogueoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'usuario' => new sfWidgetFormInputText(),
      'fecha'   => new sfWidgetFormDateTime(),
      'ip'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'usuario' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fecha'   => new sfValidatorDateTime(array('required' => false)),
      'ip'      => new sfValidatorString(array('max_length' => 15, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_logueo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioLogueo';
  }


}
