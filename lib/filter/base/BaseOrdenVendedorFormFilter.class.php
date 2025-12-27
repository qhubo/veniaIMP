<?php

/**
 * OrdenVendedor filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseOrdenVendedorFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'observaciones' => new sfWidgetFormFilterInput(),
      'estado'        => new sfWidgetFormFilterInput(),
      'fecha'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'usuario'       => new sfWidgetFormFilterInput(),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'vendedor_id'   => new sfWidgetFormPropelChoice(array('model' => 'Vendedor', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'observaciones' => new sfValidatorPass(array('required' => false)),
      'estado'        => new sfValidatorPass(array('required' => false)),
      'fecha'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'usuario'       => new sfValidatorPass(array('required' => false)),
      'empresa_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'vendedor_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Vendedor', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('orden_vendedor_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenVendedor';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'observaciones' => 'Text',
      'estado'        => 'Text',
      'fecha'         => 'Date',
      'usuario'       => 'Text',
      'empresa_id'    => 'ForeignKey',
      'vendedor_id'   => 'ForeignKey',
    );
  }
}
