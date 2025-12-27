<?php

class EditaPartidaForm extends sfForm {

    public function configure() {

        $this->setWidget('fecha', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'readOnly'=>true,        'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fecha', new sfValidatorString(array('required' => true)));

        $this->setWidget('numero', new sfWidgetFormInputText(array(), array('readOnly'=>true, 'class' => 'form-control', 'max_length' => 150,)));
        $this->setValidator('numero', new sfValidatorString(array('required' => false)));

        
        $this->setWidget('detalle', new sfWidgetFormInputText(array(), array(  'readOnly'=>true,'class' => 'form-control', 'max_length' => 150,)));
        $this->setValidator('detalle', new sfValidatorString(array('required' => false)));

        $nombreBanco = CuentaErpContableQuery::create()
                ->orderByCuentaContable("Asc")
//                ->where("CuentaErpContable.CuentaContable not like '%00'")
//                ->where('length(CuentaErpContable.CuentaContable) >6 ')
                ->find();
        $listaC[null] = '[Seleccione]';
        foreach ($nombreBanco as $linea) {
            if (strlen($linea->getCuentaContable()) > 4) {
                $listaC[$linea->getCuentaContable()] = $linea->getCuentaContable() . " " . $linea->getNombre();
            }
        }


         $this->setWidget('cuenta_haber', new sfWidgetFormChoice(array("choices" => $listaC,), array("class" => "mi-selector form-control")));
        $this->setValidator('cuenta_haber', new sfValidatorString(array('required' => false)));

        
        $this->setWidget('cuenta_debe', new sfWidgetFormChoice(array("choices" => $listaC,), array("class" => "mi-selector form-control")));
        $this->setValidator('cuenta_debe', new sfValidatorString(array('required' => false)));

       $this->setWidget('valor_haber', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => 0,
                    'onkeypress' => 'validate(event)',
                    'xtype' => 'number', 'step' => 'any')));
        $this->setValidator('valor_haber', new sfValidatorString(array('required' => false)));
        
       $this->setWidget('valor_debe', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => 0,
                    'onkeypress' => 'validate(event)',
                    'xtype' => 'number', 'step' => 'any')));
        $this->setValidator('valor_debe', new sfValidatorString(array('required' => false)));

        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
