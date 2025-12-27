<?php

/**
 * Tienda form base class.
 *
 * @method Tienda getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseTiendaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'empresa_id'             => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'                 => new sfWidgetFormInputText(),
      'nombre'                 => new sfWidgetFormInputText(),
      'codigo_establecimiento' => new sfWidgetFormInputText(),
      'direccion'              => new sfWidgetFormInputText(),
      'departamento_id'        => new sfWidgetFormPropelChoice(array('model' => 'Departamento', 'add_empty' => true)),
      'municipio_id'           => new sfWidgetFormPropelChoice(array('model' => 'Municipio', 'add_empty' => true)),
      'observaciones'          => new sfWidgetFormTextarea(),
      'correo'                 => new sfWidgetFormInputText(),
      'telefono'               => new sfWidgetFormInputText(),
      'nombre_comercial'       => new sfWidgetFormInputText(),
      'activo'                 => new sfWidgetFormInputCheckbox(),
      'cuenta_debe'            => new sfWidgetFormInputText(),
      'cuenta_haber'           => new sfWidgetFormInputText(),
      'created_by'             => new sfWidgetFormInputText(),
      'updated_by'             => new sfWidgetFormInputText(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'tipo'                   => new sfWidgetFormInputText(),
      'nit'                    => new sfWidgetFormInputText(),
      'feel_usuario'           => new sfWidgetFormInputText(),
      'feel_token'             => new sfWidgetFormInputText(),
      'feel_llave'             => new sfWidgetFormInputText(),
      'activa_buscador'        => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'             => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'codigo'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre'                 => new sfValidatorString(array('max_length' => 150)),
      'codigo_establecimiento' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'direccion'              => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'departamento_id'        => new sfValidatorPropelChoice(array('model' => 'Departamento', 'column' => 'id', 'required' => false)),
      'municipio_id'           => new sfValidatorPropelChoice(array('model' => 'Municipio', 'column' => 'id', 'required' => false)),
      'observaciones'          => new sfValidatorString(array('required' => false)),
      'correo'                 => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'telefono'               => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'nombre_comercial'       => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'activo'                 => new sfValidatorBoolean(array('required' => false)),
      'cuenta_debe'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'cuenta_haber'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_by'             => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'             => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'updated_at'             => new sfValidatorDateTime(array('required' => false)),
      'tipo'                   => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'nit'                    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'feel_usuario'           => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'feel_token'             => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'feel_llave'             => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'activa_buscador'        => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tienda[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tienda';
  }


}
