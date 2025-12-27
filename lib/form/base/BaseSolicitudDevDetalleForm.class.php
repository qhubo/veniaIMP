<?php

/**
 * SolicitudDevDetalle form base class.
 *
 * @method SolicitudDevDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseSolicitudDevDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'solicitud_devolucion_id' => new sfWidgetFormPropelChoice(array('model' => 'SolicitudDevolucion', 'add_empty' => true)),
      'hollander'               => new sfWidgetFormInputText(),
      'descripcion'             => new sfWidgetFormInputText(),
      'stock'                   => new sfWidgetFormInputText(),
      'tipo'                    => new sfWidgetFormInputText(),
      'tipo_respuesto'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'solicitud_devolucion_id' => new sfValidatorPropelChoice(array('model' => 'SolicitudDevolucion', 'column' => 'id', 'required' => false)),
      'hollander'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'descripcion'             => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'stock'                   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'tipo'                    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tipo_respuesto'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('solicitud_dev_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SolicitudDevDetalle';
  }


}
