<?php

/**
 * CambioVendedor filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseCambioVendedorFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo_opera'         => new sfWidgetFormFilterInput(),
      'vendedor_anterior'    => new sfWidgetFormFilterInput(),
      'vendedor_actualizado' => new sfWidgetFormFilterInput(),
      'usuario'              => new sfWidgetFormFilterInput(),
      'fecha'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'codigo_opera'         => new sfValidatorPass(array('required' => false)),
      'vendedor_anterior'    => new sfValidatorPass(array('required' => false)),
      'vendedor_actualizado' => new sfValidatorPass(array('required' => false)),
      'usuario'              => new sfValidatorPass(array('required' => false)),
      'fecha'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('cambio_vendedor_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CambioVendedor';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'codigo_opera'         => 'Text',
      'vendedor_anterior'    => 'Text',
      'vendedor_actualizado' => 'Text',
      'usuario'              => 'Text',
      'fecha'                => 'Date',
    );
  }
}
