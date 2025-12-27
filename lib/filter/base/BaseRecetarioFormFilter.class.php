<?php

/**
 * Recetario filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseRecetarioFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'cliente_id'    => new sfWidgetFormPropelChoice(array('model' => 'Cliente', 'add_empty' => true)),
      'empresa_id'    => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'observaciones' => new sfWidgetFormFilterInput(),
      'usuario'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'fecha'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cliente_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Cliente', 'column' => 'id')),
      'empresa_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'observaciones' => new sfValidatorPass(array('required' => false)),
      'usuario'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('recetario_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Recetario';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'fecha'         => 'Date',
      'cliente_id'    => 'ForeignKey',
      'empresa_id'    => 'ForeignKey',
      'observaciones' => 'Text',
      'usuario'       => 'Text',
    );
  }
}
