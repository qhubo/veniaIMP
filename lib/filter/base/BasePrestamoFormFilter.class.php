<?php

/**
 * Prestamo filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BasePrestamoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'        => new sfWidgetFormFilterInput(),
      'nombre'        => new sfWidgetFormFilterInput(),
      'observaciones' => new sfWidgetFormFilterInput(),
      'valor'         => new sfWidgetFormFilterInput(),
      'fecha_inicio'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'moneda'        => new sfWidgetFormFilterInput(),
      'tasa_interes'  => new sfWidgetFormFilterInput(),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'estatus'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'codigo'        => new sfValidatorPass(array('required' => false)),
      'nombre'        => new sfValidatorPass(array('required' => false)),
      'observaciones' => new sfValidatorPass(array('required' => false)),
      'valor'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'fecha_inicio'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'moneda'        => new sfValidatorPass(array('required' => false)),
      'tasa_interes'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'empresa_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'estatus'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('prestamo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Prestamo';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'codigo'        => 'Text',
      'nombre'        => 'Text',
      'observaciones' => 'Text',
      'valor'         => 'Number',
      'fecha_inicio'  => 'Date',
      'moneda'        => 'Text',
      'tasa_interes'  => 'Number',
      'empresa_id'    => 'ForeignKey',
      'estatus'       => 'Text',
    );
  }
}
