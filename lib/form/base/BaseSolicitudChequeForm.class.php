<?php

/**
 * SolicitudCheque form base class.
 *
 * @method SolicitudCheque getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseSolicitudChequeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'codigo'           => new sfWidgetFormInputText(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tipo'             => new sfWidgetFormInputText(),
      'nombre'           => new sfWidgetFormInputText(),
      'referencia'       => new sfWidgetFormInputText(),
      'motivo'           => new sfWidgetFormTextarea(),
      'valor'            => new sfWidgetFormInputText(),
      'partida_no'       => new sfWidgetFormInputText(),
      'estatus'          => new sfWidgetFormInputText(),
      'fecha'            => new sfWidgetFormDate(),
      'usuario'          => new sfWidgetFormInputText(),
      'usuario_confirmo' => new sfWidgetFormInputText(),
      'fecha_confirmo'   => new sfWidgetFormDateTime(),
      'cheque_no'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'tipo'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre'           => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'referencia'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'motivo'           => new sfValidatorString(array('required' => false)),
      'valor'            => new sfValidatorNumber(array('required' => false)),
      'partida_no'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'estatus'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha'            => new sfValidatorDate(array('required' => false)),
      'usuario'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'usuario_confirmo' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_confirmo'   => new sfValidatorDateTime(array('required' => false)),
      'cheque_no'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('solicitud_cheque[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SolicitudCheque';
  }


}
