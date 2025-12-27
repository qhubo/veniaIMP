<?php

/**
 * DocumentoCheque filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseDocumentoChequeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'banco_id'         => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'titulo'           => new sfWidgetFormFilterInput(),
      'tipo_negociable'  => new sfWidgetFormFilterInput(),
      'formato'          => new sfWidgetFormFilterInput(),
      'activo'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'margen_superior'  => new sfWidgetFormFilterInput(),
      'margen_izquierdo' => new sfWidgetFormFilterInput(),
      'ancho'            => new sfWidgetFormFilterInput(),
      'alto'             => new sfWidgetFormFilterInput(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'correlativo'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'banco_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
      'titulo'           => new sfValidatorPass(array('required' => false)),
      'tipo_negociable'  => new sfValidatorPass(array('required' => false)),
      'formato'          => new sfValidatorPass(array('required' => false)),
      'activo'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'margen_superior'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'margen_izquierdo' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ancho'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'alto'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'empresa_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'correlativo'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('documento_cheque_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocumentoCheque';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'banco_id'         => 'ForeignKey',
      'titulo'           => 'Text',
      'tipo_negociable'  => 'Text',
      'formato'          => 'Text',
      'activo'           => 'Boolean',
      'margen_superior'  => 'Number',
      'margen_izquierdo' => 'Number',
      'ancho'            => 'Number',
      'alto'             => 'Number',
      'empresa_id'       => 'ForeignKey',
      'correlativo'      => 'Number',
    );
  }
}
