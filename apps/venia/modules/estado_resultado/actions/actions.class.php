<?php

/**
 * estado_resultado actions.
 *
 * @package    plan
 * @subpackage estado_resultado
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class estado_resultadoActions extends sfActions {

     public function executeReportePdf(sfWebRequest $request) {
         $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoMayorCuen', null, 'consulta'));
      
        $test = $request->getParameter('test');
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $this->fechaInicial = $fechaInicio;
        $operaciones = null;
        $listaCuentas = null;
        $listaDatos = null;
      
            $operaciones = $this->datos($valores, 4);
            $total4 = 0;
            foreach ($operaciones as $registro) {
                $cuenta = 4;  //registro->getCuentaContable();
                $total4 = ($registro->getTotalHaber() - $registro->getTotalDebe()) + $total4;
            }
            $datos['cuenta'] = $cuenta;
            $datos['monto'] = $total4;
            $datos['detalle'] = "<strong>Ventas Netas</strong>";
            $listaDatos[$cuenta][] = $datos;
            $listaCuentas[$cuenta] = $cuenta;

            $operaciones = $this->datos($valores, 5);
            $total5 = 0;
            foreach ($operaciones as $registro) {
                $cuenta = 5;  //registro->getCuentaContable();
                $total5 = ($registro->getTotalHaber() - $registro->getTotalDebe()) + $total5;
            }
            $datos['cuenta'] = $cuenta;
            $datos['monto'] = $total5;
            $datos['detalle'] = "<strong>Costo de ventas</strong>";
            $listaDatos[$cuenta][] = $datos;
            $listaCuentas[$cuenta] = $cuenta;
            $operaciones = $this->datos($valores, null);
            $total6 =0;
            $total7 =0;
            foreach ($operaciones as $registro) {
                $cuenta = $registro->getCuentaContable();
                $monto =$registro->getTotalHaber() - $registro->getTotalDebe();
                if  (substr($cuenta, 0,1)==6) {
                    $total6=$total6+$monto;
                }
                if  (substr($cuenta, 0,1)==7) {
                    $total7=$total7+$monto;
                }   
                $datos['cuenta'] = $cuenta;
                $datos['monto'] = $monto;
                $datos['detalle'] = $registro->getDetalle();
                $listaDatos[$cuenta][] = $datos;
                $listaCuentas[$cuenta] = $cuenta;
            }



        $listaOrden = $this->array_sort($listaCuentas, "", SORT_ASC);
        $this->cuentas = $listaOrden;
        $this->listaDatos = $listaDatos;
        $this->total4= $total4;
        $this->total5=$total5;
        $this->total6= $total6;
        $this->total7=$total7;
        
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaInicial = $fechaInicio;
        $html = $this->getPartial('estado_resultado/reporte', array('fechaInicial' => $fechaInicial, 
            'cuentas' => $this->cuentas, 'listaDatos' => $this->listaDatos,
            'total4'=>$this->total4,    'total5'=>$this->total5,    'total6'=>$this->total6,    'total7'=>$this->total7
            ));
//        echo $html;
//        die();
        $PDF_HEADER_TITLE = "Estado de Resultados  ";
        $PDF_HEADER_STRING = " " . $valores['fechaInicio'] . " AL " . $valores['fechaFin'];
        $PDF_HEADER_LOGO = "logoC.png"; //Solo me funciona si esta dentro de la carpeta images de la libreria
        $nombre_archivo = "  ESTADO DE RESULTADOS DEL " . $valores['fechaInicio'] . " AL " . $valores['fechaFin'];
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
        $pdf->SetMargins(3, 20);
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
        
                     $acceso = MenuSeguridad::Acceso('estado_resultado');
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
            $valores['tienda']=null;
            sfContext::getInstance()->getUser()->setAttribute('seleccionDatoMayorCuen', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaEstadoResultadoForm($valores);

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('seleccionDatoMayorCuen', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoMayorCuen', null, 'consulta'));
                $this->redirect('estado_resultado/index?id=1&test=' . $test);
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
            $operaciones = $this->datos($valores, 4);
            $total4 = 0;
            foreach ($operaciones as $registro) {
                $cuenta = 4;  //registro->getCuentaContable();
                $total4 = ($registro->getTotalHaber() - $registro->getTotalDebe()) + $total4;               
            }
            $total4 = $total4*-1;
            $datos['cuenta'] = $cuenta;
            $datos['monto'] = $total4;
            $datos['detalle'] = "<strong>Ventas Netas</strong>";
            $listaDatos[$cuenta][] = $datos;
            $listaCuentas[$cuenta] = $cuenta;

            $operaciones = $this->datos($valores, 5);
            $total5 = 0;
            foreach ($operaciones as $registro) {
                $cuenta = 5;  //registro->getCuentaContable();
                $total5 = ($registro->getTotalHaber() - $registro->getTotalDebe()) + $total5;
            }
            $total5 = $total5*-1;
            $datos['cuenta'] = $cuenta;
            $datos['monto'] = $total5;
            $datos['detalle'] = "<strong>Costo de ventas</strong>";
            $listaDatos[$cuenta][] = $datos;
            $listaCuentas[$cuenta] = $cuenta;
            $operaciones = $this->datos($valores, null);
            $total6 =0;
            $total7 =0;
            foreach ($operaciones as $registro) {
                $cuenta = $registro->getCuentaContable();
                $monto =$registro->getTotalHaber() - $registro->getTotalDebe();
                $monto = $monto*-1;
                if  (substr($cuenta, 0,1)==6) {
                    $total6=$total6+$monto;
                }
                if  (substr($cuenta, 0,1)==7) {
                    $total7=$total7+$monto;
                }   
                $datos['cuenta'] = $cuenta;
                $datos['monto'] = $monto;
                $datos['detalle'] = $registro->getDetalle();
                $listaDatos[$cuenta][] = $datos;
                $listaCuentas[$cuenta] = $cuenta;
            }
        }

//        echo "<pre>";
//        print_r($listaDatos);
//        die();

        $listaOrden = $this->array_sort($listaCuentas, "", SORT_ASC);
        $this->cuentas = $listaOrden;
        $this->listaDatos = $listaDatos;
        $this->total4= $total4;
        $this->total5=$total5;
        $this->total6= $total6;
        $this->total7=$total7;
    }

    public function datos($valores, $tipo = null) {
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
//        if ($valores['filtro'] == "confirmadas") {
//            $operaciones->where("Partida.Confirmada=1");
//        }
//        if ($valores['filtro'] == "pendientes") {
//            $operaciones->where("Partida.Confirmada=0");
//        }
        $operaciones->where("Partida.FechaContable >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Partida.FechaContable <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones->where("substring(PartidaDetalle.CuentaContable,1,1) >3");
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->withColumn('sum(PartidaDetalle.Debe)', 'TotalDebe');
        $operaciones->withColumn('sum(PartidaDetalle.Haber)', 'TotalHaber');
        if ($tipo) {
            $operaciones->where("substring(PartidaDetalle.CuentaContable,1,1) =" . $tipo);
        } else {
            $operaciones->where("substring(PartidaDetalle.CuentaContable,1,1)  not in (4,5)");
        }
        if ($valores['tienda']){
        $operaciones->where("SUBSTR(PartidaDetalle.CuentaContable, length(PartidaDetalle.CuentaContable)-1, 2) = '".$valores['tienda']."'");
        }
        $operaciones->groupBy('PartidaDetalle.CuentaContable');
        $operaciones = $operaciones->find();

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

}
