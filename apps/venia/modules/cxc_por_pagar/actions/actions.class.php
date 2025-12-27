<?php

class cxc_por_pagarActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $prover = $request->getParameter('prover');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = $EmpresaQuery->getNombre();
        $pestanas[] = 'Cuentas por Pagar';
        $filename = "Cuentas por pagar _" . $nombreempresa . date("d_m_Y");
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
        $hoja->getCell("C1")->setValueExplicit("Cuentas por pagar al  " . date('d/m/Y'), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C1")->getFont()->setBold(true);
        $hoja->getStyle("C1")->getFont()->setSize(10);
        $fila = 3;
        $columna = 0;
        $encabezados = null;
        $encabezados[] = array("Nombre" => strtoupper("Código"), "width" => 12, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Proveedor"), "width" => 30, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Fecha"), "width" => 25, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Crédito"), "width" => 20, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Detalle"), "width" => 40, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Sub Total"), "width" => 35, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Valor ISR"), "width" => 35, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Valor Total"), "width" => 35, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Valor Pagado"), "width" => 35, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Saldo"), "width" => 35, "align" => "rigth", "format" => "#,##0.00");

        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

        $registros = new CuentaProveedorQuery();
        $registros->filterByPagado(false);
        if ($prover) {
            $registros->filterByProveedorId($prover);
        }
        $this->registros = $registros->find();

        $total = 0;
        foreach ($this->registros as $deta) {
            $fila++;
            $total = $total + ($deta->getValorTotal() - $deta->getValorPagado());
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $deta->getCodigo());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $deta->getProveedor()->getNombre());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $deta->getFecha('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $deta->getDias() . " Días ");  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $deta->getValorSubTotal());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $deta->getValorImpuesto());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $deta->getValorImpuesto());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $deta->getValorTotal());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $deta->getValorPagado());  // ENTERO          
            $datos[] = array("tipo" => 2, "valor" => $deta->getValorTotal() - $deta->getValorPagado());

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
        
         
                     $acceso = MenuSeguridad::Acceso('cxc_por_pagar');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
        
        $this->prover = $request->getParameter('prover');
        $registros = CuentaProveedorQuery::create()
                ->filterByProveedorId(null, Criteria::NOT_EQUAL)
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
        $registros = new CuentaProveedorQuery();
        $registros->filterByPagado(false);
        if ($this->prover) {
            $registros->filterByProveedorId($this->prover);
        }
        $this->registros = $registros->find();
        $proveedores = CuentaProveedorQuery::create()
                ->useProveedorQuery()
                ->endUse()
                ->groupByProveedorId()
                ->filterByPagado(false)
                ->orderBy("Proveedor.Nombre", 'Asc')
                ->find();
        $seleccion = null;
        foreach ($proveedores as $registro) {
            $seleccion[$registro->getProveedorId()] = $registro->getProveedor()->getNombre();
        }
        $this->seleccion = $seleccion;
        $this->totalSuma = $this->suma($this->prover);
    }

    public function executeActiva(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $prove = $request->getParameter('prove');
        $movi = $request->getParameter('movi');
        $activar = CuentaProveedorQuery::create()->findOneById($id);
        $activar->setSeleccionado(true);
        $activar->save();
        $suma = $this->suma($prove);
        echo Parametro::formato($suma, false);
        die();
    }

    public function executeDesactiva(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $prove = $request->getParameter('prove');
        $movi = $request->getParameter('movi');
        $activar = CuentaProveedorQuery::create()->findOneById($id);
        $activar->setSeleccionado(false);
        $activar->save();
        $suma = $this->suma($prove);
        echo Parametro::formato($suma, false);
        die();
    }

    public function suma($prove) {
        $valorTotal = 0;
        $movimient = new CuentaProveedorQuery();
        $movimient->filterByPagado(false);
        $movimient->filterBySeleccionado(true);
        if ($prove) {
            $movimient->filterByProveedorId($prove);
        }
        $movimient->withColumn('sum(CuentaProveedor.ValorTotal)', 'ValorTotalTotal');
        $movimient->withColumn('sum(CuentaProveedor.ValorPagado)', 'ValorPagadoPagado');
        $movimiento = $movimient->findOne();
        if ($movimiento) {
            if ($movimiento->getValorTotal()) {
                $valorTotal = $movimiento->getValorTotalTotal()- $movimiento->getValorPagadoPagado();
            }
        }
        return $valorTotal;
    }

}
