<?php

/**
 * NotaCredito form base class.
 *
 * @method NotaCredito getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseNotaCreditoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'numero'                => new sfWidgetFormInputText(),
      'codigo'                => new sfWidgetFormInputText(),
      'fecha'                 => new sfWidgetFormDate(),
      'cliente_id'            => new sfWidgetFormPropelChoice(array('model' => 'Cliente', 'add_empty' => true)),
      'proveedor_id'          => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'nombre'                => new sfWidgetFormInputText(),
      'documento'             => new sfWidgetFormInputText(),
      'tipo_documento'        => new sfWidgetFormInputText(),
      'sub_total'             => new sfWidgetFormInputText(),
      'iva'                   => new sfWidgetFormInputText(),
      'valor_total'           => new sfWidgetFormInputText(),
      'estatus'               => new sfWidgetFormInputText(),
      'empresa_id'            => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'medio_pago_id'         => new sfWidgetFormPropelChoice(array('model' => 'MedioPago', 'add_empty' => true)),
      'fecha_contabilizacion' => new sfWidgetFormDate(),
      'dias_credito'          => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'created_by'            => new sfWidgetFormInputText(),
      'updated_by'            => new sfWidgetFormInputText(),
      'usuario'               => new sfWidgetFormInputText(),
      'partida_no'            => new sfWidgetFormInputText(),
      'concepto'              => new sfWidgetFormInputText(),
      'tipo_nota'             => new sfWidgetFormInputText(),
      'face_firma'            => new sfWidgetFormInputText(),
      'valor_pagado'          => new sfWidgetFormInputText(),
      'documento_canje'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'numero'                => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'codigo'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha'                 => new sfValidatorDate(array('required' => false)),
      'cliente_id'            => new sfValidatorPropelChoice(array('model' => 'Cliente', 'column' => 'id', 'required' => false)),
      'proveedor_id'          => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'nombre'                => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'documento'             => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'tipo_documento'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'sub_total'             => new sfValidatorNumber(array('required' => false)),
      'iva'                   => new sfValidatorNumber(array('required' => false)),
      'valor_total'           => new sfValidatorNumber(array('required' => false)),
      'estatus'               => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'empresa_id'            => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'medio_pago_id'         => new sfValidatorPropelChoice(array('model' => 'MedioPago', 'column' => 'id', 'required' => false)),
      'fecha_contabilizacion' => new sfValidatorDate(array('required' => false)),
      'dias_credito'          => new sfValidatorNumber(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
      'updated_at'            => new sfValidatorDateTime(array('required' => false)),
      'created_by'            => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'            => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'usuario'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'partida_no'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'concepto'              => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'tipo_nota'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'face_firma'            => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'valor_pagado'          => new sfValidatorNumber(array('required' => false)),
      'documento_canje'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('nota_credito[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotaCredito';
  }


}
