<?php

/**
 * Agenda form base class.
 *
 * @method Agenda getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseAgendaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'fecha'         => new sfWidgetFormDate(),
      'hora_inicio'   => new sfWidgetFormInputText(),
      'hora_fin'      => new sfWidgetFormInputText(),
      'estatus'       => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'created_by'    => new sfWidgetFormInputText(),
      'updated_by'    => new sfWidgetFormInputText(),
      'cliente_id'    => new sfWidgetFormPropelChoice(array('model' => 'Cliente', 'add_empty' => true)),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'observaciones' => new sfWidgetFormTextarea(),
      'tienda_id'     => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'doctor'        => new sfWidgetFormInputText(),
      'no_sesion'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'fecha'         => new sfValidatorDate(array('required' => false)),
      'hora_inicio'   => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'hora_fin'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'estatus'       => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'updated_at'    => new sfValidatorDateTime(array('required' => false)),
      'created_by'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'cliente_id'    => new sfValidatorPropelChoice(array('model' => 'Cliente', 'column' => 'id', 'required' => false)),
      'empresa_id'    => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'observaciones' => new sfValidatorString(array('required' => false)),
      'tienda_id'     => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'doctor'        => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'no_sesion'     => new sfValidatorString(array('max_length' => 10, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('agenda[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Agenda';
  }


}
