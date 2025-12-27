<?php

/**
 * NotaCreditoDetalle form base class.
 *
 * @method NotaCreditoDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseNotaCreditoDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'nota_credito_id' => new sfWidgetFormPropelChoice(array('model' => 'NotaCredito', 'add_empty' => true)),
      'cantidad'        => new sfWidgetFormInputText(),
      'detalle'         => new sfWidgetFormInputText(),
      'sub_total'       => new sfWidgetFormInputText(),
      'iva'             => new sfWidgetFormInputText(),
      'valor_total'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'nota_credito_id' => new sfValidatorPropelChoice(array('model' => 'NotaCredito', 'column' => 'id', 'required' => false)),
      'cantidad'        => new sfValidatorNumber(array('required' => false)),
      'detalle'         => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'sub_total'       => new sfValidatorNumber(array('required' => false)),
      'iva'             => new sfValidatorNumber(array('required' => false)),
      'valor_total'     => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('nota_credito_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotaCreditoDetalle';
  }


}
