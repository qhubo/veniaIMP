<?php

/**
 * VendedorProducto form base class.
 *
 * @method VendedorProducto getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseVendedorProductoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'vendedor_id'       => new sfWidgetFormPropelChoice(array('model' => 'Vendedor', 'add_empty' => true)),
      'producto_id'       => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'cantidad'          => new sfWidgetFormInputText(),
      'observaciones'     => new sfWidgetFormInputText(),
      'fecha'             => new sfWidgetFormDateTime(),
      'usuario'           => new sfWidgetFormInputText(),
      'valor_unitario'    => new sfWidgetFormInputText(),
      'orden_vendedor_id' => new sfWidgetFormPropelChoice(array('model' => 'OrdenVendedor', 'add_empty' => true)),
      'verificado'        => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'vendedor_id'       => new sfValidatorPropelChoice(array('model' => 'Vendedor', 'column' => 'id', 'required' => false)),
      'producto_id'       => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'cantidad'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'observaciones'     => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'fecha'             => new sfValidatorDateTime(array('required' => false)),
      'usuario'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'valor_unitario'    => new sfValidatorNumber(array('required' => false)),
      'orden_vendedor_id' => new sfValidatorPropelChoice(array('model' => 'OrdenVendedor', 'column' => 'id', 'required' => false)),
      'verificado'        => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('vendedor_producto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'VendedorProducto';
  }


}
