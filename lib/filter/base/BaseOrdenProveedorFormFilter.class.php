<?php

/**
 * OrdenProveedor filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseOrdenProveedorFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'                => new sfWidgetFormFilterInput(),
      'empresa_id'            => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'proveedor_id'          => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'nit'                   => new sfWidgetFormFilterInput(),
      'nombre'                => new sfWidgetFormFilterInput(),
      'no_documento'          => new sfWidgetFormFilterInput(),
      'fecha_documento'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_contabilizacion' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'dia_credito'           => new sfWidgetFormFilterInput(),
      'excento'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'usuario'               => new sfWidgetFormFilterInput(),
      'estatus'               => new sfWidgetFormFilterInput(),
      'comentario'            => new sfWidgetFormFilterInput(),
      'sub_total'             => new sfWidgetFormFilterInput(),
      'iva'                   => new sfWidgetFormFilterInput(),
      'valor_total'           => new sfWidgetFormFilterInput(),
      'partida_no'            => new sfWidgetFormFilterInput(),
      'tienda_id'             => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'serie'                 => new sfWidgetFormFilterInput(),
      'token'                 => new sfWidgetFormFilterInput(),
      'usuario_confirmo'      => new sfWidgetFormFilterInput(),
      'fecha_confirmo'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'despacho'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'valor_pagado'          => new sfWidgetFormFilterInput(),
      'aplica_isr'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'aplica_iva'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'valor_impuesto'        => new sfWidgetFormFilterInput(),
      'excento_isr'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'valor_isr'             => new sfWidgetFormFilterInput(),
      'valor_retiene_iva'     => new sfWidgetFormFilterInput(),
      'confrontado_sat'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'no_sat'                => new sfWidgetFormFilterInput(),
      'impuesto_gas'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'codigo'                => new sfValidatorPass(array('required' => false)),
      'empresa_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'proveedor_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'nit'                   => new sfValidatorPass(array('required' => false)),
      'nombre'                => new sfValidatorPass(array('required' => false)),
      'no_documento'          => new sfValidatorPass(array('required' => false)),
      'fecha_documento'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_contabilizacion' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'dia_credito'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'excento'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'usuario'               => new sfValidatorPass(array('required' => false)),
      'estatus'               => new sfValidatorPass(array('required' => false)),
      'comentario'            => new sfValidatorPass(array('required' => false)),
      'sub_total'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'iva'                   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_total'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'partida_no'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tienda_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'serie'                 => new sfValidatorPass(array('required' => false)),
      'token'                 => new sfValidatorPass(array('required' => false)),
      'usuario_confirmo'      => new sfValidatorPass(array('required' => false)),
      'fecha_confirmo'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'despacho'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'valor_pagado'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'aplica_isr'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'aplica_iva'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'valor_impuesto'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'excento_isr'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'valor_isr'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_retiene_iva'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'confrontado_sat'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'no_sat'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'impuesto_gas'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('orden_proveedor_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenProveedor';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'codigo'                => 'Text',
      'empresa_id'            => 'ForeignKey',
      'proveedor_id'          => 'ForeignKey',
      'nit'                   => 'Text',
      'nombre'                => 'Text',
      'no_documento'          => 'Text',
      'fecha_documento'       => 'Date',
      'fecha_contabilizacion' => 'Date',
      'fecha'                 => 'Date',
      'dia_credito'           => 'Number',
      'excento'               => 'Boolean',
      'usuario'               => 'Text',
      'estatus'               => 'Text',
      'comentario'            => 'Text',
      'sub_total'             => 'Number',
      'iva'                   => 'Number',
      'valor_total'           => 'Number',
      'partida_no'            => 'Number',
      'tienda_id'             => 'ForeignKey',
      'serie'                 => 'Text',
      'token'                 => 'Text',
      'usuario_confirmo'      => 'Text',
      'fecha_confirmo'        => 'Date',
      'despacho'              => 'Boolean',
      'valor_pagado'          => 'Number',
      'aplica_isr'            => 'Boolean',
      'aplica_iva'            => 'Boolean',
      'valor_impuesto'        => 'Number',
      'excento_isr'           => 'Boolean',
      'valor_isr'             => 'Number',
      'valor_retiene_iva'     => 'Number',
      'confrontado_sat'       => 'Boolean',
      'no_sat'                => 'Number',
      'impuesto_gas'          => 'Number',
    );
  }
}
