<?php

/**
 * InventarioVence filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseInventarioVenceFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'          => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'producto_id'         => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'fecha_vence'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'despachado'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ingreso_producto_id' => new sfWidgetFormPropelChoice(array('model' => 'IngresoProducto', 'add_empty' => true)),
      'tienda_id'           => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'operacion_no'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'producto_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'fecha_vence'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'despachado'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ingreso_producto_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'IngresoProducto', 'column' => 'id')),
      'tienda_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'operacion_no'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('inventario_vence_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'InventarioVence';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'empresa_id'          => 'ForeignKey',
      'producto_id'         => 'ForeignKey',
      'fecha_vence'         => 'Date',
      'despachado'          => 'Boolean',
      'ingreso_producto_id' => 'ForeignKey',
      'tienda_id'           => 'ForeignKey',
      'operacion_no'        => 'Number',
    );
  }
}
