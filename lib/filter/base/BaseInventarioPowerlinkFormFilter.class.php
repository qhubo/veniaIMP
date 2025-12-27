<?php

/**
 * InventarioPowerlink filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseInventarioPowerlinkFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'categorizing_store_number' => new sfWidgetFormFilterInput(),
      'dat'                       => new sfWidgetFormFilterInput(),
      'last_date_modified'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'categorizing_store_number' => new sfValidatorPass(array('required' => false)),
      'dat'                       => new sfValidatorPass(array('required' => false)),
      'last_date_modified'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('inventario_powerlink_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'InventarioPowerlink';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'categorizing_store_number' => 'Text',
      'dat'                       => 'Text',
      'last_date_modified'        => 'Date',
    );
  }
}
