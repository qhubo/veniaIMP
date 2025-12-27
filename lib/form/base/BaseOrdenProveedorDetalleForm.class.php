<?php

/**
 * OrdenProveedorDetalle form base class.
 *
 * @method OrdenProveedorDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseOrdenProveedorDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'orden_proveedor_id' => new sfWidgetFormPropelChoice(array('model' => 'OrdenProveedor', 'add_empty' => true)),
      'producto_id'        => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'servicio_id'        => new sfWidgetFormPropelChoice(array('model' => 'Servicio', 'add_empty' => true)),
      'codigo'             => new sfWidgetFormInputText(),
      'detalle'            => new sfWidgetFormInputText(),
      'valor_unitario'     => new sfWidgetFormInputText(),
      'cantidad'           => new sfWidgetFormInputText(),
      'valor_total'        => new sfWidgetFormInputText(),
      'total_iva'          => new sfWidgetFormInputText(),
      'observaciones'      => new sfWidgetFormInputText(),
      'valor_isr'          => new sfWidgetFormInputText(),
      'impuesto_gas'       => new sfWidgetFormInputText(),
      'valor_retiene_iva'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'orden_proveedor_id' => new sfValidatorPropelChoice(array('model' => 'OrdenProveedor', 'column' => 'id', 'required' => false)),
      'producto_id'        => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'servicio_id'        => new sfValidatorPropelChoice(array('model' => 'Servicio', 'column' => 'id', 'required' => false)),
      'codigo'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'detalle'            => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'valor_unitario'     => new sfValidatorNumber(array('required' => false)),
      'cantidad'           => new sfValidatorNumber(array('required' => false)),
      'valor_total'        => new sfValidatorNumber(array('required' => false)),
      'total_iva'          => new sfValidatorNumber(array('required' => false)),
      'observaciones'      => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'valor_isr'          => new sfValidatorNumber(array('required' => false)),
      'impuesto_gas'       => new sfValidatorNumber(array('required' => false)),
      'valor_retiene_iva'  => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('orden_proveedor_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenProveedorDetalle';
  }


}
