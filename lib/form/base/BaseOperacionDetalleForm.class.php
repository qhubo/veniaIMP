<?php

/**
 * OperacionDetalle form base class.
 *
 * @method OperacionDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseOperacionDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'codigo'         => new sfWidgetFormInputText(),
      'empresa_id'     => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'operacion_id'   => new sfWidgetFormPropelChoice(array('model' => 'Operacion', 'add_empty' => true)),
      'producto_id'    => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'detalle'        => new sfWidgetFormInputText(),
      'cantidad'       => new sfWidgetFormInputText(),
      'valor_total'    => new sfWidgetFormInputText(),
      'servicio_id'    => new sfWidgetFormPropelChoice(array('model' => 'Servicio', 'add_empty' => true)),
      'valor_unitario' => new sfWidgetFormInputText(),
      'descuento'      => new sfWidgetFormInputText(),
      'total_iva'      => new sfWidgetFormInputText(),
      'costo_unitario' => new sfWidgetFormInputText(),
      'linea_no'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'empresa_id'     => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'operacion_id'   => new sfValidatorPropelChoice(array('model' => 'Operacion', 'column' => 'id', 'required' => false)),
      'producto_id'    => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'detalle'        => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'cantidad'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'valor_total'    => new sfValidatorNumber(array('required' => false)),
      'servicio_id'    => new sfValidatorPropelChoice(array('model' => 'Servicio', 'column' => 'id', 'required' => false)),
      'valor_unitario' => new sfValidatorNumber(array('required' => false)),
      'descuento'      => new sfValidatorNumber(array('required' => false)),
      'total_iva'      => new sfValidatorNumber(array('required' => false)),
      'costo_unitario' => new sfValidatorNumber(array('required' => false)),
      'linea_no'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'OperacionDetalle', 'column' => array('linea_no')))
    );

    $this->widgetSchema->setNameFormat('operacion_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OperacionDetalle';
  }


}
