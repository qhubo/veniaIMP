<?php

class SelePagoProveedorForm extends sfForm {

    public function configure() {

                $this->setWidget('vuelto', new sfWidgetFormInputText(array(), array(
                    'readonly'=>true,
                    'type' => 'number', 'class' => 'form-control', 'placeholder' => '0.00',
                    'any' => 'step', 'step' => 'any'
        )));
        $this->setValidator('vuelto', new sfValidatorString(array('required' => false)));
        
        

        $this->setWidget('comision', new sfWidgetFormInputText(array(), array(
                    'type' => 'number', 'class' => 'form-control', 'placeholder' => '0.00',
                    'any' => 'step', 'step' => 'any'
        )));
        $this->setValidator('comision', new sfValidatorString(array('required' => false)));
        
        $this->setWidget('valor', new sfWidgetFormInputText(array(), array(
                    'type' => 'number', 'class' => 'form-control', 'placeholder' => '0.00',
                    'any' => 'step', 'step' => 'any'
        )));
        $this->setValidator('valor', new sfValidatorString(array('required' => true)));

        $this->setWidget('aplica_isr', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('aplica_isr', new sfValidatorString(array('required' => false)));

        
         $this->setWidget('factura_electronica', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('factura_electronica', new sfValidatorString(array('required' => false)));

        
        $this->setWidget('aplica_iva', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('aplica_iva', new sfValidatorString(array('required' => false)));
//
//        $this->setWidget('no_documento', new sfWidgetFormInputText(array(), array(
//                    'class' => 'form-control', 'placeholder' => 'documento',)));
        
          $this->setWidget('no_documento', new sfWidgetFormTextarea(array(), array('class' => 'form-control', 'rows' => 2)));
   
        $this->setValidator('no_documento', new sfValidatorString(array('required' => false)));

        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $EmpresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $listaP[null] = '[Seleccione]';
 $MEdioPago = MedioPagoQuery::create()
                //->filterByPagoProveedor(true)
                ->filterByActivo(true)
                ->orderByNombre()
                ->find();

        $listaP['Efectivo'] = 'Efectivo';
        foreach ($MEdioPago as $rege) {
            $Nombre = str_replace(" ","",$rege->getNombre());
            $Nombre = strtolower($Nombre);
            $Nombre=trim($Nombre);
           // if ( ($Nombre <> "notacredito")  && ($Nombre <>"notacrédito") &&  ($Nombre <> "notadecredito")  && ($Nombre <>"notadecrédito") ) {
             $listaP[$rege->getNombre()] = $rege->getNombre();
           // }
                    
            
        }
     $proveedorId=  sfContext::getInstance()->getUser()->getAttribute("proveedorId", null, 'seguridad');


        $NotaCreditoPe = NotaCreditoQuery::create()
                ->filterByEstatus("Nuevo")
               ->filterByProveedorId($proveedorId)
                ->find();
        foreach($NotaCreditoPe as $regi) {
                     $listaP[$regi->getId()] ="Nota Crédito ".$regi->getCodigo();
        }
        
        
//        if ($EmpresaQ->getPagoCheque()) {
//            $listaP['Cheque'] = 'Cheque';
//        }
//        if ($EmpresaQ->getPagoTarjeta()) {
//            $listaP['Tarjeta'] = 'Tarjeta';
//        }
//        if ($EmpresaQ->getPagoDeposito()) {
//            $listaP['Deposito'] = 'Deposito';
//        }
//        if ($EmpresaQ->getPagoAch()) {
//            $listaP['Transferencia'] = 'Transferencia';
//        }

        $this->setWidget('fecha', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fecha', new sfValidatorString(array('required' => true)));

        $this->setWidget('tipo_pago', new sfWidgetFormChoice(array("choices" => $listaP), array("class" => "form-control")));
        $this->setValidator('tipo_pago', new sfValidatorString(array('required' => true)));

        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
                    'callback' => array($this, "valida")
        )));

        $bancos = BancoQuery::create()->filterByActivo(true)
                        //->filterByPagoCheque(true)
                        ->orderByNombre()->find();
        $listaB[null] = '[Seleccione]';

        foreach ($bancos as $deta) {
            $listaB[$deta->getId()] = $deta->getNombre();
        }


        $this->setWidget('banco_id', new sfWidgetFormChoice(array("choices" => $listaB), array("class" => "form-control")));
        $this->setValidator('banco_id', new sfValidatorString(array('required' => false)));

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

    public function valida(sfValidatorBase $validator, array $values) {
        $tipoPago = $values['tipo_pago'];
        $documento = trim($values['no_documento']);
        $tipoPago = trim(strtolower($tipoPago));
        if ($tipoPago <> "") {
            if (( $tipoPago <> 'efectivo') && ($tipoPago <> 'cheque') ) {
                if ($documento == "") {
                    throw new sfValidatorErrorSchema($validator, array("no_documento" => new sfValidatorError($validator, "Requiere No Documento")));
                }
            }
        }
        if ($tipoPago  == 'cheque' or $tipoPago == 'deposito') {
            if (!$values['banco_id']) {
                throw new sfValidatorErrorSchema($validator, array("banco_id" => new sfValidatorError($validator, "Requiere Banco")));
            }
        }
        return $values;
    }

}
