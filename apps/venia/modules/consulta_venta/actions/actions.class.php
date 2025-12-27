<?php

/**
 * consulta_venta actions.
 *
 * @package    plan
 * @subpackage consulta_venta
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class consulta_ventaActions extends sfActions {

    public function executeReporteExcel(sfWebRequest $request) {
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('reporteventa', null, 'consulta'));
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['usuario'] = null;
            $valores['estatus_op'] = 'Procesados';
            $valores['bodega'] = null;
            $valores['vendedor'] = null;
            $valores['usuario'] = null;
            $valores['busqueda'] = '';
            $valores['cliente'] = '';
            sfContext::getInstance()->getUser()->setAttribute('reporteventa', serialize($valores), 'consulta');
        }
        $this->getResponse()->setContentType('text/html;charset=utf-8');
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "Modelo";
        $pestanas[] = substr($EmpresaQuery->getNombre(), 0, 30);
        $nombre = "Modelo";
        $nombreEMpresa = $EmpresaQuery->getNombre();
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $filename = "Reporte de Ventas " . $nombreEMpresa . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("FECHAS", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->getCell("B1")->setValueExplicit($valores['fechaInicio'] . " al  " . $valores['fechaFin'], PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B1:D1");
        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $encabezados[] = array("Nombre" => "TIENDA", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "CODIGO", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Fecha"), "width" => 30, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => "USUARIO", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "CLIENTE", "width" => 30, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "NOMBRE", "width" => 50, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "NIT", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "ESTADO", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Valor"), "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => "Fel", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Vendedor", "width" => 45, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Observaciones/Guia", "width" => 45, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Ruta Cobro", "width" => 25, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Valor Pagado"), "width" => 25, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => "Recibo", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Fecha Pago", "width" => 20, "align" => "center", "format" => "@");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $operaciones = $this->datos($valores);
        $TOTALvENTA = 0;
        $TOTALpAGADO = 0;
        $TOTALrECIBO = 0;
        foreach ($operaciones as $lista) {
            $fila++;
            $datos = null;
            $codigCli = '';
            if ($lista->getClienteId()) {
                $codigCli = $lista->getCliente()->getCodigoCli();
            }
            $vende = "";
            if ($lista->getVendedorId()) {
                $vende = $lista->getVendedor()->getNombre();
            }
            $datos[] = array("tipo" => 3, "valor" => substr($lista->getTienda(), 0, 20));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $lista->getCodigo());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $lista->getFecha('d/m/Y H:i'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $lista->getUsuario());
            $datos[] = array("tipo" => 3, "valor" => $codigCli);
            $datos[] = array("tipo" => 3, "valor" => $lista->getNombre());
            $datos[] = array("tipo" => 3, "valor" => $lista->getNit());
            $datos[] = array("tipo" => 3, "valor" => $lista->getEstatus());
            $datos[] = array("tipo" => 2, "valor" => $lista->getValorTotal());
            $datos[] = array("tipo" => 3, "valor" => $lista->getFaceFirma());
            $datos[] = array("tipo" => 3, "valor" => $vende);
            $datos[] = array("tipo" => 3, "valor" => $lista->getObservaciones());
            $datos[] = array("tipo" => 3, "valor" => $lista->getRutaCobro());
            $datos[] = array("tipo" => 2, "valor" => $lista->getValorPagado());
            $datos[] = array("tipo" => 3, "valor" => $lista->getRecibo());
            $datos[] = array("tipo" => 3, "valor" => $lista->getFechaRecibo());
            $TOTALvENTA = $lista->getValorTotal() + $TOTALvENTA;
            $TOTALpAGADO = $lista->getValorPagado() + $TOTALpAGADO;


            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;


//        $hoja->getCell("A" . $fila)->setValueExplicit("ULTIMA LINEA", PHPExcel_Cell_DataType::TYPE_STRING);

        $hoja->getStyle("D" . $fila)->getFont()->setBold(true);
        $hoja->getStyle("D" . $fila)->getFont()->setSize(14);
        $hoja->getCell("D" . $fila)->setValueExplicit("TOTALES", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("I" . $fila)->getFont()->setBold(true);
        $hoja->getStyle("I" . $fila)->getFont()->setSize(14);
        $hoja->getCell("I" . $fila)->setValueExplicit(ROUND($TOTALvENTA, 2), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("N" . $fila)->getFont()->setBold(true);
        $hoja->getStyle("N" . $fila)->getFont()->setSize(14);
        $hoja->getCell("N" . $fila)->setValueExplicit(round($TOTALpAGADO, 2), PHPExcel_Cell_DataType::TYPE_STRING);
//        print_r($encabezados);
//        
//        die();
        header("Content-Type: text/html;charset=utf-8");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeIndex(sfWebRequest $request) {
        $usuarioQ = UsuarioQuery::create()->filterByVendedorId(null, Criteria::NOT_EQUAL)->find();
        $listaU[] = '0';
        foreach ($usuarioQ as $reg) {
            $listaU[] = $reg->getUsuario();
        }

        $ventas = OperacionQuery::create()
                ->filterByVendedorId(null)
                ->filterByUsuario($listaU, Criteria::IN)
                ->find();
        foreach ($ventas as $regi) {
            $usuarioQ = UsuarioQuery::create()->findOneByUsuario($regi->getUsuario());
            $vendedorId = $usuarioQ->getVendedorId();
            $vendedorQ = VendedorQuery::create()->findOneById($vendedorId);
            if ($vendedorQ) {
                echo $usuarioQ->getUsuario();
                $regi->setVendedorId($vendedorId);
                $regi->save();
                echo " --- ";
                echo $vendedorId;
                echo "<br>";
            }
        }



        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('reporteventa', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $bodegaId = null;
        if ($usuarioQue) {
            $bodegaId = $usuarioQue->getTiendaId();
        }
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['usuario'] = null;
            $valores['estatus_op'] = 'Procesados';
            $valores['bodega'] = null;
            $valores['vendedor'] = null;
            $valores['usuario'] = null;
            $valores['busqueda'] = '';
            $valores['cliente'] = '';
            sfContext::getInstance()->getUser()->setAttribute('reporteventa', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaVentaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('reporteventa', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('reporteventa', null, 'consulta'));

                $this->redirect('consulta_venta/index?id=1');
            }
        }
        $this->operaciones = $this->datos($valores);
    }

    public function datos($valores) {
        // $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('reporteventa', null, 'consulta'));
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        //    $usuariof = $valores['usuario'];
//        $tipo_fecha = $valores['tipo_fecha'];
        $bodega = $valores['bodega'];
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
//        $empresaId = $usuarioQue->getEmpresaId();
        $empresq = EmpresaQuery::create()->findOne();
        $operaciones = OperacionQuery::create();
        //    $operaciones->filterByClienteId(null, Criteria::NOT_EQUAL);
        $listab = TiendaQuery::TiendaActivas(); // ctivas();
        $operaciones->where("Operacion.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Operacion.Fecha <= '" . $fechaFin . " 23:59:00" . "'");
        if ($bodega) {
            $operaciones->filterByTiendaId($bodega);
        }
//        echo "<pre>";
//        print_r($valores);
//        die();
        
        if ($valores['usuario']) {
            $operaciones->filterByUsuario($valores['usuario']);
        }
        if ($valores['vendedor']) {
            if ($valores['vendedor'] == '-99') {
                $operaciones->filterByVendedorId(null, Criteria::NOT_EQUAL);
            } else {
                $operaciones->filterByVendedorId($valores['vendedor']);
            }
        }
        if ($valores['busqueda']) {
            $operaciones->where("Operacion.Nombre like  '%" . $valores['busqueda'] . "%'");
        }
        if ($valores['cliente']) {
            $operaciones->useClienteQuery();
            $operaciones->where("( Cliente.Nombre like  '%" . $valores['cliente'] . "%' or Cliente.Codigo like  '%" . $valores['cliente'] . "%' ) ");
        }

        if ($valores['estatus_op']) {
            if ($valores['estatus_op'] == 'Anulados') {
                $operaciones->filterByAnulado(true);
            }
            if ($valores['estatus_op'] == 'Procesados') {
                $operaciones->filterByAnulado(false);
            }
            if ($valores['estatus_op'] == 'Pagados') {
                $operaciones->filterByAnulado(false);
                $operaciones->filterByPagado(true);
            }
            if ($valores['estatus_op'] == 'PendientesPago') {
                $operaciones->filterByAnulado(false);
                $operaciones->filterByPagado(false);
            }
        }
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->orderByFecha("Asc");
        $operaciones = $operaciones->find();
        return $operaciones;
    }

}
