<?php

/**
 * LibroAgrupado form base class.
 *
 * @method LibroAgrupado getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseLibroAgrupadoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'empresa_id' => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'nombre'     => new sfWidgetFormInputText(),
      'tipo'       => new sfWidgetFormInputText(),
      'grupo'      => new sfWidgetFormInputText(),
      'orden'      => new sfWidgetFormInputText(),
      'abs'        => new sfWidgetFormInputCheckbox(),
      'haber'      => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id' => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'nombre'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'tipo'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'grupo'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'orden'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'abs'        => new sfValidatorBoolean(array('required' => false)),
      'haber'      => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('libro_agrupado[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LibroAgrupado';
  }


}
