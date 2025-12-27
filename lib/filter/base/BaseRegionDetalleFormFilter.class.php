<?php

/**
 * RegionDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseRegionDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'departamento_id' => new sfWidgetFormPropelChoice(array('model' => 'Departamento', 'add_empty' => true)),
      'region_id'       => new sfWidgetFormPropelChoice(array('model' => 'Region', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'departamento_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Departamento', 'column' => 'id')),
      'region_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Region', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('region_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RegionDetalle';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'departamento_id' => 'ForeignKey',
      'region_id'       => 'ForeignKey',
    );
  }
}
