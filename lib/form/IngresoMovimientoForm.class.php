<?php

class IngresoMovimientoForm extends sfForm {

    public function configure() {




        $vboedgas = BancoQuery::create()
                ->filterByActivo(true)
                ->orderByNombre()
                ->find();

        $tipo[null] = '[Seleccione]';
        foreach ($vboedgas as $registro) {
            $tipo[$registro->getId()] = $registro->getNombre();
        }

        $this->setWidget('banco_origen', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('banco_origen', new sfValidatorString(array('required' => false)));

        $this->setWidget('banco_destino', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('banco_destino', new sfValidatorString(array('required' => false)));


        $this->setWidget('fecha_movimiento', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fecha_movimiento', new sfValidatorString(array('required' => true)));

        $this->setWidget('referencia', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,
            "placeholder" => "No Documento",)));
        $this->setValidator('referencia', new sfValidatorString(array('required' => true)));




        $this->setWidget('monto', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'type' => 'number', 'any' => 'step', 'step' => 'any')));
        $this->setValidator('monto', new sfValidatorString(array('required' => true)));




        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce', 'rows' => 2)));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => true)));

        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
            'callback' => array($this, "validaUsuario")
        )));

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

    public function validaUsuario(sfValidatorBase $validator, array $values) {
        $banco_origen = $values['banco_origen'];
        $banco_destino = $values['banco_destino'];
        if ($banco_destino == $banco_origen) {
            throw new sfValidatorErrorSchema($validator, array("banco_destino" => new sfValidatorError($validator, 'Banco Origen debe ser diferente Banco Destino')));
        }
        return $values;
    }

}
