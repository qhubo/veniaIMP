<?php

/**
 * Vendedor form base class.
 *
 * @method Vendedor getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseVendedorForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'codigo'              => new sfWidgetFormInputText(),
      'nombre'              => new sfWidgetFormInputText(),
      'activo'              => new sfWidgetFormInputCheckbox(),
      'empresa_id'          => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'porcentaje_comision' => new sfWidgetFormInputText(),
      'tienda_comision'     => new sfWidgetFormInputText(),
      'encargado_tienda'    => new sfWidgetFormInputCheckbox(),
      'codigo_planilla'     => new sfWidgetFormInputText(),
      'observaciones'       => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre'              => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'activo'              => new sfValidatorBoolean(array('required' => false)),
      'empresa_id'          => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'porcentaje_comision' => new sfValidatorNumber(array('required' => false)),
      'tienda_comision'     => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'encargado_tienda'    => new sfValidatorBoolean(array('required' => false)),
      'codigo_planilla'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'observaciones'       => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('vendedor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Vendedor';
  }


}
