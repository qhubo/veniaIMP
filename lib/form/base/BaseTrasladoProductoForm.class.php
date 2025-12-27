<?php

/**
 * TrasladoProducto form base class.
 *
 * @method TrasladoProducto getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseTrasladoProductoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'codigo'           => new sfWidgetFormInputText(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'producto_id'      => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'bodega_origen'    => new sfWidgetFormInputText(),
      'bodega_destino'   => new sfWidgetFormInputText(),
      'comentario'       => new sfWidgetFormInputText(),
      'cantidad'         => new sfWidgetFormInputText(),
      'estatus'          => new sfWidgetFormInputText(),
      'usuario'          => new sfWidgetFormInputText(),
      'fecha'            => new sfWidgetFormDate(),
      'usuario_confirmo' => new sfWidgetFormInputText(),
      'fecha_confirmo'   => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'producto_id'      => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'bodega_origen'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'bodega_destino'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'comentario'       => new sfValidatorString(array('max_length' => 350, 'required' => false)),
      'cantidad'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'estatus'          => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'usuario'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha'            => new sfValidatorDate(array('required' => false)),
      'usuario_confirmo' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_confirmo'   => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('traslado_producto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TrasladoProducto';
  }


}
