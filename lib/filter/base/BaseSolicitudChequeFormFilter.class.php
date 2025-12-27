<?php

/**
 * SolicitudCheque filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseSolicitudChequeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'           => new sfWidgetFormFilterInput(),
      'empresa_id'       => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tipo'             => new sfWidgetFormFilterInput(),
      'nombre'           => new sfWidgetFormFilterInput(),
      'referencia'       => new sfWidgetFormFilterInput(),
      'motivo'           => new sfWidgetFormFilterInput(),
      'valor'            => new sfWidgetFormFilterInput(),
      'partida_no'       => new sfWidgetFormFilterInput(),
      'estatus'          => new sfWidgetFormFilterInput(),
      'fecha'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'usuario'          => new sfWidgetFormFilterInput(),
      'usuario_confirmo' => new sfWidgetFormFilterInput(),
      'fecha_confirmo'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'cheque_no'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'codigo'           => new sfValidatorPass(array('required' => false)),
      'empresa_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'tipo'             => new sfValidatorPass(array('required' => false)),
      'nombre'           => new sfValidatorPass(array('required' => false)),
      'referencia'       => new sfValidatorPass(array('required' => false)),
      'motivo'           => new sfValidatorPass(array('required' => false)),
      'valor'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'partida_no'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'estatus'          => new sfValidatorPass(array('required' => false)),
      'fecha'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'usuario'          => new sfValidatorPass(array('required' => false)),
      'usuario_confirmo' => new sfValidatorPass(array('required' => false)),
      'fecha_confirmo'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cheque_no'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('solicitud_cheque_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SolicitudCheque';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'codigo'           => 'Text',
      'empresa_id'       => 'ForeignKey',
      'tipo'             => 'Text',
      'nombre'           => 'Text',
      'referencia'       => 'Text',
      'motivo'           => 'Text',
      'valor'            => 'Number',
      'partida_no'       => 'Number',
      'estatus'          => 'Text',
      'fecha'            => 'Date',
      'usuario'          => 'Text',
      'usuario_confirmo' => 'Text',
      'fecha_confirmo'   => 'Date',
      'cheque_no'        => 'Number',
    );
  }
}
