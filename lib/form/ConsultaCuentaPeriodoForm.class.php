<?php

class ConsultaCuentaPeriodoForm extends sfForm {

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

        $this->setWidget('mes_fin', new sfWidgetFormChoice(array("choices" => $mes), array("class" => " form-control")));
        $this->setValidator('mes_fin', new sfValidatorString(array('required' => false)));

        
        $this->setWidget('anio_inicio', new sfWidgetFormChoice(array("choices" => $lano), array("class" => " form-control")));
        $this->setValidator('anio_inicio', new sfValidatorString(array('required' => false)));

        $this->setWidget('anio_fin', new sfWidgetFormChoice(array("choices" => $lano), array("class" => " form-control")));
        $this->setValidator('anio_fin', new sfValidatorString(array('required' => false)));
        
                        $nombreBanco = CuentaErpContableQuery::create()
                ->orderByCuentaContable("Asc")
             //    ->where($filtro)
//                ->where('length(CuentaErpContable.CuentaContable) >6 ')
//             ->where("SUBSTR(CuentaErpContable.CuentaContable, length(cuenta_contable)-1, 2) <> '00'")
           
                ->find();
        $listaC[null]='[Todas las Cuentas]';
        foreach ($nombreBanco as $linea) {
            if (strlen($linea->getCuentaContable()) >2) {
            $listaC[$linea->getCuentaContable()]= $linea->getCuentaContable()." ". $linea->getNombre();
            }
        }
        
        $this->setWidget('cuenta_contable', new sfWidgetFormChoice(array("choices" => $listaC,), array("class" => "mi-selector form-control")));
        $this->setValidator('cuenta_contable', new sfValidatorString(array('required' => false)));

        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
