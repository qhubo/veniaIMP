<?php

class prestamoActions extends sfActions {


    
        public function executeReporte(sfWebRequest $request) {
           
        date_default_timezone_set("America/Guatemala");
        $Id=1;
         $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = $EmpresaQuery->getNombre();
       
        
        
          $sql = "select year(fecha_inicio) as Years from prestamo_detalle where prestamo_id='" . $Id . "'  group by year(fecha_inicio) order by fecha_inicio desc";
        $con = Propel::getConnection();
        $stmt = $con->prepare($sql);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->result = $result;
        $this->id = $Id;
        $this->prestamo = PrestamoQuery::create()->findOneById($Id);
        $this->dias = $this->prestamo->getDias(date('Y-m-d'));

        $this->sele = 0;
        $data = null;
        foreach ($result as $line) {
            $anio = $line['Years'];
            $detalle = PrestamoDetalleQuery::create()
                    ->where("Year(PrestamoDetalle.FechaInicio) =" . $anio)
                    ->orderByFechaFin("Asc")
                    ->filterByPrestamoId($Id)
                    ->find();
            $data[$anio] = $detalle;
            $pestanas[] = $anio;
        }
        $this->data = $data;
        
        
        $filename = "Reporte Prestamo _" . $nombreempresa . date("d_m_Y");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $conta=0;
        foreach ($result as $vende) { 
        $hoja = $xl->setActiveSheetIndex($conta);
        $conta++;
          $anio = $vende['Years']; 
        //CABECERA  Y FILTRO
        $hoja->getRowDimension('1')->setRowHeight(15);
        $hoja->getRowDimension('2')->setRowHeight(20);
        $hoja->mergeCells("A1:A2");
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit(strtoupper($anio), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(13);
        // $hoja->getStyle("B1")->applyFromArray($styleArray);
        $hoja->getCell("C1")->setValueExplicit("Reporte de prestamo al " . date('d/m/Y'), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C1")->getFont()->setBold(true);
        $hoja->getStyle("C1")->getFont()->setSize(10);
        $fila = 3;
        $columna = 0;
        $encabezados = null;        
        $encabezados[] = array("Nombre" => strtoupper("#"), "width" => 7, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Tipo"), "width" => 22, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Valor"), "width" => 20, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Inicio"), "width" => 15, "align" => "center", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Fin"), "width" => 15, "align" => "center", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Dias"), "width" => 9, "align" => "center", "format" => "###0");
        $encabezados[] = array("Nombre" => strtoupper("Dolares"), "width" => 20, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Tasa Cambio"), "width" => 20, "align" => "rigth", "format" => "#,##0.0000000");
        $encabezados[] = array("Nombre" => strtoupper("Quetzales"), "width" => 20, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Creacion"), "width" =>24, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Usuario"), "width" => 22, "align" => "rigth", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
      
        
      
        $detalle = $data[$anio];
        foreach ($detalle as $regi) {
            $fila++;
             $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $regi->getId());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regi->getTipo());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $regi->getValor());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regi->getFechaInicio('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regi->getFechaFin('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $regi->getDias());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" =>$regi->getValorDolares());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" =>$regi->getTasaCambio());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" =>  $regi->getValorQuetzales());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $regi->getCreatedAt());  // ENTERO          
            $datos[] = array("tipo" => 3, "valor" => $regi->getCreatedBy());
            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;

        }
        
        
        $hoja = $xl->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }
    
    
    
    public function executeEliminaPagp(sfWebRequest $request) {

        $Id = $request->getParameter('id');
        $prestamoDe = PrestamoDetalleQuery::create()->findOneById($Id);
        $Prestamoid = $prestamoDe->getPrestamoId();
        if (!$prestamoDe) {
            $this->redirect('inicio/index');
        }
        $partidaNo = $prestamoDe->getPartidaNo();
        $partidaDella = PartidaDetalleQuery::create()
                ->filterByPartidaId($partidaNo)
                ->find();
        if ($partidaDella) {
            $partidaDella->delete();
        }

        $parttidaQ = PartidaQuery::create()->findOneById($partidaNo);
        if ($parttidaQ) {
            $parttidaQ->delete();
        }

        $movid = $prestamoDe->getMovimientoBancoId();
        $prestamoDe->setMovimientoBancoId(null);
        $prestamoDe->save();
        $MovimientoBanco = MovimientoBancoQuery::create()->findOneById($movid);

        if ($MovimientoBanco) {
            $MovimientoBanco->delete();
        }
        $prestamoDe->delete();
        $this->getUser()->setFlash('exito', 'Partida eliminado con exito');
        $this->redirect('prestamo/pago?id=' . $Prestamoid);
    }

    public function PartidaCalculoInteres($prestmoDetalle) {


//        echo "<pre>";
//        print_r($prestmoDetalle);
//        die();
//        
        $lista = null;

        if ($prestmoDetalle->getTipo() == "PAGO INTERES") {
            $cuentaHaber = CuentaErpContableQuery::create()->findOneByCuentaContable('7001-08');
            $cuentaDebe = CuentaErpContableQuery::create()->findOneByCuentaContable($prestmoDetalle->getBanco()->getCuentaContable());
            $data = null;
            $data['cuenta'] = $cuentaHaber->getCuentaContable();
            $data['detalle'] = $cuentaHaber->getNombre();
            $data['debe'] = round($prestmoDetalle->getValorQuetzales(), 2);
            $data['haber'] = 0;
            $lista[] = $data;
            $data = null;
            $data['cuenta'] = $cuentaDebe->getCuentaContable();
            $data['detalle'] = $cuentaDebe->getNombre();
            $data['debe'] = 0;
            $data['haber'] = round($prestmoDetalle->getValorQuetzales(), 2);
            $lista[] = $data;
        }

        if ($prestmoDetalle->getTipo() == "PAGO CAPITAL") {
            $cuentaHaber = CuentaErpContableQuery::create()->findOneByCuentaContable('2019-08');
            $cuentaDebe = CuentaErpContableQuery::create()->findOneByCuentaContable($prestmoDetalle->getBanco()->getCuentaContable());
            $data = null;
            $data['cuenta'] = $cuentaHaber->getCuentaContable();
            $data['detalle'] = $cuentaHaber->getNombre();
            $data['debe'] = round($prestmoDetalle->getValorQuetzales(), 2);
            $data['haber'] = 0;
            $lista[] = $data;
            $data = null;
            $data['cuenta'] = $cuentaDebe->getCuentaContable();
            $data['detalle'] = $cuentaDebe->getNombre();
            $data['debe'] = 0;
            $data['haber'] = round($prestmoDetalle->getValorQuetzales(), 2);
            $lista[] = $data;
        }

             if ($prestmoDetalle->getTipo() == "INGRESO PRESTAMO") {
            $cuentaDebe = CuentaErpContableQuery::create()->findOneByCuentaContable('2019-08');
            $cuentaHaber = CuentaErpContableQuery::create()->findOneByCuentaContable($prestmoDetalle->getBanco()->getCuentaContable());
            $data = null;
            $data['cuenta'] = $cuentaHaber->getCuentaContable();
            $data['detalle'] = $cuentaHaber->getNombre();
            $data['debe'] = round($prestmoDetalle->getValorQuetzales(), 2);
            $data['haber'] = 0;
            $lista[] = $data;
            $data = null;
            $data['cuenta'] = $cuentaDebe->getCuentaContable();
            $data['detalle'] = $cuentaDebe->getNombre();
            $data['debe'] = 0;
            $data['haber'] = round($prestmoDetalle->getValorQuetzales(), 2);
            $lista[] = $data;
        }  
        
        
        if ($prestmoDetalle->getTipo() == "AJUSTE DIFERENCIAL") {
            $cuentaHaber = CuentaErpContableQuery::create()->findOneByCuentaContable('6999-08');
            $cuentaDebe = CuentaErpContableQuery::create()->findOneByCuentaContable('2019-08');
            $data = null;
            $data['cuenta'] = $cuentaHaber->getCuentaContable();
            $data['detalle'] = $cuentaHaber->getNombre();
            $data['debe'] = round($prestmoDetalle->getValorQuetzales(), 2);
            $data['haber'] = 0;
            $lista[] = $data;
            $data = null;
            $data['cuenta'] = $cuentaDebe->getCuentaContable();
            $data['detalle'] = $cuentaDebe->getNombre();
            $data['debe'] = 0;
            $data['haber'] = round($prestmoDetalle->getValorQuetzales(), 2);
            $lista[] = $data;
        }




        if ($prestmoDetalle->getTipo() == "CALCULO INTERES") {
            $ceuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable('7001-08');
            $ceuentDi = CuentaErpContableQuery::create()->findOneByCuentaContable('2020-08');
            $data = null;
            $data['cuenta'] = $ceuentaQ->getCuentaContable();
            $data['detalle'] = $ceuentaQ->getNombre();
            $data['debe'] = round($prestmoDetalle->getValorQuetzales(), 2);
            $data['haber'] = 0;
            $lista[] = $data;
            $data = null;
            $data['cuenta'] = $ceuentDi->getCuentaContable();
            $data['detalle'] = $ceuentDi->getNombre();
            $data['debe'] = 0;
            $data['haber'] = round($prestmoDetalle->getValorQuetzales(), 2);
            $lista[] = $data;
        }
        return $lista;
    }

    public function executePartida(sfWebRequest $request) {
 
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $id = $request->getParameter('id');
        $this->id = $id;
        $prestmoDetalle = PrestamoDetalleQuery::create()->findOneById($id);
        $this->prestmoDetalle = $prestmoDetalle;
        $this->listaInteres = json_decode($prestmoDetalle->getDetalleInteres(), true);
        //    $this->listaInteres= serialize($this->listaInteres);
//        echo "<pre>";
//        print_r($detalle);
//        die();
        $lista = $this->PartidaCalculoInteres($prestmoDetalle);
        $this->partidaDetalle = $lista;
        $this->cuentasUno = CuentaErpContableQuery::create()->find();
        $this->cuentasDos = CuentaErpContableQuery::create()->find();
        $defaulta['fecha'] = $prestmoDetalle->getFechaFin('d/m/Y');
        $defaulta['detalle'] = "PRESTAMOS  " . $prestmoDetalle->getTipo() . " " . $prestmoDetalle->getValorQuetzales() . "  " . $prestmoDetalle->getFechaFin('d/m/Y');
        $defaulta['numero'] = 'PRE' . $prestmoDetalle->getId();
        $this->form = new CreaPartidaActivoForm($defaulta);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();

                $numero = $valores['numero'];
                $fechaInicio = $valores['fecha'];
                $fechaInicio = explode('/', $fechaInicio);
                $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
                $partida = PartidaQuery::create()->findOneByCodigo($numero);
                if (!$partida) {
                    $partida = new Partida();
                }
                $partida->setEstatus('Confirmado');
                $partida->setFechaContable($fechaInicio);
                $partida->setTipo($valores['detalle']);
                $partida->setCodigo($numero);
                $partida->setNumero($numero);
                $partida->setUsuario($usuarioQ->getUsuario());

                $partida->save();

                $total = 0;
                $cont = 0;
                if ($partida) {
                    $partidaDetlle = PartidaDetalleQuery::create()->filterByPartidaId($partida->getId())->find();
                    if ($partidaDetlle) {
                        $partidaDetlle->delete();
                    }
                }

                foreach ($this->partidaDetalle as $reg) {
                    $cont++;

                    $cuentaId = $request->getParameter('cuenta' . $cont);
                    $debe = $reg['debe'];
                    $haber = $reg['haber'];
                    $total = $debe + $total;
                    $cuentaEr = CuentaErpContableQuery::create()->findOneByCuentaContable($cuentaId);

                    $paridaDe = new PartidaDetalle();
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

                $prestmoDetalle->setPartidaNo($partida->getId());
                $prestmoDetalle->save();
                $MovimieBan = MovimientoBancoQuery::create()->findOneById($prestmoDetalle->getMovimientoBancoId());
                if ($MovimieBan) {
                    $MovimieBan->setPartidaNo($partida->getId());
                    $MovimieBan->save();
                }
                $this->getUser()->setFlash('exito', 'Partida cerrada con exito ');
                $this->redirect('prestamo/pago?id=' . $prestmoDetalle->getPrestamoId());
            }
        }
    }

    public function executeTasa(sfWebRequest $request) {

        $Id = $request->getParameter('id');
        $valor = $request->getParameter('valor');
        $valor = explode("/", $valor);
        $fecha = $valor[2] . "-" . $valor[1] . "-" . $valor[0];
        $tasa = 0;
        $tasaQ = TasaCambioQuery::create()->findOneByFecha($fecha);
        if (!$tasaQ) {
            $tasaQ = TasaCambioQuery::create()
                    ->where("TasaCambio.Fecha < '" . $fecha . "'")
                    ->findOne();
        }
        if ($tasaQ) {
            $tasa = $tasaQ->getValor();
        }
        echo $tasa;
        die();
    }

    public function executeTipo(sfWebRequest $request) {
         
        $tipo = $request->getParameter('tipo');
        $valor = '';
        if ($tipo == "CALCULO INTERES") {
            $Id = $request->getParameter('id');
            $valor = $request->getParameter('valor');
            $tasa = $request->getParameter('tasa');
            $valor = explode("/", $valor);
            $fecha = $valor[2] . "-" . $valor[1] . "-" . $valor[0];
            $valor = $request->getParameter('fecha_inicio');
            $valor = explode("/", $valor);
            $fechaInici = $valor[2] . "-" . $valor[1] . "-" . $valor[0];
            $prestamoQure = PrestamoQuery::create()->findOneById($Id);
            $valor = $prestamoQure->getCalculoInteres($fechaInici, $fecha);
            sfContext::getInstance()->getUser()->setAttribute('usuario', $fechaInici, 'presta_inicio');
            sfContext::getInstance()->getUser()->setAttribute('usuario', $fecha, 'presta_fin');
            if ($tasa > 0) {
                $valor = $tasa * $valor;
                $valor = round($valor, 2);
            }
        }
        echo $valor;
        die();
    }

    public function executeTasado(sfWebRequest $request) {

        $valor = $request->getParameter('valor');
        $tasa = $request->getParameter('tasa');
        $vquetzales = $valor / $tasa;
        $vquetzales = round($vquetzales, 2);
        echo $vquetzales;
        die();
    }

    public function executeTasaque(sfWebRequest $request) {
        $valor = $request->getParameter('valor');
        $tasa = $request->getParameter('tasa');
        $vquetzales = $valor * $tasa;
        $vquetzales = round($vquetzales, 2);
        echo $vquetzales;
        die();
    }

    public function executeInteres(sfWebRequest $request) {
       
        $Id = $request->getParameter('id');
        $valor = $request->getParameter('valor');
        $tipo = $request->getParameter('tipo');
        $tasa = $request->getParameter('tasa');
        $valor = explode("/", $valor);
        $fecha = $valor[2] . "-" . $valor[1] . "-" . $valor[0];
        $valor = $request->getParameter('fecha_inicio');
        $valor = explode("/", $valor);
        $fechaInici = $valor[2] . "-" . $valor[1] . "-" . $valor[0];
        $prestamoQure = PrestamoQuery::create()->findOneById($Id);
        $valor = $prestamoQure->getCalculoInteres($fechaInici, $fecha);
        sfContext::getInstance()->getUser()->setAttribute('usuario', $fechaInici, 'presta_inicio');
        sfContext::getInstance()->getUser()->setAttribute('usuario', $fecha, 'presta_fin');

        if ($tipo == 2) {
            $valor = $valor * $tasa;
            $valor = round($valor, 2);
        }


        echo $valor;
        die();
    }

    public function MovimientoBanco($prestaModetalle) {

        $movimiento = New MovimientoBanco();  // ok
        $movimiento->setTipoMovimiento("PRESTAMO" . $prestaModetalle->getTipo());
        $movimiento->setTipo('PRESTAMO');
        $movimiento->setBancoId($prestaModetalle->getBancoId());
        $movimiento->setValor($prestaModetalle->getValorQuetzales() * -1);
        $movimiento->setBancoOrigen($prestaModetalle->getBancoId());
        $movimiento->setDocumento($prestaModetalle->getId());
        $movimiento->setFechaDocumento($prestaModetalle->getFechaFin('Y-m-d'));
        $movimiento->setObservaciones($prestaModetalle->getComentario());
        $movimiento->setEstatus("Confirmado");
        $movimiento->setUsuario($prestaModetalle->getCreatedAt());
        $movimiento->setCreatedAt(date('Y-m-d H:i:s'));
        $movimiento->save();

        return $movimiento->getId();
    }

    
        public function MovimientoBancoiNGRESO($prestaModetalle) {

        $movimiento = New MovimientoBanco();  //ok
        $movimiento->setTipoMovimiento("PRESTAMO" . $prestaModetalle->getTipo());
        $movimiento->setTipo('PRESTAMO');
        $movimiento->setBancoId($prestaModetalle->getBancoId());
        $movimiento->setValor($prestaModetalle->getValorQuetzales() );
        $movimiento->setBancoOrigen($prestaModetalle->getBancoId());
        $movimiento->setDocumento($prestaModetalle->getId());
        $movimiento->setFechaDocumento($prestaModetalle->getFechaFin('Y-m-d'));
        $movimiento->setObservaciones($prestaModetalle->getComentario());
        $movimiento->setEstatus("Confirmado");
        $movimiento->setUsuario($prestaModetalle->getCreatedAt());
        $movimiento->setCreatedAt(date('Y-m-d H:i:s'));
        $movimiento->save();

        return $movimiento->getId();
    }
    public function executeDias(sfWebRequest $request) {
              error_reporting(-1);
        $Id = $request->getParameter('id');
        $valor = $request->getParameter('valor');
        $valor = explode("/", $valor);
        $fecha = $valor[2] . "-" . $valor[1] . "-" . $valor[0];
        $prestamoQure = PrestamoQuery::create()->findOneById($Id);

        $dias = $prestamoQure->getDias($fecha);
        echo $dias;
        die();
    }

    public function executePago(sfWebRequest $request) {
      
              error_reporting(-1);
               
        date_default_timezone_set("America/Guatemala");
        $Id = $request->getParameter('id');
        $Idv = $request->getParameter('idv');
        $this->Idv = $Idv;
        $prestamoDetalle = PrestamoDetalleQuery::create()->findOneById($Idv);
        $this->prestamoDetalle = $prestamoDetalle;
        if ($prestamoDetalle) {
            $Id = $prestamoDetalle->getPrestamoId();
        }

        $this->fecha = date('d/m/Y');
        if ($request->getParameter('fecha')) {
            $this->fecha = $request->getParameter('fecha');
        }
        $fechaFin = explode('/', $this->fecha);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $this->dia = $fechaFin;
        $proceso = TasaCambio::Tasas();
        $tasaQ = TasaCambioQuery::create()->findOneByFecha($this->dia);
        if (!$tasaQ) {
            $tasaQ = TasaCambioQuery::create()
                    ->where("TasaCambio.Fecha < '" . $this->dia . "'")
                    ->findOne();
        }
        if ($tasaQ) {
            $this->tasa = $tasaQ->getValor();
        }
        

        $sql = "select year(fecha_inicio) as Years from prestamo_detalle where prestamo_id='" . $Id . "'  group by year(fecha_inicio) order by fecha_inicio desc";
        $con = Propel::getConnection();
        $stmt = $con->prepare($sql);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->result = $result;
        $this->id = $Id;
        $this->prestamo = PrestamoQuery::create()->findOneById($Id);
        $this->dias = $this->prestamo->getDias(date('Y-m-d'));

        $this->sele = 0;
        $data = null;
        foreach ($result as $line) {
            $anio = $line['Years'];
            $detalle = PrestamoDetalleQuery::create()
                    ->where("Year(PrestamoDetalle.FechaInicio) =" . $anio)
                    ->orderByFechaFin("Asc")
                    ->filterByPrestamoId($Id)
                    ->find();
            $data[$anio] = $detalle;
        }
        $this->data = $data;
        $default['fecha_inicio'] = $this->prestamo->getFechaUlticalculo();
        $default['fecha'] = date('d/m/Y');
        $valFecha = explode("/", $default['fecha_inicio']);
        $fechaInicio = $valFecha[2] . "-" . $valFecha[1] . "-" . $valFecha[0];
        sfContext::getInstance()->getUser()->setAttribute('usuario', $fechaInicio, 'presta_inicio');
        sfContext::getInstance()->getUser()->setAttribute('usuario', date('Y-m-d'), 'presta_fin');

        $interes = $this->prestamo->getCalculoInteres($fechaInicio, date('Y-m-d'));
        $this->interes = $interes;
        $this->quetzales = round(($interes * $this->tasa), 2);

        $default['valor_dolares'] = $interes;

        $default['valor_quetzales'] = round(($interes * $this->tasa), 2);
        $this->form = new CreaPagoPrestamoForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();

                $valor = explode("/", $valores['fecha']);
                $fecha = $valor[2] . "-" . $valor[1] . "-" . $valor[0];

                $valor = explode("/", $valores['fecha_inicio']);
                $fechaInicio = $valor[2] . "-" . $valor[1] . "-" . $valor[0];

                $dias = $this->prestamo->getDias($fecha);
                $tasa = $request->getPostParameter('tasacambio');
                $valorActual = $this->prestamo->getValorActual();
                $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
                $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
                $prestamoDetalle = new PrestamoDetalle();
                $prestamoDetalle->setValor($valorActual);
                $prestamoDetalle->setPrestamoId($Id);
                $prestamoDetalle->setComentario($valores['comentario']);
                $prestamoDetalle->setFechaInicio($fechaInicio);
                $prestamoDetalle->setFechaFin($fecha);
                $prestamoDetalle->setDias($dias);
                $prestamoDetalle->setValorDolares($valores['valor_dolares']);
                $valorQ = $valores['valor_dolares'] * $tasa;
                $valorQ = round($valorQ, 2);
                $prestamoDetalle->setValorQuetzales($valorQ);
                if ($valores['tipo'] == "PAGO INTERES") {
                    $prestamoDetalle->setFechaInicio($fecha);
                    $prestamoDetalle->setBancoId($valores['banco_id']);
                    $prestamoDetalle->setDias(0);
                    $movid = $this->MovimientoBanco($prestamoDetalle);
                    $prestamoDetalle->setMovimientoBancoId($movid);
                }

                if ($valores['tipo'] == "AJUSTE DIFERENCIAL") {
                    $prestamoDetalle->setFechaInicio($fecha);
//                 $prestamoDetalle->setBancoId($valores['banco_id']);
                    $prestamoDetalle->setDias(0);
                    $prestamoDetalle->setMovimientoBancoId($movid);
                }
                if ($valores['tipo'] == "PAGO CAPITAL") {
                    $prestamoDetalle->setFechaInicio($fecha);
                    $prestamoDetalle->setBancoId($valores['banco_id']);
                    $valoRActual = $valorActual - $valores['valor_dolares'];

                    $prestamoDetalle->setValor($valoRActual);
                    $prestamoDetalle->setDias(0);
                    $movid = $this->MovimientoBanco($prestamoDetalle);
                    $prestamoDetalle->setMovimientoBancoId($movid);
                }
                
                
                 if ($valores['tipo'] == "INGRESO PRESTAMO") {
                    $prestamoDetalle->setFechaInicio($fecha);
                    $prestamoDetalle->setBancoId($valores['banco_id']);
                    $valoRActual = $valorActual + $valores['valor_dolares'];

                    $prestamoDetalle->setValor($valoRActual);
                    $prestamoDetalle->setDias(0);
                    $movid = $this->MovimientoBancoiNGRESO($prestamoDetalle);
                    $prestamoDetalle->setMovimientoBancoId($movid);
                }
                
                

                if ($valores['tipo'] == "CALCULO INTERES") {

                    $prestaQ = $prestamoDetalle->getPrestamo();
                    $lista = $prestaQ->getDetalleInteres($prestamoDetalle->getFechaInicio(), $prestamoDetalle->getFechaFin());
                    $jsonData = json_encode($lista);
                    $prestamoDetalle->setDetalleInteres($jsonData);
                }
                $prestamoDetalle->setTasaCambio($tasa);

                $prestamoDetalle->setTipo($valores['tipo']);

                $prestamoDetalle->setCreatedAt(date('Y-m-d H:i:s'));
                $prestamoDetalle->setCreatedBy($usuarioQ->getUsuario());
                $prestamoDetalle->save();

                $this->getUser()->setFlash('exito', 'Registro de ' . $prestamoDetalle->getTipo() . ' realizado con exito ');
                $this->redirect('prestamo/pago?idv=' . $prestamoDetalle->getId());
            }
        }
        $maXq = PrestamoDetalleQuery::create()
                ->filterByPrestamoId($Id)
                ->orderById("Desc")
                ->findOne();
      $this->ultimo =0;
        if ($maXq) {
        $this->ultimo = $maXq->getId();
       }
        if ($prestamoDetalle) {
            $prestmoDetalle = PrestamoDetalleQuery::create()->findOneById($Idv);
            $ceuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable('7001-08');
            $ceuentDi = CuentaErpContableQuery::create()->findOneByCuentaContable('2020-01');

            $lista = $this->PartidaCalculoInteres($prestmoDetalle);

            $this->partidaDetalle = $lista;
            $this->cuentasUno = CuentaErpContableQuery::create()->find();
            $this->cuentasDos = CuentaErpContableQuery::create()->find();
            $defaulta['fecha'] = $prestmoDetalle->getFechaFin('d/m/Y');

            $defaulta['detalle'] = "PRESTAMOS  " . $prestmoDetalle->getTipo() . " " . $prestmoDetalle->getValorQuetzales() . "  " . $prestmoDetalle->getFechaFin('d/m/Y');
            $defaulta['numero'] = 'PRE' . $prestmoDetalle->getId();

            $this->forma = new CreaPartidaActivoForm($defaulta);
        }
    }

    public function executeIndex(sfWebRequest $request) {
              error_reporting(-1);
        $this->titulo = "PRESTAMOS";
        $this->registros = PrestamoQuery::create()->find();
    }

    public function executeMuestra(sfWebRequest $request) {
              error_reporting(-1);
        $modulo = 'prestamo';
        $this->titulo = 'BANCO';
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('usuario', null, 'nivel');
        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $default = null;
        $registro = PrestamoQuery::create()->findOneById($Id);
        $default['activo'] = true;
        if ($registro) {
            $default['nombre'] = $registro->getNombre();
            $default['observaciones'] = $registro->getObservaciones();
            $default['valor'] = $registro->getValor();
            $default['fecha_inicio'] = $registro->getFechaInicio('d/m/Y');
            $default['moneda'] = $registro->getMoneda();
            $default['tasa_interes'] = $registro->getTasaInteres();
        }
        $this->registro = $registro;
        $this->form = new CreaPrestamoForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($valores);
//                die();
                $nuevo = new Prestamo();
                if ($registro) {
                    $nuevo = $registro;
                }
                $fechaInicio = $valores['fecha_inicio'];
                $fechaInicio = explode('/', $fechaInicio);
                $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
                $nuevo->setFechaInicio($fechaInicio);
                $nuevo->setNombre($valores['nombre']);
                $nuevo->setObservaciones($valores['observaciones']);
                $nuevo->setValor($valores['valor']);
                $nuevo->setMoneda($valores['moneda']);
                $nuevo->setTasaInteres($valores['tasa_interes']);
                $nuevo->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect($modulo . '/muestra?id=' . $nuevo->getId());
            }
        }
    }

    public function executeLista(sfWebRequest $request) {

        $prestamoId = 1;
        $fechaInico = '2023-06-24';
        $fechaFin = '2023-06-28';

        $fechaInico = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'presta_inicio');
        $fechaFin = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'presta_fin');

        $prestaQ = PrestamoQuery::create()->findOne();
        $lista = $prestaQ->getDetalleInteres($fechaInico, $fechaFin);
        $jsonData = json_encode($lista);
        $this->inicio = $fechaInico;
        $this->fin = $fechaFin;

        $this->lista = $lista;
    }

}
