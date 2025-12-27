<?php

/**
 * PartidaAgrupaLinea form base class.
 *
 * @method PartidaAgrupaLinea getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BasePartidaAgrupaLineaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'detalle'           => new sfWidgetFormInputText(),
      'cuenta_contable'   => new sfWidgetFormInputText(),
      'debe'              => new sfWidgetFormInputText(),
      'haber'             => new sfWidgetFormInputText(),
      'empresa_id'        => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'partida_agrupa_id' => new sfWidgetFormPropelChoice(array('model' => 'PartidaAgrupa', 'add_empty' => true)),
      'cantidad'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'detalle'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'cuenta_contable'   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'debe'              => new sfValidatorNumber(array('required' => false)),
      'haber'             => new sfValidatorNumber(array('required' => false)),
      'empresa_id'        => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'partida_agrupa_id' => new sfValidatorPropelChoice(array('model' => 'PartidaAgrupa', 'column' => 'id', 'required' => false)),
      'cantidad'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('partida_agrupa_linea[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PartidaAgrupaLinea';
  }


}
