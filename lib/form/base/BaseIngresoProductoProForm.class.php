<?php

/**
 * IngresoProductoPro form base class.
 *
 * @method IngresoProductoPro getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseIngresoProductoProForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'codigo'                => new sfWidgetFormInputText(),
      'codigo_proveedor'      => new sfWidgetFormInputText(),
      'proveedor_id'          => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'tienda_id'             => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'numero_documento'      => new sfWidgetFormInputText(),
      'fecha_documento'       => new sfWidgetFormDate(),
      'fecha_contabilizacion' => new sfWidgetFormDate(),
      'observaciones'         => new sfWidgetFormTextarea(),
      'tipo'                  => new sfWidgetFormInputText(),
      'motivo'                => new sfWidgetFormInputText(),
      'estatus'               => new sfWidgetFormInputText(),
      'usuario_id'            => new sfWidgetFormPropelChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'confirmado'            => new sfWidgetFormInputCheckbox(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'created_by'            => new sfWidgetFormInputText(),
      'updated_by'            => new sfWidgetFormInputText(),
      'bodega_origen'         => new sfWidgetFormInputText(),
      'serie_documento'       => new sfWidgetFormInputText(),
      'correlativo'           => new sfWidgetFormInputText(),
      'empresa_id'            => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'codigo_proveedor'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'proveedor_id'          => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'tienda_id'             => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'numero_documento'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_documento'       => new sfValidatorDate(array('required' => false)),
      'fecha_contabilizacion' => new sfValidatorDate(array('required' => false)),
      'observaciones'         => new sfValidatorString(array('required' => false)),
      'tipo'                  => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'motivo'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'estatus'               => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'usuario_id'            => new sfValidatorPropelChoice(array('model' => 'Usuario', 'column' => 'id', 'required' => false)),
      'confirmado'            => new sfValidatorBoolean(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
      'updated_at'            => new sfValidatorDateTime(array('required' => false)),
      'created_by'            => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'            => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'bodega_origen'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'serie_documento'       => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'correlativo'           => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'empresa_id'            => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ingreso_producto_pro[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'IngresoProductoPro';
  }


}
