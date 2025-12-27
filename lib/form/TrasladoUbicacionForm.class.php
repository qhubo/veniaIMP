<?php

class TrasladoUbicacionForm extends sfForm {

    public function configure() {
        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control', 'rows' => 2)));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => true)));
        $listaT[null] = '[Seleccione]';
        $regionq = TiendaQuery::create()
                ->find();
        foreach ($regionq as $data) {
            $listaT[$data->getId()] = $data->getNombre();
        }
        $this->setWidget('tienda_id', new sfWidgetFormChoice(array("choices" => $listaT,), array("class" => "mi-selector  form-control ")));
        $this->setValidator('tienda_id', new sfValidatorString(array('required' => true)));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
