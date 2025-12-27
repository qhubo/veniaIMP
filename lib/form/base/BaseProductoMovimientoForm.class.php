<?php

/**
 * ProductoMovimiento form base class.
 *
 * @method ProductoMovimiento getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseProductoMovimientoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'producto_id'   => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'fecha'         => new sfWidgetFormDateTime(),
      'cantidad'      => new sfWidgetFormInputText(),
      'tienda_id'     => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'identificador' => new sfWidgetFormInputText(),
      'tipo'          => new sfWidgetFormInputText(),
      'motivo'        => new sfWidgetFormInputText(),
      'inicio'        => new sfWidgetFormInputText(),
      'fin'           => new sfWidgetFormInputText(),
      'valor_total'   => new sfWidgetFormInputText(),
      'sub_total'     => new sfWidgetFormInputText(),
      'iva'           => new sfWidgetFormInputText(),
      'linea_no'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'    => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'producto_id'   => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'fecha'         => new sfValidatorDateTime(array('required' => false)),
      'cantidad'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tienda_id'     => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'identificador' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'tipo'          => new sfValidatorString(array('max_length' => 132, 'required' => false)),
      'motivo'        => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'inicio'        => new sfValidatorNumber(array('required' => false)),
      'fin'           => new sfValidatorNumber(array('required' => false)),
      'valor_total'   => new sfValidatorNumber(array('required' => false)),
      'sub_total'     => new sfValidatorNumber(array('required' => false)),
      'iva'           => new sfValidatorNumber(array('required' => false)),
      'linea_no'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'ProductoMovimiento', 'column' => array('linea_no')))
    );

    $this->widgetSchema->setNameFormat('producto_movimiento[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductoMovimiento';
  }


}
