<?php

/**
 * PartidaAgrupa form base class.
 *
 * @method PartidaAgrupa getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BasePartidaAgrupaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'codigo'         => new sfWidgetFormInputText(),
      'fecha_contable' => new sfWidgetFormDate(),
      'detalle'        => new sfWidgetFormInputText(),
      'empresa_id'     => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'revisado'       => new sfWidgetFormInputCheckbox(),
      'ano'            => new sfWidgetFormInputText(),
      'mes'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_contable' => new sfValidatorDate(array('required' => false)),
      'detalle'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'empresa_id'     => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'revisado'       => new sfValidatorBoolean(array('required' => false)),
      'ano'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'mes'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('partida_agrupa[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PartidaAgrupa';
  }


}
