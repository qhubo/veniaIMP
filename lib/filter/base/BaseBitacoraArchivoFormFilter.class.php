<?php

/**
 * BitacoraArchivo filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseBitacoraArchivoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tipo'            => new sfWidgetFormFilterInput(),
      'nombre'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nombre_original' => new sfWidgetFormFilterInput(),
      'created_by'      => new sfWidgetFormFilterInput(),
      'updated_by'      => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'carpeta'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'tipo'            => new sfValidatorPass(array('required' => false)),
      'nombre'          => new sfValidatorPass(array('required' => false)),
      'nombre_original' => new sfValidatorPass(array('required' => false)),
      'created_by'      => new sfValidatorPass(array('required' => false)),
      'updated_by'      => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'empresa_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'carpeta'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('bitacora_archivo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BitacoraArchivo';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'tipo'            => 'Text',
      'nombre'          => 'Text',
      'nombre_original' => 'Text',
      'created_by'      => 'Text',
      'updated_by'      => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'empresa_id'      => 'ForeignKey',
      'carpeta'         => 'Text',
    );
  }
}
