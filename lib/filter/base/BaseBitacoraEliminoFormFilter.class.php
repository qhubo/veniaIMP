<?php

/**
 * BitacoraElimino filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseBitacoraEliminoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tipo'          => new sfWidgetFormFilterInput(),
      'codigo'        => new sfWidgetFormFilterInput(),
      'fecha'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'observaciones' => new sfWidgetFormFilterInput(),
      'datos'         => new sfWidgetFormFilterInput(),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'usuario'       => new sfWidgetFormFilterInput(),
      'created_by'    => new sfWidgetFormFilterInput(),
      'updated_by'    => new sfWidgetFormFilterInput(),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'tipo'          => new sfValidatorPass(array('required' => false)),
      'codigo'        => new sfValidatorPass(array('required' => false)),
      'fecha'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'observaciones' => new sfValidatorPass(array('required' => false)),
      'datos'         => new sfValidatorPass(array('required' => false)),
      'empresa_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'usuario'       => new sfValidatorPass(array('required' => false)),
      'created_by'    => new sfValidatorPass(array('required' => false)),
      'updated_by'    => new sfValidatorPass(array('required' => false)),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('bitacora_elimino_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BitacoraElimino';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'tipo'          => 'Text',
      'codigo'        => 'Text',
      'fecha'         => 'Date',
      'observaciones' => 'Text',
      'datos'         => 'Text',
      'empresa_id'    => 'ForeignKey',
      'usuario'       => 'Text',
      'created_by'    => 'Text',
      'updated_by'    => 'Text',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
    );
  }
}
