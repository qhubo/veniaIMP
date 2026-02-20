<?php

/**
 * OperacionPagoPadre form base class.
 *
 * @method OperacionPagoPadre getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseOperacionPagoPadreForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'valor'           => new sfWidgetFormInputText(),
      'documento'       => new sfWidgetFormInputText(),
      'fecha_documento' => new sfWidgetFormDate(),
      'banco_id'        => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'tipo'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'valor'           => new sfValidatorNumber(array('required' => false)),
      'documento'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_documento' => new sfValidatorDate(array('required' => false)),
      'banco_id'        => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
      'tipo'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('operacion_pago_padre[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OperacionPagoPadre';
  }


}
