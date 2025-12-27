<?php

/**
 * Usuario form base class.
 *
 * @method Usuario getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseUsuarioForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'usuario'         => new sfWidgetFormInputText(),
      'nombre_completo' => new sfWidgetFormInputText(),
      'tipo_usuario'    => new sfWidgetFormInputText(),
      'clave'           => new sfWidgetFormInputText(),
      'correo'          => new sfWidgetFormInputText(),
      'estado'          => new sfWidgetFormInputText(),
      'imagen'          => new sfWidgetFormInputText(),
      'administrador'   => new sfWidgetFormInputCheckbox(),
      'ultimo_ingreso'  => new sfWidgetFormDateTime(),
      'token'           => new sfWidgetFormTextarea(),
      'activo'          => new sfWidgetFormInputCheckbox(),
      'validado'        => new sfWidgetFormInputCheckbox(),
      'nivel_usuario'   => new sfWidgetFormInputText(),
      'ip'              => new sfWidgetFormInputText(),
      'tienda_id'       => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'vendedor_id'     => new sfWidgetFormPropelChoice(array('model' => 'Vendedor', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'usuario'         => new sfValidatorString(array('max_length' => 32)),
      'nombre_completo' => new sfValidatorString(array('max_length' => 320, 'required' => false)),
      'tipo_usuario'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'clave'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'correo'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'estado'          => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'imagen'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'administrador'   => new sfValidatorBoolean(array('required' => false)),
      'ultimo_ingreso'  => new sfValidatorDateTime(array('required' => false)),
      'token'           => new sfValidatorString(array('required' => false)),
      'activo'          => new sfValidatorBoolean(array('required' => false)),
      'validado'        => new sfValidatorBoolean(array('required' => false)),
      'nivel_usuario'   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'ip'              => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'tienda_id'       => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'empresa_id'      => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'vendedor_id'     => new sfValidatorPropelChoice(array('model' => 'Vendedor', 'column' => 'id', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Usuario', 'column' => array('usuario')))
    );

    $this->widgetSchema->setNameFormat('usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Usuario';
  }


}
