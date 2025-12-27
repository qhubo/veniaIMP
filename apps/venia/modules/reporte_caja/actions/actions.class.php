<?php

/**
 * reporte_caja actions.
 *
 * @package    plan
 * @subpackage reporte_caja
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporte_cajaActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $nolista[] = 'Pendiente';
        $nolista[] = 'Anulado';

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsulta', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);

        $logo = $usuarioQue->getEmpresa()->getLogo();

        $bodegaId = null;
        if ($usuarioQue) {
            $bodegaId = $usuarioQue->getTiendaId();
        }
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['usuario'] = $usuarioQue->getUsuario();
            $valores['inicio'] = '00:00';
            $valores['fin'] = '23:30';
            $tipoUsuario = sfContext::getInstance()->getUser()->getAttribute('tipoUsuario', null, 'seguridad');
            if ($tipoUsuario <> 'ADMINISTRADOR') {
                $valores['usuario'] = $usuarioId;
            }
            $valores['estado'] = 'Pagado';
            $valores['tipo_fecha'] = 'Pago';
            $valores['bodega'] = $bodegaId;

            sfContext::getInstance()->getUser()->setAttribute('datoconsulta', serialize($valores), 'consulta');
        }


        $bodega = 'Todas';
        $bodeaQ = TiendaQuery::create()->findOneById($valores['bodega']);
        if ($bodeaQ) {
            $bodega = $bodeaQ->getNombre();
        }

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

//        echo "<pre>";
//        print_r($valores);
//        die();

        $this->operaciones = OperacionQuery::create()
                ->filterByEstatus($nolista, Criteria::NOT_IN)
                ->where("Operacion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("Operacion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->find();

        $todos = OperacionQuery::create()
                ->filterByEstatus($nolista, Criteria::NOT_IN)
                //   ->filterByEstatus('Pagado')
                ->where("Operacion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("Operacion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
//                ->filterByBodegaId($bodegaId)
//                ->where("day(Operacion.Fecha)=" . $dia)
//                ->where("month(Operacion.Fecha)=" . $mes)
//                 ->where("year(Operacion.Fecha)=" . $ano) 
                ->withColumn('sum(Operacion.ValorTotal)', 'TotalGeneral')
                ->findOne();
        $TotalCompras = $todos->getTotalGeneral();

        $this->operacionPago = OperacionPagoQuery::create()
                ->where("OperacionPago.FechaCreo >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("OperacionPago.FechaCreo <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->useOperacionQuery()
                //  ->where("Operacion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                //  ->where("Operacion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->filterByEstatus($nolista, Criteria::NOT_IN)
                //     ->filterByEstatus('Pagado')
//                ->filterByBodegaId($bodegaId)             
                ->endUse()
                ->withColumn('count(OperacionPago.Id)', 'Cantidad')
                ->withColumn('sum(OperacionPago.Valor)', 'ValorTotal')
                ->groupByTipo()
                ->find();

        $this->pendientes = OperacionQuery::create()
                ->filterByFaceReferencia(null)
                ->filterByEstatus($nolista, Criteria::NOT_IN)
                //     ->filterByEstatus('Pagado')                    
                ->filterByTiendaId($bodegaId)
                ->where("Operacion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("Operacion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->withColumn('sum(Operacion.ValorTotal)', 'TotalGeneral')
                ->count();

        $defa = null;
        $operaiconDetalle = OperacionDetalleQuery::create()
                //   ->filterByOperacionId($lista, Criteria::IN)
                ->useOperacionQuery()
                ->filterByEstatus($nolista, Criteria::NOT_IN)
                //      ->filterByEstatus('Pagado')
                ->where("Operacion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("Operacion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->endUse()
                ->withColumn('sum(OperacionDetalle.Cantidad)', 'TotalCantidad')
                ->withColumn('sum(OperacionDetalle.ValorTotal)', 'TotalValor')
                ->groupBy('OperacionDetalle.Detalle')
                ->filterByValorTotal(0, Criteria::GREATER_THAN)
                ->find();
        $this->detalle = $operaiconDetalle;

        $this->operacionCXC = OperacionPagoQuery::create()
                ->where("OperacionPago.FechaCreo >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("OperacionPago.FechaCreo <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->where("LENGTH(OperacionPago.CxcCobrar) >3")
                ->find();
        $html = $this->getPartial('reporte_caja/reporte', array('operaciones' => $this->operaciones, 'operacionPago' => $this->operacionPago,
            'operacionCXC' => $this->operacionCXC, 'pendientes' => $this->pendientes, 'detalle' => $this->detalle,
            'valores' => $valores, 'bodega' => $bodega, 'logo' => $logo,
        ));


//
//        echo $html;
//        die();

        $referencia = '';
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle("Reporte Ventas Diarias " . $referencia);
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
        $pdf->Output("Reporte Ventas Diarias " . $referencia . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        $DATOS[99] = 'DETALLE COMPLETO';
        $DATOS[1] = 'FACTURAS DEL DIA';
        $DATOS[2] = 'VENTAS DEL DIA';
        $DATOS[3] = 'MEDIOS DE PAGO FACTURAS DEL DIA';
        $DATOS[4] = 'FACTURAS COBRADAS CXC';
        $DATOS[5] = 'PAGOS RECIBIDOS DEL DIA';
        $DATOS[6] = 'FACTURAS ANULADAS';
        $DATOS[7] = 'NOTA CREDITO ';
        $DATOS[8] = 'DEVOLUCIONES';
        $this->DATOS = $DATOS;

        sfContext::getInstance()->getUser()->setAttribute('log', 99, 'seguridad');
        if ($request->getParameter("bancover")) {
            sfContext::getInstance()->getUser()->setAttribute('log', $request->getParameter("bancover"), 'seguridad');
        }

        $this->bancover = sfContext::getInstance()->getUser()->getAttribute('log', null, 'seguridad');


        $this->operacionCXC = null;
        date_default_timezone_set("America/Guatemala");
        $nolista[] = 'Pendiente';
        $nolista[] = 'Anulado';
        $listaBO [] = 0;
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsulta', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $bodegaId = null;
        if ($usuarioQue) {
            $bodegaId = $usuarioQue->getTiendaId();
        }
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['usuario'] = $usuarioQue->getUsuario();
            $valores['inicio'] = '00:00';
            $valores['fin'] = '23:30';
            $tipoUsuario = sfContext::getInstance()->getUser()->getAttribute('tipoUsuario', null, 'seguridad');
            if ($tipoUsuario <> 'ADMINISTRADOR') {
                $valores['usuario'] = $usuarioId;
            }
            $valores['estado'] = 'Pagado';
            $valores['tipo_fecha'] = 'Pago';
            $valores['bodega'] = $bodegaId;
            sfContext::getInstance()->getUser()->setAttribute('datoconsulta', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaReporteCajaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsulta', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsulta', null, 'consulta'));
                // $this->redirect('reporte_caja/index?id=1');
            }
        }
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

        $listab = TiendaQuery::TiendaActivas(); // ctivas();
        $operaciones = OperacionQuery::create();
        $operaciones->where("Operacion.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Operacion.Fecha <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones->filterByAnulado(false);
        if ($valores['bodega']) {
            $operaciones->filterByTiendaId($valores['bodega']);
        }
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->orderById('Asc');
        $operaciones->filterByEstatus('Cuenta Cobrar', Criteria::NOT_EQUAL);
        $this->operaciones = $operaciones->find();

        $listaOmite[] = 0;
        foreach ($this->operaciones as $regi) {
            $listaOmite[] = $regi->getId();
            $listaBO [] = $regi->getId();
        }


        $operaciones = OperacionQuery::create();
        $operaciones->filterById($listaOmite, Criteria::NOT_IN);
        $operaciones->where("Operacion.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Operacion.Fecha <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones->filterByAnulado(false);
        if ($valores['bodega']) {
            $operaciones->filterByTiendaId($valores['bodega']);
        }
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->orderById('Asc');
        $operaciones->filterByEstatus('Cuenta Cobrar');
        $this->operacionesCXC = $operaciones->find();

        $operaciones = OperacionQuery::create();
        $operaciones->where("Operacion.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Operacion.Fecha <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones->filterByAnulado(false);
        if ($valores['bodega']) {
            $operaciones->filterByTiendaId($valores['bodega']);
        }
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->orderById('Asc');
        $operaciones->filterByEstatus('Cuenta Cobrar');
        $operaciones->withColumn('count(Operacion.Id)', 'CantidadTotal');
        $operaciones->withColumn('sum(Operacion.ValorTotal)', 'SubValorTotal');
        $this->valorCobrar = $operaciones->findOne();

        if ($valores['bodega']) {
            $operaiconDetalle = OperacionDetalleQuery::create()
                    ->useOperacionQuery()
                    ->filterByTiendaId($valores['bodega'])
                    ->filterByAnulado(false)
                    ->where("Operacion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("Operacion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->endUse()
                    ->withColumn('sum(OperacionDetalle.Cantidad)', 'TotalCantidad')
                    ->withColumn('sum(OperacionDetalle.ValorTotal)', 'TotalValor')
                    ->groupBy('OperacionDetalle.Detalle')
                    ->filterByValorTotal(0, Criteria::GREATER_THAN)
                    ->find();
        } else {
            $operaiconDetalle = OperacionDetalleQuery::create()
                    ->useOperacionQuery()
                    ->filterByAnulado(false)
                    ->where("Operacion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("Operacion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->endUse()
                    ->withColumn('sum(OperacionDetalle.Cantidad)', 'TotalCantidad')
                    ->withColumn('sum(OperacionDetalle.ValorTotal)', 'TotalValor')
                    ->groupBy('OperacionDetalle.Detalle')
                    ->filterByValorTotal(0, Criteria::GREATER_THAN)
                    ->find();
        }
        $this->detalle = $operaiconDetalle;
        $this->operacionPago = OperacionPagoQuery::create()
                ->useOperacionQuery()
                ->filterByAnulado(false)
                ->where("Operacion.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("Operacion.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->endUse()
                ->where("OperacionPago.FechaCreo >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("OperacionPago.FechaCreo <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->withColumn('count(OperacionPago.Id)', 'Cantidad')
                ->withColumn('sum(OperacionPago.Valor)', 'ValorTotal')
                ->groupByTipo()
                ->find();


        foreach ($this->operacionPago as $reg) {
            $listaBO [] = $reg->getOperacionId();
        }


        if ($valores['bodega']) {
            $this->operacionRecupera = OperacionPagoQuery::create()
                    ->filterByTipo('CHEQUE PREFECHADO', Criteria::NOT_EQUAL)
                    ->useOperacionQuery()
                    ->filterByTiendaId($valores['bodega'])
                    ->filterById($listaBO, Criteria::NOT_IN)
                    ->filterByAnulado(false)
                    ->endUse()
                    ->where("OperacionPago.FechaCreo >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("OperacionPago.FechaCreo <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->withColumn('count(OperacionPago.Id)', 'TotalCantidad')
                    ->withColumn('sum(OperacionPago.Valor)', 'ValorPagado')
                    ->groupByTipo()
                    ->find();


            $this->Recuperadas = OperacionPagoQuery::create()
                    ->filterByTipo('CHEQUE PREFECHADO', Criteria::NOT_EQUAL)
                    ->useOperacionQuery()
                    ->filterByTiendaId($valores['bodega'])
                    ->filterById($listaBO, Criteria::NOT_IN)
                    ->filterByAnulado(false)
                    ->endUse()
                    ->where("OperacionPago.FechaCreo >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("OperacionPago.FechaCreo <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->withColumn('count(OperacionPago.Id)', 'TotalCantidad')
                    ->withColumn('sum(OperacionPago.Valor)', 'ValorTotal')
                    ->groupByOperacionId()
                    ->find();
        } else {
            $this->operacionRecupera = OperacionPagoQuery::create()
                    ->useOperacionQuery()
                    ->filterById($listaBO, Criteria::NOT_IN)
                    ->filterByAnulado(false)
                    ->endUse()
                    ->where("OperacionPago.FechaCreo >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("OperacionPago.FechaCreo <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->withColumn('count(OperacionPago.Id)', 'TotalCantidad')
                    ->withColumn('sum(OperacionPago.Valor)', 'ValorTotal')
                    ->groupByTipo()
                    ->find();
            $this->Recuperadas = OperacionPagoQuery::create()
                    ->useOperacionQuery()
                    ->filterById($listaBO, Criteria::NOT_IN)
                    ->filterByAnulado(false)
                    ->endUse()
                    ->where("OperacionPago.FechaCreo >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("OperacionPago.FechaCreo <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->withColumn('count(OperacionPago.Id)', 'TotalCantidad')
                    ->withColumn('sum(OperacionPago.Valor)', 'ValorTotal')
                    ->groupByOperacionId()
                    ->find();
        }

        $operaciones = OperacionQuery::create();
        $operaciones->filterByAnulaFaceFirma(null);
        $operaciones->filterById($listaOmite, Criteria::NOT_IN);
        $operaciones->where("Operacion.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Operacion.Fecha <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones->filterByAnulado(true);
        if ($valores['bodega']) {
            $operaciones->filterByTiendaId($valores['bodega']);
        }
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->orderById('Asc');
        $this->Anuladas = $operaciones->find();

        $operaciones = OperacionQuery::create();
        $operaciones->filterByAnulaFaceFirma(null, Criteria::NOT_EQUAL);
        $operaciones->where("STR_TO_DATE(Operacion.AnulaFaceFechaEmision, '%m/%d/%Y %H:%i:%s')  >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("STR_TO_DATE(Operacion.AnulaFaceFechaEmision, '%m/%d/%Y %H:%i:%s') <= '" . $fechaFin . " 23:59:00" . "'");
        if ($valores['bodega']) {
            $operaciones->filterByTiendaId($valores['bodega']);
        }
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->orderById('Asc');
        $this->Notas = $operaciones->find();

        $operaciones = OrdenDevolucionQuery::create();
        $operaciones->filterByTipo('Cliente');
        $operaciones->where("OrdenDevolucion.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("OrdenDevolucion.Fecha <= '" . $fechaFin . " 23:59:00" . "'");

        if ($valores['bodega']) {
            $operaciones->filterByTiendaId($valores['bodega']);
        }
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->orderById('Asc');
        $this->Devoluciones = $operaciones->find();
//        echo "<pre>";
//        print_r($this->Devoluciones);
//        die();
    }

}
