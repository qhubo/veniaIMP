<?php

/**
 * OrdenUbicacion form base class.
 *
 * @method OrdenUbicacion getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseOrdenUbicacionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'tienda_id'            => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'producto_id'          => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'ubicacion_id'         => new sfWidgetFormInputText(),
      'orden_cotizacion_id'  => new sfWidgetFormPropelChoice(array('model' => 'OrdenCotizacion', 'add_empty' => true)),
      'procesado'            => new sfWidgetFormInputCheckbox(),
      'cantidad'             => new sfWidgetFormInputText(),
      'tienda_ubica'         => new sfWidgetFormInputText(),
      'vendedor_producto_id' => new sfWidgetFormPropelChoice(array('model' => 'VendedorProducto', 'add_empty' => true)),
      'orden_vendedor_id'    => new sfWidgetFormPropelChoice(array('model' => 'OrdenVendedor', 'add_empty' => true)),
      'salida_producto_id'   => new sfWidgetFormPropelChoice(array('model' => 'SalidaProducto', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'tienda_id'            => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'producto_id'          => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'ubicacion_id'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'orden_cotizacion_id'  => new sfValidatorPropelChoice(array('model' => 'OrdenCotizacion', 'column' => 'id', 'required' => false)),
      'procesado'            => new sfValidatorBoolean(array('required' => false)),
      'cantidad'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tienda_ubica'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'vendedor_producto_id' => new sfValidatorPropelChoice(array('model' => 'VendedorProducto', 'column' => 'id', 'required' => false)),
      'orden_vendedor_id'    => new sfValidatorPropelChoice(array('model' => 'OrdenVendedor', 'column' => 'id', 'required' => false)),
      'salida_producto_id'   => new sfValidatorPropelChoice(array('model' => 'SalidaProducto', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('orden_ubicacion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenUbicacion';
  }


}
