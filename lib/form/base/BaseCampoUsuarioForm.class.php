<?php

/**
 * CampoUsuario form base class.
 *
 * @method CampoUsuario getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseCampoUsuarioForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'empresa_id'     => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tipo_documento' => new sfWidgetFormInputText(),
      'codigo'         => new sfWidgetFormInputText(),
      'nombre'         => new sfWidgetFormInputText(),
      'tipo_campo'     => new sfWidgetFormInputText(),
      'valores'        => new sfWidgetFormTextarea(),
      'requerido'      => new sfWidgetFormInputCheckbox(),
      'activo'         => new sfWidgetFormInputCheckbox(),
      'orden'          => new sfWidgetFormInputText(),
      'tienda_id'      => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'     => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'tipo_documento' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'codigo'         => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'nombre'         => new sfValidatorString(array('max_length' => 260)),
      'tipo_campo'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'valores'        => new sfValidatorString(array('required' => false)),
      'requerido'      => new sfValidatorBoolean(array('required' => false)),
      'activo'         => new sfValidatorBoolean(array('required' => false)),
      'orden'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tienda_id'      => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('campo_usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CampoUsuario';
  }


}
