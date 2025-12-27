<?php

/**
 * Operacion form base class.
 *
 * @method Operacion getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseOperacionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'codigo'                    => new sfWidgetFormInputText(),
      'tipo'                      => new sfWidgetFormInputText(),
      'estatus'                   => new sfWidgetFormInputText(),
      'empresa_id'                => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'usuario'                   => new sfWidgetFormInputText(),
      'nombre'                    => new sfWidgetFormInputText(),
      'nit'                       => new sfWidgetFormInputText(),
      'correo'                    => new sfWidgetFormInputText(),
      'fecha'                     => new sfWidgetFormDateTime(),
      'valor_total'               => new sfWidgetFormInputText(),
      'valor_pagado'              => new sfWidgetFormInputText(),
      'codigo_factura'            => new sfWidgetFormInputText(),
      'face_serie_factura'        => new sfWidgetFormInputText(),
      'face_numero_factura'       => new sfWidgetFormInputText(),
      'face_referencia'           => new sfWidgetFormInputText(),
      'face_fecha_emision'        => new sfWidgetFormDateTime(),
      'face_firma'                => new sfWidgetFormInputText(),
      'face_error'                => new sfWidgetFormInputText(),
      'face_estado'               => new sfWidgetFormInputText(),
      'cuenta_contable'           => new sfWidgetFormInputText(),
      'partida_no'                => new sfWidgetFormInputText(),
      'codigo_establecimiento'    => new sfWidgetFormInputText(),
      'sub_total'                 => new sfWidgetFormInputText(),
      'iva'                       => new sfWidgetFormInputText(),
      'tienda_id'                 => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'pagado'                    => new sfWidgetFormInputCheckbox(),
      'anulado'                   => new sfWidgetFormInputCheckbox(),
      'observaciones'             => new sfWidgetFormInputText(),
      'anulo_usuario'             => new sfWidgetFormInputText(),
      'fecha_anulo'               => new sfWidgetFormDateTime(),
      'docentry'                  => new sfWidgetFormInputText(),
      'recetario_id'              => new sfWidgetFormPropelChoice(array('model' => 'Recetario', 'add_empty' => true)),
      'anula_face_serie_factura'  => new sfWidgetFormInputText(),
      'anula_face_numero_factura' => new sfWidgetFormInputText(),
      'anula_face_referencia'     => new sfWidgetFormInputText(),
      'anula_face_fecha_emision'  => new sfWidgetFormInputText(),
      'anula_docentry'            => new sfWidgetFormInputText(),
      'anula_face_firma'          => new sfWidgetFormInputText(),
      'cliente_id'                => new sfWidgetFormPropelChoice(array('model' => 'Cliente', 'add_empty' => true)),
      'cantidad_total_caja'       => new sfWidgetFormInputText(),
      'peso_total'                => new sfWidgetFormInputText(),
      'vendedor_id'               => new sfWidgetFormPropelChoice(array('model' => 'Vendedor', 'add_empty' => true)),
      'ruta_cobro'                => new sfWidgetFormInputText(),
      'fecha_cobro'               => new sfWidgetFormDate(),
      'permite_facturar'          => new sfWidgetFormInputCheckbox(),
      'observa_facturar'          => new sfWidgetFormInputText(),
      'pais_id'                   => new sfWidgetFormPropelChoice(array('model' => 'Pais', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'codigo'                    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'tipo'                      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'estatus'                   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'empresa_id'                => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'usuario'                   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre'                    => new sfValidatorString(array('max_length' => 300, 'required' => false)),
      'nit'                       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'correo'                    => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'fecha'                     => new sfValidatorDateTime(array('required' => false)),
      'valor_total'               => new sfValidatorNumber(array('required' => false)),
      'valor_pagado'              => new sfValidatorNumber(array('required' => false)),
      'codigo_factura'            => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'face_serie_factura'        => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'face_numero_factura'       => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'face_referencia'           => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'face_fecha_emision'        => new sfValidatorDateTime(array('required' => false)),
      'face_firma'                => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'face_error'                => new sfValidatorString(array('max_length' => 450, 'required' => false)),
      'face_estado'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'cuenta_contable'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'partida_no'                => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'codigo_establecimiento'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'sub_total'                 => new sfValidatorNumber(array('required' => false)),
      'iva'                       => new sfValidatorNumber(array('required' => false)),
      'tienda_id'                 => new sfValidatorPropelChoice(array('model' => 'Tienda', 'column' => 'id', 'required' => false)),
      'pagado'                    => new sfValidatorBoolean(array('required' => false)),
      'anulado'                   => new sfValidatorBoolean(array('required' => false)),
      'observaciones'             => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'anulo_usuario'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'fecha_anulo'               => new sfValidatorDateTime(array('required' => false)),
      'docentry'                  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'recetario_id'              => new sfValidatorPropelChoice(array('model' => 'Recetario', 'column' => 'id', 'required' => false)),
      'anula_face_serie_factura'  => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'anula_face_numero_factura' => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'anula_face_referencia'     => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'anula_face_fecha_emision'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'anula_docentry'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'anula_face_firma'          => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'cliente_id'                => new sfValidatorPropelChoice(array('model' => 'Cliente', 'column' => 'id', 'required' => false)),
      'cantidad_total_caja'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'peso_total'                => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'vendedor_id'               => new sfValidatorPropelChoice(array('model' => 'Vendedor', 'column' => 'id', 'required' => false)),
      'ruta_cobro'                => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'fecha_cobro'               => new sfValidatorDate(array('required' => false)),
      'permite_facturar'          => new sfValidatorBoolean(array('required' => false)),
      'observa_facturar'          => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'pais_id'                   => new sfValidatorPropelChoice(array('model' => 'Pais', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('operacion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Operacion';
  }


}
