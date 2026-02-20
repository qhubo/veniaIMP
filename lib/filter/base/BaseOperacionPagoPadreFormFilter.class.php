<?php

/**
 * OperacionPagoPadre filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseOperacionPagoPadreFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'valor'           => new sfWidgetFormFilterInput(),
      'documento'       => new sfWidgetFormFilterInput(),
      'fecha_documento' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'banco_id'        => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'valor'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'documento'       => new sfValidatorPass(array('required' => false)),
      'fecha_documento' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'banco_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('operacion_pago_padre_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OperacionPagoPadre';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'valor'           => 'Number',
      'documento'       => 'Text',
      'fecha_documento' => 'Date',
      'banco_id'        => 'ForeignKey',
    );
  }
}
