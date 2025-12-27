<?php

/**
 * OrdenCotizacionDetalle form base class.
 *
 * @method OrdenCotizacionDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseOrdenCotizacionDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'orden_cotizacion_id' => new sfWidgetFormPropelChoice(array('model' => 'OrdenCotizacion', 'add_empty' => true)),
      'producto_id'         => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'servicio_id'         => new sfWidgetFormPropelChoice(array('model' => 'Servicio', 'add_empty' => true)),
      'codigo'              => new sfWidgetFormInputText(),
      'detalle'             => new sfWidgetFormInputText(),
      'valor_unitario'      => new sfWidgetFormInputText(),
      'cantidad'            => new sfWidgetFormInputText(),
      'valor_total'         => new sfWidgetFormInputText(),
      'total_iva'           => new sfWidgetFormInputText(),
      'combo_numero'        => new sfWidgetFormInputText(),
      'costo_unitario'      => new sfWidgetFormInputText(),
      'verificado'          => new sfWidgetFormInputCheckbox(),
      'cantidad_caja'       => new sfWidgetFormInputText(),
      'peso'                => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'orden_cotizacion_id' => new sfValidatorPropelChoice(array('model' => 'OrdenCotizacion', 'column' => 'id', 'required' => false)),
      'producto_id'         => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'servicio_id'         => new sfValidatorPropelChoice(array('model' => 'Servicio', 'column' => 'id', 'required' => false)),
      'codigo'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'detalle'             => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'valor_unitario'      => new sfValidatorNumber(array('required' => false)),
      'cantidad'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'valor_total'         => new sfValidatorNumber(array('required' => false)),
      'total_iva'           => new sfValidatorNumber(array('required' => false)),
      'combo_numero'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'costo_unitario'      => new sfValidatorNumber(array('required' => false)),
      'verificado'          => new sfValidatorBoolean(array('required' => false)),
      'cantidad_caja'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'peso'                => new sfValidatorString(array('max_length' => 150, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('orden_cotizacion_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenCotizacionDetalle';
  }


}
