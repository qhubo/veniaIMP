<?php

/**
 * UsuarioCorteValor form base class.
 *
 * @method UsuarioCorteValor getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseUsuarioCorteValorForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'usuario_id' => new sfWidgetFormPropelChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'banco_id'   => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'documento'  => new sfWidgetFormInputText(),
      'medio_pago' => new sfWidgetFormInputText(),
      'valor'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'usuario_id' => new sfValidatorPropelChoice(array('model' => 'Usuario', 'column' => 'id', 'required' => false)),
      'banco_id'   => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
      'documento'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'medio_pago' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'valor'      => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_corte_valor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioCorteValor';
  }


}
