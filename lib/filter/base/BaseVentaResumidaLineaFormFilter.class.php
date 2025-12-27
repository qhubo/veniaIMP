<?php

/**
 * VentaResumidaLinea filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseVentaResumidaLineaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'venta_resumida_id' => new sfWidgetFormPropelChoice(array('model' => 'VentaResumida', 'add_empty' => true)),
      'numero_cuotas'     => new sfWidgetFormFilterInput(),
      'total_linea'       => new sfWidgetFormFilterInput(),
      'comision_linea'    => new sfWidgetFormFilterInput(),
      'iva_linea'         => new sfWidgetFormFilterInput(),
      'retencion_linea'   => new sfWidgetFormFilterInput(),
      'medio_pago_id'     => new sfWidgetFormPropelChoice(array('model' => 'MedioPago', 'add_empty' => true)),
      'empresa_id'        => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'banco_id'          => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'venta_resumida_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'VentaResumida', 'column' => 'id')),
      'numero_cuotas'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'total_linea'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'comision_linea'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'iva_linea'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'retencion_linea'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'medio_pago_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'MedioPago', 'column' => 'id')),
      'empresa_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'banco_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('venta_resumida_linea_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'VentaResumidaLinea';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'venta_resumida_id' => 'ForeignKey',
      'numero_cuotas'     => 'Number',
      'total_linea'       => 'Number',
      'comision_linea'    => 'Number',
      'iva_linea'         => 'Number',
      'retencion_linea'   => 'Number',
      'medio_pago_id'     => 'ForeignKey',
      'empresa_id'        => 'ForeignKey',
      'banco_id'          => 'ForeignKey',
    );
  }
}
