<?php

/**
 * InventarioVence form base class.
 *
 * @method InventarioVence getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseInventarioVenceForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'empresa_id'          => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'producto_id'         => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'fecha_vence'         => new sfWidgetFormDate(),
      'despachado'          => new sfWidgetFormInputCheckbox(),
      'ingreso_producto_id' => new sfWidgetFormPropelChoice(array('model' => 'IngresoProducto', 'add_empty' => true)),
      'tienda_id'           => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'operacion_no'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'          => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'producto_id'         => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'fecha_vence'         => new sfValidatorDate(array('required' => false)),
      'despachado'          => new sfValidatorBoolean(array('required' => false)),
      'ingreso_producto_id' => new sfValidatorPropelChoice(array('model' => 'IngresoProducto', 'column' => 'id', 'required' => false)),
      'tienda_id'           => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'operacion_no'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('inventario_vence[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'InventarioVence';
  }


}
