<?php

/**
 * IngresoProducto filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseIngresoProductoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id'       => new sfWidgetFormPropelChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'fecha'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'tienda_id'        => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'fecha_documento'  => new sfWidgetFormFilterInput(),
      'observaciones'    => new sfWidgetFormFilterInput(),
      'numero_documento' => new sfWidgetFormFilterInput(),
      'numero_orden'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'usuario_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuario', 'column' => 'id')),
      'fecha'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'tienda_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'empresa_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'fecha_documento'  => new sfValidatorPass(array('required' => false)),
      'observaciones'    => new sfValidatorPass(array('required' => false)),
      'numero_documento' => new sfValidatorPass(array('required' => false)),
      'numero_orden'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ingreso_producto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'IngresoProducto';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'usuario_id'       => 'ForeignKey',
      'fecha'            => 'Date',
      'tienda_id'        => 'ForeignKey',
      'empresa_id'       => 'ForeignKey',
      'fecha_documento'  => 'Text',
      'observaciones'    => 'Text',
      'numero_documento' => 'Text',
      'numero_orden'     => 'Text',
    );
  }
}
