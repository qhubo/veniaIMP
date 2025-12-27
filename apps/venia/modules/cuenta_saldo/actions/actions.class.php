<?php

/**
 * cuenta_saldo actions.
 *
 * @package    plan
 * @subpackage cuenta_saldo
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cuenta_saldoActions extends sfActions {

    public function executeExcel(sfWebRequest $request) {
        $resultado = unserialize(sfContext::getInstance()->getUser()->getAttribute('resultado', null, 'consulta'));
        $resumen = unserialize(sfContext::getInstance()->getUser()->getAttribute('resumen', null, 'consulta'));
        $periodos = unserialize(sfContext::getInstance()->getUser()->getAttribute('periodos', null, 'consulta'));
        $cuentas = unserialize(sfContext::getInstance()->getUser()->getAttribute('cuentas', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $nombreempresa = "Libro de Saldos " . $usuarioQue->getEmpresa()->getNombre();
        $pestanas[] = 'Cuentas';
        $pestanas[] = 'Agrupado';
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionpesa', null, 'consulta'));
        $mesInicio = $valores['mes_inicio'];
        if (strlen($valores['mes_inicio']) == 1) {
            $mesInicio = "0" . $valores['mes_inicio'];
        }
        $mesFin = $valores['mes_fin'];
        if (strlen($valores['mes_fin']) == 1) {
            $mesFin = "0" . $valores['mes_fin'];
        }
        $fechaInicio = $mesInicio . "_" . $valores['anio_inicio'];
        $fechafin = $mesFin . "_" . $valores['anio_fin'];
        $filename = "Libro Saldos " . $fechaInicio . " " . $fechafin;
        $fechaInicio = $mesInicio . "/" . $valores['anio_inicio'];
        $fechafin = $mesFin . "/" . $valores['anio_fin'];
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, "Libro de Saldos");
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("LIBRO SALDOS  DEL " . $fechaInicio . " AL " . $fechafin, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->mergeCells("A1:E1");
        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');
        $fila++;
        $encabezados = null;
        $encabezados[] = array("Nombre" => 'Cuenta', "width" => 22, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Descripción', "width" => 38, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Saldo Inicial', "width" => 16, "align" => "right", "format" => "#,##0.00");
        foreach ($periodos as $Perido) {
            $encabezados[] = array("Nombre" => $Perido['detalle'], "width" => 16, "align" => "right", "format" => "#,##0.00");
        }
        $encabezados[] = array("Nombre" => 'Total', "width" => 18, "align" => "right", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
 $graTOtal =0; 
                             $TOtalFInal =0; 
                               $lineaTotal =null; 
        if ($resultado) {
            Foreach ($periodos as $Perido) { 
      
                              $lineaTotal[$Perido['periodo']] =0; 
                              } 
            foreach ($resultado as $regi) {
                $fila++;
                $datos = null;
                $datos[] = array("tipo" => 3, "valor" => $regi['cuenta']);
                $datos[] = array("tipo" => 3, "valor" => strtoupper($regi['nombre']));  // ENTERO
                $datos[] = array("tipo" => 2, "valor" => round($regi['inicial'], 2));  // ENTERO
                $graTOtal =$graTOtal+$regi['inicial'];
                foreach ($periodos as $Perido) {
                      $lineaTotal[$Perido['periodo']] =$lineaTotal[$Perido['periodo']]+$regi[$Perido['periodo']];
                    $datos[] = array("tipo" => 2, "valor" => round($regi[$Perido['periodo']], 2));  // ENTERO
                }
                $TOtalFInal =$TOtalFInal+$regi['total']; 
                $datos[] = array("tipo" => 2, "valor" => round($regi['total'], 2));  // ENTERO
                sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
            }
        
            $fila++;
              $datos = null;
                $datos[] = array("tipo" => 3, "valor" => '');
                $datos[] = array("tipo" => 3, "valor" => 'TOTALES');  // ENTERO
                $datos[] = array("tipo" => 2, "valor" => round($graTOtal, 2));  // ENTERO
                foreach ($periodos as $Perido) {
                    $datos[] = array("tipo" => 2, "valor" => round($lineaTotal[$Perido['periodo']], 2));  // ENTERO 
                }
                $datos[] = array("tipo" => 2, "valor" => round($TOtalFInal, 2));  // ENTERO
             sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
                }
                $hoja->getStyle("B".$fila)->getFont()->setBold(true);

        $hoja = $xl->setActiveSheetIndex(1);
        $hoja->getCell("A1")->setValueExplicit("LIBRO SALDOS AGRUPADO  DEL " . $fechaInicio . " AL " . $fechafin, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->mergeCells("A1:E1");
        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');
        $fila++;
        $encabezados = null;
        $encabezados[] = array("Nombre" => 'Cuenta', "width" => 22, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Saldo Inicial', "width" => 16, "align" => "right", "format" => "#,##0.00");
        foreach ($periodos as $Perido) {
            $encabezados[] = array("Nombre" => $Perido['detalle'], "width" => 16, "align" => "right", "format" => "#,##0.00");
        }
        $encabezados[] = array("Nombre" => 'Total', "width" => 18, "align" => "right", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

        if ($resumen) {
          
            foreach ($resumen as $key => $regi) {
  $imprime=0;
                $inicial = 0;
                $total = 0;
                foreach ($regi as $deta) {
                    $inicial = $inicial + $deta['inicial'];
                    $total = $total + $deta['total'];
                }
            
                $datos = null;
                $datos[] = array("tipo" => 3, "valor" => $key);
                $datos[] = array("tipo" => 2, "valor" =>  round($inicial,2));  // ENTERO
                if ($inicial) {
                    $imprime++;
                }
                foreach ($periodos as $Perido) {
                    $valorPe = 0;
                    foreach ($regi as $deta) {
                        $valorUn =round($deta[$Perido['periodo']],2);
                        $valorPe = $valorPe + $valorUn;
                    }
 if ($valorPe) {
                    $imprime++;
                }
                    $datos[] = array("tipo" => 2, "valor" => round($valorPe, 2));  // ENTERO
                }


                // $imprime=true;

                $datos[] = array("tipo" => 2, "valor" => round($total, 2));  // ENTERO
                if ($imprime) {
                        $fila++;
                sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
                }
            }
        }



        $hoja = $xl->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        die();
    }

    public function executeReporte2(sfWebRequest $request) {
        $this->getResponse()->setContentType('charset=utf-8');
        date_default_timezone_set("America/Guatemala");
        $nombre = 'CUENTA_SALDO_AGRUPADO' . date('Ymd') . '.csv';
        header('Expires: 0');
        header('Cache-control: private');
        header('Content-Type: application/x-octet-stream'); // Archivo de Excel
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
        header('Last-Modified: ' . date('D, d M Y H:i:s'));
        header('Content-Disposition: attachment; filename="' . $nombre . '"');
        header("Content-Transfer-Encoding: binary");
        $resumen = unserialize(sfContext::getInstance()->getUser()->getAttribute('resumen', null, 'consulta'));
        $resultado = unserialize(sfContext::getInstance()->getUser()->getAttribute('resultado', null, 'consulta'));
        $periodos = unserialize(sfContext::getInstance()->getUser()->getAttribute('periodos', null, 'consulta'));
        $cuentas = unserialize(sfContext::getInstance()->getUser()->getAttribute('cuentas', null, 'consulta'));

        $Datos = "Cuenta, Saldo Inicial,";
        foreach ($periodos as $Perido) {
            $Datos .= $Perido['detalle'] . ",";
        }
        $Datos .= 'Total';
        $Datos .= "\r\n";
        if ($resumen) {
            foreach ($resumen as $key => $regi) {

                $inicial = 0;
                $total = 0;
                foreach ($regi as $deta) {
                    $inicial = $inicial + $deta['inicial'];
                    $total = $total + $deta['total'];
                }
                $linea = $key . "," . $inicial . ",";
                foreach ($periodos as $Perido) {
                    $valorPe = 0;
                    foreach ($regi as $deta) {
                        $valorPe = $valorPe + $deta[$Perido['periodo']];
                    }
                    $linea .= $valorPe . ",";
                }
                $linea .= '' . $total;
                $Datos .= $linea;
                $Datos .= "\r\n";
            }
        }
        echo $Datos;
        die();
    }

    public function executeReporte(sfWebRequest $request) {
        $this->getResponse()->setContentType('charset=utf-8');
        date_default_timezone_set("America/Guatemala");
        $nombre = 'CUENTA_SALDO' . date('Ymd') . '.csv';
        header('Expires: 0');
        header('Cache-control: private');
        header('Content-Type: application/x-octet-stream'); // Archivo de Excel
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
        header('Last-Modified: ' . date('D, d M Y H:i:s'));
        header('Content-Disposition: attachment; filename="' . $nombre . '"');
        header("Content-Transfer-Encoding: binary");
        //$resumen= unserialize( sfContext::getInstance()->getUser()->getAttribute('resumen', null, 'consulta')); 
        $resultado = unserialize(sfContext::getInstance()->getUser()->getAttribute('resultado', null, 'consulta'));
        $periodos = unserialize(sfContext::getInstance()->getUser()->getAttribute('periodos', null, 'consulta'));
        $cuentas = unserialize(sfContext::getInstance()->getUser()->getAttribute('cuentas', null, 'consulta'));

        $Datos = "Cuenta,Descripcion, Saldo Inicial,";
        foreach ($periodos as $Perido) {
            $Datos .= $Perido['detalle'] . ",";
        }
        $Datos .= 'Total';
        $Datos .= "\r\n";
        if ($resultado) {
            foreach ($resultado as $regi) {

                $linea = $regi['cuenta'] . " ," . $regi['nombre'] . "," . $regi['inicial'] . ",";
                foreach ($periodos as $Perido) {
                    $linea .= $regi[$Perido['periodo']] . ",";
                }
                $linea .= '' . $regi['total'];
                $Datos .= $linea;
                $Datos .= "\r\n";
            }
        }
        echo $Datos;
        die();
    }
    

    public function executeIndex(sfWebRequest $request) {
        
                $acceso = MenuSeguridad::Acceso('cuenta_saldo');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionpesa', null, 'consulta'));
        $default = $valores;
        $muestra = $request->getParameter('id');
        $resultado = null;
        $resumen = null;
        if (!$valores) {
            $mesINi = (int) (date('m') - 1);
            $default['mes_inicio'] = $mesINi;
            $default['anio_inicio'] = date('Y');
            $default['mes_fin'] = date('m');
            $default['anio_fin'] = date('Y');
            sfContext::getInstance()->getUser()->setAttribute('seleccionpesa', serialize($default), 'consulta');
        }
        $this->form = new ConsultaCuentaPeriodoForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('seleccionpesa', serialize($valores), 'consulta');
                $this->redirect('cuenta_saldo/index?id=' . $muestra);
            }
        }
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionpesa', null, 'consulta'));
        $mesInicio = $valores['mes_inicio'];
        if (strlen($valores['mes_inicio']) == 1) {
            $mesInicio = "0" . $valores['mes_inicio'];
        }
        $mesFin = $valores['mes_fin'];
        if (strlen($valores['mes_fin']) == 1) {
            $mesFin = "0" . $valores['mes_fin'];
        }
        $fechaInicio = $valores['anio_inicio'] . "-" . $mesInicio . "-01";
        $fechafin = ( $valores['anio_fin'] . "-" . $mesFin . "-01");
        $fechaUno = $fechaInicio;
        $dateInicio = new DateTime($fechaInicio);
        $dateFin = new DateTime($fechafin);
        $Diferencia = $dateInicio->diff($dateFin);
        $Meses = (int) $Diferencia->format('%M') + 1;
        $listaPeriodo = null;
        $lista = null;
        
//        echo $Meses;
//        die();
        for ($i = 0; $i < $Meses; $i++) {
            $Periodo = strtotime($fechaUno . "+ " . $i . " months");
            $mes = date("m", $Periodo);
            $Anio = date("Y", $Periodo) . "-" . $this->mesDesc($mes);
            $Per = date("Ym", $Periodo);
            $lista['periodo'] = $Per;
            $lista['detalle'] = $Anio;
            $listaPeriodo[] = $lista;
        }
        $this->periodos = $listaPeriodo;
        $this->cuentas = null;
        if ($muestra) {
            $cuentas = new CuentaErpContableQuery();
            $cuentas->orderByCuentaContable("Asc");
//            $cuentas->setLimit(30);
       //    $cuentas->where("SUBSTR(CuentaErpContable.CuentaContable,1, 1) =6");
        //   $cuentas->where('length(CuentaErpContable.CuentaContable) >6 ');
//            $cuentas->where("CuentaErpContable.CuentaContable like '%6000%'");
          //  $cuentas->where("SUBSTR(CuentaErpContable.CuentaContable, length(cuenta_contable)-1, 2) <> '00'");
            if ($valores['cuenta_contable']) {
                $cuentas->filterByCuentaContable($valores['cuenta_contable']);
            }
            $this->cuentas = $cuentas->find();
            foreach ($this->cuentas as $cuenta) {
                $datos=null;
                $inicial = $cuenta->getValorInicial($this->periodos[0]['periodo']);
                $total = $inicial;
                $data['cuenta'] = $cuenta->getCuentaContable();
                $data['nombre'] = $cuenta->getNombre();
                $data['inicial'] = $inicial;
                $imprime = false;
                if ($inicial <> 0) {
                     $imprime = true;
                }
                foreach ($this->periodos as $Perido) {
                    $valor = $cuenta->getValorPeriodo($Perido['periodo']);
                    if ($valor <> 0) {
                        $imprime = true;
                    }
                    $data[$Perido['periodo']] = $valor;
                    $total = $total + $valor;
                }
                $data['total'] = $total;
                if ($imprime) {
                    $resultado[$cuenta->getCuentaContable()] = $data;
                }

                if (substr($cuenta->getCuentaContable(), 0, 1) > 3) {
//                     echo $cuenta->getCuentaContable();                     
                    if (array_key_exists($cuenta->getCuentaContable(), $resultado)) {
                        $datos = $resultado[$cuenta->getCuentaContable()];
                         
                    }
                    if (substr($cuenta->getCuentaContable(), -2) == "01") {
//                        echo "<font color='red'>" . $cuenta->getCuentaContable() . "</font>";
                      $resumen[$cuenta->getCuentaContable()][] = $datos;
                    } else {
                        $agrupado = substr($cuenta->getCuentaContable(), 0, 4) . "-99";
                        if ((substr($datos['cuenta'],-2)) <>  "01") {                       
                         $resumen[$agrupado][$cuenta->getCuentaContable()] = $datos;
                         }
                    }
                }
            }

            $this->resumen = $resumen;
//                  echo "<pre>";
//            print_r($resultado);
//              echo "</pre>";
//            
//              echo "<pre>";
//            print_r($resumen);
//              echo "</pre>";
////      
//         die();
        }
        $this->resultado = $resultado;

        sfContext::getInstance()->getUser()->setAttribute('resumen', serialize($resumen), 'consulta');
        sfContext::getInstance()->getUser()->setAttribute('resultado', serialize($resultado), 'consulta');
        sfContext::getInstance()->getUser()->setAttribute('periodos', serialize($this->periodos), 'consulta');
        sfContext::getInstance()->getUser()->setAttribute('cuentas', serialize($this->cuentas), 'consulta');
    }

    public function mesDesc($mes) {
        $mes = (int) $mes;
        $data[1] = 'Ene';
        $data[2] = 'Feb';
        $data[3] = 'Mar';
        $data[4] = 'Abr';
        $data[5] = 'May';
        $data[6] = 'Jun';
        $data[7] = 'Jul';
        $data[8] = 'Ago';
        $data[9] = 'Sep';
        $data[10] = 'Oct';
        $data[11] = 'Nov';
        $data[12] = 'Dic';
        $retorna = $data[$mes];
        return $retorna;
    }

}
