<?php

/**
 * ListaEmpaqueUnida filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseListaEmpaqueUnidaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id' => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'titulo'     => new sfWidgetFormFilterInput(),
      'usuario'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'titulo'     => new sfValidatorPass(array('required' => false)),
      'usuario'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lista_empaque_unida_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaEmpaqueUnida';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'empresa_id' => 'ForeignKey',
      'titulo'     => 'Text',
      'usuario'    => 'Text',
    );
  }
}
