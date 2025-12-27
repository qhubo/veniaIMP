<?php

/**
 * OrdenDevolucion filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseOrdenDevolucionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'nombre'                  => new sfWidgetFormFilterInput(),
      'referencia_factura'      => new sfWidgetFormFilterInput(),
      'concepto'                => new sfWidgetFormFilterInput(),
      'archivo'                 => new sfWidgetFormFilterInput(),
      'valor'                   => new sfWidgetFormFilterInput(),
      'retencion'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'partida_no'              => new sfWidgetFormFilterInput(),
      'estatus'                 => new sfWidgetFormFilterInput(),
      'cheque_no'               => new sfWidgetFormFilterInput(),
      'usuario_creo'            => new sfWidgetFormFilterInput(),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'usuario_confirmo'        => new sfWidgetFormFilterInput(),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'motivo_autorizo'         => new sfWidgetFormFilterInput(),
      'valor_otros'             => new sfWidgetFormFilterInput(),
      'empresa_id'              => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'token'                   => new sfWidgetFormFilterInput(),
      'codigo'                  => new sfWidgetFormFilterInput(),
      'fecha_confirmo'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'porcentaje_retenie'      => new sfWidgetFormFilterInput(),
      'tipo'                    => new sfWidgetFormFilterInput(),
      'proveedor_id'            => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'pago_medio'              => new sfWidgetFormFilterInput(),
      'vendedor'                => new sfWidgetFormFilterInput(),
      'referencia_nota'         => new sfWidgetFormFilterInput(),
      'no_hollander'            => new sfWidgetFormFilterInput(),
      'no_stock'                => new sfWidgetFormFilterInput(),
      'descripcion'             => new sfWidgetFormFilterInput(),
      'solicitud_devolucion_id' => new sfWidgetFormPropelChoice(array('model' => 'SolicitudDevolucion', 'add_empty' => true)),
      'archivo_2'               => new sfWidgetFormFilterInput(),
      'tienda_id'               => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'fecha_factura'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'motivo'                  => new sfWidgetFormFilterInput(),
      'detalle_motivo'          => new sfWidgetFormFilterInput(),
      'detalle_repuesto'        => new sfWidgetFormFilterInput(),
      'producto_id'             => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'cantidad'                => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'fecha'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'nombre'                  => new sfValidatorPass(array('required' => false)),
      'referencia_factura'      => new sfValidatorPass(array('required' => false)),
      'concepto'                => new sfValidatorPass(array('required' => false)),
      'archivo'                 => new sfValidatorPass(array('required' => false)),
      'valor'                   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'retencion'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'partida_no'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'estatus'                 => new sfValidatorPass(array('required' => false)),
      'cheque_no'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'usuario_creo'            => new sfValidatorPass(array('required' => false)),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'usuario_confirmo'        => new sfValidatorPass(array('required' => false)),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'motivo_autorizo'         => new sfValidatorPass(array('required' => false)),
      'valor_otros'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'empresa_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'token'                   => new sfValidatorPass(array('required' => false)),
      'codigo'                  => new sfValidatorPass(array('required' => false)),
      'fecha_confirmo'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'porcentaje_retenie'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tipo'                    => new sfValidatorPass(array('required' => false)),
      'proveedor_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'pago_medio'              => new sfValidatorPass(array('required' => false)),
      'vendedor'                => new sfValidatorPass(array('required' => false)),
      'referencia_nota'         => new sfValidatorPass(array('required' => false)),
      'no_hollander'            => new sfValidatorPass(array('required' => false)),
      'no_stock'                => new sfValidatorPass(array('required' => false)),
      'descripcion'             => new sfValidatorPass(array('required' => false)),
      'solicitud_devolucion_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SolicitudDevolucion', 'column' => 'id')),
      'archivo_2'               => new sfValidatorPass(array('required' => false)),
      'tienda_id'               => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'fecha_factura'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'motivo'                  => new sfValidatorPass(array('required' => false)),
      'detalle_motivo'          => new sfValidatorPass(array('required' => false)),
      'detalle_repuesto'        => new sfValidatorPass(array('required' => false)),
      'producto_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'cantidad'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('orden_devolucion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenDevolucion';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'fecha'                   => 'Date',
      'nombre'                  => 'Text',
      'referencia_factura'      => 'Text',
      'concepto'                => 'Text',
      'archivo'                 => 'Text',
      'valor'                   => 'Number',
      'retencion'               => 'Boolean',
      'partida_no'              => 'Number',
      'estatus'                 => 'Text',
      'cheque_no'               => 'Number',
      'usuario_creo'            => 'Text',
      'created_at'              => 'Date',
      'usuario_confirmo'        => 'Text',
      'updated_at'              => 'Date',
      'motivo_autorizo'         => 'Text',
      'valor_otros'             => 'Number',
      'empresa_id'              => 'ForeignKey',
      'token'                   => 'Text',
      'codigo'                  => 'Text',
      'fecha_confirmo'          => 'Date',
      'porcentaje_retenie'      => 'Number',
      'tipo'                    => 'Text',
      'proveedor_id'            => 'ForeignKey',
      'pago_medio'              => 'Text',
      'vendedor'                => 'Text',
      'referencia_nota'         => 'Text',
      'no_hollander'            => 'Text',
      'no_stock'                => 'Text',
      'descripcion'             => 'Text',
      'solicitud_devolucion_id' => 'ForeignKey',
      'archivo_2'               => 'Text',
      'tienda_id'               => 'ForeignKey',
      'fecha_factura'           => 'Date',
      'motivo'                  => 'Text',
      'detalle_motivo'          => 'Text',
      'detalle_repuesto'        => 'Text',
      'producto_id'             => 'ForeignKey',
      'cantidad'                => 'Number',
    );
  }
}
