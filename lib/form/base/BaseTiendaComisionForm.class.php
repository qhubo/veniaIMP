<?php

/**
 * TiendaComision form base class.
 *
 * @method TiendaComision getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseTiendaComisionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'nombre_tienda' => new sfWidgetFormInputText(),
      'minimo'        => new sfWidgetFormInputText(),
      'maximo'        => new sfWidgetFormInputText(),
      'tipo'          => new sfWidgetFormInputText(),
      'valor'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'nombre_tienda' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'minimo'        => new sfValidatorNumber(array('required' => false)),
      'maximo'        => new sfValidatorNumber(array('required' => false)),
      'tipo'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'valor'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tienda_comision[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TiendaComision';
  }


}
