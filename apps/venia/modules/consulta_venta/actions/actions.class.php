<?php

class consulta_ventaActions extends sfActions {

    private function obtenerReporteVentasSaldoConsolidado($valores) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');

        $detalle = ProyectoQuery::obtenerReporteVentasSaldo($empresaId, $valores);

        $facturas = [];
        $totalDetalle = 0;
        foreach ($detalle as $d) {
//        if ($d['codigo_factura'] == '1COTI2793') {
//
//    echo $d['codigo_producto']
//        ." | "
//        .$d['cantidad']
//        ." | "
//        .$d['valor_total']
//        ."<br>";
//
//}
            $totalDetalle += $d['valor_total'];
            $codigo = $d['codigo_factura'];

            if (!isset($facturas[$codigo])) {

                $facturas[$codigo] = array(
                    'codigo_tienda' => $d['tienda'],
                    'codigo' => $codigo,
                    'fecha_real' => DateTime::createFromFormat('d/m/y', $d['fecha'])->format('Y-m-d'),
                    'fecha' => $d['fecha'],
                    'usuario' => $d['usuario'],
                    'cliente' => $d['cliente'],
                    'nombre' => $d['nombre'],
                    'nit' => '',
                    'estatus' => $d['estatus'],
                    'valor' => 0,
                    'face_firma' => '',
                    'vendedor' => $d['vendedor'],
                    'valor_pagado' => $d['valor_pagado']
                );
            }

            // ESTA ES LA DIFERENCIA
            $facturas[$codigo]['valor'] += $d['valor_total'];
        }

//    $totalDetalle = 0;
//
//foreach ($detalle as $d) {
//    $totalDetalle += $d['valor_total'];
//}
//
//die(
//    'Registros: '.count($detalle).
//    '<br>Total detalle: '.number_format($totalDetalle,2)
// );
//    echo "<pre>";
//
//foreach ($facturas as $f) {
//
//    if ($f['codigo'] == '1COTI2793') {
//
//        print_r($f);
//
//    }
//
//}
//
//die();
        usort($facturas, function($a, $b) {

            if ($a['fecha_real'] == $b['fecha_real']) {
                return strcmp($a['codigo'], $b['codigo']);
            }

            return strcmp($a['fecha_real'], $b['fecha_real']);
        });

        return array_values($facturas);
    }



    /* =========================================
     * 🔥 ARMAR FILTROS DINÁMICOS (CLAVE)
     * ========================================= */

    private function getFiltros($valores) {

//        echo "<pre>";
//        print_r($valores);
//        die();
//        
        $filtros = "";

        // 🔹 BODEGA
        if (!empty($valores['bodega'])) {
            $filtros .= " AND op.tienda_id = " . (int) $valores['bodega'];
        }

        // 🔹 VENDEDOR
        if (isset($valores['vendedor']) && $valores['vendedor'] !== '') {

            if ($valores['vendedor'] == '-99') {
                $filtros .= " AND op.vendedor_id IS NOT NULL ";
            } else {
                $filtros .= " AND op.vendedor_id = " . (int) $valores['vendedor'];
            }
        }

        // 🔹 BUSQUEDA
        if (!empty($valores['busqueda'])) {
            $busqueda = addslashes($valores['busqueda']);
            $filtros .= " AND op.nombre LIKE '%{$busqueda}%'";
        }

        // 🔹 CLIENTE
        if (!empty($valores['cliente'])) {
            $cliente = addslashes($valores['cliente']);
            $filtros .= " AND (
                cli.nombre LIKE '%{$cliente}%'
                OR cli.codigo LIKE '%{$cliente}%'
            )";
        }

        return $filtros;
    }

        /* =========================================
     * 🔥 QUERY UNIFICADO
     * ========================================= */
