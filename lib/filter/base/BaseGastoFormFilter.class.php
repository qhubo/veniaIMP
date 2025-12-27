<?php

/**
 * Gasto filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseGastoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'             => new sfWidgetFormFilterInput(),
      'usuario'            => new sfWidgetFormFilterInput(),
      'excento'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'empresa_id'         => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'proyecto_id'        => new sfWidgetFormPropelChoice(array('model' => 'Proyecto', 'add_empty' => true)),
      'proveedor_id'       => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'orden_proveedor_id' => new sfWidgetFormPropelChoice(array('model' => 'OrdenProveedor', 'add_empty' => true)),
      'fecha'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'tienda_id'          => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'estatus'            => new sfWidgetFormFilterInput(),
      'dias_credito'       => new sfWidgetFormFilterInput(),
      'tipo_documento'     => new sfWidgetFormFilterInput(),
      'documento'          => new sfWidgetFormFilterInput(),
      'sub_total'          => new sfWidgetFormFilterInput(),
      'iva'                => new sfWidgetFormFilterInput(),
      'valor_total'        => new sfWidgetFormFilterInput(),
      'partida_no'         => new sfWidgetFormFilterInput(),
      'token'              => new sfWidgetFormFilterInput(),
      'observaciones'      => new sfWidgetFormFilterInput(),
      'created_by'         => new sfWidgetFormFilterInput(),
      'updated_by'         => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'valor_pagado'       => new sfWidgetFormFilterInput(),
      'aplica_isr'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'aplica_iva'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'valor_impuesto'     => new sfWidgetFormFilterInput(),
      'excento_isr'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'valor_isr'          => new sfWidgetFormFilterInput(),
      'valor_retiene_iva'  => new sfWidgetFormFilterInput(),
      'retiene_iva'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'valor_retenido_iva' => new sfWidgetFormFilterInput(),
      'confrontado_sat'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'no_sat'             => new sfWidgetFormFilterInput(),
      'valor_idp'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'codigo'             => new sfValidatorPass(array('required' => false)),
      'usuario'            => new sfValidatorPass(array('required' => false)),
      'excento'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'empresa_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'proyecto_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proyecto', 'column' => 'id')),
      'proveedor_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'orden_proveedor_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'OrdenProveedor', 'column' => 'id')),
      'fecha'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'tienda_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'estatus'            => new sfValidatorPass(array('required' => false)),
      'dias_credito'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tipo_documento'     => new sfValidatorPass(array('required' => false)),
      'documento'          => new sfValidatorPass(array('required' => false)),
      'sub_total'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'iva'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_total'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'partida_no'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'token'              => new sfValidatorPass(array('required' => false)),
      'observaciones'      => new sfValidatorPass(array('required' => false)),
      'created_by'         => new sfValidatorPass(array('required' => false)),
      'updated_by'         => new sfValidatorPass(array('required' => false)),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'valor_pagado'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'aplica_isr'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'aplica_iva'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'valor_impuesto'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'excento_isr'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'valor_isr'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_retiene_iva'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'retiene_iva'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'valor_retenido_iva' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'confrontado_sat'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'no_sat'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'valor_idp'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('gasto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Gasto';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'codigo'             => 'Text',
      'usuario'            => 'Text',
      'excento'            => 'Boolean',
      'empresa_id'         => 'ForeignKey',
      'proyecto_id'        => 'ForeignKey',
      'proveedor_id'       => 'ForeignKey',
      'orden_proveedor_id' => 'ForeignKey',
      'fecha'              => 'Date',
      'tienda_id'          => 'ForeignKey',
      'estatus'            => 'Text',
      'dias_credito'       => 'Number',
      'tipo_documento'     => 'Text',
      'documento'          => 'Text',
      'sub_total'          => 'Number',
      'iva'                => 'Number',
      'valor_total'        => 'Number',
      'partida_no'         => 'Number',
      'token'              => 'Text',
      'observaciones'      => 'Text',
      'created_by'         => 'Text',
      'updated_by'         => 'Text',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
      'valor_pagado'       => 'Number',
      'aplica_isr'         => 'Boolean',
      'aplica_iva'         => 'Boolean',
      'valor_impuesto'     => 'Number',
      'excento_isr'        => 'Boolean',
      'valor_isr'          => 'Number',
      'valor_retiene_iva'  => 'Number',
      'retiene_iva'        => 'Boolean',
      'valor_retenido_iva' => 'Number',
      'confrontado_sat'    => 'Boolean',
      'no_sat'             => 'Number',
      'valor_idp'          => 'Number',
    );
  }
}
