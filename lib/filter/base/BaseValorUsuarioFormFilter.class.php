<?php

/**
 * ValorUsuario filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseValorUsuarioFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'campo_usuario_id' => new sfWidgetFormPropelChoice(array('model' => 'CampoUsuario', 'add_empty' => true)),
      'nombre_campo'     => new sfWidgetFormFilterInput(),
      'tipo_documento'   => new sfWidgetFormFilterInput(),
      'no_documento'     => new sfWidgetFormFilterInput(),
      'valor'            => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'       => new sfWidgetFormFilterInput(),
      'updated_by'       => new sfWidgetFormFilterInput(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'campo_usuario_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'CampoUsuario', 'column' => 'id')),
      'nombre_campo'     => new sfValidatorPass(array('required' => false)),
      'tipo_documento'   => new sfValidatorPass(array('required' => false)),
      'no_documento'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'valor'            => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_by'       => new sfValidatorPass(array('required' => false)),
      'updated_by'       => new sfValidatorPass(array('required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('valor_usuario_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ValorUsuario';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'campo_usuario_id' => 'ForeignKey',
      'nombre_campo'     => 'Text',
      'tipo_documento'   => 'Text',
      'no_documento'     => 'Number',
      'valor'            => 'Text',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'created_by'       => 'Text',
      'updated_by'       => 'Text',
      'empresa_id'       => 'ForeignKey',
    );
  }
}
