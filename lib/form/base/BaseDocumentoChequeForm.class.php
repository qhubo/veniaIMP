<?php

/**
 * DocumentoCheque form base class.
 *
 * @method DocumentoCheque getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseDocumentoChequeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'banco_id'         => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'titulo'           => new sfWidgetFormInputText(),
      'tipo_negociable'  => new sfWidgetFormInputText(),
      'formato'          => new sfWidgetFormTextarea(),
      'activo'           => new sfWidgetFormInputCheckbox(),
      'margen_superior'  => new sfWidgetFormInputText(),
      'margen_izquierdo' => new sfWidgetFormInputText(),
      'ancho'            => new sfWidgetFormInputText(),
      'alto'             => new sfWidgetFormInputText(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'correlativo'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'banco_id'         => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
      'titulo'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'tipo_negociable'  => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'formato'          => new sfValidatorString(array('required' => false)),
      'activo'           => new sfValidatorBoolean(array('required' => false)),
      'margen_superior'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'margen_izquierdo' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'ancho'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'alto'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'correlativo'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('documento_cheque[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocumentoCheque';
  }


}
