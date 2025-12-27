<?php

/**
 * EgresosRecibido filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseEgresosRecibidoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'medio_pago_id' => new sfWidgetFormPropelChoice(array('model' => 'MedioPago', 'add_empty' => true)),
      'tienda_id'     => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'fecha'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'total'         => new sfWidgetFormFilterInput(),
      'partida_no'    => new sfWidgetFormFilterInput(),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'usuario_creo'  => new sfWidgetFormFilterInput(),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'observaciones' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'medio_pago_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'MedioPago', 'column' => 'id')),
      'tienda_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'fecha'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'total'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'partida_no'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'empresa_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'usuario_creo'  => new sfValidatorPass(array('required' => false)),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'observaciones' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('egresos_recibido_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EgresosRecibido';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'medio_pago_id' => 'ForeignKey',
      'tienda_id'     => 'ForeignKey',
      'fecha'         => 'Date',
      'total'         => 'Number',
      'partida_no'    => 'Number',
      'empresa_id'    => 'ForeignKey',
      'usuario_creo'  => 'Text',
      'created_at'    => 'Date',
      'observaciones' => 'Text',
    );
  }
}
