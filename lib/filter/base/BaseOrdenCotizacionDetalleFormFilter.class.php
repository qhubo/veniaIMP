<?php

/**
 * OrdenCotizacionDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseOrdenCotizacionDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'orden_cotizacion_id' => new sfWidgetFormPropelChoice(array('model' => 'OrdenCotizacion', 'add_empty' => true)),
      'producto_id'         => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'servicio_id'         => new sfWidgetFormPropelChoice(array('model' => 'Servicio', 'add_empty' => true)),
      'codigo'              => new sfWidgetFormFilterInput(),
      'detalle'             => new sfWidgetFormFilterInput(),
      'valor_unitario'      => new sfWidgetFormFilterInput(),
      'cantidad'            => new sfWidgetFormFilterInput(),
      'valor_total'         => new sfWidgetFormFilterInput(),
      'total_iva'           => new sfWidgetFormFilterInput(),
      'combo_numero'        => new sfWidgetFormFilterInput(),
      'costo_unitario'      => new sfWidgetFormFilterInput(),
      'verificado'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'cantidad_caja'       => new sfWidgetFormFilterInput(),
      'peso'                => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'orden_cotizacion_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'OrdenCotizacion', 'column' => 'id')),
      'producto_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'servicio_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Servicio', 'column' => 'id')),
      'codigo'              => new sfValidatorPass(array('required' => false)),
      'detalle'             => new sfValidatorPass(array('required' => false)),
      'valor_unitario'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cantidad'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'valor_total'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_iva'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'combo_numero'        => new sfValidatorPass(array('required' => false)),
      'costo_unitario'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'verificado'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'cantidad_caja'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'peso'                => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('orden_cotizacion_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenCotizacionDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'orden_cotizacion_id' => 'ForeignKey',
      'producto_id'         => 'ForeignKey',
      'servicio_id'         => 'ForeignKey',
      'codigo'              => 'Text',
      'detalle'             => 'Text',
      'valor_unitario'      => 'Number',
      'cantidad'            => 'Number',
      'valor_total'         => 'Number',
      'total_iva'           => 'Number',
      'combo_numero'        => 'Text',
      'costo_unitario'      => 'Number',
      'verificado'          => 'Boolean',
      'cantidad_caja'       => 'Number',
      'peso'                => 'Text',
    );
  }
}
