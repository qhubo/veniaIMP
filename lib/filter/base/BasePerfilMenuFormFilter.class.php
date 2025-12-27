<?php

/**
 * PerfilMenu filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BasePerfilMenuFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'perfil_id'         => new sfWidgetFormPropelChoice(array('model' => 'Perfil', 'add_empty' => true)),
      'menu_seguridad_id' => new sfWidgetFormPropelChoice(array('model' => 'MenuSeguridad', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'perfil_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Perfil', 'column' => 'id')),
      'menu_seguridad_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'MenuSeguridad', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('perfil_menu_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PerfilMenu';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'perfil_id'         => 'ForeignKey',
      'menu_seguridad_id' => 'ForeignKey',
    );
  }
}
