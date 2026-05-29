<?php

/**
 * ListaEmpaqueUnidaDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseListaEmpaqueUnidaDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'             => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'lista_empaque_unida_id' => new sfWidgetFormPropelChoice(array('model' => 'ListaEmpaqueUnida', 'add_empty' => true)),
      'codigo'                 => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'lista_empaque_unida_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'ListaEmpaqueUnida', 'column' => 'id')),
      'codigo'                 => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lista_empaque_unida_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaEmpaqueUnidaDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'empresa_id'             => 'ForeignKey',
      'lista_empaque_unida_id' => 'ForeignKey',
      'codigo'                 => 'Text',
    );
  }
}
