<?php

/**
 * OrdenCotizacionEmpaque form base class.
 *
 * @method OrdenCotizacionEmpaque getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseOrdenCotizacionEmpaqueForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'orden_cotizacion_id' => new sfWidgetFormPropelChoice(array('model' => 'OrdenCotizacion', 'add_empty' => true)),
      'orden_empaque'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'orden_cotizacion_id' => new sfValidatorPropelChoice(array('model' => 'OrdenCotizacion', 'column' => 'id', 'required' => false)),
      'orden_empaque'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('orden_cotizacion_empaque[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenCotizacionEmpaque';
  }


}
