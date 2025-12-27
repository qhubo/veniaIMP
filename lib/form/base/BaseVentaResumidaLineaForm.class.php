<?php

/**
 * VentaResumidaLinea form base class.
 *
 * @method VentaResumidaLinea getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseVentaResumidaLineaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'venta_resumida_id' => new sfWidgetFormPropelChoice(array('model' => 'VentaResumida', 'add_empty' => true)),
      'numero_cuotas'     => new sfWidgetFormInputText(),
      'total_linea'       => new sfWidgetFormInputText(),
      'comision_linea'    => new sfWidgetFormInputText(),
      'iva_linea'         => new sfWidgetFormInputText(),
      'retencion_linea'   => new sfWidgetFormInputText(),
      'medio_pago_id'     => new sfWidgetFormPropelChoice(array('model' => 'MedioPago', 'add_empty' => true)),
      'empresa_id'        => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'banco_id'          => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'venta_resumida_id' => new sfValidatorPropelChoice(array('model' => 'VentaResumida', 'column' => 'id', 'required' => false)),
      'numero_cuotas'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'total_linea'       => new sfValidatorNumber(array('required' => false)),
      'comision_linea'    => new sfValidatorNumber(array('required' => false)),
      'iva_linea'         => new sfValidatorNumber(array('required' => false)),
      'retencion_linea'   => new sfValidatorNumber(array('required' => false)),
      'medio_pago_id'     => new sfValidatorPropelChoice(array('model' => 'MedioPago', 'column' => 'id', 'required' => false)),
      'empresa_id'        => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'banco_id'          => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('venta_resumida_linea[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'VentaResumidaLinea';
  }


}