private function getQuery($valores)
{
    $fi = explode('/', $valores['fechaInicio']);
    $fechaInicio = $fi[2] . '-' . $fi[1] . '-' . $fi[0];

    $ff = explode('/', $valores['fechaFin']);
    $fechaFin = $ff[2] . '-' . $ff[1] . '-' . $ff[0];

    $filtros = $this->getFiltros($valores);
$empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
    return "
    SELECT * FROM (

    /* ===== VENTAS ===== */
    SELECT
        tt.codigo AS codigo_tienda,
        op.codigo,
        op.fecha AS fecha_real,
        DATE_FORMAT(op.fecha,'%d/%m/%Y ') AS fecha,
        op.usuario,
        cli.codigo AS cliente,
        op.nombre,
        cli.nit,
        'VENTA' AS estatus,
        op.valor_total AS valor,
        op.face_firma,
        ve.nombre AS vendedor,
        op.valor_pagado

    FROM operacion op
    LEFT JOIN cliente cli ON cli.id = op.cliente_id
    LEFT JOIN vendedor ve ON ve.id = op.vendedor_id
    LEFT JOIN tienda tt ON tt.id = op.tienda_id

    WHERE op.fecha BETWEEN '{$fechaInicio} 00:00:00' AND '{$fechaFin} 23:59:59'
    {$filtros}  and op.empresa_id = {$empresaId}

    UNION ALL

    /* ===== ANULADAS SIN NOTA ===== */
    SELECT
        tt.codigo,
        CONCAT(op.codigo, ' - ANULADO') AS codigo,
        op.fecha_anulo AS fecha_real,
        DATE_FORMAT(op.fecha_anulo,'%d/%m/%Y %H:%i'),
        op.usuario,
        cli.codigo,
        op.nombre,
        cli.nit,
        'ANULADO',
        op.valor_total * -1 AS valor,
        op.anula_face_firma face_firma,
        ve.nombre,
        0 AS valor_pagado

    FROM operacion op
    LEFT JOIN cliente cli ON cli.id = op.cliente_id
    LEFT JOIN vendedor ve ON ve.id = op.vendedor_id
    LEFT JOIN tienda tt ON tt.id = op.tienda_id

    WHERE op.anulado = 1
    AND op.fecha_anulo BETWEEN '{$fechaInicio} 00:00:00' AND '{$fechaFin} 23:59:59'
    AND NOT EXISTS (
        SELECT 1 FROM nota_credito nc WHERE nc.documento = op.codigo
    )
    {$filtros} and op.empresa_id = {$empresaId}


    UNION ALL

    /* ===== NOTAS DE CRÃ‰DITO ===== */
    SELECT
        tt.codigo,
        CONCAT(nc.documento, ' - ', nc.codigo) AS codigo,
        nc.fecha AS fecha_real,
        DATE_FORMAT(nc.fecha,'%d/%m/%Y %H:%i'),
        op.usuario,
        cli.codigo,
        op.nombre,
        cli.nit,
        'NOTA CREDITO',
        nc.valor_total * -1 AS valor,
        op. anula_face_firma face_firma,
        ve.nombre,
        0 AS valor_pagado

    FROM nota_credito nc
    INNER JOIN operacion op ON op.codigo = nc.documento
    LEFT JOIN cliente cli ON cli.id = op.cliente_id
    LEFT JOIN vendedor ve ON ve.id = op.vendedor_id
    LEFT JOIN tienda tt ON tt.id = op.tienda_id

    WHERE nc.fecha BETWEEN '{$fechaInicio} 00:00:00' AND '{$fechaFin} 23:59:59'
    {$filtros}   and op.empresa_id = {$empresaId}

    ) t

    ORDER BY t.fecha_real ASC
    ";
}
    /* =========================================
     * 🔥 QUERY UNIFICADO
     * ========================================= */

 

    /* =========================================
     * 🔥 EXPORT EXCEL
     * ========================================= */

    public function executeReporteExcel(sfWebRequest $request) {
                         $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');

        $valores = unserialize(
                sfContext::getInstance()->getUser()->getAttribute('datosConsultaRecibo', null, 'consulta')
        );

        if (!$valores) {
            die('Debe aplicar filtros');
        }

        if ($valores['tipo_reporte'] == "VENTA_NETA") {

            $registros = $this->obtenerReporteVentasSaldoConsolidado($valores);
        } else {

      $query = $this->getQuery($valores);

    $con = Propel::getConnection();
    $stmt = $con->prepare($query);
    $stmt->execute();
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        $xl = sfContext::getInstance()->getUser()->nuevoExcel("REPORTE", array('Reporte'), 'Reporte');
        $hoja = $xl->setActiveSheetIndex(0);

        $headers = array(
            "TIENDA", "CODIGO", "FECHA", "USUARIO", "CLIENTE",
            "NOMBRE", "RUC", "ESTADO", "VALOR", 
            "VENDEDOR", "VALOR PAGADO"
        );

        $fila = 1;
        $col = 0;

        // 🔥 ENCABEZADOS
        foreach ($headers as $h) {
            $hoja->setCellValueByColumnAndRow($col++, $fila, $h);
        }

        // 🔥 ESTILO ENCABEZADO
        $hoja->getStyle("A1:L1")->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 11
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'D9D9D9')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        // 🔥 congelar encabezado
        $hoja->freezePane('A2');

        $fila++;

        $total = 0;
        $totalPagado = 0;

        foreach ($registros as $r) {

            $col = 0;

            $hoja->setCellValueByColumnAndRow($col++, $fila, $r['codigo_tienda']);
            $hoja->setCellValueByColumnAndRow($col++, $fila, $r['codigo']);
            $hoja->setCellValueByColumnAndRow($col++, $fila, $r['fecha']);
            $hoja->setCellValueByColumnAndRow($col++, $fila, $r['usuario']);
            $hoja->setCellValueByColumnAndRow($col++, $fila, $r['cliente']);
            $hoja->setCellValueByColumnAndRow($col++, $fila, $r['nombre']);
            $hoja->setCellValueByColumnAndRow($col++, $fila, $r['nit']);
            $hoja->setCellValueByColumnAndRow($col++, $fila, $r['estatus']);

            $hoja->setCellValueByColumnAndRow($col++, $fila, (float) $r['valor']);
            $hoja->setCellValueByColumnAndRow($col++, $fila, $r['vendedor']);
            $hoja->setCellValueByColumnAndRow($col++, $fila, (float) $r['valor_pagado']);

            $total += (float) $r['valor'];
            $totalPagado += (float) $r['valor_pagado'];

            $fila++;
        }

        // 🔥 TOTALES
        $hoja->setCellValue("H{$fila}", "TOTALES");
        $hoja->setCellValue("I{$fila}", $total);
        $hoja->setCellValue("K{$fila}", $totalPagado);

        // 🔥 estilo totales
        $hoja->getStyle("H{$fila}:K{$fila}")->applyFromArray(array(
            'font' => array('bold' => true),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'F2F2F2')
            )
        ));

        // 🔥 FORMATO NUMÉRICO
        $hoja->getStyle("I2:I{$fila}")
                ->getNumberFormat()
                ->setFormatCode('#,##0.00');

        $hoja->getStyle("L2:L{$fila}")
                ->getNumberFormat()
                ->setFormatCode('#,##0.00');

        // 🔥 AUTO ANCHO COLUMNAS
        foreach (range('A', 'K') as $col) {
            $hoja->getColumnDimension($col)->setAutoSize(true);
        }

        // 🔥 bordes a toda la tabla
        $hoja->getStyle("A1:K{$fila}")
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // 🔥 salida
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="reporte.xls"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $writer->save('php://output');

        exit;
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
                         $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');

        // 🔹 valores desde sesión
        $valores = unserialize(
                sfContext::getInstance()->getUser()->getAttribute('datosConsultaRecibo', null, 'consulta')
        );

        if (!$valores) {
            $valores = array(
                'fechaInicio' => date('d/m/Y'),
                'fechaFin' => date('d/m/Y'),
                'bodega' => '',
                'vendedor' => '',
                'busqueda' => '',
                'cliente' => '',
                'tipo_reporte' => ''
            );
        }

        // 🔹 guardar si viene POST
        if ($request->isMethod('post')) {
            $valores = $request->getParameter('consulta');
            sfContext::getInstance()->getUser()->setAttribute('datosConsultaRecibo', serialize($valores), 'consulta');
        }




        if ($valores['tipo_reporte'] == "VENTA_NETA") {

            $this->registros = $this->obtenerReporteVentasSaldoConsolidado($valores);
        } else {
          
    $query = $this->getQuery($valores);

    $con = Propel::getConnection();
    $stmt = $con->prepare($query);
    $stmt->execute();

    $this->registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }



        // 🔹 form
        $this->form = new ConsultaFechaDatosForm($valores);
    }

}
