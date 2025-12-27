<?php

/**
 * estado_cuenta actions.
 *
 * @package    plan
 * @subpackage estado_cuenta
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class estado_cuentaActions extends sfActions {

    public function executeReportePdf(sfWebRequest $request) {
        $clientev = $request->getParameter('clientev');
        $fechaInicial = $request->getParameter('fecharef');
//        echo $fechaInicial;
//        die();
        error_reporting(-1);
        $clienteQ = ClienteQuery::create()->findOneById($clientev);
        $logo = $clienteQ->getEmpresa()->getLogo();
        $logo = 'uploads/images/' . $logo;
        $NOMBRE_EMPRESA = $clienteQ->getEmpresa()->getNombre();
        $DIRECCION = $clienteQ->getEmpresa()->getDireccion();
        $TELEFONO = $clienteQ->getEmpresa()->getTelefono();
        $detalle = $this->DatosFactura($clientev, $fechaInicial);
//        echo "<pre>";
//        print_r($detalle);
//        die();
        
        $html = $this->getPartial('estado_cuenta/reporte', array("logo" => $logo, 'NOMBRE_EMPRESA' => $NOMBRE_EMPRESA,
            'DIRECCION' => $DIRECCION, 'TELEFONO' => $TELEFONO, 'detalle' => $detalle, 'clienteQ' => $clienteQ));
//        echo $html;
//        die();
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle('Estado de cuenta cliente  ' . $clienteQ->getCodigo());
        $pdf->SetSubject('Estado Cuenta');
        $pdf->SetKeywords('Estado Cuenta'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetMargins(3, 5, 0, true);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetHeaderMargin(0.1);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont('dejavusans', '', 9);
        $pdf->AddPage();
           $pdf->Image($logo, 5, 10, 35, '', '', '', '100', false, 0);
        $pdf->writeHTML($html);



        $pdf->Output('Estado cuenta ' . $clienteQ->getCodigo() . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeIndex(sfWebRequest $request) {
        $this->clientev = $request->getParameter('clientev');
        $this->clientes = ClienteQuery::create()->find();
        $this->registros = null;
        $fechaInicial = date('d/m/Y');
        $this->fechaInicial = $fechaInicial;
        if ($request->getParameter('fecharef')) {
            $this->fechaInicial = $request->getParameter('fecharef');
        }
        if ($this->clientev) {
            $this->registros = $this->DatosFactura($this->clientev, $this->fechaInicial );
        }
    }

    public function DatosFactura($clientev, $fechaInicial) {
  //      echo $fechaInicial;
        $VALORESFECHA = explode("/", $fechaInicial);
        $fechaInicial = $VALORESFECHA[2] . "-" . $VALORESFECHA[1] . "-" . $VALORESFECHA[0];
        $SUMAS = 0;
        $RESTAR = 0;
        $sumatorias = OperacionQuery::create()
                 ->filterById(237, Criteria::GREATER_THAN)
                ->where("Operacion.Fecha < '" . $fechaInicial . " 01:01:01'")
                ->withColumn('sum(Operacion.ValorTotal)', 'TotalTotal')
                ->filterByEstatus('Anulado', Criteria::NOT_EQUAL)
                ->filterByClienteId($clientev)
                ->findOne();
        if ($sumatorias) {
            $SUMAS = $sumatorias->getTotalTotal();
        }
        $listab[] ='CXC COBRAR';
$listab[] ='CONTRA ENTREGA';
$listab[] ='CONTRAENTREGA';
$listab[] ='CHEQUE PREFECHADO';
    $restas = OperacionPagoQuery::create()
     ->filterById(237, Criteria::GREATER_THAN)
                ->filterByTipo($listab, Criteria::NOT_IN)
            ->where("OperacionPago.FechaCreo < '" . $fechaInicial . " 01:01:01'")
                ->withColumn('sum(OperacionPago.Valor)', 'TotalTotal')
                ->useOperacionQuery()
                ->filterByClienteId($clientev)
                ->endUse()
                ->findOne();
        if ($restas) {
            $RESTAR = $restas->getTotalTotal();
        }
        $SALDO = $SUMAS + $RESTAR;
        
//        ECHO $SUMAS;
//        echo "<br>";
//        echo $RESTAR;
//        die();
        
        $operaciones = OperacionQuery::create()
                     ->filterById(237, Criteria::GREATER_THAN)
                ->where("Operacion.Fecha >= '" . $fechaInicial . " 00:00:00'")
                ->filterByEstatus('Anulado', Criteria::NOT_EQUAL)
                ->filterByClienteId($clientev)
                ->find();
        $data = null;
        $lista = null;
        $listaKey = null;
        $saldoINcial = $SALDO;

        $VALORESFECHA = explode("-", $fechaInicial);
        $fechaInic = $VALORESFECHA[2] . "/" . $VALORESFECHA[1] . "/" . $VALORESFECHA[0];
//        echo "<pre>";
//        print_R($VALORESFECHA);
//        die();
        
        $Key = '20210101246050_P';
        $data['codigo'] = "Saldo a la fecha";
        $data['fecha'] = $fechaInic;
        $data['cargo'] = 0;
        $data['abono'] = 0;
        $data['descripcion'] = '';
        $data['saldo'] = $saldoINcial;
        $lista[$Key] = $data;
        $listaKey[] = $Key;

        $listb[]=0;

        foreach ($operaciones as $registr) {
            $listb[]=$registr->getCodigo();
            if (array_key_exists($registr->getCodigo(), $listb)) {
                
            } else {
            $saldoINcial = $saldoINcial + $registr->getValorTotal();
            $Key = $registr->getFecha('YmdHis') . "_P".$registr->getId();
            $data['codigo'] = "FACTURA " . $registr->getCodigo();
            $data['fecha'] = $registr->getFecha('d/m/Y H:i');
            $data['cargo'] = $registr->getValorTotal();
            $data['abono'] = 0;
            $data['descripcion'] = '';
            $data['saldo'] = $saldoINcial;
            $lista[$Key] = $data;
            $listaKey[] = $Key;
            }
        }
        

        
        $opeacionesPago = OperacionPagoQuery::create()
                     ->filterById(237, Criteria::GREATER_THAN)
                ->where("OperacionPago.FechaCreo >= '" . $fechaInicial . " 01:01:01'")
              //  ->filterByTipo('CXC COBRAR', Criteria::NOT_EQUAL)
                ->filterByTipo($listab, Criteria::NOT_IN)
            ->useOperacionQuery()
                ->filterByClienteId($clientev)
                ->endUse()
                ->find();
        foreach ($opeacionesPago as $pago) {
            $saldoINcial = $saldoINcial - $pago->getValor();
            $Key = $pago->getFechaCreo('YmdHis') . "_C";
            $data['codigo'] = "RECIBO " . $pago->getCodigo();
            $data['fecha'] = $pago->getFechaCreo('d/m/Y H:i');
            $data['abono'] = $pago->getValor();
            $data['cargo'] = 0;
            $data['saldo'] = $saldoINcial;
            $banco = "";
            if ($pago->getBancoId()) {
                $banco = $pago->getBanco()->getNombre();
            }
            $data['descripcion'] = $pago->getTipo() . " " . $banco . " Documento " . $pago->getDocumento() . " " . $pago->getFechaDocumento('d/m/Y');
            $lista[$Key] = $data;
            $listaKey[] = $Key;
        }
        sort($listaKey, SORT_NATURAL | SORT_FLAG_CASE);
        $registro = null;
        
       
        foreach ($listaKey as $listad) {
          
        $CODIGO= $lista[$listad]['codigo'];
       
            $registro[$CODIGO] = $lista[$listad];
        }
        

        
        
        return $registro;
    }

}
