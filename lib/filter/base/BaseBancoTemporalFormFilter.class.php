<?php

/**
 * BancoTemporal filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseBancoTemporalFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'             => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'fecha'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'banco_id'               => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'saldo_banco'            => new sfWidgetFormFilterInput(),
      'deposito_transito'      => new sfWidgetFormFilterInput(),
      'nota_credito_transito'  => new sfWidgetFormFilterInput(),
      'cheques_circulacion'    => new sfWidgetFormFilterInput(),
      'nota_debito_transito'   => new sfWidgetFormFilterInput(),
      'saldo_libros'           => new sfWidgetFormFilterInput(),
      'deposito_registrar'     => new sfWidgetFormFilterInput(),
      'nota_credito_registrar' => new sfWidgetFormFilterInput(),
      'cheques_registrar'      => new sfWidgetFormFilterInput(),
      'nota_debito_registrar'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'fecha'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'banco_id'               => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
      'saldo_banco'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'deposito_transito'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'nota_credito_transito'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cheques_circulacion'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'nota_debito_transito'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'saldo_libros'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'deposito_registrar'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'nota_credito_registrar' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cheques_registrar'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'nota_debito_registrar'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('banco_temporal_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BancoTemporal';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'empresa_id'             => 'ForeignKey',
      'fecha'                  => 'Date',
      'banco_id'               => 'ForeignKey',
      'saldo_banco'            => 'Number',
      'deposito_transito'      => 'Number',
      'nota_credito_transito'  => 'Number',
      'cheques_circulacion'    => 'Number',
      'nota_debito_transito'   => 'Number',
      'saldo_libros'           => 'Number',
      'deposito_registrar'     => 'Number',
      'nota_credito_registrar' => 'Number',
      'cheques_registrar'      => 'Number',
      'nota_debito_registrar'  => 'Number',
    );
  }
}
