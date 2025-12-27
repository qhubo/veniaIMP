<?php

/**
 * NotaCreditoDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseNotaCreditoDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nota_credito_id' => new sfWidgetFormPropelChoice(array('model' => 'NotaCredito', 'add_empty' => true)),
      'cantidad'        => new sfWidgetFormFilterInput(),
      'detalle'         => new sfWidgetFormFilterInput(),
      'sub_total'       => new sfWidgetFormFilterInput(),
      'iva'             => new sfWidgetFormFilterInput(),
      'valor_total'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'nota_credito_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'NotaCredito', 'column' => 'id')),
      'cantidad'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'detalle'         => new sfValidatorPass(array('required' => false)),
      'sub_total'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'iva'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_total'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('nota_credito_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotaCreditoDetalle';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'nota_credito_id' => 'ForeignKey',
      'cantidad'        => 'Number',
      'detalle'         => 'Text',
      'sub_total'       => 'Number',
      'iva'             => 'Number',
      'valor_total'     => 'Number',
    );
  }
}
