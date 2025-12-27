<?php

/**
 * Producto filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseProductoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'codigo_sku'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'codigo_barras'             => new sfWidgetFormFilterInput(),
      'descripcion_corta'         => new sfWidgetFormFilterInput(),
      'descripcion'               => new sfWidgetFormFilterInput(),
      'activo'                    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'tipo_aparato_id'           => new sfWidgetFormPropelChoice(array('model' => 'TipoAparato', 'add_empty' => true)),
      'modelo_id'                 => new sfWidgetFormPropelChoice(array('model' => 'Modelo', 'add_empty' => true)),
      'marca_id'                  => new sfWidgetFormPropelChoice(array('model' => 'Marca', 'add_empty' => true)),
      'existencia'                => new sfWidgetFormFilterInput(),
      'precio_anterior'           => new sfWidgetFormFilterInput(),
      'ofertado'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'precio'                    => new sfWidgetFormFilterInput(),
      'orden'                     => new sfWidgetFormFilterInput(),
      'codigo_proveedor'          => new sfWidgetFormFilterInput(),
      'costo_proveedor'           => new sfWidgetFormFilterInput(),
      'cargo_peso_libra_producto' => new sfWidgetFormFilterInput(),
      'estatus'                   => new sfWidgetFormFilterInput(),
      'created_by'                => new sfWidgetFormFilterInput(),
      'updated_by'                => new sfWidgetFormFilterInput(),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'dia_garantia'              => new sfWidgetFormFilterInput(),
      'alerta_minimo'             => new sfWidgetFormFilterInput(),
      'tercero'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'imagen'                    => new sfWidgetFormFilterInput(),
      'promocional'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'traslado'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'top_venta'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'salida'                    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'opcion_combo'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'bodega_interna'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'afecto_inventario'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'empresa_id'                => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'receta_producto_id'        => new sfWidgetFormPropelChoice(array('model' => 'RecetaProducto', 'add_empty' => true)),
      'combo_producto_id'         => new sfWidgetFormPropelChoice(array('model' => 'ComboProducto', 'add_empty' => true)),
      'status'                    => new sfWidgetFormFilterInput(),
      'proveedor_id'              => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'unidad_medida'             => new sfWidgetFormFilterInput(),
      'unidad_medida_costo'       => new sfWidgetFormFilterInput(),
      'costo_anterior'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'nombre'                    => new sfValidatorPass(array('required' => false)),
      'codigo_sku'                => new sfValidatorPass(array('required' => false)),
      'codigo_barras'             => new sfValidatorPass(array('required' => false)),
      'descripcion_corta'         => new sfValidatorPass(array('required' => false)),
      'descripcion'               => new sfValidatorPass(array('required' => false)),
      'activo'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'tipo_aparato_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TipoAparato', 'column' => 'id')),
      'modelo_id'                 => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Modelo', 'column' => 'id')),
      'marca_id'                  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Marca', 'column' => 'id')),
      'existencia'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'precio_anterior'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'ofertado'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'precio'                    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'orden'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'codigo_proveedor'          => new sfValidatorPass(array('required' => false)),
      'costo_proveedor'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cargo_peso_libra_producto' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'estatus'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_by'                => new sfValidatorPass(array('required' => false)),
      'updated_by'                => new sfValidatorPass(array('required' => false)),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'dia_garantia'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'alerta_minimo'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tercero'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'imagen'                    => new sfValidatorPass(array('required' => false)),
      'promocional'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'traslado'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'top_venta'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'salida'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'opcion_combo'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'bodega_interna'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'afecto_inventario'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'empresa_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'receta_producto_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'RecetaProducto', 'column' => 'id')),
      'combo_producto_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'ComboProducto', 'column' => 'id')),
      'status'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'proveedor_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'unidad_medida'             => new sfValidatorPass(array('required' => false)),
      'unidad_medida_costo'       => new sfValidatorPass(array('required' => false)),
      'costo_anterior'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('producto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Producto';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'nombre'                    => 'Text',
      'codigo_sku'                => 'Text',
      'codigo_barras'             => 'Text',
      'descripcion_corta'         => 'Text',
      'descripcion'               => 'Text',
      'activo'                    => 'Boolean',
      'tipo_aparato_id'           => 'ForeignKey',
      'modelo_id'                 => 'ForeignKey',
      'marca_id'                  => 'ForeignKey',
      'existencia'                => 'Number',
      'precio_anterior'           => 'Number',
      'ofertado'                  => 'Boolean',
      'precio'                    => 'Number',
      'orden'                     => 'Number',
      'codigo_proveedor'          => 'Text',
      'costo_proveedor'           => 'Number',
      'cargo_peso_libra_producto' => 'Number',
      'estatus'                   => 'Number',
      'created_by'                => 'Text',
      'updated_by'                => 'Text',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
      'dia_garantia'              => 'Number',
      'alerta_minimo'             => 'Number',
      'tercero'                   => 'Boolean',
      'imagen'                    => 'Text',
      'promocional'               => 'Boolean',
      'traslado'                  => 'Boolean',
      'top_venta'                 => 'Boolean',
      'salida'                    => 'Boolean',
      'opcion_combo'              => 'Boolean',
      'bodega_interna'            => 'Boolean',
      'afecto_inventario'         => 'Boolean',
      'empresa_id'                => 'ForeignKey',
      'receta_producto_id'        => 'ForeignKey',
      'combo_producto_id'         => 'ForeignKey',
      'status'                    => 'Number',
      'proveedor_id'              => 'ForeignKey',
      'unidad_medida'             => 'Text',
      'unidad_medida_costo'       => 'Text',
      'costo_anterior'            => 'Number',
    );
  }
}
