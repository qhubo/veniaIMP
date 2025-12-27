<?php

/**
 * DefinicionCuenta filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseDefinicionCuentaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'grupo'           => new sfWidgetFormFilterInput(),
      'tipo'            => new sfWidgetFormFilterInput(),
      'cuenta_contable' => new sfWidgetFormFilterInput(),
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'detalle'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'grupo'           => new sfValidatorPass(array('required' => false)),
      'tipo'            => new sfValidatorPass(array('required' => false)),
      'cuenta_contable' => new sfValidatorPass(array('required' => false)),
      'empresa_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'detalle'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('definicion_cuenta_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DefinicionCuenta';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'grupo'           => 'Text',
      'tipo'            => 'Text',
      'cuenta_contable' => 'Text',
      'empresa_id'      => 'ForeignKey',
      'detalle'         => 'Text',
    );
  }
}
