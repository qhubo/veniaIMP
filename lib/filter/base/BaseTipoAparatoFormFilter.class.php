<?php

/**
 * TipoAparato filter form base class.
 *
 * @package    plan
 * @subpackage filter
 * @author     Via
 */
abstract class BaseTipoAparatoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'                => new sfWidgetFormPropelChoice(array('model' => 'Empresa', 'add_empty' => true)),
      'codigo'                    => new sfWidgetFormFilterInput(),
      'descripcion'               => new sfWidgetFormFilterInput(),
      'activo'                    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'menu_invertido'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'muestra_menu'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'logo'                      => new sfWidgetFormFilterInput(),
      'cargo_peso_libra_producto' => new sfWidgetFormFilterInput(),
      'imagen'                    => new sfWidgetFormFilterInput(),
      'orden_mostrar'             => new sfWidgetFormFilterInput(),
      'menu_muestra_producto'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'tipo_menu'                 => new sfWidgetFormFilterInput(),
      'menu_lateral'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'receta'                    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'status'                    => new sfWidgetFormFilterInput(),
      'cuenta_contable'           => new sfWidgetFormFilterInput(),
      'venta'                     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'empresa_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Empresa', 'column' => 'id')),
      'codigo'                    => new sfValidatorPass(array('required' => false)),
      'descripcion'               => new sfValidatorPass(array('required' => false)),
      'activo'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'menu_invertido'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'muestra_menu'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'logo'                      => new sfValidatorPass(array('required' => false)),
      'cargo_peso_libra_producto' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'imagen'                    => new sfValidatorPass(array('required' => false)),
      'orden_mostrar'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'menu_muestra_producto'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'tipo_menu'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'menu_lateral'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'receta'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'status'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cuenta_contable'           => new sfValidatorPass(array('required' => false)),
      'venta'                     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('tipo_aparato_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TipoAparato';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'empresa_id'                => 'ForeignKey',
      'codigo'                    => 'Text',
      'descripcion'               => 'Text',
      'activo'                    => 'Boolean',
      'menu_invertido'            => 'Boolean',
      'muestra_menu'              => 'Boolean',
      'logo'                      => 'Text',
      'cargo_peso_libra_producto' => 'Number',
      'imagen'                    => 'Text',
      'orden_mostrar'             => 'Number',
      'menu_muestra_producto'     => 'Boolean',
      'tipo_menu'                 => 'Number',
      'menu_lateral'              => 'Boolean',
      'receta'                    => 'Boolean',
      'status'                    => 'Number',
      'cuenta_contable'           => 'Text',
      'venta'                     => 'Boolean',
    );
  }
}
