<?php

/**
 * PartidaAgrupaLinea filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BasePartidaAgrupaLineaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'detalle'           => new sfWidgetFormFilterInput(),
      'cuenta_contable'   => new sfWidgetFormFilterInput(),
      'debe'              => new sfWidgetFormFilterInput(),
      'haber'             => new sfWidgetFormFilterInput(),
      'empresa_id'        => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'partida_agrupa_id' => new sfWidgetFormPropelChoice(array('model' => 'PartidaAgrupa', 'add_empty' => true)),
      'cantidad'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'detalle'           => new sfValidatorPass(array('required' => false)),
      'cuenta_contable'   => new sfValidatorPass(array('required' => false)),
      'debe'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'haber'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'empresa_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'partida_agrupa_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PartidaAgrupa', 'column' => 'id')),
      'cantidad'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('partida_agrupa_linea_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PartidaAgrupaLinea';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'detalle'           => 'Text',
      'cuenta_contable'   => 'Text',
      'debe'              => 'Number',
      'haber'             => 'Number',
      'empresa_id'        => 'ForeignKey',
      'partida_agrupa_id' => 'ForeignKey',
      'cantidad'          => 'Number',
    );
  }
}
