<?php

/**
 * BitacoraCambio filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseBitacoraCambioFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tipo'           => new sfWidgetFormFilterInput(),
      'observaciones'  => new sfWidgetFormFilterInput(),
      'fecha'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'usuario'        => new sfWidgetFormFilterInput(),
      'revisado'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'usuario_reviso' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'tipo'           => new sfValidatorPass(array('required' => false)),
      'observaciones'  => new sfValidatorPass(array('required' => false)),
      'fecha'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'usuario'        => new sfValidatorPass(array('required' => false)),
      'revisado'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'usuario_reviso' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('bitacora_cambio_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BitacoraCambio';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'tipo'           => 'Text',
      'observaciones'  => 'Text',
      'fecha'          => 'Date',
      'usuario'        => 'Text',
      'revisado'       => 'Boolean',
      'usuario_reviso' => 'Text',
    );
  }
}
