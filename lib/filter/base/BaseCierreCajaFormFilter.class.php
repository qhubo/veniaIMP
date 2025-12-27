<?php

/**
 * CierreCaja filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseCierreCajaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha_creo'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'usuario'          => new sfWidgetFormFilterInput(),
      'fecha_calendario' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'valor_total'      => new sfWidgetFormFilterInput(),
      'no_documentos'    => new sfWidgetFormFilterInput(),
      'valor_caja'       => new sfWidgetFormFilterInput(),
      'estatus'          => new sfWidgetFormFilterInput(),
      'inicio'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fin'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tienda_id'        => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'cierre_dia_id'    => new sfWidgetFormPropelChoice(array('model' => 'Cierre', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'fecha_creo'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'usuario'          => new sfValidatorPass(array('required' => false)),
      'fecha_calendario' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'valor_total'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'no_documentos'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'valor_caja'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'estatus'          => new sfValidatorPass(array('required' => false)),
      'inicio'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fin'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'empresa_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'tienda_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'cierre_dia_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Cierre', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('cierre_caja_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CierreCaja';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'fecha_creo'       => 'Date',
      'usuario'          => 'Text',
      'fecha_calendario' => 'Date',
      'valor_total'      => 'Number',
      'no_documentos'    => 'Number',
      'valor_caja'       => 'Number',
      'estatus'          => 'Text',
      'inicio'           => 'Date',
      'fin'              => 'Date',
      'empresa_id'       => 'ForeignKey',
      'tienda_id'        => 'ForeignKey',
      'cierre_dia_id'    => 'ForeignKey',
    );
  }
}
