<?php

/**
 * OrdenCotizacion filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseOrdenCotizacionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'              => new sfWidgetFormFilterInput(),
      'empresa_id'          => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'cliente_id'          => new sfWidgetFormPropelChoice(array('model' => 'Cliente', 'add_empty' => true)),
      'nit'                 => new sfWidgetFormFilterInput(),
      'nombre'              => new sfWidgetFormFilterInput(),
      'fecha_documento'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_vencimiento'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'dia_credito'         => new sfWidgetFormFilterInput(),
      'excento'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'usuario'             => new sfWidgetFormFilterInput(),
      'estatus'             => new sfWidgetFormFilterInput(),
      'comentario'          => new sfWidgetFormFilterInput(),
      'sub_total'           => new sfWidgetFormFilterInput(),
      'iva'                 => new sfWidgetFormFilterInput(),
      'valor_total'         => new sfWidgetFormFilterInput(),
      'cuenta_contable'     => new sfWidgetFormFilterInput(),
      'partida_no'          => new sfWidgetFormFilterInput(),
      'tienda_id'           => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'token'               => new sfWidgetFormFilterInput(),
      'telefono'            => new sfWidgetFormFilterInput(),
      'direccion'           => new sfWidgetFormFilterInput(),
      'correo'              => new sfWidgetFormFilterInput(),
      'usuario_confirmo'    => new sfWidgetFormFilterInput(),
      'fecha_confirmo'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'combo_numero'        => new sfWidgetFormFilterInput(),
      'recetario_id'        => new sfWidgetFormPropelChoice(array('model' => 'Recetario', 'add_empty' => true)),
      'solicitar_bodega'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'cantidad_total_caja' => new sfWidgetFormFilterInput(),
      'peso_total'          => new sfWidgetFormFilterInput(),
      'vendedor_id'         => new sfWidgetFormPropelChoice(array('model' => 'Vendedor', 'add_empty' => true)),
      'pais_id'             => new sfWidgetFormPropelChoice(array('model' => 'Pais', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'codigo'              => new sfValidatorPass(array('required' => false)),
      'empresa_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'cliente_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Cliente', 'column' => 'id')),
      'nit'                 => new sfValidatorPass(array('required' => false)),
      'nombre'              => new sfValidatorPass(array('required' => false)),
      'fecha_documento'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_vencimiento'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'dia_credito'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'excento'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'usuario'             => new sfValidatorPass(array('required' => false)),
      'estatus'             => new sfValidatorPass(array('required' => false)),
      'comentario'          => new sfValidatorPass(array('required' => false)),
      'sub_total'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'iva'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_total'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cuenta_contable'     => new sfValidatorPass(array('required' => false)),
      'partida_no'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tienda_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'token'               => new sfValidatorPass(array('required' => false)),
      'telefono'            => new sfValidatorPass(array('required' => false)),
      'direccion'           => new sfValidatorPass(array('required' => false)),
      'correo'              => new sfValidatorPass(array('required' => false)),
      'usuario_confirmo'    => new sfValidatorPass(array('required' => false)),
      'fecha_confirmo'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'combo_numero'        => new sfValidatorPass(array('required' => false)),
      'recetario_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Recetario', 'column' => 'id')),
      'solicitar_bodega'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'cantidad_total_caja' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'peso_total'          => new sfValidatorPass(array('required' => false)),
      'vendedor_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Vendedor', 'column' => 'id')),
      'pais_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Pais', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('orden_cotizacion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenCotizacion';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'codigo'              => 'Text',
      'empresa_id'          => 'ForeignKey',
      'cliente_id'          => 'ForeignKey',
      'nit'                 => 'Text',
      'nombre'              => 'Text',
      'fecha_documento'     => 'Date',
      'fecha_vencimiento'   => 'Date',
      'fecha'               => 'Date',
      'dia_credito'         => 'Number',
      'excento'             => 'Boolean',
      'usuario'             => 'Text',
      'estatus'             => 'Text',
      'comentario'          => 'Text',
      'sub_total'           => 'Number',
      'iva'                 => 'Number',
      'valor_total'         => 'Number',
      'cuenta_contable'     => 'Text',
      'partida_no'          => 'Number',
      'tienda_id'           => 'ForeignKey',
      'token'               => 'Text',
      'telefono'            => 'Text',
      'direccion'           => 'Text',
      'correo'              => 'Text',
      'usuario_confirmo'    => 'Text',
      'fecha_confirmo'      => 'Date',
      'combo_numero'        => 'Text',
      'recetario_id'        => 'ForeignKey',
      'solicitar_bodega'    => 'Boolean',
      'cantidad_total_caja' => 'Number',
      'peso_total'          => 'Text',
      'vendedor_id'         => 'ForeignKey',
      'pais_id'             => 'ForeignKey',
    );
  }
}
