<?php

/**
 * CierreCheck filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseCierreCheckFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'check_lista_id' => new sfWidgetFormPropelChoice(array('model' => 'CheckLista', 'add_empty' => true)),
      'cierre_caja_id' => new sfWidgetFormPropelChoice(array('model' => 'CierreCaja', 'add_empty' => true)),
      'cierre_dia_id'  => new sfWidgetFormPropelChoice(array('model' => 'Cierre', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'check_lista_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'CheckLista', 'column' => 'id')),
      'cierre_caja_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'CierreCaja', 'column' => 'id')),
      'cierre_dia_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Cierre', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('cierre_check_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CierreCheck';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'check_lista_id' => 'ForeignKey',
      'cierre_caja_id' => 'ForeignKey',
      'cierre_dia_id'  => 'ForeignKey',
    );
  }
}
