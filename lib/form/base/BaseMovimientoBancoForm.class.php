<?php

/**
 * MovimientoBanco form base class.
 *
 * @method MovimientoBanco getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseMovimientoBancoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'empresa_id'              => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tipo'                    => new sfWidgetFormInputText(),
      'identificador'           => new sfWidgetFormInputText(),
      'tipo_movimiento'         => new sfWidgetFormInputText(),
      'banco_id'                => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'documento'               => new sfWidgetFormInputText(),
      'fecha_documento'         => new sfWidgetFormDate(),
      'valor'                   => new sfWidgetFormInputText(),
      'usuario'                 => new sfWidgetFormInputText(),
      'created_by'              => new sfWidgetFormInputText(),
      'updated_by'              => new sfWidgetFormInputText(),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
      'cuenta_contable'         => new sfWidgetFormInputText(),
      'partida_no'              => new sfWidgetFormInputText(),
      'concepto'                => new sfWidgetFormInputText(),
      'banco_origen'            => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => false)),
      'estatus'                 => new sfWidgetFormInputText(),
      'observaciones'           => new sfWidgetFormTextarea(),
      'medio_pago_id'           => new sfWidgetFormPropelChoice(array('model' => 'MedioPago', 'add_empty' => true)),
      'tienda_id'               => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'bitacora_archivo_id'     => new sfWidgetFormPropelChoice(array('model' => 'BitacoraArchivo', 'add_empty' => true)),
      'confirmado_banco'        => new sfWidgetFormInputCheckbox(),
      'usuario_confirmo_banco'  => new sfWidgetFormInputText(),
      'fecha_confirmo_banco'    => new sfWidgetFormDateTime(),
      'venta_resumida_linea_id' => new sfWidgetFormPropelChoice(array('model' => 'VentaResumidaLinea', 'add_empty' => true)),
      'revisado'                => new sfWidgetFormInputCheckbox(),
      'tasa_cambio'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'              => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'tipo'                    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'identificador'           => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'tipo_movimiento'         => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'banco_id'                => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
      'documento'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_documento'         => new sfValidatorDate(array('required' => false)),
      'valor'                   => new sfValidatorNumber(array('required' => false)),
      'usuario'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_by'              => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'              => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'updated_at'              => new sfValidatorDateTime(array('required' => false)),
      'cuenta_contable'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'partida_no'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'concepto'                => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'banco_origen'            => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id')),
      'estatus'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'observaciones'           => new sfValidatorString(array('required' => false)),
      'medio_pago_id'           => new sfValidatorPropelChoice(array('model' => 'MedioPago', 'column' => 'id', 'required' => false)),
      'tienda_id'               => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'bitacora_archivo_id'     => new sfValidatorPropelChoice(array('model' => 'BitacoraArchivo', 'column' => 'id', 'required' => false)),
      'confirmado_banco'        => new sfValidatorBoolean(array('required' => false)),
      'usuario_confirmo_banco'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_confirmo_banco'    => new sfValidatorDateTime(array('required' => false)),
      'venta_resumida_linea_id' => new sfValidatorPropelChoice(array('model' => 'VentaResumidaLinea', 'column' => 'id', 'required' => false)),
      'revisado'                => new sfValidatorBoolean(array('required' => false)),
      'tasa_cambio'             => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('movimiento_banco[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MovimientoBanco';
  }


}
