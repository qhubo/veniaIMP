<?php

/**
 * CierreCheck form base class.
 *
 * @method CierreCheck getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseCierreCheckForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'check_lista_id' => new sfWidgetFormPropelChoice(array('model' => 'CheckLista', 'add_empty' => true)),
      'cierre_caja_id' => new sfWidgetFormPropelChoice(array('model' => 'CierreCaja', 'add_empty' => true)),
      'cierre_dia_id'  => new sfWidgetFormPropelChoice(array('model' => 'Cierre', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'check_lista_id' => new sfValidatorPropelChoice(array('model' => 'CheckLista', 'column' => 'id', 'required' => false)),
      'cierre_caja_id' => new sfValidatorPropelChoice(array('model' => 'CierreCaja', 'column' => 'id', 'required' => false)),
      'cierre_dia_id'  => new sfValidatorPropelChoice(array('model' => 'Cierre', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cierre_check[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CierreCheck';
  }


}
