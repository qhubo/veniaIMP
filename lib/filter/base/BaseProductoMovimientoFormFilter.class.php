<?php

/**
 * ProductoMovimiento filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseProductoMovimientoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'producto_id'   => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'fecha'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'cantidad'      => new sfWidgetFormFilterInput(),
      'tienda_id'     => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'identificador' => new sfWidgetFormFilterInput(),
      'tipo'          => new sfWidgetFormFilterInput(),
      'motivo'        => new sfWidgetFormFilterInput(),
      'inicio'        => new sfWidgetFormFilterInput(),
      'fin'           => new sfWidgetFormFilterInput(),
      'valor_total'   => new sfWidgetFormFilterInput(),
      'sub_total'     => new sfWidgetFormFilterInput(),
      'iva'           => new sfWidgetFormFilterInput(),
      'linea_no'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'producto_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Producto', 'column' => 'id')),
      'fecha'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cantidad'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tienda_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'identificador' => new sfValidatorPass(array('required' => false)),
      'tipo'          => new sfValidatorPass(array('required' => false)),
      'motivo'        => new sfValidatorPass(array('required' => false)),
      'inicio'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'fin'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_total'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'sub_total'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'iva'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'linea_no'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_movimiento_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductoMovimiento';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'empresa_id'    => 'ForeignKey',
      'producto_id'   => 'ForeignKey',
      'fecha'         => 'Date',
      'cantidad'      => 'Number',
      'tienda_id'     => 'ForeignKey',
      'identificador' => 'Text',
      'tipo'          => 'Text',
      'motivo'        => 'Text',
      'inicio'        => 'Number',
      'fin'           => 'Number',
      'valor_total'   => 'Number',
      'sub_total'     => 'Number',
      'iva'           => 'Number',
      'linea_no'      => 'Text',
    );
  }
}
