<?php

class CreaSolicitudDevolucionForm extends sfForm {

    public function configure() {

        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));

        $this->setWidget('factura', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Factura', 'max_length' => 150,)));
        $this->setValidator('factura', new sfValidatorString(array('required' => true)));

        $this->setWidget('referencia_factura', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Referencia', 'max_length' => 150,)));
        $this->setValidator('referencia_factura', new sfValidatorString(array('required' => true)));

        $listaVem[null] = "[Seleccione]";
        $vendedorQ = VendedorQuery::create()
                ->filterByActivo(true)
                ->orderByNombre("Asc")
                ->find();
        foreach ($vendedorQ as $vende) {
            $nomb = trim(strtoupper($vende->getNombre()));
            $listaVem[$nomb] = $nomb;
        }

        $this->setWidget('vendedor', new sfWidgetFormChoice(array("choices" => $listaVem,), array("class" => "mi-selector form-control ")));
        $this->setValidator('vendedor', new sfValidatorString(array('required' => true)));
        $listaMedio['Del Dia'] = 'Del Dia';
        $listaMedio['CHEQUE'] = 'Cheque';
        $listaMedio['Vale'] = 'Vale';
        $listaMedio['Cambio'] = 'Cambio';

        $this->setWidget('medio', new sfWidgetFormChoice(array("choices" => $listaMedio,), array("class" => " form-control ")));
        $this->setValidator('medio', new sfValidatorString(array('required' => true)));

        $this->setWidget('concepto', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce',
                    'placeholder' => ''
        )));
        $this->setValidator('concepto', new sfValidatorString(array('required' => true)));

        $this->setWidget('detalle', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce',
                    'placeholder' => 'Describa el motivo del reclamo'
        )));
        $this->setValidator('detalle', new sfValidatorString(array('required' => true)));

        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "Cliente",)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));

        $this->setWidget('dpi', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "00000000000000",)));
        $this->setValidator('dpi', new sfValidatorString(array('required' => false)));

        $this->setWidget('telefono', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "00000000",)));
        $this->setValidator('telefono', new sfValidatorString(array('required' => false)));
        $this->setWidget('valor', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'onkeypress' => 'validate(event)', 'placeholder' => '00.00', 'max_length' => 150,)));

        $this->setValidator('valor', new sfValidatorString(array('required' => true)));

        $this->setWidget('valor', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'onkeypress' => 'validate(event)', 'placeholder' => '00.00', 'max_length' => 150,)));

        $this->setValidator('valor', new sfValidatorString(array('required' => true)));

        $this->setWidget('valor_retiene', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'onkeypress' => 'validate(event)', 'placeholder' => '00.00', 'max_length' => 150,)));

        $this->setValidator('valor_retiene', new sfValidatorString(array('required' => false)));

        $this->setWidget('codigo1', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Hollander', 'max_length' => 150,)));
        $this->setValidator('codigo1', new sfValidatorString(array('required' => true)));
        $this->setWidget('descripcion1', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => '', 'max_length' => 150,)));
        $this->setValidator('descripcion1', new sfValidatorString(array('required' => true)));
        $this->setWidget('stock1', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Stock', 'max_length' => 150,)));
        $this->setValidator('stock1', new sfValidatorString(array('required' => true)));
        $listaT[null] = '[Seleccione]';
        $listaT["NUEVO"] = 'Nuevo';
        $listaT["USADO"] = 'Usado';

        $this->setWidget('tipo1', new sfWidgetFormChoice(array("choices" => $listaT,), array("class" => " form-control ")));
        $this->setValidator('tipo1', new sfValidatorString(array('required' => false)));

        for ($i = 2; $i <= 10; $i++) {
            $this->setWidget('codigo' . $i, new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Hollander', 'max_length' => 150,)));
            $this->setValidator('codigo' . $i, new sfValidatorString(array('required' => false)));
            $this->setWidget('descripcion' . $i, new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => '', 'max_length' => 150,)));
            $this->setValidator('descripcion' . $i, new sfValidatorString(array('required' => false)));
            $this->setWidget('stock' . $i, new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Stock', 'max_length' => 150,)));
            $this->setValidator('stock' . $i, new sfValidatorString(array('required' => false)));
            $this->setWidget('tipo' . $i, new sfWidgetFormChoice(array("choices" => $listaT,), array("class" => " form-control ")));
            $this->setValidator('tipo' . $i, new sfValidatorString(array('required' => false)));
        }


        $motivoA = MotivoMovimientoProductoQuery::create()
                //->filterByActivo(true)
                ->find();
        foreach ($motivoA as $regist) {
            $this->setWidget('motivo_' . $regist->getId(), new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
            $this->setValidator('motivo_' . $regist->getId(), new sfValidatorString(array('required' => false)));
        }

        $this->setWidget('Ltipo1', new sfWidgetFormChoice(array("choices" => $listaT,), array("class" => " form-control ")));
        $this->setValidator('Ltipo1', new sfValidatorString(array('required' => false)));

        for ($i = 1; $i <= 11; $i++) {
            $this->setWidget('Lcodigo' . $i, new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Hollander', 'max_length' => 150,)));
            $this->setValidator('Lcodigo' . $i, new sfValidatorString(array('required' => false)));
            $this->setWidget('Ldescripcion' . $i, new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => '', 'max_length' => 150,)));
            $this->setValidator('Ldescripcion' . $i, new sfValidatorString(array('required' => false)));
            $this->setWidget('Lstock' . $i, new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Stock', 'max_length' => 150,)));
            $this->setValidator('Lstock' . $i, new sfValidatorString(array('required' => false)));
            $this->setWidget('Ltipo' . $i, new sfWidgetFormChoice(array("choices" => $listaT,), array("class" => " form-control ")));
            $this->setValidator('Ltipo' . $i, new sfValidatorString(array('required' => false)));
        }


        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
                    'callback' => array($this, "validaUsuario")
        )));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

    public function validaUsuario(sfValidatorBase $validator, array $values) {

        $motivoA = MotivoMovimientoProductoQuery::create()
                ->filterByActivo(true)
                ->find();
        $can = 0;
        foreach ($motivoA as $regist) {
            if ($values['motivo_' . $regist->getId()]) {
                $can++;
            }
        }
        for ($i = 1; $i <= 10; $i++) {
            $stock = $values['stock' . $i];
            $codigo = $values['codigo' . $i];
            $tipoRE = $values['tipo' . $i];
            if ((trim($stock) <> "") && (trim($codigo) <> "")) {
                if (trim($tipoRE) == "") {
                    $msg = 'Debe tipo Repuesto ';
                    throw new sfValidatorErrorSchema($validator, array("descripcion" . $i => new sfValidatorError($validator, $msg)));
                }
            }
            $stock = $values['Lstock' . $i];
            $codigo = $values['Lcodigo' . $i];
            $tipoRE = $values['Ltipo' . $i];
            if ((trim($stock) <> "") && (trim($codigo) <> "")) {
                if (trim($tipoRE) == "") {
                    $msg = 'Debe tipo Repuesto ';
                    throw new sfValidatorErrorSchema($validator, array("Ldescripcion" . $i => new sfValidatorError($validator, $msg)));
                }
            }
        }
        if ($can == 0) {
            $msg = 'Debe seleccionar una razón ';
            throw new sfValidatorErrorSchema($validator, array("detalle" => new sfValidatorError($validator, $msg)));
        }

        return $values;
    }

}
