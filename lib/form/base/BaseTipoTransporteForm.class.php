<?php

/**
 * TipoTransporte form base class.
 *
 * @method TipoTransporte getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseTipoTransporteForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'empresa_id'  => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'      => new sfWidgetFormInputText(),
      'nombre'      => new sfWidgetFormInputText(),
      'activo'      => new sfWidgetFormInputCheckbox(),
      'descripcion' => new sfWidgetFormInputText(),
      'telefono'    => new sfWidgetFormInputText(),
      'clave'       => new sfWidgetFormInputText(),
      'clave_2'     => new sfWidgetFormInputText(),
      'direccion'   => new sfWidgetFormInputText(),
      'correo'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'  => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'codigo'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'nombre'      => new sfValidatorString(array('max_length' => 260)),
      'activo'      => new sfValidatorBoolean(array('required' => false)),
      'descripcion' => new sfValidatorString(array('max_length' => 260, 'required' => false)),
      'telefono'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'clave'       => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'clave_2'     => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'direccion'   => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'correo'      => new sfValidatorString(array('max_length' => 150, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tipo_transporte[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TipoTransporte';
  }


}
