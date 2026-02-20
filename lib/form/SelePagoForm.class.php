<?php

class SelePagoForm extends sfForm {

    public function configure() {


        $this->setWidget('no_documento', new sfWidgetFormTextarea(array(), array('class' => 'form-control', 'rows' => 2)));

        $this->setValidator('no_documento', new sfValidatorString(array('required' => false)));


        $listaP[null] = '[Seleccione]';
        $MEdioPago = MedioPagoQuery::create()
                //->filterByPagoProveedor(true)
                ->filterByActivo(true)
                ->orderByNombre()
                ->find();

        $listaP['Efectivo'] = 'Efectivo';
        foreach ($MEdioPago as $rege) {
            $Nombre = str_replace(" ", "", $rege->getNombre());
            $Nombre = strtolower($Nombre);
            $Nombre = trim($Nombre);
            // if ( ($Nombre <> "notacredito")  && ($Nombre <>"notacrédito") &&  ($Nombre <> "notadecredito")  && ($Nombre <>"notadecrédito") ) {
            if ($Nombre <> "contraentrega") {
                $listaP[$rege->getNombre()] = $rege->getNombre();
            }
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

}
