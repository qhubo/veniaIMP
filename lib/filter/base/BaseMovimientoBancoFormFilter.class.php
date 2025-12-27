<?php

/**
 * MovimientoBanco filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseMovimientoBancoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'              => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tipo'                    => new sfWidgetFormFilterInput(),
      'identificador'           => new sfWidgetFormFilterInput(),
      'tipo_movimiento'         => new sfWidgetFormFilterInput(),
      'banco_id'                => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'documento'               => new sfWidgetFormFilterInput(),
      'fecha_documento'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'valor'                   => new sfWidgetFormFilterInput(),
      'usuario'                 => new sfWidgetFormFilterInput(),
      'created_by'              => new sfWidgetFormFilterInput(),
      'updated_by'              => new sfWidgetFormFilterInput(),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'cuenta_contable'         => new sfWidgetFormFilterInput(),
      'partida_no'              => new sfWidgetFormFilterInput(),
      'concepto'                => new sfWidgetFormFilterInput(),
      'banco_origen'            => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'estatus'                 => new sfWidgetFormFilterInput(),
      'observaciones'           => new sfWidgetFormFilterInput(),
      'medio_pago_id'           => new sfWidgetFormPropelChoice(array('model' => 'MedioPago', 'add_empty' => true)),
      'tienda_id'               => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'bitacora_archivo_id'     => new sfWidgetFormPropelChoice(array('model' => 'BitacoraArchivo', 'add_empty' => true)),
      'confirmado_banco'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'usuario_confirmo_banco'  => new sfWidgetFormFilterInput(),
      'fecha_confirmo_banco'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'venta_resumida_linea_id' => new sfWidgetFormPropelChoice(array('model' => 'VentaResumidaLinea', 'add_empty' => true)),
      'revisado'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'tasa_cambio'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'tipo'                    => new sfValidatorPass(array('required' => false)),
      'identificador'           => new sfValidatorPass(array('required' => false)),
      'tipo_movimiento'         => new sfValidatorPass(array('required' => false)),
      'banco_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
      'documento'               => new sfValidatorPass(array('required' => false)),
      'fecha_documento'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'valor'                   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'usuario'                 => new sfValidatorPass(array('required' => false)),
      'created_by'              => new sfValidatorPass(array('required' => false)),
      'updated_by'              => new sfValidatorPass(array('required' => false)),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cuenta_contable'         => new sfValidatorPass(array('required' => false)),
      'partida_no'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'concepto'                => new sfValidatorPass(array('required' => false)),
      'banco_origen'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
      'estatus'                 => new sfValidatorPass(array('required' => false)),
      'observaciones'           => new sfValidatorPass(array('required' => false)),
      'medio_pago_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'MedioPago', 'column' => 'id')),
      'tienda_id'               => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'bitacora_archivo_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'BitacoraArchivo', 'column' => 'id')),
      'confirmado_banco'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'usuario_confirmo_banco'  => new sfValidatorPass(array('required' => false)),
      'fecha_confirmo_banco'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'venta_resumida_linea_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'VentaResumidaLinea', 'column' => 'id')),
      'revisado'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'tasa_cambio'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('movimiento_banco_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MovimientoBanco';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'empresa_id'              => 'ForeignKey',
      'tipo'                    => 'Text',
      'identificador'           => 'Text',
      'tipo_movimiento'         => 'Text',
      'banco_id'                => 'ForeignKey',
      'documento'               => 'Text',
      'fecha_documento'         => 'Date',
      'valor'                   => 'Number',
      'usuario'                 => 'Text',
      'created_by'              => 'Text',
      'updated_by'              => 'Text',
      'created_at'              => 'Date',
      'updated_at'              => 'Date',
      'cuenta_contable'         => 'Text',
      'partida_no'              => 'Number',
      'concepto'                => 'Text',
      'banco_origen'            => 'ForeignKey',
      'estatus'                 => 'Text',
      'observaciones'           => 'Text',
      'medio_pago_id'           => 'ForeignKey',
      'tienda_id'               => 'ForeignKey',
      'bitacora_archivo_id'     => 'ForeignKey',
      'confirmado_banco'        => 'Boolean',
      'usuario_confirmo_banco'  => 'Text',
      'fecha_confirmo_banco'    => 'Date',
      'venta_resumida_linea_id' => 'ForeignKey',
      'revisado'                => 'Boolean',
      'tasa_cambio'             => 'Number',
    );
  }
}
