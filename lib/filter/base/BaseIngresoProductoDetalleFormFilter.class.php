<?php

/**
 * IngresoProductoDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseIngresoProductoDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'producto_id'         => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'ingreso_producto_id' => new sfWidgetFormPropelChoice(array('model' => 'IngresoProducto', 'add_empty' => true)),
      'cantidad'            => new sfWidgetFormFilterInput(),
      'empresa_id'          => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'ubicacion'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'producto_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'ingreso_producto_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'IngresoProducto', 'column' => 'id')),
      'cantidad'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'empresa_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'ubicacion'           => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ingreso_producto_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'IngresoProductoDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'producto_id'         => 'ForeignKey',
      'ingreso_producto_id' => 'ForeignKey',
      'cantidad'            => 'Number',
      'empresa_id'          => 'ForeignKey',
      'ubicacion'           => 'Text',
    );
  }
}
