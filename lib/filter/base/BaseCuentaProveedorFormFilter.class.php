<?php

/**
 * CuentaProveedor filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseCuentaProveedorFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'         => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'orden_proveedor_id' => new sfWidgetFormPropelChoice(array('model' => 'OrdenProveedor', 'add_empty' => true)),
      'proveedor_id'       => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'fecha'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'detalle'            => new sfWidgetFormFilterInput(),
      'valor_total'        => new sfWidgetFormFilterInput(),
      'fecha_pago'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'valor_pagado'       => new sfWidgetFormFilterInput(),
      'cuenta_contable'    => new sfWidgetFormFilterInput(),
      'pagado'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'updated_by'         => new sfWidgetFormFilterInput(),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'gasto_id'           => new sfWidgetFormPropelChoice(array('model' => 'Gasto', 'add_empty' => true)),
      'contrasena_no'      => new sfWidgetFormFilterInput(),
      'seleccionado'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'empresa_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'orden_proveedor_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'OrdenProveedor', 'column' => 'id')),
      'proveedor_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'fecha'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'detalle'            => new sfValidatorPass(array('required' => false)),
      'valor_total'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'fecha_pago'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'valor_pagado'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cuenta_contable'    => new sfValidatorPass(array('required' => false)),
      'pagado'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'updated_by'         => new sfValidatorPass(array('required' => false)),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'gasto_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Gasto', 'column' => 'id')),
      'contrasena_no'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'seleccionado'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('cuenta_proveedor_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CuentaProveedor';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'empresa_id'         => 'ForeignKey',
      'orden_proveedor_id' => 'ForeignKey',
      'proveedor_id'       => 'ForeignKey',
      'fecha'              => 'Date',
      'detalle'            => 'Text',
      'valor_total'        => 'Number',
      'fecha_pago'         => 'Date',
      'valor_pagado'       => 'Number',
      'cuenta_contable'    => 'Text',
      'pagado'             => 'Boolean',
      'updated_by'         => 'Text',
      'updated_at'         => 'Date',
      'gasto_id'           => 'ForeignKey',
      'contrasena_no'      => 'Number',
      'seleccionado'       => 'Boolean',
    );
  }
}
