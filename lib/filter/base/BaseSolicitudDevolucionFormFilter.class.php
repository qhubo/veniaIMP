<?php

/**
 * SolicitudDevolucion filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseSolicitudDevolucionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'           => new sfWidgetFormFilterInput(),
      'fecha'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'factura'          => new sfWidgetFormFilterInput(),
      'no_referencia'    => new sfWidgetFormFilterInput(),
      'vendedor'         => new sfWidgetFormFilterInput(),
      'descripcion'      => new sfWidgetFormFilterInput(),
      'nombre_cliente'   => new sfWidgetFormFilterInput(),
      'dpi'              => new sfWidgetFormFilterInput(),
      'telefono'         => new sfWidgetFormFilterInput(),
      'medio_pago'       => new sfWidgetFormFilterInput(),
      'usuario'          => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'estatus'          => new sfWidgetFormFilterInput(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'valor'            => new sfWidgetFormFilterInput(),
      'usuario_confirmo' => new sfWidgetFormFilterInput(),
      'fecha_confirmo'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'valor_retiene'    => new sfWidgetFormFilterInput(),
      'tienda_id'        => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'motivo'           => new sfWidgetFormFilterInput(),
      'detalle_motivo'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'codigo'           => new sfValidatorPass(array('required' => false)),
      'fecha'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'factura'          => new sfValidatorPass(array('required' => false)),
      'no_referencia'    => new sfValidatorPass(array('required' => false)),
      'vendedor'         => new sfValidatorPass(array('required' => false)),
      'descripcion'      => new sfValidatorPass(array('required' => false)),
      'nombre_cliente'   => new sfValidatorPass(array('required' => false)),
      'dpi'              => new sfValidatorPass(array('required' => false)),
      'telefono'         => new sfValidatorPass(array('required' => false)),
      'medio_pago'       => new sfValidatorPass(array('required' => false)),
      'usuario'          => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'estatus'          => new sfValidatorPass(array('required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'valor'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'usuario_confirmo' => new sfValidatorPass(array('required' => false)),
      'fecha_confirmo'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'valor_retiene'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'tienda_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'motivo'           => new sfValidatorPass(array('required' => false)),
      'detalle_motivo'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('solicitud_devolucion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SolicitudDevolucion';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'codigo'           => 'Text',
      'fecha'            => 'Date',
      'factura'          => 'Text',
      'no_referencia'    => 'Text',
      'vendedor'         => 'Text',
      'descripcion'      => 'Text',
      'nombre_cliente'   => 'Text',
      'dpi'              => 'Text',
      'telefono'         => 'Text',
      'medio_pago'       => 'Text',
      'usuario'          => 'Text',
      'created_at'       => 'Date',
      'estatus'          => 'Text',
      'empresa_id'       => 'ForeignKey',
      'valor'            => 'Number',
      'usuario_confirmo' => 'Text',
      'fecha_confirmo'   => 'Date',
      'valor_retiene'    => 'Number',
      'tienda_id'        => 'ForeignKey',
      'motivo'           => 'Text',
      'detalle_motivo'   => 'Text',
    );
  }
}
