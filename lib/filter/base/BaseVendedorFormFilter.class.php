<?php

/**
 * Vendedor filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseVendedorFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'              => new sfWidgetFormFilterInput(),
      'nombre'              => new sfWidgetFormFilterInput(),
      'activo'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'empresa_id'          => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'porcentaje_comision' => new sfWidgetFormFilterInput(),
      'tienda_comision'     => new sfWidgetFormFilterInput(),
      'encargado_tienda'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'codigo_planilla'     => new sfWidgetFormFilterInput(),
      'observaciones'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'codigo'              => new sfValidatorPass(array('required' => false)),
      'nombre'              => new sfValidatorPass(array('required' => false)),
      'activo'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'empresa_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'porcentaje_comision' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'tienda_comision'     => new sfValidatorPass(array('required' => false)),
      'encargado_tienda'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'codigo_planilla'     => new sfValidatorPass(array('required' => false)),
      'observaciones'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('vendedor_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Vendedor';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'codigo'              => 'Text',
      'nombre'              => 'Text',
      'activo'              => 'Boolean',
      'empresa_id'          => 'ForeignKey',
      'porcentaje_comision' => 'Number',
      'tienda_comision'     => 'Text',
      'encargado_tienda'    => 'Boolean',
      'codigo_planilla'     => 'Text',
      'observaciones'       => 'Text',
    );
  }
}
