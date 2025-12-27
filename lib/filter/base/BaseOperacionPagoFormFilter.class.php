<?php

/**
 * OperacionPago filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseOperacionPagoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'      => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'operacion_id'    => new sfWidgetFormPropelChoice(array('model' => 'Operacion', 'add_empty' => true)),
      'tipo'            => new sfWidgetFormFilterInput(),
      'valor'           => new sfWidgetFormFilterInput(),
      'documento'       => new sfWidgetFormFilterInput(),
      'fecha_documento' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'banco_id'        => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'cuenta_contable' => new sfWidgetFormFilterInput(),
      'partida_no'      => new sfWidgetFormFilterInput(),
      'usuario'         => new sfWidgetFormFilterInput(),
      'fecha_creo'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'cxc_cobrar'      => new sfWidgetFormFilterInput(),
      'comision'        => new sfWidgetFormFilterInput(),
      'vuelto'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'operacion_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Operacion', 'column' => 'id')),
      'tipo'            => new sfValidatorPass(array('required' => false)),
      'valor'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'documento'       => new sfValidatorPass(array('required' => false)),
      'fecha_documento' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'banco_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
      'cuenta_contable' => new sfValidatorPass(array('required' => false)),
      'partida_no'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'usuario'         => new sfValidatorPass(array('required' => false)),
      'fecha_creo'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cxc_cobrar'      => new sfValidatorPass(array('required' => false)),
      'comision'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'vuelto'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('operacion_pago_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OperacionPago';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'empresa_id'      => 'ForeignKey',
      'operacion_id'    => 'ForeignKey',
      'tipo'            => 'Text',
      'valor'           => 'Number',
      'documento'       => 'Text',
      'fecha_documento' => 'Date',
      'banco_id'        => 'ForeignKey',
      'cuenta_contable' => 'Text',
      'partida_no'      => 'Number',
      'usuario'         => 'Text',
      'fecha_creo'      => 'Date',
      'cxc_cobrar'      => 'Text',
      'comision'        => 'Number',
      'vuelto'          => 'Number',
    );
  }
}
