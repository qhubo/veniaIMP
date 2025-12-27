<?php

/**
 * UsuarioReport form base class.
 *
 * @method UsuarioReport getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseUsuarioReportForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'empresa_id'             => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tipo_letra'             => new sfWidgetFormInputText(),
      'papel'                  => new sfWidgetFormInputText(),
      'orientacion'            => new sfWidgetFormInputText(),
      'logo_tamanio'           => new sfWidgetFormInputText(),
      'logo_posicion'          => new sfWidgetFormInputText(),
      'letra_titulo_no'        => new sfWidgetFormInputText(),
      'letra_detalle_no'       => new sfWidgetFormInputText(),
      'letra_titulo_bold'      => new sfWidgetFormInputCheckbox(),
      'letra_detalle_bold'     => new sfWidgetFormInputCheckbox(),
      'letra_titulo_color'     => new sfWidgetFormInputText(),
      'letra_detalle_color'    => new sfWidgetFormInputText(),
      'una_linea'              => new sfWidgetFormInputCheckbox(),
      'tipo_tabla'             => new sfWidgetFormInputText(),
      'border_color'           => new sfWidgetFormInputText(),
      'fondo_color_encabezado' => new sfWidgetFormInputText(),
      'fondo_color_detalle'    => new sfWidgetFormInputText(),
      'marca_agua'             => new sfWidgetFormInputText(),
      'fondo'                  => new sfWidgetFormInputText(),
      'logo'                   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'             => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'tipo_letra'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'papel'                  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'orientacion'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'logo_tamanio'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'logo_posicion'          => new sfValidatorString(array('max_length' => 90, 'required' => false)),
      'letra_titulo_no'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'letra_detalle_no'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'letra_titulo_bold'      => new sfValidatorBoolean(array('required' => false)),
      'letra_detalle_bold'     => new sfValidatorBoolean(array('required' => false)),
      'letra_titulo_color'     => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'letra_detalle_color'    => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'una_linea'              => new sfValidatorBoolean(array('required' => false)),
      'tipo_tabla'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'border_color'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fondo_color_encabezado' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fondo_color_detalle'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'marca_agua'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'fondo'                  => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'logo'                   => new sfValidatorString(array('max_length' => 150, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_report[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioReport';
  }


}
