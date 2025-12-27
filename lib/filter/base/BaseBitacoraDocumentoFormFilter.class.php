<?php

/**
 * BitacoraDocumento filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseBitacoraDocumentoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tipo'          => new sfWidgetFormFilterInput(),
      'identificador' => new sfWidgetFormFilterInput(),
      'usuario'       => new sfWidgetFormFilterInput(),
      'fecha'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'hora'          => new sfWidgetFormFilterInput(),
      'accion'        => new sfWidgetFormFilterInput(),
      'comentario'    => new sfWidgetFormFilterInput(),
      'ip'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'tipo'          => new sfValidatorPass(array('required' => false)),
      'identificador' => new sfValidatorPass(array('required' => false)),
      'usuario'       => new sfValidatorPass(array('required' => false)),
      'fecha'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'hora'          => new sfValidatorPass(array('required' => false)),
      'accion'        => new sfValidatorPass(array('required' => false)),
      'comentario'    => new sfValidatorPass(array('required' => false)),
      'ip'            => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('bitacora_documento_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BitacoraDocumento';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'tipo'          => 'Text',
      'identificador' => 'Text',
      'usuario'       => 'Text',
      'fecha'         => 'Date',
      'hora'          => 'Text',
      'accion'        => 'Text',
      'comentario'    => 'Text',
      'ip'            => 'Text',
    );
  }
}
