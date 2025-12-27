<?php

/**
 * Usuario filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseUsuarioFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nombre_completo' => new sfWidgetFormFilterInput(),
      'tipo_usuario'    => new sfWidgetFormFilterInput(),
      'clave'           => new sfWidgetFormFilterInput(),
      'correo'          => new sfWidgetFormFilterInput(),
      'estado'          => new sfWidgetFormFilterInput(),
      'imagen'          => new sfWidgetFormFilterInput(),
      'administrador'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ultimo_ingreso'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'token'           => new sfWidgetFormFilterInput(),
      'activo'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'validado'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'nivel_usuario'   => new sfWidgetFormFilterInput(),
      'ip'              => new sfWidgetFormFilterInput(),
      'tienda_id'       => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'vendedor_id'     => new sfWidgetFormPropelChoice(array('model' => 'Vendedor', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'usuario'         => new sfValidatorPass(array('required' => false)),
      'nombre_completo' => new sfValidatorPass(array('required' => false)),
      'tipo_usuario'    => new sfValidatorPass(array('required' => false)),
      'clave'           => new sfValidatorPass(array('required' => false)),
      'correo'          => new sfValidatorPass(array('required' => false)),
      'estado'          => new sfValidatorPass(array('required' => false)),
      'imagen'          => new sfValidatorPass(array('required' => false)),
      'administrador'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ultimo_ingreso'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'token'           => new sfValidatorPass(array('required' => false)),
      'activo'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'validado'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'nivel_usuario'   => new sfValidatorPass(array('required' => false)),
      'ip'              => new sfValidatorPass(array('required' => false)),
      'tienda_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
      'empresa_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'vendedor_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Vendedor', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('usuario_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Usuario';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'usuario'         => 'Text',
      'nombre_completo' => 'Text',
      'tipo_usuario'    => 'Text',
      'clave'           => 'Text',
      'correo'          => 'Text',
      'estado'          => 'Text',
      'imagen'          => 'Text',
      'administrador'   => 'Boolean',
      'ultimo_ingreso'  => 'Date',
      'token'           => 'Text',
      'activo'          => 'Boolean',
      'validado'        => 'Boolean',
      'nivel_usuario'   => 'Text',
      'ip'              => 'Text',
      'tienda_id'       => 'ForeignKey',
      'empresa_id'      => 'ForeignKey',
      'vendedor_id'     => 'ForeignKey',
    );
  }
}
