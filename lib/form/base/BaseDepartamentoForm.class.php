<?php

/**
 * Departamento form base class.
 *
 * @method Departamento getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseDepartamentoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'pais_id'       => new sfWidgetFormPropelChoice(array('model' => 'Pais', 'add_empty' => true)),
      'codigo'        => new sfWidgetFormInputText(),
      'nombre'        => new sfWidgetFormInputText(),
      'activo'        => new sfWidgetFormInputCheckbox(),
      'created_by'    => new sfWidgetFormInputText(),
      'updated_by'    => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'observaciones' => new sfWidgetFormTextarea(),
      'codigo_cargo'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'pais_id'       => new sfValidatorPropelChoice(array('model' => 'Pais', 'column' => 'id', 'required' => false)),
      'codigo'        => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'nombre'        => new sfValidatorString(array('max_length' => 260)),
      'activo'        => new sfValidatorBoolean(array('required' => false)),
      'created_by'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'updated_at'    => new sfValidatorDateTime(array('required' => false)),
      'observaciones' => new sfValidatorString(array('required' => false)),
      'codigo_cargo'  => new sfValidatorString(array('max_length' => 32, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('departamento[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Departamento';
  }


}
