<?php

/**
 * UsuarioCorteValor filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseUsuarioCorteValorFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id' => new sfWidgetFormPropelChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'banco_id'   => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'documento'  => new sfWidgetFormFilterInput(),
      'medio_pago' => new sfWidgetFormFilterInput(),
      'valor'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'usuario_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuario', 'column' => 'id')),
      'banco_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
      'documento'  => new sfValidatorPass(array('required' => false)),
      'medio_pago' => new sfValidatorPass(array('required' => false)),
      'valor'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('usuario_corte_valor_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioCorteValor';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'usuario_id' => 'ForeignKey',
      'banco_id'   => 'ForeignKey',
      'documento'  => 'Text',
      'medio_pago' => 'Text',
      'valor'      => 'Number',
    );
  }
}
