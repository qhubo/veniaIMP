<?php

/**
 * Cliente filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseClienteFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'           => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'               => new sfWidgetFormFilterInput(),
      'nombre'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pequeno_contribuye'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'regimen_isr'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'direccion'            => new sfWidgetFormFilterInput(),
      'telefono'             => new sfWidgetFormFilterInput(),
      'correo_electronico'   => new sfWidgetFormFilterInput(),
      'observaciones'        => new sfWidgetFormFilterInput(),
      'nit'                  => new sfWidgetFormFilterInput(),
      'dias_credito'         => new sfWidgetFormFilterInput(),
      'tipo_referencia'      => new sfWidgetFormFilterInput(),
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
      'limite_credito'       => new sfWidgetFormFilterInput(),
      'pais_id'              => new sfWidgetFormPropelChoice(array('model' => 'Pais', 'add_empty' => true)),
      'nombre_facturar'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'codigo'               => new sfValidatorPass(array('required' => false)),
      'nombre'               => new sfValidatorPass(array('required' => false)),
      'pequeno_contribuye'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'regimen_isr'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'direccion'            => new sfValidatorPass(array('required' => false)),
      'telefono'             => new sfValidatorPass(array('required' => false)),
      'correo_electronico'   => new sfValidatorPass(array('required' => false)),
      'observaciones'        => new sfValidatorPass(array('required' => false)),
      'nit'                  => new sfValidatorPass(array('required' => false)),
      'dias_credito'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tipo_referencia'      => new sfValidatorPass(array('required' => false)),
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
      'limite_credito'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'pais_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Pais', 'column' => 'id')),
      'nombre_facturar'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cliente_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cliente';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'empresa_id'           => 'ForeignKey',
      'codigo'               => 'Text',
      'nombre'               => 'Text',
      'pequeno_contribuye'   => 'Boolean',
      'regimen_isr'          => 'Boolean',
      'direccion'            => 'Text',
      'telefono'             => 'Text',
      'correo_electronico'   => 'Text',
      'observaciones'        => 'Text',
      'nit'                  => 'Text',
      'dias_credito'         => 'Number',
      'tipo_referencia'      => 'Text',
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
      'limite_credito'       => 'Number',
      'pais_id'              => 'ForeignKey',
      'nombre_facturar'      => 'Text',
    );
  }
}
