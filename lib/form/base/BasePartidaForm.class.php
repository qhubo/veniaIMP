<?php

/**
 * Partida form base class.
 *
 * @method Partida getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BasePartidaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'fecha_contable'    => new sfWidgetFormDate(),
      'usuario'           => new sfWidgetFormInputText(),
      'empresa_id'        => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'            => new sfWidgetFormInputText(),
      'tipo'              => new sfWidgetFormInputText(),
      'created_by'        => new sfWidgetFormInputText(),
      'updated_by'        => new sfWidgetFormInputText(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'valor'             => new sfWidgetFormInputText(),
      'tienda_id'         => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'confirmada'        => new sfWidgetFormInputCheckbox(),
      'estatus'           => new sfWidgetFormInputText(),
      'numero'            => new sfWidgetFormInputText(),
      'medio_pago_id'     => new sfWidgetFormPropelChoice(array('model' => 'MedioPago', 'add_empty' => true)),
      'tipo_partida'      => new sfWidgetFormInputText(),
      'tipo_numero'       => new sfWidgetFormInputText(),
      'detalle'           => new sfWidgetFormInputText(),
      'ano'               => new sfWidgetFormInputText(),
      'mes'               => new sfWidgetFormInputText(),
      'partida_agrupa_id' => new sfWidgetFormPropelChoice(array('model' => 'PartidaAgrupa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'fecha_contable'    => new sfValidatorDate(array('required' => false)),
      'usuario'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'empresa_id'        => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'codigo'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'tipo'              => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'created_by'        => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'updated_by'        => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'        => new sfValidatorDateTime(array('required' => false)),
      'updated_at'        => new sfValidatorDateTime(array('required' => false)),
      'valor'             => new sfValidatorNumber(array('required' => false)),
      'tienda_id'         => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'confirmada'        => new sfValidatorBoolean(array('required' => false)),
      'estatus'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'numero'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'medio_pago_id'     => new sfValidatorPropelChoice(array('model' => 'MedioPago', 'column' => 'id', 'required' => false)),
      'tipo_partida'      => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'tipo_numero'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'detalle'           => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'ano'               => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'mes'               => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'partida_agrupa_id' => new sfValidatorPropelChoice(array('model' => 'PartidaAgrupa', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('partida[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Partida';
  }


}
