<?php

/**
 * GastoDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseGastoDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'gasto_id'        => new sfWidgetFormPropelChoice(array('model' => 'Gasto', 'add_empty' => true)),
      'cuenta_contable' => new sfWidgetFormFilterInput(),
      'concepto'        => new sfWidgetFormFilterInput(),
      'cantidad'        => new sfWidgetFormFilterInput(),
      'sub_total'       => new sfWidgetFormFilterInput(),
      'iva'             => new sfWidgetFormFilterInput(),
      'valor_total'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'gasto_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Gasto', 'column' => 'id')),
      'cuenta_contable' => new sfValidatorPass(array('required' => false)),
      'concepto'        => new sfValidatorPass(array('required' => false)),
      'cantidad'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'sub_total'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'iva'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_total'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('gasto_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'GastoDetalle';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'gasto_id'        => 'ForeignKey',
      'cuenta_contable' => 'Text',
      'concepto'        => 'Text',
      'cantidad'        => 'Number',
      'sub_total'       => 'Number',
      'iva'             => 'Number',
      'valor_total'     => 'Number',
    );
  }
}
