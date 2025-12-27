<?php

/**
 * ComboProductoDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseComboProductoDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'combo_producto_id' => new sfWidgetFormPropelChoice(array('model' => 'ComboProducto', 'add_empty' => true)),
      'marca_id'          => new sfWidgetFormPropelChoice(array('model' => 'Marca', 'add_empty' => true)),
      'producto_default'  => new sfWidgetFormFilterInput(),
      'orden'             => new sfWidgetFormFilterInput(),
      'ultimo'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'obligatorio'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'precio'            => new sfWidgetFormFilterInput(),
      'seleccion'         => new sfWidgetFormFilterInput(),
      'empresa_id'        => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'unidad_medida'     => new sfWidgetFormFilterInput(),
      'cantidad_medida'   => new sfWidgetFormFilterInput(),
      'costo_unidad'      => new sfWidgetFormFilterInput(),
      'costo_producto'    => new sfWidgetFormFilterInput(),
      'costo_promedio'    => new sfWidgetFormFilterInput(),
      'costo_unidad_pro'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'combo_producto_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'ComboProducto', 'column' => 'id')),
      'marca_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Marca', 'column' => 'id')),
      'producto_default'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'orden'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ultimo'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'obligatorio'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'precio'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'seleccion'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'empresa_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'unidad_medida'     => new sfValidatorPass(array('required' => false)),
      'cantidad_medida'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo_unidad'      => new sfValidatorPass(array('required' => false)),
      'costo_producto'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo_promedio'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo_unidad_pro'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('combo_producto_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ComboProductoDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'combo_producto_id' => 'ForeignKey',
      'marca_id'          => 'ForeignKey',
      'producto_default'  => 'Number',
      'orden'             => 'Number',
      'ultimo'            => 'Boolean',
      'obligatorio'       => 'Boolean',
      'precio'            => 'Number',
      'seleccion'         => 'Number',
      'empresa_id'        => 'ForeignKey',
      'unidad_medida'     => 'Text',
      'cantidad_medida'   => 'Number',
      'costo_unidad'      => 'Text',
      'costo_producto'    => 'Number',
      'costo_promedio'    => 'Number',
      'costo_unidad_pro'  => 'Number',
    );
  }
}
