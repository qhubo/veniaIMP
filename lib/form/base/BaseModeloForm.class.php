<?php

/**
 * Modelo form base class.
 *
 * @method Modelo getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseModeloForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'marca_id'      => new sfWidgetFormPropelChoice(array('model' => 'Marca', 'add_empty' => true)),
      'codigo'        => new sfWidgetFormInputText(),
      'descripcion'   => new sfWidgetFormInputText(),
      'muestra_menu'  => new sfWidgetFormInputCheckbox(),
      'logo'          => new sfWidgetFormInputText(),
      'activo'        => new sfWidgetFormInputCheckbox(),
      'imagen'        => new sfWidgetFormInputText(),
      'orden_mostrar' => new sfWidgetFormInputText(),
      'aparato'       => new sfWidgetFormInputText(),
      'status'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'    => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'marca_id'      => new sfValidatorPropelChoice(array('model' => 'Marca', 'column' => 'id', 'required' => false)),
      'codigo'        => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'descripcion'   => new sfValidatorString(array('max_length' => 260)),
      'muestra_menu'  => new sfValidatorBoolean(array('required' => false)),
      'logo'          => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'activo'        => new sfValidatorBoolean(array('required' => false)),
      'imagen'        => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'orden_mostrar' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'aparato'       => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'status'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('modelo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Modelo';
  }


}
