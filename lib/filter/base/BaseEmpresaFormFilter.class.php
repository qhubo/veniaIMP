<?php

/**
 * Empresa filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseEmpresaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'               => new sfWidgetFormFilterInput(),
      'nombre'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nomenclatura'         => new sfWidgetFormFilterInput(),
      'telefono'             => new sfWidgetFormFilterInput(),
      'departamento_id'      => new sfWidgetFormPropelChoice(array('model' => 'Departamento', 'add_empty' => true)),
      'municipio_id'         => new sfWidgetFormPropelChoice(array('model' => 'Municipio', 'add_empty' => true)),
      'direccion'            => new sfWidgetFormFilterInput(),
      'mapa_geo'             => new sfWidgetFormFilterInput(),
      'logo'                 => new sfWidgetFormFilterInput(),
      'contacto_nombre'      => new sfWidgetFormFilterInput(),
      'contacto_telefono'    => new sfWidgetFormFilterInput(),
      'contacto_movil'       => new sfWidgetFormFilterInput(),
      'observaciones'        => new sfWidgetFormFilterInput(),
      'factura_electronica'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'contacto_correo'      => new sfWidgetFormFilterInput(),
      'feel_nombre'          => new sfWidgetFormFilterInput(),
      'feel_usuario'         => new sfWidgetFormFilterInput(),
      'feel_token'           => new sfWidgetFormFilterInput(),
      'feel_llave'           => new sfWidgetFormFilterInput(),
      'feel_escenario_frase' => new sfWidgetFormFilterInput(),
      'dias_credito'         => new sfWidgetFormFilterInput(),
      'retiene_isr'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'moneda_q'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'codigo'               => new sfValidatorPass(array('required' => false)),
      'nombre'               => new sfValidatorPass(array('required' => false)),
      'nomenclatura'         => new sfValidatorPass(array('required' => false)),
      'telefono'             => new sfValidatorPass(array('required' => false)),
      'departamento_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Departamento', 'column' => 'id')),
      'municipio_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Municipio', 'column' => 'id')),
      'direccion'            => new sfValidatorPass(array('required' => false)),
      'mapa_geo'             => new sfValidatorPass(array('required' => false)),
      'logo'                 => new sfValidatorPass(array('required' => false)),
      'contacto_nombre'      => new sfValidatorPass(array('required' => false)),
      'contacto_telefono'    => new sfValidatorPass(array('required' => false)),
      'contacto_movil'       => new sfValidatorPass(array('required' => false)),
      'observaciones'        => new sfValidatorPass(array('required' => false)),
      'factura_electronica'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'contacto_correo'      => new sfValidatorPass(array('required' => false)),
      'feel_nombre'          => new sfValidatorPass(array('required' => false)),
      'feel_usuario'         => new sfValidatorPass(array('required' => false)),
      'feel_token'           => new sfValidatorPass(array('required' => false)),
      'feel_llave'           => new sfValidatorPass(array('required' => false)),
      'feel_escenario_frase' => new sfValidatorPass(array('required' => false)),
      'dias_credito'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'retiene_isr'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'moneda_q'             => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('empresa_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Empresa';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'codigo'               => 'Text',
      'nombre'               => 'Text',
      'nomenclatura'         => 'Text',
      'telefono'             => 'Text',
      'departamento_id'      => 'ForeignKey',
      'municipio_id'         => 'ForeignKey',
      'direccion'            => 'Text',
      'mapa_geo'             => 'Text',
      'logo'                 => 'Text',
      'contacto_nombre'      => 'Text',
      'contacto_telefono'    => 'Text',
      'contacto_movil'       => 'Text',
      'observaciones'        => 'Text',
      'factura_electronica'  => 'Boolean',
      'contacto_correo'      => 'Text',
      'feel_nombre'          => 'Text',
      'feel_usuario'         => 'Text',
      'feel_token'           => 'Text',
      'feel_llave'           => 'Text',
      'feel_escenario_frase' => 'Text',
      'dias_credito'         => 'Number',
      'retiene_isr'          => 'Boolean',
      'moneda_q'             => 'Text',
    );
  }
}
