<?php


class estado_cuentaActions extends sfActions {

    public function executeReportePdf(sfWebRequest $request) {
        $clientev = $request->getParameter('clientev');
        $fechaInicial = $request->getParameter('fecharef');
            $SUMAS = 0;
        $RESTAR = 0;

        // ================= SALDO INICIAL =================
        $sumatorias = OperacionQuery::create()

              ->withColumn('sum(Operacion.ValorTotal)', 'TotalTotal')
                ->filterByEstatus('Anulado', Criteria::NOT_EQUAL)
                ->filterByClienteId($clientev)
                ->findOne();

        if ($sumatorias) {
            $SUMAS = $sumatorias->getTotalTotal();
        }
 $listab[] = 'Anulado';
        $listab[] = 'CXC COBRAR';
        $listab[] = 'CONTRA ENTREGA';
        $listab[] = 'CONTRAENTREGA';
        $listab[] = 'CHEQUE PREFECHADO';

        $restas = OperacionPagoQuery::create()
                ->filterByTipo($listab, Criteria::NOT_IN)
                 ->withColumn('sum(OperacionPago.Valor)', 'TotalTotal')
                ->useOperacionQuery()
                ->filterByClienteId($clientev)
                ->endUse()
                ->findOne();

        if ($restas) {
            $RESTAR = $restas->getTotalTotal();
        }

        $notasCredito = NotaCreditoQuery::create()       
                ->where("NotaCredito.Estatus not like '%Anul%'")
                ->filterByClienteId($clientev)
                ->find();

        $RESTAN = 0;
        foreach ($notasCredito as $nota) {
            $RESTAN += ($nota->getValorTotal() - $nota->getValorPagado());
        }

        $SALDO = $SUMAS - $RESTAR - $RESTAN;
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
        // echo "<pre>";
        // print_r($detalle);
        //  die();

        $html = $this->getPartial('estado_cuenta/reporte', array("logo" => $logo, 'NOMBRE_EMPRESA' => $NOMBRE_EMPRESA,
       'SALDO'=> $SALDO,    'DIRECCION' => $DIRECCION, 'TELEFONO' => $TELEFONO, 'detalle' => $detalle, 'clienteQ' => $clienteQ));
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
        $pdf->SetMargins(0, 5, 2, true);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetHeaderMargin(0.1);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont('dejavusans', '', 9);
        $pdf->AddPage();
        $pdf->Image($logo, 55, -5, 35, '', '', '', '100', false, 0);
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
            $this->registros = $this->DatosFactura($this->clientev, $this->fechaInicial);
        }
    }

  public function DatosFactura($clientev, $fechaInicial) {
    $VALORESFECHA = explode("/", $fechaInicial);
    $fechaInicial = $VALORESFECHA[2] . "-" . $VALORESFECHA[1] . "-" . $VALORESFECHA[0];
    $SUMAS = 0;
    $RESTAR = 0;
    // ================= SALDO INICIAL =================
    $sumatorias = OperacionQuery::create()
        ->where("Operacion.Fecha <= '" . $fechaInicial . " 00:01:00'")
        ->withColumn('sum(Operacion.ValorTotal)', 'TotalTotal')
        ->filterByEstatus('Anulado', Criteria::NOT_EQUAL)
        ->filterByClienteId($clientev)
        ->findOne();

    if ($sumatorias) {
        $SUMAS = $sumatorias->getTotalTotal();
    }

     $listab[] = 'Anulado';
    $listab[] = 'CONTRA ENTREGA';
    $listab[] = 'CONTRAENTREGA';
    $listab[] = 'CHEQUE PREFECHADO';
    
    
    
    $restas = OperacionPagoQuery::create()
        ->filterByTipo($listab, Criteria::NOT_IN)
        ->where("OperacionPago.FechaCreo < '" . $fechaInicial . " 01:01:01'")
       // ->withColumn('sum(OperacionPago.Valor)', 'TotalTotal')
        ->useOperacionQuery()
            ->filterByClienteId($clientev)
        ->endUse()
        ->find();

  foreach($restas as $re) {
      $query="SELECT SUM(COALESCE(op1.comision,0)) valor  FROM operacion_pago op1 WHERE op1.operacion_pago_padre_no = ".$re->getId();
        $con = Propel::getConnection();
        $stmt = $con->prepare($query);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $valor=0;
        if ($result) {
           echo $valor = $result[0]['valor'];
            die();
        }
        $RESTAR = $re->getValor()+$RESTAR+$valor;
    }
//echo $RESTAR;
//die();
    $notasCredito = NotaCreditoQuery::create()
        ->where("NotaCredito.Fecha < '" . $fechaInicial . " 01:01:01'")
        ->where("NotaCredito.Estatus not like '%Anul%'")
        ->filterByClienteId($clientev)
        ->find();

    $RESTAN = 0;
    foreach ($notasCredito as $nota) {
        $RESTAN += ($nota->getValorTotal() - $nota->getValorPagado());
    }
    $SALDO = $SUMAS - $RESTAR - $RESTAN;
    // ================= MOVIMIENTOS =================
    $lista = [];
    $listaKey = [];
    $VALORESFECHA = explode("-", $fechaInicial);
    $fechaInic = $VALORESFECHA[2] . "/" . $VALORESFECHA[1] . "/" . $VALORESFECHA[0];
    // Saldo inicial
    $Key = '00000000000000_SALDO';
    $lista[$Key] = [
        'codigo' => "Saldo a la fecha",
        'fecha' => $fechaInic,
        'cargo' => 0,
        'abono' => 0,
        'descripcion' => '',
        'saldo' => $SALDO
    ];
    $listaKey[] = $Key;
    // FACTURAS
    $operaciones = OperacionQuery::create()
        ->where("Operacion.Fecha > '" . $fechaInicial . " 00:01:00'")
        ->filterByEstatus('Anulado', Criteria::NOT_EQUAL)
        ->filterByClienteId($clientev)
        ->find();

    foreach ($operaciones as $registr) {
        $Key = $registr->getFecha('YmdHis') . "_P" . $registr->getId();
        $lista[$Key] = [
            'codigo' => "FACT. " .trim(str_replace(" ", "",$registr->getCodigoFactura())),
            'fecha' => $registr->getFecha('d/m/Y'),
            'cargo' => $registr->getValorTotal(),
            'abono' => 0,
            'descripcion' => '',
            'saldo' => 0 // 🔥 ya no se calcula aquí
        ];
        $listaKey[] = $Key;
    }
    
      
     //  operacion pago PADRE  YmdHis
    $sqlquery =" select pp.id,  DATE_FORMAT(pp.fecha_documento, '%Y%m%d%H%i%s') fecha_orden, concat('P',pp.id) codigo, b.nombre banco, pp.documento,"
            . "  DATE_FORMAT(pp.fecha_documento, '%d/%m/%Y') fecha_documento,"
            . "  (
        pp.valor +
        COALESCE(
            (
                SELECT SUM(COALESCE(op1.comision,0))
                FROM operacion_pago op1
                WHERE op1.operacion_pago_padre_no = pp.id
            ),
        0)
    ) AS valor,   pp.tipo,pp.id "
    . " from operacion_pago_padre pp inner join banco b on b.id = pp.banco_id inner join operacion_pago"
    . " op on op.operacion_pago_padre_no = pp.id  inner join operacion opera on opera.id = operacion_id"
    . " where op.tipo <> 'anulado' and cliente_id=".$clientev."  and pp.fecha_documento >= '".$fechaInicial."'"
    . " group by pp.id, pp.documento, pp.fecha_documento, pp.valor, pp.tipo, pp.id";
            $sqlquery .= " order by op.fecha_documento";
        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlquery);
