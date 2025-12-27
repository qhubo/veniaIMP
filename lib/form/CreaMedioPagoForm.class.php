<?php

class CreaMedioPagoForm extends sfForm {

    public function configure() {


        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "Nombre",)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));
        
          $this->setWidget('activo', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));
        $this->setWidget('aplica_mov_banco', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('aplica_mov_banco', new sfValidatorString(array('required' => false)));

                $this->setWidget('pide_banco', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('pide_banco', new sfValidatorString(array('required' => false)));

               $this->setWidget('pago_proveedor', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('pago_proveedor', new sfValidatorString(array('required' => false)));
        
        $filtro ="(CuentaErpContable.Nombre like '%caja%' ";
        $filtro .=" or  CuentaErpContable.Nombre like '%caja%'";
        $filtro .=" or  CuentaErpContable.Nombre like '%bank%'";
        $filtro .=" or  CuentaErpContable.Nombre like '%depo%'";
        $filtro .=" or  CuentaErpContable.Nombre like '%visa%'";
        $filtro .=" or  CuentaErpContable.Nombre like '%depo%'";
        $filtro .=" or  CuentaErpContable.Nombre like '%credo%'";
        $filtro .=" or  CuentaErpContable.Nombre like '%visa%'";
        $filtro .=") ";
        
        
        
                $nombreBanco = CuentaErpContableQuery::create()
                // ->where('length(CuentaErpContable.CuentaContable) >6 ')
              //   ->where($filtro)
                ->orderByCuentaContable("Asc")
                ->find();
        $listaC[null]='[Seleccione]';
        foreach ($nombreBanco as $linea) {
            //if (strlen($linea->getCuentaContable()) >4) {
            $listaC[$linea->getCuentaContable()]= $linea->getCuentaContable()." ". $linea->getNombre();
           // }
        }
        
        $this->setWidget('cuenta_contable', new sfWidgetFormChoice(array("choices" => $listaC,), array("class" => "mi-selector form-control")));
        $this->setValidator('cuenta_contable', new sfValidatorString(array('required' => false)));

        
        
     
for ($i = 1; $i <= 100; $i++) {     
        $tipo[$i] = $i;
}
       
        $this->setWidget('orden', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('orden', new sfValidatorString(array('required' => true)));


        
        $bancos= BancoQuery::create()
                ->find();
        $listab[null]='[Seleccione]';
        foreach ($bancos as $regi) {
            $listab[$regi->getId()]=$regi->getNombre();
        }
        
        $this->setWidget('banco', new sfWidgetFormChoice(array("choices" => $listab,), array("class" => "form-control")));
        $this->setValidator('banco', new sfValidatorString(array('required' => false)));
        
        
        
        
    
         $this->setWidget('pos', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('pos', new sfValidatorString(array('required' => false)));

      
         $this->setWidget('retiene_isr', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('retiene_isr', new sfValidatorString(array('required' => false)));

     

        
//          $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
//            'callback' => array($this, "valida")
//        )));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
