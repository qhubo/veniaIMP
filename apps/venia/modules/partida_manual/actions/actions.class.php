<?php

/**
 * partida_manual actions.
 *
 * @package    plan
 * @subpackage partida_manual
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class partida_manualActions extends sfActions {

    public function executeCarga(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $this->getResponse()->setContentType('charset=utf-8');
        $id = $request->getParameter('id');
        $this->id = $id;
        $datos = CuentaErp::pobladatosPartida($id);
        if (!$datos['valido']) {
            $texto = $datos['pendiente'];
            $textol = implode(' , ', $texto);
            $this->getUser()->setFlash('error', 'Las siguiente columnas no fueron encontradas: ' . $textol);
            $this->redirect('partida_manual/index');
        }
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $pendiente = PartidaQuery::create()
                ->filterByEstatus('Proceso')
                ->filterByUsuario($usuarioQ->getUsuario())
                ->findOne();

        if ($pendiente) {
            $partidaDella = PartidaDetalleQuery::create()
                    ->filterByPartidaId($pendiente->getId())
                    ->find();
            if ($partidaDella) {
                $partidaDella->delete();
            }
        }
        $cont = 0;
        foreach ($datos['datos'] as $reg) {
            $fecha = $reg['FECHA'];
//            die();
//            $fecha = date("Y-m-d", strtotime($reg['FECHA']));
            $cont++;
            if ($cont == 1) {
                if (!$pendiente) {
                    $pendiente = new Partida();
                    $pendiente->setEstatus('Proceso');

                    $pendiente->setCodigo('Manual');
                    $pendiente->setUsuario($usuarioQ->getUsuario());
                    $pendiente->save();
                }
            }
            $pendiente->setFechaContable($fecha);
            $pendiente->setCodigo($reg['ASIENTO']);
            $pendiente->setTipo($reg['DOCUMENTO']);
            $pendiente->save();
            $cuentaQ = CuentaErpContableQuery::create()->findOneById($reg['ID']);
            $cuenta = $cuentaQ->getCuentaContable();
            $nombreCuenta = $cuentaQ->getNombre();
            $partidaNe = new PartidaDetalle();
            $partidaNe->setPartidaId($pendiente->getId());
            $partidaNe->setCuentaContable($cuenta);
            $partidaNe->setDetalle($nombreCuenta);
            $partidaNe->setDebe(0);
            $partidaNe->setHaber(0);
            if ($reg['DEBE']) {
                $partidaNe->setDebe(round($reg['DEBE'], 2));
            }
            if ($reg['HABER']) {
                $partidaNe->setHaber(round($reg['HABER'], 2));
            }
            $partidaNe->save();
        }
              $Partidas = PartidaDetalleQuery::create()
                        ->filterByPartidaId($pendiente->getId())
                        ->withColumn('sum(PartidaDetalle.Debe)', 'ValorTotal')
                        ->findOne();
            
                if ($Partidas) {
                    $pendiente->setValor($Partidas->getValorTotal());
                    $pendiente->save();
                }

                
        $this->redirect('partida_manual/index?carga=1');
        //   die();
    }

    public function executeReporte(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $nombreempresa = "Modelo";
        $nombreEMpresa = 'Venialink';
        $pestanas[] = 'Carga';
        $nombre = "Modelo";

        $filename = "Archivo_Carga_Partida_" . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("TIPO DE ARCHIVO ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->mergeCells("A1:B1");
        $hoja->getCell("C1")->setValueExplicit("Archivo carga partida " . strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("C1:E1");
        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');
        $encabezados[] = array("Nombre" => 'fecha', "width" => 15, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'cuenta', "width" => 35, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'documento', "width" => 30, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'descripcion', "width" => 30, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'debe', "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'haber', "width" => 15, "align" => "left", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $hoja->getStyle('A2:F2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('006600');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        //          die();
        $xl->save('php://output');
        die();
        throw new sfStopException();
    }

    public function executeElimina(sfWebRequest $request) {
        $edit = $request->getParameter('edit');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $defaulta['fecha'] = date('d/m/Y');
        $numero = $request->getParameter('no');
      
//        $pendiente = PartidaQuery::create()
//                ->filterByEstatus('Proceso')
//                ->filterByUsuario($usuarioQ->getUsuario())
//                ->findOne();
//        if ($pendiente) {
//            $numero = $pendiente->getId();
//        }
        $partidaDetalle = PartidaDetalleQuery::create()
                ->filterById($edit)
              //  ->filterByPartidaId($numero)
                ->findOne();
        if ($partidaDetalle) {
            $numero= $partidaDetalle->getPartidaId();
            $this->getUser()->setFlash('error', 'Detalle de partida eliminada con exito');
            $partidaDetalle->delete();
        }

        $Partidas = PartidaDetalleQuery::create()
                ->filterByPartidaId($numero)
                ->withColumn('sum(PartidaDetalle.Haber)', 'TotalHaber')
                ->withColumn('sum(PartidaDetalle.Debe)', 'TotalDebe')
                ->findOne();
        if ($Partidas) {
            $totalDebe = $Partidas->getTotalDebe();
            $totalHaber = $Partidas->getTotalHaber();
        }

        if ($pendiente) {
            $pendiente->setValor($totalDebe);
            $pendiente->save();
        }
        $this->redirect('partida_manual/index?no='.$numero);
    }

    public function executeValor(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $numero = $request->getParameter('numero');
        $valor = $request->getParameter('valor');
        $tipo = $request->getParameter('tipo');
        $edit = $request->getParameter('edit');
        $totalDebe = 0;
        $totalHaber = 0;
        $retorna = 0;

        $Partidas = PartidaDetalleQuery::create()
                ->filterById($edit, Criteria::NOT_EQUAL)
                ->filterByPartidaId($numero)
                ->withColumn('sum(PartidaDetalle.Haber)', 'TotalHaber')
                ->withColumn('sum(PartidaDetalle.Debe)', 'TotalDebe')
                ->findOne();
        if ($Partidas) {
            $totalDebe = $Partidas->getTotalDebe();
            $totalHaber = $Partidas->getTotalHaber();
        }

        if ($tipo == 1) {
            $retorna = $valor + $totalDebe;
        }
        if ($tipo == 2) {
            $retorna = $valor + $totalHaber;
        }
        $retorna = '<font size="+1"><strong>' . Parametro::formato($retorna) . '</strong></font>';

        echo $retorna;
        die();
    }

    public function executeConfirmar(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $PartidaQ = PartidaQuery::create()->findOneById($id);

        if ($PartidaQ) {
            $tokenGuardado = sha1($PartidaQ->getId());
            if ($token == $tokenGuardado) {
                $Partidas = PartidaDetalleQuery::create()
                        ->filterByPartidaId($PartidaQ->getId())
                        ->withColumn('sum(PartidaDetalle.Haber)', 'TotalHaber')
                        ->withColumn('sum(PartidaDetalle.Debe)', 'TotalDebe')
                        ->findOne();
                $totalDebe = round($Partidas->getTotalDebe(),2);
                $totalHaber = round($Partidas->getTotalHaber(),2);
                $diferencaia = $totalDebe - $totalHaber;
//                if ($totalDebe <> $totalHaber) {
//                    $this->getUser()->setFlash('error', 'Valores de partida no son correctos diferencia ' . $diferencaia);
//
//                    $this->redirect('partida_manual/index');
//                }
                $PartidaQ->setConfirmada(true);
                $PartidaQ->setEstatus('Cerrada');
                $PartidaQ->save();
                $this->getUser()->setFlash('exito', 'Partida cerrada con exito');
            }
        }
        $this->redirect('partida_manual/index');
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $defaulta['fecha'] = date('d/m/Y');
        $numero = $request->getParameter('no');
       
        $ven = $request->getParameter('ven');
        $VENTARESUMI = VentaResumidaLineaQuery::create()->findOneById($ven);
                if ($VENTARESUMI) {
             $partida = PartidaQuery::create()
                ->filterByEstatus('Proceso')
                ->filterByUsuario($usuarioQ->getUsuario())
                ->findOne();
             if ($partida) {
            $partidaDe = PartidaDetalleQuery::create()
                    ->filterByPartidaId($partida->getId())
                    ->count();
//            echo $partidaDe;
//            die();
            if ($partidaDe >0) {
                $partida->setEstatus("Cerrada");
                $partida->save();
                $partida=null;
            }
                 }
                }
        $edit = 0;
        if ($request->getParameter('edit')) {
            $edit = $request->getParameter('edit');
        }
        $this->edit = $edit;
        $parrtidaDetrlle = PartidaDetalleQuery::create()
                ->findOneById($edit);
        if ($parrtidaDetrlle) {
            $numero = $parrtidaDetrlle->getPartidaId();
        }
        
        $pendiente = PartidaQuery::create()->findOneById($numero);
        if (!$pendiente) {
        $pendiente = PartidaQuery::create()
                ->filterByEstatus('Proceso')
                ->filterByUsuario($usuarioQ->getUsuario())
                ->findOne();
        }
        if ($pendiente) {
            $numero = $pendiente->getId();
        }
        $partida = PartidaQuery::create()->findOneById($numero);
        if ($partida) {
            $defaulta['numero'] = $partida->getId();
            $defaulta['detalle'] = $partida->getTipo();
            $defaulta['fecha'] = $partida->getFechaContable('d/m/Y');
        }
        $partidaDetalle = PartidaDetalleQuery::create()
                ->filterById($edit)
               // ->filterByPartidaId($numero)
                ->findOne();
        $this->borra = 0;
        $this->valor1 = 0;
        $this->valor2 = 0;
        if ($partidaDetalle) {
            if ($partidaDetalle->getDebe() > 0) {
                $defaulta['cuenta_debe'] = $partidaDetalle->getCuentaContable();
                $defaulta['valor_debe'] = $partidaDetalle->getDebe();
                $this->borra = 1;
                $this->valor1 = $partidaDetalle->getDebe();
            }
            if ($partidaDetalle->getHaber() > 0) {
                $defaulta['cuenta_haber'] = $partidaDetalle->getCuentaContable();
                $defaulta['valor_haber'] = $partidaDetalle->getHaber();
                $this->borra = 2;
                $this->valor2 = $partidaDetalle->getHaber();
            }
        }

        
   
        if ($VENTARESUMI) {
             $partida = PartidaQuery::create()
                ->filterByEstatus('Proceso')
                ->filterByUsuario($usuarioQ->getUsuario())
                ->findOne();
             if ($partida) {
            $partidaDe = PartidaDetalleQuery::create()
                    ->filterByPartidaId($partida->getId())
                    ->count();
//            echo $partidaDe;
//            die();
            if ($partidaDe >0) {
                $partida->setEstatus("Cerrada");
                $partida->save();
                $partida=null;
            }
                 }
             
             if (!$partida) {
                 $partida = new Partida();
                 $partida->setEstatus("Proceso");
                 $partida->setUsuario($usuarioQ->getUsuario());
                 $partida->save();
             }
              $partida->setFechaContable($VENTARESUMI->getVentaResumida()->getFecha('Y-m-d'));
              $partida->setTipo($VENTARESUMI->getMedioPago()." ".$VENTARESUMI->getVentaResumida()->getObservaciones());
               $partida->setCodigo('Manual');
              $partida->setUsuario($VENTARESUMI->getVentaResumida()->getUsuario());
                $partida->save();
                
                $partidaLinea = PartidaDetalleQuery::create()
                        ->filterByPartidaId($partida->getId())
                        ->find();
                if ($partidaLinea) {
                    $partidaLinea->delete();
                }
                
                $defaulta['detalle']=$VENTARESUMI->getMedioPago()." ".$VENTARESUMI->getVentaResumida()->getObservaciones();
                $defaulta['fecha']=$VENTARESUMI->getVentaResumida()->getFecha('d/m/Y');
        $defaulta['valor_debe']=$VENTARESUMI->getVentaResumida()->getValorDeposito();
                $defaulta['valor_haber']=$VENTARESUMI->getVentaResumida()->getValorDeposito();
//                 $partidaNe = new PartidaDetalle();
//                        $partidaNe->setPartidaId($partida->getId());
////                        $partidaNe->setCuentaContable();
////                        $partidaNe->setDetalle();
//                        $partidaNe->setDebe($VENTARESUMI->getVentaResumida()->getValorDeposito());
//                        $partidaNe->setHaber(0);
//                        $partidaNe->save();
//                        
//                           $partidaNe = new PartidaDetalle();
//                        $partidaNe->setPartidaId($partida->getId());
////                        $partidaNe->setCuentaContable();
////                        $partidaNe->setDetalle();
//                        $partidaNe->setDebe(0);
//                        $partidaNe->setHaber($VENTARESUMI->getVentaResumida()->getValorDeposito());
//                        $partidaNe->save();
        }
        
//        
//        
//           $partida = PartidaQuery::create()->findOneById($numero);
//                if (!$partida) {
//                    $partida = new Partida();
//                    $partida->setEstatus('Proceso');
//                }
//                $partida->setFechaContable($fechaInicio);
//                $partida->setTipo($valores['detalle']);
//                $partida->setCodigo('Manual');
//                $partida->setUsuario($usuarioQ->getUsuario());
//                $partida->save();
//                
                
        $this->form = new CreaPartidaForm($defaulta);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($partidaDetalle);
//                echo "</pre>";
//
//                echo "<pre>";
//                print_r($valores);
//                die();
                $numero = $valores['numero'];
                $fechaInicio = $valores['fecha'];
                $fechaInicio = explode('/', $fechaInicio);
                $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
                $partida = PartidaQuery::create()->findOneById($numero);
                if (!$partida) {
                    $partida = new Partida();
                    $partida->setEstatus('Proceso');
                }
                $partida->setFechaContable($fechaInicio);
                $partida->setTipo($valores['detalle']);
                $partida->setCodigo('Manual');
                $partida->setUsuario($usuarioQ->getUsuario());
                $partida->save();

                if ($partidaDetalle) {
                    
                    if ($valores['cuenta_debe'] <> "") {
                     $cuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($valores['cuenta_debe']);
                        $cuenta = $cuentaQ->getCuentaContable();
                        $nombreCuenta = $cuentaQ->getNombre();
                        $partidaDetalle->setCuentaContable($valores['cuenta_debe']);
                        $parrtidaDetrlle->setDetalle($nombreCuenta);

                        }
                    if ($valores['cuenta_haber'] <> "") {
                           $cuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($valores['cuenta_haber']);
                        $cuenta = $cuentaQ->getCuentaContable();
                        $nombreCuenta = $cuentaQ->getNombre();
                        $partidaDetalle->setCuentaContable($valores['cuenta_haber']);
                        $parrtidaDetrlle->setDetalle($nombreCuenta);
                    }
                    $partidaDetalle->setDebe($valores['valor_debe']);
                    $partidaDetalle->setHaber($valores['valor_haber']);
                    $partidaDetalle->save();
                }

                if (!$partidaDetalle) {
                    if (($valores['cuenta_debe'] <> "") && ($valores['valor_debe'] > 0)) {
                        $cuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($valores['cuenta_debe']);
                        $cuenta = $cuentaQ->getCuentaContable();
                        $nombreCuenta = $cuentaQ->getNombre();
                        $partidaNe = new PartidaDetalle();
                        $partidaNe->setPartidaId($partida->getId());
                        $partidaNe->setCuentaContable($cuenta);
                        $partidaNe->setDetalle($nombreCuenta);
                        $partidaNe->setDebe($valores['valor_debe']);
                        $partidaNe->setHaber(0);
                        $partidaNe->save();
                    }
                    if (($valores['cuenta_haber'] <> "") && ($valores['valor_haber'] > 0)) {
                        $cuentaQ = CuentaErpContableQuery::create()->findOneByCuentaContable($valores['cuenta_haber']);
                        $cuenta = $cuentaQ->getCuentaContable();
                        $nombreCuenta = $cuentaQ->getNombre();
                        $partidaNe = new PartidaDetalle();
                        $partidaNe->setPartidaId($partida->getId());
                        $partidaNe->setCuentaContable($cuenta);
                        $partidaNe->setDetalle($nombreCuenta);
                        $partidaNe->setDebe(0);
                        $partidaNe->setHaber($valores['valor_haber']);
                        $partidaNe->save();
                    }
                }
                $Partidas = PartidaDetalleQuery::create()
                        ->filterByPartidaId($partida->getId())
                        ->withColumn('sum(PartidaDetalle.Debe)', 'ValorTotal')
                        ->findOne();
            
                if ($Partidas) {
                    $partida->setValor($Partidas->getValorTotal());
                    $partida->save();
                }
          

                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect('partida_manual/index?no=' . $partida->getId());
            }
        }
        $this->detalle = PartidaDetalleQuery::create()
                ->filterById($edit, Criteria::NOT_EQUAL)
                ->filterByPartidaId($numero)
                ->find();
//        echo $numero;
//        echo "<pre>";
//        print_r($this->detalle);
//        die();
        $this->partida = $partida;

        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $operaciones = PartidaQuery::create();
        $operaciones->filterByCodigo('Manual');
        //   $operaciones->filterByUsuario($usuarioQue->getUsuario());
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $this->operaciones = $operaciones->find();
        $this->no = $numero;

//        echo "<pre>";
//        print_r($this->operaciones);
//        die();
    }

}
