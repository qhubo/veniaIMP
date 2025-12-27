<?php

/**
 * ComboProducto form base class.
 *
 * @method ComboProducto getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseComboProductoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'nombre'           => new sfWidgetFormInputText(),
      'activo'           => new sfWidgetFormInputCheckbox(),
      'precio'           => new sfWidgetFormInputText(),
      'codigo_sku'       => new sfWidgetFormInputText(),
      'imagen'           => new sfWidgetFormInputText(),
      'codigo_barras'    => new sfWidgetFormInputText(),
      'precio_variable'  => new sfWidgetFormInputCheckbox(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'usuario_creo'     => new sfWidgetFormInputText(),
      'fecha_creo'       => new sfWidgetFormDateTime(),
      'usuario_confirmo' => new sfWidgetFormInputText(),
      'fecha_confirmo'   => new sfWidgetFormDateTime(),
      'comentario'       => new sfWidgetFormInputText(),
      'estatus'          => new sfWidgetFormInputText(),
      'descripcion'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'nombre'           => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'activo'           => new sfValidatorBoolean(array('required' => false)),
      'precio'           => new sfValidatorNumber(array('required' => false)),
      'codigo_sku'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'imagen'           => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'codigo_barras'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'precio_variable'  => new sfValidatorBoolean(array('required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'usuario_creo'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_creo'       => new sfValidatorDateTime(array('required' => false)),
      'usuario_confirmo' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_confirmo'   => new sfValidatorDateTime(array('required' => false)),
      'comentario'       => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'estatus'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'descripcion'      => new sfValidatorString(array('max_length' => 250, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('combo_producto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ComboProducto';
  }


}
