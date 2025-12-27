<?php

/**
 * TrasladoUbicacionDetalle form base class.
 *
 * @method TrasladoUbicacionDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseTrasladoUbicacionDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'traslado_ubicacion_id' => new sfWidgetFormPropelChoice(array('model' => 'TrasladoUbicacion', 'add_empty' => true)),
      'producto_id'           => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'ubicacion_original'    => new sfWidgetFormInputText(),
      'cantidad'              => new sfWidgetFormInputText(),
      'tienda_id'             => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'nueva_ubicacion'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'traslado_ubicacion_id' => new sfValidatorPropelChoice(array('model' => 'TrasladoUbicacion', 'column' => 'id', 'required' => false)),
      'producto_id'           => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'ubicacion_original'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'cantidad'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tienda_id'             => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'nueva_ubicacion'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('traslado_ubicacion_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TrasladoUbicacionDetalle';
  }


}
