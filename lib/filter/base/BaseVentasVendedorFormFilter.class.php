<?php

/**
 * VentasVendedor filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseVentasVendedorFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo_vendedor'  => new sfWidgetFormFilterInput(),
      'nombre_vendedor'  => new sfWidgetFormFilterInput(),
      'facturas'         => new sfWidgetFormFilterInput(),
      'total_facturas'   => new sfWidgetFormFilterInput(),
      'detalle_facturas' => new sfWidgetFormFilterInput(),
      'notas'            => new sfWidgetFormFilterInput(),
      'total_notas'      => new sfWidgetFormFilterInput(),
      'detalle_notas'    => new sfWidgetFormFilterInput(),
      'periodo'          => new sfWidgetFormFilterInput(),
      'mes'              => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'       => new sfWidgetFormFilterInput(),
      'updated_by'       => new sfWidgetFormFilterInput(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'bono'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'codigo_vendedor'  => new sfValidatorPass(array('required' => false)),
      'nombre_vendedor'  => new sfValidatorPass(array('required' => false)),
      'facturas'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'total_facturas'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'detalle_facturas' => new sfValidatorPass(array('required' => false)),
      'notas'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'total_notas'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'detalle_notas'    => new sfValidatorPass(array('required' => false)),
      'periodo'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mes'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'       => new sfValidatorPass(array('required' => false)),
      'updated_by'       => new sfValidatorPass(array('required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'bono'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('ventas_vendedor_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'VentasVendedor';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'codigo_vendedor'  => 'Text',
      'nombre_vendedor'  => 'Text',
      'facturas'         => 'Number',
      'total_facturas'   => 'Number',
      'detalle_facturas' => 'Text',
      'notas'            => 'Number',
      'total_notas'      => 'Number',
      'detalle_notas'    => 'Text',
      'periodo'          => 'Number',
      'mes'              => 'Number',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'created_by'       => 'Text',
      'updated_by'       => 'Text',
      'empresa_id'       => 'ForeignKey',
      'bono'             => 'Number',
    );
  }
}
