<?php

/**
 * ruta_cobro actions.
 *
 * @package    plan
 * @subpackage ruta_cobro
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ruta_cobroActions extends sfActions {

    public function executeFecha(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&$dirh =
        $val = $request->getParameter('val'); //=155555&$dirh =
        $fechaInicio = explode('/', $val);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $operacionQ = OperacionQuery::create()->findOneById($id);
        $operacionQ->setFechaCobro($fechaInicio);
        $operacionQ->save();
        echo "actualizado";
        die();
    }

    public function executeComentario(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&$dirh =
        $val = $request->getParameter('val'); //=155555&$dirh =
        $operacionQ = OperacionQuery::create()->findOneById($id);
        $operacionQ->setRutaCobro($val);
        $operacionQ->save();
        echo "actualizado";
        die();
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        $registros = OperacionQuery::create()
                ->filterByClienteId(null, Criteria::NOT_EQUAL)
                ->filterByPagado(false)
                ->filterByValorPagado(0, Criteria::GREATER_THAN)
                ->find();
        foreach ($registros as $deta) {
            $valorTotal = round($deta->getValorTotal(), 2);
            $valorPagado = round($deta->getValorPagado(), 2);
            if ($valorPagado == $valorTotal) {
                $deta->setPagado(true);
                $deta->save();
            }
        }

        $this->id = $request->getParameter('id'); //=155555&$dirh =
//        $acceso = MenuSeguridad::Acceso('lista_cobro');
//        if (!$acceso) {
//            $this->redirect('inicio/index');
//        }

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('rutaCobro', null, 'consulta'));
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $operacionQ = OperacionQuery::create()
                    ->filterByFecha(null, Criteria::NOT_EQUAL)
                    ->filterByPagado(false)
                    ->orderByFecha('Asc')
                    ->findOne();
            if ($operacionQ) {
                $valores['fechaInicio'] = $operacionQ->getFecha('d/m/Y');
            }
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('rutaCobro', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFacturaNotaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('rutaCobro', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('rutaCobro', null, 'consulta'));
                $this->redirect('ruta_cobro/index');
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



        if ($valores['busqueda'] <> "") {
            $bus = "%" . $valores['busqueda'] . "%";

            $this->operaciones = OperacionQuery::create()
                    ->filterByEstatus('Cuenta Cobrar')
                    ->useClienteQuery()
                    ->endUse()
                    ->filterByPagado(false)
                    ->where("(Operacion.Nombre like '" . $bus . "' or Operacion.Nit like '" . $bus . "' or Cliente.Codigo like '" . $bus . "')")
                    ->where("Operacion.Fecha  >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("Operacion.Fecha  <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->orderBy("Cliente.Nombre")
                    ->find();
        } else {
            $this->operaciones = OperacionQuery::create()
                    ->filterByEstatus('Cuenta Cobrar')
                    ->useClienteQuery()
                    ->endUse()
                    ->filterByPagado(false)
                    ->where("Operacion.Fecha  >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                    ->where("Operacion.Fecha  <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                    ->orderBy("Cliente.Nombre")
                    ->find();
        }
    }

    public function executeHistorial(sfWebRequest $request) {
        error_reporting(-1);
        $registros = OperacionQuery::create()
                ->filterByClienteId(null, Criteria::NOT_EQUAL)
                ->filterByPagado(false)
                ->filterByValorPagado(0, Criteria::GREATER_THAN)
                ->find();
        foreach ($registros as $deta) {
            $valorTotal = round($deta->getValorTotal(), 2);
            $valorPagado = round($deta->getValorPagado(), 2);
            if ($valorPagado == $valorTotal) {
                $deta->setPagado(true);
                $deta->save();
            }
        }

        $this->id = $request->getParameter('id'); //=155555&$dirh =

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('rutaCobro', null, 'consulta'));
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $operacionQ = OperacionQuery::create()
                    ->filterByFecha(null, Criteria::NOT_EQUAL)
                    ->filterByPagado(false)
                    ->orderByFecha('Asc')
                    ->findOne();
            if ($operacionQ) {
                $valores['fechaInicio'] = $operacionQ->getFecha('d/m/Y');
            }
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('rutaCobro', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFacturaNotaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('rutaCobro', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('rutaCobro', null, 'consulta'));
                $this->redirect('ruta_cobro/index');
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



        $this->operaciones = OperacionQuery::create()
                ->useClienteQuery()
                ->endUse()
                ->where("Operacion.FechaCobro  >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("Operacion.FechaCobro  <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->orderBy("Cliente.Nombre")
                ->find();
    }

    public function executeReporteExcel(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('rutaCobro', null, 'consulta'));
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $operacionQ = OperacionQuery::create()
                    ->filterByFecha(null, Criteria::NOT_EQUAL)
                    ->filterByPagado(false)
                    ->orderByFecha('Asc')
                    ->findOne();
            if ($operacionQ) {
                $valores['fechaInicio'] = $operacionQ->getFecha('d/m/Y');
            }
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('rutaCobro', serialize($valores), 'consulta');
        }
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = $EmpresaQuery->getNombre();

        $pestanas[] = 'Ruta Cobro';

        $filename = "Ruta de Cobro  " . $nombreempresa . date("d_m_Y");
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

        $hoja->getCell("C1")->setValueExplicit("Ruta de cobro ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C1")->getFont()->setBold(true);
        $hoja->getStyle("C1")->getFont()->setSize(10);

        $textoBusqueda = $valores['fechaInicio'] . "  " . $valores['fechaFin'];
        $hoja->mergeCells("C1:E1");
        $hoja->getCell("B2")->setValueExplicit("Fecha Cobro ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B2")->getFont()->setBold(true);
        $hoja->getStyle("B2")->getFont()->setSize(10);
        $hoja->getCell("C2")->setValueExplicit($textoBusqueda, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle('C2')->getAlignment()->setWrapText(true);
        $hoja->mergeCells("C2:E2");


        $fila = 3;
        $columna = 0;
        $encabezados = null;
        $encabezados[] = array("Nombre" => strtoupper("Fecha Cobro"), "width" => 16, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Ruta Cobro"), "width" => 30, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Fecha"), "width" => 16, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Codigo Cliente"), "width" => 20, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Cliente"), "width" => 30, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Factura"), "width" => 18, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Dirección"), "width" => 40, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Valor Total"), "width" => 25, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Valor Pagado"), "width" => 25, "align" => "rigth", "format" => "#,##0.00");

        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

        $this->operaciones = OperacionQuery::create()
                ->useClienteQuery()
                ->endUse()
                ->where("Operacion.FechaCobro  >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
                ->where("Operacion.FechaCobro  <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->orderBy("Cliente.Nombre")
                ->find();
        $total = 0;
        foreach ($this->operaciones as $registro) {
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $registro->getFechaCobro('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getRutaCobro());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getFecha('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getCliente()->getCodigoCli());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getCliente()->getNombre());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getCodigo());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getCliente()->getDireccion());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $registro->getValorTotal());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $registro->getValorPagado());  // ENTERO

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
