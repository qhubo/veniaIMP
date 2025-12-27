<?php

/**
 * Facturas form base class.
 *
 * @method Facturas getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseFacturasForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'tienda'         => new sfWidgetFormInputText(),
      'referencia'     => new sfWidgetFormInputText(),
      'fecha'          => new sfWidgetFormDateTime(),
      'tipo_documento' => new sfWidgetFormInputText(),
      'firma'          => new sfWidgetFormInputText(),
      'motivo'         => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'tienda'         => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'referencia'     => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'fecha'          => new sfValidatorDateTime(array('required' => false)),
      'tipo_documento' => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'firma'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'motivo'         => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('facturas[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Facturas';
  }


}
