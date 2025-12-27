<?php

/**
 * TipoServicio form base class.
 *
 * @method TipoServicio getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseTipoServicioForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'empresa_id'        => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'            => new sfWidgetFormInputText(),
      'nombre'            => new sfWidgetFormInputText(),
      'activo'            => new sfWidgetFormInputCheckbox(),
      'dia_credito'       => new sfWidgetFormInputText(),
      'cuenta_contable'   => new sfWidgetFormInputText(),
      'precio'            => new sfWidgetFormInputText(),
      'impuesto_hotelero' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'        => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'codigo'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre'            => new sfValidatorString(array('max_length' => 150)),
      'activo'            => new sfValidatorBoolean(array('required' => false)),
      'dia_credito'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'cuenta_contable'   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'precio'            => new sfValidatorNumber(array('required' => false)),
      'impuesto_hotelero' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tipo_servicio[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TipoServicio';
  }


}
