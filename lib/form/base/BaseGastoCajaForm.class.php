<?php

/**
 * GastoCaja form base class.
 *
 * @method GastoCaja getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseGastoCajaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'tienda_id'     => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'fecha'         => new sfWidgetFormDate(),
      'concepto'      => new sfWidgetFormInputText(),
      'usuario'       => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'estatus'       => new sfWidgetFormInputText(),
      'gasto_id'      => new sfWidgetFormPropelChoice(array('model' => 'Gasto', 'add_empty' => true)),
      'valor'         => new sfWidgetFormInputText(),
      'observaciones' => new sfWidgetFormTextarea(),
      'cuenta'        => new sfWidgetFormInputText(),
      'partida_no'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'tienda_id'     => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'empresa_id'    => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'fecha'         => new sfValidatorDate(array('required' => false)),
      'concepto'      => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'usuario'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'estatus'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'gasto_id'      => new sfValidatorPropelChoice(array('model' => 'Gasto', 'column' => 'id', 'required' => false)),
      'valor'         => new sfValidatorNumber(array('required' => false)),
      'observaciones' => new sfValidatorString(array('required' => false)),
      'cuenta'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'partida_no'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('gasto_caja[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'GastoCaja';
  }


}
