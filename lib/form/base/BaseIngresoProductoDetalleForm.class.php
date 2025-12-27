<?php

/**
 * IngresoProductoDetalle form base class.
 *
 * @method IngresoProductoDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseIngresoProductoDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'producto_id'         => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'ingreso_producto_id' => new sfWidgetFormPropelChoice(array('model' => 'IngresoProducto', 'add_empty' => true)),
      'cantidad'            => new sfWidgetFormInputText(),
      'empresa_id'          => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'ubicacion'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'producto_id'         => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'ingreso_producto_id' => new sfValidatorPropelChoice(array('model' => 'IngresoProducto', 'column' => 'id', 'required' => false)),
      'cantidad'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'empresa_id'          => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'ubicacion'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ingreso_producto_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'IngresoProductoDetalle';
  }


}
