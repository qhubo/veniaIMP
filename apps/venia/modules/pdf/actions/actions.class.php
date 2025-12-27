<?php

/**
 * pdf actions.
 *
 * @package    plan
 
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pdfActions extends sfActions {

    public function executeFactura(sfWebRequest $request) {
        error_reporting(-1);

        date_default_timezone_set("America/Guatemala");
        $tok = $request->getParameter('tok');
        $descarga = $request->getParameter('descarga');
        $operacion = OperacionQuery::create()->findOneByCodigo($tok);

        $EMPRESAnit = EmpresaQuery::create()->findOneByTelefono($operacion->getTienda()->getNit());

        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuario = UsuarioQuery::create()->findOneById($usuarioId);
        $logo = $usuario->getEmpresa()->getLogo();
        if ($EMPRESAnit) {
            $logo = $EMPRESAnit->getLogo();
        }
        $urlImage = 'uploads/images/' . $logo;
        $ReporTUsuario = UsuarioReportQuery::create()->findOne();
        $nombreE = rtrim(str_replace(" ", "", $operacion->getEmpresa()->getNombre()));

        if ($EMPRESAnit) {
            $nombreE = rtrim(str_replace(" ", "", $EMPRESAnit->getNombre()));
        }

        $nombreE = substr($nombreE, 0, 18);
//        echo $nombreE;
//        die();

        $orientacion = $ReporTUsuario->getOrientacion();
        $fuente = $ReporTUsuario->getTipoLetra();
        $tamanoPapel = $ReporTUsuario->getPapel();
        $PosicionLogo = $ReporTUsuario->getLogoPosicion();
        $tamanoLogo = $ReporTUsuario->getLogoTamanio();
        $UNA_LINEA = $ReporTUsuario->getUnaLinea();
        $tipoBorder = $ReporTUsuario->getTipoTabla();
        $colorBorder = $ReporTUsuario->getBorderColor();
        $fondoEncabezado = $ReporTUsuario->getFondoColorEncabezado();
        $fondoDetalle = $ReporTUsuario->getFondoColorDetalle();
        $Titulo_no = $ReporTUsuario->getLetraTituloNo() + 18;  //7;
        $Titulo_Color = $ReporTUsuario->getLetraTituloColor();  //'#000000';
        $Titulo_Bold = $ReporTUsuario->getLetraTituloBold();  //true;
        $linea_no = $ReporTUsuario->getLetraDetalleNo() + 15;  //7;
        $linea_Color = $ReporTUsuario->getLetraDetalleColor();  //'#000000';
        $linea_Bold = $ReporTUsuario->getLetraDetalleBold();  //false;
        $tipoMarcaAgua = $ReporTUsuario->getMarcaAgua();
        $fondo = "";
        $return = UsuarioReport::PDefault($tamanoPapel, $orientacion, $PosicionLogo, $UNA_LINEA, $tamanoLogo);
        $altoTotal = $return['altoTotal'];
        $medidas = $return['medidas'];
        $ocultaLogo = $return['ocultaLogo'];
        $maxAncho = $return['maxAncho'];
        $maxAlto = $return['maxAlto'];
        $pos = $return['pos'];
        $y = $return['y'];
        $x = $return['x'];
        $valoresDefault = UsuarioReport::PValoresDefault($operacion, $nombreE);
        $valoresDefault['TIPO_PAGO'] = 'CONTADO';
        
        $estauts = strtoupper(trim(str_replace(" ","", trim($operacion->getEstatus()))));
        if ($estauts=="CUENTACOBRAR") {
              $valoresDefault['TIPO_PAGO'] = 'CREDITO';
        }
                
        $MEDIOpAGO = OperacionPagoQuery::create()->findOneByOperacionId($operacion->getId());
        if ($MEDIOpAGO) {
            $tipo = $MEDIOpAGO->getTipo();
            if ($tipo == 'CXC COBRAR') {
                $tipo = 'CREDITO';
            }
            $valoresDefault['TIPO_PAGO'] = $tipo;
        }

        $valoresDefault['VENDEDOR'] = $operacion->getUsuario();
        if ($operacion->getVendedorId()) {
            $valoresDefault['VENDEDOR'] = $operacion->getVendedor()->getNombre();
        }

 
        $valoresDefault['CLIENTE'] = '';
        if ($operacion->getCliente()) {
            if ($operacion->getCliente()->getCodigo() != "CONTRAENTREGA") {
                if ($operacion->getCliente()->getCodigo() != "CONTRA ENTREGA") {
                    $valoresDefault['CLIENTE'] = $operacion->getCliente()->getCodigo();
                }
            }
        }
        $valoresDefault['REFERENCIA'] = $operacion->getCodigo();
        $valoresDefault['OBSERVACIONES'] = $operacion->getObservaciones();
        $diacre = "";
        $valoresDefault['CODIGO_CLIENTE'] = '';
        if ($operacion->getClienteId()) {
            if ($operacion->getCliente()->getDiasCredito()) {
                $diacre = "<strong>Dias Credito</strong> " . $operacion->getCliente()->getDiasCredito();
            }
            $valoresDefault['CODIGO_CLIENTE'] = $operacion->getCliente()->getCodigo() . " " . $diacre;
        }

        if ($operacion->getClienteId()) {
            if ($operacion->getCliente()->getCodigo() == "CONTRAENTREGA") {
                $valoresDefault['CODIGO_CLIENTE'] = '';
            }
            if ($operacion->getCliente()->getCodigo() == "CONTRA ENTREGA") {
                $valoresDefault['CODIGO_CLIENTE'] = '';
            }
        }

        $valoresDefault['TRANSPORTE'] = '';
        $cotizacion = OrdenCotizacionQuery::create()->findOneByCodigo($operacion->getCodigo());
        if ($cotizacion) {
            $valorUsuario = ValorUsuarioQuery::create()->filterByNoDocumento($cotizacion->getId())->filterByNombreCampo('TRANSPORTE')->findOne();
            if ($valorUsuario) {
                $valoresDefault['TRANSPORTE'] = $valorUsuario->getValor();
            }
        }
        $valoresDefault['IVA'] = $operacion->getIva();
        $valoresDefault['IMPUESTO_HOTEL'] = $operacion->getImpuestoHotel();
//        $valoresDefault['Certificacion']['NumeroAutorizacion']='469183BE-C3EF-4E3F-857D-2C936D037656';
//        $valoresDefault['CertificacionF']['Serie']='FAA5A4ASD4';
//        $valoresDefault['CertificacionF']['Numero']='1235455';
        //  $valoresDefault['GENERALES']['Tipo']='Fact Cambiaria';
        if ($operacion->getFaceEstado() == "FIRMADONOTA") {
            $valoresDefault['GENERALES']['Tipo'] = "Nota de Crédito";
        }
        $setear = false;
        if (($tamanoPapel == 'Letter') && ($orientacion == 'P')) {
            $setear = true;
        }
        $valoresDefault['GENERALES']['FechaFactura'] = $operacion->getFecha('d/m/Y');
        $orientacionT = $orientacion;
        $tamanoPapelT = $tamanoPapel;
        if ($tamanoPapel == 'A5H') {
            $tamanoPapelT = 'A5';
            $orientacionT = 'L';
        }
        if ($tamanoPapel == 'A5V') {
            $tamanoPapelT = 'A5';
            $orientacionT = 'P';
        }

        if (!$medidas) {
            $pdf = new TCPDF($orientacionT, "mm", $tamanoPapelT);
        }
        if ($medidas) {
            $pdf = new TCPDF('P', 'mm', $medidas, true, 'UTF-8', false);
        }
//        echo $tamanoPapel;
//        die();
//       if ($nombreE=="IMPORTADORAINFINIT") {
        $html = $this->getPartial('pdf/encabezadoIN', array(
            'ancho' => $maxAncho, 'tamanoPapel' => $tamanoPapel,
            'pos' => $pos, "wlogo" => $tamanoLogo, "PosicionLogo" => $PosicionLogo, 'UNA_LINEA' => $UNA_LINEA,
            'Titulo_no' => $Titulo_no, 'Titulo_Color' => $Titulo_Color, 'Titulo_Bold' => $Titulo_Bold,
            'linea_no' => $linea_no, 'linea_Color' => $linea_Color, 'linea_Bold' => $linea_Bold,
            'urlImage' => $urlImage, 'valoresDefault' => $valoresDefault,
            'maxAncho' => $maxAncho, 'maxAlto' => $maxAlto
        ));
//       } else {
//                   $html = $this->getPartial('pdf/encabezado', array(
//            'ancho' => $maxAncho, 'tamanoPapel' => $tamanoPapel,
//            'pos' => $pos, "wlogo" => $tamanoLogo, "PosicionLogo" => $PosicionLogo, 'UNA_LINEA' => $UNA_LINEA,
//            'Titulo_no' => $Titulo_no, 'Titulo_Color' => $Titulo_Color, 'Titulo_Bold' => $Titulo_Bold,
//            'linea_no' => $linea_no, 'linea_Color' => $linea_Color, 'linea_Bold' => $linea_Bold,
//            'urlImage' => $urlImage, 'valoresDefault' => $valoresDefault,
//            'maxAncho' => $maxAncho, 'maxAlto' => $maxAlto
//        ));
//       }
// if ($nombreE=="IMPORTADORAINFINIT") {
        $tipoBorder = "";
        $html .= $this->getPartial('pdf/infinity', array(
            'fondoEncabezado' => $fondoEncabezado, 'fondoDetalle' => $fondoDetalle,
            'colorBorder' => $colorBorder, 'Titulo_no' => $Titulo_no, 'Titulo_Color' => $Titulo_Color, 'Titulo_Bold' => $Titulo_Bold,
            'linea_no' => $linea_no, 'linea_Color' => $linea_Color, 'UNA_LINEA' => $UNA_LINEA,
            'linea_Bold' => $linea_Bold, 'valoresDefault' => $valoresDefault, 'ancho' => $maxAncho,
            'setear' => $setear
        ));

        //     }

        if ($tipoBorder == 'Todos-Bordes') {
            // $html .="aaaaaaaaaaaaaaaa<hr>";
            $html .= $this->getPartial('pdf/todos_bordes', array(
                'fondoEncabezado' => $fondoEncabezado, 'fondoDetalle' => $fondoDetalle,
                'colorBorder' => $colorBorder, 'Titulo_no' => $Titulo_no, 'Titulo_Color' => $Titulo_Color, 'Titulo_Bold' => $Titulo_Bold,
                'linea_no' => $linea_no, 'linea_Color' => $linea_Color, 'UNA_LINEA' => $UNA_LINEA,
                'linea_Bold' => $linea_Bold, 'valoresDefault' => $valoresDefault, 'ancho' => $maxAncho,
                'setear' => $setear
            ));
        }
        if ($tipoBorder == 'Border-Exterior') {
            $html .= $this->getPartial('pdf/border_exterior', array(
                'fondoEncabezado' => $fondoEncabezado, 'fondoDetalle' => $fondoDetalle,
                'colorBorder' => $colorBorder, 'Titulo_no' => $Titulo_no, 'Titulo_Color' => $Titulo_Color, 'Titulo_Bold' => $Titulo_Bold,
                'linea_no' => $linea_no, 'UNA_LINEA' => $UNA_LINEA, 'linea_Color' => $linea_Color,
                'linea_Bold' => $linea_Bold, 'valoresDefault' => $valoresDefault,
                'setear' => $setear
            ));
        }
        if ($tipoBorder == 'Border-Linea2') {
            $html .= $this->getPartial('pdf/border_linea2', array(
                'fondoEncabezado' => $fondoEncabezado, 'fondoDetalle' => $fondoDetalle,
                'colorBorder' => $colorBorder, 'Titulo_no' => $Titulo_no, 'UNA_LINEA' => $UNA_LINEA, 'Titulo_Color' => $Titulo_Color, 'Titulo_Bold' => $Titulo_Bold,
                'linea_no' => $linea_no, 'linea_Color' => $linea_Color, 'linea_Bold' => $linea_Bold, 'valoresDefault' => $valoresDefault, 'setear' => $setear
            ));
        }
        if ($tipoBorder == 'Border-Linea') {
            $html .= $this->getPartial('pdf/border_linea', array(
                'fondoEncabezado' => $fondoEncabezado, 'fondoDetalle' => $fondoDetalle,
                'colorBorder' => $colorBorder, 'Titulo_no' => $Titulo_no, 'UNA_LINEA' => $UNA_LINEA, 'Titulo_Color' => $Titulo_Color, 'Titulo_Bold' => $Titulo_Bold,
                'linea_no' => $linea_no, 'linea_Color' => $linea_Color, 'linea_Bold' => $linea_Bold, 'valoresDefault' => $valoresDefault, 'setear' => $setear
            ));
        }
        if ($tipoBorder == 'Border-Encabezado') {
            $html .= $this->getPartial('pdf/border_encabezado', array(
                'fondoEncabezado' => $fondoEncabezado, 'fondoDetalle' => $fondoDetalle,
                'colorBorder' => $colorBorder, 'Titulo_no' => $Titulo_no, 'UNA_LINEA' => $UNA_LINEA, 'Titulo_Color' => $Titulo_Color, 'Titulo_Bold' => $Titulo_Bold,
                'linea_no' => $linea_no, 'linea_Color' => $linea_Color, 'linea_Bold' => $linea_Bold, 'valoresDefault' => $valoresDefault,
                'setear' => $setear
            ));
        }
        if ($tipoBorder == 'Sin-Borders') {
            $html .= $this->getPartial('pdf/sin_borders', array(
                'fondoEncabezado' => $fondoEncabezado, 'fondoDetalle' => $fondoDetalle,
                'colorBorder' => $colorBorder, 'Titulo_no' => $Titulo_no, 'Titulo_Color' => $Titulo_Color, 'UNA_LINEA' => $UNA_LINEA,
                'Titulo_Bold' => $Titulo_Bold, 'linea_no' => $linea_no, 'linea_Color' => $linea_Color,
                'linea_Bold' => $linea_Bold, 'valoresDefault' => $valoresDefault,
                'setear' => $setear
            ));
        }


        $html .= $this->getPartial('pdf/pie', array(
            'ancho' => $maxAncho, 'tamanoPapel' => $tamanoPapel,
            'pos' => $pos, "wlogo" => $tamanoLogo, "PosicionLogo" => $PosicionLogo, 'UNA_LINEA' => $UNA_LINEA,
            'Titulo_no' => $Titulo_no, 'Titulo_Color' => $Titulo_Color, 'Titulo_Bold' => $Titulo_Bold,
            'linea_no' => $linea_no, 'UNA_LINEA' => $UNA_LINEA, 'linea_Color' => $linea_Color,
            'linea_Bold' => $linea_Bold, 'maxAncho' => $maxAncho, 'valoresDefault' => $valoresDefault,
            'colorBorder' => $colorBorder,
        ));


//                echo $html;
//                die();
        $tipoDocum = trim($valoresDefault['GENERALES']['Tipo']);
        $serie = trim($valoresDefault['CertificacionF']['Serie']);
        $Numero = trim($valoresDefault['Certificacion']['NumeroAutorizacion']);
        $tipoDocum = strtoupper(str_replace(" ", "_", $tipoDocum));
        if ($operacion->getFaceEstado() == "FIRMADONOTA") {
            $tipoDocum = 'NOTA CREDITO';
        }



        $fecha = $valoresDefault['GENERALES']['FechaHoraEmision'];
        $fecha = str_replace(" ", "_", $fecha);
        $fecha = str_replace("/", "", $fecha);
        $fecha = str_replace(":", "", $fecha);
        $nit = $valoresDefault['EMISOR']['NITEmisor'];
        $nombrePdf = $tipoDocum . "_" . $serie . "_" . $Numero . ".pdf";
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Pdf Factura , NOTA');
        $pdf->SetTitle($nombrePdf);
        $pdf->SetSubject('Contable, XML , Fel');
        $pdf->SetKeywords('Contable, XML , Fel,Pdf'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        if ($tamanoPapel == 'A5H') {
            $pdf->SetAutoPageBreak(true, 10);
        }

        $pdf->SetMargins(4, 10, 5, true);
        $pdf->SetHeaderMargin(0.1);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont($fuente, '', 14);
        $pdf->AddPage();
        $tipoFONDO = 2;
        $tipoFONDO = 1;
        $tipoFONDO = 3;

        $img_file = "images/anulado.png";
        if (strtoupper($operacion->getFaceEstado()) != "FIRMADONOTA") {
            if (strtoupper($operacion->getEstatus()) == 'ANULADO') {
                //  $pdf->Image($img_file, 140, 5, 50, '', '', '', '300', false, 0);                
                $pdf->Image($img_file, 40, 5, 150, '', '', '', '300', false, 0);
                $pdf->Image($img_file, 40, 45, 150, '', '', '', '300', false, 0);
            }
        }
        //     $pdf->Image($img_file, 140, 5, 250, '', '', '', '300', false, 0);
        //  $tipoMarcaAgua=1;
        if ($tipoMarcaAgua == 2) {
            $fo = null;
            $fo[1] = 'bronce.png';
            $fo[2] = 'bronce.png';
            $noFondo = rand(1, 2);
            $fondo = "images/" . $fo[$noFondo];
        }

        if ($tipoMarcaAgua == 1) {
            $fo = null;
            $fo[1] = 'logoFondo.png';
            $fo[2] = 'logoFondo.png';
            $noFondo = rand(1, 2);
            $fondo = "images/" . $fo[$noFondo];
        }
        if ($tipoMarcaAgua == 3) {
            $fo = null;
            $fo[1] = 'bronce.png';
            $fo[2] = 'bronce.png';
            $noFondo = rand(1, 2);
            $fondo = "images/" . $fo[$noFondo];
        }
        $urlFondo = '';
        if ($urlFondo) {
            $fondo = $urlFondo;
        }
        //***MARCA DE AGUA FONDO
        $marca = "";
        if ($fondo) {
            $marcaAgua = UsuarioReport::marcaAgua($fondo);
            $wAncho = $marcaAgua['ancho'];
            $wAlto = $marcaAgua['alto'];
            $marca = $marcaAgua['destino'];
        }
        if ($marca <> "") {
            $anchoTotal = $return['anchoTotal'];
            $altoTotal = $return['altoTotal'];
            //*** FONDO TOTAL 
            if ($tipoMarcaAgua == 1) {
                $pdf->Image($marca, 0, 0, $anchoTotal, $altoTotal, '', '', '', false, 300, 'C', false, false, 0);
            }
            $MedioAncho = $anchoTotal / 2;
            $MedioAncho = (int) $MedioAncho;
            $MedioAlto = $altoTotal / 2;
            $MedioAlto = (int) $MedioAlto;
            $posicionY = $MedioAlto / 2;
            $posicionY = (int) $posicionY;
            //**  FONDO MITAD
            if ($tipoMarcaAgua == 2) {
                $pdf->Image($marca, 0, $posicionY, $MedioAncho, $MedioAlto, '', '', '', false, 300, 'C', false, false, 0);
            }

            $MedioAncho = $wAncho;
            $MedioAlto = $wAlto;
            if (($wAncho > $anchoTotal) or ($wAlto > $altoTotal)) {
                $MedioAncho = $anchoTotal / 4;
                $MedioAncho = (int) $MedioAncho;
                $MedioAlto = $altoTotal / 4;
                $MedioAlto = (int) $MedioAlto;
            }
            $posicionY = $MedioAlto * 1.5;
            $posicionY = (int) $posicionY;
            //**  FONDO pequenio
            if ($tipoMarcaAgua == 3) {
                $pdf->Image($marca, 0, $posicionY, $MedioAncho, $MedioAlto, '', '', '', false, 300, 'C', false, false, 0);
            }

            //$pdf->Image(file, x, y, w, h, type, link, aling, resize, dpi, plaalin,ismak, )

            $pdf->setPageMark();
        }
        /// ***  FIN MARCA DE AGUA
        //** LOGO
        $ocultalogo = false;
        if ($PosicionLogo == "SUPERIOR-CENTRO") {
            $y = $y + 2;
            if ($UNA_LINEA) {
                $ocultalogo = true;
            }
        }
        if ($operacion->getTienda()->getCodigo()=="PL") {
                  $ocultalogo=true;
        }
  
        if (!$ocultalogo) {
            //            echo $x;
            //            echo "<br>";
            //            echo $y;
            //            die();
//            echo $urlImage;
//            die('aaa');
            $pdf->Image($urlImage, $x + 10, $y + 5, $tamanoLogo - 15);
        }
        //   *  FIN LOGO
//   die();

        $lineas = 2;
        $uuid = $valoresDefault['Certificacion']['NumeroAutorizacion'];
        $emisor = $valoresDefault['EMISOR']['NITEmisor'];
        $receptor = $valoresDefault['RECEPTOR']['IDReceptor'];
        $monto = 0;
        foreach ($valoresDefault['lineas'] as $lin) {
            $monto = $monto + $lin['Precio'];
        }
        $urlQrcode = "https://felpub.c.sat.gob.gt/verificador-web/publico/vistas/verificacionDte.jsf?tipo=autorizacion&";
        $urlQrcode .= "numero=" . $uuid . "&emisor=" . $emisor . "&receptor=" . $receptor . "&monto=" . $monto;

        $tamanoPapel = trim($tamanoPapel);
        $orientacion = trim($orientacion);
        $style = array(
            'border' => 1,
            'padding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => array(255, 255, 255)
        );

        // require_once('TCPDF/examples/barcodes/tcpdf_barcodes_2d_include.php');
        //  $TCPDF2DBarcode = new TCPDF2DBarcode($urlQrcode, 'QRCODE,H');
        //  $imagenBar = $TCPDF2DBarcode->getBarcodePngData(1.5, 1.5);
        // $img_base64_encoded = 'data:image/png;base64,' . base64_encode($imagenBar);
        // $img = '<br/><br/><img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $img_base64_encoded) . '" width="65" height="65">';
// $pdf->write2DBarcode($urlQrcode, 'QRCODE,H', 22, 175, 40, 40, $style);

        $pdf->writeHTML($html, true, false, true, false, '');
        $style = array('border' => 0, 'padding' => 'auto', 'fgcolor' => array(0, 0, 0), 'bgcolor' => array(255, 255, 255));
        $general = true;

        if (($tamanoPapel == 'A5V')) {
            //** tiket
            $general = false;
            // $pdf->write2DBarcode($urlQrcode, 'QRCODE,H', ($maxAncho - 25), $altoTotal - 35, 25, 25, $style);
            //$pdf->Image($urlFeel, 4, $altoTotal - 28, 30);
            //      die('ticket');
        }
        if (($tamanoPapel == 'A5H')) {

            //*** media carta
            $general = false;
            //$pdf->write2DBarcode($urlQrcode, 'QRCODE,H', ($maxAncho - 30), $altoTotal - 30, 25, 25, $style);
            //$pdf->Image($urlFeel, 6, 120, 40);
        }


        if (($tamanoPapel == 'Letter') && ($orientacion == 'P')) {
            //** carta 
            $general = false;
            //die('aa');
            $pdf->write2DBarcode($urlQrcode, 'QRCODE,H', ($maxAncho - 40), 218, 35, 35, $style);
            // $pdf->Image($urlFeel, 6, 275, 45);
        }

        if ($general) {
            //  $pdf->write2DBarcode($urlQrcode, 'QRCODE,H', ($maxAncho - 40), $altoTotal - 26, 25, 25, $style);
            //  $pdf->Image($urlFeel, 2, $altoTotal - 30, 45);
        }

        if ($descarga) {
            $pdf->Output('documento.pdf', 'D');
        }
        $BASE64 = $pdf->Output('documento.pdf', 'E');
        $BASE64 = explode('pdf"', $BASE64);
        $BASE64 = trim($BASE64[2]);

        $base64_decode = base64_decode($BASE64);
        $pg = fopen("uploads/factura.pdf", 'w');
        fwrite($pg, $base64_decode);
        fclose($pg);
        if (!$descarga) {
            $pdf->Output($nombrePdf, 'I');
        }
        die();
        echo $html;
    }

}
