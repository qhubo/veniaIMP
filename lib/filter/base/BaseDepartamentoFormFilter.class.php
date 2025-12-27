<?php

/**
 * Departamento filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseDepartamentoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'pais_id'       => new sfWidgetFormPropelChoice(array('model' => 'Pais', 'add_empty' => true)),
      'codigo'        => new sfWidgetFormFilterInput(),
      'nombre'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'activo'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_by'    => new sfWidgetFormFilterInput(),
      'updated_by'    => new sfWidgetFormFilterInput(),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'observaciones' => new sfWidgetFormFilterInput(),
      'codigo_cargo'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'pais_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Pais', 'column' => 'id')),
      'codigo'        => new sfValidatorPass(array('required' => false)),
      'nombre'        => new sfValidatorPass(array('required' => false)),
      'activo'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_by'    => new sfValidatorPass(array('required' => false)),
      'updated_by'    => new sfValidatorPass(array('required' => false)),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'observaciones' => new sfValidatorPass(array('required' => false)),
      'codigo_cargo'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('departamento_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Departamento';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'pais_id'       => 'ForeignKey',
      'codigo'        => 'Text',
      'nombre'        => 'Text',
      'activo'        => 'Boolean',
      'created_by'    => 'Text',
      'updated_by'    => 'Text',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
      'observaciones' => 'Text',
      'codigo_cargo'  => 'Text',
    );
  }
}
