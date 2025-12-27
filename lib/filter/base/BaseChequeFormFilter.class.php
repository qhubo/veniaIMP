<?php

/**
 * Cheque filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseChequeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'banco_id'            => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => true)),
      'documento_cheque_id' => new sfWidgetFormPropelChoice(array('model' => 'DocumentoCheque', 'add_empty' => true)),
      'proveedor_id'        => new sfWidgetFormPropelChoice(array('model' => 'Proveedor', 'add_empty' => true)),
      'numero'              => new sfWidgetFormFilterInput(),
      'beneficiario'        => new sfWidgetFormFilterInput(),
      'fecha_cheque'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'valor'               => new sfWidgetFormFilterInput(),
      'motivo'              => new sfWidgetFormFilterInput(),
      'estatus'             => new sfWidgetFormFilterInput(),
      'negociable'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'usuario'             => new sfWidgetFormFilterInput(),
      'fecha_creo'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'orden_devolucion_id' => new sfWidgetFormPropelChoice(array('model' => 'OrdenDevolucion', 'add_empty' => true)),
      'solicitud_cheque_id' => new sfWidgetFormPropelChoice(array('model' => 'SolicitudCheque', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'banco_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Banco', 'column' => 'id')),
      'documento_cheque_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'DocumentoCheque', 'column' => 'id')),
      'proveedor_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveedor', 'column' => 'id')),
      'numero'              => new sfValidatorPass(array('required' => false)),
      'beneficiario'        => new sfValidatorPass(array('required' => false)),
      'fecha_cheque'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'valor'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'motivo'              => new sfValidatorPass(array('required' => false)),
      'estatus'             => new sfValidatorPass(array('required' => false)),
      'negociable'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'usuario'             => new sfValidatorPass(array('required' => false)),
      'fecha_creo'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'orden_devolucion_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'OrdenDevolucion', 'column' => 'id')),
      'solicitud_cheque_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SolicitudCheque', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('cheque_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cheque';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'banco_id'            => 'ForeignKey',
      'documento_cheque_id' => 'ForeignKey',
      'proveedor_id'        => 'ForeignKey',
      'numero'              => 'Text',
      'beneficiario'        => 'Text',
      'fecha_cheque'        => 'Date',
      'valor'               => 'Number',
      'motivo'              => 'Text',
      'estatus'             => 'Text',
      'negociable'          => 'Boolean',
      'usuario'             => 'Text',
      'fecha_creo'          => 'Date',
      'orden_devolucion_id' => 'ForeignKey',
      'solicitud_cheque_id' => 'ForeignKey',
    );
  }
}
