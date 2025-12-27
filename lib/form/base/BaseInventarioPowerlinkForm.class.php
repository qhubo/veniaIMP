<?php

/**
 * InventarioPowerlink form base class.
 *
 * @method InventarioPowerlink getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseInventarioPowerlinkForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'categorizing_store_number' => new sfWidgetFormInputText(),
      'dat'                       => new sfWidgetFormTextarea(),
      'last_date_modified'        => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'categorizing_store_number' => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'dat'                       => new sfValidatorString(array('required' => false)),
      'last_date_modified'        => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('inventario_powerlink[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'InventarioPowerlink';
  }


}
