<?php

/**
 * Marca form base class.
 *
 * @method Marca getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseMarcaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tipo_aparato_id' => new sfWidgetFormPropelChoice(array('model' => 'TipoAparato', 'add_empty' => true)),
      'codigo'          => new sfWidgetFormInputText(),
      'descripcion'     => new sfWidgetFormInputText(),
      'muestra_menu'    => new sfWidgetFormInputCheckbox(),
      'logo'            => new sfWidgetFormInputText(),
      'activo'          => new sfWidgetFormInputCheckbox(),
      'imagen'          => new sfWidgetFormInputText(),
      'orden_mostrar'   => new sfWidgetFormInputText(),
      'receta'          => new sfWidgetFormInputCheckbox(),
      'status'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'      => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'tipo_aparato_id' => new sfValidatorPropelChoice(array('model' => 'TipoAparato', 'column' => 'id', 'required' => false)),
      'codigo'          => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'descripcion'     => new sfValidatorString(array('max_length' => 260)),
      'muestra_menu'    => new sfValidatorBoolean(array('required' => false)),
      'logo'            => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'activo'          => new sfValidatorBoolean(array('required' => false)),
      'imagen'          => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'orden_mostrar'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'receta'          => new sfValidatorBoolean(array('required' => false)),
      'status'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('marca[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Marca';
  }


}
