<?php

/**
 * TrasladoUbicacion filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseTrasladoUbicacionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tienda_id'     => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'observaciones' => new sfWidgetFormFilterInput(),
      'usuario'       => new sfWidgetFormFilterInput(),
      'fecha'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'estado'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'tienda_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'observaciones' => new sfValidatorPass(array('required' => false)),
      'usuario'       => new sfValidatorPass(array('required' => false)),
      'fecha'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'estado'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('traslado_ubicacion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TrasladoUbicacion';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'empresa_id'    => 'ForeignKey',
      'tienda_id'     => 'ForeignKey',
      'observaciones' => 'Text',
      'usuario'       => 'Text',
      'fecha'         => 'Date',
      'estado'        => 'Text',
    );
  }
}
