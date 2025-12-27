<?php

/**
 * CierreCajaValor filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseCierreCajaValorFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'cierre_caja_id' => new sfWidgetFormPropelChoice(array('model' => 'CierreCaja', 'add_empty' => true)),
      'medio_pago'     => new sfWidgetFormFilterInput(),
      'valor'          => new sfWidgetFormFilterInput(),
      'documento'      => new sfWidgetFormFilterInput(),
      'banco_id'       => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'cierre_caja_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'CierreCaja', 'column' => 'id')),
      'medio_pago'     => new sfValidatorPass(array('required' => false)),
      'valor'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'documento'      => new sfValidatorPass(array('required' => false)),
      'banco_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('cierre_caja_valor_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CierreCajaValor';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'cierre_caja_id' => 'ForeignKey',
      'medio_pago'     => 'Text',
      'valor'          => 'Number',
      'documento'      => 'Text',
      'banco_id'       => 'ForeignKey',
    );
  }
}
