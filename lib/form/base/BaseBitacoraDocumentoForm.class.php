<?php

/**
 * BitacoraDocumento form base class.
 *
 * @method BitacoraDocumento getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseBitacoraDocumentoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'tipo'          => new sfWidgetFormInputText(),
      'identificador' => new sfWidgetFormInputText(),
      'usuario'       => new sfWidgetFormInputText(),
      'fecha'         => new sfWidgetFormDate(),
      'hora'          => new sfWidgetFormInputText(),
      'accion'        => new sfWidgetFormInputText(),
      'comentario'    => new sfWidgetFormTextarea(),
      'ip'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'tipo'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'identificador' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'usuario'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha'         => new sfValidatorDate(array('required' => false)),
      'hora'          => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'accion'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'comentario'    => new sfValidatorString(array('required' => false)),
      'ip'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('bitacora_documento[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BitacoraDocumento';
  }


}
