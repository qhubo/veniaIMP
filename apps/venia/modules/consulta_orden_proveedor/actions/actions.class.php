<?php

/**
 * consulta_orden_proveedor actions.
 *
 * @package    plan
 * @subpackage consulta_orden_proveedor
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class consulta_orden_proveedorActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('dataProve', null, 'consulta'));
        error_reporting(-1);

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '01:00';
        $valores['fin'] = '23:00';


        $registros = new OrdenProveedorQuery();
        if ($valores['usuario']) {

            $registros->filterByUsuario($valores['usuario']);
        }
        $registros->where("OrdenProveedor.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'");
        $registros->where("OrdenProveedor.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'");
        $registros = $registros->find();
        $nombreempresa = "Golden";
        $pestanas[] = 'REPORTE ORDEN COMPRA';
        $filename = "REPORTE ORDEN COMPRA ";
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $sheet = $xl->setActiveSheetIndex(0);


// ================= COLUMNAS =================
        $widths = [18, 22, 18, 20, 30, 40, 18, 18, 20];
        $col = 'A';
        foreach ($widths as $w) {
            $sheet->getColumnDimension($col)->setWidth($w);
            $col++;
        }

// ================= HEADERS =================
        $fila = 1;

        $headers = [
            "Código", "Fecha", "Estatus", "Usuario",
            "Proveedor", "Comentario", "Valor Total",
            "Valor Pagado", "Usuario"
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

// ================= DETALLE =================
        $fila++;

        foreach ($registros as $data) {
//echo "<pre>";
//print_r($data);
//die();
            
            $sheet->setCellValue("A$fila", $data->getCodigo());
            $sheet->setCellValue("B$fila", $data->getFecha('d/m/Y H:i'));
            $sheet->setCellValue("C$fila", $data->getEstatus());
            $sheet->setCellValue("D$fila", $data->getUsuario());
            $sheet->setCellValue("E$fila", $data->getNombre());
            $sheet->setCellValue("F$fila", $data->getComentario());
            $sheet->setCellValue("G$fila", $data->getValorTotal());
            $sheet->setCellValue("H$fila", $data->getValorPagado());
            $sheet->setCellValue("I$fila", $data->getUsuario());

            foreach (range('A', 'J') as $c) {
                $sheet->getStyle($c . $fila)->getBorders()->getAllBorders()
                        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            }

            $fila++;
        }

// ================= FORMATOS =================
        $sheet->getStyle("G2:H$fila")->getNumberFormat()
                ->setFormatCode('#,##0.00');


        // ================== SALIDA ==================
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeIndex(sfWebRequest $request) {

        $acceso = MenuSeguridad::Acceso('consulta_orden_proveedor');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('dataProve', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['usuario'] = trim($usuarioQue->getUsuario());
            sfContext::getInstance()->getUser()->setAttribute('dataProve', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('dataProve', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('dataProve', null, 'consulta'));
                $this->redirect('consulta_orden_proveedor/index?id=');
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


        $registros = new OrdenProveedorQuery();
        if ($valores['usuario']) {

            $registros->filterByUsuario($valores['usuario']);
        }
        $registros->where("OrdenProveedor.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'");
        $registros->where("OrdenProveedor.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'");
        $this->registros = $registros->find();

// $this->registros = OrdenProveedorQuery::create()
//         ->find();
//      
    }

}
