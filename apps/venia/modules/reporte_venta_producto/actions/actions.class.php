<?php

class reporte_venta_productoActions extends sfActions {

    public function executeReporteExcel(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
            $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
                
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datosConsultaRecibo', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('datosConsultaRecibo', serialize($valores), 'consulta');
        }
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = $EmpresaQuery->getNombre();
        $pestanas[] = 'Ventas Producto';
        $filename = "Ventas Producto " . $nombreempresa . date("d_m_Y");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $hoja = $xl->setActiveSheetIndex(0);
        //CABECERA  Y FILTRO
        $hoja->getRowDimension('1')->setRowHeight(15);
        $hoja->getRowDimension('2')->setRowHeight(20);

        $hoja->mergeCells("A1:A2");
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit(strtoupper($nombreempresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(13);
        // $hoja->getStyle("B1")->applyFromArray($styleArray);

        $hoja->getCell("C1")->setValueExplicit("Reporte Venta por Productos ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C1")->getFont()->setBold(true);
        $hoja->getStyle("C1")->getFont()->setSize(10);

        $textoBusqueda = $valores['fechaInicio'] . "  " . $valores['fechaFin'];
        $hoja->mergeCells("C1:E1");
        $hoja->getCell("B2")->setValueExplicit("Fecha  ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B2")->getFont()->setBold(true);
        $hoja->getStyle("B2")->getFont()->setSize(10);
        $hoja->getCell("C2")->setValueExplicit($textoBusqueda, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle('C2')->getAlignment()->setWrapText(true);
        $hoja->mergeCells("C2:E2");


        $fila = 3;
        $columna = 0;
        $encabezados = null;
        $encabezados[] = array("Nombre" => strtoupper("Fecha"), "width" => 16, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Vendedor"), "width" => 20, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Usuario"), "width" => 16, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Código Producto"), "width" => 22, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Descripcion"), "width" => 30, "align" => "left", "format" => "#,##0.");
        $encabezados[] = array("Nombre" => strtoupper("Valor Unitario"), "width" => 16, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Cantidad"), "width" => 14, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Valor Total"), "width" => 18, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Valor Neto"), "width" => 18, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Costo Total"), "width" => 17, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Margen"), "width" => 17, "align" => "left", "format" => "#,##0.00");

        $encabezados[] = array("Nombre" => strtoupper("Código Factura"), "width" => 18, "align" => "left", "format" => "#,##");
        $encabezados[] = array("Nombre" => strtoupper("Cliente"), "width" => 14, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Nombre Factura"), "width" => 25, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Estatus"), "width" => 16, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Valor Factura"), "width" => 18, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Valor Pagado"), "width" => 18, "align" => "left", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '01:00';
        $valores['fin'] = '23:00';

        $query = "select tt.nombre tienda, op.codigo codigo_factura,  cli.codigo cliente, op.nombre, op.estatus, DATE_FORMAT(op.fecha, '%d/%m/%y')  fecha, ve.nombre vendedor, ";
        $query .= " op.usuario, op.valor_total, op.valor_pagado, de.codigo codigo_producto, de.detalle, de.cantidad, de.valor_unitario, ";
        $query .= " de.valor_total, pro.costo_proveedor   from operacion  op left join operacion_detalle de  on op.id= de.operacion_id  left join ";
        $query .= "vendedor ve on ve.id = op.vendedor_id  left join cliente cli on cli.id= op.cliente_id ";
        $query .= "left join producto pro on pro.id = producto_id  left join tienda tt on tt.id= op.tienda_id ";
        $query .= " where op.empresa_id= ".$empresaId." and op.anulado=0 and  de.cantidad >0 and  op.fecha  >= '" . $fechaInicio . " 00:00:00' and op.fecha <= '" . $fechaFin . " 23:59'";
        if ($valores['vendedor']) {
            $query .= "  and  vendedor_id = " . $valores['vendedor'] . " ";
        }
           if ($valores['bodega']) {
            $query .= "  and  tienda_id = " . $valores['bodega'] . " ";
        }
        if ($valores['busqueda']) {
            $query .= "  and  op.nombre like '%" . $valores['busqueda'] . "%'";
        }
        if ($valores['cliente']) {
            $query .= " and  ( cli.nombre like  '%" . $valores['cliente'] . "%' or cli.codigo like  '%" . $valores['cliente'] . "%' ) ";
        }
        if ($valores['producto']) {
            $query .= " and  ( pro.nombre like  '%" . $valores['producto'] . "%' or pro.codigo_sku like  '%" . $valores['producto'] . "%' ) ";
        }

        $query .= " order by op.fecha";
        $con = Propel::getConnection();
        $stmt = $con->prepare($query);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->registros = $result;
