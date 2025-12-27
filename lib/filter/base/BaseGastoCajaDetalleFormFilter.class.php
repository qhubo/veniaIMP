<?php

/**
 * GastoCajaDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseGastoCajaDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'gasto_caja_id'     => new sfWidgetFormPropelChoice(array('model' => 'GastoCaja', 'add_empty' => true)),
      'serie'             => new sfWidgetFormFilterInput(),
      'factura'           => new sfWidgetFormFilterInput(),
      'fecha'             => new sfWidgetFormFilterInput(),
      'descripcion'       => new sfWidgetFormFilterInput(),
      'proveedor_id'      => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'cuenta'            => new sfWidgetFormFilterInput(),
      'valor'             => new sfWidgetFormFilterInput(),
      'iva'               => new sfWidgetFormFilterInput(),
      'valor_isr'         => new sfWidgetFormFilterInput(),
      'valor_retiene_iva' => new sfWidgetFormFilterInput(),
      'confrontado_sat'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'no_sat'            => new sfWidgetFormFilterInput(),
      'valor_idp'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'gasto_caja_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'GastoCaja', 'column' => 'id')),
      'serie'             => new sfValidatorPass(array('required' => false)),
      'factura'           => new sfValidatorPass(array('required' => false)),
      'fecha'             => new sfValidatorPass(array('required' => false)),
      'descripcion'       => new sfValidatorPass(array('required' => false)),
      'proveedor_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'cuenta'            => new sfValidatorPass(array('required' => false)),
      'valor'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'iva'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_isr'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'valor_retiene_iva' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'confrontado_sat'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'no_sat'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'valor_idp'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('gasto_caja_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'GastoCajaDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'gasto_caja_id'     => 'ForeignKey',
      'serie'             => 'Text',
      'factura'           => 'Text',
      'fecha'             => 'Text',
      'descripcion'       => 'Text',
      'proveedor_id'      => 'ForeignKey',
      'cuenta'            => 'Text',
      'valor'             => 'Number',
      'iva'               => 'Number',
      'valor_isr'         => 'Number',
      'valor_retiene_iva' => 'Number',
      'confrontado_sat'   => 'Boolean',
      'no_sat'            => 'Number',
      'valor_idp'         => 'Number',
    );
  }
}
