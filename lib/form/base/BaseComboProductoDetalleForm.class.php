<?php

/**
 * ComboProductoDetalle form base class.
 *
 * @method ComboProductoDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseComboProductoDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'combo_producto_id' => new sfWidgetFormPropelChoice(array('model' => 'ComboProducto', 'add_empty' => true)),
      'marca_id'          => new sfWidgetFormPropelChoice(array('model' => 'Marca', 'add_empty' => true)),
      'producto_default'  => new sfWidgetFormInputText(),
      'orden'             => new sfWidgetFormInputText(),
      'ultimo'            => new sfWidgetFormInputCheckbox(),
      'obligatorio'       => new sfWidgetFormInputCheckbox(),
      'precio'            => new sfWidgetFormInputText(),
      'seleccion'         => new sfWidgetFormInputText(),
      'empresa_id'        => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'unidad_medida'     => new sfWidgetFormInputText(),
      'cantidad_medida'   => new sfWidgetFormInputText(),
      'costo_unidad'      => new sfWidgetFormInputText(),
      'costo_producto'    => new sfWidgetFormInputText(),
      'costo_promedio'    => new sfWidgetFormInputText(),
      'costo_unidad_pro'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'combo_producto_id' => new sfValidatorPropelChoice(array('model' => 'ComboProducto', 'column' => 'id', 'required' => false)),
      'marca_id'          => new sfValidatorPropelChoice(array('model' => 'Marca', 'column' => 'id', 'required' => false)),
      'producto_default'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'orden'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'ultimo'            => new sfValidatorBoolean(array('required' => false)),
      'obligatorio'       => new sfValidatorBoolean(array('required' => false)),
      'precio'            => new sfValidatorNumber(array('required' => false)),
      'seleccion'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'empresa_id'        => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'unidad_medida'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'cantidad_medida'   => new sfValidatorNumber(array('required' => false)),
      'costo_unidad'      => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'costo_producto'    => new sfValidatorNumber(array('required' => false)),
      'costo_promedio'    => new sfValidatorNumber(array('required' => false)),
      'costo_unidad_pro'  => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('combo_producto_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ComboProductoDetalle';
  }


}
