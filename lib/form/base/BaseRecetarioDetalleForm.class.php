<?php

/**
 * RecetarioDetalle form base class.
 *
 * @method RecetarioDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseRecetarioDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'recetario_id'  => new sfWidgetFormPropelChoice(array('model' => 'Recetario', 'add_empty' => true)),
      'tipo_detalle'  => new sfWidgetFormInputText(),
      'servicio'      => new sfWidgetFormInputText(),
      'producto_id'   => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'dosis'         => new sfWidgetFormInputText(),
      'frecuencia'    => new sfWidgetFormInputText(),
      'observaciones' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'recetario_id'  => new sfValidatorPropelChoice(array('model' => 'Recetario', 'column' => 'id', 'required' => false)),
      'tipo_detalle'  => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'servicio'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'producto_id'   => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'dosis'         => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'frecuencia'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'observaciones' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('recetario_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RecetarioDetalle';
  }


}
