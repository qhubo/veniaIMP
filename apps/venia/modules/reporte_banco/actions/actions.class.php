<?php

/**
 * reporte_banco actions.
 *
 * @package    plan
 * @subpackage reporte_banco
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporte_bancoActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsuFE', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = $EmpresaQuery->getNombre();
        $pestanas[] = 'Movimientos Bancarios';

        $nombreEMpresa = $EmpresaQuery->getNombre();
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $filename = "Movimientos_Bancarios_" . $nombreEMpresa . date("d_m_Y");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $hoja = $xl->setActiveSheetIndex(0);
        //CABECERA  Y FILTRO
        $hoja->getRowDimension('1')->setRowHeight(15);
        $hoja->getRowDimension('2')->setRowHeight(20);

        $hoja->mergeCells("A1:A2");
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit(strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(13);
        // $hoja->getStyle("B1")->applyFromArray($styleArray);

        date_default_timezone_set("America/Guatemala");

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaMOVBanco', null, 'consulta'));
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['banco'] = null;
            $valores['tipo'] = null;
            sfContext::getInstance()->getUser()->setAttribute('datoconsultaMOVBanco', serialize($valores), 'consulta');
        }
        $dolares =0;
        $bancoQ = BancoQuery::create()->findOneById($valores['banco']);
        if ($bancoQ) {
        $dolares=$bancoQ->getDolares();
        }
        
        $textoBusqueda = $this->textobusqueda($valores);
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '00:00';
        $valores['fin'] = '23:00';
        $hoja->getCell("C1")->setValueExplicit("Movimientos Bancos ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C1")->getFont()->setBold(true);
        $hoja->getStyle("C1")->getFont()->setSize(10);

        $hoja->mergeCells("C1:E1");
        $hoja->getCell("B2")->setValueExplicit("Busqueda ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B2")->getFont()->setBold(true);
        $hoja->getStyle("B2")->getFont()->setSize(10);
        $hoja->getCell("C2")->setValueExplicit($textoBusqueda, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle('C2')->getAlignment()->setWrapText(true);
        $hoja->mergeCells("C2:E2");
        $fila = 3;
        $columna = 0;
        $encabezados = null;

        $encabezados[] = array("Nombre" => strtoupper("Fecha"), "width" => 12, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Banco"), "width" => 30, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Movimiento"), "width" => 25, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Documento"), "width" => 20, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Observaciones"), "width" => 40, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Detalle"), "width" => 35, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Valor"), "width" => 18, "align" => "rigth", "format" => "#,##0.00");
        if ($dolares) { 
        $encabezados[] = array("Nombre" => strtoupper("Tasa Cambio"), "width" => 24, "align" => "rigth", "format" => "#,##0.00000");
        $encabezados[] = array("Nombre" => strtoupper("Valor Banco"), "width" => 24, "align" => "rigth", "format" => "#,##0.00");
                  } 
                                
        
        $encabezados[] = array("Nombre" => strtoupper("Usuario"), "width" => 14, "align" => "left", "format" => "#,##0");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $operaciones = new MovimientoBancoQuery();
        $operaciones->orderByFechaDocumento("Desc");
        if ($valores['tipo']) {
            if (($valores['tipo'] <> "Transferencia") && ($valores['tipo'] <> "Ventas") && ($valores['tipo'] <> "NoVentas")) {
                $operaciones->filterByVentaResumidaLineaId(null);
                $operaciones->filterByTipo($valores['tipo']);
            }
            if ($valores['tipo'] == "Ventas") {
                $operaciones->filterByVentaResumidaLineaId(null, Criteria::NOT_EQUAL);
            }
            if ($valores['tipo'] == "Transferencia") {
                $operaciones->filterByTipoMovimiento("Transferencia");
            }

            if ($valores['tipo'] == "NoVentas") {
                $operaciones->filterByVentaResumidaLineaId(null);
            }
        }
        $operaciones->where("MovimientoBanco.FechaDocumento >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'");
        $operaciones->where("MovimientoBanco.FechaDocumento <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'");
        if ($valores['banco']) {
            $operaciones->filterByBancoId($valores['banco']);
        }
        $this->operaciones = $operaciones->find();

  
        
        //  $hoja->getStyle("A" . $fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($color);
        $TOTAL = 0;
        foreach ($this->operaciones as $regi) {
            $fila++;
            $datos = null;
//            $TOTAL = $TOTAL + $data->getValor();
            $datos[] = array("tipo" => 3, "valor" => $regi->getFechaDocumento('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regi->getBancoRelatedByBancoId()->getNombre());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => strtoupper($regi->getTipo()) . " " . strtoupper($regi->getTipoMovimiento()));  // ENTERO
            if (!$regi->getVentaResumidaLineaId()) {
                $datos[] = array("tipo" => 3, "valor" => $regi->getDocumento());  // ENTERO  
            } else {
                $datos[] = array("tipo" => 3, "valor" => "");  // ENTERO  
            }

            $datos[] = array("tipo" => 3, "valor" => $regi->getObservaciones());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regi->getDetalleMovimiento());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => abs($regi->getValor()));  // ENTERO
                 if ($dolares) { 
                           $valorQ=abs($regi->getValor()); 
                         $valorDolar = $valorQ/ $regi->getTasaCambio(); 
            $datos[] = array("tipo" => 2, "valor" => $regi->getTasaCambio());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" =>$valorDolar );  // ENTERO                     
                 }
            $datos[] = array("tipo" => 3, "valor" => $regi->getUsuario());  // ENTERO
            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;
//        $hoja->getCell("E" . $fila)->setValueExplicit("TOTALES ", PHPExcel_Cell_DataType::TYPE_STRING);
//        $hoja->getStyle("E" . $fila)->getFont()->setBold(true);
//        $hoja->getStyle("E" . $fila)->getFont()->setSize(12);
//        //$hoja->mergeCells("F" . $fila . ":G" . $fila);
//        $hoja->getCell("H" . $fila)->setValueExplicit(round($TOTAL, 2), PHPExcel_Cell_DataType::TYPE_NUMERIC);
//        $hoja->getStyle("H" . $fila)->getFont()->setBold(true);
//        $hoja->getStyle("H" . $fila)->getFont()->setSize(12);
//        $fila++;
//        $LetraFin = UsuarioQuery::numeroletra(7);
//        $hoja->getCell("A" . $fila)->setValueExplicit("ULTIMA LINEA", PHPExcel_Cell_DataType::TYPE_STRING);
//        $hoja->mergeCells("B" . $fila . ":" . $LetraFin . $fila);

        $hoja = $xl->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function textobusqueda($valores) {
        $textoBusqueda = '';
        $Busqueda = null;

        foreach ($valores as $clave => $valor) {
            $clave = trim(strtoupper($clave));
//            echo $clave;
//            echo "<br>";
            if ($valor) {
                if ($clave == 'FECHAINICIO') {
                    $Busqueda[] = 'DEL ' . $valor;
                }
                if ($clave == 'FECHAFIN') {
                    $Busqueda[] = ' AL  ' . $valor;
                }
                if ($clave == 'USUARIO') {
                    $query = UsuarioQuery::create()->findOneById($valor);
                    if ($query) {
                        $valor = $query->getUsuario();
                    }
                    $Busqueda[] = ' USUARIO: ' . $valor;
                }
            }
        }
        if ($Busqueda) {
            $textoBusqueda = implode(",", $Busqueda);
        }
        return $textoBusqueda;
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaMOVBanco', null, 'consulta'));
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['banco'] = null;
            $valores['tipo'] = null;
            sfContext::getInstance()->getUser()->setAttribute('datoconsultaMOVBanco', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaReporteBancoForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsultaMOVBanco', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaMOVBanco', null, 'consulta'));
                $this->redirect('reporte_banco/index?id=');
            }
        }
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '00:00';
        $valores['fin'] = '23:00';

        $operaciones = new MovimientoBancoQuery();
        $operaciones->orderByFechaDocumento("Desc");
        if ($valores['tipo']) {
            if (($valores['tipo'] <> "Transferencia") && ($valores['tipo'] <> "Ventas") && ($valores['tipo'] <> "NoVentas")) {
                $operaciones->filterByVentaResumidaLineaId(null);
                $operaciones->filterByTipo($valores['tipo']);
            }
            if ($valores['tipo'] == "Ventas") {
                $operaciones->filterByVentaResumidaLineaId(null, Criteria::NOT_EQUAL);
            }
            if ($valores['tipo'] == "Transferencia") {
                $operaciones->filterByTipoMovimiento("Transferencia");
            }

            if ($valores['tipo'] == "NoVentas") {
                $operaciones->filterByVentaResumidaLineaId(null);
            }
        }
        $operaciones->where("MovimientoBanco.FechaDocumento >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'");
        $operaciones->where("MovimientoBanco.FechaDocumento <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'");
        if ($valores['banco']) {
            $operaciones->filterByBancoId($valores['banco']);
        }
        $this->operaciones = $operaciones->find();
        
        $this->dolares =0;
        $bancoQ = BancoQuery::create()->findOneById($valores['banco']);
        if ($bancoQ) {
            $this->dolares=$bancoQ->getDolares();
        }
       
    }

}
