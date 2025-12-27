<?php

/**
 * SaldoBanco filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseSaldoBancoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'saldo_libro'       => new sfWidgetFormFilterInput(),
      'banco_id'          => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'usuario'           => new sfWidgetFormFilterInput(),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'saldo_banco'       => new sfWidgetFormFilterInput(),
      'saldo_conciliado'  => new sfWidgetFormFilterInput(),
      'diferencia'        => new sfWidgetFormFilterInput(),
      'fecha_docu'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'deposito_transito' => new sfWidgetFormFilterInput(),
      'nota_credito'      => new sfWidgetFormFilterInput(),
      'cheques_circula'   => new sfWidgetFormFilterInput(),
      'nota_transito'     => new sfWidgetFormFilterInput(),
      'diferencial'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'fecha'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'saldo_libro'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'banco_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
      'usuario'           => new sfValidatorPass(array('required' => false)),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'saldo_banco'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'saldo_conciliado'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'diferencia'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'fecha_docu'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deposito_transito' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'nota_credito'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cheques_circula'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'nota_transito'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'diferencial'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('saldo_banco_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SaldoBanco';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'fecha'             => 'Date',
      'saldo_libro'       => 'Number',
      'banco_id'          => 'ForeignKey',
      'usuario'           => 'Text',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
      'saldo_banco'       => 'Number',
      'saldo_conciliado'  => 'Number',
      'diferencia'        => 'Number',
      'fecha_docu'        => 'Date',
      'deposito_transito' => 'Number',
      'nota_credito'      => 'Number',
      'cheques_circula'   => 'Number',
      'nota_transito'     => 'Number',
      'diferencial'       => 'Number',
    );
  }
}
