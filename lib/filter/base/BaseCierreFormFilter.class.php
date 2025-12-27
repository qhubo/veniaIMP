<?php

/**
 * Cierre filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseCierreFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha_creo'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'usuario'     => new sfWidgetFormFilterInput(),
      'valor_total' => new sfWidgetFormFilterInput(),
      'no_cierre'   => new sfWidgetFormFilterInput(),
      'empresa_id'  => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tienda_id'   => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'fecha_creo'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'usuario'     => new sfValidatorPass(array('required' => false)),
      'valor_total' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'no_cierre'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'empresa_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'tienda_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('cierre_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cierre';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'fecha_creo'  => 'Date',
      'usuario'     => 'Text',
      'valor_total' => 'Number',
      'no_cierre'   => 'Number',
      'empresa_id'  => 'ForeignKey',
      'tienda_id'   => 'ForeignKey',
    );
  }
}
