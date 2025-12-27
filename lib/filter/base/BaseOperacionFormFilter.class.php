<?php

/**
 * Operacion filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseOperacionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'                    => new sfWidgetFormFilterInput(),
      'tipo'                      => new sfWidgetFormFilterInput(),
      'estatus'                   => new sfWidgetFormFilterInput(),
      'empresa_id'                => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'usuario'                   => new sfWidgetFormFilterInput(),
      'nombre'                    => new sfWidgetFormFilterInput(),
      'nit'                       => new sfWidgetFormFilterInput(),
      'correo'                    => new sfWidgetFormFilterInput(),
      'fecha'                     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'valor_total'               => new sfWidgetFormFilterInput(),
      'valor_pagado'              => new sfWidgetFormFilterInput(),
      'codigo_factura'            => new sfWidgetFormFilterInput(),
      'face_serie_factura'        => new sfWidgetFormFilterInput(),
      'face_numero_factura'       => new sfWidgetFormFilterInput(),
      'face_referencia'           => new sfWidgetFormFilterInput(),
      'face_fecha_emision'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'face_firma'                => new sfWidgetFormFilterInput(),
      'face_error'                => new sfWidgetFormFilterInput(),
      'face_estado'               => new sfWidgetFormFilterInput(),
      'cuenta_contable'           => new sfWidgetFormFilterInput(),
      'partida_no'                => new sfWidgetFormFilterInput(),
      'codigo_establecimiento'    => new sfWidgetFormFilterInput(),
      'sub_total'                 => new sfWidgetFormFilterInput(),
      'iva'                       => new sfWidgetFormFilterInput(),
      'tienda_id'                 => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'pagado'                    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'anulado'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'observaciones'             => new sfWidgetFormFilterInput(),
      'anulo_usuario'             => new sfWidgetFormFilterInput(),
      'fecha_anulo'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'docentry'                  => new sfWidgetFormFilterInput(),
      'recetario_id'              => new sfWidgetFormPropelChoice(array('model' => 'Recetario', 'add_empty' => true)),
      'anula_face_serie_factura'  => new sfWidgetFormFilterInput(),
      'anula_face_numero_factura' => new sfWidgetFormFilterInput(),
      'anula_face_referencia'     => new sfWidgetFormFilterInput(),
      'anula_face_fecha_emision'  => new sfWidgetFormFilterInput(),
      'anula_docentry'            => new sfWidgetFormFilterInput(),
      'anula_face_firma'          => new sfWidgetFormFilterInput(),
      'cliente_id'                => new sfWidgetFormPropelChoice(array('model' => 'Cliente', 'add_empty' => true)),
      'cantidad_total_caja'       => new sfWidgetFormFilterInput(),
      'peso_total'                => new sfWidgetFormFilterInput(),
      'vendedor_id'               => new sfWidgetFormPropelChoice(array('model' => 'Vendedor', 'add_empty' => true)),
      'ruta_cobro'                => new sfWidgetFormFilterInput(),
      'fecha_cobro'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'permite_facturar'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'observa_facturar'          => new sfWidgetFormFilterInput(),
      'pais_id'                   => new sfWidgetFormPropelChoice(array('model' => 'Pais', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'codigo'                    => new sfValidatorPass(array('required' => false)),
      'tipo'                      => new sfValidatorPass(array('required' => false)),
      'estatus'                   => new sfValidatorPass(array('required' => false)),
      'empresa_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'usuario'                   => new sfValidatorPass(array('required' => false)),
      'nombre'                    => new sfValidatorPass(array('required' => false)),
      'nit'                       => new sfValidatorPass(array('required' => false)),
      'correo'                    => new sfValidatorPass(array('required' => false)),
      'fecha'                     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'valor_total'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_pagado'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'codigo_factura'            => new sfValidatorPass(array('required' => false)),
      'face_serie_factura'        => new sfValidatorPass(array('required' => false)),
      'face_numero_factura'       => new sfValidatorPass(array('required' => false)),
      'face_referencia'           => new sfValidatorPass(array('required' => false)),
      'face_fecha_emision'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'face_firma'                => new sfValidatorPass(array('required' => false)),
      'face_error'                => new sfValidatorPass(array('required' => false)),
      'face_estado'               => new sfValidatorPass(array('required' => false)),
      'cuenta_contable'           => new sfValidatorPass(array('required' => false)),
      'partida_no'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'codigo_establecimiento'    => new sfValidatorPass(array('required' => false)),
      'sub_total'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'iva'                       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'tienda_id'                 => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'pagado'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'anulado'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'observaciones'             => new sfValidatorPass(array('required' => false)),
      'anulo_usuario'             => new sfValidatorPass(array('required' => false)),
      'fecha_anulo'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'docentry'                  => new sfValidatorPass(array('required' => false)),
      'recetario_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Recetario', 'column' => 'id')),
      'anula_face_serie_factura'  => new sfValidatorPass(array('required' => false)),
      'anula_face_numero_factura' => new sfValidatorPass(array('required' => false)),
      'anula_face_referencia'     => new sfValidatorPass(array('required' => false)),
      'anula_face_fecha_emision'  => new sfValidatorPass(array('required' => false)),
      'anula_docentry'            => new sfValidatorPass(array('required' => false)),
      'anula_face_firma'          => new sfValidatorPass(array('required' => false)),
      'cliente_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Cliente', 'column' => 'id')),
      'cantidad_total_caja'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'peso_total'                => new sfValidatorPass(array('required' => false)),
      'vendedor_id'               => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Vendedor', 'column' => 'id')),
      'ruta_cobro'                => new sfValidatorPass(array('required' => false)),
      'fecha_cobro'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'permite_facturar'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'observa_facturar'          => new sfValidatorPass(array('required' => false)),
      'pais_id'                   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Pais', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('operacion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Operacion';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'codigo'                    => 'Text',
      'tipo'                      => 'Text',
      'estatus'                   => 'Text',
      'empresa_id'                => 'ForeignKey',
      'usuario'                   => 'Text',
      'nombre'                    => 'Text',
      'nit'                       => 'Text',
      'correo'                    => 'Text',
      'fecha'                     => 'Date',
      'valor_total'               => 'Number',
      'valor_pagado'              => 'Number',
      'codigo_factura'            => 'Text',
      'face_serie_factura'        => 'Text',
      'face_numero_factura'       => 'Text',
      'face_referencia'           => 'Text',
      'face_fecha_emision'        => 'Date',
      'face_firma'                => 'Text',
      'face_error'                => 'Text',
      'face_estado'               => 'Text',
      'cuenta_contable'           => 'Text',
      'partida_no'                => 'Number',
      'codigo_establecimiento'    => 'Text',
      'sub_total'                 => 'Number',
      'iva'                       => 'Number',
      'tienda_id'                 => 'ForeignKey',
      'pagado'                    => 'Boolean',
      'anulado'                   => 'Boolean',
      'observaciones'             => 'Text',
      'anulo_usuario'             => 'Text',
      'fecha_anulo'               => 'Date',
      'docentry'                  => 'Text',
      'recetario_id'              => 'ForeignKey',
      'anula_face_serie_factura'  => 'Text',
      'anula_face_numero_factura' => 'Text',
      'anula_face_referencia'     => 'Text',
      'anula_face_fecha_emision'  => 'Text',
      'anula_docentry'            => 'Text',
      'anula_face_firma'          => 'Text',
      'cliente_id'                => 'ForeignKey',
      'cantidad_total_caja'       => 'Number',
      'peso_total'                => 'Text',
      'vendedor_id'               => 'ForeignKey',
      'ruta_cobro'                => 'Text',
      'fecha_cobro'               => 'Date',
      'permite_facturar'          => 'Boolean',
      'observa_facturar'          => 'Text',
      'pais_id'                   => 'ForeignKey',
    );
  }
}
