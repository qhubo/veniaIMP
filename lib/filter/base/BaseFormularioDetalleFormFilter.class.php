<?php

/**
 * FormularioDetalle filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseFormularioDetalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'formulario_datos_id' => new sfWidgetFormPropelChoice(array('model' => 'FormularioDatos', 'add_empty' => true)),
      'hollander'           => new sfWidgetFormFilterInput(),
      'repuesto'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'formulario_datos_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'FormularioDatos', 'column' => 'id')),
      'hollander'           => new sfValidatorPass(array('required' => false)),
      'repuesto'            => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('formulario_detalle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'FormularioDetalle';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'formulario_datos_id' => 'ForeignKey',
      'hollander'           => 'Text',
      'repuesto'            => 'Text',
    );
  }
}
