<?php

/**
 * PartidaDetalle form base class.
 *
 * @method PartidaDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BasePartidaDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'partida_id'      => new sfWidgetFormPropelChoice(array('model' => 'Partida', 'add_empty' => true)),
      'detalle'         => new sfWidgetFormInputText(),
      'cuenta_contable' => new sfWidgetFormInputText(),
      'debe'            => new sfWidgetFormInputText(),
      'haber'           => new sfWidgetFormInputText(),
      'tipo'            => new sfWidgetFormInputText(),
      'grupo'           => new sfWidgetFormInputText(),
      'adicional'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'      => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'partida_id'      => new sfValidatorPropelChoice(array('model' => 'Partida', 'column' => 'id', 'required' => false)),
      'detalle'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'cuenta_contable' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'debe'            => new sfValidatorNumber(array('required' => false)),
      'haber'           => new sfValidatorNumber(array('required' => false)),
      'tipo'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'grupo'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'adicional'       => new sfValidatorString(array('max_length' => 150, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('partida_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PartidaDetalle';
  }


}
