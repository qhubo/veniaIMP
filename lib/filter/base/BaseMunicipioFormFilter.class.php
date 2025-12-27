<?php

/**
 * Municipio filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseMunicipioFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'departamento_id' => new sfWidgetFormPropelChoice(array('model' => 'Departamento', 'add_empty' => true)),
      'descripcion'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'abreviatura'     => new sfWidgetFormFilterInput(),
      'codigo_postal'   => new sfWidgetFormFilterInput(),
      'activo'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'observaciones'   => new sfWidgetFormFilterInput(),
      'created_by'      => new sfWidgetFormFilterInput(),
      'updated_by'      => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'codigo_cargo'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'departamento_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Departamento', 'column' => 'id')),
      'descripcion'     => new sfValidatorPass(array('required' => false)),
      'abreviatura'     => new sfValidatorPass(array('required' => false)),
      'codigo_postal'   => new sfValidatorPass(array('required' => false)),
      'activo'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'observaciones'   => new sfValidatorPass(array('required' => false)),
      'created_by'      => new sfValidatorPass(array('required' => false)),
      'updated_by'      => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'codigo_cargo'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('municipio_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Municipio';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'departamento_id' => 'ForeignKey',
      'descripcion'     => 'Text',
      'abreviatura'     => 'Text',
      'codigo_postal'   => 'Text',
      'activo'          => 'Boolean',
      'observaciones'   => 'Text',
      'created_by'      => 'Text',
      'updated_by'      => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'codigo_cargo'    => 'Text',
    );
  }
}
