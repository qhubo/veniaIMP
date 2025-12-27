<?php

/**
 * BitacoraElimino form base class.
 *
 * @method BitacoraElimino getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseBitacoraEliminoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'tipo'          => new sfWidgetFormInputText(),
      'codigo'        => new sfWidgetFormInputText(),
      'fecha'         => new sfWidgetFormDateTime(),
      'observaciones' => new sfWidgetFormTextarea(),
      'datos'         => new sfWidgetFormTextarea(),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'usuario'       => new sfWidgetFormInputText(),
      'created_by'    => new sfWidgetFormInputText(),
      'updated_by'    => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'tipo'          => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'codigo'        => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'fecha'         => new sfValidatorDateTime(array('required' => false)),
      'observaciones' => new sfValidatorString(array('required' => false)),
      'datos'         => new sfValidatorString(array('required' => false)),
      'empresa_id'    => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'usuario'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_by'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'updated_at'    => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('bitacora_elimino[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BitacoraElimino';
  }


}
