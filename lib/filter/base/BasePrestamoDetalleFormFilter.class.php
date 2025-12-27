<?php

/**
 * PrestamoDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BasePrestamoDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'prestamo_id'         => new sfWidgetFormPropelChoice(array('model' => 'Prestamo', 'add_empty' => true)),
      'comentario'          => new sfWidgetFormFilterInput(),
      'fecha_inicio'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_fin'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'dias'                => new sfWidgetFormFilterInput(),
      'tasa_cambio'         => new sfWidgetFormFilterInput(),
      'valor_quetzales'     => new sfWidgetFormFilterInput(),
      'valor_dolares'       => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'          => new sfWidgetFormFilterInput(),
      'tipo'                => new sfWidgetFormFilterInput(),
      'valor'               => new sfWidgetFormFilterInput(),
      'banco_id'            => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'movimiento_banco_id' => new sfWidgetFormPropelChoice(array('model' => 'MovimientoBanco', 'add_empty' => true)),
      'partida_no'          => new sfWidgetFormFilterInput(),
      'detalle_interes'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'prestamo_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Prestamo', 'column' => 'id')),
      'comentario'          => new sfValidatorPass(array('required' => false)),
      'fecha_inicio'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_fin'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'dias'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tasa_cambio'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_quetzales'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_dolares'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'          => new sfValidatorPass(array('required' => false)),
      'tipo'                => new sfValidatorPass(array('required' => false)),
      'valor'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'banco_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
      'movimiento_banco_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'MovimientoBanco', 'column' => 'id')),
      'partida_no'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'detalle_interes'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('prestamo_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PrestamoDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'prestamo_id'         => 'ForeignKey',
      'comentario'          => 'Text',
      'fecha_inicio'        => 'Date',
      'fecha_fin'           => 'Date',
      'dias'                => 'Number',
      'tasa_cambio'         => 'Number',
      'valor_quetzales'     => 'Number',
      'valor_dolares'       => 'Number',
      'created_at'          => 'Date',
      'created_by'          => 'Text',
      'tipo'                => 'Text',
      'valor'               => 'Number',
      'banco_id'            => 'ForeignKey',
      'movimiento_banco_id' => 'ForeignKey',
      'partida_no'          => 'Number',
      'detalle_interes'     => 'Text',
    );
  }
}
