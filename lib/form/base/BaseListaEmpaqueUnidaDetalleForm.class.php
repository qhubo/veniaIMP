<?php

/**
 * ListaEmpaqueUnidaDetalle form base class.
 *
 * @method ListaEmpaqueUnidaDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseListaEmpaqueUnidaDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'empresa_id'             => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'lista_empaque_unida_id' => new sfWidgetFormPropelChoice(array('model' => 'ListaEmpaqueUnida', 'add_empty' => true)),
      'codigo'                 => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'             => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'lista_empaque_unida_id' => new sfValidatorPropelChoice(array('model' => 'ListaEmpaqueUnida', 'column' => 'id', 'required' => false)),
      'codigo'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lista_empaque_unida_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaEmpaqueUnidaDetalle';
  }


}
