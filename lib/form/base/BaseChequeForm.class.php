<?php

/**
 * Cheque form base class.
 *
 * @method Cheque getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseChequeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'banco_id'            => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'documento_cheque_id' => new sfWidgetFormPropelChoice(array('model' => 'DocumentoCheque', 'add_empty' => true)),
      'proveedor_id'        => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'numero'              => new sfWidgetFormInputText(),
      'beneficiario'        => new sfWidgetFormInputText(),
      'fecha_cheque'        => new sfWidgetFormDate(),
      'valor'               => new sfWidgetFormInputText(),
      'motivo'              => new sfWidgetFormInputText(),
      'estatus'             => new sfWidgetFormInputText(),
      'negociable'          => new sfWidgetFormInputCheckbox(),
      'usuario'             => new sfWidgetFormInputText(),
      'fecha_creo'          => new sfWidgetFormDateTime(),
      'orden_devolucion_id' => new sfWidgetFormPropelChoice(array('model' => 'OrdenDevolucion', 'add_empty' => true)),
      'solicitud_cheque_id' => new sfWidgetFormPropelChoice(array('model' => 'SolicitudCheque', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'banco_id'            => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
      'documento_cheque_id' => new sfValidatorPropelChoice(array('model' => 'DocumentoCheque', 'column' => 'id', 'required' => false)),
      'proveedor_id'        => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'numero'              => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'beneficiario'        => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'fecha_cheque'        => new sfValidatorDate(array('required' => false)),
      'valor'               => new sfValidatorNumber(array('required' => false)),
      'motivo'              => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'estatus'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'negociable'          => new sfValidatorBoolean(array('required' => false)),
      'usuario'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_creo'          => new sfValidatorDateTime(array('required' => false)),
      'orden_devolucion_id' => new sfValidatorPropelChoice(array('model' => 'OrdenDevolucion', 'column' => 'id', 'required' => false)),
      'solicitud_cheque_id' => new sfValidatorPropelChoice(array('model' => 'SolicitudCheque', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cheque[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cheque';
  }


}
