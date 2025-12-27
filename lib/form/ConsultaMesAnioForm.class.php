<?php

class ConsultaMesAnioForm extends sfForm {

    public function configure() {

        $mes[1] = 'Enero';
        $mes[2] = 'Febrero';
        $mes[3] = 'Marzo';
        $mes[4] = 'Abril';
        $mes[5] = 'Mayo';
        $mes[6] = 'Junio';
        $mes[7] = 'Julio';
        $mes[8] = 'Agosto';
        $mes[9] = 'Septiembre';
        $mes[10] = 'Octubre';
        $mes[11] = 'Noviembre';
        $mes[12] = 'Diciembre';
        $anioInicia = date('Y') - 2;
        for ($i = 0; $i <= 10; $i++) {
            $anio = $anioInicia + $i;
            $lano[$anio] = $anio;
        }


        $this->setWidget('mes_inicio', new sfWidgetFormChoice(array("choices" => $mes), array("class" => " form-control")));
        $this->setValidator('mes_inicio', new sfValidatorString(array('required' => false)));


        
        $this->setWidget('anio_inicio', new sfWidgetFormChoice(array("choices" => $lano), array("class" => " form-control")));
        $this->setValidator('anio_inicio', new sfValidatorString(array('required' => false)));

     
        
        $this->widgetSchema->setNameFormat('periodo[%s]');
    }

}
