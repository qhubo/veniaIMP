<?php

/**
 * carga_gasto actions.
 *
 * @package    plan
 * @subpackage carga_gasto
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class carga_gastoActions extends sfActions {

    public function executeLimpia(sfWebRequest $request) {
//                     $this->getUser()->setFlash('error', ' ');
        sfContext::getInstance()->getUser()->setAttribute('seledatos', null, 'carga');
        $this->redirect('carga_gasto/index');
    }

    public function executeTest(sfWebRequest $request) {

// $VALORES=      $excento = false, $isr = false
        $valores = ParametroQuery::ObtenerIva('2500.02', false, true, false, '');
        echo "<pre>";
        print_r($valores);
        echo "</pre>";
        echo "<strong>PEQUEñO</strong>";
        $valores = ParametroQuery::ObtenerIva('2500.02', false, true, false, "PEQUEñO");
        echo "<pre>";
        print_r($valores);
        echo "</pre>";
        die();
    }

    public function partida($gastoCaja) {
        date_default_timezone_set("America/Guatemala");
        //     $gastoCaja = GastoCajaQuery::create()->findOne();
        $TOTALIVA = 0;
        $VALORtotal = 0;
        $partidaQ = new Partida();
        $partidaQ->setFechaContable($gastoCaja->getFecha('Y-m-d'));
        $partidaQ->setUsuario($gastoCaja->getUsuario());
        $partidaQ->setTipo('GastoCaja');
        $partidaQ->setCodigo($gastoCaja->getId());
        $partidaQ->setValor($gastoCaja->getValor());
        $partidaQ->setTiendaId($gastoCaja->getTiendaId());
        $partidaQ->save();
        //  cuenta del debe sumatoria        
        $movimientosele = GastoCajaDetalleQuery::create()
                ->filterByGastoCajaId($gastoCaja->getId())
                ->withColumn('sum(GastoCajaDetalle.Valor)', 'ValorTotal')
                ->withColumn('sum(GastoCajaDetalle.Iva)', 'ValorTotalIva')
                ->withColumn('sum(GastoCajaDetalle.ValorIdp)', 'ValorTotalIDP')
                ->groupByCuenta()
                ->find();

        foreach ($movimientosele as $registro) {
            $VALORtotal = $VALORtotal + ($registro->getValorTotal() - $registro->getValorTotalIva());
            $cuentaContable = $registro->getCuenta();
            $nombreCuenta = Partida::cuenta($cuentaContable);
            $valor = $registro->getValorTotal() - $registro->getValorTotalIva()-$registro->getValorTotalIDP();
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaQ->getId());
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            if ($valor < 0) {
                $partidaLinea->setDebe(0);
                $partidaLinea->setHaber($valor * -1);
            } else {
                $partidaLinea->setDebe($valor);
                $partidaLinea->setHaber(0);
            }
            $concepto = trim($registro->getDescripcion());
            $concepto = str_replace(" ", "", $concepto);
            $concepto = trim($concepto);
            $concepto = substr($concepto, 0, 50);
            $partidaLinea->setGrupo($concepto);
            $partidaLinea->save();
            
        }

        //  sumatoria iva debe
        $detalleIva = GastoCajaDetalleQuery::create()
                ->filterByGastoCajaId($gastoCaja->getId())
                ->withColumn('sum(GastoCajaDetalle.Iva)', 'ValorTotalIva')
                ->findOne();
        if ($detalleIva) {
            $TOTALIVA = $detalleIva->getValorTotalIva();
        }
        if ($TOTALIVA > 0) {
            $cuentaPartida = Partida::busca("IVA CREDITO", 0, 2);
            $cuentaContable = $cuentaPartida['cuenta'];
            $nombreCuenta = $cuentaPartida['nombre'];
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaQ->getId());
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setDebe($TOTALIVA);
            $partidaLinea->setHaber(0);
            $partidaLinea->setGrupo("IVA CREDITO");
            $partidaLinea->save();
        }
        $VALOR_ISR = 0;
        $VALOR_RETIENE_IVA = 0;
        $VALOR_SIN_ISR = 0;
        /// SUM RETENCION
        $detalleIva = GastoCajaDetalleQuery::create()
                ->filterByGastoCajaId($gastoCaja->getId())
                ->withColumn('sum(GastoCajaDetalle.ValorRetieneIva)', 'TotalRetieneIva')
                ->findOne();
        if ($detalleIva) {
            $VALOR_RETIENE_IVA = $detalleIva->getTotalRetieneIva();
        }
        if ($VALOR_RETIENE_IVA > 0) {
            ///  2031-08 VALOR_RETIENE_IVA
            $cuentaPartida = Partida::busca("RETENCIONES%DE%IVA", 0, 2);
            $cuentaContable = $cuentaPartida['cuenta'];
            $nombreCuenta = $cuentaPartida['nombre'];
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaQ->getId());
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setDebe(0);
            $partidaLinea->setHaber($VALOR_RETIENE_IVA);
            $partidaLinea->setGrupo("RETENCIONES DE IVA");
            //   $partidaLinea->setGrupo($concepto);
            $partidaLinea->save();
        }
        
        //  SUMA DE IDP
         /// SUM RETENCION
        $VALOR_IDP =0;
        $detalleIva = GastoCajaDetalleQuery::create()
                ->filterByGastoCajaId($gastoCaja->getId())
                ->withColumn('sum(GastoCajaDetalle.ValorIdp)', 'ValorTotalIDP')
                ->findOne();
        if ($detalleIva) {
            $VALOR_IDP =round( $detalleIva->getValorTotalIDP(),2);
        }
//        echo "<pre>";
//        print_r($detalleIva);
//        echo "</pre>";
//        
//        echo $VALOR_IDP;
//        die();
        
        if ($VALOR_IDP > 0) {
            ///  2031-08 VALOR_RETIENE_IVA
            $cuentaPartida = Partida::busca("IDP COMBUSTIBLE", 0, 2);
            $cuentaContable = $cuentaPartida['cuenta'];
            $nombreCuenta = $cuentaPartida['nombre'];
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaQ->getId());
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setDebe($VALOR_IDP);
            $partidaLinea->setHaber(0);
            $partidaLinea->setGrupo("IDP COMBUSTIBLE");
            //   $partidaLinea->setGrupo($concepto);
            $partidaLinea->save();
        }
        //FIN SUMA IDP
        
        
        // VALOR_ISR  2030-08
        $detalleIva = GastoCajaDetalleQuery::create()
                ->filterByGastoCajaId($gastoCaja->getId())
                ->withColumn('sum(GastoCajaDetalle.ValorIsr)', 'TotalIsr')
                ->findOne();
        if ($detalleIva) {
            $VALOR_ISR = $detalleIva->getTotalIsr();
        }
        if ($VALOR_ISR > 0) {
            $cuentaPartida = Partida::busca("RENTA%POR%PAGAR ", 0, 2);
            $cuentaContable = $cuentaPartida['cuenta'];
            $nombreCuenta = $cuentaPartida['nombre'];
            $partidaLinea = new PartidaDetalle();
            $partidaLinea->setPartidaId($partidaQ->getId());
            $partidaLinea->setDetalle($nombreCuenta);
            $partidaLinea->setCuentaContable($cuentaContable);
            $partidaLinea->setDebe(0);
            $partidaLinea->setHaber($VALOR_ISR);

            //  $partidaLinea->setGrupo($concepto);
            $partidaLinea->save();
        }

        $VALOR_SIN_ISR = $VALORtotal + $TOTALIVA - $VALOR_ISR - $VALOR_RETIENE_IVA;

        //cuenta que coloco
        $cuentaPartida = $gastoCaja->getCuenta();
        $cuentaQr = CuentaErpContableQuery::create()->findOneByCuentaContable($cuentaPartida);
        $cuentaContable = $cuentaQr->getCuentaContable();
        $nombreCuenta = $cuentaQr->getNombre();
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaQ->getId());
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe(0);
        $partidaLinea->setHaber($VALOR_SIN_ISR);
        $partidaLinea->setGrupo("PROVEEDOR COMPRA");
        $partidaLinea->save();
        // $ordenProveedor->setValorImpuesto($VALOR_ISR + $VALOR_RETIENE_IVA);
        $gastoCaja->setPartidaNo($partidaQ->getId());
        $gastoCaja->save();
        return $partidaQ->getId();
    }

    public function executeCuenta(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $valor = $request->getParameter('val');
        $gasto = GastoCajaQuery::create()->findOneById($id);
        $gasto->setCuenta($valor);
        $gasto->save();
        echo "<pre>";
        print_r($gasto);
        echo "</pre>";
        echo "actualizado";
        die();
    }

    public function executeTienda(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $valor = $request->getParameter('val');
        $gasto = GastoCajaQuery::create()->findOneById($id);
        $gasto->setTiendaId($valor);
        $gasto->save();
        echo "<pre>";
        print_r($gasto);
        echo "</pre>";
        echo "actualizado";
        die();
    }

    public function executeFecha(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $valor = $request->getParameter('val');
        $gasto = GastoCajaQuery::create()->findOneById($id);
        $fechaFin = explode('/', $valor);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $gasto->setFecha($fechaFin);
        $gasto->save();
        echo "<pre>";
        print_r($gasto);
        echo "</pre>";
        echo "actualizado";
        die();
    }

    public function executeValor(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $valor = $request->getParameter('val');
        $gasto = GastoCajaQuery::create()->findOneById($id);
        $gasto->setValor($valor);
        $gasto->save();
        echo "<pre>";
        print_r($gasto);
        echo "</pre>";
        echo "actualizado";
        die();
    }

    public function executeObservacion(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $valor = $request->getParameter('val');
        $gasto = GastoCajaQuery::create()->findOneById($id);
        $gasto->setConcepto($valor);
        $gasto->save();
        echo "<pre>";
        print_r($gasto);
        echo "</pre>";
        echo "actualizado";
        die();
    }

    public function executeCarga(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $this->getResponse()->setContentType('charset=utf-8');
        $id = $request->getParameter('id');
        $this->id = $id;
        sfContext::getInstance()->getUser()->setAttribute('seledatos', null, 'carga');
        $datos = Gasto::pobladatos($id);
        if (!$datos['valido']) {
            $texto = $datos['pendiente'];
            $textol = implode(' , ', $texto);
            $this->getUser()->setFlash('error', 'Las siguiente columnas no fueron encontradas: ' . $textol);
            $this->redirect('carga_gasto/index');
        }
        $this->datos = $datos;
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $usuario = $usuarioQ->getUsuario();
        $gastoCaja = GastoCajaQuery::create()
                ->filterByUsuario($usuario)
                ->filterByEstatus("Proceso")
                ->findOne();
        $gastoCaja->setValor($datos['total']);
        $gastoCaja->save();
        $this->redirect('carga_gasto/index');
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seledatos', null, 'carga'));
        $this->tiendaver = null;
        $this->tiendas = TiendaQuery::create()->filterByActivo(true)->orderByNombre()->find();
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $usuario = $usuarioQ->getUsuario();
        $gastoCaja = GastoCajaQuery::create()
                ->filterByUsuario($usuario)
                ->filterByEstatus("Proceso")
                ->findOne();
        if (!$gastoCaja) {
            $gastoCaja = new GastoCaja();
            $gastoCaja->setUsuario($usuario);
            $gastoCaja->setFecha(date('Y-m-d'));
            $gastoCaja->setEstatus("Proceso");
            $gastoCaja->setTiendaId($usuarioQ->getTiendaId());
            $gastoCaja->save();
        }

        $this->gasto = $gastoCaja;
        if ($valores) {
            if ($request->isMethod('post')) {
                $cuenta = $request->getPostParameter("cuentaid");
                if (trim($cuenta) == "") {
                    $this->getUser()->setFlash('error', 'Debe seleccionar numero de cuenta ');
                    $this->redirect('carga_gasto/index');
                }
                $gastoCaja->setCuenta($cuenta);
                $gastoCaja->save();
                foreach ($valores as $regi) {
                    if ($regi['VALIDO']) {
                        $fecha = $regi['FECHA'];
                        $fecha = str_replace(" ", "", $fecha);
                        $fecha = trim($fecha);
                        $fecha = substr($fecha, 0, 10);
                        $proyectQ = ProyectoQuery::create()->findOneByNombre($regi['TIPO']);
                        $detalle = New GastoCajaDetalle();
                        $detalle->setGastoCajaId($gastoCaja->getId());
                        $detalle->setSerie($regi['SERIE']);
                        $detalle->setFactura($regi['FACTURA']);
                        $detalle->setFecha($fecha);
                        $detalle->setDescripcion($regi['DESCRIPCION']);
                        $detalle->setProveedorId($regi['PROVEEDORID']);
                        $detalle->setCuenta($regi['CUENTA']);
                        $detalle->setValor($regi['VALOR']);
                        $detalle->setIva($regi['IVA']);
                        $detalle->setValorIsr($regi['VALOR_ISR']);
                        $detalle->setValorRetieneIva($regi['VALOR_RETIENE_IVA']);
                        $detalle->setValorIdp($regi['IDP']);
                        if ($proyectQ) {
                            $detalle->setProyectoId($proyectQ->getId());
                        }
                        $detalle->save();
                    }
                }
                sfContext::getInstance()->getUser()->setAttribute('seledatos', null, 'carga');
                $gastoCaja->setEstatus('Confirmado');
                $gastoCaja->save();
                $this->partida($gastoCaja);

                // ** busca proveeoro crea proveedor
                $provedorQ = ProveedorQuery::create()->findOneByCodigo("TIENDA" . $gastoCaja->getTiendaId());
                if (!$provedorQ) {
                    $provedorQ = new Proveedor();
                    $provedorQ->setActivo(true);
                    $provedorQ->setNombre($gastoCaja->getTienda()->getNombre());
                    $provedorQ->setCodigo("TIENDA" . $gastoCaja->getTiendaId());
                    $provedorQ->setObservaciones("Proveedor creado para proceso de caja tienda");
                    $provedorQ->save();
                }

                ///crea gasto de caja 
                $gasto = new Gasto();
                $gasto->setCodigo('Caja' . $gastoCaja->getId());
                $gasto->setUsuario($gastoCaja->getUsuario());
                $gasto->setEmpresaId($gastoCaja->getEmpresaId());
                $gasto->setProveedorId($provedorQ->getId());
                $gasto->setFecha($gastoCaja->getFecha('Y-m-d'));
                $gasto->setTiendaId($gastoCaja->getTiendaId());
                $gasto->setEstatus("Confirmada");
                $gasto->setToken(sha1('Caja' . $gastoCaja->getId()));
                $gasto->setTipoDocumento("GastoTienda");
                $gasto->setDocumento($gastoCaja->getId());
                $gasto->setValorTotal($gastoCaja->getValorTotal()-$gastoCaja->getValorIdp());
                $gasto->setValorPagado(0);
                $gasto->setValorImpuesto($gastoCaja->getValorImpuesto());
                $gasto->setValorIsr($gastoCaja->getValorIsr());
                $gasto->setValorRetieneIva($gastoCaja->getValorRetieneIva());
                $gasto->setObservaciones("Cargo de gastos por archivo " . date('d/m/Y'));
                $gasto->setPartidaNo($gastoCaja->getPartidaNo());
                $detalle->setValorIdp($gastoCaja->getValorIdp());
                $gasto->save();

                //** crea cuenta proveedor
                $cuentaProveedor = CuentaProveedorQuery::create()->findOneByGastoId($gasto->getId());
                if (!$cuentaProveedor) {
                    $cuentaProveedor = new CuentaProveedor();
                    $cuentaProveedor->setGastoId($gasto->getId());
                }
                $valorPagar = $gastoCaja->getValor() - $gastoCaja->getValorImpuesto();
                $valorPagar = round($valorPagar, 2);
                $cuentaProveedor->setProveedorId($gasto->getProveedorId());
                $cuentaProveedor->setFecha(date('Y-m-d'));
                $cuentaProveedor->setDetalle("Gasto " . $gasto->getCodigo());
                $cuentaProveedor->setValorTotal($valorPagar);
                $cuentaProveedor->setValorPagado(0);
                $cuentaProveedor->setContrasenaNo(-1);
                $cuentaProveedor->save();

                $this->getUser()->setFlash('exito', 'Informacion almacenada cone exito ');
                $this->redirect('carga_gasto/index');
            }
        }

        $this->partidaPen = PartidaQuery::create()
                ->filterByUsuario($usuario)
                ->filterByConfirmada(0)
                ->filterByTipo('GastoCaja')
                ->findOne();
    }

    public function executeReporte(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $empresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "Modelo";
        $nombreEMpresa = $empresaQ->getNombre();
        $pestanas[] = 'Carga';
        $nombre = "Modelo";
        $filename = "Archivo_Carga_Gastos_" . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("TIPO DE ARCHIVO ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
//        $hoja->getCell("B1")->setValueExplicit("Archivo carga Gasto   Columna TIPO (S) servicios (M) mercancias", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getCell("B1")->setValueExplicit("Archivo carga Gasto   Columnas (aplica iva,retiene iva,exento isr) colocar 1 para activar", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B1:D1");


        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');
        $encabezados[] = array("Nombre" => 'serie', "width" => 12, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'factura', "width" => 16, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'fecha', "width" => 12, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'descripcion', "width" => 45, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'codigo proveedor', "width" => 22, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'proveedor', "width" => 45, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'cuenta', "width" => 18, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'nombre cuenta', "width" => 35, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'valor', "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'aplica iva', "width" => 13, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'retiene iva', "width" => 13, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'exento isr', "width" => 13, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'IDP', "width" => 15, "align" => "left", "format" => "#,##0.00");
        // $encabezados[] = array("Nombre" => 'TIPO', "width" => 13, "align" => "left", "format" => "@");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $hoja->getStyle('A2:I2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('819BFB');
        $hoja->getStyle('F')->getAlignment()->setWrapText(true);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        //          die();
        $xl->save('php://output');
        die();
        throw new sfStopException();
    }

}
