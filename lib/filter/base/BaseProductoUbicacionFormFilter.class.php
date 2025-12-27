<?php

/**
 * ProductoUbicacion filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseProductoUbicacionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'  => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'producto_id' => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'cantidad'    => new sfWidgetFormFilterInput(),
      'tienda_id'   => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'ubicacion'   => new sfWidgetFormFilterInput(),
      'transito'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'producto_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'cantidad'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tienda_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'ubicacion'   => new sfValidatorPass(array('required' => false)),
      'transito'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('producto_ubicacion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductoUbicacion';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'empresa_id'  => 'ForeignKey',
      'producto_id' => 'ForeignKey',
      'cantidad'    => 'Number',
      'tienda_id'   => 'ForeignKey',
      'ubicacion'   => 'Text',
      'transito'    => 'Number',
    );
  }
}
