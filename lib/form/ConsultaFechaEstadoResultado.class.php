<?php


class ConsultaFechaEstadoResultadoForm extends sfForm {

    public function configure() {
           $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
     
        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), 
                array('class' => 'form-control', 'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
       $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
           'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));
        $lista[null]='Seleccione';
        $lista['01']='01';
        $lista['02']='02';
        $lista['03']='03';
        $lista['04']='04';
        $lista['05']='05';
        $lista['06']='06';
        $lista['07']='07';
        $lista['08']='08';
        $lista['09']='09';
        $lista['10']='10';
                                                
        $this->setWidget('tienda', new sfWidgetFormChoice(array("choices" => $lista,), array("class" => "mi-selector form-control")));
        $this->setValidator('tienda', new sfValidatorString(array('required' => false)));
        
        
//        
//                $nombreBanco = CuentaErpContableQuery::create()
//                ->orderByCuentaContable("Asc")
//                          ->where("SUBSTR(CuentaErpContable.CuentaContable, length(cuenta_contable)-1, 2) <> '00'")
//             //    ->where($filtro)
//                ->where('length(CuentaErpContable.CuentaContable) >6 ')
//                ->find();
//        $listaC[null]='[Todas las Cuentas]';
//        $listaC2[null]='[SELECCIONE]';
//        foreach ($nombreBanco as $linea) {
//            if (strlen($linea->getCuentaContable()) >4) {
//            $listaC[$linea->getCuentaContable()]= $linea->getCuentaContable()." ". $linea->getNombre();
//            }
//            if (strlen($linea->getCuentaContable()) >4) {
//            $listaC2[$linea->getCuentaContable()]= $linea->getCuentaContable()." ". $linea->getNombre();
//            }
//        }
//        
//        $this->setWidget('cuenta_contable', new sfWidgetFormChoice(array("choices" => $listaC,), array("class" => "mi-selector form-control")));
//        $this->setValidator('cuenta_contable', new sfValidatorString(array('required' => false)));
//
//        
//         $this->setWidget('cuenta_contable2', new sfWidgetFormChoice(array("choices" => $listaC2,), array("class" => "mi-selector form-control")));
//        $this->setValidator('cuenta_contable2', new sfValidatorString(array('required' => false)));
//
//        
//       
//         $this->setWidget('cuenta_contable3', new sfWidgetFormChoice(array("choices" => $listaC2,), array("class" => "mi-selector form-control")));
//        $this->setValidator('cuenta_contable3', new sfValidatorString(array('required' => false)));
//
//               
//         $this->setWidget('cuenta_contable4', new sfWidgetFormChoice(array("choices" => $listaC2,), array("class" => "mi-selector form-control")));
//        $this->setValidator('cuenta_contable4', new sfValidatorString(array('required' => false)));
//
//               
//         $this->setWidget('cuenta_contable5', new sfWidgetFormChoice(array("choices" => $listaC2,), array("class" => "mi-selector form-control")));
//        $this->setValidator('cuenta_contable5', new sfValidatorString(array('required' => false)));
//
//               
//         $this->setWidget('cuenta_contable6', new sfWidgetFormChoice(array("choices" => $listaC2,), array("class" => "mi-selector form-control")));
//        $this->setValidator('cuenta_contable6', new sfValidatorString(array('required' => false)));
//
//               
//         $this->setWidget('cuenta_contable7', new sfWidgetFormChoice(array("choices" => $listaC2,), array("class" => "mi-selector form-control")));
//        $this->setValidator('cuenta_contable7', new sfValidatorString(array('required' => false)));
//    $this->setWidget('cuenta_contable8', new sfWidgetFormChoice(array("choices" => $listaC2,), array("class" => "mi-selector form-control")));
//        $this->setValidator('cuenta_contable8', new sfValidatorString(array('required' => false)));
//
//          $this->setWidget('cuenta_contable9', new sfWidgetFormChoice(array("choices" => $listaC2,), array("class" => "mi-selector form-control")));
//        $this->setValidator('cuenta_contable9', new sfValidatorString(array('required' => false)));
//
//        
//          $this->setWidget('cuenta_contable10', new sfWidgetFormChoice(array("choices" => $listaC2,), array("class" => "mi-selector form-control")));
//        $this->setValidator('cuenta_contable10', new sfValidatorString(array('required' => false)));
//
//        
//          $this->setWidget('cuenta_contable11', new sfWidgetFormChoice(array("choices" => $listaC2,), array("class" => "mi-selector form-control")));
//        $this->setValidator('cuenta_contable11', new sfValidatorString(array('required' => false)));
//
//$tipo['agrudado']='Agrupado';
//$tipo['detallado']='Detallado';
//        
//          $this->setWidget('tipo', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "mi-selector form-control")));
//        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));
//
//        
//$tipoF[null]='Todas';
//$tipoF['confirmadas']='Confirmadas';
//$tipoF['pendientes']='Pendientes';
//        
//          $this->setWidget('filtro', new sfWidgetFormChoice(array("choices" => $tipoF,), array("class" => "mi-selector form-control")));
//        $this->setValidator('filtro', new sfValidatorString(array('required' => false)));
//
//        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}