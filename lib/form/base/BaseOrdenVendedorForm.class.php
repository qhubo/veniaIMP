<?php

/**
 * OrdenVendedor form base class.
 *
 * @method OrdenVendedor getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseOrdenVendedorForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'observaciones' => new sfWidgetFormInputText(),
      'estado'        => new sfWidgetFormInputText(),
      'fecha'         => new sfWidgetFormDateTime(),
      'usuario'       => new sfWidgetFormInputText(),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'vendedor_id'   => new sfWidgetFormPropelChoice(array('model' => 'Vendedor', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'observaciones' => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'estado'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha'         => new sfValidatorDateTime(array('required' => false)),
      'usuario'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'empresa_id'    => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'vendedor_id'   => new sfValidatorPropelChoice(array('model' => 'Vendedor', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('orden_vendedor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenVendedor';
  }


}
