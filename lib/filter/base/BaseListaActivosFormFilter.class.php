<?php

/**
 * ListaActivos filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseListaActivosFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'                 => new sfWidgetFormFilterInput(),
      'cuenta_contable'        => new sfWidgetFormFilterInput(),
      'detalle'                => new sfWidgetFormFilterInput(),
      'fecha_adquision'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'anio_util'              => new sfWidgetFormFilterInput(),
      'valor_libro'            => new sfWidgetFormFilterInput(),
      'porcentaje'             => new sfWidgetFormFilterInput(),
      'cuenta_erp_contable_id' => new sfWidgetFormPropelChoice(array('model' => 'CuentaErpContable', 'add_empty' => true)),
      'usuario'                => new sfWidgetFormFilterInput(),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'activo'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'empresa_id'             => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'codigo'                 => new sfValidatorPass(array('required' => false)),
      'cuenta_contable'        => new sfValidatorPass(array('required' => false)),
      'detalle'                => new sfValidatorPass(array('required' => false)),
      'fecha_adquision'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'anio_util'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'valor_libro'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'porcentaje'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cuenta_erp_contable_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'CuentaErpContable', 'column' => 'id')),
      'usuario'                => new sfValidatorPass(array('required' => false)),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'activo'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'empresa_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('lista_activos_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaActivos';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'codigo'                 => 'Text',
      'cuenta_contable'        => 'Text',
      'detalle'                => 'Text',
      'fecha_adquision'        => 'Date',
      'anio_util'              => 'Number',
      'valor_libro'            => 'Number',
      'porcentaje'             => 'Number',
      'cuenta_erp_contable_id' => 'ForeignKey',
      'usuario'                => 'Text',
      'updated_at'             => 'Date',
      'activo'                 => 'Boolean',
      'empresa_id'             => 'ForeignKey',
    );
  }
}
