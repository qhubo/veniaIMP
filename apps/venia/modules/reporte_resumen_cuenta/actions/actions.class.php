<?php

/**
 * reporte_resumen_cuenta actions.
 *
 * @package    plan
 * @subpackage reporte_resumen_cuenta
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporte_resumen_cuentaActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = $EmpresaQuery->getNombre();
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('reporteCo', null, 'consulta'));
        if (!$valores) {
            $valores['filtro'] = null;
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['cuenta_contable'] = null;
            $valores['cuenta_contable2'] = null;
            sfContext::getInstance()->getUser()->setAttribute('reporteCo', serialize($valores), 'consulta');
        }

        $pestanas[] = 'ResumenCuentas';
        $filename = "Resumen Cuentas Agrupado  " . $nombreempresa . date("d_m_Y");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $hoja = $xl->setActiveSheetIndex(0);
//CABECERA  Y FILTRO
        $hoja->getRowDimension('1')->setRowHeight(15);
        $hoja->getRowDimension('2')->setRowHeight(20);

        $hoja->mergeCells("A1:A2");
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit("Reporte", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(10);
// $hoja->getStyle("B1")->applyFromArray($styleArray);

        $hoja->getCell("C1")->setValueExplicit($nombreempresa . " Resumen Cuentas  ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C1")->getFont()->setBold(true);
        $hoja->getStyle("C1")->getFont()->setSize(13);

        $textoBusqueda = $this->textobusqueda($valores);
        $hoja->mergeCells("C1:E1");
        $hoja->getCell("B2")->setValueExplicit("Busqueda ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B2")->getFont()->setBold(true);
        $hoja->getStyle("B2")->getFont()->setSize(10);
        $hoja->getCell("C2")->setValueExplicit($textoBusqueda, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle('C2')->getAlignment()->setWrapText(true);
        $hoja->mergeCells("C2:E2");
        $fila = 3;
        $columna = 0;
        $encabezados = null;
        $encabezados[] = array("Nombre" => strtoupper("Cuenta"), "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Descripción"), "width" => 45, "align" => "left", "format" => "#,##0");

        $encabezados[] = array("Nombre" => strtoupper("'-01"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("'-02"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("'-03"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("'-04"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("'-05"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("'-06"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("'-07"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("'-08"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("'-09"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("'-10"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("'-11"), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("'-12"), "width" => 15, "align" => "right", "format" => "#,##0.00");

        $encabezados[] = array("Nombre" => strtoupper("Total"), "width" => 18, "align" => "right", "format" => "#,##0.00");

        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $inicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $listado = $this->Datos($valores);
       
             
        foreach ($listado as $regi) {

            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $regi['prefijo']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regi['nombre']);  // ENTERO
            $total = 0;
            foreach ($regi['cuentas'] as $detalle) {
                $valor = CuentaErpContablePeer::saldo($inicio, $fin, $detalle);
                $valor=round($valor,2);
                $total = $total + $valor;
                $datos[] = array("tipo" => 2, "valor" => $valor);  // ENTERO
            }
            $datos[] = array("tipo" => 2, "valor" => $total);  // ENTERO

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


                if ($clave == 'ESTATUS') {
                    if ($valor == "") {
                        $Busqueda[] = ' Todos los Estatus ';
                    } else {
                        $Busqueda[] = 'ESTADO : ' . $valor;
                    }
                }
            }
        }
        if ($Busqueda) {
            $textoBusqueda = implode(",", $Busqueda);
        }
        return $textoBusqueda;
    }

    public function executeIndex(sfWebRequest $request) {

        date_default_timezone_set("America/Guatemala");
        $muestra = $request->getParameter('id');
        $test = $request->getParameter('test');
        $cuenta = null;
        $this->test = $test;
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('reporteCo', null, 'consulta'));
        if (!$valores) {
            $valores['filtro'] = null;
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['cuenta_contable'] = null;
            $valores['cuenta_contable2'] = null;
            sfContext::getInstance()->getUser()->setAttribute('reporteCo', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaDosCuentaForm($valores);

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('reporteCo', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('reporteCo', null, 'consulta'));
                $this->redirect('reporte_resumen_cuenta/index?id=1&test=' . $test);
            }
        }



        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

        $this->listaDoPrefi = $this->Datos($valores);
        $this->inicio = $fechaInicio;
        $this->fin = $fechaFin;
    }

    public function Datos($valores) {
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $cuenta_contable = $valores['cuenta_contable'];
        $cuenta_contable2 = $valores['cuenta_contable2'];

        $busca = true;
        if (($cuenta_contable <> "") && ($cuenta_contable2 <> "")) {
            $busca = false;
            $cuenta = CuentaErpContableQuery::create()
                    ->orderByCuentaContable("Asc")
//                    ->where("SUBSTR(CuentaErpContable.CuentaContable, length(cuenta_contable)-1, 2) <> '00'")
//                    ->where('length(CuentaErpContable.CuentaContable) >6 ')
                    ->where("(CuentaErpContable.CuentaContable) >= '" . $cuenta_contable . "'")
                    ->where("(CuentaErpContable.CuentaContable) <= '" . $cuenta_contable2 . "'")
                    ->find();
        }
        if ($busca) {
            if ($cuenta_contable <> "") {
                $cuenta = CuentaErpContableQuery::create()
                        ->orderByCuentaContable("Asc")
//                        ->where("SUBSTR(CuentaErpContable.CuentaContable, length(cuenta_contable)-1, 2) <> '00'")
//                        ->where('length(CuentaErpContable.CuentaContable) >6 ')
                        ->where("(CuentaErpContable.CuentaContable) ='" . $cuenta_contable . "' ")
                        ->find();
            }
        }
        $listaDoPrefi = null;
        if ($cuenta) {
            $bandera = '';
            $listaDoPrefi = null;
            foreach ($cuenta as $regitro) {
                $valores = explode("-", $regitro->getCuentaContable());
                $prefijo = $valores[0];
                $dta = null;
                $listaDoPrefi[$prefijo]['prefijo'] = $prefijo;
                $listaDoPrefi[$prefijo]['nombre'] = $regitro->getNombre();
                for ($i = 1; $i <= 12; $i++) {
                    if ($i < 10) {
                        $listaDoPrefi[$prefijo]['cuentas'][$prefijo . "-0" . $i] = $prefijo . "-0" . $i;
                    } else {
                        $listaDoPrefi[$prefijo]['cuentas'][$prefijo . "-" . $i] = $prefijo . "-" . $i;
                    }
                }
            }
        }
        return $listaDoPrefi;
    }

}
