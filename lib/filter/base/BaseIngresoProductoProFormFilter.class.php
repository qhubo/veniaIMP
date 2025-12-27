<?php

/**
 * IngresoProductoPro filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseIngresoProductoProFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'                => new sfWidgetFormFilterInput(),
      'codigo_proveedor'      => new sfWidgetFormFilterInput(),
      'proveedor_id'          => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'tienda_id'             => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'numero_documento'      => new sfWidgetFormFilterInput(),
      'fecha_documento'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_contabilizacion' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'observaciones'         => new sfWidgetFormFilterInput(),
      'tipo'                  => new sfWidgetFormFilterInput(),
      'motivo'                => new sfWidgetFormFilterInput(),
      'estatus'               => new sfWidgetFormFilterInput(),
      'usuario_id'            => new sfWidgetFormPropelChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'confirmado'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'            => new sfWidgetFormFilterInput(),
      'updated_by'            => new sfWidgetFormFilterInput(),
      'bodega_origen'         => new sfWidgetFormFilterInput(),
      'serie_documento'       => new sfWidgetFormFilterInput(),
      'correlativo'           => new sfWidgetFormFilterInput(),
      'empresa_id'            => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'codigo'                => new sfValidatorPass(array('required' => false)),
      'codigo_proveedor'      => new sfValidatorPass(array('required' => false)),
      'proveedor_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'tienda_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'numero_documento'      => new sfValidatorPass(array('required' => false)),
      'fecha_documento'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_contabilizacion' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'observaciones'         => new sfValidatorPass(array('required' => false)),
      'tipo'                  => new sfValidatorPass(array('required' => false)),
      'motivo'                => new sfValidatorPass(array('required' => false)),
      'estatus'               => new sfValidatorPass(array('required' => false)),
      'usuario_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuario', 'column' => 'id')),
      'confirmado'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'            => new sfValidatorPass(array('required' => false)),
      'updated_by'            => new sfValidatorPass(array('required' => false)),
      'bodega_origen'         => new sfValidatorPass(array('required' => false)),
      'serie_documento'       => new sfValidatorPass(array('required' => false)),
      'correlativo'           => new sfValidatorPass(array('required' => false)),
      'empresa_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('ingreso_producto_pro_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'IngresoProductoPro';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'codigo'                => 'Text',
      'codigo_proveedor'      => 'Text',
      'proveedor_id'          => 'ForeignKey',
      'tienda_id'             => 'ForeignKey',
      'numero_documento'      => 'Text',
      'fecha_documento'       => 'Date',
      'fecha_contabilizacion' => 'Date',
      'observaciones'         => 'Text',
      'tipo'                  => 'Text',
      'motivo'                => 'Text',
      'estatus'               => 'Text',
      'usuario_id'            => 'ForeignKey',
      'confirmado'            => 'Boolean',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
      'created_by'            => 'Text',
      'updated_by'            => 'Text',
      'bodega_origen'         => 'Text',
      'serie_documento'       => 'Text',
      'correlativo'           => 'Text',
      'empresa_id'            => 'ForeignKey',
    );
  }
}
