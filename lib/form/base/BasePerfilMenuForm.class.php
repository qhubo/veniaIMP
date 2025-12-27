<?php

/**
 * PerfilMenu form base class.
 *
 * @method PerfilMenu getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BasePerfilMenuForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'perfil_id'         => new sfWidgetFormPropelChoice(array('model' => 'Perfil', 'add_empty' => true)),
      'menu_seguridad_id' => new sfWidgetFormPropelChoice(array('model' => 'MenuSeguridad', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'perfil_id'         => new sfValidatorPropelChoice(array('model' => 'Perfil', 'column' => 'id', 'required' => false)),
      'menu_seguridad_id' => new sfValidatorPropelChoice(array('model' => 'MenuSeguridad', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('perfil_menu[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PerfilMenu';
  }


}
