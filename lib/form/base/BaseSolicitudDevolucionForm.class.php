<?php

/**
 * SolicitudDevolucion form base class.
 *
 * @method SolicitudDevolucion getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseSolicitudDevolucionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'codigo'           => new sfWidgetFormInputText(),
      'fecha'            => new sfWidgetFormDate(),
      'factura'          => new sfWidgetFormInputText(),
      'no_referencia'    => new sfWidgetFormInputText(),
      'vendedor'         => new sfWidgetFormInputText(),
      'descripcion'      => new sfWidgetFormInputText(),
      'nombre_cliente'   => new sfWidgetFormInputText(),
      'dpi'              => new sfWidgetFormInputText(),
      'telefono'         => new sfWidgetFormInputText(),
      'medio_pago'       => new sfWidgetFormInputText(),
      'usuario'          => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'estatus'          => new sfWidgetFormInputText(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'valor'            => new sfWidgetFormInputText(),
      'usuario_confirmo' => new sfWidgetFormInputText(),
      'fecha_confirmo'   => new sfWidgetFormDateTime(),
      'valor_retiene'    => new sfWidgetFormInputText(),
      'tienda_id'        => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'motivo'           => new sfWidgetFormInputText(),
      'detalle_motivo'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha'            => new sfValidatorDate(array('required' => false)),
      'factura'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'no_referencia'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'vendedor'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'descripcion'      => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'nombre_cliente'   => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'dpi'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'telefono'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'medio_pago'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'usuario'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'estatus'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'valor'            => new sfValidatorNumber(array('required' => false)),
      'usuario_confirmo' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_confirmo'   => new sfValidatorDateTime(array('required' => false)),
      'valor_retiene'    => new sfValidatorNumber(array('required' => false)),
      'tienda_id'        => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'motivo'           => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'detalle_motivo'   => new sfValidatorString(array('max_length' => 450, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('solicitud_devolucion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SolicitudDevolucion';
  }


}
