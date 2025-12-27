<?php

/**
 * Proveedor filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseProveedorFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'           => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'               => new sfWidgetFormFilterInput(),
      'nombre'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'razon_social'         => new sfWidgetFormFilterInput(),
      'pequeno_contribuye'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'regimen_isr'          => new sfWidgetFormFilterInput(),
      'direccion'            => new sfWidgetFormFilterInput(),
      'sitio_web'            => new sfWidgetFormFilterInput(),
      'telefono'             => new sfWidgetFormFilterInput(),
      'correo_electronico'   => new sfWidgetFormFilterInput(),
      'observaciones'        => new sfWidgetFormFilterInput(),
      'nit'                  => new sfWidgetFormFilterInput(),
      'dias_credito'         => new sfWidgetFormFilterInput(),
      'tipo_proveedor'       => new sfWidgetFormFilterInput(),
      'activo'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'tiene_credito'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'avenida_calle'        => new sfWidgetFormFilterInput(),
      'zona'                 => new sfWidgetFormFilterInput(),
      'departamento_id'      => new sfWidgetFormPropelChoice(array('model' => 'Departamento', 'add_empty' => true)),
      'municipio_id'         => new sfWidgetFormPropelChoice(array('model' => 'Municipio', 'add_empty' => true)),
      'contacto'             => new sfWidgetFormFilterInput(),
      'correo_contacto'      => new sfWidgetFormFilterInput(),
      'imagen'               => new sfWidgetFormFilterInput(),
      'telefono_contacto'    => new sfWidgetFormFilterInput(),
      'tipificacion'         => new sfWidgetFormFilterInput(),
      'fecha'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'tipo_producto'        => new sfWidgetFormFilterInput(),
      'porcentaje_negociado' => new sfWidgetFormFilterInput(),
      'token_visa'           => new sfWidgetFormFilterInput(),
      'token_visa_test'      => new sfWidgetFormFilterInput(),
      'epay_terminal'        => new sfWidgetFormFilterInput(),
      'epay_merchant'        => new sfWidgetFormFilterInput(),
      'epay_user'            => new sfWidgetFormFilterInput(),
      'epay_key'             => new sfWidgetFormFilterInput(),
      'test_visa'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'merchand_id'          => new sfWidgetFormFilterInput(),
      'org_id'               => new sfWidgetFormFilterInput(),
      'numero_cliente_vol'   => new sfWidgetFormFilterInput(),
      'retiene_iva'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'retine_isr'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'exento_isr'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'cuenta_contable'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'codigo'               => new sfValidatorPass(array('required' => false)),
      'nombre'               => new sfValidatorPass(array('required' => false)),
      'razon_social'         => new sfValidatorPass(array('required' => false)),
      'pequeno_contribuye'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'regimen_isr'          => new sfValidatorPass(array('required' => false)),
      'direccion'            => new sfValidatorPass(array('required' => false)),
      'sitio_web'            => new sfValidatorPass(array('required' => false)),
      'telefono'             => new sfValidatorPass(array('required' => false)),
      'correo_electronico'   => new sfValidatorPass(array('required' => false)),
      'observaciones'        => new sfValidatorPass(array('required' => false)),
      'nit'                  => new sfValidatorPass(array('required' => false)),
      'dias_credito'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tipo_proveedor'       => new sfValidatorPass(array('required' => false)),
      'activo'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'tiene_credito'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'avenida_calle'        => new sfValidatorPass(array('required' => false)),
      'zona'                 => new sfValidatorPass(array('required' => false)),
      'departamento_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Departamento', 'column' => 'id')),
      'municipio_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Municipio', 'column' => 'id')),
      'contacto'             => new sfValidatorPass(array('required' => false)),
      'correo_contacto'      => new sfValidatorPass(array('required' => false)),
      'imagen'               => new sfValidatorPass(array('required' => false)),
      'telefono_contacto'    => new sfValidatorPass(array('required' => false)),
      'tipificacion'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'tipo_producto'        => new sfValidatorPass(array('required' => false)),
      'porcentaje_negociado' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'token_visa'           => new sfValidatorPass(array('required' => false)),
      'token_visa_test'      => new sfValidatorPass(array('required' => false)),
      'epay_terminal'        => new sfValidatorPass(array('required' => false)),
      'epay_merchant'        => new sfValidatorPass(array('required' => false)),
      'epay_user'            => new sfValidatorPass(array('required' => false)),
      'epay_key'             => new sfValidatorPass(array('required' => false)),
      'test_visa'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'merchand_id'          => new sfValidatorPass(array('required' => false)),
      'org_id'               => new sfValidatorPass(array('required' => false)),
      'numero_cliente_vol'   => new sfValidatorPass(array('required' => false)),
      'retiene_iva'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'retine_isr'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'exento_isr'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'cuenta_contable'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('proveedor_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Proveedor';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'empresa_id'           => 'ForeignKey',
      'codigo'               => 'Text',
      'nombre'               => 'Text',
      'razon_social'         => 'Text',
      'pequeno_contribuye'   => 'Boolean',
      'regimen_isr'          => 'Text',
      'direccion'            => 'Text',
      'sitio_web'            => 'Text',
      'telefono'             => 'Text',
      'correo_electronico'   => 'Text',
      'observaciones'        => 'Text',
      'nit'                  => 'Text',
      'dias_credito'         => 'Number',
      'tipo_proveedor'       => 'Text',
      'activo'               => 'Boolean',
      'tiene_credito'        => 'Boolean',
      'avenida_calle'        => 'Text',
      'zona'                 => 'Text',
      'departamento_id'      => 'ForeignKey',
      'municipio_id'         => 'ForeignKey',
      'contacto'             => 'Text',
      'correo_contacto'      => 'Text',
      'imagen'               => 'Text',
      'telefono_contacto'    => 'Text',
      'tipificacion'         => 'Number',
      'fecha'                => 'Date',
      'tipo_producto'        => 'Text',
      'porcentaje_negociado' => 'Number',
      'token_visa'           => 'Text',
      'token_visa_test'      => 'Text',
      'epay_terminal'        => 'Text',
      'epay_merchant'        => 'Text',
      'epay_user'            => 'Text',
      'epay_key'             => 'Text',
      'test_visa'            => 'Boolean',
      'merchand_id'          => 'Text',
      'org_id'               => 'Text',
      'numero_cliente_vol'   => 'Text',
      'retiene_iva'          => 'Boolean',
      'retine_isr'           => 'Boolean',
      'exento_isr'           => 'Boolean',
      'cuenta_contable'      => 'Text',
    );
  }
}
