<?php

class CreaServicioForm extends sfForm {

    public function configure() {

        $this->setWidget('precio', new sfWidgetFormInputText(array(), array('class' => 'form-control','any'=>'step',  'step'=>'any', 'type' => 'number',)));
        $this->setValidator('precio', new sfValidatorString(array('required' => false)));
        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "Nombre",)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));
        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => false)));
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
        $this->setWidget('codigo', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, )));
        $this->setValidator('codigo', new sfValidatorString(array('required' => false)));
        
        $this->setWidget('impuesto_hotelero', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('impuesto_hotelero', new sfValidatorString(array('required' => false)));        
        $this->setWidget('activo', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));
              $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
