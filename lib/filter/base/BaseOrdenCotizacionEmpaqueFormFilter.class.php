<?php

/**
 * OrdenCotizacionEmpaque filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseOrdenCotizacionEmpaqueFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'orden_cotizacion_id' => new sfWidgetFormPropelChoice(array('model' => 'OrdenCotizacion', 'add_empty' => true)),
      'orden_empaque'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'orden_cotizacion_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'OrdenCotizacion', 'column' => 'id')),
      'orden_empaque'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('orden_cotizacion_empaque_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenCotizacionEmpaque';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'orden_cotizacion_id' => 'ForeignKey',
      'orden_empaque'       => 'Number',
    );
  }
}
