<?php

class CreaLineaForm extends sfForm {

    public function configure() {
        $vboedgas = CuentaErpContableQuery::create()
                ->orderByCuentaContable('Asc')
                ->find();
        $tipoProv[null] = '[Seleccione]';
        foreach ($vboedgas as $registro) {
            $tipoProv[$registro->getCuentaContable()] = "[" . $registro->getCuentaContable() . "] " . $registro->getNombre();
        }
        $this->setWidget('cuenta_contable', new sfWidgetFormChoice(array("choices" => $tipoProv,), array("class" => "mi-selector form-control")));
        $this->setValidator('cuenta_contable', new sfValidatorString(array('required' => true)));
        $this->setWidget('nombre', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce', 'rows' => 2)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => false)));
        for ($i = 1; $i <= 100; $i++) {
            $va[$i] = $i;
        }
        $this->setWidget('cantidad', new sfWidgetFormChoice(array("choices" => $va,), array("class" => "form-control")));
        $this->setValidator('cantidad', new sfValidatorString(array('required' => true)));

        $this->setWidget('valor', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number',)));
        $this->setValidator('valor', new sfValidatorString(array('required' => true)));



        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
