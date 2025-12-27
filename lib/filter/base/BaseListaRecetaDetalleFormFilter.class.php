<?php

/**
 * ListaRecetaDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseListaRecetaDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'receta_producto_detalle_id' => new sfWidgetFormPropelChoice(array('model' => 'RecetaProductoDetalle', 'add_empty' => true)),
      'producto_id'                => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'empresa_id'                 => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'precio'                     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'receta_producto_detalle_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'RecetaProductoDetalle', 'column' => 'id')),
      'producto_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'empresa_id'                 => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'precio'                     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('lista_receta_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaRecetaDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'receta_producto_detalle_id' => 'ForeignKey',
      'producto_id'                => 'ForeignKey',
      'empresa_id'                 => 'ForeignKey',
      'precio'                     => 'Number',
    );
  }
}
