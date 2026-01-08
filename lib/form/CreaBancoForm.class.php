<?php

class CreaBancoForm extends sfForm {

    public function configure() {


                        $this->setWidget('direccion', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('direccion', new sfValidatorString(array('required' => false)));

        $paisQ = PaisQuery::create()->orderByNombre()->find();
        $listaPais[null]='Seleccione';
        foreach($paisQ as $regi) {
        $listaPais[$regi->getId()]=$regi->getNombre();
            
        }
        
         $this->setWidget('pais_id', new sfWidgetFormChoice(array("choices" => $listaPais,), array("class" => "form-control")));
        $this->setValidator('pais_id', new sfValidatorString(array('required' => true)));
        
        
         $this->setWidget('destinario', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 250,)));
        $this->setValidator('destinario', new sfValidatorString(array('required' => false)));

         $this->setWidget('intermediario', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 250,)));
        $this->setValidator('intermediario', new sfValidatorString(array('required' => false)));

        
        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "Nombre",)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));
        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => false)));


        $this->setWidget('cuenta', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,)));
        $this->setValidator('cuenta', new sfValidatorString(array('required' => false)));

                $this->setWidget('pago_cheque', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('pago_cheque', new sfValidatorString(array('required' => false)));

        $this->setWidget('dolares', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('dolares', new sfValidatorString(array('required' => false)));
        $this->setWidget('activo', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));
       $tipo[null]='[Seleccione]';
        $tipo['CORRIENTES'] = 'CORRIENTES';
       $tipo['AHORRO']='AHORRO';
       
        $this->setWidget('tipo', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('tipo', new sfValidatorString(array('required' => true)));
        
        $nombreBanco = NombreBancoQuery::create()
                ->filterByActivo(true)
                ->orderByNombre()
                ->find();
        $listaM[null]='[Seleccione]';
        foreach ($nombreBanco as $linea) {
            $listaM[$linea->getId()]=$linea->getNombre();
            
        }
        $this->setWidget('banco', new sfWidgetFormChoice(array("choices" => $listaM,), array("class" => "mi-selector form-control")));
        $this->setValidator('banco', new sfValidatorString(array('required' => false)));

        
            $filtro ="(CuentaErpContable.Nombre like '%banco%' ";

        $filtro .=" or  CuentaErpContable.Nombre like '%bank%'";

        $filtro .=") ";
        
        $nombreBanco = CuentaErpContableQuery::create()
                ->orderByCuentaContable("Asc")
             //    ->where($filtro)
       //         ->where('length(CuentaErpContable.CuentaContable) >6 ')
                ->find();
        $listaC[null]='[Seleccione]';
        foreach ($nombreBanco as $linea) {
          //  if (strlen($linea->getCuentaContable()) >4) {
            $listaC[$linea->getCuentaContable()]= $linea->getCuentaContable()." ". $linea->getNombre();
           // }
        }
        
        $this->setWidget('cuenta_contable', new sfWidgetFormChoice(array("choices" => $listaC,), array("class" => "mi-selector form-control")));
        $this->setValidator('cuenta_contable', new sfValidatorString(array('required' => false)));

        
        
//          $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
//            'callback' => array($this, "valida")
//        )));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
