<?php

/**
 * TemporalCompara filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseTemporalComparaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'indicador' => new sfWidgetFormFilterInput(),
      'valor'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'indicador' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'valor'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('temporal_compara_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TemporalCompara';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'indicador' => 'Number',
      'valor'     => 'Text',
    );
  }
}
