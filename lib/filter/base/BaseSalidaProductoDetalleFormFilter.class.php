<?php

/**
 * SalidaProductoDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseSalidaProductoDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'salida_producto_id' => new sfWidgetFormPropelChoice(array('model' => 'SalidaProducto', 'add_empty' => true)),
      'producto_id'        => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'codigo'             => new sfWidgetFormFilterInput(),
      'detalle'            => new sfWidgetFormFilterInput(),
      'valor'              => new sfWidgetFormFilterInput(),
      'cantidad'           => new sfWidgetFormFilterInput(),
      'valor_total'        => new sfWidgetFormFilterInput(),
      'excento'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'confirmado'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'usuario_id'         => new sfWidgetFormPropelChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'empresa_id'         => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'salida_producto_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SalidaProducto', 'column' => 'id')),
      'producto_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'codigo'             => new sfValidatorPass(array('required' => false)),
      'detalle'            => new sfValidatorPass(array('required' => false)),
      'valor'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cantidad'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'valor_total'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'excento'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'confirmado'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'usuario_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuario', 'column' => 'id')),
      'empresa_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('salida_producto_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SalidaProductoDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'salida_producto_id' => 'ForeignKey',
      'producto_id'        => 'ForeignKey',
      'codigo'             => 'Text',
      'detalle'            => 'Text',
      'valor'              => 'Number',
      'cantidad'           => 'Number',
      'valor_total'        => 'Number',
      'excento'            => 'Boolean',
      'confirmado'         => 'Boolean',
      'usuario_id'         => 'ForeignKey',
      'empresa_id'         => 'ForeignKey',
    );
  }
}
