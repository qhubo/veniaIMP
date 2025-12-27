<?php

/**
 * FormularioDatos filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseFormularioDatosFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'establecimiento' => new sfWidgetFormFilterInput(),
      'tipo'            => new sfWidgetFormFilterInput(),
      'propietario'     => new sfWidgetFormFilterInput(),
      'telefono'        => new sfWidgetFormFilterInput(),
      'email'           => new sfWidgetFormFilterInput(),
      'region_id'       => new sfWidgetFormPropelChoice(array('model' => 'Region', 'add_empty' => true)),
      'departamento_id' => new sfWidgetFormPropelChoice(array('model' => 'Departamento', 'add_empty' => true)),
      'municipio_id'    => new sfWidgetFormPropelChoice(array('model' => 'Municipio', 'add_empty' => true)),
      'direccion'       => new sfWidgetFormFilterInput(),
      'nit'             => new sfWidgetFormFilterInput(),
      'contacto'        => new sfWidgetFormFilterInput(),
      'whtas_app'       => new sfWidgetFormFilterInput(),
      'observaciones'   => new sfWidgetFormFilterInput(),
      'fecha_visita'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'usuario'         => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'      => new sfWidgetFormFilterInput(),
      'updated_by'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'establecimiento' => new sfValidatorPass(array('required' => false)),
      'tipo'            => new sfValidatorPass(array('required' => false)),
      'propietario'     => new sfValidatorPass(array('required' => false)),
      'telefono'        => new sfValidatorPass(array('required' => false)),
      'email'           => new sfValidatorPass(array('required' => false)),
      'region_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Region', 'column' => 'id')),
      'departamento_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Departamento', 'column' => 'id')),
      'municipio_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Municipio', 'column' => 'id')),
      'direccion'       => new sfValidatorPass(array('required' => false)),
      'nit'             => new sfValidatorPass(array('required' => false)),
      'contacto'        => new sfValidatorPass(array('required' => false)),
      'whtas_app'       => new sfValidatorPass(array('required' => false)),
      'observaciones'   => new sfValidatorPass(array('required' => false)),
      'fecha_visita'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'usuario'         => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'      => new sfValidatorPass(array('required' => false)),
      'updated_by'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('formulario_datos_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'FormularioDatos';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'establecimiento' => 'Text',
      'tipo'            => 'Text',
      'propietario'     => 'Text',
      'telefono'        => 'Text',
      'email'           => 'Text',
      'region_id'       => 'ForeignKey',
      'departamento_id' => 'ForeignKey',
      'municipio_id'    => 'ForeignKey',
      'direccion'       => 'Text',
      'nit'             => 'Text',
      'contacto'        => 'Text',
      'whtas_app'       => 'Text',
      'observaciones'   => 'Text',
      'fecha_visita'    => 'Date',
      'usuario'         => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'created_by'      => 'Text',
      'updated_by'      => 'Text',
    );
  }
}
