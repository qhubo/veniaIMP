<?php

/**
 * pago_recibido actions.
 *
 * @package    plan
 * @subpackage pago_recibido
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pago_recibidoActions extends sfActions {

    public function executeElimina(sfWebRequest $request) {
               date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datosConsultaRecibo', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $id = $request->getParameter("id");
        $operacionPago = OperacionPagoQuery::create()->findOneById($id);
        $operacion = OperacionQuery::create()->findOneById($operacionPago->getOperacionId());
        $partida = PartidaQuery::create()->findOneById($operacionPago->getPartidaNo());
        if ($partida) {
            $partidaDe = PartidaDetalleQuery::create()->filterByPartidaId($partida->getId())->find();
            if ($partidaDe) {
                $partidaDe->delete();
            }
            $partida->delete();
        }
        $nuevoValor = $operacion->getValorPagado() - $operacionPago->getValor();
        $operacion->setValorPagado($nuevoValor);
        $operacion->setPagado(false);
        $operacion->setEstatus('Procesada');
        if ($operacion->getClienteId()) {
            $operacion->setEstatus('Cuenta Cobrar');
        }
        $operacion->save();
        $operacionPago->setTipo('Anulado');
        $operacionPago->setFechaCreo(null);
        $operacionPago->setDocumento('Anulo '.$usuarioQue->getUsuario(). " ".date('d/m/Y'));
        $operacionPago->save();
        
        $this->getUser()->setFlash('exito', 'Recibo eliminado con exito ');
        $this->redirect('pago_recibido/index?id=' . $operacionPago->getId());
        die();
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
            sfContext::getInstance()->getUser()->setAttribute('datosConsultaRecibo', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaDatosForm($valores);


        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datosConsultaRecibo', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datosConsultaRecibo', null, 'consulta'));
                $this->redirect('pago_recibido/index?id=1');
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

        $query = "select pp.id recibo, op.codigo factura,DATE_FORMAT(op.fecha,'%d/%m/%Y') fechaFactura, face_firma,   DATE_FORMAT(fecha_creo,'%d/%m/%Y %H:%i') fecha_creo, cl.codigo codigo_cliente, op.nit, op.nombre, op.estatus,";
        $query .= " pp.tipo tipoPago, valor, DATE_FORMAT(fecha_documento,'%d/%m/%Y')  fecha_documento, ban.nombre banco,ban.cuenta, documento ,  comision, ven.nombre vendedor, op.usuario, op.valor_total ";
        $query .= " valor_factura   from  operacion_pago  pp inner join operacion op on op.id = pp.operacion_id  left join vendedor ven on ven.id = vendedor_id left join";
        $query .= " banco ban on ban.id= banco_id left join cliente cl on cl.id = op.cliente_id where pp.tipo not in ('CONTRA ENTREGA', 'CXC COBRAR','CHEQUE PREFECHADO', 'CONTRAENTREGA')  ";
        $query .= " and op.anulado=0  and   fecha_creo  >= '" . $fechaInicio . " 01:00' and fecha_creo <= '" . $fechaFin . " 23:59' ";
        $query .= "  and  op.empresa_id = " . $empresaId;
        if ($valores['vendedor']) {
            $query .= "  and  vendedor_id = " . $valores['vendedor'];
        }
        if ($valores['busqueda']) {
            $query .= "  and  op.nombre like '%" . $valores['busqueda'] . "%'";
        }
        if ($valores['cliente']) {
            $query .= " and  ( cl.nombre like  '%" . $valores['cliente'] . "%' or cl.codigo like  '%" . $valores['cliente'] . "%' ) ";
        }
        if ($valores['medio_pago']) {
            $query .= "  and  pp.tipo = '" . $valores['medio_pago'] . "'";
        }

        $query .= " order by fecha_creo";

        $con = Propel::getConnection();
        $stmt = $con->prepare($query);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->registros = $result;
    }

    public function executeReporteExcel(sfWebRequest $request) {
                   $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
                
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
            sfContext::getInstance()->getUser()->setAttribute('datosConsultaRecibo', serialize($valores), 'consulta');
        }
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = $EmpresaQuery->getNombre();
        $pestanas[] = 'Pago Recibido';
        $filename = "Pagos Recibido " . $nombreempresa . date("d_m_Y");
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

        $hoja->getCell("C1")->setValueExplicit("Pagos Recibidos ", PHPExcel_Cell_DataType::TYPE_STRING);
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
        $encabezados[] = array("Nombre" => strtoupper("Fecha Pago"), "width" => 16, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Recibo"), "width" => 12, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Valor"), "width" => 16, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Comisión"), "width" => 12, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Medio Pago"), "width" => 20, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Banco Pago"), "width" => 18, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("No. Cuenta"), "width" => 15, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Documento Pago"), "width" => 21, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Fecha Documento Pago"), "width" => 16, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Codigo Cliente"), "width" => 15, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Nombre Factura"), "width" => 35, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Firma Factura"), "width" => 25, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Fecha Factura"), "width" => 16, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Código Factura"), "width" => 20, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Estatus Factura"), "width" => 20, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Valor Factura"), "width" => 16, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Vendedor Factura"), "width" => 20, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Usuario Factura"), "width" => 15, "align" => "rigth", "format" => "#,##0.00");

        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '01:00';
        $valores['fin'] = '23:00';

        $query = "select pp.id recibo, op.codigo factura,DATE_FORMAT(op.fecha,'%d/%m/%Y') fechaFactura, face_firma,   DATE_FORMAT(fecha_creo,'%d/%m/%Y %H:%i') fecha_creo, cl.codigo codigo_cliente, op.nit, op.nombre, op.estatus,";
        $query .= " pp.tipo tipoPago, valor, DATE_FORMAT(fecha_documento,'%d/%m/%Y')  fecha_documento, ban.nombre banco,ban.cuenta, documento ,  comision, ven.nombre vendedor, op.usuario, op.valor_total ";
        $query .= " valor_factura   from  operacion_pago  pp inner join operacion op on op.id = pp.operacion_id  left join vendedor ven on ven.id = vendedor_id left join";
        $query .= " banco ban on ban.id= banco_id left join cliente cl on cl.id = op.cliente_id where pp.tipo not in ( 'CONTRA ENTREGA','CXC COBRAR','CHEQUE PREFECHADO', 'CONTRAENTREGA')  ";
        $query .= " and op.anulado=0    and   fecha_creo  >= '" . $fechaInicio . " 01:00' and fecha_creo <= '" . $fechaFin . " 23:59' ";
        $query .= "  and  op.empresa_id = " . $empresaId;
        if ($valores['vendedor']) {
            $query .= "  and  vendedor_id = " . $valores['vendedor'];
        }
        if ($valores['busqueda']) {
            $query .= "  and  op.nombre like '%" . $valores['busqueda'] . "%'";
        }
        if ($valores['cliente']) {
            $query .= " and  ( cl.nombre like  '%" . $valores['cliente'] . "%' or cl.codigo like  '%" . $valores['cliente'] . "%' ) ";
        }
        if ($valores['medio_pago']) {
            $query .= "  and  pp.tipo = '" . $valores['medio_pago'] . "'";
        }

        $query .= " order by fecha_creo";

//       echo $query;
//       die();
        $con = Propel::getConnection();
        $stmt = $con->prepare($query);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->registros = $result;
        $total = 0;
        foreach ($this->registros as $registro) {
            $fila++;
            $datos = null;
            $codigo = $registro['codigo_cliente'];
            if ($codigo == "CONTRAENTREGA") {
                $codigo = "";
            }
            $datos[] = array("tipo" => 3, "valor" => $registro['fecha_creo']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => OperacionPago::Codigo($registro['recibo']));  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => round($registro['valor'], 2));  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => round($registro['comision'], 2));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['tipoPago']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['banco']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['cuenta']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['documento']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['fecha_documento']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $codigo);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['nombre']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['face_firma']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['fechaFactura']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['factura']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['estatus']);  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => round($registro['valor_factura'], 2));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['vendedor']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['usuario']);  // ENTERO

            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;

        $hoja = $xl->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

}
