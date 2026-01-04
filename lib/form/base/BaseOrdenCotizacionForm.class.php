<?php

/**
 * OrdenCotizacion form base class.
 *
 * @method OrdenCotizacion getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseOrdenCotizacionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'codigo'              => new sfWidgetFormInputText(),
      'empresa_id'          => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'cliente_id'          => new sfWidgetFormPropelChoice(array('model' => 'Cliente', 'add_empty' => true)),
      'nit'                 => new sfWidgetFormInputText(),
      'nombre'              => new sfWidgetFormInputText(),
      'fecha_documento'     => new sfWidgetFormDate(),
      'fecha_vencimiento'   => new sfWidgetFormDate(),
      'fecha'               => new sfWidgetFormDateTime(),
      'dia_credito'         => new sfWidgetFormInputText(),
      'excento'             => new sfWidgetFormInputCheckbox(),
      'usuario'             => new sfWidgetFormInputText(),
      'estatus'             => new sfWidgetFormInputText(),
      'comentario'          => new sfWidgetFormInputText(),
      'sub_total'           => new sfWidgetFormInputText(),
      'iva'                 => new sfWidgetFormInputText(),
      'valor_total'         => new sfWidgetFormInputText(),
      'cuenta_contable'     => new sfWidgetFormInputText(),
      'partida_no'          => new sfWidgetFormInputText(),
      'tienda_id'           => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'token'               => new sfWidgetFormInputText(),
      'telefono'            => new sfWidgetFormInputText(),
      'direccion'           => new sfWidgetFormInputText(),
      'correo'              => new sfWidgetFormInputText(),
      'usuario_confirmo'    => new sfWidgetFormInputText(),
      'fecha_confirmo'      => new sfWidgetFormDateTime(),
      'combo_numero'        => new sfWidgetFormInputText(),
      'recetario_id'        => new sfWidgetFormPropelChoice(array('model' => 'Recetario', 'add_empty' => true)),
      'solicitar_bodega'    => new sfWidgetFormInputCheckbox(),
      'cantidad_total_caja' => new sfWidgetFormInputText(),
      'peso_total'          => new sfWidgetFormInputText(),
      'vendedor_id'         => new sfWidgetFormPropelChoice(array('model' => 'Vendedor', 'add_empty' => true)),
      'pais_id'             => new sfWidgetFormPropelChoice(array('model' => 'Pais', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'empresa_id'          => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'cliente_id'          => new sfValidatorPropelChoice(array('model' => 'Cliente', 'column' => 'id', 'required' => false)),
      'nit'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre'              => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'fecha_documento'     => new sfValidatorDate(array('required' => false)),
      'fecha_vencimiento'   => new sfValidatorDate(array('required' => false)),
      'fecha'               => new sfValidatorDateTime(array('required' => false)),
      'dia_credito'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'excento'             => new sfValidatorBoolean(array('required' => false)),
      'usuario'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'estatus'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'comentario'          => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'sub_total'           => new sfValidatorNumber(array('required' => false)),
      'iva'                 => new sfValidatorNumber(array('required' => false)),
      'valor_total'         => new sfValidatorNumber(array('required' => false)),
      'cuenta_contable'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'partida_no'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tienda_id'           => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'token'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'telefono'            => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'direccion'           => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'correo'              => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'usuario_confirmo'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_confirmo'      => new sfValidatorDateTime(array('required' => false)),
      'combo_numero'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'recetario_id'        => new sfValidatorPropelChoice(array('model' => 'Recetario', 'column' => 'id', 'required' => false)),
      'solicitar_bodega'    => new sfValidatorBoolean(array('required' => false)),
      'cantidad_total_caja' => new sfValidatorNumber(array('required' => false)),
      'peso_total'          => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'vendedor_id'         => new sfValidatorPropelChoice(array('model' => 'Vendedor', 'column' => 'id', 'required' => false)),
      'pais_id'             => new sfValidatorPropelChoice(array('model' => 'Pais', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('orden_cotizacion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenCotizacion';
  }


}
