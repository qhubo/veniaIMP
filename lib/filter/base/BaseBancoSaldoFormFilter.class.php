<?php

/**
 * BancoSaldo filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseBancoSaldoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'               => new sfWidgetFormFilterInput(),
      'banco_id'             => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'moneda_id'            => new sfWidgetFormPropelChoice(array('model' => 'Moneda', 'add_empty' => true)),
      'nombre'               => new sfWidgetFormFilterInput(),
      'saldo'                => new sfWidgetFormFilterInput(),
      'ultima_actualizacion' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'ultimo_movimiento'    => new sfWidgetFormFilterInput(),
      'empresa_id'           => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'codigo'               => new sfValidatorPass(array('required' => false)),
      'banco_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
      'moneda_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Moneda', 'column' => 'id')),
      'nombre'               => new sfValidatorPass(array('required' => false)),
      'saldo'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'ultima_actualizacion' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'ultimo_movimiento'    => new sfValidatorPass(array('required' => false)),
      'empresa_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('banco_saldo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BancoSaldo';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'codigo'               => 'Text',
      'banco_id'             => 'ForeignKey',
      'moneda_id'            => 'ForeignKey',
      'nombre'               => 'Text',
      'saldo'                => 'Number',
      'ultima_actualizacion' => 'Date',
      'ultimo_movimiento'    => 'Text',
      'empresa_id'           => 'ForeignKey',
    );
  }
}
