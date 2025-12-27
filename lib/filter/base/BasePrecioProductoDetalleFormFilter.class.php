<?php

/**
 * PrecioProductoDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BasePrecioProductoDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'producto_id'        => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'precio_producto_id' => new sfWidgetFormPropelChoice(array('model' => 'PrecioProducto', 'add_empty' => true)),
      'precio'             => new sfWidgetFormFilterInput(),
      'empresa_id'         => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'producto_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'precio_producto_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PrecioProducto', 'column' => 'id')),
      'precio'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'empresa_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('precio_producto_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PrecioProductoDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'producto_id'        => 'ForeignKey',
      'precio_producto_id' => 'ForeignKey',
      'precio'             => 'Number',
      'empresa_id'         => 'ForeignKey',
    );
  }
}
