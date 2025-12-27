<?php

/**
 * SalidaProducto form base class.
 *
 * @method SalidaProducto getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseSalidaProductoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'codigo'                => new sfWidgetFormInputText(),
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
      'bodega_destino'        => new sfWidgetFormInputText(),
      'empresa_id'            => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
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
      'bodega_destino'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'empresa_id'            => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('salida_producto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SalidaProducto';
  }


}
