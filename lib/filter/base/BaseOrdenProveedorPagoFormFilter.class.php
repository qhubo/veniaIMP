<?php

/**
 * OrdenProveedorPago filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseOrdenProveedorPagoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'              => new sfWidgetFormFilterInput(),
      'empresa_id'          => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'proveedor_id'        => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'orden_proveedor_id'  => new sfWidgetFormPropelChoice(array('model' => 'OrdenProveedor', 'add_empty' => true)),
      'tipo_pago'           => new sfWidgetFormFilterInput(),
      'documento'           => new sfWidgetFormFilterInput(),
      'fecha'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'valor_total'         => new sfWidgetFormFilterInput(),
      'usuario'             => new sfWidgetFormFilterInput(),
      'fecha_creo'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'cuenta_proveedor_id' => new sfWidgetFormPropelChoice(array('model' => 'CuentaProveedor', 'add_empty' => true)),
      'banco_id'            => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'created_by'          => new sfWidgetFormFilterInput(),
      'updated_by'          => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'cuenta_contable'     => new sfWidgetFormFilterInput(),
      'partida_no'          => new sfWidgetFormFilterInput(),
      'cheque_id'           => new sfWidgetFormPropelChoice(array('model' => 'Cheque', 'add_empty' => true)),
      'temporal'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'codigo'              => new sfValidatorPass(array('required' => false)),
      'empresa_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'proveedor_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'orden_proveedor_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'OrdenProveedor', 'column' => 'id')),
      'tipo_pago'           => new sfValidatorPass(array('required' => false)),
      'documento'           => new sfValidatorPass(array('required' => false)),
      'fecha'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'valor_total'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'usuario'             => new sfValidatorPass(array('required' => false)),
      'fecha_creo'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cuenta_proveedor_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'CuentaProveedor', 'column' => 'id')),
      'banco_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
      'created_by'          => new sfValidatorPass(array('required' => false)),
      'updated_by'          => new sfValidatorPass(array('required' => false)),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cuenta_contable'     => new sfValidatorPass(array('required' => false)),
      'partida_no'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cheque_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Cheque', 'column' => 'id')),
      'temporal'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('orden_proveedor_pago_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenProveedorPago';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'codigo'              => 'Text',
      'empresa_id'          => 'ForeignKey',
      'proveedor_id'        => 'ForeignKey',
      'orden_proveedor_id'  => 'ForeignKey',
      'tipo_pago'           => 'Text',
      'documento'           => 'Text',
      'fecha'               => 'Date',
      'valor_total'         => 'Number',
      'usuario'             => 'Text',
      'fecha_creo'          => 'Date',
      'cuenta_proveedor_id' => 'ForeignKey',
      'banco_id'            => 'ForeignKey',
      'created_by'          => 'Text',
      'updated_by'          => 'Text',
      'created_at'          => 'Date',
      'cuenta_contable'     => 'Text',
      'partida_no'          => 'Number',
      'cheque_id'           => 'ForeignKey',
      'temporal'            => 'Boolean',
    );
  }
}
