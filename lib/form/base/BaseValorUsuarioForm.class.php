<?php

/**
 * ValorUsuario form base class.
 *
 * @method ValorUsuario getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseValorUsuarioForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'campo_usuario_id' => new sfWidgetFormPropelChoice(array('model' => 'CampoUsuario', 'add_empty' => true)),
      'nombre_campo'     => new sfWidgetFormInputText(),
      'tipo_documento'   => new sfWidgetFormInputText(),
      'no_documento'     => new sfWidgetFormInputText(),
      'valor'            => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'created_by'       => new sfWidgetFormInputText(),
      'updated_by'       => new sfWidgetFormInputText(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'campo_usuario_id' => new sfValidatorPropelChoice(array('model' => 'CampoUsuario', 'column' => 'id', 'required' => false)),
      'nombre_campo'     => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'tipo_documento'   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'no_documento'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'valor'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
      'created_by'       => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'       => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('valor_usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ValorUsuario';
  }


}
