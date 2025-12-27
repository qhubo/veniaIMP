<?php

/**
 * RegionDetalle form base class.
 *
 * @method RegionDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseRegionDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'departamento_id' => new sfWidgetFormPropelChoice(array('model' => 'Departamento', 'add_empty' => true)),
      'region_id'       => new sfWidgetFormPropelChoice(array('model' => 'Region', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'departamento_id' => new sfValidatorPropelChoice(array('model' => 'Departamento', 'column' => 'id', 'required' => false)),
      'region_id'       => new sfValidatorPropelChoice(array('model' => 'Region', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('region_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RegionDetalle';
  }


}
