<?php

/**
 * CuentaBanco filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseCuentaBancoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'banco_id'            => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'movimiento_banco_id' => new sfWidgetFormPropelChoice(array('model' => 'MovimientoBanco', 'add_empty' => true)),
      'valor'               => new sfWidgetFormFilterInput(),
      'fecha'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'documento'           => new sfWidgetFormFilterInput(),
      'observaciones'       => new sfWidgetFormFilterInput(),
      'usuario'             => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'estatus'             => new sfWidgetFormFilterInput(),
      'operacion_pago_id'   => new sfWidgetFormPropelChoice(array('model' => 'OperacionPago', 'add_empty' => true)),
      'empresa_id'          => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'banco_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
      'movimiento_banco_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'MovimientoBanco', 'column' => 'id')),
      'valor'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'fecha'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'documento'           => new sfValidatorPass(array('required' => false)),
      'observaciones'       => new sfValidatorPass(array('required' => false)),
      'usuario'             => new sfValidatorPass(array('required' => false)),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'estatus'             => new sfValidatorPass(array('required' => false)),
      'operacion_pago_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'OperacionPago', 'column' => 'id')),
      'empresa_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('cuenta_banco_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CuentaBanco';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'banco_id'            => 'ForeignKey',
      'movimiento_banco_id' => 'ForeignKey',
      'valor'               => 'Number',
      'fecha'               => 'Date',
      'documento'           => 'Text',
      'observaciones'       => 'Text',
      'usuario'             => 'Text',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
      'estatus'             => 'Text',
      'operacion_pago_id'   => 'ForeignKey',
      'empresa_id'          => 'ForeignKey',
    );
  }
}
