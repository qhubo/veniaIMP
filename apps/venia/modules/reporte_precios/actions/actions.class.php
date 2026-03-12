<?php

class reporte_preciosActions extends sfActions {

    
    
    
public function executeReporteCostos(sfWebRequest $request)
{
    error_reporting(E_ALL);

    $this->setLayout(false);

    $empresaId = $this->getUser()->getAttribute("usuario", null, 'empresa');

    $fechaInicio = '2026-01-01 00:00:00';
    $fechaFin    = '2026-03-01 23:59:59';

    $query = " SELECT  
                usu.usuario,   
                DATE_FORMAT(p.fecha, '%d/%m/%Y %H:%i') AS fecha,      
                COALESCE(bb.tipo, 'CambiaPrecio') AS tipo, 
                pro.codigo_sku, 
                pro.nombre,  
                det.producto_id,
                det.precio,  
                0 AS precio_lista 
            FROM precio_producto p
            INNER JOIN precio_producto_detalle det 
                ON p.id = det.precio_producto_id
            INNER JOIN usuario usu 
                ON p.usuario_id = usu.id
            INNER JOIN producto pro  
                ON pro.id = det.producto_id
            LEFT JOIN bitacora_cambio bb  
                ON TRIM(bb.observaciones) = CAST(p.id AS CHAR)
            WHERE pro.empresa_id = ?
            AND p.fecha >= ? 
            AND p.fecha <= ?
            group by usu.usuario, p.fecha, det.producto_id";

    $con = Propel::getConnection();
    $stmt = $con->prepare($query);

    // ✅ Pasar parámetros correctamente
    $stmt->execute(array(
        $empresaId,
        $fechaInicio,
        $fechaFin
    ));

    // 🔹 Headers
    $response = $this->getResponse();
    $response->clearHttpHeaders();
    $response->setHttpHeader('Content-Type', 'text/csv; charset=UTF-8');
    $response->setHttpHeader('Content-Disposition', 'attachment; filename=reporte_cambio_costos.csv');
    $response->sendHttpHeaders();

    // 🔹 BOM UTF-8 para Excel
    echo "\xEF\xBB\xBF";

    $output = fopen('php://output', 'w');

    // Encabezados
    fputcsv($output, array(
        'Usuario',
        'Fecha',
        'Tipo',
        'SKU',
        'Producto',
        'Producto ID',
        'Precio',
        'Precio Lista'
    ), ';');

    // ✅ Streaming correcto (sin fetchAll)
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row, ';');
    }

    fclose($output);

    return sfView::NONE;
}
    
    public function executeReporte(sfWebRequest $request) {

          $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'reporte_precios'));
        $fechaInicio = $valores['fechaInicio'];
        $fechaFin = $valores['fechaFin'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
       
        $fechaInicio='2026-01-01';
        $fechaFin='2026-03-01';
        
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
      


$query = " SELECT  
            usu.usuario,   
            DATE_FORMAT(p.fecha, '%d/%m/%Y %H:%i') AS fecha,      
            COALESCE(bb.tipo, 'CambiaPrecio') AS tipo, 
            codigo_sku, 
            pro.nombre,  
            det.producto_id,
            det.precio,  
            0 AS precio_lista 
        FROM precio_producto p ";

$query .= " INNER JOIN precio_producto_detalle det 
            ON p.id = det.precio_producto_id ";

$query .= " INNER JOIN usuario usu 
            ON p.usuario_id = usu.id ";

$query .= " INNER JOIN producto pro  
            ON pro.id = det.producto_id ";

$query .= " LEFT JOIN bitacora_cambio bb  
            ON TRIM(bb.observaciones) = CAST(p.id AS CHAR) ";

$query .= " WHERE pro.empresa_id = " . $empresaId;

$query .= " AND p.fecha >= '" . $fechaInicio . " 01:00' 
            AND p.fecha < '" . $fechaFin . " 23:59' ";

 //$query .= " AND COALESCE(bb.tipo, 'CambiaPrecio') = 'CambioCosto' ";


        
        $query .= " order by codigo_sku, fecha";
        $con = Propel::getConnection();
        $stmt = $con->prepare($query);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Crear objeto PHPExcel
        $xl = new PHPExcel();
        $sheet = $xl->setActiveSheetIndex(0);

        /* ===== ENCABEZADOS ===== */
        $headers = array(
            'Usuario',
            'Fecha',
            'Tipo',
            'Codigo SKU',
            'Nombre',
            'Precio',
            'Precio Lista'
        );

        $col = 0;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($col, 1, $header);
            $col++;
        }

        /* ===== DATOS ===== */
        $rowNumber = 2;

        foreach ($result as $row) {
            $sheet->setCellValueExplicit('A' . $rowNumber, $row['usuario']);
            $sheet->setCellValue('B' . $rowNumber, $row['fecha']);
            $sheet->setCellValue('C' . $rowNumber, $row['tipo']);
            $sheet->setCellValueExplicit('D' . $rowNumber, $row['codigo_sku']);
            $sheet->setCellValue('E' . $rowNumber, $row['nombre']);
            $sheet->setCellValue('F' . $rowNumber, $row['precio']);
            if ($row['precio_lista'] >0) {
            $sheet->setCellValue('G' . $rowNumber, $row['precio_lista']);
            }
            $rowNumber++;
        }
        /* ===== AGREGAR FILTRO ===== */
