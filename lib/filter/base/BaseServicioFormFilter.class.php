<?php

/**
 * Servicio filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseServicioFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'            => new sfWidgetFormFilterInput(),
      'nombre'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'activo'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_by'        => new sfWidgetFormFilterInput(),
      'updated_by'        => new sfWidgetFormFilterInput(),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'observaciones'     => new sfWidgetFormFilterInput(),
      'empresa_id'        => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'precio'            => new sfWidgetFormFilterInput(),
      'cuenta_contable'   => new sfWidgetFormFilterInput(),
      'impuesto_hotelero' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'codigo'            => new sfValidatorPass(array('required' => false)),
      'nombre'            => new sfValidatorPass(array('required' => false)),
      'activo'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_by'        => new sfValidatorPass(array('required' => false)),
      'updated_by'        => new sfValidatorPass(array('required' => false)),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'observaciones'     => new sfValidatorPass(array('required' => false)),
      'empresa_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'precio'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cuenta_contable'   => new sfValidatorPass(array('required' => false)),
      'impuesto_hotelero' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('servicio_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Servicio';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'codigo'            => 'Text',
      'nombre'            => 'Text',
      'activo'            => 'Boolean',
      'created_by'        => 'Text',
      'updated_by'        => 'Text',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
      'observaciones'     => 'Text',
      'empresa_id'        => 'ForeignKey',
      'precio'            => 'Number',
      'cuenta_contable'   => 'Text',
      'impuesto_hotelero' => 'Boolean',
    );
  }
}
