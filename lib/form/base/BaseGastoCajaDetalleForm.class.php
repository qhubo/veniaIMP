<?php

/**
 * GastoCajaDetalle form base class.
 *
 * @method GastoCajaDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseGastoCajaDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'gasto_caja_id'     => new sfWidgetFormPropelChoice(array('model' => 'GastoCaja', 'add_empty' => true)),
      'serie'             => new sfWidgetFormInputText(),
      'factura'           => new sfWidgetFormInputText(),
      'fecha'             => new sfWidgetFormInputText(),
      'descripcion'       => new sfWidgetFormInputText(),
      'proveedor_id'      => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'cuenta'            => new sfWidgetFormInputText(),
      'valor'             => new sfWidgetFormInputText(),
      'iva'               => new sfWidgetFormInputText(),
      'valor_isr'         => new sfWidgetFormInputText(),
      'valor_retiene_iva' => new sfWidgetFormInputText(),
      'confrontado_sat'   => new sfWidgetFormInputCheckbox(),
      'no_sat'            => new sfWidgetFormInputText(),
      'valor_idp'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'gasto_caja_id'     => new sfValidatorPropelChoice(array('model' => 'GastoCaja', 'column' => 'id', 'required' => false)),
      'serie'             => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'factura'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha'             => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'descripcion'       => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'proveedor_id'      => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'cuenta'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'valor'             => new sfValidatorNumber(array('required' => false)),
      'iva'               => new sfValidatorNumber(array('required' => false)),
      'valor_isr'         => new sfValidatorNumber(array('required' => false)),
      'valor_retiene_iva' => new sfValidatorNumber(array('required' => false)),
      'confrontado_sat'   => new sfValidatorBoolean(array('required' => false)),
      'no_sat'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'valor_idp'         => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('gasto_caja_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'GastoCajaDetalle';
  }


}
