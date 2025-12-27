<?php

/**
 * CargaComprasSat filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseCargaComprasSatFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'validado'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'tipo_dte'     => new sfWidgetFormFilterInput(),
      'serie'        => new sfWidgetFormFilterInput(),
      'no_dte'       => new sfWidgetFormFilterInput(),
      'emisor'       => new sfWidgetFormFilterInput(),
      'autorizacion' => new sfWidgetFormFilterInput(),
      'nit_emisor'   => new sfWidgetFormFilterInput(),
      'monto'        => new sfWidgetFormFilterInput(),
      'tipo'         => new sfWidgetFormFilterInput(),
      'codigo'       => new sfWidgetFormFilterInput(),
      'usuario'      => new sfWidgetFormFilterInput(),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'manual'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'documento'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'fecha'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'validado'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'tipo_dte'     => new sfValidatorPass(array('required' => false)),
      'serie'        => new sfValidatorPass(array('required' => false)),
      'no_dte'       => new sfValidatorPass(array('required' => false)),
      'emisor'       => new sfValidatorPass(array('required' => false)),
      'autorizacion' => new sfValidatorPass(array('required' => false)),
      'nit_emisor'   => new sfValidatorPass(array('required' => false)),
      'monto'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'tipo'         => new sfValidatorPass(array('required' => false)),
      'codigo'       => new sfValidatorPass(array('required' => false)),
      'usuario'      => new sfValidatorPass(array('required' => false)),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'manual'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'documento'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('carga_compras_sat_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CargaComprasSat';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'fecha'        => 'Date',
      'validado'     => 'Boolean',
      'tipo_dte'     => 'Text',
      'serie'        => 'Text',
      'no_dte'       => 'Text',
      'emisor'       => 'Text',
      'autorizacion' => 'Text',
      'nit_emisor'   => 'Text',
      'monto'        => 'Number',
      'tipo'         => 'Text',
      'codigo'       => 'Text',
      'usuario'      => 'Text',
      'updated_at'   => 'Date',
      'manual'       => 'Boolean',
      'documento'    => 'Text',
    );
  }
}
