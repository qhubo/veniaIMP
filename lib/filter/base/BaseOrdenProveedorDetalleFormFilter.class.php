<?php

/**
 * OrdenProveedorDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseOrdenProveedorDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'orden_proveedor_id' => new sfWidgetFormPropelChoice(array('model' => 'OrdenProveedor', 'add_empty' => true)),
      'producto_id'        => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'servicio_id'        => new sfWidgetFormPropelChoice(array('model' => 'Servicio', 'add_empty' => true)),
      'codigo'             => new sfWidgetFormFilterInput(),
      'detalle'            => new sfWidgetFormFilterInput(),
      'valor_unitario'     => new sfWidgetFormFilterInput(),
      'cantidad'           => new sfWidgetFormFilterInput(),
      'valor_total'        => new sfWidgetFormFilterInput(),
      'total_iva'          => new sfWidgetFormFilterInput(),
      'observaciones'      => new sfWidgetFormFilterInput(),
      'valor_isr'          => new sfWidgetFormFilterInput(),
      'impuesto_gas'       => new sfWidgetFormFilterInput(),
      'valor_retiene_iva'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'orden_proveedor_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'OrdenProveedor', 'column' => 'id')),
      'producto_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'servicio_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Servicio', 'column' => 'id')),
      'codigo'             => new sfValidatorPass(array('required' => false)),
      'detalle'            => new sfValidatorPass(array('required' => false)),
      'valor_unitario'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cantidad'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_total'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_iva'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'observaciones'      => new sfValidatorPass(array('required' => false)),
      'valor_isr'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'impuesto_gas'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_retiene_iva'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('orden_proveedor_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenProveedorDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'orden_proveedor_id' => 'ForeignKey',
      'producto_id'        => 'ForeignKey',
      'servicio_id'        => 'ForeignKey',
      'codigo'             => 'Text',
      'detalle'            => 'Text',
      'valor_unitario'     => 'Number',
      'cantidad'           => 'Number',
      'valor_total'        => 'Number',
      'total_iva'          => 'Number',
      'observaciones'      => 'Text',
      'valor_isr'          => 'Number',
      'impuesto_gas'       => 'Number',
      'valor_retiene_iva'  => 'Number',
    );
  }
}
