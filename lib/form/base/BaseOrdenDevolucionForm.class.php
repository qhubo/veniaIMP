<?php

/**
 * OrdenDevolucion form base class.
 *
 * @method OrdenDevolucion getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseOrdenDevolucionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'fecha'                   => new sfWidgetFormDate(),
      'nombre'                  => new sfWidgetFormInputText(),
      'referencia_factura'      => new sfWidgetFormInputText(),
      'concepto'                => new sfWidgetFormInputText(),
      'archivo'                 => new sfWidgetFormInputText(),
      'valor'                   => new sfWidgetFormInputText(),
      'retencion'               => new sfWidgetFormInputCheckbox(),
      'partida_no'              => new sfWidgetFormInputText(),
      'estatus'                 => new sfWidgetFormInputText(),
      'cheque_no'               => new sfWidgetFormInputText(),
      'usuario_creo'            => new sfWidgetFormInputText(),
      'created_at'              => new sfWidgetFormDateTime(),
      'usuario_confirmo'        => new sfWidgetFormInputText(),
      'updated_at'              => new sfWidgetFormDateTime(),
      'motivo_autorizo'         => new sfWidgetFormInputText(),
      'valor_otros'             => new sfWidgetFormInputText(),
      'empresa_id'              => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'token'                   => new sfWidgetFormInputText(),
      'codigo'                  => new sfWidgetFormInputText(),
      'fecha_confirmo'          => new sfWidgetFormDateTime(),
      'porcentaje_retenie'      => new sfWidgetFormInputText(),
      'tipo'                    => new sfWidgetFormInputText(),
      'proveedor_id'            => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'pago_medio'              => new sfWidgetFormInputText(),
      'vendedor'                => new sfWidgetFormInputText(),
      'referencia_nota'         => new sfWidgetFormInputText(),
      'no_hollander'            => new sfWidgetFormInputText(),
      'no_stock'                => new sfWidgetFormInputText(),
      'descripcion'             => new sfWidgetFormInputText(),
      'solicitud_devolucion_id' => new sfWidgetFormPropelChoice(array('model' => 'SolicitudDevolucion', 'add_empty' => true)),
      'archivo_2'               => new sfWidgetFormInputText(),
      'tienda_id'               => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'fecha_factura'           => new sfWidgetFormDate(),
      'motivo'                  => new sfWidgetFormInputText(),
      'detalle_motivo'          => new sfWidgetFormInputText(),
      'detalle_repuesto'        => new sfWidgetFormInputText(),
      'producto_id'             => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'cantidad'                => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'fecha'                   => new sfValidatorDate(array('required' => false)),
      'nombre'                  => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'referencia_factura'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'concepto'                => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'archivo'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'valor'                   => new sfValidatorNumber(array('required' => false)),
      'retencion'               => new sfValidatorBoolean(array('required' => false)),
      'partida_no'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'estatus'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'cheque_no'               => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'usuario_creo'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'usuario_confirmo'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'updated_at'              => new sfValidatorDateTime(array('required' => false)),
      'motivo_autorizo'         => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'valor_otros'             => new sfValidatorNumber(array('required' => false)),
      'empresa_id'              => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'token'                   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'codigo'                  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_confirmo'          => new sfValidatorDateTime(array('required' => false)),
      'porcentaje_retenie'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tipo'                    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'proveedor_id'            => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'pago_medio'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'vendedor'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'referencia_nota'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'no_hollander'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'no_stock'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'descripcion'             => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'solicitud_devolucion_id' => new sfValidatorPropelChoice(array('model' => 'SolicitudDevolucion', 'column' => 'id', 'required' => false)),
      'archivo_2'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'tienda_id'               => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'fecha_factura'           => new sfValidatorDate(array('required' => false)),
      'motivo'                  => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'detalle_motivo'          => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'detalle_repuesto'        => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'producto_id'             => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'cantidad'                => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('orden_devolucion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenDevolucion';
  }


}
