<?php

/**
 * TiendaComision filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseTiendaComisionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre_tienda' => new sfWidgetFormFilterInput(),
      'minimo'        => new sfWidgetFormFilterInput(),
      'maximo'        => new sfWidgetFormFilterInput(),
      'tipo'          => new sfWidgetFormFilterInput(),
      'valor'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'nombre_tienda' => new sfValidatorPass(array('required' => false)),
      'minimo'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'maximo'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'tipo'          => new sfValidatorPass(array('required' => false)),
      'valor'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tienda_comision_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TiendaComision';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'nombre_tienda' => 'Text',
      'minimo'        => 'Number',
      'maximo'        => 'Number',
      'tipo'          => 'Text',
      'valor'         => 'Text',
    );
  }
}
