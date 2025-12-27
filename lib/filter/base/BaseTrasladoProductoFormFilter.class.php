<?php

/**
 * TrasladoProducto filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseTrasladoProductoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'           => new sfWidgetFormFilterInput(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'producto_id'      => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'bodega_origen'    => new sfWidgetFormFilterInput(),
      'bodega_destino'   => new sfWidgetFormFilterInput(),
      'comentario'       => new sfWidgetFormFilterInput(),
      'cantidad'         => new sfWidgetFormFilterInput(),
      'estatus'          => new sfWidgetFormFilterInput(),
      'usuario'          => new sfWidgetFormFilterInput(),
      'fecha'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'usuario_confirmo' => new sfWidgetFormFilterInput(),
      'fecha_confirmo'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'codigo'           => new sfValidatorPass(array('required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'producto_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'bodega_origen'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'bodega_destino'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'comentario'       => new sfValidatorPass(array('required' => false)),
      'cantidad'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'estatus'          => new sfValidatorPass(array('required' => false)),
      'usuario'          => new sfValidatorPass(array('required' => false)),
      'fecha'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'usuario_confirmo' => new sfValidatorPass(array('required' => false)),
      'fecha_confirmo'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('traslado_producto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TrasladoProducto';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'codigo'           => 'Text',
      'empresa_id'       => 'ForeignKey',
      'producto_id'      => 'ForeignKey',
      'bodega_origen'    => 'Number',
      'bodega_destino'   => 'Number',
      'comentario'       => 'Text',
      'cantidad'         => 'Number',
      'estatus'          => 'Text',
      'usuario'          => 'Text',
      'fecha'            => 'Date',
      'usuario_confirmo' => 'Text',
      'fecha_confirmo'   => 'Date',
    );
  }
}
