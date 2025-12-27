<?php

class ListaBancoForm extends sfForm {

    public function configure() {

        $dia = sfContext::getInstance()->getUser()->getAttribute('fecha', null, 'dia');
        $ventaResumida = VentaResumidaQuery::create()
                ->filterByFecha($dia)
                ->find();
             $bancoq = BancoQuery::create()->filterByActivo(true)->find();
        $tipoB[null]='[Seleccione Banco]';
        foreach($bancoq as $regi) {
            $tipoB[$regi->getId()]=$regi->getNombre();
        }
        foreach ($ventaResumida as $registro) {
            $this->setWidget('banco' . $registro->getId(), new sfWidgetFormChoice(array("choices" => $tipoB,), array("class" => "form-control")));
            $this->setValidator('banco' . $registro->getId(), new sfValidatorString(array('required' => false)));
        }


        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
