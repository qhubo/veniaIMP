<?php

/**
 * TrasladoUbicacionDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseTrasladoUbicacionDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'traslado_ubicacion_id' => new sfWidgetFormPropelChoice(array('model' => 'TrasladoUbicacion', 'add_empty' => true)),
      'producto_id'           => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'ubicacion_original'    => new sfWidgetFormFilterInput(),
      'cantidad'              => new sfWidgetFormFilterInput(),
      'tienda_id'             => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'nueva_ubicacion'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'traslado_ubicacion_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TrasladoUbicacion', 'column' => 'id')),
      'producto_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'ubicacion_original'    => new sfValidatorPass(array('required' => false)),
      'cantidad'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tienda_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'nueva_ubicacion'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('traslado_ubicacion_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TrasladoUbicacionDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'traslado_ubicacion_id' => 'ForeignKey',
      'producto_id'           => 'ForeignKey',
      'ubicacion_original'    => 'Text',
      'cantidad'              => 'Number',
      'tienda_id'             => 'ForeignKey',
      'nueva_ubicacion'       => 'Text',
    );
  }
}
