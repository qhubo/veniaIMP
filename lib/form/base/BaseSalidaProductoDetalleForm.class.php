<?php

/**
 * SalidaProductoDetalle form base class.
 *
 * @method SalidaProductoDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseSalidaProductoDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'salida_producto_id' => new sfWidgetFormPropelChoice(array('model' => 'SalidaProducto', 'add_empty' => true)),
      'producto_id'        => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'codigo'             => new sfWidgetFormInputText(),
      'detalle'            => new sfWidgetFormInputText(),
      'valor'              => new sfWidgetFormInputText(),
      'cantidad'           => new sfWidgetFormInputText(),
      'valor_total'        => new sfWidgetFormInputText(),
      'excento'            => new sfWidgetFormInputCheckbox(),
      'confirmado'         => new sfWidgetFormInputCheckbox(),
      'usuario_id'         => new sfWidgetFormPropelChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'empresa_id'         => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'salida_producto_id' => new sfValidatorPropelChoice(array('model' => 'SalidaProducto', 'column' => 'id', 'required' => false)),
      'producto_id'        => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'codigo'             => new sfValidatorString(array('max_length' => 42, 'required' => false)),
      'detalle'            => new sfValidatorString(array('max_length' => 300, 'required' => false)),
      'valor'              => new sfValidatorNumber(array('required' => false)),
      'cantidad'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'valor_total'        => new sfValidatorNumber(array('required' => false)),
      'excento'            => new sfValidatorBoolean(array('required' => false)),
      'confirmado'         => new sfValidatorBoolean(array('required' => false)),
      'usuario_id'         => new sfValidatorPropelChoice(array('model' => 'Usuario', 'column' => 'id', 'required' => false)),
      'empresa_id'         => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('salida_producto_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SalidaProductoDetalle';
  }


}
