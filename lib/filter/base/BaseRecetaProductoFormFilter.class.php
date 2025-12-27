<?php

/**
 * RecetaProducto filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseRecetaProductoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'            => new sfWidgetFormFilterInput(),
      'activo'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'vence'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'fecha_fin'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'afecto_inventario' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'precio_variable'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'precio'            => new sfWidgetFormFilterInput(),
      'codigo_sku'        => new sfWidgetFormFilterInput(),
      'imagen'            => new sfWidgetFormFilterInput(),
      'codigo_barras'     => new sfWidgetFormFilterInput(),
      'usuario_creo'      => new sfWidgetFormFilterInput(),
      'fecha_creo'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'usuario_confirmo'  => new sfWidgetFormFilterInput(),
      'fecha_confirmo'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'comentario'        => new sfWidgetFormFilterInput(),
      'estatus'           => new sfWidgetFormFilterInput(),
      'empresa_id'        => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'descripcion'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'nombre'            => new sfValidatorPass(array('required' => false)),
      'activo'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'vence'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'fecha_fin'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'afecto_inventario' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'precio_variable'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'precio'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'codigo_sku'        => new sfValidatorPass(array('required' => false)),
      'imagen'            => new sfValidatorPass(array('required' => false)),
      'codigo_barras'     => new sfValidatorPass(array('required' => false)),
      'usuario_creo'      => new sfValidatorPass(array('required' => false)),
      'fecha_creo'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'usuario_confirmo'  => new sfValidatorPass(array('required' => false)),
      'fecha_confirmo'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'comentario'        => new sfValidatorPass(array('required' => false)),
      'estatus'           => new sfValidatorPass(array('required' => false)),
      'empresa_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'descripcion'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('receta_producto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RecetaProducto';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'nombre'            => 'Text',
      'activo'            => 'Boolean',
      'vence'             => 'Boolean',
      'fecha_fin'         => 'Date',
      'afecto_inventario' => 'Boolean',
      'precio_variable'   => 'Boolean',
      'precio'            => 'Number',
      'codigo_sku'        => 'Text',
      'imagen'            => 'Text',
      'codigo_barras'     => 'Text',
      'usuario_creo'      => 'Text',
      'fecha_creo'        => 'Date',
      'usuario_confirmo'  => 'Text',
      'fecha_confirmo'    => 'Date',
      'comentario'        => 'Text',
      'estatus'           => 'Text',
      'empresa_id'        => 'ForeignKey',
      'descripcion'       => 'Text',
    );
  }
}
