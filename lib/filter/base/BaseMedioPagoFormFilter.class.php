<?php

/**
 * MedioPago filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseMedioPagoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'           => new sfWidgetFormFilterInput(),
      'nombre'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'activo'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'cuenta_contable'  => new sfWidgetFormFilterInput(),
      'orden'            => new sfWidgetFormFilterInput(),
      'pos'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'aplica_mov_banco' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_by'       => new sfWidgetFormFilterInput(),
      'updated_by'       => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'aplica_cuotas'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'numero_cuotas'    => new sfWidgetFormFilterInput(),
      'comision'         => new sfWidgetFormFilterInput(),
      'retiene_isr'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'pide_banco'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'banco_id'         => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'pago_proveedor'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'empresa_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'codigo'           => new sfValidatorPass(array('required' => false)),
      'nombre'           => new sfValidatorPass(array('required' => false)),
      'activo'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'cuenta_contable'  => new sfValidatorPass(array('required' => false)),
      'orden'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'pos'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'aplica_mov_banco' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_by'       => new sfValidatorPass(array('required' => false)),
      'updated_by'       => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'aplica_cuotas'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'numero_cuotas'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'comision'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'retiene_isr'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'pide_banco'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'banco_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
      'pago_proveedor'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('medio_pago_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MedioPago';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'empresa_id'       => 'ForeignKey',
      'codigo'           => 'Text',
      'nombre'           => 'Text',
      'activo'           => 'Boolean',
      'cuenta_contable'  => 'Text',
      'orden'            => 'Number',
      'pos'              => 'Boolean',
      'aplica_mov_banco' => 'Boolean',
      'created_by'       => 'Text',
      'updated_by'       => 'Text',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'aplica_cuotas'    => 'Boolean',
      'numero_cuotas'    => 'Number',
      'comision'         => 'Number',
      'retiene_isr'      => 'Boolean',
      'pide_banco'       => 'Boolean',
      'banco_id'         => 'ForeignKey',
      'pago_proveedor'   => 'Boolean',
    );
  }
}
