<?php

/**
 * reporte actions.
 *
 * @package    plan
 * @subpackage reporte
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporteActions extends sfActions {

    public function executeConciliaBanco(sfWebRequest $request) {
        $BancoId = $request->getParameter('bancoId');
        date_default_timezone_set("America/Guatemala");
        $fecha = date('d/m/Y');
        if ($request->getParameter('fecha')) {
            $fecha = $request->getParameter('fecha');
        }
        $fechaInicio = explode('/', $fecha);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];

        $Banco = BancoQuery::create()->findOneById($BancoId);
        $logo = $Banco->getEmpresa()->getLogo();
        $titulo = 'Conciliación Bancaria ' . $fecha;
        $referencia = $Banco->getCuentaContable();
        $observaciones = " "; //. $ordenCompra->getTipoDocumento()." ".$ordenCompra->getDocumento()."";
        $nombre2 = ' ';
        $html = '';
        $html = $this->getPartial('reporte/encabezadob', array("fecha" => $fecha, 'nombre2' => $nombre2, 'logo' => $logo, 'titulo' => $titulo, 'observaciones' => $observaciones, 'referencia' => $referencia));
        $html .= $this->getPartial('concilia_banco/vistaReporte', array('banco' => $Banco, "dia" => $fechaInicio));

//        echo $fechaInicio;
//        echo "<br>";
//        echo $html;
//        die();
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
        $pdf->Output('Conciliacion ' . $Banco->getCuentaContable() . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeCheque(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $cheque = ChequeQuery::create()->findOneById($id);
        $margen = 3;

        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle("Cheque " . $cheque->getNumero());
        $pdf->SetSubject('Cheque, banco, pago');
        $pdf->SetKeywords('Cheque,banco, pago'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
//        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetMargins(3, $margen, 0, true);

//        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
//        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetHeaderMargin(0.0);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont('dejavusans', '', 9);
        $pdf->AddPage();

        $numberToLetterConverter = new NumberToLetterConverter();
        $valor = $cheque->getValor();
        $valor = Parametro::formato($valor, false);
        $valor = str_replace(",", "", $valor);
        $totalImprime = str_replace(".", ",", $valor);
        $partida = 0;
        $devolucion = OrdenDevolucionQuery::create()->findOneById($cheque->getOrdenDevolucionId());
        if ($devolucion) {
            if ($devolucion->getPartidaNo()) {
                $partida = $devolucion->getPartidaNo();
            }
        }

        $soli = SolicitudChequeQuery::create()->findOneById($cheque->getSolicitudChequeId());
        if ($soli) {
            if ($soli->getPartidaNo()) {
                $partida = $soli->getPartidaNo();
            }
        }
        $totalImprime = $numberToLetterConverter->to_word($totalImprime, $miMoneda = null);
        $valoresImprime = explode("CON", $totalImprime);
        if (count($valoresImprime) > 1) {
            $totalImprime = str_replace("CON", " QUETZALES  CON ", $totalImprime) . " CENTAVOS ";
        } else {
            $totalImprime .= " EXACTOS ";
        }
        $totalImprime = "**" . $totalImprime . "**";
        $html = $this->getPartial('reporte/cheque', array('cheque' => $cheque, 'valorLetras' => $totalImprime, 'partida' => $partida));

//        echo $totalImprime;
//        echo "<br><br>";
//        $html = str_replace("%FECHA%",  "Guatemala ".$cheque->getFechaCreo('d/m/Y'), $html);
//        $html = str_replace("%CORRELATIVO%", $cheque->getNumero(), $html);
//        $html = str_replace("%BENEFICIARIO%", $cheque->getBeneficiario(), $html);
//        $html = str_replace("%VALOR%", Parametro::formato($cheque->getValor()), $html);
//        
//        $html = str_replace("%VALOR_LETRAS%", $numberToLetterConverter->to_word($totalImprime, $miMoneda = null), $html);
//        $html = str_replace("%MOTIVO%", "<font size='-2'>" . strtoupper($cheque->getMotivo()) . "<font>", $html);
//        if ($cheque->getNegociable()) {
//            $html = str_replace("%NEGOCIABLE%", "<font size='-2'></font> ", $html);
//        } else {
//            $html = str_replace("%NEGOCIABLE%", "<font size='-2'>No Negociable</font> ", $html);
//        }
//        echo $html;
//        die();

        $pdf->writeHTML($html);
        $pdf->Output("Cheque " . $cheque->getNumero() . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeGasto(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $token = $request->getParameter('token');
        $ordenCompra = GastoQuery::create()->findOneByToken($token);
        $lista = GastoDetalleQuery::create()
                ->filterByGastoId($ordenCompra->getId())
                ->find();

        $logo = $ordenCompra->getEmpresa()->getLogo();
        $titulo = 'GASTO';
        $referencia = $ordenCompra->getCodigo();
        $observaciones = " "; //. $ordenCompra->getTipoDocumento()." ".$ordenCompra->getDocumento()."";
        $nombre2 = ' ';
        $html = $this->getPartial('reporte/encabezado', array('nombre2' => $nombre2, 'logo' => $logo, 'titulo' => $titulo, 'observaciones' => $observaciones, 'referencia' => $referencia));
        $html .= $this->getPartial('reporte/gasto', array('orden' => $ordenCompra, 'lista' => $lista));

//        echo $html;
//        die();
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle($titulo . " " . $referencia);
        $pdf->SetSubject('Documento Gasto');
        $pdf->SetKeywords('Documento,Gasto,Cuenta'); // set default header data
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
        $pdf->Output('OrdenGasto' . $ordenCompra->getCodigo() . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeOrdenCotizacion(sfWebRequest $request) {
                date_default_timezone_set("America/Guatemala");
        error_reporting(-1);
        $token = $request->getParameter('token');
        $ordenCompra = OrdenCotizacionQuery::create()->findOneByToken($token);
        $lista = OrdenCotizacionDetalleQuery::create()
                ->filterByCantidad(0,Criteria::GREATER_THAN )

                ->filterByOrdenCotizacionId($ordenCompra->getId())
                ->find();

        $logo = $ordenCompra->getEmpresa()->getLogo();
               $EMPRESAnit= EmpresaQuery::create()->findOneByTelefono($ordenCompra->getTienda()->getNit());
               if ($EMPRESAnit) {
                           $logo = $EMPRESAnit->getLogo();
               }
        
        $titulo = 'COTIZACIÓN';
        if (strtoupper($ordenCompra->getEstatus()) == "AUTORIZADO") {
            $titulo = 'VENTA';
        }
        if (strtoupper($ordenCompra->getEstatus()) == "CONFIRMADA") {
            $titulo = 'VENTA';
        }

        $referencia = $ordenCompra->getCodigo();
        $observaciones = " "; //  $ordenCompra->getSerie()." ".$ordenCompra->getNoDocumento()."";
        $nombre2 = ' ';
        $html = $this->getPartial('reporte/encabezado', array('nombre2' => $nombre2, 'logo' => $logo, 'titulo' => $titulo, 'observaciones' => $observaciones, 'referencia' => $referencia));

        $html .= $this->getPartial('reporte/ordenCotizacion', array('orden' => $ordenCompra, 'lista' => $lista));
        $img_file = "images/enProceso.png";
        if (strtoupper($ordenCompra->getEstatus()) == "AUTORIZADO")
        {
            $img_file = "images/autorizado.png";
        }
//        echo $html;
//        die();
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle($titulo . " " . $referencia);
        $pdf->SetSubject('Documento Orden Compra');
        $pdf->SetKeywords('Documento,Orden,Cuenta'); // set default header data
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
        // $pdf->Image($img_file, 140, 5, 50, '', '', '', '300', false, 0);
        $pdf->writeHTML($html);
        $pdf->Output('cotizacion ' . $ordenCompra->getCodigo() . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeOrdenCompra(sfWebRequest $request) {
                date_default_timezone_set("America/Guatemala");
        error_reporting(-1);
        $token = $request->getParameter('token');
        $ordenCompra = OrdenProveedorQuery::create()->findOneByToken($token);
        $lista = OrdenProveedorDetalleQuery::create()
                ->filterByOrdenProveedorId($ordenCompra->getId())
                ->find();

        $logo = $ordenCompra->getEmpresa()->getLogo();
        $titulo = 'ORDEN DE  COMPRA';
        $referencia = $ordenCompra->getCodigo();
        $observaciones = " " . $ordenCompra->getSerie() . " " . $ordenCompra->getNoDocumento() . "";
        $nombre2 = 'Documento';
        $html = $this->getPartial('reporte/encabezado', array('nombre2' => $nombre2, 'logo' => $logo, 'titulo' => $titulo, 'observaciones' => $observaciones, 'referencia' => $referencia));
        $html .= $this->getPartial('reporte/orden', array('orden' => $ordenCompra, 'lista' => $lista));

//        echo $html;
//        die();
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");

        $img_file = "images/enProceso.png";
        if (strtoupper($ordenCompra->getEstatus()) == "AUTORIZADO") {
            $img_file = "images/autorizado.png";
        }

        // Render the image
        //      $pdf->Image($img_file, 0, 0, 223, 280, '', '', '', false, 300, '', false, false, 0);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle($titulo . " " . $referencia);
        $pdf->SetSubject('Documento Orden Compra');
        $pdf->SetKeywords('Documento,Orden,Cuenta'); // set default header data
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
        $pdf->Image($img_file, 140, 5, 50, '', '', '', '300', false, 0);
        $pdf->writeHTML($html);

        $pdf->Output('OrdenCompra' . $ordenCompra->getCodigo() . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeCuenta(sfWebRequest $request) {
        $viviendaId = $request->getParameter('id');
        $vivviendaQ = ViviendaQuery::create()->findOneById($viviendaId);
        $em = 1;
        if ($request->getParameter('em')) {
            $em = $request->getParameter('em');
        }
        if ($em == 1) {
            $observaciones = '** MES ACTUAL **';
            $cuenta = CuentaViviendaQuery::create()
                    ->filterByMes(date('m'))
                    ->filterByAnio(date('Y'))
                    ->filterByViviendaId($viviendaId)
                    ->withColumn("Date_format(CuentaVivienda.Fecha,'%Y%m%d')", 'MesF')
                    ->orderByMesF('Desc')
                    ->find();
        }
        if ($em == 2) {
            $observaciones = '** VENCIDOS **';
            $cuenta = CuentaViviendaQuery::create()
                    ->filterByPagado(false)
                    ->filterByViviendaId($viviendaId)
                    ->orderByFechaPago("Desc")
                    ->orderByFecha("Desc")
                    ->where("CuentaVivienda.Fecha <= '" . date('Y-m-d') . "'")
                    ->withColumn("Date_format(CuentaVivienda.Fecha,'%Y%m%d')", 'MesF')
                    ->orderByMesF('Desc')
                    ->find();
        }
        if ($em == 3) {
            $observaciones = '** TODOS **';
            $cuenta = CuentaViviendaQuery::create()
                    ->filterByViviendaId($viviendaId)
                    //    ->orderBy("CuentaVivienda.Fecha")
                    ->withColumn("Date_format(CuentaVivienda.Fecha,'%Y%m%d')", 'MesF')
                    ->orderByMesF('Desc')
                    ->find();
        }

        $logo = $vivviendaQ->getEmpresa()->getLogo();
        $titulo = 'ESTADO DE CUENTA';
        $referencia = $vivviendaQ->getCodigo();

        $html = $this->getPartial('reporte/encabezado', array('logo' => $logo, 'titulo' => $titulo, 'observaciones' => $observaciones, 'referencia' => $referencia));

        $html .= $this->getPartial('reporte/cuenta', array('cuenta' => $cuenta, 'vivienda' => $vivviendaQ,
        ));

        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle($titulo . " " . $referencia);
        $pdf->SetSubject('Cobros Pago vivienda');
        $pdf->SetKeywords('Cobros , Pagos, vivienda'); // set default header data
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
        $pdf->Output('EstadoCuenta.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeCorteCaja(sfWebRequest $request) {
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsulta', null, 'consulta'));
        date_default_timezone_set("America/Guatemala");
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $empresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $logo = $empresaQ->getLogo();
        $titulo = 'CORTE DE CAJA';
        $referencia = "";
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '01:00';
        $valores['fin'] = '23:00';
        $operaciones = OperacionQuery::create()
                ->where("Operacion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("Operacion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->find();
        $todos = OperacionQuery::create()
                ->where("Operacion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("Operacion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
//                ->filterByBodegaId($bodegaId)
//                ->where("day(Operacion.Fecha)=" . $dia)
//                ->where("month(Operacion.Fecha)=" . $mes)
//                 ->where("year(Operacion.Fecha)=" . $ano) 
                ->withColumn('sum(Operacion.ValorTotal)', 'TotalGeneral')
                ->findOne();
        $TotalCompras = $todos->getTotalGeneral();
        $operacionPago = OperacionPagoQuery::create()
                ->useOperacionQuery()
                ->where("Operacion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("Operacion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->endUse()
                ->withColumn('count(OperacionPago.Id)', 'Cantidad')
                ->withColumn('sum(OperacionPago.Valor)', 'ValorTotal')
                ->groupByTipo()
                ->find();
        $defa = null;
        $operaiconDetalle = OperacionDetalleQuery::create()
                ->useCuentaViviendaQuery()
                ->endUse()
                //   ->filterByOperacionId($lista, Criteria::IN)
                ->useOperacionQuery()
                ->where("Operacion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("Operacion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->endUse()
                ->withColumn('sum(OperacionDetalle.Cantidad)', 'TotalCantidad')
                ->withColumn('sum(OperacionDetalle.ValorTotal)', 'TotalValor')
                ->groupBy('CuentaVivienda.ServicioId')
                ->filterByValorTotal(0, Criteria::GREATER_THAN)
                ->find();
        $detalle = $operaiconDetalle;

        $observaciones = $valores['fechaInicio'] . " AL " . $valores['fechaFin'];
        $html = $this->getPartial('reporte/encabezado', array('logo' => $logo, 'titulo' => $titulo, 'observaciones' => $observaciones, 'referencia' => ''));

        $html .= $this->getPartial('reporte/cortelistado', array('operaciones' => $operaciones,
            'operacionPago' => $operacionPago, 'detalle' => $detalle
        ));

        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle($titulo . " " . $referencia);
        $pdf->SetSubject('Cobros Pago vivienda');
        $pdf->SetKeywords('Cobros , Pagos, vivienda'); // set default header data
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
        $pdf->Output('EstadoCuenta.pdf', 'I');
        die();
        echo $html;
        die();
    }

}
