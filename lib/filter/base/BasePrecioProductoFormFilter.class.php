<?php

/**
 * PrecioProducto filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BasePrecioProductoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id' => new sfWidgetFormPropelChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'fecha'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'tienda_id'  => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'empresa_id' => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tipo_no'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'usuario_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuario', 'column' => 'id')),
      'fecha'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'tienda_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'empresa_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'tipo_no'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('precio_producto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PrecioProducto';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'usuario_id' => 'ForeignKey',
      'fecha'      => 'Date',
      'tienda_id'  => 'ForeignKey',
      'empresa_id' => 'ForeignKey',
      'tipo_no'    => 'Text',
    );
  }
}
