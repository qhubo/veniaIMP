<?php

/**
 * TipoTransporte filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseTipoTransporteFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'  => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'      => new sfWidgetFormFilterInput(),
      'nombre'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'activo'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'descripcion' => new sfWidgetFormFilterInput(),
      'telefono'    => new sfWidgetFormFilterInput(),
      'clave'       => new sfWidgetFormFilterInput(),
      'clave_2'     => new sfWidgetFormFilterInput(),
      'direccion'   => new sfWidgetFormFilterInput(),
      'correo'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'codigo'      => new sfValidatorPass(array('required' => false)),
      'nombre'      => new sfValidatorPass(array('required' => false)),
      'activo'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'descripcion' => new sfValidatorPass(array('required' => false)),
      'telefono'    => new sfValidatorPass(array('required' => false)),
      'clave'       => new sfValidatorPass(array('required' => false)),
      'clave_2'     => new sfValidatorPass(array('required' => false)),
      'direccion'   => new sfValidatorPass(array('required' => false)),
      'correo'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tipo_transporte_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TipoTransporte';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'empresa_id'  => 'ForeignKey',
      'codigo'      => 'Text',
      'nombre'      => 'Text',
      'activo'      => 'Boolean',
      'descripcion' => 'Text',
      'telefono'    => 'Text',
      'clave'       => 'Text',
      'clave_2'     => 'Text',
      'direccion'   => 'Text',
      'correo'      => 'Text',
    );
  }
}
