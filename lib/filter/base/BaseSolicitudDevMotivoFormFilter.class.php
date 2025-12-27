<?php

/**
 * SolicitudDevMotivo filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseSolicitudDevMotivoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'solicitud_devolucion_id' => new sfWidgetFormPropelChoice(array('model' => 'SolicitudDevolucion', 'add_empty' => true)),
      'motivo'                  => new sfWidgetFormFilterInput(),
      'empresa_id'              => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'solicitud_devolucion_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SolicitudDevolucion', 'column' => 'id')),
      'motivo'                  => new sfValidatorPass(array('required' => false)),
      'empresa_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('solicitud_dev_motivo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SolicitudDevMotivo';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'solicitud_devolucion_id' => 'ForeignKey',
      'motivo'                  => 'Text',
      'empresa_id'              => 'ForeignKey',
    );
  }
}
