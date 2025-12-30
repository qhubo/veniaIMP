<?php

/**
 * ProductoPrecio filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseProductoPrecioFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'producto_id'     => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'valor'           => new sfWidgetFormFilterInput(),
      'lista_precio_id' => new sfWidgetFormPropelChoice(array('model' => 'ListaPrecio', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'empresa_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'producto_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'valor'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'lista_precio_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'ListaPrecio', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('producto_precio_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductoPrecio';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'empresa_id'      => 'ForeignKey',
      'producto_id'     => 'ForeignKey',
      'valor'           => 'Number',
      'lista_precio_id' => 'ForeignKey',
    );
  }
}
