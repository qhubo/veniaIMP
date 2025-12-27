<?php

/**
 * concilia_todo actions.
 *
 * @package    plan
 * @subpackage concilia_todo
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class concilia_todoActions extends sfActions {

    public function executePartida(sfWebRequest $request) {
        
         date_default_timezone_set("America/Guatemala");
      $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
         $fecha= $request->getParameter('fecha');
         $id= $request->getParameter('id');
         $this->fecha=$fecha;
         $this->id=$id;
        $bancoQ = BancoQuery::create()->findOneById($id);
        $saldoBancoQ = SaldoBancoQuery::create()
                ->filterByFecha($fecha)
                ->filterByBancoId($bancoQ->getId())
                ->findOne();
        $ceuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($bancoQ->getCuentaContable());
        $ceuentDi = CuentaErpContableQuery::create()->findOneByCuentaContable('6999-08');
        $diferencialCambiario = $saldoBancoQ->getDiferencial();
       
        $saldoLibro = $saldoBancoQ->getSaldoLibro();
        $saldoBanco = $saldoBancoQ->getSaldoBanco();
        if ($diferencialCambiario > 0) {
            $data = null;
            $data['cuenta'] = '6999-08';
            $data['detalle'] = $ceuentDi->getNombre();
            $data['debe'] = round($diferencialCambiario, 2);
            $data['haber'] = 0;
            $lista[] = $data;
            $data = null;
            $data['cuenta'] = $bancoQ->getCuentaContable();
            $data['detalle'] = $ceuentaQ->getNombre();
            $data['debe'] = 0;
            $data['haber'] = round($diferencialCambiario, 2);
            $lista[] = $data;
        }
        if ($diferencialCambiario < 0) {
            $diferencialCambiario = $diferencialCambiario * -1;
            $data = null;
            $data['cuenta'] = $bancoQ->getCuentaContable();
            $data['detalle'] = $ceuentaQ->getNombre();
            $data['debe'] = round($diferencialCambiario, 2);
            $data['haber'] = 0;
            $lista[] = $data;
            $data = null;
            $data['cuenta'] = '6999-08';
            $data['detalle'] = $ceuentDi->getNombre();
            $data['debe'] = 0;
            $data['haber'] = round($diferencialCambiario, 2);

            $lista[] = $data;
        }

        $this->partidaDetalle = $lista;
        $this->cuentasUno = CuentaErpContableQuery::create()->find();
        $this->cuentasDos = CuentaErpContableQuery::create()->find();
        $defaulta['fecha'] = date('d/m/Y');
        $valoresFe = explode("-", $fecha);
        $defaulta['fecha'] =$valoresFe[2]."/".$valoresFe[1]."/".$valoresFe[0];
        $defaulta['detalle'] = "DIFERENCIAL CAMBIARIO " .$bancoQ->getNombre()." ".$saldoBancoQ->getFecha('M') . $saldoBancoQ->getFecha('Y');
        $defaulta['numero'] = 'DICA' . $saldoBancoQ->getFecha('m') . $saldoBancoQ->getFecha('Y').$saldoBancoQ->getBancoId();

        $this->form = new CreaPartidaActivoForm($defaulta);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();

                $numero = $valores['numero'];
                $fechaInicio = $valores['fecha'];
                $fechaInicio = explode('/', $fechaInicio);
                $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
                $partida = PartidaQuery::create()->findOneByCodigo($numero);
                if (!$partida) {
                    $partida = new Partida();
                }
                $partida->setEstatus('Confirmado');
                $partida->setFechaContable($fechaInicio);
                $partida->setTipo($valores['detalle']);
                $partida->setCodigo($numero);
                $partida->setNumero($numero);
                $partida->setUsuario($usuarioQ->getUsuario());
                $partida->save();

                $total = 0;
                $cont = 0;
                if ($partida) {
                    $partidaDetlle = PartidaDetalleQuery::create()->filterByPartidaId($partida->getId())->find();
                    if ($partidaDetlle) {
                        $partidaDetlle->delete();
                    }
                }
                foreach ($this->partidaDetalle as $reg) {
                    $cont++;

                    $cuentaId = $request->getParameter('cuenta' . $cont);
                    $debe = $reg['debe'];
                    $haber = $reg['haber'];
                    $total = $debe + $total;
                    $cuentaEr = CuentaErpContableQuery::create()->findOneByCuentaContable($cuentaId);

                    $paridaDe = new PartidaDetalle();
                    $paridaDe->setCuentaContable($cuentaEr->getCuentaContable());
                    $paridaDe->setDebe($debe);
                    $paridaDe->setHaber($haber);
                    $paridaDe->setDetalle($cuentaEr->getNombre());
                    $paridaDe->setPartidaId($partida->getId());
                    $paridaDe->save();
                }


                $partida->setValor($total);
                $partida->setConfirmada(true);
                $partida->save();
                $this->getUser()->setFlash('exito', 'Partida cerrada con exito ');
                $this->redirect('concilia_todo/index');

                //  die();
            }
        }
    }

    public function executeReporteEx(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $this->fecha = date('d/m/Y');
        $fechaFin = explode('/', $this->fecha);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        if ($request->getParameter('fecha')) {
            $fechaFin = $request->getParameter('fecha');
        }
        $dia = $fechaFin;
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $empresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $nombreEMpresa = $empresaQ->getNombre();
        $pestanas[] = "Conciliacion " . $dia;
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
//        $logoFile = $EmpresaQuery->getLogo();
        $filename = "Conciliacion_" . $nombreEMpresa . str_replace("-", "_", $dia);
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreEMpresa, $pestanas, $pestanas[0]);
        $hoja = $xl->setActiveSheetIndex(0);
        //CABECERA  Y FILTRO        
        $hoja->getRowDimension('1')->setRowHeight(15);
        $hoja->getRowDimension('2')->setRowHeight(20);
        $hoja->mergeCells("A1:A2");
        $logoFile = $empresaQ->getLogo();
        $obj = new PHPExcel_Worksheet_Drawing();
        $obj->setName("Logo");
        $obj->setDescription("Logo");
        $obj->setPath("./uploads/images/" . $logoFile);
        $obj->setCoordinates("A1");
        $obj->setHeight(48);
        $obj->setWorksheet($hoja);
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit(strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(13);
        $hoja->mergeCells("B1:E1");
        $hoja->getCell("B2")->setValueExplicit("Reporte", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B2")->getFont()->setBold(true);
        $hoja->getStyle("B2")->getFont()->setSize(10);
        $hoja->getCell("C2")->setValueExplicit("Conciliacion Bancaria ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C2")->getFont()->setSize(11);
        $hoja->getStyle('C2')->getAlignment()->setWrapText(true);
        $hoja->mergeCells("C2:E2");
        $fila = 3;
        $columna = 0;
        $encabezados = null;
        $Bancos = BancoQuery::create()->orderByNombre("Asc")
                ->find();
        //               ->filterByActivo(true)->find();

        $encabezados[] = array("Nombre" => strtoupper("Concepto"), "width" => 34, "align" => "center", "format" => "@");
        foreach ($Bancos as $banco) {
            $encabezados[] = array("Nombre" => strtoupper($banco->getNombre()), "width" => 22, "align" => "rigth", "format" => "#,##0.00");
        }
//        $encabezados[] = array("Nombre" => strtoupper("Usuario"), "width" => 15, "align" => "center", "format" => "@");
//        $encabezados[] = array("Nombre" => strtoupper("Updated"), "width" => 15, "align" => "center", "format" => "@");


        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

        $hoja->getCell("A4")->setValueExplicit("SALDO EN LIBROS", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getCell("A5")->setValueExplicit("SALDO EN BANCO", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getCell("A6")->setValueExplicit("DEPOSITOS EN TRÁNSITO", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getCell("A7")->setValueExplicit("NOTAS DE CREDITO EN TRÁNSITO", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getCell("A8")->setValueExplicit("CHEQUES EN CIRCULACIÓN", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getCell("A9")->setValueExplicit("NOTAS DE DÉBITO EN TRANSITO", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getCell("A10")->setValueExplicit("SALDO CONCILIADO", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getCell("A11")->setValueExplicit("DIFERENCIA", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getCell("A14")->setValueExplicit("Libro Mayor", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getCell("A12")->setValueExplicit("Usuario", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getCell("A13")->setValueExplicit("Updated", PHPExcel_Cell_DataType::TYPE_STRING);

        $fechaFin = explode('-', $dia);
        $fechaFin = $fechaFin[2] . '/' . $fechaFin[1] . '/' . $fechaFin[0];
        $hoja->getCell("F2")->setValueExplicit($fechaFin, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("F2")->getFont()->setSize(12);
        $data[1] = "A";
        $data[2] = "B";
        $data[3] = "C";
        $data[4] = "D";
        $data[5] = "E";
        $data[6] = "F";
        $data[7] = "G";
        $data[8] = "H";
        $data[9] = "I";
        $data[10] = "J";
        $data[11] = "K";
        $line = 1;
        foreach ($Bancos as $banco) {
            $valor = $banco->getHsaldoBanco($dia);
            $ValorBanco = $banco->getHsaldoConciliado($dia);
            $retorna = $banco->getHDiferencia($dia);
            $line++;
            $diaLibro = $fecha = date("Y-m-d", strtotime($dia . "+ 1 days"));
            ;
            $libroMayor = CuentaErpContablePeer::getSaldoFecha($diaLibro, $banco->getCuentaContable());
            ;
            $usuari = '';
            $updated = '';
            $bancosaldo = SaldoBancoQuery::create()
                    ->filterByBancoId($banco->getId())
                    ->filterByFecha($dia)
                    ->findOne();
            if ($bancosaldo) {
                $usuari = $bancosaldo->getUsuario();
                $updated = $bancosaldo->getUpdatedAt('d/m/y H:i:s');
            }

            $letra = $data[$line];
            $hoja->getCell($letra . "4")->setValueExplicit($banco->getHSaldoLibros($dia), PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $hoja->getCell($letra . "5")->setValueExplicit(abs($valor), PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $hoja->getCell($letra . "6")->setValueExplicit(abs($banco->getHDepositoTransito($dia)), PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $hoja->getCell($letra . "7")->setValueExplicit(abs($banco->getHNotasCreditoTransito($dia)), PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $hoja->getCell($letra . "8")->setValueExplicit(abs($banco->getHNotasChequesCircula($dia)), PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $hoja->getCell($letra . "9")->setValueExplicit(abs($banco->getHNotasDebitoTransito($dia)), PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $hoja->getCell($letra . "10")->setValueExplicit(abs($ValorBanco), PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $hoja->getCell($letra . "11")->setValueExplicit(abs($retorna), PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $hoja->getCell($letra . "14")->setValueExplicit($libroMayor, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $hoja->getCell($letra . "12")->setValueExplicit($usuari, PHPExcel_Cell_DataType::TYPE_STRING);
            $hoja->getCell($letra . "13")->setValueExplicit($updated, PHPExcel_Cell_DataType::TYPE_STRING);
            $hoja->getStyle($letra . "12")->getFont()->setBold(true);
            $hoja->getStyle($letra . "13")->getFont()->setBold(true);

            $hoja->getStyle($letra . "4")->getFont()->setSize(10);
            $hoja->getStyle($letra . "5")->getFont()->setSize(10);
            $hoja->getStyle($letra . "6")->getFont()->setSize(10);
            $hoja->getStyle($letra . "7")->getFont()->setSize(10);
            $hoja->getStyle($letra . "8")->getFont()->setSize(10);
            $hoja->getStyle($letra . "9")->getFont()->setSize(10);
            $hoja->getStyle($letra . "10")->getFont()->setSize(10);
            $hoja->getStyle($letra . "11")->getFont()->setSize(10);
            $hoja->getStyle($letra . "14")->getFont()->setSize(10);
        }



        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeReporte(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $this->fecha = date('d/m/Y');
        $fechaFin = explode('/', $this->fecha);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        if ($request->getParameter('fecha')) {
            $fechaFin = $request->getParameter('fecha');
        }

        $dia = $fechaFin;
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $titulo = 'Conciliación Bancaria';
        $referencia = '';
        $empresa = EmpresaQuery::create()->findOneById($empresaId);
        $logo = $empresa->getLogo();
        $tasa = TasaCambio::TasaPromedio();
        $img_file = "uploads/images/" . $logo;
//          echo $img_file;
//          die();
        $observaciones = " "; //. $ordenCompra->getTipoDocumento()." ".$ordenCompra->getDocumento()."";
        $nombre2 = ' ';
        $html = $this->getPartial('reporte/encabezado', array('nombre2' => $nombre2, 'logo' => $logo, 'titulo' => $titulo, 'observaciones' => $observaciones, 'referencia' => $referencia));
        $Bancos = BancoQuery::create()
                        ->orderByNombre("Asc")
                        ->filterByActivo(true)->find();
        $html = '';
        $html .= $this->getPartial('concilia_todo/vistaReporte', array('bancos' => $Bancos, "tasa" => $tasa,
            "imagen" => $logo, 'dia' => $dia));
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle(" Concilia Banco");
        $pdf->SetSubject('Concilia Banco');
        $pdf->SetKeywords('Concilia,Banco,Cuenta'); // set default header data
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
        $pdf->writeHTML($html);
        $pdf->Output('Conciliacion Bancaria' . '.pdf', 'I');
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $Id = $request->getParameter('id');
        $this->fecha = date('d/m/Y');
        if ($request->getParameter('fecha')) {
            $this->fecha = $request->getParameter('fecha');
        }
        $fechaFin = explode('/', $this->fecha);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

        $this->dia = $fechaFin;
        if ($Id) {
            $this->bancos = BancoQuery::create()
                    ->orderByNombre("Asc")
                    ->filterById($Id)
                    ->find();
        } else {
            $this->bancos = BancoQuery::create()
                    ->orderByNombre("Asc")
                    ->find();
        }

        $proceso = TasaCambio::Tasas();

        $tasaQ = TasaCambioQuery::create()->findOneByFecha($this->dia);
        if (!$tasaQ) {
            $tasaQ = TasaCambioQuery::create()
                    ->where("TasaCambio.Fecha < '" . $this->dia . "'")
                    ->findOne();
        }
        if ($tasaQ) {
            $this->tasa = $tasaQ->getValor();
        }
        $sleecion = sfContext::getInstance()->getUser()->getAttribute('seleccionBan', 0, 'seguridad');
        if (!$sleecion) {
            foreach ($this->bancos as $banco) {
                $movimientosBancos = MovimientoBancoQuery::create()->filterByBancoId($banco->getId())->count();
                sfContext::getInstance()->getUser()->setAttribute('selecBa' . $banco->getId(), 0, 'seguridad');
                if ($movimientosBancos) {
                    sfContext::getInstance()->getUser()->setAttribute('selecBa' . $banco->getId(), 1, 'seguridad');
                }
            }
        }
    }

    public function executeCheck(sfWebRequest $request) {
        $id = $request->getParameter('id');
        sfContext::getInstance()->getUser()->setAttribute('selecBa' . $id, 1, 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('seleccionBan', '1', 'seguridad');
        echo "aqui";
        die();
    }

    public function executeUncheck(sfWebRequest $request) {
        $id = $request->getParameter('id');
        sfContext::getInstance()->getUser()->setAttribute('selecBa' . $id, 0, 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('seleccionBan', '1', 'seguridad');

        echo "aqui bbb";
        die();
    }

}
