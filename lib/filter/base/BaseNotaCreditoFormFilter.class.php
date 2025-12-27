<?php

/**
 * NotaCredito filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseNotaCreditoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'numero'                => new sfWidgetFormFilterInput(),
      'codigo'                => new sfWidgetFormFilterInput(),
      'fecha'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'cliente_id'            => new sfWidgetFormPropelChoice(array('model' => 'Cliente', 'add_empty' => true)),
      'proveedor_id'          => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'nombre'                => new sfWidgetFormFilterInput(),
      'documento'             => new sfWidgetFormFilterInput(),
      'tipo_documento'        => new sfWidgetFormFilterInput(),
      'sub_total'             => new sfWidgetFormFilterInput(),
      'iva'                   => new sfWidgetFormFilterInput(),
      'valor_total'           => new sfWidgetFormFilterInput(),
      'estatus'               => new sfWidgetFormFilterInput(),
      'empresa_id'            => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'medio_pago_id'         => new sfWidgetFormPropelChoice(array('model' => 'MedioPago', 'add_empty' => true)),
      'fecha_contabilizacion' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'dias_credito'          => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'            => new sfWidgetFormFilterInput(),
      'updated_by'            => new sfWidgetFormFilterInput(),
      'usuario'               => new sfWidgetFormFilterInput(),
      'partida_no'            => new sfWidgetFormFilterInput(),
      'concepto'              => new sfWidgetFormFilterInput(),
      'tipo_nota'             => new sfWidgetFormFilterInput(),
      'face_firma'            => new sfWidgetFormFilterInput(),
      'valor_pagado'          => new sfWidgetFormFilterInput(),
      'documento_canje'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'numero'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'codigo'                => new sfValidatorPass(array('required' => false)),
      'fecha'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cliente_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Cliente', 'column' => 'id')),
      'proveedor_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'nombre'                => new sfValidatorPass(array('required' => false)),
      'documento'             => new sfValidatorPass(array('required' => false)),
      'tipo_documento'        => new sfValidatorPass(array('required' => false)),
      'sub_total'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'iva'                   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_total'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'estatus'               => new sfValidatorPass(array('required' => false)),
      'empresa_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'medio_pago_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'MedioPago', 'column' => 'id')),
      'fecha_contabilizacion' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'dias_credito'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'            => new sfValidatorPass(array('required' => false)),
      'updated_by'            => new sfValidatorPass(array('required' => false)),
      'usuario'               => new sfValidatorPass(array('required' => false)),
      'partida_no'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'concepto'              => new sfValidatorPass(array('required' => false)),
      'tipo_nota'             => new sfValidatorPass(array('required' => false)),
      'face_firma'            => new sfValidatorPass(array('required' => false)),
      'valor_pagado'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'documento_canje'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('nota_credito_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotaCredito';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'numero'                => 'Number',
      'codigo'                => 'Text',
      'fecha'                 => 'Date',
      'cliente_id'            => 'ForeignKey',
      'proveedor_id'          => 'ForeignKey',
      'nombre'                => 'Text',
      'documento'             => 'Text',
      'tipo_documento'        => 'Text',
      'sub_total'             => 'Number',
      'iva'                   => 'Number',
      'valor_total'           => 'Number',
      'estatus'               => 'Text',
      'empresa_id'            => 'ForeignKey',
      'medio_pago_id'         => 'ForeignKey',
      'fecha_contabilizacion' => 'Date',
      'dias_credito'          => 'Number',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
      'created_by'            => 'Text',
      'updated_by'            => 'Text',
      'usuario'               => 'Text',
      'partida_no'            => 'Number',
      'concepto'              => 'Text',
      'tipo_nota'             => 'Text',
      'face_firma'            => 'Text',
      'valor_pagado'          => 'Number',
      'documento_canje'       => 'Text',
    );
  }
}
