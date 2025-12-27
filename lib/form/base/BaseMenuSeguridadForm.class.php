<?php

/**
 * MenuSeguridad form base class.
 *
 * @method MenuSeguridad getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseMenuSeguridadForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'descripcion' => new sfWidgetFormInputText(),
      'credencial'  => new sfWidgetFormInputText(),
      'modulo'      => new sfWidgetFormInputText(),
      'icono'       => new sfWidgetFormInputText(),
      'accion'      => new sfWidgetFormInputText(),
      'superior'    => new sfWidgetFormInputText(),
      'orden'       => new sfWidgetFormInputText(),
      'sub_menu'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'descripcion' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'credencial'  => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'modulo'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'icono'       => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'accion'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'superior'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'orden'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'sub_menu'    => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('menu_seguridad[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MenuSeguridad';
  }


}
