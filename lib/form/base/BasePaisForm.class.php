<?php

/**
 * Pais form base class.
 *
 * @method Pais getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BasePaisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'principal'     => new sfWidgetFormInputCheckbox(),
      'codigo_iso'    => new sfWidgetFormInputText(),
      'nombre'        => new sfWidgetFormInputText(),
      'activo'        => new sfWidgetFormInputCheckbox(),
      'created_by'    => new sfWidgetFormInputText(),
      'updated_by'    => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'observaciones' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'principal'     => new sfValidatorBoolean(array('required' => false)),
      'codigo_iso'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'nombre'        => new sfValidatorString(array('max_length' => 260)),
      'activo'        => new sfValidatorBoolean(array('required' => false)),
      'created_by'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'updated_at'    => new sfValidatorDateTime(array('required' => false)),
      'observaciones' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pais[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Pais';
  }


}
