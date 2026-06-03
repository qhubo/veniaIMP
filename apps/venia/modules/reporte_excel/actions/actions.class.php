<?php

/**
 * reporte_excel actions.
 *
 * @package    plan
 * @subpackage reporte_excel
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporte_excelActions extends sfActions {

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
    
    public function executePedido(sfWebRequest $request) {
        error_reporting(-1);
        $id = $request->getParameter('id');
        $ordenCompra = OrdenCotizacionQuery::create()->findOneById($id);
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
        $nombreempresa = "Golden";
        $pestanas[] = 'PEDIDO';
        $filename = "PEDIDO " . $ordenCompra->getCodigo();
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $sheet = $xl->setActiveSheetIndex(0);

// ================= COLUMNAS =================
        $widths = [5, 20, 66, 15, 15, 30, 15, 18, 18];
        $col = 'A';
        foreach ($widths as $w) {
            $sheet->getColumnDimension($col)->setWidth($w);
            $col++;
        }

// ================= TITULO =================
        $sheet->mergeCells("A1:I1");
        $sheet->setCellValue("A1", $ordenCompra->getEmpresa()->getNombre());
        $sheet->getStyle("A1")->getFont()->setSize(18)->setBold(true);
        $sheet->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells("A2:G2")->setCellValue("A2", "RUC: " . $ordenCompra->getEmpresa()->getTelefono());
        $sheet->getStyle("A2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells("A3:G3")->setCellValue("A3", "Teléfono: " . $ordenCompra->getEmpresa()->getContactoTelefono());
        $sheet->getStyle("A3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells("A4:G4")->setCellValue("A4", $ordenCompra->getEmpresa()->getDireccion());
        $sheet->getStyle("A4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        
// ================= PEDIDO =================
        $sheet->setCellValue("H2", "PEDIDO:");
        $sheet->setCellValue("I2", $ordenCompra->getCodigo());
        $sheet->getStyle("H2:I2")->getFont()->setBold(true);

// ================= CLIENTE =================
        $sheet->setCellValue("B6", "Fecha:");
        $sheet->setCellValue("C6", $ordenCompra->getFecha('d/m/Y'));
        $sheet->setCellValue("B7", "Cliente:");
        $sheet->setCellValue("C7", $ordenCompra->getNombre());
        $sheet->setCellValue("B8", "Dirección:");
        $sheet->setCellValue("C8", $ordenCompra->getDireccion());
        $sheet->setCellValue("B9", "Acuerdo de Pago:");
        $sheet->setCellValue("C9", $ordenCompra->getAcuerdoPago());
        $sheet->setCellValue("B10", "Código Cliente:");
        $sheet->setCellValue("C10", $ordenCompra->getCliente()->getCodigo());        
        $sheet->setCellValue("B11", "RUC:");
        $sheet->setCellValue("C11", $ordenCompra->getNit());
        
        $sheet->setCellValue("F6", "No Pedido:");
        $sheet->setCellValue("G6",  $ordenCompra->getCodigo());
        $sheet->setCellValue("F7", "Vendedor:");
        if ($ordenCompra->getVendedorId()) {
        $sheet->setCellValue("G7", $ordenCompra->getVendedor()->getNombre());
        }
        $sheet->setCellValue("F8", "País:");
        $sheet->setCellValue("G8", $ordenCompra->getCliente()->getPais()->getNombre());
        $sheet->setCellValue("F9", "Telefono:");
        $sheet->setCellValue("G9", $ordenCompra->getCliente()->getTelefono());
        $sheet->setCellValue("F10", "Transporte:");
        $sheet->setCellValue("G10", $ordenCompra->getNombreTransporte());
        
        
        
        

// ================= CABECERA =================
        $fila = 13;
        $headers = ["No", "Código", "Descripción", "Origen", "Marca", "Características", "Unidades", "Precio Unit", "Total","Peso"];

        $col = "A";
        foreach ($headers as $h) {
            $sheet->setCellValue($col . $fila, $h);
            $sheet->getStyle($col . $fila)->getFont()->setBold(true);
            $sheet->getStyle($col . $fila)->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . $fila)->getBorders()->getAllBorders()
                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $col++;
        }

// ================= DETALLE =================
        $can = 0;
        $totalPeso = 0;
        $totalMetros = 0;
        $totalUnidades = 0;
        $Subtotal = 0;
        $totalCajas = 0;
        foreach ($lista as $regist) {
            $can++;
            $pro = $regist->getProducto();
            $totalPeso = $totalPeso + ($regist->getProducto()->getPeso() * $regist->getCantidad());
            $totalMetros = $totalMetros + ( ($pro->getAlto() * $pro->getAncho() * $pro->getLargo()) * $regist->getCantidad());
            $totalUnidades = $totalUnidades + $regist->getCantidad();
            $totalCajas = $totalCajas + $regist->getCantidadCaja();
            $Subtotal = $Subtotal + $regist->getValorTotal();
            $fila++;

            $sheet->setCellValue("A$fila", $can);
            $sheet->setCellValue("B$fila", $regist->getCodigo());
            $sheet->setCellValue("C$fila", $regist->getDetalle());
            $sheet->setCellValue("D$fila", $regist->getProducto()->getOrigen());
            $sheet->setCellValue("E$fila", $regist->getProducto()->getMarcaProducto());
            $sheet->setCellValue("F$fila", $regist->getProducto()->getCaracteristica());
            $sheet->setCellValue("G$fila",  $regist->getCantidad());
            $sheet->setCellValue("H$fila", $regist->getValorUnitario());
            $sheet->setCellValue("I$fila", $regist->getValorTotal());
            $sheet->setCellValue("J$fila", (  $regist->getProducto()->getPeso() * $regist->getCantidad()));
          
        }

        foreach (range('A', 'I') as $c) {
            $sheet->getStyle($c . $fila)->getBorders()->getAllBorders()
                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        }

// ================= TOTALES =================
        $fila += 3;

        $sheet->setCellValue("B$fila", "Metros Cúbicos");
        $sheet->setCellValue("C$fila", round($totalMetros, 2));
        
        
        $sheet->setCellValue("G$fila", "Subtotal");
        $sheet->setCellValue("I$fila", round($Subtotal,2));

        $fila++;
         $sheet->setCellValue("B$fila", "Kilogramos");
        $sheet->setCellValue("C$fila", round($totalPeso, 2));
        
        $fila++;
        $sheet->setCellValue("G$fila", "Recarga");
        $sheet->setCellValue("I$fila", round($ordenCompra->getTotalRecargo(),2));
        
        $sheet->setCellValue("B$fila", "Bultos");
        $sheet->setCellValue("C$fila", round($totalCajas, 2));
    $numberToLetterConverter = new NumberToLetterConverter();
        $valor = $ordenCompra->getValorTotal();
        $valor = Parametro::formato($valor, false);
        $valor = str_replace(",", "", $valor);
        $totalImprime = str_replace(".", ",", $valor);
          $totalImprime = $numberToLetterConverter->to_word($totalImprime, $miMoneda = null);
        $fila++;
          $sheet->setCellValue("C$fila", $totalImprime);
        $sheet->setCellValue("G$fila", "TOTAL");
        $sheet->setCellValue("I$fila", round($ordenCompra->getValorTotal(),2));
        $sheet->getStyle("G$fila:I$fila")->getFont()->setBold(true);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeEmpaque(sfWebRequest $request) {
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


        $nombreempresa = "Golden";
        $pestanas[] = 'FACTURA';
        $filename = "EMPAQUE" . date("d_m_Y");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $sheet = $xl->setActiveSheetIndex(0);
// ================= COLUMNAS =================
        $widths = [20, 18, 45, 15, 10, 14, 22, 12, 14, 12, 14];
        $col = 'A';
        foreach ($widths as $w) {
            $sheet->getColumnDimension($col)->setWidth($w);
            $col++;
        }

// ================= ENCABEZADO =================
// 
// // ================= ENCABEZADO =================

// ---- COLUMNAS BASE ----
// A:E  -> lado izquierdo
// F:K  -> lado derecho

// ================= FILA TITULO =================
$sheet->mergeCells("A8:K8");
$sheet->setCellValue("A8", "PACKING LIST");

$sheet->getStyle("A8")->getFont()
      ->setSize(18)
      ->setBold(true);

$sheet->getStyle("A8")->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
      ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


// ================= LADO IZQUIERDO =================
$sheet->mergeCells("A2:E2");
$sheet->setCellValue("A2",$operacion->getEmpresa()->getNombre());
$sheet->getStyle("A2")->getFont()->setBold(true);

$sheet->setCellValue("A3", "FECHA:");
$sheet->setCellValue("B3", $operacion->getFecha('d/m/Y'));

$sheet->setCellValue("A4", "NOMBRE:");
$sheet->setCellValue("B4", $operacion->getNombre());

$sheet->setCellValue("A5", "OBSERVACIONES:");
$sheet->setCellValue("B5", $operacion->getComentario());


// ================= LADO DERECHO =================
$sheet->setCellValue("G2", "No.");
$sheet->setCellValue("H2", $codigo);


$sheet->setCellValue("G6", "CÓDIGO DEL CLIENTE:");
if ($operacion->getClienteId()) {
$sheet->setCellValue("H6", $operacion->getCliente()->getCodigo());
}
$sheet->setCellValue("G7", "PEDIDO:");
$sheet->setCellValue("H7", str_replace("LIST-","", $codigo));


// ================= ESTILO (opcionales) =================
$sheet->getStyle("A2:K7")->getFont()->setSize(11);

$sheet->getStyle("A2:K7")->getAlignment()
      ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$sheet->getStyle("A2:A5")->getFont()->setBold(true);
$sheet->getStyle("G2:G7")->getFont()->setBold(true);

$sheet->getRowDimension(2)->setRowHeight(22);
$sheet->getRowDimension(8)->setRowHeight(28);

//        $sheet->mergeCells("A1:K1");
//        $sheet->setCellValue("A1", "PACKING LIST");
//        $sheet->getStyle("A1")->getFont()->setSize(18)->setBold(true);
//        $sheet->getStyle("A1")->getAlignment()
//                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//
//        $sheet->setCellValue("A3", $operacion->getEmpresa()->getNombre());
//        $sheet->setCellValue("A4", "FECHA:");
//        $sheet->setCellValue("B4", $operacion->getFecha('d/m/Y'));
//        $sheet->setCellValue("A5", "NOMBRE:");
//        $sheet->setCellValue("B5", $operacion->getNombre());
//
//        $sheet->setCellValue("H4", "No:");
//        $sheet->setCellValue("I4", $operacion->getId());
//        $sheet->setCellValue("H6", "PEDIDO:");
//        $sheet->setCellValue("I6", $operacion->getCodigo()) ;

// ================= CABECERA TABLA =================
        $fila = 9;

        $headers = [
            "ITEM", "CÓDIGO", "DESCRIPCIÓN", "MARCAS", "UNT",
            "CANT. BULTOS", "NO. BULTOS", "PESO", "PESO TOTAL", "CBM", "TOTAL CBM", "ALTO", "ANCHO", "LARGO", "TOTAL", "TOTAL X CANTIDAD"
        ];

        $col = "A";


        foreach ($headers as $h) {
            $sheet->setCellValue($col . $fila, $h);
            $sheet->getStyle($col . $fila)->getFont()->setBold(true);
            $sheet->getStyle($col . $fila)->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . $fila)->getBorders()->getAllBorders()
                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $col++;
        }


// ================= DETALLE =================
 $can = 0; 
        $totalUni = 0; 
        $totalBulto = 0; 
        $totalPeso = 0; 
        $totalCmb = 0; 
        foreach ($detalle as $detra) { 
            $fila++;
            $can++; 
            $totalUni = $detra->getCantidad() + $totalUni; 
            $totalBulto = $detra->getCantidadCaja() + $totalBulto; 
            $totalPeso = ($detra->getProducto()->getPeso() * $detra->getCantidad()) + $totalPeso; 
            $totalCmb = ($detra->getProducto()->getCMB() * $detra->getCantidad()) + $totalCmb; 
  

        $sheet->setCellValue("A$fila", $can);
        $sheet->setCellValue("B$fila", $detra->getProducto()->getCodigoSku());
        $sheet->setCellValue("C$fila", $detra->getProducto()->getNombre());
        $sheet->setCellValue("D$fila", $detra->getProducto()->getMarcaProducto());
        $sheet->setCellValue("E$fila", $detra->getCantidad());
        $sheet->setCellValue("F$fila", $detra->getCantidadCaja());
        $bultodes="";
        if ($detra->getCantidadCaja() > 0 or $detra->getBultoSuperior() > 0) { 
        $bultodes= " Bulto " . $detra->getBultoInicio(); 
             if ($detra->getBultoInicio() < $detra->getBultoFin()) { 
                        $bultodes .= " A Bulto " . $detra->getBultoFin(); 
                     } 
                 } 
                 
                 $totalC =$detra->getProducto()->getAlto()*$detra->getProducto()->getAncho()*$detra->getProducto()->getLargo();
                 $totalV = $totalC * $detra->getCantidad();
        
        $sheet->setCellValue("G$fila",$bultodes);
        $sheet->setCellValue("H$fila", round( $detra->getProducto()->getPeso(),2));
        $sheet->setCellValue("I$fila", round($detra->getProducto()->getPeso() * $detra->getCantidad(),2));
        $sheet->setCellValue("J$fila", round($detra->getProducto()->getCMB(),2));
        $sheet->setCellValue("K$fila", round($detra->getProducto()->getCMB() * $detra->getCantidad(),2));
    $sheet->setCellValue("L$fila", $detra->getProducto()->getAlto());
        $sheet->setCellValue("M$fila", $detra->getProducto()->getAncho());
            $sheet->setCellValue("N$fila", $detra->getProducto()->getLargo());
                $sheet->setCellValue("O$fila", $totalC);
                   $sheet->setCellValue("P$fila", $totalV);
             }


        foreach (range('A', 'K') as $c) {
            $sheet->getStyle($c . $fila)->getBorders()->getAllBorders()
                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        }

// ================= TOTALES =================
        $fila++;

        $sheet->mergeCells("A$fila:C$fila");
        $sheet->setCellValue("D$fila", "Totales");
        $sheet->setCellValue("E$fila", $totalUni);
        $sheet->mergeCells("F$fila:G$fila");
        $sheet->setCellValue("F$fila", round($totalBulto,2));
        $sheet->setCellValue("I$fila", round($totalPeso,2));
        $sheet->setCellValue("K$fila", round($totalCmb,2));

        foreach (range('A', 'K') as $c) {
            $sheet->getStyle($c . $fila)->getBorders()->getAllBorders()
                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeFactura(sfWebRequest $request) {
        error_reporting(-1);
        $id = $request->getParameter('id');
        $ordenCompra = OperacionQuery::create()->findOneById($id);
        $registro =$ordenCompra;
        $lista = OperacionDetalleQuery::create()
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->filterByCantidad(0, Criteria::GREATER_THAN)
                ->filterByOperacionId($ordenCompra->getId())
                ->find();
        $nombreempresa = $registro->getEmpresa()->getNombre();
        $pestanas[] = 'FACTURA';
        $filename = "FACTURA " . $registro->getCodigoFactura();
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $sheet = $xl->setActiveSheetIndex(0);
// ===== COLUMNAS =====
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(65);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
$ordenCompra=$registro;
// ===== ENCABEZADO =====
        $sheet->mergeCells("A1:F1");
        $sheet->setCellValue("A1", $registro->getEmpresa()->getNombre());
        $sheet->getStyle("A1")->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue("G1", "FACTURA ".$registro->getCodigoFactura());
        $sheet->getStyle("G1")->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle("G1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $sheet->mergeCells("A2:G2")->setCellValue("A2", "RUC: " . $ordenCompra->getEmpresa()->getTelefono());
        $sheet->getStyle("A2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells("A3:G3")->setCellValue("A3", "Teléfono: " . $ordenCompra->getEmpresa()->getContactoTelefono());
        $sheet->getStyle("A3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells("A4:G4")->setCellValue("A4", $ordenCompra->getEmpresa()->getDireccion());
        $sheet->getStyle("A4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// ===== CLIENTE =====
     $sheet->setCellValue("B6", "Fecha:");
        $sheet->setCellValue("C6", $ordenCompra->getFecha('d/m/Y'));
        $sheet->setCellValue("B7", "Cliente:");
        $sheet->setCellValue("C7", $ordenCompra->getNombre());
        $sheet->setCellValue("B8", "Dirección:");
        $sheet->setCellValue("C8", $ordenCompra->getDireccion());
        $sheet->setCellValue("B9", "Acuerdo de Pago:");
        $sheet->setCellValue("C9", $ordenCompra->getAcuerdoPago());
        $sheet->setCellValue("B10", "Código Cliente:");
        $sheet->setCellValue("C10", $ordenCompra->getCliente()->getCodigo());        
        $sheet->setCellValue("B11", "RUC:");
        $sheet->setCellValue("C11", $ordenCompra->getNit());
        
        $sheet->setCellValue("F6", "No Pedido:");
        $sheet->setCellValue("G6", str_replace("LIST-","", $ordenCompra->getPedidos()));
        $sheet->setCellValue("F7", "Vendedor:");
        if ($ordenCompra->getVendedorId()) {
        $sheet->setCellValue("G7", $ordenCompra->getVendedor()->getNombre());
        }
        $sheet->setCellValue("F8", "País:");
        $sheet->setCellValue("G8", $ordenCompra->getCliente()->getPais()->getNombre());
        $sheet->setCellValue("F9", "Telefono:");
        $sheet->setCellValue("G9", $ordenCompra->getCliente()->getTelefono());
        $sheet->setCellValue("F10", "Transporte:");
        $sheet->setCellValue("G10", $ordenCompra->getNombreTransporte());

// ===== CABECERA =====
        $fila = 13;
        $headers = ["No", "Código", "Descripción", "Origen", "Marca", "Características", "Unidades", "Precio Unit", "Total"];
        $col = "A";

        foreach ($headers as $h) {
            $sheet->setCellValue($col . $fila, $h);
            $sheet->getStyle($col . $fila)->getFont()->setBold(true);
            $sheet->getStyle($col . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . $fila)->getBorders()->getAllBorders()
                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $col++;
        }

// ===== DETALLE =====
        $opreacionDetalle = OperacionDetalleQuery::create()
                ->filterByProductoId(null, Criteria::NOT_EQUAL)
                ->filterByCantidad(0, Criteria::GREATER_THAN)
                ->filterByOperacionId($id)
                ->find();

        $pos = 0;
         $Subtotal = 0; 
                 $totalPeso = 0;
        $totalMetros = 0;
        $totalUnidades = 0;
        $Subtotal = 0;
        $totalCajas = 0;
        foreach ($opreacionDetalle as $detalle) {
            $regist=$detalle;
            $fila++;
            $pos++;
                        $pro = $regist->getProducto();
            $totalPeso = $totalPeso + $regist->getProducto()->getPeso();
            $totalMetros = $totalMetros + ( ($pro->getAlto() * $pro->getAncho() * $pro->getLargo()) * $regist->getCantidad());
            $totalUnidades = $totalUnidades + $regist->getCantidad();
            $totalCajas = $totalCajas + $regist->getCantidadCaja();

            $Subtotal = $Subtotal + $detalle->getValorTotal(); 
            $sheet->setCellValue("A$fila", $pos);
            $sheet->setCellValue("B$fila", $detalle->getCodigo());
            $sheet->setCellValue("C$fila", $detalle->getDetalle());
            $sheet->setCellValue("D$fila", $detalle->getProducto()->getOrigen());
            $sheet->setCellValue("E$fila", $detalle->getProducto()->getMarcaProducto());
            $sheet->setCellValue("F$fila", $detalle->getProducto()->getCaracteristica());
            $sheet->setCellValue("G$fila", $detalle->getCantidad());
            $sheet->setCellValue("H$fila", round($detalle->getValorUnitario(),2));
            $sheet->setCellValue("I$fila", round($detalle->getValorTotal(),2));
        }
        foreach (range('A', 'I') as $c) {
            $sheet->getStyle($c . $fila)->getBorders()->getAllBorders()
                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        }
        
        $medidas = $ordenCompra->getMedidas(); 

// ===== TOTALES =====
// ================= TOTALES =================
        $fila += 3;

        $sheet->setCellValue("B$fila", "Metros Cúbicos");
        $sheet->setCellValue("C$fila", round($medidas['totalcmb'], 2));
        
        
        $sheet->setCellValue("G$fila", "Subtotal");
        $sheet->setCellValue("I$fila", round($Subtotal,2));

        $fila++;
         $sheet->setCellValue("B$fila", "Kilogramos");
        $sheet->setCellValue("C$fila", round($medidas['totalpeso'], 2));
        
        $fila++;
        $sheet->setCellValue("G$fila", "Recarga");
        $sheet->setCellValue("I$fila", round($ordenCompra->getTotalRecargo(),2));
        
        $sheet->setCellValue("B$fila", "Bultos");
        $sheet->setCellValue("C$fila", round($medidas['totalbulto'], 2));
    $numberToLetterConverter = new NumberToLetterConverter();
        $valor = $ordenCompra->getValorTotal();
        $valor = Parametro::formato($valor, false);
        $valor = str_replace(",", "", $valor);
        $totalImprime = str_replace(".", ",", $valor);
          $totalImprime = $numberToLetterConverter->to_word($totalImprime, $miMoneda = null);
        $fila++;
          $sheet->setCellValue("C$fila", $totalImprime);
        $sheet->setCellValue("G$fila", "TOTAL");
        $sheet->setCellValue("I$fila", round($ordenCompra->getValorTotal(),2));
        $sheet->getStyle("G$fila:I$fila")->getFont()->setBold(true);

// ===== SALIDA =====
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

}
