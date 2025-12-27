<?php

/**
 * Prestamo form base class.
 *
 * @method Prestamo getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BasePrestamoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'codigo'        => new sfWidgetFormInputText(),
      'nombre'        => new sfWidgetFormInputText(),
      'observaciones' => new sfWidgetFormTextarea(),
      'valor'         => new sfWidgetFormInputText(),
      'fecha_inicio'  => new sfWidgetFormDate(),
      'moneda'        => new sfWidgetFormInputText(),
      'tasa_interes'  => new sfWidgetFormInputText(),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'estatus'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre'        => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'observaciones' => new sfValidatorString(array('required' => false)),
      'valor'         => new sfValidatorNumber(array('required' => false)),
      'fecha_inicio'  => new sfValidatorDate(array('required' => false)),
      'moneda'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'tasa_interes'  => new sfValidatorNumber(array('required' => false)),
      'empresa_id'    => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'estatus'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('prestamo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Prestamo';
  }


}
