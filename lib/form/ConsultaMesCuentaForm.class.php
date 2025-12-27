<?php

class ConsultaMesCuentaForm extends sfForm {

    public function configure() {
                $nombreBanco = CuentaErpContableQuery::create()
                ->orderByCuentaContable("Asc")
//                          ->where("SUBSTR(CuentaErpContable.CuentaContable, length(cuenta_contable)-1, 2) <> '00'")
//             //    ->where($filtro)
//                ->where('length(CuentaErpContable.CuentaContable) >6 ')
                ->find();
        $listaC[null]='[Todas las Cuentas]';
        $listaC2[null]='[SELECCIONE]';
        foreach ($nombreBanco as $linea) {
           if (strlen($linea->getCuentaContable()) >4) {
            $listaC2[$linea->getCuentaContable()]= $linea->getCuentaContable()." ". $linea->getNombre();
            }
        }
        
        $this->setWidget('cuenta_contable', new sfWidgetFormChoice(array("choices" => $listaC2,), array("class" => "mi-selector form-control")));
        $this->setValidator('cuenta_contable', new sfValidatorString(array('required' => false)));

        
         $this->setWidget('cuenta_contable2', new sfWidgetFormChoice(array("choices" => $listaC2,), array("class" => "mi-selector form-control")));
        $this->setValidator('cuenta_contable2', new sfValidatorString(array('required' => false)));

        
       
        
        
$mes['01']="Enero";
$mes['02']="Febrero";
$mes['03']="Marzo";
$mes['04']="Abril";
$mes['05']="Mayo";
$mes['06']="Junio";
$mes['07']="Julio";
$mes['08']="Agosto";
$mes['09']="Septiembre";
$mes['10']="Octubre";
$mes['11']="Noviembre";
$mes['12']="Diciembre";


          $this->setWidget('mes', new sfWidgetFormChoice(array("choices" => $mes,), array("class" => "mi-selector form-control")));
        $this->setValidator('mes', new sfValidatorString(array('required' => false)));

       for ($i = (date('Y')-3); $i <= (date('Y')+20); $i++) {
           $list[$i]=$i;
       } 

        
        
          $this->setWidget('anio', new sfWidgetFormChoice(array("choices" => $list,), array("class" => "mi-selector form-control")));
        $this->setValidator('anio', new sfValidatorString(array('required' => false)));

        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}