<?php

/**
 * ParametroCuenta filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseParametroCuentaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tipo'           => new sfWidgetFormFilterInput(),
      'empresa_id'     => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'cuenta_default' => new sfWidgetFormFilterInput(),
      'created_by'     => new sfWidgetFormFilterInput(),
      'updated_by'     => new sfWidgetFormFilterInput(),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'tipo'           => new sfValidatorPass(array('required' => false)),
      'empresa_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'cuenta_default' => new sfValidatorPass(array('required' => false)),
      'created_by'     => new sfValidatorPass(array('required' => false)),
      'updated_by'     => new sfValidatorPass(array('required' => false)),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('parametro_cuenta_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ParametroCuenta';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'tipo'           => 'Text',
      'empresa_id'     => 'ForeignKey',
      'cuenta_default' => 'Text',
      'created_by'     => 'Text',
      'updated_by'     => 'Text',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