$lastRow = $rowNumber - 1; // última fila con datos
$sheet->setAutoFilter("A1:G{$lastRow}");

        /* ===== ESTILO ENCABEZADO ===== */
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        /* ===== AUTO AJUSTAR COLUMNAS ===== */
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        /* ===== FORMATO NUMERICO ===== */
        $sheet->getStyle('F2:G' . ($rowNumber - 1))
                ->getNumberFormat()
                ->setFormatCode('#,##0.00');

        $sheet->getStyle('H2:H' . ($rowNumber - 1))
                ->getNumberFormat()
                ->setFormatCode('#,##0.00');

        /* ===== DESCARGA ===== */
        $filename = "Reporte_Precios_" . date('Ymd_His') . ".xls";

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        exit;
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'reporte_precios'));
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['bodega'] = null;
            $valores['tipo'] = null;
            $valores['tipo'] = null;
            $valores['motivo'] = null;
            $valores['nombrebuscar'] = null;
            sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'reporte_precios');
        }

        $this->form = new ConsultaParaKardexForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'reporte_precios');
                $this->redirect('reporte_precios/index');
            }
        }
        $fechaInicio = $valores['fechaInicio'];
        $fechaFin = $valores['fechaFin'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $query = " select  usu.usuario,   DATE_FORMAT(fecha, '%d/%m/%Y %H:%i') AS fecha,  'Actualizacion General ' as tipo, codigo_sku, pro.nombre,  det.producto_id,det.precio, 0 precio_lista from precio_producto p ";
        $query .= " inner join precio_producto_detalle det on p.id=det.precio_producto_id  ";
        $query .= " inner join usuario usu on p.usuario_id=usu.id  ";
        $query .= " inner join producto  pro on pro.id=det.producto_id  ";
        $query .= " where pro.empresa_id =" . $empresaId;
        $query .= " and fecha >= '" . $fechaInicio . " 01:00' and fecha <  '" . $fechaFin . " 23:59' ";
        if ($valores['nombrebuscar']) {
            $nombre = trim($valores['nombrebuscar']);
            $query .= " and  ( pro.codigo_sku like  '%" . $nombre . "%' or pro.nombre like  '%" . $nombre . "%')";
        }
        $query .= " UNION ALL ";
        $query .= " select usuario, DATE_FORMAT(fecha, '%d/%m/%Y %H:%i') fecha, CONCAT('Venta ', op.codigo) tipo,codigo_sku ,pro.nombre, producto_id,valor_unitario precio";
        $query .= " ,precio_lista from  operacion_detalle d inner join operacion op on op.id=d.operacion_id  inner join producto  pro on pro.id=d.producto_id   where precio_lista >0 ";
        $query .= " and precio_lista <> valor_unitario ";
        $query .= " and op.empresa_id =" . $empresaId;
        if ($valores['nombrebuscar']) {
            $nombre = trim($valores['nombrebuscar']);
            $query .= "  and ( pro.codigo_sku like  '%" . $nombre . "%' or pro.nombre like  '%" . $nombre . "%')";
        }
        $query .= " and fecha >= '" . $fechaInicio . " 01:00' and fecha <  '" . $fechaFin . " 23:59'";







$query = " SELECT  
            usu.usuario,   
            DATE_FORMAT(p.fecha, '%d/%m/%Y %H:%i') AS fecha,      
            COALESCE(bb.tipo, 'CambiaPrecio') AS tipo, 
            codigo_sku, 
            pro.nombre,  
            det.producto_id,
            det.precio,  
            0 AS precio_lista 
        FROM precio_producto p ";

$query .= " INNER JOIN precio_producto_detalle det 
            ON p.id = det.precio_producto_id ";

$query .= " INNER JOIN usuario usu 
            ON p.usuario_id = usu.id ";

$query .= " INNER JOIN producto pro  
            ON pro.id = det.producto_id ";

$query .= " LEFT JOIN bitacora_cambio bb  
            ON TRIM(bb.observaciones) = CAST(p.id AS CHAR) ";

$query .= " WHERE pro.empresa_id = " . $empresaId;

$query .= " AND p.fecha >= '" . $fechaInicio . " 01:00' 
            AND p.fecha < '" . $fechaFin . " 23:59' ";

// $query .= " AND COALESCE(bb.tipo, 'CambiaPrecio') = 'CambioCosto' ";

        
        $query .= " order by codigo_sku, fecha";
        $con = Propel::getConnection();
        $stmt = $con->prepare($query);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->registros = $result;
    }

}
