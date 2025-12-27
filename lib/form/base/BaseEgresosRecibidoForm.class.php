<?php

/**
 * EgresosRecibido form base class.
 *
 * @method EgresosRecibido getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseEgresosRecibidoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'medio_pago_id' => new sfWidgetFormPropelChoice(array('model' => 'MedioPago', 'add_empty' => true)),
      'tienda_id'     => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'fecha'         => new sfWidgetFormDate(),
      'total'         => new sfWidgetFormInputText(),
      'partida_no'    => new sfWidgetFormInputText(),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'usuario_creo'  => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'observaciones' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'medio_pago_id' => new sfValidatorPropelChoice(array('model' => 'MedioPago', 'column' => 'id', 'required' => false)),
      'tienda_id'     => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'fecha'         => new sfValidatorDate(array('required' => false)),
      'total'         => new sfValidatorNumber(array('required' => false)),
      'partida_no'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'empresa_id'    => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'usuario_creo'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'observaciones' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('egresos_recibido[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EgresosRecibido';
  }


}
