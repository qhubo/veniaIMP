<?php

/**
 * PrestamoDetalle form base class.
 *
 * @method PrestamoDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BasePrestamoDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'prestamo_id'         => new sfWidgetFormPropelChoice(array('model' => 'Prestamo', 'add_empty' => true)),
      'comentario'          => new sfWidgetFormInputText(),
      'fecha_inicio'        => new sfWidgetFormDate(),
      'fecha_fin'           => new sfWidgetFormDate(),
      'dias'                => new sfWidgetFormInputText(),
      'tasa_cambio'         => new sfWidgetFormInputText(),
      'valor_quetzales'     => new sfWidgetFormInputText(),
      'valor_dolares'       => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'created_by'          => new sfWidgetFormInputText(),
      'tipo'                => new sfWidgetFormInputText(),
      'valor'               => new sfWidgetFormInputText(),
      'banco_id'            => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'movimiento_banco_id' => new sfWidgetFormPropelChoice(array('model' => 'MovimientoBanco', 'add_empty' => true)),
      'partida_no'          => new sfWidgetFormInputText(),
      'detalle_interes'     => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'prestamo_id'         => new sfValidatorPropelChoice(array('model' => 'Prestamo', 'column' => 'id', 'required' => false)),
      'comentario'          => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'fecha_inicio'        => new sfValidatorDate(array('required' => false)),
      'fecha_fin'           => new sfValidatorDate(array('required' => false)),
      'dias'                => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'tasa_cambio'         => new sfValidatorNumber(array('required' => false)),
      'valor_quetzales'     => new sfValidatorNumber(array('required' => false)),
      'valor_dolares'       => new sfValidatorNumber(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'created_by'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'tipo'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'valor'               => new sfValidatorNumber(array('required' => false)),
      'banco_id'            => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id', 'required' => false)),
      'movimiento_banco_id' => new sfValidatorPropelChoice(array('model' => 'MovimientoBanco', 'column' => 'id', 'required' => false)),
      'partida_no'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'detalle_interes'     => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('prestamo_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PrestamoDetalle';
  }


}
