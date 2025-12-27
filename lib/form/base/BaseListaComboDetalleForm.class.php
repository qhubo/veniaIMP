<?php

/**
 * ListaComboDetalle form base class.
 *
 * @method ListaComboDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseListaComboDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'combo_producto_detalle_id' => new sfWidgetFormPropelChoice(array('model' => 'ComboProductoDetalle', 'add_empty' => true)),
      'producto_id'               => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'empresa_id'                => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'precio'                    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'combo_producto_detalle_id' => new sfValidatorPropelChoice(array('model' => 'ComboProductoDetalle', 'column' => 'id', 'required' => false)),
      'producto_id'               => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'empresa_id'                => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'precio'                    => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lista_combo_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaComboDetalle';
  }


}
