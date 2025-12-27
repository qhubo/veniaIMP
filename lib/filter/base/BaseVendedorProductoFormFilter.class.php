<?php

/**
 * VendedorProducto filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseVendedorProductoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'vendedor_id'       => new sfWidgetFormPropelChoice(array('model' => 'Vendedor', 'add_empty' => true)),
      'producto_id'       => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'cantidad'          => new sfWidgetFormFilterInput(),
      'observaciones'     => new sfWidgetFormFilterInput(),
      'fecha'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'usuario'           => new sfWidgetFormFilterInput(),
      'valor_unitario'    => new sfWidgetFormFilterInput(),
      'orden_vendedor_id' => new sfWidgetFormPropelChoice(array('model' => 'OrdenVendedor', 'add_empty' => true)),
      'verificado'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'vendedor_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Vendedor', 'column' => 'id')),
      'producto_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'cantidad'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'observaciones'     => new sfValidatorPass(array('required' => false)),
      'fecha'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'usuario'           => new sfValidatorPass(array('required' => false)),
      'valor_unitario'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'orden_vendedor_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'OrdenVendedor', 'column' => 'id')),
      'verificado'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('vendedor_producto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'VendedorProducto';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'vendedor_id'       => 'ForeignKey',
      'producto_id'       => 'ForeignKey',
      'cantidad'          => 'Number',
      'observaciones'     => 'Text',
      'fecha'             => 'Date',
      'usuario'           => 'Text',
      'valor_unitario'    => 'Number',
      'orden_vendedor_id' => 'ForeignKey',
      'verificado'        => 'Boolean',
    );
  }
}
