<?php

/**
 * CierreCaja form base class.
 *
 * @method CierreCaja getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseCierreCajaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'fecha_creo'       => new sfWidgetFormDateTime(),
      'usuario'          => new sfWidgetFormInputText(),
      'fecha_calendario' => new sfWidgetFormDate(),
      'valor_total'      => new sfWidgetFormInputText(),
      'no_documentos'    => new sfWidgetFormInputText(),
      'valor_caja'       => new sfWidgetFormInputText(),
      'estatus'          => new sfWidgetFormInputText(),
      'inicio'           => new sfWidgetFormDateTime(),
      'fin'              => new sfWidgetFormDateTime(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tienda_id'        => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'cierre_dia_id'    => new sfWidgetFormPropelChoice(array('model' => 'Cierre', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'fecha_creo'       => new sfValidatorDateTime(array('required' => false)),
      'usuario'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_calendario' => new sfValidatorDate(array('required' => false)),
      'valor_total'      => new sfValidatorNumber(array('required' => false)),
      'no_documentos'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'valor_caja'       => new sfValidatorNumber(array('required' => false)),
      'estatus'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'inicio'           => new sfValidatorDateTime(array('required' => false)),
      'fin'              => new sfValidatorDateTime(array('required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'tienda_id'        => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'cierre_dia_id'    => new sfValidatorPropelChoice(array('model' => 'Cierre', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cierre_caja[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CierreCaja';
  }


}
