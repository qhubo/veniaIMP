<?php

/**
 * CargaComprasSat form base class.
 *
 * @method CargaComprasSat getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseCargaComprasSatForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'fecha'        => new sfWidgetFormDate(),
      'validado'     => new sfWidgetFormInputCheckbox(),
      'tipo_dte'     => new sfWidgetFormInputText(),
      'serie'        => new sfWidgetFormInputText(),
      'no_dte'       => new sfWidgetFormInputText(),
      'emisor'       => new sfWidgetFormInputText(),
      'autorizacion' => new sfWidgetFormInputText(),
      'nit_emisor'   => new sfWidgetFormInputText(),
      'monto'        => new sfWidgetFormInputText(),
      'tipo'         => new sfWidgetFormInputText(),
      'codigo'       => new sfWidgetFormInputText(),
      'usuario'      => new sfWidgetFormInputText(),
      'updated_at'   => new sfWidgetFormDateTime(),
      'manual'       => new sfWidgetFormInputCheckbox(),
      'documento'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'fecha'        => new sfValidatorDate(array('required' => false)),
      'validado'     => new sfValidatorBoolean(array('required' => false)),
      'tipo_dte'     => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'serie'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'no_dte'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'emisor'       => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'autorizacion' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nit_emisor'   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'monto'        => new sfValidatorNumber(array('required' => false)),
      'tipo'         => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'codigo'       => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'usuario'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'updated_at'   => new sfValidatorDateTime(array('required' => false)),
      'manual'       => new sfValidatorBoolean(array('required' => false)),
      'documento'    => new sfValidatorString(array('max_length' => 150, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('carga_compras_sat[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CargaComprasSat';
  }


}
