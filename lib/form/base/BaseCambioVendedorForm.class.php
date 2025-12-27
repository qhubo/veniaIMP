<?php

/**
 * CambioVendedor form base class.
 *
 * @method CambioVendedor getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseCambioVendedorForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'codigo_opera'         => new sfWidgetFormInputText(),
      'vendedor_anterior'    => new sfWidgetFormInputText(),
      'vendedor_actualizado' => new sfWidgetFormInputText(),
      'usuario'              => new sfWidgetFormInputText(),
      'fecha'                => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo_opera'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'vendedor_anterior'    => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'vendedor_actualizado' => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'usuario'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha'                => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cambio_vendedor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CambioVendedor';
  }


}
