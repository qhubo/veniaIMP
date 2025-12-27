<?php

/**
 * ListaComboDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseListaComboDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'combo_producto_detalle_id' => new sfWidgetFormPropelChoice(array('model' => 'ComboProductoDetalle', 'add_empty' => true)),
      'producto_id'               => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'empresa_id'                => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'precio'                    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'combo_producto_detalle_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'ComboProductoDetalle', 'column' => 'id')),
      'producto_id'               => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'empresa_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'precio'                    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('lista_combo_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaComboDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'combo_producto_detalle_id' => 'ForeignKey',
      'producto_id'               => 'ForeignKey',
      'empresa_id'                => 'ForeignKey',
      'precio'                    => 'Number',
    );
  }
}
