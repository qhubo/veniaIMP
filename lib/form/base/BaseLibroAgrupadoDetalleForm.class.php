<?php

/**
 * LibroAgrupadoDetalle form base class.
 *
 * @method LibroAgrupadoDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseLibroAgrupadoDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'empresa_id'        => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'libro_agrupado_id' => new sfWidgetFormPropelChoice(array('model' => 'LibroAgrupado', 'add_empty' => true)),
      'cuenta_contable'   => new sfWidgetFormInputText(),
      'detalle'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'empresa_id'        => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'libro_agrupado_id' => new sfValidatorPropelChoice(array('model' => 'LibroAgrupado', 'column' => 'id', 'required' => false)),
      'cuenta_contable'   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'detalle'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('libro_agrupado_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LibroAgrupadoDetalle';
  }


}
