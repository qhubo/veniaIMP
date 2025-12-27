<?php

/**
 * SolicitudDevMotivo form base class.
 *
 * @method SolicitudDevMotivo getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseSolicitudDevMotivoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'solicitud_devolucion_id' => new sfWidgetFormPropelChoice(array('model' => 'SolicitudDevolucion', 'add_empty' => true)),
      'motivo'                  => new sfWidgetFormInputText(),
      'empresa_id'              => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'solicitud_devolucion_id' => new sfValidatorPropelChoice(array('model' => 'SolicitudDevolucion', 'column' => 'id', 'required' => false)),
      'motivo'                  => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'empresa_id'              => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('solicitud_dev_motivo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SolicitudDevMotivo';
  }


}
