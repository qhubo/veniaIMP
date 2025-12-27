<?php

/**
 * TipoServicio filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseTipoServicioFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'        => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'            => new sfWidgetFormFilterInput(),
      'nombre'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'activo'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'dia_credito'       => new sfWidgetFormFilterInput(),
      'cuenta_contable'   => new sfWidgetFormFilterInput(),
      'precio'            => new sfWidgetFormFilterInput(),
      'impuesto_hotelero' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'empresa_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'codigo'            => new sfValidatorPass(array('required' => false)),
      'nombre'            => new sfValidatorPass(array('required' => false)),
      'activo'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'dia_credito'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cuenta_contable'   => new sfValidatorPass(array('required' => false)),
      'precio'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'impuesto_hotelero' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('tipo_servicio_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TipoServicio';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'empresa_id'        => 'ForeignKey',
      'codigo'            => 'Text',
      'nombre'            => 'Text',
      'activo'            => 'Boolean',
      'dia_credito'       => 'Number',
      'cuenta_contable'   => 'Text',
      'precio'            => 'Number',
      'impuesto_hotelero' => 'Boolean',
    );
  }
}
