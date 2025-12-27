<?php

/**
 * ListaActivos form base class.
 *
 * @method ListaActivos getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseListaActivosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'codigo'                 => new sfWidgetFormInputText(),
      'cuenta_contable'        => new sfWidgetFormInputText(),
      'detalle'                => new sfWidgetFormInputText(),
      'fecha_adquision'        => new sfWidgetFormDate(),
      'anio_util'              => new sfWidgetFormInputText(),
      'valor_libro'            => new sfWidgetFormInputText(),
      'porcentaje'             => new sfWidgetFormInputText(),
      'cuenta_erp_contable_id' => new sfWidgetFormPropelChoice(array('model' => 'CuentaErpContable', 'add_empty' => true)),
      'usuario'                => new sfWidgetFormInputText(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'activo'                 => new sfWidgetFormInputCheckbox(),
      'empresa_id'             => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'cuenta_contable'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'detalle'                => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'fecha_adquision'        => new sfValidatorDate(array('required' => false)),
      'anio_util'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'valor_libro'            => new sfValidatorNumber(array('required' => false)),
      'porcentaje'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'cuenta_erp_contable_id' => new sfValidatorPropelChoice(array('model' => 'CuentaErpContable', 'column' => 'id', 'required' => false)),
      'usuario'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'updated_at'             => new sfValidatorDateTime(array('required' => false)),
      'activo'                 => new sfValidatorBoolean(array('required' => false)),
      'empresa_id'             => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lista_activos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaActivos';
  }


}
