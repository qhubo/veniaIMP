<?php

/**
 * CorrelativoCodigo form base class.
 *
 * @method CorrelativoCodigo getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseCorrelativoCodigoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'numero_asginar' => new sfWidgetFormInputText(),
      'prefijo'        => new sfWidgetFormInputText(),
      'tipo'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'numero_asginar' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'prefijo'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'tipo'           => new sfValidatorString(array('max_length' => 250, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('correlativo_codigo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CorrelativoCodigo';
  }


}