//       die();



        $con = Propel::getConnection();
        $stmt = $con->prepare($query);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->registros = $result;
        $total = 0;
        $totalNETO=0;
        $totalCOSTO=0;
        $totalMARGEN=0;
        foreach ($this->registros as $registro) {
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $registro['fecha']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['vendedor']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['usuario']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['codigo_producto']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['detalle']);  // ENTERO

            $datos[] = array("tipo" => 2, "valor" => round($registro['valor_unitario'], 2));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['cantidad']);  // ENTERO
            $valor_neto = $registro['cantidad'] * $registro['valor_unitario'];
            $valor_neto = $valor_neto / 1.12;
          
            $datos[] = array("tipo" => 2, "valor" => round($registro['cantidad'] * $registro['valor_unitario'], 2));  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => round($valor_neto, 2));  // ENTERO

            $valorCosto = round($registro['cantidad'] * $registro['costo_proveedor'], 1);
            $datos[] = array("tipo" => 2, "valor" => round($registro['cantidad'] * $registro['costo_proveedor'], 2));  // ENTERO
            $valorMargen = $valor_neto - $valorCosto;
            $datos[] = array("tipo" => 2, "valor" => round($valorMargen, 2));  // ENTERO
  $totalNETO= $totalNETO+$valor_neto;
            $totalCOSTO= $totalCOSTO +$valorCosto;

            $totalMARGEN= $totalMARGEN +$valorMargen;

            $datos[] = array("tipo" => 3, "valor" => $registro['codigo_factura']);  // ENTERO
            if ($reg['cliente'] <> "CONTRAENTREGA") {
                $datos[] = array("tipo" => 3, "valor" => $registro['cliente']);  // CONTRAENTREGA
            } else {
                $datos[] = array("tipo" => 3, "valor" => '');  // CONTRAENTREGA
            }
            $datos[] = array("tipo" => 3, "valor" => $registro['nombre']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['estatus']);  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => round($registro['valor_total'], 2));  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => round($registro['valor_pagado'], 2));  // ENTERO




            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;
        
        
         $hoja->getStyle("D" . $fila)->getFont()->setBold(true);
        $hoja->getStyle("D" . $fila)->getFont()->setSize(14);
             $hoja->getCell("D" . $fila)->setValueExplicit("TOTALES", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("I" . $fila)->getFont()->setBold(true);
        $hoja->getStyle("I" . $fila)->getFont()->setSize(14);
        $hoja->getCell("I" . $fila)->setValueExplicit(ROUND($totalNETO,2), PHPExcel_Cell_DataType::TYPE_STRING);
         $hoja->getStyle("J" . $fila)->getFont()->setBold(true);
        $hoja->getStyle("J" . $fila)->getFont()->setSize(14);
        $hoja->getCell("J" . $fila)->setValueExplicit(round($totalCOSTO,2), PHPExcel_Cell_DataType::TYPE_STRING);
                 $hoja->getStyle("K" . $fila)->getFont()->setBold(true);
        $hoja->getStyle("K" . $fila)->getFont()->setSize(14);
        $hoja->getCell("K" . $fila)->setValueExplicit(round($totalMARGEN,2), PHPExcel_Cell_DataType::TYPE_STRING);
// $datos = null;
//      $datos[] = array("tipo" => 3, "valor" => 'TOTALES');  // ENTERO
//          $datos[] = array("tipo" => 3, "valor" => '');  // ENTERO
//             $datos[] = array("tipo" => 3, "valor" => '');  // ENTERO
//             $datos[] = array("tipo" => 3, "valor" => '');  // ENTERO
//            $datos[] = array("tipo" => 3, "valor" =>'TOTALES');  // ENTERO
//
//            $datos[] = array("tipo" => 3, "valor" => '');  // ENTERO
//            $datos[] = array("tipo" => 3, "valor" =>'');  // ENTERO
//            
//            $datos[] = array("tipo" => 3, "valor" => '');  // ENTERO
//            $datos[] = array("tipo" => 2, "valor" => round($totalNETO, 2));  // ENTERO
//              $datos[] = array("tipo" => 2, "valor" => round($totalCOSTO, 2));  // ENTERO
//             $datos[] = array("tipo" => 2, "valor" => round($totalMARGEN, 2));  // ENTERO
//             
//            
//        $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
                  
        $hoja = $xl->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeIndex(sfWebRequest $request) {
            $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
                
        error_reporting(-1);
        $acceso = MenuSeguridad::Acceso('pagos_realizado');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datosConsultaRecibo', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['vendedor'] = null;
            $valores['busqueda'] = null;
            $valores['cliente'] = null;
            $valores['medio_pago'] = null;
            $valores['producto'] = null;
            $valores['bodega'] = null;
            sfContext::getInstance()->getUser()->setAttribute('datosConsultaRecibo', serialize($valores), 'consulta');
        }

//        echo "<pre>";
//        print_r($valores);
//        die();
        $this->form = new ConsultaFechaDatosForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datosConsultaRecibo', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datosConsultaRecibo', null, 'consulta'));
                $this->redirect('reporte_venta_producto/index?id=1');
            }
        }
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '01:00';
        $valores['fin'] = '23:00';

        $query = "select tt.nombre tienda, op.codigo codigo_factura,  cli.codigo cliente, op.nombre, op.estatus, DATE_FORMAT(op.fecha, '%d/%m/%y')  fecha, ve.nombre vendedor, ";
        $query .= " op.usuario, op.valor_total, op.valor_pagado, de.codigo codigo_producto, de.detalle, de.cantidad, de.valor_unitario, ";
        $query .= " de.valor_total, pro.costo_proveedor   from operacion  op left join operacion_detalle de  on op.id= de.operacion_id  left join ";
        $query .= "vendedor ve on ve.id = op.vendedor_id  left join cliente cli on cli.id= op.cliente_id ";
        $query .= "left join producto pro on pro.id = producto_id   left join tienda tt on tt.id= op.tienda_id ";
        $query .= " where op.empresa_id= ".$empresaId." and  op.anulado=0 and de.cantidad >0 and  op.fecha  >= '" . $fechaInicio . " 00:00:00' and op.fecha <= '" . $fechaFin . " 23:59'";
        if ($valores['vendedor']) {
            $query .= "  and  vendedor_id = " . $valores['vendedor'] . " ";
        }
         if ($valores['bodega']) {
            $query .= "  and  tienda_id = " . $valores['bodega'] . " ";
        }
        if ($valores['busqueda']) {
            $query .= "  and  op.nombre like '%" . $valores['busqueda'] . "%'";
        }
        if ($valores['cliente']) {
            $query .= " and  ( cli.nombre like  '%" . $valores['cliente'] . "%' or cli.codigo like  '%" . $valores['cliente'] . "%' ) ";
        }
        if ($valores['producto']) {
            $query .= " and  ( pro.nombre like  '%" . $valores['producto'] . "%' or pro.codigo_sku like  '%" . $valores['producto'] . "%' ) ";
        }

        $query .= " order by op.fecha";
//        echo $query;
//        die();
        $con = Propel::getConnection();
        $stmt = $con->prepare($query);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->registros = $result;
//        echo "<pre>";
//        print_r($result);
//        die();
    }

}
