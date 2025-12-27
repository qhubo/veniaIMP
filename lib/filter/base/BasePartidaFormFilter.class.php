<?php

/**
 * Partida filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BasePartidaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha_contable'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'usuario'           => new sfWidgetFormFilterInput(),
      'empresa_id'        => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'            => new sfWidgetFormFilterInput(),
      'tipo'              => new sfWidgetFormFilterInput(),
      'created_by'        => new sfWidgetFormFilterInput(),
      'updated_by'        => new sfWidgetFormFilterInput(),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'valor'             => new sfWidgetFormFilterInput(),
      'tienda_id'         => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'confirmada'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'estatus'           => new sfWidgetFormFilterInput(),
      'numero'            => new sfWidgetFormFilterInput(),
      'medio_pago_id'     => new sfWidgetFormPropelChoice(array('model' => 'MedioPago', 'add_empty' => true)),
      'tipo_partida'      => new sfWidgetFormFilterInput(),
      'tipo_numero'       => new sfWidgetFormFilterInput(),
      'detalle'           => new sfWidgetFormFilterInput(),
      'ano'               => new sfWidgetFormFilterInput(),
      'mes'               => new sfWidgetFormFilterInput(),
      'partida_agrupa_id' => new sfWidgetFormPropelChoice(array('model' => 'PartidaAgrupa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'fecha_contable'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'usuario'           => new sfValidatorPass(array('required' => false)),
      'empresa_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'codigo'            => new sfValidatorPass(array('required' => false)),
      'tipo'              => new sfValidatorPass(array('required' => false)),
      'created_by'        => new sfValidatorPass(array('required' => false)),
      'updated_by'        => new sfValidatorPass(array('required' => false)),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'valor'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'tienda_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'confirmada'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'estatus'           => new sfValidatorPass(array('required' => false)),
      'numero'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'medio_pago_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'MedioPago', 'column' => 'id')),
      'tipo_partida'      => new sfValidatorPass(array('required' => false)),
      'tipo_numero'       => new sfValidatorPass(array('required' => false)),
      'detalle'           => new sfValidatorPass(array('required' => false)),
      'ano'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mes'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'partida_agrupa_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PartidaAgrupa', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('partida_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Partida';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'fecha_contable'    => 'Date',
      'usuario'           => 'Text',
      'empresa_id'        => 'ForeignKey',
      'codigo'            => 'Text',
      'tipo'              => 'Text',
      'created_by'        => 'Text',
      'updated_by'        => 'Text',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
      'valor'             => 'Number',
      'tienda_id'         => 'ForeignKey',
      'confirmada'        => 'Boolean',
      'estatus'           => 'Text',
      'numero'            => 'Number',
      'medio_pago_id'     => 'ForeignKey',
      'tipo_partida'      => 'Text',
      'tipo_numero'       => 'Text',
      'detalle'           => 'Text',
      'ano'               => 'Number',
      'mes'               => 'Number',
      'partida_agrupa_id' => 'ForeignKey',
    );
  }
}
