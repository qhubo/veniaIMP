<?php

/**
 * OperacionDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseOperacionDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'         => new sfWidgetFormFilterInput(),
      'empresa_id'     => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'operacion_id'   => new sfWidgetFormPropelChoice(array('model' => 'Operacion', 'add_empty' => true)),
      'producto_id'    => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'detalle'        => new sfWidgetFormFilterInput(),
      'cantidad'       => new sfWidgetFormFilterInput(),
      'valor_total'    => new sfWidgetFormFilterInput(),
      'servicio_id'    => new sfWidgetFormPropelChoice(array('model' => 'Servicio', 'add_empty' => true)),
      'valor_unitario' => new sfWidgetFormFilterInput(),
      'descuento'      => new sfWidgetFormFilterInput(),
      'total_iva'      => new sfWidgetFormFilterInput(),
      'costo_unitario' => new sfWidgetFormFilterInput(),
      'linea_no'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'codigo'         => new sfValidatorPass(array('required' => false)),
      'empresa_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'operacion_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Operacion', 'column' => 'id')),
      'producto_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'detalle'        => new sfValidatorPass(array('required' => false)),
      'cantidad'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'valor_total'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'servicio_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Servicio', 'column' => 'id')),
      'valor_unitario' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'descuento'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_iva'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo_unitario' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'linea_no'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('operacion_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OperacionDetalle';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'codigo'         => 'Text',
      'empresa_id'     => 'ForeignKey',
      'operacion_id'   => 'ForeignKey',
      'producto_id'    => 'ForeignKey',
      'detalle'        => 'Text',
      'cantidad'       => 'Number',
      'valor_total'    => 'Number',
      'servicio_id'    => 'ForeignKey',
      'valor_unitario' => 'Number',
      'descuento'      => 'Number',
      'total_iva'      => 'Number',
      'costo_unitario' => 'Number',
      'linea_no'       => 'Text',
    );
  }
}
