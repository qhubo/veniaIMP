<?php

/**
 * reporte_venta actions.
 *
 * @package    plan
 * @subpackage reporte_venta
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporte_ventaActions extends sfActions {

    public function retornaProductos($id) {
        $operaDet = OperacionQuery::create()->findOneById($id);
        $cotizacion = OrdenCotizacionQuery::create()->findOneByCodigo($operaDet->getCodigo());
        $OrdenUbicacion = OrdenUbicacionQuery::create()
                ->filterByOrdenCotizacionId($cotizacion->getId())
                ->find();
        $total=0;
        foreach ($OrdenUbicacion as $regi) {
            $tiendaId = $regi->getTiendaUbica();
            $ubicacion = $regi->getUbicacionId();
            $cantida = $regi->getCantidad();
            $productoId = $regi->getProductoId();
            $total++;
            $productoUbi = ProductoUbicacionQuery::create()
                    ->filterByProductoId($productoId)
                    ->filterByTiendaId($tiendaId)
                    ->filterByUbicacion($ubicacion)
                    ->findOne();
            $nuevCantidad = $productoUbi->getCantidad() + $cantida;
            $productoUbi->setCantidad($nuevCantidad);
            $productoUbi->save();

            $ProductoExite = ProductoExistenciaQuery::create()
                    ->filterByTiendaId($tiendaId)
                    ->filterByProductoId($productoId)
                    ->findOne();
            $nuevaCantidad = $ProductoExite->getCantidad() + $cantida;
            $ProductoExite->setCantidad($nuevaCantidad);
            $ProductoExite->save();
            ProductoMovimientoQuery::Ingreso($productoId, $cantida, 'ANU' . $operaDet->getCodigo(), "Ingreso Inventario", date("Y-m-d"), $tiendaId);
        }
        return $total;
    }
    public function executeCorrigeVendedor(sfWebRequest $request) {
         error_reporting(-1);
              $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
                date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('opera'); //=155555&$dirh =
        $vendedorID = $request->getParameter('vendedor'); //=155555&$dirh =
        $VendedorQ = VendedorQuery::create()->findOneById($vendedorID);
        $operacionQ = OperacionQuery::create()->findOneById($id);
        $vendedorActual='';
        if ($operacionQ->getVendedorId()) {
            $vendedorActual = $operacionQ->getVendedor()->getNombre();
        }        
        $operacionQ->setVendedorId(null);
        $nombreVe = '';
        if ($vendedorID >0) {
           $operacionQ->setVendedorId($vendedorID);
        }
        if ($VendedorQ) {
            $nombreVe=$VendedorQ->getNombre();
        }            
        $operacionQ->save();
        $bitacora = new CambioVendedor();
        $bitacora->setCodigoOpera($operacionQ->getCodigo());
        $bitacora->setVendedorAnterior($vendedorActual);
        $bitacora->setVendedorActualizado($nombreVe);
        $bitacora->setFecha(date('Y-m-d H:i:s'));
        $bitacora->setUsuario($usuarioQue->getUsuario());
        $bitacora->save();
        
        
        $this->getUser()->setFlash('exito', 'Vendedor '.$nombreVe.' Actualizado para Codigo '.$operacionQ->getCodigo()." ");
        $this->redirect('reporte_venta/index');
        
    }
    public function executeComentario(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&$dirh =
        $val = $request->getParameter('val'); //=155555&$dirh =
        $operacionQ = OperacionQuery::create()->findOneById($id);
        $operacionQ->setObservaciones($val);
        $operacionQ->save();
        echo "actualizado";
        die();
    }
    public function executeReporteExcel(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $bodegaId = null;
        if ($usuarioQue) {
            $bodegaId = $usuarioQue->getTiendaId();
        }
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccioventa', null, 'consulta'));
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['usuario'] = null;
            $valores['usuario'] = $usuarioId;
            $valores['bodega'] = $bodegaId;
        }
        $this->getResponse()->setContentType('text/html;charset=utf-8');
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "Modelo";
        $pestanas[] = substr($EmpresaQuery->getNombre(), 0, 30);
        $nombre = "Modelo";
        $nombreEMpresa = $EmpresaQuery->getNombre();
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $filename = "Reporte de Ventas " . $nombreEMpresa . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("FECHAS", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->getCell("B1")->setValueExplicit($valores['fechaInicio'] . " al  " . $valores['fechaFin'], PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B1:D1");
        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $encabezados[] = array("Nombre" => "TIENDA", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "CODIGO", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Fecha"), "width" => 30, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => "USUARIO", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "CLIENTE", "width" => 30, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "NOMBRE", "width" => 50, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "NIT", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "ESTADO", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Valor"), "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Valor Pagado"), "width" => 25, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => "Fecha", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Firma", "width" => 45, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Vendedor", "width" => 45, "align" => "center", "format" => "@");

        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $operaciones = $this->datos($valores);
        foreach ($operaciones as $lista) {
            $fila++;
            $datos = null;
            $codigCli = '';
            if ($lista->getClienteId()) {
                $codigCli = $lista->getCliente()->getCodigoCli();
            }
            $datos[] = array("tipo" => 3, "valor" => substr($lista->getTienda(), 0, 20));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $lista->getCodigo());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $lista->getFecha('d/m/Y H:i'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $lista->getUsuario());
            $datos[] = array("tipo" => 3, "valor" => $codigCli);
            $datos[] = array("tipo" => 3, "valor" => $lista->getNombre());
            $datos[] = array("tipo" => 3, "valor" => $lista->getNit());
            $datos[] = array("tipo" => 3, "valor" => $lista->getEstatus());
            $datos[] = array("tipo" => 2, "valor" => $lista->getValorTotal());
            $datos[] = array("tipo" => 2, "valor" => $lista->getValorPagado());
            $datos[] = array("tipo" => 3, "valor" => $lista->getFecha('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $lista->getFaceFirma());
            $vende = "";
            if ($lista->getVendedorId()) {
                $vende = $lista->getVendedor()->getNombre();
            }
            $datos[] = array("tipo" => 3, "valor" => $vende);
            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;

//        $hoja->getCell("A" . $fila)->setValueExplicit("ULTIMA LINEA", PHPExcel_Cell_DataType::TYPE_STRING);
//        $hoja->mergeCells("B" . $fila . ":D" . $fila);
//        $hoja->getCell("B" . $fila)->setValueExplicit("----------------------------------------", PHPExcel_Cell_DataType::TYPE_STRING);
//        print_r($encabezados);
//        
//        die();
        header("Content-Type: text/html;charset=utf-8");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }
    public function executeReenviar(sfWebRequest $request) {
        $OperacionId = $request->getParameter('id'); //=155555&$dirh =
        $returna = Operacion::FacturaFel($OperacionId);
        if (trim($returna['ERROR']) <> "") {
            $this->getUser()->setFlash('error', 'ERROR FEL ' . $returna['ERROR']);
        }
        if (trim($returna['CONTIGENCIA']) <> "") {
            $this->getUser()->setFlash('error', 'FACTURA EN CONTINGENCIA ' . $returna['CONTIGENCIA']);
        }
        if (trim($returna['UUID']) <> "") {
            $this->getUser()->setFlash('exito', 'FACTURA FEL creada con exito ' . $returna['UUID']);
        }
        $this->redirect('reporte_venta/index?id=' . $OperacionId);
    }
    public function executeAnula(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $this->getResponse()->setContentType('charset=utf-8');
        $valoresV = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccioventa', null, 'consulta'));

        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);

        $id = $request->getParameter('id');
        $this->id = $id;
        $operacionQ = OperacionQuery::create()->findOneById($id);
//        OperacionPagoPeer::xmlfeelNOta($operacionQ);
//        die();
        $this->operacion = $operacionQ;

        $this->form = new ComentarioIngresoForm();

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $observaciones = $valores['observaciones'];

                $operacionQ->setObservaciones($observaciones);
                $operacionQ->save();
                $resultado['Status'] = true;
                if ($operacionQ->getFaceEstado() == 'FIRMADO') {
                    $aplicaNota = false;
                    if ($operacionQ->getFecha('dmY') <> date('dmY')) {
                        $aplicaNota = true;
                    }

                    if ($aplicaNota) {
                        $resultado = Operacion::NotaFel($operacionQ->getId());
                    } else {
                        $username = $operacionQ->getEmpresa()->getFeelUsuario(); // '630001';
                        $password = $operacionQ->getEmpresa()->getFeelLlave(); //  'kuHag&xo9?w22pr#ka-A';
                        $base64 = base64_encode($username . ":" . $password);
                        $Cmpcode = (int) $operacionQ->getTienda()->getCodigoEstablecimiento();
                        $Cmpcode = (int) $operacionQ->getEmpresa()->getNomenclatura();

                        $whscode = '00001';
                        $whscode = $operacionQ->getTienda()->getCodigoEstablecimiento();
                        $EMPRESAnit = EmpresaQuery::create()->findOneByTelefono($operacionQ->getTienda()->getNit());
                        if ($EMPRESAnit) {
                            $username = $EMPRESAnit->getFeelUsuario(); // '630001';
                            $password = $EMPRESAnit->getFeelLlave(); //  'kuHag&xo9?w22pr#ka-A';
                            $base64 = base64_encode($username . ":" . $password);
                            $Cmpcode = (int) $EMPRESAnit->getNomenclatura();
                            $whscode = $operacionQ->getTienda()->getCodigoEstablecimiento();
                        }


                        $stattionId = 1;
                        $operaId = $operacionQ->getId();
                        $Docentry = $operaId;
                        if (strlen($operaId) == 1) {
                            $Docentry = "1000" . $operaId;
                        }
                        if (strlen($operaId) == 2) {
                            $Docentry = "100" . $operaId;
                        }
                        if (strlen($operaId) == 3) {
                            $Docentry = "1000" . $operaId;
                        }
                        $Docentry = $operacionQ->getDocentry();
                        $Docentry = (int) $Docentry;

                        $url = 'http://23.99.129.238/Dev/Document/anullmentext/' . $Cmpcode . '/' . $whscode . '/' . $stattionId . '/' . $Docentry;

                        $texto = $url;
                        $texto .= "\n";

                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json',
                                'Authorization: Basic ' . $base64
                            ),
                        ));

                        $response = curl_exec($curl);
                        $resultado = json_decode($response, true);

                        if ($resultado['Status']) {
                            $resultad = json_decode($response);
                            $DATA = json_decode($resultad->Data);
                            if (isset($DATA->DocEntry)) {
                                $DocEntry = $DATA->DocEntry;
                            }
                            if (isset($DATA->Contingencia)) {
                                $CONTIGENCIA = $DATA->Contingencia;
                            }
                            if (isset($DATA->Fecha_Cert)) {
                                $FECHA = $DATA->Fecha_Cert;
                            }
                            if (isset($DATA->Serie)) {
                                $SERIE = $DATA->Serie;
                            }
                            if (isset($DATA->Numero)) {
                                $NUMERO = $DATA->Numero;
                            }
                            if (isset($DATA->UUID)) {
                                $UUID = $DATA->UUID;
                            }
                            $operacionQ->setAnulaFaceFechaEmision($FECHA);
                            $operacionQ->setAnulaDocentry($DocEntry);
                            $operacionQ->setAnulaFaceReferencia($CONTIGENCIA);
                            $operacionQ->setAnulaFaceSerieFactura($SERIE);
                            $operacionQ->setAnulaFaceFirma($UUID);
                            $operacionQ->setAnulaFaceNumeroFactura($NUMERO);
                            $operacionQ->save();
                            
                        }

                        $texto .= $response;
                        $ruta = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . "logfelAnula.txt";
                        $fh = fopen($ruta, 'w');
                        fwrite($fh, $texto);
                        fclose($fh);
                    }
                }


                if ($resultado['Status']) {
                    $operacionQ->setAnuloUsuario($usuarioQue->getUsuario());
                    $operacionQ->setAnulado(true);
                    $operacionQ->setFechaAnulo(date('Y-m-d H:i:s'));
                    $operacionQ->setEstatus('Anulado');
                    $operacionQ->save();
                    $valoresV['estado'] = 'Anulado';

                   $total=  $this->retornaProductos($operacionQ->getId());
                    
                   if ($total==0) {
                    $opreaciones = OperacionDetalleQuery::create()
                            ->filterByOperacionId($operacionQ->getId())
                            ->find();
                    foreach ($opreaciones as $de) {
                        $de = OperacionDetalleQuery::create()->findOneById($de->getId());
                        $de->getCantidad();
                        $de->getProductoId();
                        $clave = $de->getProductoId();
                        $valor = $de->getCantidad();
                        ProductoMovimientoQuery::Ingreso($clave, $valor, $operacionQ->getCodigoFactura(), "Anula Factura", date('Y-m-d H:i:s'), $operacionQ->getTiendaId());
                        ProductoExistenciaQuery::Actualiza($clave, $valor, $operacionQ->getTiendaId());
                    }
                   }


                    $inventrioVence = InventarioVenceQuery::create()
                            ->filterByOperacionNo($operacionQ->getId())
                            ->find();
                    foreach ($inventrioVence as $regi) {
                        $regi->setDespachado(false);
                        $regi->setOperacionNo(0);
                        $regi->save();
                    }

                    $this->getUser()->setFlash('exito', 'Documento firmado ANULADO  exitosamente');
                } else {
                    $error = serialize($resultado);
                    $operacionQ->setObservaciones($error);
                    $operacionQ->save();
                    $this->getUser()->setFlash('error', 'Intentar nuevamente ' . $error);
                }
            } else {
                $this->getUser()->setFlash('error', 'Debe ingresar el motivo de anulacion');
            }
            $this->redirect('reporte_venta/index');
        }
    }
    public function executeRechazar(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $modulo = $request->getParameter('retorno');
        $productos = ProductoFrontedQuery::create()
                ->filterByEstado('Pendiente')
                ->filterByUsuarioFrontedId($id)
                ->find();
        foreach ($productos as $lis) {
            $lis->delete();
        }
        $this->getUser()->setFlash('error', 'Venta Rechazada con exito');
        $this->redirect($modulo . '/index');
    }
    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $this->vendedores = VendedorQuery::create()->orderByNombre()->find();
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccioventa', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
         $this->TIPO_USUARIO = strtoupper($usuarioQue->getTipoUsuario()); 
        $bodegaId = null;
        if ($usuarioQue) {
            $bodegaId = $usuarioQue->getTiendaId();
        }
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['usuario'] = null;
            $valores['estatus_op']='Procesados';
//            $tipoUsuario = sfContext::getInstance()->getUser()->getAttribute('tipoUsuario', null, 'seguridad');
//            if ($tipoUsuario <> 'ADMINISTRADOR') {
            $valores['usuario'] = $usuarioId;
//            }
//            $valores['estado'] = 'Pagado';
//            $valores['tipo_fecha'] = 'Pago';
            $valores['bodega'] = $bodegaId;
            sfContext::getInstance()->getUser()->setAttribute('seleccioventa', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('seleccioventa', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccioventa', null, 'consulta'));
            }
        }


        $this->operaciones = $this->datos($valores);
        $this->total= $this->granTotal($valores);
        //  die();
    }

    public function executeMuestra(sfWebRequest $request) {
        $OperacionId = $request->getParameter('id'); //=155555&$dirh =
        $this->operacion = OperacionQuery::create()->findOneById($OperacionId);
        $this->detalle = OperacionDetalleQuery::create()->filterByOperacionId($OperacionId)->find();
        $this->pagos = OperacionPagoQuery::create()->filterByOperacionId($OperacionId)->find();
    }

    public function datos($valores) {
        // $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccioventa', null, 'consulta'));
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $bodega = $valores['bodega'];
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresq = EmpresaQuery::create()->findOne();
        $listab = TiendaQuery::TiendaActivas(); // ctivas();
        $operaciones = OperacionQuery::create();
        $operaciones->where("Operacion.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Operacion.Fecha <= '" . $fechaFin . " 23:59:00" . "'");
        if ($valores['estatus_op']) {
            if ($valores['estatus_op']=='Anulados') {
                $operaciones->filterByAnulado(true);
            } else {
                $operaciones->filterByAnulado(false);
            }
        }
        if ($bodega) {
            $operaciones->filterByTiendaId($bodega);
        } else {
            $operaciones->filterByTiendaId($listab, Criteria::IN);
        }
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->orderById('Asc');
        $operaciones = $operaciones->find();
        return $operaciones;
    }
    
        public function granTotal($valores) {
        // $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccioventa', null, 'consulta'));
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $bodega = $valores['bodega'];
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresq = EmpresaQuery::create()->findOne();
        $operaciones = OperacionQuery::create();
        $listab = TiendaQuery::TiendaActivas(); // ctivas();
        $operaciones->where("Operacion.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Operacion.Fecha <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones->filterByAnulado(false);
        if ($bodega) {
            $operaciones->filterByTiendaId($bodega);
        } else {
            $operaciones->filterByTiendaId($listab, Criteria::IN);
        }
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->withColumn('sum(Operacion.ValorTotal)', 'GranValorTotal');
        $RESULT = $operaciones->findOne();
        $VALOR =$RESULT->getGranValorTotal(); 
        
        return $VALOR;
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
                if ($clave == 'ESTADO') {
                    $Busqueda[] = ' ESTADO: ' . $valor;
                }
            }
        }
        if ($Busqueda) {
            $textoBusqueda = implode(",", $Busqueda);
        }
        return $textoBusqueda;
    }

}
