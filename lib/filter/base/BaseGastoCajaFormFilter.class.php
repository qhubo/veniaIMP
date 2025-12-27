<?php

/**
 * GastoCaja filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseGastoCajaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tienda_id'     => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'fecha'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'concepto'      => new sfWidgetFormFilterInput(),
      'usuario'       => new sfWidgetFormFilterInput(),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'estatus'       => new sfWidgetFormFilterInput(),
      'gasto_id'      => new sfWidgetFormPropelChoice(array('model' => 'Gasto', 'add_empty' => true)),
      'valor'         => new sfWidgetFormFilterInput(),
      'observaciones' => new sfWidgetFormFilterInput(),
      'cuenta'        => new sfWidgetFormFilterInput(),
      'partida_no'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'tienda_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'empresa_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'fecha'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'concepto'      => new sfValidatorPass(array('required' => false)),
      'usuario'       => new sfValidatorPass(array('required' => false)),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'estatus'       => new sfValidatorPass(array('required' => false)),
      'gasto_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Gasto', 'column' => 'id')),
      'valor'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'observaciones' => new sfValidatorPass(array('required' => false)),
      'cuenta'        => new sfValidatorPass(array('required' => false)),
      'partida_no'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('gasto_caja_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'GastoCaja';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'tienda_id'     => 'ForeignKey',
      'empresa_id'    => 'ForeignKey',
      'fecha'         => 'Date',
      'concepto'      => 'Text',
      'usuario'       => 'Text',
      'created_at'    => 'Date',
      'estatus'       => 'Text',
      'gasto_id'      => 'ForeignKey',
      'valor'         => 'Number',
      'observaciones' => 'Text',
      'cuenta'        => 'Text',
      'partida_no'    => 'Number',
    );
  }
}
