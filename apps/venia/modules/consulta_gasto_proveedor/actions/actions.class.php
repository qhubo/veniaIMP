<?php

/**
 * consulta_gasto_proveedor actions.
 *
 * @package    plan
 * @subpackage consulta_gasto_proveedor
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class consulta_gasto_proveedorActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {



        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaGasto', null, 'consulta'));
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '01:00';
        $valores['fin'] = '23:00';
        $registros = GastoQuery::create()
                ->filterByEstatus('Proceso', Criteria::NOT_EQUAL)
                ->where("Gasto.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("Gasto.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->find();

        error_reporting(-1);
        $nombreempresa = "Golden";
        $pestanas[] = 'REPORTE GASTOS';
        $filename = "REPORTE GASTOS ";
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $sheet = $xl->setActiveSheetIndex(0);

// ================== COLUMNAS ==================
        $widths = [18, 20, 30, 25, 35, 18, 18, 20];
        $col = 'A';
        foreach ($widths as $w) {
            $sheet->getColumnDimension($col)->setWidth($w);
            $col++;
        }

// ================== ENCABEZADOS ==================
        $fila = 1;

        $headers = [
            "Código", "Fecha", "Proveedor", "Documento",
            "Concepto", "Valor Total", "Valor Pagado", "Usuario"
        ];

        $col = "A";
        foreach ($headers as $h) {
            $sheet->setCellValue($col . $fila, $h);
            $sheet->getStyle($col . $fila)->getFont()->setBold(true);
            $sheet->getStyle($col . $fila)->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . $fila)->getBorders()->getAllBorders()
                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $col++;
        }

// ================== DETALLE ==================
        $fila++;

// -------- PRIMER FOREACH --------
        foreach ($registros as $data) {

            $sheet->setCellValue("A$fila", $data->getCodigo());
            $sheet->setCellValue("B$fila", $data->getFecha('d/m/Y H:i'));
            $sheet->setCellValue("C$fila", $data->getProveedor()->getNombre());
            $sheet->setCellValue("D$fila", $data->getTipoDocumento() . ' ' . $data->getDocumento());
            $sheet->setCellValue("E$fila", $data->getConcepto());
            $sheet->setCellValue("F$fila", $data->getValorTotal() - $data->getValorImpuesto());
            $sheet->setCellValue("G$fila", $data->getValorPagado());
            $sheet->setCellValue("H$fila", $data->getUsuario());

            foreach (range('A', 'H') as $c) {
                $sheet->getStyle($c . $fila)->getBorders()->getAllBorders()
                        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            }

            $fila++;
        }

// -------- SEGUNDO FOREACH --------
//        foreach ($registrosCaja as $data) {
//
//            $sheet->setCellValue("A$fila", $data->getId());
//            $sheet->setCellValue("B$fila", $data->getFecha('d/m/Y H:i'));
//            $sheet->setCellValue("C$fila", $data->getUsuario());
//            $sheet->setCellValue("D$fila", $data->getTienda());
//            $sheet->setCellValue("E$fila", $data->getConcepto());
//            $sheet->setCellValue("F$fila", $data->getValor());
//            $sheet->setCellValue("G$fila", $data->getValorImpuesto());
//            $sheet->setCellValue("H$fila", $data->getUsuario());
//
//            foreach (range('A', 'H') as $c) {
//                $sheet->getStyle($c . $fila)->getBorders()->getAllBorders()
//                        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//            }
//
//            $fila++;
//        }
// ================== FORMATOS ==================
        $sheet->getStyle("F2:G$fila")->getNumberFormat()
                ->setFormatCode('#,##0.00');

// ================== SALIDA ==================
          header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeEliminar(sfWebRequest $request) {

        $acceso = MenuSeguridad::Acceso('consulta_gasto_proveedor');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }


        $id = $request->getParameter('id');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $gastoOrden = GastoQuery::create()->findOneById($id);
            $cuentaProveedor = CuentaProveedorQuery::create()->findOneByGastoId($gastoOrden->getId());
            $cuentaProveedor->delete();
            $codigo = $gastoOrden->getCodigo();
            $gastoDetalle = GastoDetalleQuery::create()
                    ->filterByGastoId($id)
                    ->find();
            if ($gastoDetalle) {
                $gastoDetalle->delete();
            }
            $gastoOrden->delete();
            $con->commit();
            $this->getUser()->setFlash('error', 'Gasto eliminado con exito ' . $codigo);
            $partidaId = $gastoOrden->getPartidaNo();
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('consulta_gasto_proveedor/index');
        }

        $partidaQ = PartidaDetalleQuery::create()
                ->filterByPartidaId($partidaId)
                ->find();
        if ($partidaQ) {
            $partidaQ->delete();
        }
        $partidaM = PartidaQuery::create()->findOneById($partidaId);
        if ($partidaM) {
            $partidaM->delete();
        }
        $this->redirect('consulta_gasto_proveedor/index');
    }

    public function executeIndex(sfWebRequest $request) {
        $acceso = MenuSeguridad::Acceso('consulta_gasto_proveedor');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaGasto', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('datoconsultaGasto', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsultaGasto', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaGasto', null, 'consulta'));
                $this->redirect('consulta_gasto_proveedor/index?id=1');
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

//        echo $fechaInicio;
//       echo "<br>";
//
//        echo $fechaFin;

        $this->registros = GastoQuery::create()
                ->filterByEstatus('Proceso', Criteria::NOT_EQUAL)
                ->where("Gasto.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("Gasto.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->find();
//        $this->registrosCaja = GastoCajaQuery::create()
//                ->filterByEstatus('Confirmado')
//                ->where("GastoCaja.Fecha >= '".$fechaInicio. "'")
//                ->where("GastoCaja.Fecha <= '" . $fechaFin."'")
//                ->find();
//        echo "<pre>";
//        print_R($this->registrosCaja);
//        die();
// $this->registros = OrdenProveedorQuery::create()
//         ->find();
//      
    }

}
