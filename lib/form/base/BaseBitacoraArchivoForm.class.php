<?php

/**
 * BitacoraArchivo form base class.
 *
 * @method BitacoraArchivo getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseBitacoraArchivoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'tipo'            => new sfWidgetFormInputText(),
      'nombre'          => new sfWidgetFormInputText(),
      'nombre_original' => new sfWidgetFormInputText(),
      'created_by'      => new sfWidgetFormInputText(),
      'updated_by'      => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'carpeta'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'tipo'            => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'nombre'          => new sfValidatorString(array('max_length' => 260)),
      'nombre_original' => new sfValidatorString(array('max_length' => 260, 'required' => false)),
      'created_by'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
      'empresa_id'      => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'carpeta'         => new sfValidatorString(array('max_length' => 150, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('bitacora_archivo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BitacoraArchivo';
  }


}
