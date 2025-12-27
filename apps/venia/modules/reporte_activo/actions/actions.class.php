<?php

/**
 * reporte_activo actions.
 *
 * @package    plan
 * @subpackage reporte_activo
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporte_activoActions extends sfActions {

    public function executePartida(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
      $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $valoresPartida = $this->Partidas();
        $fecha = $valoresPartida['fecha'];
        $fechaINICIAL = $fecha;
        $listaResumida = $valoresPartida['listaResumida'];
        $listaCuentaHaber = $valoresPartida['listaCuentaHaber'];
        foreach ($listaResumida as $registro) {
            $datos = null;
            $datos['cuenta'] = $registro['debe_cuenta'];  // ENTERO
            $datos['nombre'] = $registro['debe_nombre'];  // ENTERO
            $datos['debe'] = $registro['valor'];  // ENTERO
            $datos['haber'] = 00;  // ENTERO
            $listaFinal[] = $datos;
        }
        foreach ($listaCuentaHaber as $key => $valores) {
            $totalLinea = 0;
            foreach ($valores as $value) {
                $totalLinea = $value + $totalLinea;
            }
            $cuentaHaber = CuentaErpContableQuery::create()->findOneByCuentaContable($key);
            $datos = null;
            $datos['cuenta'] = $cuentaHaber->getCuentaContable();  // ENTERO
            $datos['nombre'] = $cuentaHaber->getNombre();  // ENTERO
            $datos['debe'] = 0;
            $datos['haber'] = $totalLinea;  // ENTERO
            $listaFinal[] = $datos;
        }
        $this->partidaDetalle = $listaFinal;
        
//        echo "<pre>";
//        print_r($this->partidaDetalle);
//        die();

        $this->cuentasUno = CuentaErpContableQuery::create()
                //        ->filterByTipo(1)
                ->find();
        $this->cuentasDos = CuentaErpContableQuery::create()
                //        ->filterByTipo(2)
                ->find();
        $defaulta = null;

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionpe', null, 'consulta'));
        $mesInicio = $valores['mes_inicio'];
        if (strlen($valores['mes_inicio']) == 1) {
            $mesInicio = "0" . $valores['mes_inicio'];
        }
        $fechaINICIAL = '01-' . $mesInicio . "-" . $valores['anio_inicio'];
        $FECHA = $valores['anio_inicio'] . "-" . $mesInicio . "-01";

        $defaulta['fecha'] = date('d/m/Y');
        $defaulta['detalle'] = "Activos Periodo " . $mesInicio . " " . $valores['anio_inicio'];
        $defaulta['numero'] = 'ACTIVOS' . $mesInicio . $valores['anio_inicio'];

        $this->form = new CreaPartidaActivoForm($defaulta);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                
                
                     $numero = $valores['numero'];
                $fechaInicio = $valores['fecha'];
                $fechaInicio = explode('/', $fechaInicio);
                $mes=$fechaInicio[1];
                $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
                $partida = PartidaQuery::create()->findOneByCodigo($numero);
                if (!$partida) {
                 $partida = new Partida();
                      $partida->setCodigo($numero);
                }
                $partida->setEstatus('Confirmado');
                $partida->setFechaContable($fechaInicio);
                $partida->setTipo($valores['detalle']);
                $partida->setNumero($mes);
                $partida->setUsuario($usuarioQ->getUsuario());
                $partida->save();
          
                $total =0;
              $cont=0; 
          if ($partida){
              $partidaDetlle = PartidaDetalleQuery::create()->filterByPartidaId($partida->getId())->find();
              if ($partidaDetlle) {
                  $partidaDetlle->delete();
              }
          }
              foreach ($this->partidaDetalle as $reg) { 
                   $cont++; 
                 
                  $cuentaId=$request->getParameter('cuenta'.$cont);
                 $debe=$reg['debe'];
                 $haber=$reg['haber'];
                 $total= $debe+$total;
                 $cuentaEr = CuentaErpContableQuery::create()->findOneByCuentaContable($cuentaId);
                 
                 $paridaDe=new PartidaDetalle();
                 $paridaDe->setCuentaContable($cuentaEr->getCuentaContable());
                 $paridaDe->setDebe($debe);
                 $paridaDe->setHaber($haber);
                 $paridaDe->setDetalle($cuentaEr->getNombre());
                 $paridaDe->setPartidaId($partida->getId());
                 $paridaDe->save();
       
                    }
                    
                    
                    $partida->setValor($total);
                    $partida->setConfirmada(true);
                    $partida->save();
                    $this->getUser()->setFlash('exito', 'Partida cerrada con exito ');
                    $this->redirect('reporte_activo/index?id=' . $partida->getId());
                    
                  //  die();
            }
        }
    }

    public function Partidas() {
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionpe', null, 'consulta'));
        $mesInicio = $valores['mes_inicio'];
        if (strlen($valores['mes_inicio']) == 1) {
            $mesInicio = "0" . $valores['mes_inicio'];
        }
        $fechaINICIAL = '01-' . $mesInicio . "-" . $valores['anio_inicio'];
        $FECHA = $valores['anio_inicio'] . "-" . $mesInicio . "-01";
        $registros = ListaActivosQuery::create();
        if ($valores['cuenta_contable']) {
            $registros->filterByCuentaErpContableId($valores['cuenta_contable']);
        }
        $registros->where("DATE_ADD(ListaActivos.FechaAdquision,INTERVAL anio_util+1 YEAR) > '" . date('Y-m-d') . "'");
        $registros->withColumn('DATE_ADD(ListaActivos.FechaAdquision,INTERVAL anio_util YEAR)', 'FechaVence');
        $registros->where("DATE_ADD(ListaActivos.FechaAdquision,INTERVAL anio_util YEAR) > '" . $FECHA . "'");
        $registros->find();
        $this->registros = $registros->find();

        $TOTAL = 0;
        foreach ($this->registros as $data) {
            $valorLibros = ($data->getValorLibro() - $data->getDepreAcumulada($fechaINICIAL));

            if ($valorLibros > 0) {
                $valorMensual = $data->getDepreMensual($fechaINICIAL);
                $TOTAL = $TOTAL + round($valorMensual, 2);
                $cuenta = $data->getCuentaErpContable()->getCuentaContable();
                $cuentaOriginal = $cuenta;
                $cuenta = $this->cuentaPadre($cuenta);
                $cuentaHaber = $this->cuenta($cuenta);
                $cuentaQuer = CuentaErpContableQuery::create()->findOneByCuentaContable($cuenta);

                $datosV = null;
                $datosV['cuenta_original'] = $cuentaOriginal;
                $datosV['debe_cuenta'] = $cuentaQuer->getCuentaContable();
                $datosV['debe_nombre'] = $cuentaQuer->getNombre();
                $datosV['haber_cuenta'] = $cuentaHaber['cuenta'];
                $datosV['haber_nombre'] = $cuentaHaber['nombre'];
                $datosV['descripcion'] = $data->getDetalle();
                $datosV['valor'] = round($valorMensual, 2);
                $listacuenta[$cuenta][] = round($valorMensual, 2);
                $listaDatos[] = $datosV;
            }
        }



        foreach ($listacuenta as $key => $valores) {
            $totalLinea = 0;
            foreach ($valores as $value) {
                $totalLinea = $value + $totalLinea;
            }
            $cuentaDebe = CuentaErpContableQuery::create()->findOneByCuentaContable($key);
            $cuentaHaber = $this->cuenta($key);
            $keyHaber = $cuentaHaber['cuenta'];
            $datosV = null;
            $datosV['debe_cuenta'] = $cuentaDebe->getCuentaContable();
            $datosV['debe_nombre'] = $cuentaDebe->getNombre();
//            $datosV['haber_cuenta'] = $cuentaHaber['cuenta'];
//            $datosV['haber_nombre'] = $cuentaHaber['nombre'];
            $datosV['valor'] = round($totalLinea, 2);
            $listaResumida[$key] = $datosV;
            $listaCuentaHaber[$keyHaber][] = round($totalLinea, 2);
        }
        $retorna['listaCuentaHaber'] = $listaCuentaHaber;
        $retorna['fecha'] = $fechaINICIAL;
        $retorna['listaResumida'] = $listaResumida;
        $retorna['listaDatos'] = $listaDatos;
        $retorna['valores'] = $valores;

//              echo  "<pre>";
//        print_r($retorna['listaResumida']);
//        die();
//      

        return $retorna;
    }

    public function cuentaPadre($cuenta) {
        $data['1505-08'] = '6210-08';
        $data['1510-08'] = '6210-08';
        $data['1515-01'] = '6210-01';
        $data['1515-02'] = '6210-08';
        $data['1515-08'] = '6210-08';
        $data['1520-01'] = '6210-01';
        $data['1520-02'] = '6210-08';
        $data['1520-03'] = '6210-08';
        $data['1520-08'] = '6210-08';
        $data['1525-01'] = '6210-08';
        $data['1525-02'] = '6210-08';
        $data['1525-03'] = '6210-08';
        $data['1525-08'] = '6210-08';
        $data['1530-01'] = '6210-01';
        $data['1530-02'] = '6210-08';
        $data['1530-03'] = '6210-08';
        $data['1530-08'] = '6210-08';
        $data['1540-01'] = '6210-01';
        $data['1540-08'] = '6210-08';

        $retorna = $data[$cuenta];
        return $retorna;
    }

    public function cuenta($cuenta) {

//        [11:19 a. m., 23/5/2023] Witson Franco: 1541-01
//[11:19 a. m., 23/5/2023] Witson Franco: 1541-08
        $data['6210-01'] = '1541-01';
        $data['6210-08'] = '1541-08';
        $data['1505-08'] = '1541-08';
        $data['1510-08'] = '1541-08';
        $data['1515-01'] = '1541-01';
        $data['1515-02'] = '1541-08';
        $data['1515-08'] = '1541-08';
        $data['1520-01'] = '1541-01';
        $data['1520-02'] = '1541-08';
        $data['1520-03'] = '1541-08';
        $data['1520-08'] = '1541-08';
        $data['1525-01'] = '1541-01';
        $data['1525-02'] = '1541-08';
        $data['1525-03'] = '1541-08';
        $data['1525-08'] = '1541-08';
        $data['1530-01'] = '1541-01';
        $data['1530-02'] = '1541-08';
        $data['1530-03'] = '1541-08';
        $data['1530-08'] = '1541-08';
        $data['1540-01'] = '1541-01';
        $data['1540-08'] = '1541-08';
        $cuentaContable = CuentaErpContableQuery::create()->findOneByCuentaContable($data[$cuenta]);
        $nombre = '';
        $cuenta = '';
        if ($cuentaContable) {
            $cuenta = $cuentaContable->getCuentaContable();
            $nombre = $cuentaContable->getNombre();
        }
        $retonra['cuenta'] = $cuenta;
        $retonra['nombre'] = $nombre;
        return $retonra;
    }

    public function executeReporte(sfWebRequest $request) {
        $valoresPartida = $this->Partidas();
        $fecha = $valoresPartida['fecha'];
        $fechaINICIAL = $fecha;
        $listaResumida = $valoresPartida['listaResumida'];
        $listaDatos = $valoresPartida['listaDatos'];
        $listaCuentaHaber = $valoresPartida['listaCuentaHaber'];
        $valores = $valoresPartida['valores'];

        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $empresa = $usuarioQue->getEmpresa()->getNombre();
        $empresaQ = $usuarioQue->getEmpresa();
        $nombreempresa = "Libro Activos";
        $pestanas[] = 'Lista ACTIVOS';
        $pestanas[] = 'Partida RESUMIDA';
        $pestanas[] = 'Partidas';
        $nombre = "Libro Activos";
        $filename = "LIBROS ACTIVOS" . $fecha;
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);

        /// *********************PARTIDA  RESUMIDA
        $hoja = $xl->setActiveSheetIndex(1);
        $hoja->getRowDimension('1')->setRowHeight(22);
        $hoja->getRowDimension('2')->setRowHeight(23);
        $hoja->mergeCells("A1:A2");
        $logoFile = $empresaQ->getLogo();
        $obj = new PHPExcel_Worksheet_Drawing();
        $obj->setName("Logo");
        $obj->setDescription("Logo");
        $obj->setPath("./uploads/images/" . $logoFile);
        $obj->setCoordinates("A1");
        $obj->setHeight(45);
        $obj->setWorksheet($hoja);
        $hoja->getCell("B1")->setValueExplicit("LIBRO ACTIVOS   " . $empresa . " PERIODO " . $fecha, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(10);
        $hoja->mergeCells("B1:J1");

        $hoja->getCell("B2")->setValueExplicit("PARTIDA DEL  PERIODO " . $fecha, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B2")->getFont()->setBold(true);
        $hoja->getStyle("B2")->getFont()->setSize(10);
        $hoja->mergeCells("B2:J2");
        $fila = 3;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');
//        $encabezados[] = array("Nombre" => 'Partida', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Fecha', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Cuenta', "width" => 20, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Descripcion', "width" => 45, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Debe', "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'Haber', "width" => 15, "align" => "left", "format" => "#,##0.00");
//        $encabezados[] = array("Nombre" => 'Detalle', "width" => 35, "align" => "left", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $total1 = 0;
        $total2 = 0;
        foreach ($listaResumida as $registro) {
            $fila++;
            $datos = null;
//            $datos[] = array("tipo" => 3, "valor" => '');
            $datos[] = array("tipo" => 3, "valor" => $fecha);
            $datos[] = array("tipo" => 3, "valor" => $registro['debe_cuenta']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['debe_nombre']);  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $registro['valor']);  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => 0.00);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => '');
            $total1 = $total1 + $registro['valor'];
            sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        foreach ($listaCuentaHaber as $key => $valores) {
            $totalLinea = 0;
            foreach ($valores as $value) {
                $totalLinea = $value + $totalLinea;
            }
            $cuentaHaber = CuentaErpContableQuery::create()->findOneByCuentaContable($key);
            $fila++;
            $datos = null;
//            $datos[] = array("tipo" => 3, "valor" => '');
            $datos[] = array("tipo" => 3, "valor" => $fecha);
            $datos[] = array("tipo" => 3, "valor" => $cuentaHaber->getCuentaContable());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $cuentaHaber->getNombre());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => 0);  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $totalLinea);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => '');
            $total2 = $total2 + $totalLinea;
            sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;
        $encabezados = null;
        $encabezados[] = array("Nombre" => 'Totales', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => '', "width" => 20, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => '', "width" => 45, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => round($total1, 2), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => round($total2, 2), "width" => 15, "align" => "right", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        //// ************  FIN PARTIDA RESUMIDA
        /// *********************PARTIDAS
        $hoja = $xl->setActiveSheetIndex(2);
        $hoja->getRowDimension('1')->setRowHeight(22);
        $hoja->getRowDimension('2')->setRowHeight(23);
        $hoja->mergeCells("A1:A2");
        $logoFile = $empresaQ->getLogo();
        $obj = new PHPExcel_Worksheet_Drawing();
        $obj->setName("Logo");
        $obj->setDescription("Logo");
        $obj->setPath("./uploads/images/" . $logoFile);
        $obj->setCoordinates("A1");
        $obj->setHeight(45);
        $obj->setWorksheet($hoja);
        $hoja->getCell("B1")->setValueExplicit("LIBRO ACTIVOS " . $empresa . " PERIODO " . $fecha, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(10);
        $hoja->mergeCells("B1:J1");

        $hoja->getCell("B2")->setValueExplicit("DETALLE DE PARTIDAS PERIODO " . $fecha, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B2")->getFont()->setBold(true);
        $hoja->getStyle("B2")->getFont()->setSize(10);
        $hoja->mergeCells("B2:J2");
        $fila = 3;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');
        $encabezados[] = array("Nombre" => 'Partida', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Fecha', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Cuenta', "width" => 20, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Descripcion', "width" => 45, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Debe', "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'Haber', "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'Detalle', "width" => 35, "align" => "left", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $total1 = 0;
        $total2 = 0;
        $contador = 0;
//        echo "<pre>";
//        print_r($listaDatos);
//        die();

        foreach ($listaDatos as $registro) {
            $contador++;
            $fila++;
            $datos = null;
            $cuentaDebe = CuentaErpContableQuery::create()->findOneByCuentaContable($registro['cuenta_original']);

            $datos[] = array("tipo" => 3, "valor" => $contador);
            $datos[] = array("tipo" => 3, "valor" => $fecha);
            $datos[] = array("tipo" => 3, "valor" => $registro['cuenta_original']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $cuentaDebe->getNombre());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $registro['valor']);  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => 0.00);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['descripcion']);
            $total1 = $total1 + $registro['valor'];
            sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $contador);
            $datos[] = array("tipo" => 3, "valor" => $fecha);
            $datos[] = array("tipo" => 3, "valor" => $registro['haber_cuenta']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['haber_nombre']);  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => 0.00);  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $registro['valor']);  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro['descripcion']);
            $total2 = $total2 + $registro['valor'];
            sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }

        $fila++;
        $encabezados = null;
        $encabezados[] = array("Nombre" => '', "width" => 20, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Totales', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => '', "width" => 20, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => '', "width" => 45, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => round($total1, 2), "width" => 15, "align" => "right", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => round($total2, 2), "width" => 15, "align" => "right", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        //// ************ PARTIDAS
        /// *********************ACTIVOS
        $hoja = $xl->setActiveSheetIndex(0);

        //CABECERA  Y FILTRO        
        $hoja->getRowDimension('1')->setRowHeight(22);
        $hoja->getRowDimension('2')->setRowHeight(23);
        $hoja->mergeCells("A1:A2");
        $logoFile = $empresaQ->getLogo();
        $obj = new PHPExcel_Worksheet_Drawing();
        $obj->setName("Logo");
        $obj->setDescription("Logo");
        $obj->setPath("./uploads/images/" . $logoFile);
        $obj->setCoordinates("A1");
        $obj->setHeight(45);
        $obj->setWorksheet($hoja);
        $hoja->getCell("B1")->setValueExplicit("LIBRO ACTIVOS " . $empresa . " PERIODO " . $fecha, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(10);
        $hoja->mergeCells("B1:J1");

        $hoja->getCell("B2")->setValueExplicit(" PERIODO " . $fecha, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B2")->getFont()->setBold(true);
        $hoja->getStyle("B2")->getFont()->setSize(10);
        $hoja->mergeCells("B2:J2");
        $fila = 3;
        $columna = 0;
        $encabezados = null;
        $hoja->getStyle('A')->getAlignment()->setWrapText(true);
        $hoja->getStyle('E')->getAlignment()->setWrapText(true);
        $hoja->getStyle('F')->getAlignment()->setWrapText(true);
        $hoja->getStyle('G')->getAlignment()->setWrapText(true);
        $hoja->getStyle('H')->getAlignment()->setWrapText(true);
        $hoja->getStyle('I')->getAlignment()->setWrapText(true);
        $hoja->getStyle('J')->getAlignment()->setWrapText(true);
        $hoja->getStyle('K')->getAlignment()->setWrapText(true);
        $hoja->getStyle('L')->getAlignment()->setWrapText(true);
        $hoja->getStyle('M')->getAlignment()->setWrapText(true);
        $hoja->getStyle('N')->getAlignment()->setWrapText(true);
        $hoja->getStyle('O')->getAlignment()->setWrapText(true);
        $hoja->getStyle('P')->getAlignment()->setWrapText(true);

        $this->getResponse()->setContentType('charset=utf-8');
        $encabezados[] = array("Nombre" => 'Codigo', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Account', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Account Name', "width" => 40, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Description', "width" => 45, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Adquisition Date', "width" => 16, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Ending Date', "width" => 16, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Life Years', "width" => 12, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Book Value', "width" => 12, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => '% Depreciation', "width" => 19, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Annual Depreciation', "width" => 19, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'Months Depreciation', "width" => 19, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Monthly Depreciation', "width" => 19, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'Años Transcurridos', "width" => 19, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Meses Transcurridos ', "width" => 19, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Acumulada Periodo Anterior ', "width" => 22, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'Depreciación Acumulada ', "width" => 22, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'Valor Libro ', "width" => 25, "align" => "left", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $hoja->getStyle('A')->getAlignment()->setWrapText(true);
        $hoja->getStyle('E')->getAlignment()->setWrapText(true);
        $hoja->getStyle('F')->getAlignment()->setWrapText(true);
        $hoja->getStyle('G')->getAlignment()->setWrapText(true);
        $hoja->getStyle('H')->getAlignment()->setWrapText(true);
        $hoja->getStyle('I')->getAlignment()->setWrapText(true);
        $hoja->getStyle('J')->getAlignment()->setWrapText(true);
        $hoja->getStyle('K')->getAlignment()->setWrapText(true);
        $hoja->getStyle('L')->getAlignment()->setWrapText(true);
        $hoja->getStyle('M')->getAlignment()->setWrapText(true);
        $hoja->getStyle('N')->getAlignment()->setWrapText(true);
        $hoja->getStyle('O')->getAlignment()->setWrapText(true);
        $hoja->getStyle('P')->getAlignment()->setWrapText(true);

        $registros = ListaActivosQuery::create();
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionpe', null, 'consulta'));
        $mesInicio = $valores['mes_inicio'];
        if (strlen($valores['mes_inicio']) == 1) {
            $mesInicio = "0" . $valores['mes_inicio'];
        }

        $FECHA = $valores['anio_inicio'] . "-" . $mesInicio . "-01";
        if ($valores['cuenta_contable']) {
            $registros->filterByCuentaErpContableId($valores['cuenta_contable']);
        }
        //  $registros->where("DATE_ADD(ListaActivos.FechaAdquision,INTERVAL anio_util+1 YEAR) > '" . date('Y-m-d') . "'");
        $registros->withColumn('DATE_ADD(ListaActivos.FechaAdquision,INTERVAL anio_util YEAR)', 'FechaVence');
        //    $registros->where("DATE_ADD(ListaActivos.FechaAdquision,INTERVAL anio_util YEAR) > '".$FECHA."'");
        //  $registros->find();
        $this->registros = $registros->find();

        $TOTALGENERAL = 0;
        $TOTALMENSUAL = 0;
        $todos = $request->getParameter('todos');

        foreach ($this->registros as $data) {
            $valorLibros = ($data->getValorLibro() - $data->getDepreAcumulada($fechaINICIAL));
            $imprime = false;
            if ($todos) {
                $imprime = true;
            }
            if ($valorLibros > 0) {
                $imprime = true;
            }

            if ($imprime) {
                if ($valorLibros < 0) {
                    $valorLibros = 0;
                }
                $mensual = 0;
                if ($valorLibros > 0) {
                    $mensual = $data->getDepreMensual($fechaINICIAL);
                }
                $codigo = $data->getId();
                if ($data->getCodigo()) {
                    $codigo = $data->getCodigo();
                }
                //    if ($valorLibros > 0) {
                $TOTALGENERAL = $TOTALGENERAL + round($valorLibros, 2);
                $TOTALMENSUAL = $TOTALMENSUAL + round($mensual, 2);
                $fila++;
                $datos = null;
                $datos[] = array("tipo" => 3, "valor" => $codigo);
                $datos[] = array("tipo" => 3, "valor" => $data->getCuentaContable());
                $datos[] = array("tipo" => 3, "valor" => $data->getCuentaErpContable()->getNombre());  // ENTERO
                $datos[] = array("tipo" => 3, "valor" => $data->getDetalle());  // ENTERO
                $datos[] = array("tipo" => 3, "valor" => $data->getFechaAdquision('d/m/Y'));  // ENTERO
                $datos[] = array("tipo" => 3, "valor" => $data->getFechaVence());  // ENTERO
                $datos[] = array("tipo" => 3, "valor" => $data->getAnioUtil());
                $datos[] = array("tipo" => 2, "valor" => round($data->getValorLibro(), 2));
                $datos[] = array("tipo" => 3, "valor" => $data->getPorcentaje());
                $datos[] = array("tipo" => 2, "valor" => round($data->getDepreAnual(), 2));
                $datos[] = array("tipo" => 3, "valor" => $data->getNoMeses());
                $datos[] = array("tipo" => 2, "valor" => round($mensual, 2));
                $datos[] = array("tipo" => 3, "valor" => $data->getAnioUso($fechaINICIAL));
                $datos[] = array("tipo" => 3, "valor" => $data->getMesesUso($fechaINICIAL));
                $datos[] = array("tipo" => 2, "valor" => round($data->getDepreAcumuladaMesAnterior($fechaINICIAL), 2));
                $datos[] = array("tipo" => 2, "valor" => round($data->getDepreAcumulada($fechaINICIAL), 2));
                $datos[] = array("tipo" => 2, "valor" => round($valorLibros, 2));
                $total1 = $total1 + $registro['valor'];
                sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
            }
        }
        //}
//die();

        $encabezados = NULL;
        $fila++;
        $encabezados[] = array("Nombre" => '', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => '', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => '', "width" => 40, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'TOTALES', "width" => 45, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => '***', "width" => 16, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => '**** ', "width" => 16, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => '***', "width" => 12, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => '***', "width" => 12, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => '***', "width" => 19, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => '***', "width" => 19, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => '', "width" => 19, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => $TOTALMENSUAL, "width" => 19, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => '', "width" => 19, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => ' ', "width" => 19, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => ' ', "width" => 22, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => ' ', "width" => 22, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => $TOTALGENERAL, "width" => 25, "align" => "left", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

        $hoja->getStyle('A')->getAlignment()->setWrapText(true);
        $hoja->getStyle('E')->getAlignment()->setWrapText(true);
        $hoja->getStyle('F')->getAlignment()->setWrapText(true);
        $hoja->getStyle('G')->getAlignment()->setWrapText(true);
        $hoja->getStyle('H')->getAlignment()->setWrapText(true);
        $hoja->getStyle('I')->getAlignment()->setWrapText(true);
        $hoja->getStyle('J')->getAlignment()->setWrapText(true);
        $hoja->getStyle('K')->getAlignment()->setWrapText(true);
        $hoja->getStyle('L')->getAlignment()->setWrapText(true);
        $hoja->getStyle('M')->getAlignment()->setWrapText(true);
        $hoja->getStyle('N')->getAlignment()->setWrapText(true);
        $hoja->getStyle('O')->getAlignment()->setWrapText(true);
        $hoja->getStyle('P')->getAlignment()->setWrapText(true);

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
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionpe', null, 'consulta'));
        $default = $valores;
        $muestra = $request->getParameter('id');
        $resultado = null;
        $resumen = null;
        if (!$valores) {
            $mesINi = (int) (date('m') - 1);
            $default['mes_inicio'] = $mesINi;
            $default['cuenta_contable'] = null;
            $default['anio_inicio'] = date('Y');
            sfContext::getInstance()->getUser()->setAttribute('seleccionpe', serialize($default), 'consulta');
        }

        $this->form = new ConsultaCuentaActivoForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($valores);
//                die();
                sfContext::getInstance()->getUser()->setAttribute('seleccionpe', serialize($valores), 'consulta');
                $this->redirect('reporte_activo/index?id=' . $muestra);
            }
        }

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionpe', null, 'consulta'));
        $mesInicio = $valores['mes_inicio'];
        if (strlen($valores['mes_inicio']) == 1) {
            $mesInicio = "0" . $valores['mes_inicio'];
        }
        $this->fechaINICIAL = '01-' . $mesInicio . "-" . $valores['anio_inicio'];
        $FECHA = $valores['anio_inicio'] . "-" . $mesInicio . "-01";
//        echo $FECHA;
//        die();
        $registros = ListaActivosQuery::create();

        if ($valores['cuenta_contable']) {
            $registros->filterByCuentaErpContableId($valores['cuenta_contable']);
        }
        $registros->where("DATE_ADD(ListaActivos.FechaAdquision,INTERVAL anio_util+1 YEAR) > '" . date('Y-m-d') . "'");
        $registros->withColumn('DATE_ADD(ListaActivos.FechaAdquision,INTERVAL anio_util YEAR)', 'FechaVence');
        $registros->where("DATE_ADD(ListaActivos.FechaAdquision,INTERVAL anio_util YEAR) > '" . $FECHA . "'");
        $registros->find();

        $this->registros = $registros->find();

//
//        $this->registros = ListaActivosQuery::create()
//                ->filterById(-99)
//                ->find();
//            $this->registros= ListaActivosQuery::create()
//                      ->where("ListaActivos.FechaAdquision >= '" . $fechaInicio .  "'")
//                    ->where("ListaActivos.FechaAdquision <= '" . $fechaFin .  "'")
//                 ->find();
    }

}
