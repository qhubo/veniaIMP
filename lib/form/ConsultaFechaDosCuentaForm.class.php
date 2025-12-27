<?php

class ConsultaFechaDosCuentaForm extends sfForm {

    public function configure() {
           $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
     
        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), 
                array('class' => 'form-control', 'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
       $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
           'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));
        
        
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
            $listaC[$linea->getCuentaContable()]= $linea->getCuentaContable()." ". $linea->getNombre();
            }
            if (strlen($linea->getCuentaContable()) >4) {
            $listaC2[$linea->getCuentaContable()]= $linea->getCuentaContable()." ". $linea->getNombre();
            }
        }
        
        $this->setWidget('cuenta_contable', new sfWidgetFormChoice(array("choices" => $listaC,), array("class" => "mi-selector form-control")));
        $this->setValidator('cuenta_contable', new sfValidatorString(array('required' => true)));

        
         $this->setWidget('cuenta_contable2', new sfWidgetFormChoice(array("choices" => $listaC2,), array("class" => "mi-selector form-control")));
        $this->setValidator('cuenta_contable2', new sfValidatorString(array('required' => false)));

        
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}