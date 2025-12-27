<?php

/**
 * Municipio form base class.
 *
 * @method Municipio getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseMunicipioForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'departamento_id' => new sfWidgetFormPropelChoice(array('model' => 'Departamento', 'add_empty' => true)),
      'descripcion'     => new sfWidgetFormInputText(),
      'abreviatura'     => new sfWidgetFormInputText(),
      'codigo_postal'   => new sfWidgetFormInputText(),
      'activo'          => new sfWidgetFormInputCheckbox(),
      'observaciones'   => new sfWidgetFormTextarea(),
      'created_by'      => new sfWidgetFormInputText(),
      'updated_by'      => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'codigo_cargo'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'departamento_id' => new sfValidatorPropelChoice(array('model' => 'Departamento', 'column' => 'id', 'required' => false)),
      'descripcion'     => new sfValidatorString(array('max_length' => 260)),
      'abreviatura'     => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'codigo_postal'   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'activo'          => new sfValidatorBoolean(array('required' => false)),
      'observaciones'   => new sfValidatorString(array('required' => false)),
      'created_by'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
      'codigo_cargo'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('municipio[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Municipio';
  }


}
