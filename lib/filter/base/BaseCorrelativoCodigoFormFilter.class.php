<?php

/**
 * CorrelativoCodigo filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseCorrelativoCodigoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'numero_asginar' => new sfWidgetFormFilterInput(),
      'prefijo'        => new sfWidgetFormFilterInput(),
      'tipo'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'numero_asginar' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'prefijo'        => new sfValidatorPass(array('required' => false)),
      'tipo'           => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('correlativo_codigo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CorrelativoCodigo';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'numero_asginar' => 'Number',
      'prefijo'        => 'Text',
      'tipo'           => 'Text',
    );
  }
}
