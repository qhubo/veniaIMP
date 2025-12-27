<?php

/**
 * OperacionPago form base class.
 *
 * @method OperacionPago getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseOperacionPagoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'operacion_id'    => new sfWidgetFormPropelChoice(array('model' => 'Operacion', 'add_empty' => true)),
      'tipo'            => new sfWidgetFormInputText(),
      'valor'           => new sfWidgetFormInputText(),
      'documento'       => new sfWidgetFormInputText(),
      'fecha_documento' => new sfWidgetFormDate(),
      'banco_id'        => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'cuenta_contable' => new sfWidgetFormInputText(),
      'partida_no'      => new sfWidgetFormInputText(),
      'usuario'         => new sfWidgetFormInputText(),
      'fecha_creo'      => new sfWidgetFormDateTime(),
      'cxc_cobrar'      => new sfWidgetFormInputText(),
      'comision'        => new sfWidgetFormInputText(),
      'vuelto'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'      => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'operacion_id'    => new sfValidatorPropelChoice(array('model' => 'Operacion', 'column' => 'id', 'required' => false)),
      'tipo'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'valor'           => new sfValidatorNumber(array('required' => false)),
      'documento'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_documento' => new sfValidatorDate(array('required' => false)),
      'banco_id'        => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
      'cuenta_contable' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'partida_no'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'usuario'         => new sfValidatorString(array('max_length' => 52, 'required' => false)),
      'fecha_creo'      => new sfValidatorDateTime(array('required' => false)),
      'cxc_cobrar'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'comision'        => new sfValidatorNumber(array('required' => false)),
      'vuelto'          => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('operacion_pago[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OperacionPago';
  }


}
