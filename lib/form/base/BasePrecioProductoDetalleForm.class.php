<?php

/**
 * PrecioProductoDetalle form base class.
 *
 * @method PrecioProductoDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BasePrecioProductoDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'producto_id'        => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'precio_producto_id' => new sfWidgetFormPropelChoice(array('model' => 'PrecioProducto', 'add_empty' => true)),
      'precio'             => new sfWidgetFormInputText(),
      'empresa_id'         => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'producto_id'        => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'precio_producto_id' => new sfValidatorPropelChoice(array('model' => 'PrecioProducto', 'column' => 'id', 'required' => false)),
      'precio'             => new sfValidatorNumber(array('required' => false)),
      'empresa_id'         => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('precio_producto_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PrecioProductoDetalle';
  }


}
