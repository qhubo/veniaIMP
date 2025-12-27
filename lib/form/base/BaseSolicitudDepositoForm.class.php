<?php

/**
 * SolicitudDeposito form base class.
 *
 * @method SolicitudDeposito getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseSolicitudDepositoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'codigo'                 => new sfWidgetFormInputText(),
      'banco_id'               => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'tienda_id'              => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'fecha_ingreso'          => new sfWidgetFormDateTime(),
      'fecha_deposito'         => new sfWidgetFormDate(),
      'total'                  => new sfWidgetFormInputText(),
      'boleta'                 => new sfWidgetFormInputText(),
      'vendedor'               => new sfWidgetFormInputText(),
      'telefono'               => new sfWidgetFormInputText(),
      'cliente'                => new sfWidgetFormInputText(),
      'pieza'                  => new sfWidgetFormInputText(),
      'stock'                  => new sfWidgetFormInputText(),
      'documento_confirmacion' => new sfWidgetFormInputText(),
      'usuario_confirmo'       => new sfWidgetFormInputText(),
      'fecha_confirmo'         => new sfWidgetFormDateTime(),
      'estatus'                => new sfWidgetFormInputText(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'created_by'             => new sfWidgetFormInputText(),
      'updated_by'             => new sfWidgetFormInputText(),
      'empresa_id'             => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'banco_id'               => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
      'tienda_id'              => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'fecha_ingreso'          => new sfValidatorDateTime(array('required' => false)),
      'fecha_deposito'         => new sfValidatorDate(array('required' => false)),
      'total'                  => new sfValidatorNumber(array('required' => false)),
      'boleta'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'vendedor'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'telefono'               => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'cliente'                => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'pieza'                  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'stock'                  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'documento_confirmacion' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'usuario_confirmo'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_confirmo'         => new sfValidatorDateTime(array('required' => false)),
      'estatus'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'updated_at'             => new sfValidatorDateTime(array('required' => false)),
      'created_by'             => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'             => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'empresa_id'             => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('solicitud_deposito[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SolicitudDeposito';
  }


}
