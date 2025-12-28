<?php

/**
 * MarcaProducto form base class.
 *
 * @method MarcaProducto getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseMarcaProductoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'empresa_id' => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'     => new sfWidgetFormInputText(),
      'nombre'     => new sfWidgetFormInputText(),
      'activo'     => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id' => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'codigo'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre'     => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'activo'     => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('marca_producto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MarcaProducto';
  }


}
