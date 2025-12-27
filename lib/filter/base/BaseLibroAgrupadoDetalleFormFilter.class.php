<?php

/**
 * LibroAgrupadoDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseLibroAgrupadoDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'        => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'libro_agrupado_id' => new sfWidgetFormPropelChoice(array('model' => 'LibroAgrupado', 'add_empty' => true)),
      'cuenta_contable'   => new sfWidgetFormFilterInput(),
      'detalle'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'libro_agrupado_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'LibroAgrupado', 'column' => 'id')),
      'cuenta_contable'   => new sfValidatorPass(array('required' => false)),
      'detalle'           => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('libro_agrupado_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LibroAgrupadoDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'empresa_id'        => 'ForeignKey',
      'libro_agrupado_id' => 'ForeignKey',
      'cuenta_contable'   => 'Text',
      'detalle'           => 'Text',
    );
  }
}
