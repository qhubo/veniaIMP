<?php

/**
 * GastoDetalle form base class.
 *
 * @method GastoDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseGastoDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'gasto_id'        => new sfWidgetFormPropelChoice(array('model' => 'Gasto', 'add_empty' => true)),
      'cuenta_contable' => new sfWidgetFormInputText(),
      'concepto'        => new sfWidgetFormInputText(),
      'cantidad'        => new sfWidgetFormInputText(),
      'sub_total'       => new sfWidgetFormInputText(),
      'iva'             => new sfWidgetFormInputText(),
      'valor_total'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'gasto_id'        => new sfValidatorPropelChoice(array('model' => 'Gasto', 'column' => 'id', 'required' => false)),
      'cuenta_contable' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'concepto'        => new sfValidatorString(array('max_length' => 350, 'required' => false)),
      'cantidad'        => new sfValidatorNumber(array('required' => false)),
      'sub_total'       => new sfValidatorNumber(array('required' => false)),
      'iva'             => new sfValidatorNumber(array('required' => false)),
      'valor_total'     => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('gasto_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'GastoDetalle';
  }


}