//     echo $sqlquery;
//     die();
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $registros = $result;
    

    foreach ($registros as $pago) {
        $estado= OperacionPagoQuery::create()
                ->filterByOperacionPagoPadreNo($pago['id'])
                ->find();
        $lsitado= '';
        $da=null;
        foreach($estado as $reg){
            $da[]='Fact '.$reg->getOperacion()->getCodigo()."  Valor " . Parametro::formato($reg->getValor(), false);
        }
         $lsitado= implode('<br>', $da);
        
         $codigo = 'P' . str_pad($pago['id'], 3, '0', STR_PAD_LEFT);
        $Key = $pago['fecha_orden']. "_C" . $pago['id'];
        $lista[$Key] = [
            'codigo' => "REC.  " .$codigo,
            'fecha' => $pago['fecha_documento'],
            'cargo' => 0,
            'abono' => $pago['valor'],
            'descripcion' => $pago['tipo'] . " " . $pago['banco'] . " Doc " . $pago['documento']."<br>  ".$lsitado,
            'saldo' => 0
        ];

        $listaKey[] = $Key;
    }
    
    // PAGOS
    $opeacionesPago = OperacionPagoQuery::create()
        ->where("OperacionPago.FechaCreo >= '" . $fechaInicial . " 01:01:01'")
        ->filterByTipo($listab, Criteria::NOT_IN)
        ->useOperacionQuery()
            ->filterByClienteId($clientev)
        ->endUse()
          ->filterByOperacionPagoPadreNo(0)
        ->find();

    foreach ($opeacionesPago as $pago) {
        $banco = "";
        if ($pago->getBancoId()) {
            $banco = $pago->getBanco()->getNombre();
        }

        $Key = $pago->getFechaCreo('YmdHis') . "_C" . $pago->getId();
        $lista[$Key] = [
            'codigo' => "REC.  " . $pago->getCodigo(),
            'fecha' => $pago->getFechaCreo('d/m/Y'),
            'cargo' => 0,
            'abono' => $pago->getValor()+ $pago->getComision(),
            'descripcion' => $pago->getTipo() . " " . $banco . " Doc " . $pago->getDocumento()." Fact ".$pago->getOperacion()->getCodigoFactura(),
            'saldo' => 0
        ];

        $listaKey[] = $Key;
    }

    // NOTAS DE CRÉDITO
    $notasCredito = NotaCreditoQuery::create()
        ->where("NotaCredito.Fecha >= '" . $fechaInicial . " 01:01:01'")
        ->where("NotaCredito.Estatus not like '%Anul%'")
        ->filterByClienteId($clientev)
        ->find();
    foreach ($notasCredito as $nota) {
        $valor = ($nota->getValorTotal() - $nota->getValorPagado());
        $Key = $nota->getFecha('YmdHis') . "_N" . $nota->getId();
        $lista[$Key] = [
            'codigo' => "N.C. " . $nota->getCodigo(),
            'fecha' => $nota->getFecha('d/m/Y'),
            'cargo' => 0,
            'abono' => $valor,
            'descripcion' => $nota->getConcepto(),
            'saldo' => 0
        ];
        $listaKey[] = $Key;
    }

    // ================= ORDENAR =================
    sort($listaKey, SORT_NATURAL | SORT_FLAG_CASE);

    // ================= RECALCULAR SALDO =================
    $saldoINcial = $SALDO;
    foreach ($listaKey as $index => $key) {
        if ($index == 0) {
            $lista[$key]['saldo'] = $saldoINcial;
            continue;
        }
        $saldoINcial += $lista[$key]['cargo'];
        $saldoINcial -= $lista[$key]['abono'];
        $lista[$key]['saldo'] = $saldoINcial;
   }
    // ================= RESULTADO FINAL =================
    $registro = [];
    foreach ($listaKey as $key) {
        $registro[$lista[$key]['codigo']] = $lista[$key];
    }
    

    return $registro;
}

    public function DatosFacturaxxx ($clientev, $fechaInicial) {
        //      echo $fechaInicial;
        $VALORESFECHA = explode("/", $fechaInicial);
        $fechaInicial = $VALORESFECHA[2] . "-" . $VALORESFECHA[1] . "-" . $VALORESFECHA[0];
        $SUMAS = 0;
        $RESTAR = 0;
        $sumatorias = OperacionQuery::create()
                //  ->filterById(237, Criteria::GREATER_THAN)
                ->where("Operacion.Fecha < '" . $fechaInicial . " 01:01:01'")
                ->withColumn('sum(Operacion.ValorTotal)', 'TotalTotal')
                ->filterByEstatus('Anulado', Criteria::NOT_EQUAL)
                ->filterByClienteId($clientev)
                ->findOne();
        if ($sumatorias) {
            $SUMAS = $sumatorias->getTotalTotal();
        }
        // $listab[] ='CXC COBRAR';
        $listab[] = 'CONTRA ENTREGA';
        $listab[] = 'CONTRAENTREGA';
        $listab[] = 'CHEQUE PREFECHADO';
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
//        $SALDO = $SUMAS + $RESTAR;
        $notasCredito = NotaCreditoQuery::create()
                ->where("NotaCredito.Fecha < '" . $fechaInicial . " 01:01:01'")
                ->where("NotaCredito.Estatus  not like  '%Anul%'")
                ->filterByClienteId($clientev)
                ->find();
        $RESTAN = 0;
        foreach ($notasCredito as $nota) {
            $RESTAN = $RESTAN + ($nota->getValorTotal() - $nota->getValorPagado());
        }

        $SALDO = $SUMAS - $RESTAR - $RESTAN;

//        ECHO $SUMAS;
//        echo "<br>";
//        echo $RESTAR;
//        die();

        $operaciones = OperacionQuery::create()
                //        ->filterById(237, Criteria::GREATER_THAN)
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
        $data['sumasaldo'] = $saldoINcial;
        $data['codigo'] = "Saldo a la fecha";
        $data['fecha'] = $fechaInic;
        $data['cargo'] = 0;
        $data['abono'] = 0;
        $data['descripcion'] = '';
        $data['saldo'] = $saldoINcial;
        $lista[$Key] = $data;
        $listaKey[] = $Key;

        $listb[] = 0;

        foreach ($operaciones as $registr) {
            $listb[] = $registr->getCodigo();
            if (array_key_exists($registr->getCodigo(), $listb)) {
                
            } else {
                $saldoINcial = $saldoINcial + $registr->getValorTotal();
                $Key = $registr->getFecha('YmdHis') . "_P" . $registr->getId();
                $data['sumasaldo'] = 0;
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
                //   ->filterById(237, Criteria::GREATER_THAN)
                ->where("OperacionPago.FechaCreo >= '" . $fechaInicial . " 01:01:01'")
                //  ->filterByTipo('CXC COBRAR', Criteria::NOT_EQUAL)
                ->filterByTipo($listab, Criteria::NOT_IN)
                ->useOperacionQuery()
                ->filterByClienteId($clientev)
                ->endUse()
                ->find();
        foreach ($opeacionesPago as $pago) {
            $saldoINcial = $saldoINcial - $pago->getValor();
            $Key = $pago->getFechaCreo('YmdHis') . "_C" . "  -" . $pago->getId();
            $data['codigo'] = "RECIBO " . $pago->getCodigo() . "  -" . $pago->getId();
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

        $notasCredito = NotaCreditoQuery::create()
                ->where("NotaCredito.Fecha >= '" . $fechaInicial . " 01:01:01'")
                ->where("NotaCredito.Estatus  not like  '%Anul%'")
                ->filterByClienteId($clientev)
                ->find();

        foreach ($notasCredito as $nota) {
            $saldoINcial = $saldoINcial - ($nota->getValorTotal() - $nota->getValorPagado());
            $Key = $nota->getFecha('YmdHis') . "_N";
            $data['codigo'] = "NOTA CREDITO " . $nota->getCodigo() . "  -" . $nota->getId();
            $data['fecha'] = $nota->getFecha('d/m/Y H:i');
            $data['abono'] = $nota->getValorTotal() - $nota->getValorPagado();
            $data['cargo'] = 0;
            $data['saldo'] = $saldoINcial;
            $data['descripcion'] = $nota->getConcepto() . " Documento " . $nota->getDocumento();
            $lista[$Key] = $data;
            $listaKey[] = $Key;
        }
        sort($listaKey, SORT_NATURAL | SORT_FLAG_CASE);
        $registro = null;
        foreach ($listaKey as $listad) {
            $CODIGO = $lista[$listad]['codigo'];
            $registro[$CODIGO] = $lista[$listad];
        }




        return $registro;
    }

}
