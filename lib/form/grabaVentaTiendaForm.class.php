<?php

class grabaVentaTiendaForm extends sfForm {

    public function configure() {


        $this->setWidget('total', new sfWidgetFormInputText(array(), array('class' => 'form-control',)));
        $this->setValidator('total', new sfValidatorString(array('required' => false)));

        $medioPago = MedioPagoQuery::create()
                ->find();

        $bancoq = BancoQuery::create()->filterByActivo(true)->find();
        $tipoB[null] = '[Seleccione Banco]';
        foreach ($bancoq as $regi) {
            $tipoB[$regi->getId()] = $regi->getNombre();
        }


for ($i = 1; $i <= 10; $i++) {
        foreach ($medioPago as $registro) {
            $this->setWidget('observaciones' . $registro->getId()."_".$i, new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Observaciones',)));
            $this->setValidator('observaciones' . $registro->getId()."_".$i, new sfValidatorString(array('required' => false)));
            $this->setWidget('boleta' . $registro->getId()."_".$i, new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'No Boleta',)));
            $this->setValidator('boleta' . $registro->getId()."_".$i, new sfValidatorString(array('required' => false)));
            
            $this->setWidget('medio' . $registro->getId()."_".$i, new sfWidgetFormInputText(array(), array('placeholder' => 0,
                        'class' => 'form-control',
                        'onkeypress' => 'validate(event)',
                        'xtype' => 'number', 'step' => 'any')));
            $this->setValidator('medio' . $registro->getId()."_".$i, new sfValidatorString(array('required' => false)));
            $this->setWidget('banco' . $registro->getId()."_".$i, new sfWidgetFormChoice(array("choices" => $tipoB,), array("class" => "form-control")));
            $this->setValidator('banco' . $registro->getId()."_".$i, new sfValidatorString(array('required' => false)));
        }
}
        
//              $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
//            'callback' => array($this, "validaUsuario")
//        )));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

//        public function validaUsuario(sfValidatorBase $validator, array $values) {
//
//         $mediosPago = MedioPagoQuery::create()
//                 ->find();
//         foreach ($mediosPago as $regis) {
//             $valor = $values['medio'.$regis->getId()];
//             $bancoId = $values['banco'.$regis->getId()];
//             if ($valor >0) {
//               if  (!$bancoId) {
//                 throw new sfValidatorErrorSchema($validator, array("banco".$regis->getId() => new sfValidatorError($validator, "Debe seleccionar banco")));
//                   
//               }
//             }
//             
//             
//         }
//  
//
//        return $values;
//    }
}
