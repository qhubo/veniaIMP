<?php

/**
 * TipoAparato form base class.
 *
 * @method TipoAparato getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseTipoAparatoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'empresa_id'                => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'                    => new sfWidgetFormInputText(),
      'descripcion'               => new sfWidgetFormInputText(),
      'activo'                    => new sfWidgetFormInputCheckbox(),
      'menu_invertido'            => new sfWidgetFormInputCheckbox(),
      'muestra_menu'              => new sfWidgetFormInputCheckbox(),
      'logo'                      => new sfWidgetFormInputText(),
      'cargo_peso_libra_producto' => new sfWidgetFormInputText(),
      'imagen'                    => new sfWidgetFormInputText(),
      'orden_mostrar'             => new sfWidgetFormInputText(),
      'menu_muestra_producto'     => new sfWidgetFormInputCheckbox(),
      'tipo_menu'                 => new sfWidgetFormInputText(),
      'menu_lateral'              => new sfWidgetFormInputCheckbox(),
      'receta'                    => new sfWidgetFormInputCheckbox(),
      'status'                    => new sfWidgetFormInputText(),
      'cuenta_contable'           => new sfWidgetFormInputText(),
      'venta'                     => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'                => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'codigo'                    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'descripcion'               => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'activo'                    => new sfValidatorBoolean(array('required' => false)),
      'menu_invertido'            => new sfValidatorBoolean(array('required' => false)),
      'muestra_menu'              => new sfValidatorBoolean(array('required' => false)),
      'logo'                      => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'cargo_peso_libra_producto' => new sfValidatorNumber(array('required' => false)),
      'imagen'                    => new sfValidatorString(array('max_length' => 151, 'required' => false)),
      'orden_mostrar'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'menu_muestra_producto'     => new sfValidatorBoolean(array('required' => false)),
      'tipo_menu'                 => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'menu_lateral'              => new sfValidatorBoolean(array('required' => false)),
      'receta'                    => new sfValidatorBoolean(array('required' => false)),
      'status'                    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'cuenta_contable'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'venta'                     => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'TipoAparato', 'column' => array('descripcion', 'empresa_id')))
    );

    $this->widgetSchema->setNameFormat('tipo_aparato[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TipoAparato';
  }


}
