<?php

/**
 * Empresa form base class.
 *
 * @method Empresa getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseEmpresaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'codigo'               => new sfWidgetFormInputText(),
      'nombre'               => new sfWidgetFormInputText(),
      'nomenclatura'         => new sfWidgetFormInputText(),
      'telefono'             => new sfWidgetFormInputText(),
      'departamento_id'      => new sfWidgetFormPropelChoice(array('model' => 'Departamento', 'add_empty' => true)),
      'municipio_id'         => new sfWidgetFormPropelChoice(array('model' => 'Municipio', 'add_empty' => true)),
      'direccion'            => new sfWidgetFormInputText(),
      'mapa_geo'             => new sfWidgetFormTextarea(),
      'logo'                 => new sfWidgetFormInputText(),
      'contacto_nombre'      => new sfWidgetFormInputText(),
      'contacto_telefono'    => new sfWidgetFormInputText(),
      'contacto_movil'       => new sfWidgetFormInputText(),
      'observaciones'        => new sfWidgetFormTextarea(),
      'factura_electronica'  => new sfWidgetFormInputCheckbox(),
      'contacto_correo'      => new sfWidgetFormInputText(),
      'feel_nombre'          => new sfWidgetFormInputText(),
      'feel_usuario'         => new sfWidgetFormInputText(),
      'feel_token'           => new sfWidgetFormInputText(),
      'feel_llave'           => new sfWidgetFormInputText(),
      'feel_escenario_frase' => new sfWidgetFormInputText(),
      'dias_credito'         => new sfWidgetFormInputText(),
      'retiene_isr'          => new sfWidgetFormInputCheckbox(),
      'moneda_q'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre'               => new sfValidatorString(array('max_length' => 150)),
      'nomenclatura'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'telefono'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'departamento_id'      => new sfValidatorPropelChoice(array('model' => 'Departamento', 'column' => 'id', 'required' => false)),
      'municipio_id'         => new sfValidatorPropelChoice(array('model' => 'Municipio', 'column' => 'id', 'required' => false)),
      'direccion'            => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'mapa_geo'             => new sfValidatorString(array('required' => false)),
      'logo'                 => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'contacto_nombre'      => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'contacto_telefono'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'contacto_movil'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'observaciones'        => new sfValidatorString(array('required' => false)),
      'factura_electronica'  => new sfValidatorBoolean(array('required' => false)),
      'contacto_correo'      => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'feel_nombre'          => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'feel_usuario'         => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'feel_token'           => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'feel_llave'           => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'feel_escenario_frase' => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'dias_credito'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'retiene_isr'          => new sfValidatorBoolean(array('required' => false)),
      'moneda_q'             => new sfValidatorString(array('max_length' => 2, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('empresa[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Empresa';
  }


}
