<?php

/**
 * ContrasenaCrea form base class.
 *
 * @method ContrasenaCrea getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseContrasenaCreaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'codigo'       => new sfWidgetFormInputText(),
      'fecha'        => new sfWidgetFormDate(),
      'estatus'      => new sfWidgetFormInputText(),
      'proveedor_id' => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'dias_credito' => new sfWidgetFormInputText(),
      'fecha_pago'   => new sfWidgetFormDate(),
      'valor'        => new sfWidgetFormInputText(),
      'empresa_id'   => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha'        => new sfValidatorDate(array('required' => false)),
      'estatus'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'proveedor_id' => new sfValidatorPropelChoice(array('model' => 'Proveedor', 'column' => 'id', 'required' => false)),
      'dias_credito' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'fecha_pago'   => new sfValidatorDate(array('required' => false)),
      'valor'        => new sfValidatorNumber(array('required' => false)),
      'empresa_id'   => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contrasena_crea[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContrasenaCrea';
  }


}
