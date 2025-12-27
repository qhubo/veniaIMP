<?php

/**
 * SolicitudDeposito filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseSolicitudDepositoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'                 => new sfWidgetFormFilterInput(),
      'banco_id'               => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'tienda_id'              => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'fecha_ingreso'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_deposito'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'total'                  => new sfWidgetFormFilterInput(),
      'boleta'                 => new sfWidgetFormFilterInput(),
      'vendedor'               => new sfWidgetFormFilterInput(),
      'telefono'               => new sfWidgetFormFilterInput(),
      'cliente'                => new sfWidgetFormFilterInput(),
      'pieza'                  => new sfWidgetFormFilterInput(),
      'stock'                  => new sfWidgetFormFilterInput(),
      'documento_confirmacion' => new sfWidgetFormFilterInput(),
      'usuario_confirmo'       => new sfWidgetFormFilterInput(),
      'fecha_confirmo'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'estatus'                => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'             => new sfWidgetFormFilterInput(),
      'updated_by'             => new sfWidgetFormFilterInput(),
      'empresa_id'             => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'codigo'                 => new sfValidatorPass(array('required' => false)),
      'banco_id'               => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
      'tienda_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'fecha_ingreso'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_deposito'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'total'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'boleta'                 => new sfValidatorPass(array('required' => false)),
      'vendedor'               => new sfValidatorPass(array('required' => false)),
      'telefono'               => new sfValidatorPass(array('required' => false)),
      'cliente'                => new sfValidatorPass(array('required' => false)),
      'pieza'                  => new sfValidatorPass(array('required' => false)),
      'stock'                  => new sfValidatorPass(array('required' => false)),
      'documento_confirmacion' => new sfValidatorPass(array('required' => false)),
      'usuario_confirmo'       => new sfValidatorPass(array('required' => false)),
      'fecha_confirmo'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'estatus'                => new sfValidatorPass(array('required' => false)),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'             => new sfValidatorPass(array('required' => false)),
      'updated_by'             => new sfValidatorPass(array('required' => false)),
      'empresa_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('solicitud_deposito_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SolicitudDeposito';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'codigo'                 => 'Text',
      'banco_id'               => 'ForeignKey',
      'tienda_id'              => 'ForeignKey',
      'fecha_ingreso'          => 'Date',
      'fecha_deposito'         => 'Date',
      'total'                  => 'Number',
      'boleta'                 => 'Text',
      'vendedor'               => 'Text',
      'telefono'               => 'Text',
      'cliente'                => 'Text',
      'pieza'                  => 'Text',
      'stock'                  => 'Text',
      'documento_confirmacion' => 'Text',
      'usuario_confirmo'       => 'Text',
      'fecha_confirmo'         => 'Date',
      'estatus'                => 'Text',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'created_by'             => 'Text',
      'updated_by'             => 'Text',
      'empresa_id'             => 'ForeignKey',
    );
  }
}
