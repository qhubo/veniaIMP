<?php

/**
 * Cierre form base class.
 *
 * @method Cierre getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseCierreForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'fecha_creo'  => new sfWidgetFormDateTime(),
      'usuario'     => new sfWidgetFormInputText(),
      'valor_total' => new sfWidgetFormInputText(),
      'no_cierre'   => new sfWidgetFormInputText(),
      'empresa_id'  => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tienda_id'   => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'fecha_creo'  => new sfValidatorDateTime(array('required' => false)),
      'usuario'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'valor_total' => new sfValidatorNumber(array('required' => false)),
      'no_cierre'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'empresa_id'  => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'tienda_id'   => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cierre[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cierre';
  }


}
