<?php

/**
 * PartidaDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BasePartidaDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'partida_id'      => new sfWidgetFormPropelChoice(array('model' => 'Partida', 'add_empty' => true)),
      'detalle'         => new sfWidgetFormFilterInput(),
      'cuenta_contable' => new sfWidgetFormFilterInput(),
      'debe'            => new sfWidgetFormFilterInput(),
      'haber'           => new sfWidgetFormFilterInput(),
      'tipo'            => new sfWidgetFormFilterInput(),
      'grupo'           => new sfWidgetFormFilterInput(),
      'adicional'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'partida_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Partida', 'column' => 'id')),
      'detalle'         => new sfValidatorPass(array('required' => false)),
      'cuenta_contable' => new sfValidatorPass(array('required' => false)),
      'debe'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'haber'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'tipo'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'grupo'           => new sfValidatorPass(array('required' => false)),
      'adicional'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('partida_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PartidaDetalle';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'empresa_id'      => 'ForeignKey',
      'partida_id'      => 'ForeignKey',
      'detalle'         => 'Text',
      'cuenta_contable' => 'Text',
      'debe'            => 'Number',
      'haber'           => 'Number',
      'tipo'            => 'Number',
      'grupo'           => 'Text',
      'adicional'       => 'Text',
    );
  }
}
