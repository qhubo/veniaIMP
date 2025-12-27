<?php

/**
 * Marca filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseMarcaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tipo_aparato_id' => new sfWidgetFormPropelChoice(array('model' => 'TipoAparato', 'add_empty' => true)),
      'codigo'          => new sfWidgetFormFilterInput(),
      'descripcion'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'muestra_menu'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'logo'            => new sfWidgetFormFilterInput(),
      'activo'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'imagen'          => new sfWidgetFormFilterInput(),
      'orden_mostrar'   => new sfWidgetFormFilterInput(),
      'receta'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'status'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'tipo_aparato_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TipoAparato', 'column' => 'id')),
      'codigo'          => new sfValidatorPass(array('required' => false)),
      'descripcion'     => new sfValidatorPass(array('required' => false)),
      'muestra_menu'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'logo'            => new sfValidatorPass(array('required' => false)),
      'activo'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'imagen'          => new sfValidatorPass(array('required' => false)),
      'orden_mostrar'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'receta'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'status'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('marca_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Marca';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'empresa_id'      => 'ForeignKey',
      'tipo_aparato_id' => 'ForeignKey',
      'codigo'          => 'Text',
      'descripcion'     => 'Text',
      'muestra_menu'    => 'Boolean',
      'logo'            => 'Text',
      'activo'          => 'Boolean',
      'imagen'          => 'Text',
      'orden_mostrar'   => 'Number',
      'receta'          => 'Boolean',
      'status'          => 'Number',
    );
  }
}
