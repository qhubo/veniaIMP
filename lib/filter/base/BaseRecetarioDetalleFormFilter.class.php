<?php

/**
 * RecetarioDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseRecetarioDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'recetario_id'  => new sfWidgetFormPropelChoice(array('model' => 'Recetario', 'add_empty' => true)),
      'tipo_detalle'  => new sfWidgetFormFilterInput(),
      'servicio'      => new sfWidgetFormFilterInput(),
      'producto_id'   => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'dosis'         => new sfWidgetFormFilterInput(),
      'frecuencia'    => new sfWidgetFormFilterInput(),
      'observaciones' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'recetario_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Recetario', 'column' => 'id')),
      'tipo_detalle'  => new sfValidatorPass(array('required' => false)),
      'servicio'      => new sfValidatorPass(array('required' => false)),
      'producto_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'dosis'         => new sfValidatorPass(array('required' => false)),
      'frecuencia'    => new sfValidatorPass(array('required' => false)),
      'observaciones' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('recetario_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RecetarioDetalle';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'recetario_id'  => 'ForeignKey',
      'tipo_detalle'  => 'Text',
      'servicio'      => 'Text',
      'producto_id'   => 'ForeignKey',
      'dosis'         => 'Text',
      'frecuencia'    => 'Text',
      'observaciones' => 'Text',
    );
  }
}
