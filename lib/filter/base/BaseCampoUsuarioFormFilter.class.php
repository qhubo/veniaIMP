<?php

/**
 * CampoUsuario filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseCampoUsuarioFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'     => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tipo_documento' => new sfWidgetFormFilterInput(),
      'codigo'         => new sfWidgetFormFilterInput(),
      'nombre'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tipo_campo'     => new sfWidgetFormFilterInput(),
      'valores'        => new sfWidgetFormFilterInput(),
      'requerido'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'activo'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'orden'          => new sfWidgetFormFilterInput(),
      'tienda_id'      => new sfWidgetFormPropelChoice(array('model' => 'Tienda', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'empresa_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'tipo_documento' => new sfValidatorPass(array('required' => false)),
      'codigo'         => new sfValidatorPass(array('required' => false)),
      'nombre'         => new sfValidatorPass(array('required' => false)),
      'tipo_campo'     => new sfValidatorPass(array('required' => false)),
      'valores'        => new sfValidatorPass(array('required' => false)),
      'requerido'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'activo'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'orden'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tienda_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tienda', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('campo_usuario_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CampoUsuario';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'empresa_id'     => 'ForeignKey',
      'tipo_documento' => 'Text',
      'codigo'         => 'Text',
      'nombre'         => 'Text',
      'tipo_campo'     => 'Text',
      'valores'        => 'Text',
      'requerido'      => 'Boolean',
      'activo'         => 'Boolean',
      'orden'          => 'Number',
      'tienda_id'      => 'ForeignKey',
    );
  }
}
