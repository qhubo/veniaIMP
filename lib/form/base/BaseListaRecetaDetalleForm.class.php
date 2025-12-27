<?php

/**
 * ListaRecetaDetalle form base class.
 *
 * @method ListaRecetaDetalle getObject() Returns the current form's model object
 *
 * @package    plan
 * @subpackage form
 * @author     Via
 */
abstract class BaseListaRecetaDetalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'receta_producto_detalle_id' => new sfWidgetFormPropelChoice(array('model' => 'RecetaProductoDetalle', 'add_empty' => true)),
      'producto_id'                => new sfWidgetFormPropelChoice(array('model' => 'Producto', 'add_empty' => true)),
      'empresa_id'                 => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'precio'                     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'receta_producto_detalle_id' => new sfValidatorPropelChoice(array('model' => 'RecetaProductoDetalle', 'column' => 'id', 'required' => false)),
      'producto_id'                => new sfValidatorPropelChoice(array('model' => 'Producto', 'column' => 'id', 'required' => false)),
      'empresa_id'                 => new sfValidatorPropelChoice(array('model' => 'Empresa', 'column' => 'id', 'required' => false)),
      'precio'                     => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lista_receta_detalle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaRecetaDetalle';
  }


}
