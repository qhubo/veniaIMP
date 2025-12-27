<?php

/**
 * LibroAgrupado filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseLibroAgrupadoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id' => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'nombre'     => new sfWidgetFormFilterInput(),
      'tipo'       => new sfWidgetFormFilterInput(),
      'grupo'      => new sfWidgetFormFilterInput(),
      'orden'      => new sfWidgetFormFilterInput(),
      'abs'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'haber'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'empresa_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'nombre'     => new sfValidatorPass(array('required' => false)),
      'tipo'       => new sfValidatorPass(array('required' => false)),
      'grupo'      => new sfValidatorPass(array('required' => false)),
      'orden'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'abs'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'haber'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('libro_agrupado_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LibroAgrupado';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'empresa_id' => 'ForeignKey',
      'nombre'     => 'Text',
      'tipo'       => 'Text',
      'grupo'      => 'Text',
      'orden'      => 'Number',
      'abs'        => 'Boolean',
      'haber'      => 'Boolean',
    );
  }
}
