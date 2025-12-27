<?php

/**
 * OrdenUbicacion filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseOrdenUbicacionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tienda_id'            => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'producto_id'          => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'ubicacion_id'         => new sfWidgetFormFilterInput(),
      'orden_cotizacion_id'  => new sfWidgetFormPropelChoice(array('model' => 'OrdenCotizacion', 'add_empty' => true)),
      'procesado'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'cantidad'             => new sfWidgetFormFilterInput(),
      'tienda_ubica'         => new sfWidgetFormFilterInput(),
      'vendedor_producto_id' => new sfWidgetFormPropelChoice(array('model' => 'VendedorProducto', 'add_empty' => true)),
      'orden_vendedor_id'    => new sfWidgetFormPropelChoice(array('model' => 'OrdenVendedor', 'add_empty' => true)),
      'salida_producto_id'   => new sfWidgetFormPropelChoice(array('model' => 'SalidaProducto', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'tienda_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'producto_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'ubicacion_id'         => new sfValidatorPass(array('required' => false)),
      'orden_cotizacion_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'OrdenCotizacion', 'column' => 'id')),
      'procesado'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'cantidad'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tienda_ubica'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'vendedor_producto_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'VendedorProducto', 'column' => 'id')),
      'orden_vendedor_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'OrdenVendedor', 'column' => 'id')),
      'salida_producto_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SalidaProducto', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('orden_ubicacion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenUbicacion';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'tienda_id'            => 'ForeignKey',
      'producto_id'          => 'ForeignKey',
      'ubicacion_id'         => 'Text',
      'orden_cotizacion_id'  => 'ForeignKey',
      'procesado'            => 'Boolean',
      'cantidad'             => 'Number',
      'tienda_ubica'         => 'Number',
      'vendedor_producto_id' => 'ForeignKey',
      'orden_vendedor_id'    => 'ForeignKey',
      'salida_producto_id'   => 'ForeignKey',
    );
  }
}
