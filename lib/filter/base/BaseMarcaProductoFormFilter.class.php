<?php

/**
 * MarcaProducto filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseMarcaProductoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id' => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'     => new sfWidgetFormFilterInput(),
      'nombre'     => new sfWidgetFormFilterInput(),
      'activo'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'empresa_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'codigo'     => new sfValidatorPass(array('required' => false)),
      'nombre'     => new sfValidatorPass(array('required' => false)),
      'activo'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('marca_producto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MarcaProducto';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'empresa_id' => 'ForeignKey',
      'codigo'     => 'Text',
      'nombre'     => 'Text',
      'activo'     => 'Boolean',
    );
  }
}
