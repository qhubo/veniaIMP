<?php

/**
 * VentasVendedor form base class.
 *
 * @method VentasVendedor getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseVentasVendedorForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'codigo_vendedor'  => new sfWidgetFormInputText(),
      'nombre_vendedor'  => new sfWidgetFormInputText(),
      'facturas'         => new sfWidgetFormInputText(),
      'total_facturas'   => new sfWidgetFormInputText(),
      'detalle_facturas' => new sfWidgetFormTextarea(),
      'notas'            => new sfWidgetFormInputText(),
      'total_notas'      => new sfWidgetFormInputText(),
      'detalle_notas'    => new sfWidgetFormTextarea(),
      'periodo'          => new sfWidgetFormInputText(),
      'mes'              => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'created_by'       => new sfWidgetFormInputText(),
      'updated_by'       => new sfWidgetFormInputText(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'bono'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo_vendedor'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre_vendedor'  => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'facturas'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'total_facturas'   => new sfValidatorNumber(array('required' => false)),
      'detalle_facturas' => new sfValidatorString(array('required' => false)),
      'notas'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'total_notas'      => new sfValidatorNumber(array('required' => false)),
      'detalle_notas'    => new sfValidatorString(array('required' => false)),
      'periodo'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'mes'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
      'created_by'       => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'       => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'bono'             => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ventas_vendedor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'VentasVendedor';
  }


}
