<?php

/**
 * FormularioDatos form base class.
 *
 * @method FormularioDatos getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseFormularioDatosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'establecimiento' => new sfWidgetFormInputText(),
      'tipo'            => new sfWidgetFormInputText(),
      'propietario'     => new sfWidgetFormInputText(),
      'telefono'        => new sfWidgetFormInputText(),
      'email'           => new sfWidgetFormInputText(),
      'region_id'       => new sfWidgetFormPropelChoice(array('model' => 'Region', 'add_empty' => true)),
      'departamento_id' => new sfWidgetFormPropelChoice(array('model' => 'Departamento', 'add_empty' => true)),
      'municipio_id'    => new sfWidgetFormPropelChoice(array('model' => 'Municipio', 'add_empty' => true)),
      'direccion'       => new sfWidgetFormInputText(),
      'nit'             => new sfWidgetFormInputText(),
      'contacto'        => new sfWidgetFormInputText(),
      'whtas_app'       => new sfWidgetFormInputText(),
      'observaciones'   => new sfWidgetFormTextarea(),
      'fecha_visita'    => new sfWidgetFormDate(),
      'usuario'         => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'created_by'      => new sfWidgetFormInputText(),
      'updated_by'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'establecimiento' => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'tipo'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'propietario'     => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'telefono'        => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'email'           => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'region_id'       => new sfValidatorPropelChoice(array('model' => 'Region', 'column' => 'id', 'required' => false)),
      'departamento_id' => new sfValidatorPropelChoice(array('model' => 'Departamento', 'column' => 'id', 'required' => false)),
      'municipio_id'    => new sfValidatorPropelChoice(array('model' => 'Municipio', 'column' => 'id', 'required' => false)),
      'direccion'       => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'nit'             => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'contacto'        => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'whtas_app'       => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'observaciones'   => new sfValidatorString(array('required' => false)),
      'fecha_visita'    => new sfValidatorDate(array('required' => false)),
      'usuario'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
      'created_by'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('formulario_datos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'FormularioDatos';
  }


}
