<?php

/**
 * MotivoMovimientoProducto filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseMotivoMovimientoProductoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'      => new sfWidgetFormFilterInput(),
      'nombre'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descripcion' => new sfWidgetFormFilterInput(),
      'activo'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'empresa_id'  => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tipo'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'codigo'      => new sfValidatorPass(array('required' => false)),
      'nombre'      => new sfValidatorPass(array('required' => false)),
      'descripcion' => new sfValidatorPass(array('required' => false)),
      'activo'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'empresa_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'tipo'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('motivo_movimiento_producto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MotivoMovimientoProducto';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'codigo'      => 'Text',
      'nombre'      => 'Text',
      'descripcion' => 'Text',
      'activo'      => 'Boolean',
      'empresa_id'  => 'ForeignKey',
      'tipo'        => 'Text',
    );
  }
}
