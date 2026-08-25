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


        public function executePreFactura(sfWebRequest $request) {

        date_default_timezone_set("America/Guatemala");
        error_reporting(-1);
        $id = $request->getParameter('id');
        $listas = $this->BuscaId($id);
        
        $IIREDB= OrdenCotizacionQuery::create()->filterById($listas, Criteria::IN)->find();
        foreach($IIREDB as $reg) {
            $listaCo[]= str_replace('LIST-','',$reg->getCodigo());
        }
        $codigo = 'LIST-'.implode("-", $listaCo);
        
        
        $operacion = OrdenCotizacionQuery::create()->findOneById($id);
        $detalle = OrdenCotizacionDetalleQuery::create()
                ->filterByConfirmado(true)
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->filterByOrdenCotizacionId($listas, Criteria::IN)
                ->withColumn('CAST(orden_cotizacion_detalle.bulto_inicio AS UNSIGNED)', 'BultoOrden')
                ->orderBy('BultoOrden', Criteria::ASC)
                ->find();

        $html = '';
        $logo = $operacion->getEmpresa()->getLogo();
        $html = $this->getPartial('reporte/preFactura', array('codigo'=>$codigo, 'operacion' => $operacion, 'detalle' => $detalle, 'logo' => $logo));
        $img_file = "uploads/images/" . $logo;

        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle(" Prefactura " . $operacion->getCodigo());
        $pdf->SetSubject('Prefactura');
        $pdf->SetKeywords('Concilia,Banco,Cuenta'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetMargins(3, 5, 5, true);
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
        $pdf->Image($img_file, 18, -8, 40); //, 50, '', '', '', '300', false, 0);



        $pdf->Output('PreFactura ' . $operacion->getCodigo() . '.pdf', 'I');
    }
    
    
    
    public function executeExportar(sfWebRequest $request) {
        $tipoUsua = strtoupper(sfContext::getInstance()->getUser()->getAttribute("tipoUsuario", null, 'seguridad'));
   
    $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
    $con = Propel::getConnection();
    // ==========================================
    // OBTENER LISTAS DE PRECIOS
    // ==========================================
    $stmt = $con->prepare("SELECT id, nombre FROM lista_precio WHERE empresa_id = :empresa_id ORDER BY id ");
    $stmt->bindValue(':empresa_id', $empresaId, PDO::PARAM_INT);
    $stmt->execute();
    $listasPrecio = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // ==========================================
    // CONSTRUIR COLUMNAS DINÁMICAS DE PRECIOS
    // ==========================================
    $camposPrecios = '';
    $joinsPrecios  = '';
    foreach ($listasPrecio as $lista) {
        $alias = 'pp_' . $lista['id'];
        $camposPrecios .= ", {$alias}.valor AS precio_{$lista['id']}";
        $joinsPrecios .= "   LEFT JOIN producto_precio {$alias}  ON {$alias}.producto_id = p.id   AND {$alias}.lista_precio_id = {$lista['id']}";
    }
    if ($camposPrecios) {
        $camposPrecios=",".$camposPrecios;
    }
//echo $empresaId;
//die();
//    echo $camposPrecios;
//    die();
    // ==========================================
    // CONSULTA PRINCIPAL
    // ==========================================
    $query = " SELECT t.codigo AS codigo_tienda,  t.nombre AS tienda, p.codigo_sku,  p.codigo_barras,  p.nombre AS producto,
    pe.cantidad,  p.precio {$camposPrecios} , costo_proveedor FROM producto_existencia pe INNER JOIN producto p ON p.id = pe.producto_id
    INNER JOIN tienda t  ON t.id = pe.tienda_id   {$joinsPrecios}  WHERE pe.empresa_id = :empresa_id
    AND IFNULL(pe.cantidad,0) > 0 and t.id not in(99)   ORDER BY   t.nombre,  p.nombre ";
    $query = str_replace(",,", ",", $query);
//    echo $query;
//    die();
    $stmt = $con->prepare($query);
    
    
    $stmt->bindValue(':empresa_id', $empresaId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // ==========================================
    // DESCARGA CSV
    // ==========================================
    $filename = 'inventario_' . date('Ymd_His') . '.csv';
    while (ob_get_level()) {
        ob_end_clean();
    }
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');
    $output = fopen('php://output', 'w');
    // BOM UTF-8 para Excel
    fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
    // ==========================================
    // ENCABEZADOS
    // ==========================================
    $header = array('Codigo Tienda', 'Tienda','SKU', 'Codigo Barras', 'Producto','Existencia','Precio  Venta');
    foreach ($listasPrecio as $lista) {
        $header[] = $lista['nombre'];
    }
    
         if ($tipoUsua == "ADMINISTRADOR") { 
                $header[]='Costo';
        }

    fputcsv($output, $header);
    // ==========================================
    // TOTALES
    // ==========================================
    $totalExistencia = 0;
    $totalValor = 0;
    // ==========================================
    // DETALLE
    // ==========================================
    foreach ($result as $row) {

        $codigoTienda = preg_replace(
            '/\s+/',
            ' ',
            str_replace(
                array(',', ';', "\r", "\n", "\t"),
                ' ',
                trim((string)$row['codigo_tienda'])
            )
        );

        $tienda = preg_replace(
            '/\s+/',
            ' ',
            str_replace(
                array(',', ';', "\r", "\n", "\t"),
                ' ',
                trim((string)$row['tienda'])
            )
        );

        $sku = preg_replace(
            '/\s+/',
            ' ',
            str_replace(
                array(',', ';', "\r", "\n", "\t"),
                ' ',
                trim((string)$row['codigo_sku'])
            )
        );

        $codigoBarras = preg_replace(
            '/\s+/',
            ' ',
            str_replace(
                array(',', ';', "\r", "\n", "\t"),
                ' ',
                trim((string)$row['codigo_barras'])
            )
        );

        $producto = preg_replace(
            '/\s+/',
            ' ',
            str_replace(
                array(',', ';', "\r", "\n", "\t"),
                ' ',
                trim((string)$row['producto'])
            )
        );

        $linea = array(
            $codigoTienda,
            $tienda,
            $sku,
            $codigoBarras,
            $producto,
            (int)$row['cantidad'],
            number_format((float)$row['precio'], 2, '.', '')

        );

        // Agregar precios de listas dinámicamente
        foreach ($listasPrecio as $lista) {

            $campo = 'precio_' . $lista['id'];

            $linea[] = (
                isset($row[$campo]) &&
                $row[$campo] !== null
            )
                ? number_format((float)$row[$campo], 2, '.', '')
                : '';
        }
              if ($tipoUsua == "ADMINISTRADOR") { 
        $linea[]=number_format((float)$row['costo_proveedor'], 2, '.', '');
              }
        fputcsv($output, $linea);

        $totalExistencia += (int)$row['cantidad'];
        $totalValor += (float)$row['valor_existencia'];
    }

    // ==========================================
    // TOTALES
    // ==========================================
    fputcsv($output, array());

//    $filaTotal = array(
//        '',
//        '',
//        '',
//        '',
//        'TOTALES',
//        '',
//        $totalExistencia,
//        number_format($totalValor, 2, '.', '')
//    );
//
//    // Completar columnas de listas de precios
//    foreach ($listasPrecio as $lista) {
//        $filaTotal[] = '';
//    }
//
//    fputcsv($output, $filaTotal);

    fclose($output);

    return sfView::NONE;
}
       public function BuscaId($listaId) {
        $sql = " select oc.id from lista_empaque_unida_detalle un inner join orden_cotizacion ";
        $sql .= " oc on un.codigo =oc.codigo where lista_empaque_unida_id in (select lista_empaque_unida_id ";
        $sql .= " from lista_empaque_unida_detalle un inner join orden_cotizacion oc on un.codigo =oc.codigo  where oc.id=" . $listaId . ");";
        $con = Propel::getConnection();
        $stmt = $con->prepare($sql);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $listados = array();
        $listados[] = $listaId;
        foreach ($result as $fila) {
            if (!in_array($fila['id'], $listados)) {
                $listados[] = $fila['id'];
            }
        }
        return $listados;
    }
    
    public function executeEmpaque(sfWebRequest $request) {

        date_default_timezone_set("America/Guatemala");
        error_reporting(-1);
        $id = $request->getParameter('id');
        $listas = $this->BuscaId($id);
        
        $IIREDB= OrdenCotizacionQuery::create()->filterById($listas, Criteria::IN)->find();
        foreach($IIREDB as $reg) {
            $listaCo[]= str_replace('LIST-','',$reg->getCodigo());
        }
        $codigo = 'LIST-'.implode("-", $listaCo);
        
        
        $operacion = OrdenCotizacionQuery::create()->findOneById($id);
        $detalle = OrdenCotizacionDetalleQuery::create()
                ->filterByConfirmado(true)
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->filterByOrdenCotizacionId($listas, Criteria::IN)
                ->withColumn('CAST(orden_cotizacion_detalle.bulto_inicio AS UNSIGNED)', 'BultoOrden')
                ->orderBy('BultoOrden', Criteria::ASC)
                ->find();

        $html = '';
        $logo = $operacion->getEmpresa()->getLogo();
        $html = $this->getPartial('reporte/empaque', array('codigo'=>$codigo, 'operacion' => $operacion, 'detalle' => $detalle, 'logo' => $logo));
        $img_file = "uploads/images/" . $logo;

        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle(" Lista Empaque " . $operacion->getCodigo());
        $pdf->SetSubject('Lista Empaque');
        $pdf->SetKeywords('Concilia,Banco,Cuenta'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetMargins(3, 5, 5, true);
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
        $pdf->Image($img_file, 18, -8, 40); //, 50, '', '', '', '300', false, 0);



        $pdf->Output('Lista Empaque ' . $operacion->getCodigo() . '.pdf', 'I');
    }

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
//       
//        
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
   
       if ($ordenCompra->getPrefijo()=='LISTA') {
           $codigo = str_replace("LIST-","", $ordenCompra->getCodigo());
           $hija= OrdenCotizacionQuery::create()->findOneByCodigo($codigo);
           if ($hija) {
               $ordenCompra=$hija;
           }
       }
        $lista = OrdenCotizacionDetalleQuery::create()
                ->filterByConfirmado(true, Criteria::NOT_EQUAL)
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->filterByCantidad(0, Criteria::GREATER_THAN)
                ->filterByOrdenCotizacionId($ordenCompra->getId())
                ->find();

        $logo = $ordenCompra->getEmpresa()->getLogo();
        $valor = $ordenCompra->getValorTotal();
        $valor = Parametro::formato($valor, false);
        $valor = str_replace(",", "", $valor);
        $totalImprime = str_replace(".", ",", $valor);


        $numberToLetterConverter = new NumberToLetterConverter();
        $totalImprime = $numberToLetterConverter->to_word($totalImprime, $miMoneda = null);
        $valoresImprime = explode("CON", $totalImprime);
        if (count($valoresImprime) > 1) {
            $totalImprime = str_replace("CON", " DOLARES  CON ", $totalImprime) . " CENTAVOS ";
        } else {
            $totalImprime .= " EXACTOS ";
        }
        $totalImprime = "**" . $totalImprime . "**";


        $html = $this->getPartial('reporte/ordenCotizacion',
                array('logo' => $logo, 'orden' => $ordenCompra, 'lista' => $lista,
                    'totalImprime' => $totalImprime));
        $img_file = "uploads/images/" . $logo;
//        $img_file = "images/enProceso.png";
//        
//        if (strtoupper($ordenCompra->getEstatus()) == "AUTORIZADO")
//        {
//            $img_file = "images/autorizado.png";
//        }
//        echo $html;
//        die();
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle("Pedido " . $ordenCompra->getCodigo());
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
        $pdf->Image($img_file, 18, -8, 40); //, 50, '', '', '', '300', false, 0);


        $pdf->writeHTML($html);

        $pdf->Output('Pedido ' . $ordenCompra->getCodigo() . '.pdf', 'I');
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

//echo $html;
//die();
//        
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
        if (strtoupper($ordenCompra->getEstatus()) != "CONFIRMADA") {
            $pdf->Image($img_file, 140, 5, 50, '', '', '', '300', false, 0);
        }
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
