<?php

/**
 * Producto form base class.
 *
 * @method Producto getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseProductoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'nombre'                    => new sfWidgetFormInputText(),
      'codigo_sku'                => new sfWidgetFormInputText(),
      'codigo_barras'             => new sfWidgetFormInputText(),
      'descripcion_corta'         => new sfWidgetFormTextarea(),
      'descripcion'               => new sfWidgetFormTextarea(),
      'activo'                    => new sfWidgetFormInputCheckbox(),
      'tipo_aparato_id'           => new sfWidgetFormPropelChoice(array('model' => 'TipoAparato', 'add_empty' => true)),
      'modelo_id'                 => new sfWidgetFormPropelChoice(array('model' => 'Modelo', 'add_empty' => true)),
      'marca_id'                  => new sfWidgetFormPropelChoice(array('model' => 'Marca', 'add_empty' => true)),
      'existencia'                => new sfWidgetFormInputText(),
      'precio_anterior'           => new sfWidgetFormInputText(),
      'ofertado'                  => new sfWidgetFormInputCheckbox(),
      'precio'                    => new sfWidgetFormInputText(),
      'orden'                     => new sfWidgetFormInputText(),
      'codigo_proveedor'          => new sfWidgetFormInputText(),
      'costo_proveedor'           => new sfWidgetFormInputText(),
      'cargo_peso_libra_producto' => new sfWidgetFormInputText(),
      'estatus'                   => new sfWidgetFormInputText(),
      'created_by'                => new sfWidgetFormInputText(),
      'updated_by'                => new sfWidgetFormInputText(),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
      'dia_garantia'              => new sfWidgetFormInputText(),
      'alerta_minimo'             => new sfWidgetFormInputText(),
      'tercero'                   => new sfWidgetFormInputCheckbox(),
      'imagen'                    => new sfWidgetFormInputText(),
      'promocional'               => new sfWidgetFormInputCheckbox(),
      'traslado'                  => new sfWidgetFormInputCheckbox(),
      'top_venta'                 => new sfWidgetFormInputCheckbox(),
      'salida'                    => new sfWidgetFormInputCheckbox(),
      'opcion_combo'              => new sfWidgetFormInputCheckbox(),
      'bodega_interna'            => new sfWidgetFormInputCheckbox(),
      'afecto_inventario'         => new sfWidgetFormInputCheckbox(),
      'empresa_id'                => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'receta_producto_id'        => new sfWidgetFormPropelChoice(array('model' => 'RecetaProducto', 'add_empty' => true)),
      'combo_producto_id'         => new sfWidgetFormPropelChoice(array('model' => 'ComboProducto', 'add_empty' => true)),
      'status'                    => new sfWidgetFormInputText(),
      'proveedor_id'              => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'unidad_medida'             => new sfWidgetFormInputText(),
      'unidad_medida_costo'       => new sfWidgetFormInputText(),
      'costo_anterior'            => new sfWidgetFormInputText(),
      'codigo_arancel'            => new sfWidgetFormInputText(),
      'marca_producto'            => new sfWidgetFormInputText(),
      'caracteristica'            => new sfWidgetFormInputText(),
      'nombre_ingles'             => new sfWidgetFormInputText(),
      'alto'                      => new sfWidgetFormInputText(),
      'ancho'                     => new sfWidgetFormInputText(),
      'largo'                     => new sfWidgetFormInputText(),
      'peso'                      => new sfWidgetFormInputText(),
      'costo_fabrica'             => new sfWidgetFormInputText(),
      'costo_cif'                 => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'nombre'                    => new sfValidatorString(array('max_length' => 260)),
      'codigo_sku'                => new sfValidatorString(array('max_length' => 32)),
      'codigo_barras'             => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'descripcion_corta'         => new sfValidatorString(array('required' => false)),
      'descripcion'               => new sfValidatorString(array('required' => false)),
      'activo'                    => new sfValidatorBoolean(array('required' => false)),
      'tipo_aparato_id'           => new sfValidatorPropelChoice(array('model' => 'TipoAparato', 'column' => 'id', 'required' => false)),
      'modelo_id'                 => new sfValidatorPropelChoice(array('model' => 'Modelo', 'column' => 'id', 'required' => false)),
      'marca_id'                  => new sfValidatorPropelChoice(array('model' => 'Marca', 'column' => 'id', 'required' => false)),
      'existencia'                => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'precio_anterior'           => new sfValidatorNumber(array('required' => false)),
      'ofertado'                  => new sfValidatorBoolean(array('required' => false)),
      'precio'                    => new sfValidatorNumber(array('required' => false)),
      'orden'                     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'codigo_proveedor'          => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'costo_proveedor'           => new sfValidatorNumber(array('required' => false)),
      'cargo_peso_libra_producto' => new sfValidatorNumber(array('required' => false)),
      'estatus'                   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'created_by'                => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'                => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'                => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                => new sfValidatorDateTime(array('required' => false)),
      'dia_garantia'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'alerta_minimo'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tercero'                   => new sfValidatorBoolean(array('required' => false)),
      'imagen'                    => new sfValidatorString(array('max_length' => 360, 'required' => false)),
      'promocional'               => new sfValidatorBoolean(array('required' => false)),
      'traslado'                  => new sfValidatorBoolean(array('required' => false)),
      'top_venta'                 => new sfValidatorBoolean(array('required' => false)),
      'salida'                    => new sfValidatorBoolean(array('required' => false)),
      'opcion_combo'              => new sfValidatorBoolean(array('required' => false)),
      'bodega_interna'            => new sfValidatorBoolean(array('required' => false)),
      'afecto_inventario'         => new sfValidatorBoolean(array('required' => false)),
      'empresa_id'                => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'receta_producto_id'        => new sfValidatorPropelChoice(array('model' => 'RecetaProducto', 'column' => 'id', 'required' => false)),
      'combo_producto_id'         => new sfValidatorPropelChoice(array('model' => 'ComboProducto', 'column' => 'id', 'required' => false)),
      'status'                    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'proveedor_id'              => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'unidad_medida'             => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'unidad_medida_costo'       => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'costo_anterior'            => new sfValidatorNumber(array('required' => false)),
      'codigo_arancel'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'marca_producto'            => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'caracteristica'            => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'nombre_ingles'             => new sfValidatorString(array('max_length' => 350, 'required' => false)),
      'alto'                      => new sfValidatorNumber(array('required' => false)),
      'ancho'                     => new sfValidatorNumber(array('required' => false)),
      'largo'                     => new sfValidatorNumber(array('required' => false)),
      'peso'                      => new sfValidatorNumber(array('required' => false)),
      'costo_fabrica'             => new sfValidatorNumber(array('required' => false)),
      'costo_cif'                 => new sfValidatorNumber(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Producto', 'column' => array('codigo_sku')))
    );

    $this->widgetSchema->setNameFormat('producto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Producto';
  }


}
