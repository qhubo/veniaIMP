<?php

/**
 * IngresoProducto form base class.
 *
 * @method IngresoProducto getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseIngresoProductoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'usuario_id'       => new sfWidgetFormPropelChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'fecha'            => new sfWidgetFormDateTime(),
      'tienda_id'        => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'fecha_documento'  => new sfWidgetFormInputText(),
      'observaciones'    => new sfWidgetFormInputText(),
      'numero_documento' => new sfWidgetFormInputText(),
      'numero_orden'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'usuario_id'       => new sfValidatorPropelChoice(array('model' => 'Usuario', 'column' => 'id', 'required' => false)),
      'fecha'            => new sfValidatorDateTime(array('required' => false)),
      'tienda_id'        => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'fecha_documento'  => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'observaciones'    => new sfValidatorString(array('max_length' => 460, 'required' => false)),
      'numero_documento' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'numero_orden'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ingreso_producto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'IngresoProducto';
  }


}
