<?php

/**
 * Parametro form base class.
 *
 * @method Parametro getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseParametroForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'logo'           => new sfWidgetFormInputText(),
      'puerto_correo'  => new sfWidgetFormInputText(),
      'smtp_correo'    => new sfWidgetFormInputText(),
      'usuario_correo' => new sfWidgetFormInputText(),
      'clave_correo'   => new sfWidgetFormInputText(),
      'bienvenida'     => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'logo'           => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'puerto_correo'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'smtp_correo'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'usuario_correo' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'clave_correo'   => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'bienvenida'     => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('parametro[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Parametro';
  }


}
