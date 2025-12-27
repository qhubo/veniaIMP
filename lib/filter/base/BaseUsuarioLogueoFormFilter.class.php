<?php

/**
 * UsuarioLogueo filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseUsuarioLogueoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario' => new sfWidgetFormFilterInput(),
      'fecha'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'ip'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'usuario' => new sfValidatorPass(array('required' => false)),
      'fecha'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'ip'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_logueo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioLogueo';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'usuario' => 'Text',
      'fecha'   => 'Date',
      'ip'      => 'Text',
    );
  }
}
