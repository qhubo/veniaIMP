<?php

/**
 * PartidaAgrupa filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BasePartidaAgrupaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'         => new sfWidgetFormFilterInput(),
      'fecha_contable' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'detalle'        => new sfWidgetFormFilterInput(),
      'empresa_id'     => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'revisado'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ano'            => new sfWidgetFormFilterInput(),
      'mes'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'codigo'         => new sfValidatorPass(array('required' => false)),
      'fecha_contable' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'detalle'        => new sfValidatorPass(array('required' => false)),
      'empresa_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'revisado'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ano'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mes'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('partida_agrupa_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PartidaAgrupa';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'codigo'         => 'Text',
      'fecha_contable' => 'Date',
      'detalle'        => 'Text',
      'empresa_id'     => 'ForeignKey',
      'revisado'       => 'Boolean',
      'ano'            => 'Number',
      'mes'            => 'Number',
    );
  }
}
