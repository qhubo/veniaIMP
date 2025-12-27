<?php

/**
 * libro_mayor actions.
 *
 * @package    plan
 * @subpackage libro_mayor
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class libro_mayorActions extends sfActions {

    public function executeConfirma(sfWebRequest $request) {
        $this->id = $request->getParameter('id');
        $this->partidaPen = PartidaQuery::create()->findOneById($this->id);

        if ($request->isMethod('post')) {
            $this->redirect('libro_mayor/index');
        }
    }

    public function executeReporte(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $nombreempresa = "Libro Mayor";
        $pestanas[] = 'Partidas';
        $nombre = "Libro Mayor";
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoMayorCuen', null, 'consulta'));
        $operaciones = $this->datos($valores);
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoMayorCuen', null, 'consulta'));
        $operaciones = $this->datos($valores);
        foreach ($operaciones as $registro) {
            $cuenta = $registro->getCuentaContable();
            $datos['numero'] = $registro->getPartida()->getNoAsiento();
            $mov = "xxxxxxxxxx";
            $movimientoBanco = MovimientoBancoQuery::create()->findOneByPartidaNo($registro->getPartidaId());
            if ($movimientoBanco) {
                $mov = $movimientoBanco->getId();
                $valorba = $movimientoBanco->getValor();
            }
            $datos['movi'] = $mov;
            if ($mov == "xxxxxxxxxx") {
                $datos['movi'] = "xxxxxxxxxx      " . $registro->getPartidaId();
            }
            
            $datos['confirmada'] = 0;

            if ($registro->getPartida()->getConfirmada()) {
                $datos['confirmada'] = 1;
            }
            $datos['par'] = $registro->getPartidaId();
            $datos['fecha'] = $registro->getPartida()->getFechaContable('d/m/Y'); //."   ->  ".$registro->getPartida()->getAno()."-".$registro->getPartida()->getMes() ;
            $datos['debe'] = $registro->getTotalDebe();
            $datos['haber'] = $registro->getTotalHaber();
            
            if ($registro->getTotalDebe() <0 ){
            $datos['debe'] = 0;
            $datos['haber'] = $registro->getTotalDebe()*-1;
                
            }
            
            $datos['tipo']=$registro->getPartida()->getTipo();
            $datos['detalle'] = $registro->getPartida()->getCompleto();
            $datos['codigo']=$registro->getPartida()->getCodigo();
            $datos['nombrepartida'] = $registro->getPartida()->getTipo() . " " . $registro->getPartida()->getCodigo();
            $mov = 0;
            $valorba = 0;
            $movimientoBanco = MovimientoBancoQuery::create()->findOneByPartidaNo($registro->getPartidaId());
            if ($movimientoBanco) {
                $mov = $movimientoBanco->getId();
                $valorba = $movimientoBanco->getValor();
            }
            $datos['banco'] = $mov . "  " . $valorba;
            if (($datos['debe'] > 0) && ($datos['haber'] > 0)) {
                $datosdebe = $datos;
                $datosdebe['haber'] = 0;
                $datoshaber = $datos;
                $datoshaber['debe'] = 0;
                $listaDatos[$cuenta][] = $datosdebe;
                $listaDatos[$cuenta][] = $datoshaber;
            } else {
                $listaDatos[$cuenta][] = $datos;
            }
            $listaCuentas[$cuenta] = $cuenta;
        }
        $listaOrden = $this->array_sort($listaCuentas, "", SORT_ASC);
        $cuentas = $listaOrden;
        $listaDatos = $listaDatos;
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaInicial = $fechaInicio;

        $filename = "Libro_Mayor " . $fechaInicial;
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
//        $hoja->getCell("A1")->setValueExplicit("LIBRO  MAYOR  DEL " . $valores['fechaInicio'] . " AL " . $valores['fechaFin'], PHPExcel_Cell_DataType::TYPE_STRING);
//        $hoja->getStyle("A1")->getFont()->setBold(true);
//        $hoja->getStyle("A1")->getFont()->setSize(10);
//        $hoja->mergeCells("A1:E1");
    $fila = 2;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');

        if ($cuentas) {
            foreach ($cuentas as $cuenta) {
$fila++;
$encabezados = null;
                $datosCuenta = $listaDatos[$cuenta];
                $encabezados[] = array("Nombre" => 'Partida', "width" => 20, "align" => "center", "format" => "@");
                $encabezados[] = array("Nombre" => 'Fecha', "width" => 20, "align" => "center", "format" => "@");
                $encabezados[] = array("Nombre" => ' Cuenta', "width" => 20, "align" => "center", "format" => "@");
                $encabezados[] = array("Nombre" => 'Detalle', "width" => 30, "align" => "center", "format" => "@");
                $encabezados[] = array("Nombre" => 'Descripción', "width" => 40, "align" => "center", "format" => "@");
                $encabezados[] = array("Nombre" => 'Debe', "width" => 15, "align" => "left", "format" => "#,##0.00");
                $encabezados[] = array("Nombre" => ' Haber', "width" => 15, "align" => "left", "format" => "#,##0.00");
                $encabezados[] = array("Nombre" => ' Saldo', "width" => 15, "align" => "left", "format" => "#,##0.00");
                sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

                $saldo = CuentaErpContablePeer::getSaldoFecha($fechaInicial, $cuenta);
$fila++;
                $encabezados = null;
                $encabezados[] = array("Nombre" => '', "width" => 20, "align" => "center", "format" => "@");
                $encabezados[] = array("Nombre" => '', "width" => 20, "align" => "center", "format" => "@");
                $encabezados[] = array("Nombre" => '', "width" => 20, "align" => "center", "format" => "@");
                $encabezados[] = array("Nombre" => '', "width" => 30, "align" => "center", "format" => "@");
                $encabezados[] = array("Nombre" => 'Saldo Inicial ', "width" => 55, "align" => "left", "format" => "#,##0.00");
                $encabezados[] = array("Nombre" => '', "width" => 20, "align" => "center", "format" => "@");
                $encabezados[] = array("Nombre" => '', "width" => 15, "align" => "left", "format" => "#,##0.00");
                $encabezados[] = array("Nombre" => $saldo, "width" => 15, "align" => "left", "format" => "#,##0.00");
           sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

                foreach ($datosCuenta as $dato) {
                    $fila++;

                    $saldo = $saldo + $dato['debe'] - $dato['haber'];
                    $datos = null;
                    $datos[] = array("tipo" => 3, "valor" => $dato['numero']);
                    $datos[] = array("tipo" => 3, "valor" => $dato['fecha']);
                    $datos[] = array("tipo" => 3, "valor" => $cuenta);  //echo $dato['movi'];  </td>
                    $datos[] = array("tipo" => 3, "valor" => $dato['tipo']); // </td>
                    $datos[] = array("tipo" => 3, "valor" => $dato['detalle']); // </td>
                    $datos[] = array("tipo" => 2, "valor" => $dato['debe']); //, true) </td>
                    $datos[] = array("tipo" => 2, "valor" => $dato['haber']); //, true) </td>
                    $datos[] = array("tipo" => 2, "valor" => $saldo); //; </td>
                      $datos[] = array("tipo" => 3, "valor" => $dato['codigo']); // </td>
                   sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
                }
                $datos = null;
                 $datos[] = array("tipo" => 3, "valor" => '');
                $datos[] = array("tipo" => 3, "valor" => '');
                $datos[] = array("tipo" => 3, "valor" => '');
                $datos[] = array("tipo" => 3, "valor" => '');
                $datos[] = array("tipo" => 3, "valor" => '');
                $datos[] = array("tipo" => 3, "valor" => '');
                $datos[] = array("tipo" => 3, "valor" => '');
                $datos[] = array("tipo" => 3, "valor" => '');
  $fila++;

               sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
            }
        }


        $hoja = $xl->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        die();
    }

    public function executeReportePdf(sfWebRequest $request) {

        $test = $request->getParameter('test');

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoMayorCuen', null, 'consulta'));
        $operaciones = $this->datos($valores);
        foreach ($operaciones as $registro) {
            $cuenta = $registro->getCuentaContable();
            $datos['numero'] = $registro->getPartida()->getNoAsiento();
            $mov = "xxxxxxxxxx";
            $movimientoBanco = MovimientoBancoQuery::create()->findOneByPartidaNo($registro->getPartidaId());
            if ($movimientoBanco) {
                $mov = $movimientoBanco->getId();
                $valorba = $movimientoBanco->getValor();
            }
            $datos['movi'] = $mov;
            if ($mov == "xxxxxxxxxx") {
                $datos['movi'] = "xxxxxxxxxx      " . $registro->getPartidaId();
            }
            if ($test == 1) {
                $datos['numero'] = $datos['movi'];
            }
            $datos['confirmada'] = 0;

            if ($registro->getPartida()->getConfirmada()) {
                $datos['confirmada'] = 1;
            }
            $datos['par'] = $registro->getPartidaId();
            $datos['fecha'] = $registro->getPartida()->getFechaContable('d/m/Y'); //."   ->  ".$registro->getPartida()->getAno()."-".$registro->getPartida()->getMes() ;
            $datos['debe'] = $registro->getTotalDebe();
             $datos['tipo']=$registro->getPartida()->getTipo();
            $datos['haber'] = $registro->getTotalHaber();
            
              if ($registro->getTotalDebe() <0 ){
            $datos['debe'] = 0;
            $datos['haber'] = $registro->getTotalDebe()*-1;
                
            }
            
            $datos['detalle'] = $registro->getPartida()->getCompleto();
            $datos['nombrepartida'] = $registro->getPartida()->getTipo() . " " . $registro->getPartida()->getCodigo();
            $mov = 0;
            $valorba = 0;
            $movimientoBanco = MovimientoBancoQuery::create()->findOneByPartidaNo($registro->getPartidaId());
            if ($movimientoBanco) {
                $mov = $movimientoBanco->getId();
                $valorba = $movimientoBanco->getValor();
            }
            $datos['banco'] = $mov . "  " . $valorba;
            if (($datos['debe'] > 0) && ($datos['haber'] > 0)) {
                $datosdebe = $datos;
                $datosdebe['haber'] = 0;
                $datoshaber = $datos;
                $datoshaber['debe'] = 0;
                $listaDatos[$cuenta][] = $datosdebe;
                $listaDatos[$cuenta][] = $datoshaber;
            } else {
                $listaDatos[$cuenta][] = $datos;
            }
            $listaCuentas[$cuenta] = $cuenta;
        }
        $listaOrden = $this->array_sort($listaCuentas, "", SORT_ASC);
        $this->cuentas = $listaOrden;
        $this->listaDatos = $listaDatos;
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaInicial = $fechaInicio;
        $html = $this->getPartial('libro_mayor/reporte', array('fechaInicial' => $fechaInicial, 'cuentas' => $this->cuentas, 'listaDatos' => $this->listaDatos));
        $PDF_HEADER_TITLE = "Libro Mayor  ";
        $PDF_HEADER_STRING = " " . $valores['fechaInicio'] . " AL " . $valores['fechaFin'];
        $PDF_HEADER_LOGO = "WMlogoFondo.png"; //Solo me funciona si esta dentro de la carpeta images de la libreria
        $nombre_archivo = "  LIBRO MAYOR  DEL " . $valores['fechaInicio'] . " AL " . $valores['fechaFin'];
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle($nombre_archivo);
        $pdf->SetSubject('Libro Diario Contable');
        $pdf->SetKeywords('Libro,Contable, Mayor, Compra'); // set default header data
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

    public function executeIndex(sfWebRequest $request) {
        
        $acceso = MenuSeguridad::Acceso('libro_mayor');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
        date_default_timezone_set("America/Guatemala");
        $muestra = $request->getParameter('id');
        $test = $request->getParameter('test');
        $this->test = $test;
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoMayorCuen', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $bodegaId = null;
        if ($usuarioQue) {
            $bodegaId = $usuarioQue->getTiendaId();
        }
        if (!$valores) {
            $valores['tipo'] = 'agrupado';
            $valores['filtro'] = null;
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('seleccionDatoMayorCuen', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaCuentaForm($valores);

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('seleccionDatoMayorCuen', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoMayorCuen', null, 'consulta'));
                $this->redirect('libro_mayor/index?id=1&test=' . $test);
            }
        }

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $this->fechaInicial = $fechaInicio;
        $operaciones = null;
        $listaCuentas = null;
        $listaDatos = null;
        if ($muestra) {
            $operaciones = $this->datos($valores);
            foreach ($operaciones as $registro) {
                $cuenta = $registro->getCuentaContable();
                $datos['numero'] = $registro->getPartida()->getNoAsiento();
                $mov = "xxxxxxxxxx";
                $movimientoBanco = MovimientoBancoQuery::create()->findOneByPartidaNo($registro->getPartidaId());
                if ($movimientoBanco) {
                    $mov = $movimientoBanco->getId();
                    $valorba = $movimientoBanco->getValor();
                }
                $datos['movi'] = $mov;
                if ($mov == "xxxxxxxxxx") {
                    $datos['movi'] = "xxxxxxxxxx      " . $registro->getPartidaId();
                }
                if ($test == 1) {
                    $datos['numero'] = $datos['movi'];
                }
                $datos['confirmada'] = 0;
                $datos['par'] = $registro->getPartidaId();
                if ($registro->getPartida()->getConfirmada()) {
                    $datos['confirmada'] = 1;
                }
                $datos['fecha'] = $registro->getPartida()->getFechaContable('d/m/Y'); //."   ->  ".$registro->getPartida()->getAno()."-".$registro->getPartida()->getMes() ;
                $datos['debe'] = $registro->getTotalDebe();
                 $datos['tipo']=$registro->getPartida()->getTipo();
                $datos['haber'] = $registro->getTotalHaber();
                
                  if ($registro->getTotalDebe() <0 ){
            $datos['debe'] = 0;
            $datos['haber'] = $registro->getTotalDebe()*-1;
                
            }
            
                $datos['detalle'] = $registro->getPartida()->getCompleto();
                $datos['nombrepartida'] = $registro->getPartida()->getTipo() . " " . $registro->getPartida()->getCodigo();
                $mov = 0;
                $valorba = 0;
                $movimientoBanco = MovimientoBancoQuery::create()->findOneByPartidaNo($registro->getPartidaId());
                if ($movimientoBanco) {
                    $mov = $movimientoBanco->getId();
                    $valorba = $movimientoBanco->getValor();
                }
                $datos['banco'] = $mov . "  " . $valorba;
                if (($datos['debe'] > 0) && ($datos['haber'] > 0)) {
                    $datosdebe = $datos;
                    $datosdebe['haber'] = 0;
                    $datoshaber = $datos;
                    $datoshaber['debe'] = 0;
                    $listaDatos[$cuenta][] = $datosdebe;
                    $listaDatos[$cuenta][] = $datoshaber;
                } else {
                    $listaDatos[$cuenta][] = $datos;
                }
                $listaCuentas[$cuenta] = $cuenta;
            }
        }

//             echo "<pre>";
//       print_r($listaCuentas);
//       echo "</pre>";
//       echo "<pre>";
//       print_r($listaDatos);
//       echo "</pre>";
        $listaOrden = $this->array_sort($listaCuentas, "", SORT_ASC);
//                     echo "<pre>";
//       print_r($listaOrden);
//       echo "</pre>";
//       die();


        $this->cuentas = $listaOrden;
        $this->listaDatos = $listaDatos;
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
        if ($valores['cuenta_contable']) {
            $listaCue[] = $valores['cuenta_contable'];
            if ($valores['cuenta_contable2']) {
                $listaCue[] = $valores['cuenta_contable2'];
                $nombreBanco = CuentaErpContableQuery::create()
                        ->where("CuentaErpContable.CuentaContable >= '" . $valores['cuenta_contable'] . "'")
                        ->where("CuentaErpContable.CuentaContable <= '" . $valores['cuenta_contable2'] . "'")
                     //   ->where('length(CuentaErpContable.CuentaContable) >6 ')
                        ->find();
                foreach ($nombreBanco as $reg) {
                    $listaCue[] = $reg->getCuentaContable();
                }
            }

            $operaciones->filterByCuentaContable($listaCue, Criteria::IN);
        }
        $operaciones->usePartidaQuery();
        if ($valores['filtro'] == "confirmadas") {
            $operaciones->where("Partida.Confirmada=1");
        }
        if ($valores['filtro'] == "pendientes") {
            $operaciones->where("Partida.Confirmada=0");
        }

        $operaciones->where("Partida.FechaContable >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Partida.FechaContable <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());

        if ($valores['tipo'] == "detallado") {
            $operaciones->withColumn('(PartidaDetalle.Debe)', 'TotalDebe');
            $operaciones->withColumn('(PartidaDetalle.Haber)', 'TotalHaber');
        } else {
            $operaciones->withColumn('sum(PartidaDetalle.Debe)', 'TotalDebe');
            $operaciones->withColumn('sum(PartidaDetalle.Haber)', 'TotalHaber');
            $operaciones->groupBy('Partida.FechaContable');
            $operaciones->groupBy('PartidaDetalle.CuentaContable');
        }
        $operaciones->orderBy("Partida.FechaContable");
        $operaciones = $operaciones->find();
//        echo "<pre>";
//        print_r($operaciones);
//        echo "</pre>";
//die();
        return $operaciones;
    }

    function array_sort($array, $on, $order = SORT_DESC) {
        $new_array = array();
        $sortable_array = array();
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }
            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
        return $new_array;
    }

    //        if ($valores['cuenta_contable3']) {
//           $listaCue[]=$valores['cuenta_contable3'];
//        }            
//        if ($valores['cuenta_contable4']) {
//           $listaCue[]=$valores['cuenta_contable4'];
//        }            
//        if ($valores['cuenta_contable5']) {
//           $listaCue[]=$valores['cuenta_contable5'];
//        }            
//        if ($valores['cuenta_contable6']) {
//           $listaCue[]=$valores['cuenta_contable6'];
//        }            
//        if ($valores['cuenta_contable7']) {
//           $listaCue[]=$valores['cuenta_contable7'];
//        }            
//        if ($valores['cuenta_contable8']) {
//           $listaCue[]=$valores['cuenta_contable8'];
//        }            
//
//           if ($valores['cuenta_contable9']) {
//           $listaCue[]=$valores['cuenta_contable8'];
//        }  
//           if ($valores['cuenta_contable10']) {
//           $listaCue[]=$valores['cuenta_contable8'];
//        }  
//           if ($valores['cuenta_contable11']) {
//           $listaCue[]=$valores['cuenta_contable8'];
//        }  
}
