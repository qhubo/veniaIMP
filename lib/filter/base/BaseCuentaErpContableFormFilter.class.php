<?php

/**
 * CuentaErpContable filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseCuentaErpContableFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tipo'            => new sfWidgetFormFilterInput(),
      'campo'           => new sfWidgetFormFilterInput(),
      'nombre'          => new sfWidgetFormFilterInput(),
      'cuenta_contable' => new sfWidgetFormFilterInput(),
      'fecha_inicio'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'saldo_inicio'    => new sfWidgetFormFilterInput(),
      'created_by'      => new sfWidgetFormFilterInput(),
      'updated_by'      => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'tipo'            => new sfValidatorPass(array('required' => false)),
      'campo'           => new sfValidatorPass(array('required' => false)),
      'nombre'          => new sfValidatorPass(array('required' => false)),
      'cuenta_contable' => new sfValidatorPass(array('required' => false)),
      'fecha_inicio'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'saldo_inicio'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_by'      => new sfValidatorPass(array('required' => false)),
      'updated_by'      => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'empresa_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('cuenta_erp_contable_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CuentaErpContable';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'tipo'            => 'Text',
      'campo'           => 'Text',
      'nombre'          => 'Text',
      'cuenta_contable' => 'Text',
      'fecha_inicio'    => 'Date',
      'saldo_inicio'    => 'Number',
      'created_by'      => 'Text',
      'updated_by'      => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'empresa_id'      => 'ForeignKey',
    );
  }
}
