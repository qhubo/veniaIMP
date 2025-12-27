<?php

/**
 * Tienda filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseTiendaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'             => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'                 => new sfWidgetFormFilterInput(),
      'nombre'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'codigo_establecimiento' => new sfWidgetFormFilterInput(),
      'direccion'              => new sfWidgetFormFilterInput(),
      'departamento_id'        => new sfWidgetFormPropelChoice(array('model' => 'Departamento', 'add_empty' => true)),
      'municipio_id'           => new sfWidgetFormPropelChoice(array('model' => 'Municipio', 'add_empty' => true)),
      'observaciones'          => new sfWidgetFormFilterInput(),
      'correo'                 => new sfWidgetFormFilterInput(),
      'telefono'               => new sfWidgetFormFilterInput(),
      'nombre_comercial'       => new sfWidgetFormFilterInput(),
      'activo'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'cuenta_debe'            => new sfWidgetFormFilterInput(),
      'cuenta_haber'           => new sfWidgetFormFilterInput(),
      'created_by'             => new sfWidgetFormFilterInput(),
      'updated_by'             => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'tipo'                   => new sfWidgetFormFilterInput(),
      'nit'                    => new sfWidgetFormFilterInput(),
      'feel_usuario'           => new sfWidgetFormFilterInput(),
      'feel_token'             => new sfWidgetFormFilterInput(),
      'feel_llave'             => new sfWidgetFormFilterInput(),
      'activa_buscador'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'empresa_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'codigo'                 => new sfValidatorPass(array('required' => false)),
      'nombre'                 => new sfValidatorPass(array('required' => false)),
      'codigo_establecimiento' => new sfValidatorPass(array('required' => false)),
      'direccion'              => new sfValidatorPass(array('required' => false)),
      'departamento_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Departamento', 'column' => 'id')),
      'municipio_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Municipio', 'column' => 'id')),
      'observaciones'          => new sfValidatorPass(array('required' => false)),
      'correo'                 => new sfValidatorPass(array('required' => false)),
      'telefono'               => new sfValidatorPass(array('required' => false)),
      'nombre_comercial'       => new sfValidatorPass(array('required' => false)),
      'activo'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'cuenta_debe'            => new sfValidatorPass(array('required' => false)),
      'cuenta_haber'           => new sfValidatorPass(array('required' => false)),
      'created_by'             => new sfValidatorPass(array('required' => false)),
      'updated_by'             => new sfValidatorPass(array('required' => false)),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'tipo'                   => new sfValidatorPass(array('required' => false)),
      'nit'                    => new sfValidatorPass(array('required' => false)),
      'feel_usuario'           => new sfValidatorPass(array('required' => false)),
      'feel_token'             => new sfValidatorPass(array('required' => false)),
      'feel_llave'             => new sfValidatorPass(array('required' => false)),
      'activa_buscador'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('tienda_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tienda';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'empresa_id'             => 'ForeignKey',
      'codigo'                 => 'Text',
      'nombre'                 => 'Text',
      'codigo_establecimiento' => 'Text',
      'direccion'              => 'Text',
      'departamento_id'        => 'ForeignKey',
      'municipio_id'           => 'ForeignKey',
      'observaciones'          => 'Text',
      'correo'                 => 'Text',
      'telefono'               => 'Text',
      'nombre_comercial'       => 'Text',
      'activo'                 => 'Boolean',
      'cuenta_debe'            => 'Text',
      'cuenta_haber'           => 'Text',
      'created_by'             => 'Text',
      'updated_by'             => 'Text',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'tipo'                   => 'Text',
      'nit'                    => 'Text',
      'feel_usuario'           => 'Text',
      'feel_token'             => 'Text',
      'feel_llave'             => 'Text',
      'activa_buscador'        => 'Boolean',
    );
  }
}
