<?php

/**
 * libro_diario actions.
 *
 * @package    plan
 * @subpackage libro_diario
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class libro_diarioActions extends sfActions {

    public function executeReporte2(sfWebRequest $request) {
        $acceso = MenuSeguridad::Acceso('libro_diario');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }

        $this->fecha = date('d/m/Y');
        $this->tiendaver = $request->getParameter('tiendaver');
        if ($request->getParameter('fecha')) {
            $this->fecha = $request->getParameter('fecha');
        }
        $fechaFin = explode('/', $this->fecha);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

//        $listado = new VentaResumidaQuery();
//        $listado->filterByFecha($fechaFin);
//        $listado->useMedioPagoQuery();
//        if ($this->tiendaver) {
//            $listado->filterByTiendaId($this->tiendaver);
//        }
//
//
//        $cuotas = MedioPagoQuery::create()
//                ->groupByNumeroCuotas()
//                ->orderByNumeroCuotas()
//                ->find();
//        if ($request->getParameter('med')) {
//            $medioPago = MedioPagoQuery::create()->findOneById($request->getParameter('med'));
//            if ($medioPago) {
//                $cuotas = MedioPagoQuery::create()
//                        ->filterByNombre($medioPago->getNombre())
//                        ->groupByNumeroCuotas()
//                        ->orderByNumeroCuotas()
//                        ->find();
//                $listado->where("MedioPago.Nombre ='" . $medioPago->getNombre() . "'");
//            }
//        }
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoPart', null, 'consulta'));

        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $nombreempresa = "Libro Diario";
        $pestanas[] = 'Partidas';
        $nombre = "Libro Diario";

        $filename = "Libro_Diario" . $fechaFin;
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("LIBRO DIARIO  DEL " . $valores['fechaInicio'] . " AL " . $valores['fechaFin'], PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->mergeCells("A1:E1");

        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');

        $operaciones = $this->datos($valores);
        $fila = 2;
        if ($operaciones) {
            $hoja = $xl->setActiveSheetIndex(0);
            // ENCABEZADOS

            $encabezados = null;
            $encabezados[] = array("Nombre" => 'Partida', "width" => 20, "align" => "center", "format" => "@");
            $encabezados[] = array("Nombre" => 'Fecha', "width" => 20, "align" => "center", "format" => "@");
            $encabezados[] = array("Nombre" => 'Cuenta', "width" => 25, "align" => "left", "format" => "@");
            $encabezados[] = array("Nombre" => 'Descripcion', "width" => 45, "align" => "left", "format" => "@");
            $encabezados[] = array("Nombre" => 'Debe', "width" => 15, "align" => "left", "format" => "#,##0.00");
            $encabezados[] = array("Nombre" => 'Haber', "width" => 15, "align" => "left", "format" => "#,##0.00");
            $encabezados[] = array("Nombre" => 'Detalle', "width" => 35, "align" => "left", "format" => "#,##0.00");

            sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
            // ***  ENCEBEZADOS 


            $bandera = 0;
            $total1 = 0;
            $total2 = 0;
            $cantida = 0;

            foreach ($operaciones as $registro) {

                $fila++;
                $datos = null;
                $datos[] = array("tipo" => 3, "valor" => $registro->getPartida()->getNoAsiento());
                $datos[] = array("tipo" => 3, "valor" => $registro->getPartida()->getFechaContable('d/m/Y'));
                $datos[] = array("tipo" => 3, "valor" => $registro->getCuentaContable());  // ENTERO
                $datos[] = array("tipo" => 3, "valor" => $registro->getDetalle());  // ENTERO
                $datos[] = array("tipo" => 2, "valor" => round($registro->getDebe(), 2));  // ENTERO
                $datos[] = array("tipo" => 2, "valor" => round($registro->getHaber(), 2));  // ENTERO
                $datos[] = array("tipo" => 3, "valor" => $registro->getPartida()->getCompleto());
                sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
                if ($bandera <> $registro->getPartidaId()) {
                    $bandera = $registro->getPartidaId();
                    $total1 = 0;
                    $total2 = 0;
                }
                $total1 = $registro->getDebe() + $total1;
                $total2 = $registro->getHaber() + $total2;
            }
            $fila++;
        }


        $hoja = $xl->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        die();

        die('aqui');
    }

    public function executeReportePdf(sfWebRequest $request) {
        $acceso = MenuSeguridad::Acceso('libro_diario');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        $this->fecha = date('d/m/Y');
        $this->tiendaver = $request->getParameter('tiendaver');
        if ($request->getParameter('fecha')) {
            $this->fecha = $request->getParameter('fecha');
        }
        $fechaFin = explode('/', $this->fecha);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

//        $listado = new VentaResumidaQuery();
//        $listado->filterByFecha($fechaFin);
//        $listado->useMedioPagoQuery();
//        if ($this->tiendaver) {
//            $listado->filterByTiendaId($this->tiendaver);
//        }
//        $cuotas = MedioPagoQuery::create()
//                ->groupByNumeroCuotas()
//                ->orderByNumeroCuotas()
//                ->find();
//        if ($request->getParameter('med')) {
//            $medioPago = MedioPagoQuery::create()->findOneById($request->getParameter('med'));
//            if ($medioPago) {
//                $cuotas = MedioPagoQuery::create()
//                        ->filterByNombre($medioPago->getNombre())
//                        ->groupByNumeroCuotas()
//                        ->orderByNumeroCuotas()
//                        ->find();
//                $listado->where("MedioPago.Nombre ='" . $medioPago->getNombre() . "'");
//            }
//        }
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoPart', null, 'consulta'));
        $operaciones = $this->datos($valores);
        $html = $this->getPartial('libro_diario/reporte', array('operaciones' => $operaciones));
//        echo $html;
//        die();

        $PDF_HEADER_TITLE = "Libro Diario    ";
        $PDF_HEADER_STRING = " " . $valores['fechaInicio'] . " AL " . $valores['fechaFin'];
        $PDF_HEADER_LOGO = "logoC.png"; //Solo me funciona si esta dentro de la carpeta images de la libreria
        $nombre_archivo = "  LIBRO DIARIO  DEL " . $valores['fechaInicio'] . " AL " . $valores['fechaFin'];
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle($nombre_archivo);
        $pdf->SetSubject('Libro Diario Contable');
        $pdf->SetKeywords('Libro,Contbale, Gasto , Compra'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        //      $pdf->SetMargins(3, 5, 0, true);
        $pdf->SetMargins(0, 20);
        $pdf->SetHeaderData($PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//        $pdf->SetHeaderMargin(0.1);
//        $pdf->SetFooterMargin(0.1);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetFont('courier', '', 9);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $pdf->Output($nombre_archivo . '.pdf', 'I');

        die('kk');
    }

    public function executeReporte(sfWebRequest $request) {
        $this->fecha = date('d/m/Y');
        $this->tiendaver = $request->getParameter('tiendaver');
        if ($request->getParameter('fecha')) {
            $this->fecha = $request->getParameter('fecha');
        }
        $fechaFin = explode('/', $this->fecha);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

//        $listado = new VentaResumidaQuery();
//        $listado->filterByFecha($fechaFin);
//        $listado->useMedioPagoQuery();
//        if ($this->tiendaver) {
//            $listado->filterByTiendaId($this->tiendaver);
//        }
//
//
//        $cuotas = MedioPagoQuery::create()
//                ->groupByNumeroCuotas()
//                ->orderByNumeroCuotas()
//                ->find();
//        if ($request->getParameter('med')) {
//            $medioPago = MedioPagoQuery::create()->findOneById($request->getParameter('med'));
//            if ($medioPago) {
//                $cuotas = MedioPagoQuery::create()
//                        ->filterByNombre($medioPago->getNombre())
//                        ->groupByNumeroCuotas()
//                        ->orderByNumeroCuotas()
//                        ->find();
//                $listado->where("MedioPago.Nombre ='" . $medioPago->getNombre() . "'");
//            }
//        }
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoPart', null, 'consulta'));

        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $nombreempresa = "Libro Diario";
        $pestanas[] = 'Partidas';
        $nombre = "Libro Diario";

        $filename = "Libro_Diario" . $fechaFin;
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("LIBRO DIARIO  DEL " . $valores['fechaInicio'] . " AL " . $valores['fechaFin'], PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->mergeCells("A1:E1");

        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');

        $operaciones = $this->datos($valores);
        $fila = 2;
        if ($operaciones) {
            $hoja = $xl->setActiveSheetIndex(0);
            // ENCABEZADOS
            $hoja->getCell("A" . $fila)->setValueExplicit("PARTIDA", PHPExcel_Cell_DataType::TYPE_STRING);
            $hoja->getCell("B" . $fila)->setValueExplicit($operaciones[0]->getPartida()->getNoAsiento(), PHPExcel_Cell_DataType::TYPE_STRING);
            $hoja->getCell("C" . $fila)->setValueExplicit($operaciones[0]->getPartida()->getTipo() . " " . $operaciones[0]->getPartida()->getNoAsiento(), PHPExcel_Cell_DataType::TYPE_STRING);
            $hoja->mergeCells("C" . $fila . ":E" . $fila);
            $hoja->getStyle("B" . $fila)->getFont()->setBold(true);
            $hoja->getStyle("C" . $fila)->getFont()->setBold(true);
            $hoja->getStyle("B" . $fila)->getFont()->setSize(10);
            $hoja->getStyle("C" . $fila)->getFont()->setSize(10);

            $fila++;
            $encabezados = null;
            $encabezados[] = array("Nombre" => 'Partida', "width" => 20, "align" => "center", "format" => "@");
            $encabezados[] = array("Nombre" => 'Fecha', "width" => 20, "align" => "center", "format" => "@");
            $encabezados[] = array("Nombre" => 'Cuenta', "width" => 25, "align" => "left", "format" => "@");
            $encabezados[] = array("Nombre" => 'Debe', "width" => 15, "align" => "left", "format" => "#,##0.00");
            $encabezados[] = array("Nombre" => 'Haber', "width" => 15, "align" => "left", "format" => "#,##0.00");

            sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
            // ***  ENCEBEZADOS 


            $bandera = 0;
            $total1 = 0;
            $total2 = 0;
            $cantida = 0;

            foreach ($operaciones as $registro) {
                if ($bandera <> $registro->getPartidaId()) {
                    if ($total1 > 0) {
                        $fila++;
                        $encabezados = null;
                        $encabezados[] = array("Nombre" => 'Totales', "width" => 20, "align" => "center", "format" => "@");
                        $encabezados[] = array("Nombre" => '', "width" => 25, "align" => "left", "format" => "@");
                        $encabezados[] = array("Nombre" => '', "width" => 35, "align" => "left", "format" => "@");
                        $encabezados[] = array("Nombre" => round($total1, 2), "width" => 15, "align" => "right", "format" => "#,##0.00");
                        $encabezados[] = array("Nombre" => round($total2, 2), "width" => 15, "align" => "right", "format" => "#,##0.00");
                        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

                        $fila++;
                        $fila++;

                        $hoja->getCell("A" . $fila)->setValueExplicit("PARTIDA", PHPExcel_Cell_DataType::TYPE_STRING);
                        $hoja->getCell("B" . $fila)->setValueExplicit($registro->getPartida()->getNoAsiento(), PHPExcel_Cell_DataType::TYPE_STRING);
                        $hoja->getCell("C" . $fila)->setValueExplicit($registro->getPartida()->getTipo() . " " . $registro->getPartida()->getNoAsiento(), PHPExcel_Cell_DataType::TYPE_STRING);
                        $hoja->mergeCells("C" . $fila . ":E" . $fila);
                        $hoja->getStyle("B" . $fila)->getFont()->setBold(true);
                        $hoja->getStyle("C" . $fila)->getFont()->setBold(true);
                        $hoja->getStyle("B" . $fila)->getFont()->setSize(10);
                        $hoja->getStyle("C" . $fila)->getFont()->setSize(10);

                        $fila++;
                        $encabezados = null;
                        $encabezados[] = array("Nombre" => 'Partida', "width" => 20, "align" => "center", "format" => "@");
                        $encabezados[] = array("Nombre" => 'Fecha', "width" => 20, "align" => "center", "format" => "@");
                        $encabezados[] = array("Nombre" => 'Cuenta', "width" => 25, "align" => "left", "format" => "@");
                        $encabezados[] = array("Nombre" => 'Debe', "width" => 15, "align" => "left", "format" => "#,##0.00");
                        $encabezados[] = array("Nombre" => 'Haber', "width" => 15, "align" => "left", "format" => "#,##0.00");
                        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
                        // ***  ENCEBEZADOS 
                    }
                }
                $fila++;
                $datos = null;
                $datos[] = array("tipo" => 3, "valor" => $registro->getPartida()->getNoAsiento());
                $datos[] = array("tipo" => 3, "valor" => $registro->getPartida()->getFechaContable('d/m/Y'));
                $datos[] = array("tipo" => 3, "valor" => $registro->getCuentaContable());  // ENTERO
                $datos[] = array("tipo" => 2, "valor" => round($registro->getDebe(), 2));  // ENTERO
                $datos[] = array("tipo" => 2, "valor" => round($registro->getHaber(), 2));  // ENTERO
                sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
                if ($bandera <> $registro->getPartidaId()) {
                    $bandera = $registro->getPartidaId();
                    $total1 = 0;
                    $total2 = 0;
                }
                $total1 = $registro->getDebe() + $total1;
                $total2 = $registro->getHaber() + $total2;
            }
            $fila++;
            $encabezados = null;
            $encabezados[] = array("Nombre" => 'Totales', "width" => 20, "align" => "center", "format" => "@");
            $encabezados[] = array("Nombre" => '', "width" => 25, "align" => "left", "format" => "@");
            $encabezados[] = array("Nombre" => '', "width" => 35, "align" => "left", "format" => "@");
            $encabezados[] = array("Nombre" => round($total1, 2), "width" => 15, "align" => "right", "format" => "#,##0.00");
            $encabezados[] = array("Nombre" => round($total2, 2), "width" => 15, "align" => "right", "format" => "#,##0.00");
            sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        }


        $hoja = $xl->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        die();

        die('aqui');
    }

    public function executeIndex(sfWebRequest $request) {
        $acceso = MenuSeguridad::Acceso('libro_diario');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoPart', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $bodegaId = null;
        if ($usuarioQue) {
            $bodegaId = $usuarioQue->getTiendaId();
        }
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('seleccionDatoPart', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('seleccionDatoPart', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoPart', null, 'consulta'));
                $this->redirect('libro_diario/index');
            }
        }


        $this->operaciones = $this->datos($valores);
        //  die();
    }

    public function datos($valores) {
        // $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('selecciondato', null, 'consulta'));
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $operaciones = PartidaDetalleQuery::create();
        $operaciones->usePartidaQuery();
        $operaciones->where("Partida.Confirmada=1");
        $operaciones->where("Partida.FechaContable >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Partida.FechaContable <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->orderByPartidaId();
        $operaciones = $operaciones->find();
        return $operaciones;
    }

}
