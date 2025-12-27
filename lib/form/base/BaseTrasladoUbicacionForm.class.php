<?php

/**
 * TrasladoUbicacion form base class.
 *
 * @method TrasladoUbicacion getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseTrasladoUbicacionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tienda_id'     => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'observaciones' => new sfWidgetFormInputText(),
      'usuario'       => new sfWidgetFormInputText(),
      'fecha'         => new sfWidgetFormDate(),
      'estado'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'    => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'tienda_id'     => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'observaciones' => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'usuario'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha'         => new sfValidatorDate(array('required' => false)),
      'estado'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('traslado_ubicacion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TrasladoUbicacion';
  }


}
