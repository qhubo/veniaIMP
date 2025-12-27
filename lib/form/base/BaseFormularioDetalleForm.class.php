<?php

/**
 * FormularioDetalle form base class.
 *
 * @method FormularioDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseFormularioDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'formulario_datos_id' => new sfWidgetFormPropelChoice(array('model' => 'FormularioDatos', 'add_empty' => true)),
      'hollander'           => new sfWidgetFormInputText(),
      'repuesto'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'formulario_datos_id' => new sfValidatorPropelChoice(array('model' => 'FormularioDatos', 'column' => 'id', 'required' => false)),
      'hollander'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'repuesto'            => new sfValidatorString(array('max_length' => 250, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('formulario_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'FormularioDetalle';
  }


}
