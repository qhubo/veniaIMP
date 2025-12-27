<?php

class IngreCargaInicialForm extends sfForm {

    public function configure() {
        $listaCuentas = CuentaErpContableQuery::create()->find();

        foreach ($listaCuentas as $registro) {
            $this->setWidget('debe'.$registro->getId(), new sfWidgetFormInputText(array(), array('type' => 'number', 'class' => 'form-control', 'placeholder' => '0.00','any' => 'step', 'step' => 'any' )));
            $this->setValidator('debe'.$registro->getId(), new sfValidatorString(array('required' => false)));
            $this->setWidget('haber'.$registro->getId(), new sfWidgetFormInputText(array(), array('type' => 'number', 'class' => 'form-control', 'placeholder' => '0.00','any' => 'step', 'step' => 'any' )));
            $this->setValidator('haber'.$registro->getId(), new sfValidatorString(array('required' => false)));
            
        }
 $this->setWidget('confirma', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('confirma', new sfValidatorString(array('required' => true)));

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

    public function valida(sfValidatorBase $validator, array $values) {

        $tipoPago = $values['tipo_pago'];
        $documento = trim($values['no_documento']);

        if ($tipoPago <> "") {

            if (( $tipoPago <> 'Efectivo') && ($tipoPago <> 'Cheque')) {
                if ($documento == "") {
                    throw new sfValidatorErrorSchema($validator, array("no_documento" => new sfValidatorError($validator, "Requiere No Documento")));
                }
            }
        }

        if ($tipoPago == 'Cheque') {
            if (!$values['banco_id']) {
                throw new sfValidatorErrorSchema($validator, array("banco_id" => new sfValidatorError($validator, "Requiere Banco")));
            }
        }
        return $values;
    }

}
