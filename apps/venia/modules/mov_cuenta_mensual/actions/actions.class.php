<?php

/**
 * mov_cuenta_mensual actions.
 *
 * @package    plan
 * @subpackage mov_cuenta_mensual
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mov_cuenta_mensualActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        $mes['1'] = "Enero";
        $mes['2'] = "Febrero";
        $mes['3'] = "Marzo";
        $mes['4'] = "Abril";
        $mes['5'] = "Mayo";
        $mes['6'] = "Junio";
        $mes['7'] = "Julio";
        $mes['8'] = "Agosto";
        $mes['9'] = "Septiembre";
        $mes['10'] = "Octubre";
        $mes['11'] = "Noviembre";
        $mes['12'] = "Diciembre";
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionCuenta', null, 'consulta'));

        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $nombreempresa = "Saldo Mensuales";
        $pestanas[] = 'Movimientos';
        $nombre = "Libro Mayor";
        $periodo = $mes[(int) $valores['mes']] . " " . $valores['anio'];
        $filename = "Saldos_Mensuales_movimientos_cuentas_" . $periodo;
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("SALDOS DE MOVIMIENTOS  PERíODO " . $periodo, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->mergeCells("A1:E1");
        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');
         $resumen=      sfContext::getInstance()->getUser()->getAttribute('datos', null, 'consulta');
        
                $fila++;
                $encabezados = null;      
                $encabezados[] = array("Nombre" => 'Período', "width" => 20, "align" => "center", "format" => "@");
                $encabezados[] = array("Nombre" => 'Cuenta', "width" => 20, "align" => "center", "format" => "@");
                $encabezados[] = array("Nombre" => 'Descripción', "width" => 45, "align" => "center", "format" => "@");
                $encabezados[] = array("Nombre" => 'Saldo Inicial', "width" => 25, "align" => "left", "format" => "#,##0.00");
                $encabezados[] = array("Nombre" => 'Debe', "width" => 20, "align" => "left", "format" => "#,##0.00");
                $encabezados[] = array("Nombre" => 'Haber', "width" => 20, "align" => "left", "format" => "#,##0.00");
                $encabezados[] = array("Nombre" => 'Total', "width" => 25, "align" => "left", "format" => "#,##0.00");
                sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

                foreach ($resumen as $key => $regi) {
                    $fila++;
                    $datos = null;
                    $datos[] = array("tipo" => 3, "valor" => $periodo);
                    $datos[] = array("tipo" => 3, "valor" => $key);
                    $datos[] = array("tipo" => 3, "valor" => $regi['nombre']);  //echo $dato['movi'];  </td>
                    $datos[] = array("tipo" => 2, "valor" => $regi['inicial']); // </td>
                    $datos[] = array("tipo" => 2, "valor" => $regi['debe']); //, true) </td>
                    $datos[] = array("tipo" => 2, "valor" => $regi['haber']); //, true) </td>
                    $datos[] = array("tipo" => 2, "valor" => $regi['saldo']); //; </td>
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
                $fila++;

                sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
          
     


        $hoja = $xl->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        die();
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");

               $acceso = MenuSeguridad::Acceso('mov_cuenta_mensual');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        $mes['1'] = "Enero";
        $mes['2'] = "Febrero";
        $mes['3'] = "Marzo";
        $mes['4'] = "Abril";
        $mes['5'] = "Mayo";
        $mes['6'] = "Junio";
        $mes['7'] = "Julio";
        $mes['8'] = "Agosto";
        $mes['9'] = "Septiembre";
        $mes['10'] = "Octubre";
        $mes['11'] = "Noviembre";
        $mes['12'] = "Diciembre";

        $muestra = $request->getParameter('id');
        $test = $request->getParameter('test');
        $this->test = $test;
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionCuenta', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $bodegaId = null;
        if ($usuarioQue) {
            $bodegaId = $usuarioQue->getTiendaId();
        }
        if (!$valores) {
            $valores['mes'] = date('m');
            $valores['anio'] = date('Y');
            $valores['cuenta_contable'] = null;
            $valores['cuenta_contable2'] = null;
            sfContext::getInstance()->getUser()->setAttribute('seleccionCuenta', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaMesCuentaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('seleccionCuenta', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionCuenta', null, 'consulta'));
                $this->redirect('mov_cuenta_mensual/index?id=1');
            }
        }

        $listaCue = null;
        if ($valores['cuenta_contable']) {
            $listaCue[] = $valores['cuenta_contable'];
            if ($valores['cuenta_contable2']) {
                $listaCue[] = $valores['cuenta_contable2'];
                $nombreBanco = CuentaErpContableQuery::create()
                        ->where("CuentaErpContable.CuentaContable >= '" . $valores['cuenta_contable'] . "'")
                        ->where("CuentaErpContable.CuentaContable <= '" . $valores['cuenta_contable2'] . "'")
                      //  ->where('length(CuentaErpContable.CuentaContable) >6 ')
                        ->find();
                foreach ($nombreBanco as $reg) {
                    $listaCue[] = $reg->getCuentaContable();
                }
            }
        }

        $cuentas = new CuentaErpContableQuery();
        $cuentas->orderByCuentaContable("Asc");
        if ($listaCue) {
            $cuentas->filterByCuentaContable($listaCue, Criteria::IN);
        }
        $this->cuentas = $cuentas->find();
        $this->periodo = $mes[(int) $valores['mes']] . " " . $valores['anio'];
        foreach ($this->cuentas as $cuenta) {
            $datos = null;
            $perioodo = $valores['anio'] . $valores['mes'];
            $inicial = $cuenta->getValorInicial($perioodo);
            $debe = $cuenta->getValorPeriodoTipo($perioodo, 1);
            $haber = $cuenta->getValorPeriodoTipo($perioodo, 2);
            $data['cuenta'] = $cuenta->getCuentaContable();
            $data['nombre'] = $cuenta->getNombre();
            $data['inicial'] = $inicial;
            $data['debe'] = $debe;
            $data['haber'] = $haber;
            $saldo = $inicial + $debe - $haber;
            $data['saldo'] = $saldo;
            $imprime = false;
            if ($inicial) {
                $imprime = true;
            }
            if ($debe) {
                $imprime = true;
            }
            if ($haber) {
                $imprime = true;
            }
            if ($imprime) {
                $resumen[$cuenta->getCuentaContable()] = $data;
            }
        }
        $this->resumen = $resumen;
        
        sfContext::getInstance()->getUser()->setAttribute('datos', $resumen, 'consulta');

//        if ($listaCue) {
//            echo "<pre>";
//            print_r($resumen);
//            die();
//        }
    }

}
