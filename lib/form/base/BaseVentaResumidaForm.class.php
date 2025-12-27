<?php

/**
 * VentaResumida form base class.
 *
 * @method VentaResumida getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseVentaResumidaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'medio_pago_id' => new sfWidgetFormPropelChoice(array('model' => 'MedioPago', 'add_empty' => true)),
      'tienda_id'     => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'fecha'         => new sfWidgetFormDate(),
      'total'         => new sfWidgetFormInputText(),
      'comision'      => new sfWidgetFormInputText(),
      'iva'           => new sfWidgetFormInputText(),
      'retencion'     => new sfWidgetFormInputText(),
      'documento'     => new sfWidgetFormInputText(),
      'observaciones' => new sfWidgetFormInputText(),
      'usuario'       => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'partida_no'    => new sfWidgetFormInputText(),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'linea'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'medio_pago_id' => new sfValidatorPropelChoice(array('model' => 'MedioPago', 'column' => 'id', 'required' => false)),
      'tienda_id'     => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'fecha'         => new sfValidatorDate(array('required' => false)),
      'total'         => new sfValidatorNumber(array('required' => false)),
      'comision'      => new sfValidatorNumber(array('required' => false)),
      'iva'           => new sfValidatorNumber(array('required' => false)),
      'retencion'     => new sfValidatorNumber(array('required' => false)),
      'documento'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'observaciones' => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'usuario'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'partida_no'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'empresa_id'    => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'linea'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('venta_resumida[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'VentaResumida';
  }


}
