<?php

/**
 * SolicitudDevDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseSolicitudDevDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'solicitud_devolucion_id' => new sfWidgetFormPropelChoice(array('model' => 'SolicitudDevolucion', 'add_empty' => true)),
      'hollander'               => new sfWidgetFormFilterInput(),
      'descripcion'             => new sfWidgetFormFilterInput(),
      'stock'                   => new sfWidgetFormFilterInput(),
      'tipo'                    => new sfWidgetFormFilterInput(),
      'tipo_respuesto'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'solicitud_devolucion_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SolicitudDevolucion', 'column' => 'id')),
      'hollander'               => new sfValidatorPass(array('required' => false)),
      'descripcion'             => new sfValidatorPass(array('required' => false)),
      'stock'                   => new sfValidatorPass(array('required' => false)),
      'tipo'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tipo_respuesto'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('solicitud_dev_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SolicitudDevDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'solicitud_devolucion_id' => 'ForeignKey',
      'hollander'               => 'Text',
      'descripcion'             => 'Text',
      'stock'                   => 'Text',
      'tipo'                    => 'Number',
      'tipo_respuesto'          => 'Text',
    );
  }
}
