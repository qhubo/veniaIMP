<?php

/**
 * Banco filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseBancoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'          => new sfWidgetFormFilterInput(),
      'nombre'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cuenta'          => new sfWidgetFormFilterInput(),
      'tipo_banco'      => new sfWidgetFormFilterInput(),
      'observaciones'   => new sfWidgetFormFilterInput(),
      'activo'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'cuenta_contable' => new sfWidgetFormFilterInput(),
      'nombre_banco_id' => new sfWidgetFormPropelChoice(array('model' => 'NombreBanco', 'add_empty' => true)),
      'pago_cheque'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'dolares'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'empresa_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'codigo'          => new sfValidatorPass(array('required' => false)),
      'nombre'          => new sfValidatorPass(array('required' => false)),
      'cuenta'          => new sfValidatorPass(array('required' => false)),
      'tipo_banco'      => new sfValidatorPass(array('required' => false)),
      'observaciones'   => new sfValidatorPass(array('required' => false)),
      'activo'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'cuenta_contable' => new sfValidatorPass(array('required' => false)),
      'nombre_banco_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'NombreBanco', 'column' => 'id')),
      'pago_cheque'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'dolares'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('banco_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Banco';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'empresa_id'      => 'ForeignKey',
      'codigo'          => 'Text',
      'nombre'          => 'Text',
      'cuenta'          => 'Text',
      'tipo_banco'      => 'Text',
      'observaciones'   => 'Text',
      'activo'          => 'Boolean',
      'cuenta_contable' => 'Text',
      'nombre_banco_id' => 'ForeignKey',
      'pago_cheque'     => 'Boolean',
      'dolares'         => 'Boolean',
    );
  }
}
