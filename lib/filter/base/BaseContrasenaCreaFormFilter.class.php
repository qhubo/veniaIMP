<?php

/**
 * ContrasenaCrea filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseContrasenaCreaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'       => new sfWidgetFormFilterInput(),
      'fecha'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'estatus'      => new sfWidgetFormFilterInput(),
      'proveedor_id' => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'dias_credito' => new sfWidgetFormFilterInput(),
      'fecha_pago'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'valor'        => new sfWidgetFormFilterInput(),
      'empresa_id'   => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'codigo'       => new sfValidatorPass(array('required' => false)),
      'fecha'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'estatus'      => new sfValidatorPass(array('required' => false)),
      'proveedor_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'dias_credito' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha_pago'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'valor'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'empresa_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('contrasena_crea_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContrasenaCrea';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'codigo'       => 'Text',
      'fecha'        => 'Date',
      'estatus'      => 'Text',
      'proveedor_id' => 'ForeignKey',
      'dias_credito' => 'Number',
      'fecha_pago'   => 'Date',
      'valor'        => 'Number',
      'empresa_id'   => 'ForeignKey',
    );
  }
}
