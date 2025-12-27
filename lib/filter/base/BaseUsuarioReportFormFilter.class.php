<?php

/**
 * UsuarioReport filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseUsuarioReportFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'             => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'tipo_letra'             => new sfWidgetFormFilterInput(),
      'papel'                  => new sfWidgetFormFilterInput(),
      'orientacion'            => new sfWidgetFormFilterInput(),
      'logo_tamanio'           => new sfWidgetFormFilterInput(),
      'logo_posicion'          => new sfWidgetFormFilterInput(),
      'letra_titulo_no'        => new sfWidgetFormFilterInput(),
      'letra_detalle_no'       => new sfWidgetFormFilterInput(),
      'letra_titulo_bold'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'letra_detalle_bold'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'letra_titulo_color'     => new sfWidgetFormFilterInput(),
      'letra_detalle_color'    => new sfWidgetFormFilterInput(),
      'una_linea'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'tipo_tabla'             => new sfWidgetFormFilterInput(),
      'border_color'           => new sfWidgetFormFilterInput(),
      'fondo_color_encabezado' => new sfWidgetFormFilterInput(),
      'fondo_color_detalle'    => new sfWidgetFormFilterInput(),
      'marca_agua'             => new sfWidgetFormFilterInput(),
      'fondo'                  => new sfWidgetFormFilterInput(),
      'logo'                   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'empresa_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'tipo_letra'             => new sfValidatorPass(array('required' => false)),
      'papel'                  => new sfValidatorPass(array('required' => false)),
      'orientacion'            => new sfValidatorPass(array('required' => false)),
      'logo_tamanio'           => new sfValidatorPass(array('required' => false)),
      'logo_posicion'          => new sfValidatorPass(array('required' => false)),
      'letra_titulo_no'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'letra_detalle_no'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'letra_titulo_bold'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'letra_detalle_bold'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'letra_titulo_color'     => new sfValidatorPass(array('required' => false)),
      'letra_detalle_color'    => new sfValidatorPass(array('required' => false)),
      'una_linea'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'tipo_tabla'             => new sfValidatorPass(array('required' => false)),
      'border_color'           => new sfValidatorPass(array('required' => false)),
      'fondo_color_encabezado' => new sfValidatorPass(array('required' => false)),
      'fondo_color_detalle'    => new sfValidatorPass(array('required' => false)),
      'marca_agua'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fondo'                  => new sfValidatorPass(array('required' => false)),
      'logo'                   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_report_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioReport';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'empresa_id'             => 'ForeignKey',
      'tipo_letra'             => 'Text',
      'papel'                  => 'Text',
      'orientacion'            => 'Text',
      'logo_tamanio'           => 'Text',
      'logo_posicion'          => 'Text',
      'letra_titulo_no'        => 'Number',
      'letra_detalle_no'       => 'Number',
      'letra_titulo_bold'      => 'Boolean',
      'letra_detalle_bold'     => 'Boolean',
      'letra_titulo_color'     => 'Text',
      'letra_detalle_color'    => 'Text',
      'una_linea'              => 'Boolean',
      'tipo_tabla'             => 'Text',
      'border_color'           => 'Text',
      'fondo_color_encabezado' => 'Text',
      'fondo_color_detalle'    => 'Text',
      'marca_agua'             => 'Number',
      'fondo'                  => 'Text',
      'logo'                   => 'Text',
    );
  }
}
