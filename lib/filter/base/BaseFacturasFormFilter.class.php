<?php

/**
 * Facturas filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseFacturasFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tienda'         => new sfWidgetFormFilterInput(),
      'referencia'     => new sfWidgetFormFilterInput(),
      'fecha'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'tipo_documento' => new sfWidgetFormFilterInput(),
      'firma'          => new sfWidgetFormFilterInput(),
      'motivo'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'tienda'         => new sfValidatorPass(array('required' => false)),
      'referencia'     => new sfValidatorPass(array('required' => false)),
      'fecha'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'tipo_documento' => new sfValidatorPass(array('required' => false)),
      'firma'          => new sfValidatorPass(array('required' => false)),
      'motivo'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('facturas_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Facturas';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'tienda'         => 'Text',
      'referencia'     => 'Text',
      'fecha'          => 'Date',
      'tipo_documento' => 'Text',
      'firma'          => 'Text',
      'motivo'         => 'Text',
    );
  }
}
