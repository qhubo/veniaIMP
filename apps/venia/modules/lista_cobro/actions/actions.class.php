<?php

/**
 * lista_cobro actions.
 *
 * @package    plan
 * @subpackage lista_cobro
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lista_cobroActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        $this->id = $request->getParameter("id");
        $operacionPago = OperacionPagoQuery::create()->findOneById($this->id);

        $numberToLetterConverter = new NumberToLetterConverter();
        $valor = $operacionPago->getValor() + $operacionPago->getComision();
        $valor = Parametro::formato($valor, false);
        $valor = str_replace(",", "", $valor);
        $totalImprime = str_replace(".", ",", $valor);
        $TOTAL_LETRAS = $numberToLetterConverter->to_word($totalImprime, $miMoneda = null);


        $NOMBRE_EMPRESA = $operacionPago->getEmpresa()->getNombre();
        $DIRECCION = $operacionPago->getEmpresa()->getDireccion();
        $TELEFONO = $operacionPago->getEmpresa()->getTelefono();
        $logo = $operacionPago->getOperacion()->getEmpresa()->getLogo();
        $CODIGO_CLIENTE = '';
        if ($operacionPago->getOperacion()->getClienteId()) {
            $CODIGO_CLIENTE = $operacionPago->getOperacion()->getCliente()->getCodigo();
        }
        $EMPRESAnit = EmpresaQuery::create()->findOneByTelefono($operacionPago->getOperacion()->getTienda()->getNit());
        if ($EMPRESAnit) {
            $logo = $EMPRESAnit->getLogo();
            $NOMBRE_EMPRESA = $EMPRESAnit->getNombre();
            $DIRECCION = $EMPRESAnit->getDireccion();
            $TELEFONO = $EMPRESAnit->getTelefono();
        }
        $logo = 'uploads/images/' . $logo;
        $html = $this->getPartial('lista_cobro/reporte', array("operacionPago" => $operacionPago,
            "logo" => $logo, 'NOMBRE_EMPRESA' => $NOMBRE_EMPRESA,
            'DIRECCION' => $DIRECCION, 'TELEFONO' => $TELEFONO,
            'TOTAL_LETRAS' => $TOTAL_LETRAS,
            'CODIGO_CLIENTE' => $CODIGO_CLIENTE
        ));
        $pdf = new sfTCPDF("P", "mm", "Letter");

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle('Recibo Pago ' . $operacionPago->getCodigo());
        $pdf->SetSubject('Recibo');
        $pdf->SetKeywords('Recibo recibo'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetMargins(3, 5, 0, true);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetHeaderMargin(0.1);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont('dejavusans', '', 9);
        $pdf->AddPage();
        $pdf->Image($logo, 0, 5, 35, '', '', '', '100', false, 0);
        $pdf->writeHTML($html);



        $pdf->Output('Recibo Pago ' . $operacionPago->getCodigo() . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeConfirmarCuenta(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&$dirh =
        $fel = $request->getParameter('fel'); //=155555&$dirh =

        $operacionQ = OperacionQuery::create()->findOneById($id);
        $operacionQ->setEstatus("Cuenta Cobrar");
        $operacionQ->save();

        OrdenCotizacionQuery::partidaVenta($operacionQ);
        $this->getUser()->setFlash('exito', 'Factura enviado a cuentas por cobrar ' . $operacionQ->getCodigo());

        $OperacionId = $request->getParameter('id'); //=155555&$dirh =
        if ($fel == 'SI') {

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
            //$this->redirect('lista_cobro/caja?id=' . $OperacionId);
        }
        $this->redirect('lista_cobro/index?id=' . $operacionQ->getId());
        echo "actualizado";
        die();
    }

    public function executeNombre(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&$dirh =
        $val = $request->getParameter('val'); //=155555&$dirh =
        $operacionQ = OperacionQuery::create()->findOneById($id);
        $operacionQ->setNombre($val);
        $operacionQ->save();
        echo "actualizado";
        die();
    }

    public function executeComentario(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&$dirh =
        $val = $request->getParameter('val'); //=155555&$dirh =
        $operacionQ = OrdenCotizacionQuery::create()->findOneById($id);
        $operacionQ->setComentario($val);
        $operacionQ->save();
        echo "actualizado";
        die();
    }

    public function executeNit(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&$dirh =
        $val = $request->getParameter('val'); //=155555&$dirh =
        $operacionQ = OperacionQuery::create()->findOneById($id);
        $operacionQ->setNit($val);
        $operacionQ->save();
        echo "actualizado";
        die();
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
        $this->redirect('lista_cobro/caja?id=' . $OperacionId);
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        $this->id = $request->getParameter('id'); //=155555&$dirh =
        $acceso = MenuSeguridad::Acceso('lista_cobro');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        $this->operaciones = OperacionQuery::create()
                ->filterByPagado(false)
                ->filterByEstatus('Procesada')
                ->orderByFecha("Desc")
                ->find();

        $this->operacion = OperacionQuery::create()->findOneById($this->id);
    }

    public function executeCaja(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $OperacionId = $request->getParameter('id'); //=155555&$dirh =
        $operacion = OperacionQuery::create()->findOneById($OperacionId);
        $this->operacion = OperacionQuery::create()->findOneById($OperacionId);
        $this->detalle = OperacionDetalleQuery::create()->filterByOperacionId($OperacionId)->find();
        $this->pagos = OperacionPagoQuery::create()->filterByOperacionId($OperacionId)->find();
        $this->ulPago = OperacionPagoQuery::create()->filterByOperacionId($OperacionId)->orderById("Desc")->findOne();
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $value['fecha'] = date('d/m/Y');
        $value['factura_electronica'] = true;
        $this->form = new SelePagoProveedorForm($value);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $banco_id=$valores['banco_id'];
                if ($banco_id) {
                   $documento =$valores['no_documento'];
                   $operacionPago = OperacionPagoQuery::create()
                           ->filterByBancoId($banco_id)
                           ->filterByDocumento($documento)
                           ->findOne();
                   if ($operacionPago) {
                                   $this->getUser()->setFlash('error', 'Numero de documento ya fue utilizado para este banco recibo  '.$operacionPago->getCodigo());
                        $this->redirect('lista_cobro/caja?id=' . $OperacionId);
                   }
                    
                }
//                echo "<pre>";
//                print_r($valores);
//                die();
//                
                

                $tipoPago = $valores['tipo_pago'];
                $tipoPago = str_replace(" ", "", $tipoPago);
                $tipoPago = strtoupper(trim($tipoPago));

                if ($tipoPago == "CONTRAENTREGA") {
                    if ($operacion->getValorPagado() > 0) {
                        $this->getUser()->setFlash('error', 'Ya existe valor pagado previamente no permite CONTRA ENTREGA');
                        $this->redirect('lista_cobro/caja?id=' . $OperacionId);
                    }
                    if ($operacion->getValorTotal() > $valores['valor']) {
                        $this->getUser()->setFlash('error', 'Medio Pago CONTRA ENTREGA no permite pagos parciales');
                        $this->redirect('lista_cobro/caja?id=' . $OperacionId);
                    }
                    if ($operacion->getValorPagado() > 0) {
                        $this->getUser()->setFlash('error', 'Ya existe valor pagado previamente no permite CONTRA ENTREGA');
                        $this->redirect('lista_cobro/caja?id=' . $OperacionId);
                    }
                    $clienteQ = ClienteQuery::create()->findOneByCodigo($tipoPago);
                    if (!$clienteQ) {
                        $clienteQ = new Cliente();
                        $clienteQ->setCodigo($tipoPago);
                        $clienteQ->setCorreoContacto($tipoPago);
                        $clienteQ->setNombre('GUATEX');
                        $clienteQ->save();
                    }
                    $observacionesPrevia = $operacion->getObservaciones();
                    $operacion->setObservaciones($observacionesPrevia . "   Guia " . $valores['no_documento']);
                    $operacion->setClienteId($clienteQ->getId());
                    $operacion->setEstatus("Cuenta Cobrar");
                    $operacion->save();
                    OrdenCotizacionQuery::partidaVenta($operacion);
                    $this->getUser()->setFlash('exito', 'Operacion enviada a cuentas por cobrar');
                    $this->redirect('lista_cobro/index');
                }

                $valor = $valores['valor'];
                $valorPagado = $operacion->getValorPagado() + $valor;
                if ($valorPagado > $operacion->getValorTotal()) {
                    sfContext::getInstance()->getUser()->setAttribute('tab', 4, 'seguridad');
                    $this->getUser()->setFlash('error', 'Valor de pago  ' . $valorPagado . " es mayor que valor documento " . $operacion->getValorTotal());
                    $this->redirect('lista_cobro/caja?id=' . $OperacionId);
                }
                $fechaInicio = $valores['fecha'];
                $fechaInicio = explode('/', $fechaInicio);
                $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];

                if ($valores['fecha']) {
                    $fechaInicio = $valores['fecha'];
                    $fechaInicio = explode('/', $fechaInicio);
                    $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
                } else {
                    $fechaInicio = date('Y-m-d');
                }

                $OperaPgo = new OperacionPago();
                $OperaPgo->setOperacionId($operacion->getId());
                $OperaPgo->setTipo($valores['tipo_pago']);
                $OperaPgo->setDocumento($valores['no_documento']);
                if ($valores['banco_id']) {
                    $OperaPgo->setBancoId($valores['banco_id']);
                }
                $OperaPgo->setFechaDocumento($fechaInicio);
                $OperaPgo->setUsuario($usuarioQ->getUsuario());
                $OperaPgo->setFechaCreo(date('Y-m-d H:i:s'));
                $OperaPgo->setValor($valor);
                $OperaPgo->save();
                //  $this->partidaPago($OperaPgo);
                $valorPagado = $operacion->getValorPagado() + $valor;
                $OperaPgo->setFechaCreo(date('Y-m-d H:i:s'));
                // $OperaPgo->setValorPagado($valorPagado);
                //$OperaPgo->setFechaPago(date('Y-m-d H:i:s'));
                if ($valorPagado >= $operacion->getValorTotal()) {
                    $operacion->setPagado(true);
                    $detalle = OperacionDetalleQuery::create()
                            ->filterByOperacionId($operacion->getId())
                            ->useProductoQuery()
                            ->filterByTercero(true)
                            ->endUse()
                            ->count();
                    if ($detalle > 0) {
                        $operacion->setEstatus('Entrega');
                        $operacion->save();
                    }
                    OrdenCotizacionQuery::partidaVenta($operacion);
                }
                $operacion->save();
                $operacion->setValorPagado($valorPagado);
                $operacion->save();

                if ($OperaPgo->getBancoId()) {
                    $movimiento = New MovimientoBanco();
                    $movimiento->setTipo('Pago');
                    $movimiento->setTipoMovimiento($OperaPgo->getTipo());
                    $movimiento->setBancoOrigen($OperaPgo->getBancoId());
                    $movimiento->setDocumento($OperaPgo->getDocumento());
                    $movimiento->setBancoId($OperaPgo->getBancoId());
                    $movimiento->setFechaDocumento($OperaPgo->getFechaDocumento('Y-m-d H:i'));
                    $movimiento->setValor($OperaPgo->getValor());
                    $movimiento->setObservaciones("Pago Operacion " . $operacion->getCodigo());
                    $movimiento->setEstatus("Confirmado");
                    $movimiento->setUsuario($OperaPgo->getUsuario());
                    $movimiento->save();
//                    $cxc = New CuentaBanco();
//                    $cxc->setBancoId($movimiento->getBancoId());
//                    $cxc->setMovimientoBancoId($movimiento->getId());
//                    $cxc->setMovimientoB($movimiento->getId());
//                    $cxc->setValor($movimiento->getValor());
//                    $cxc->setFecha($movimiento->getCreatedAt());
//                    $cxc->setDocumento($movimiento->getDocumento());
//                    $cxc->setUsuario($movimiento->getUsuario());
//                    $cxc->setCreatedAt($movimiento->getCreatedAt());
//                    $cxc->setObservaciones($movimiento->getTipo());
//                    $cxc->save();

                    $cxc = New CuentaBanco();
                    $cxc->setBancoId($OperaPgo->getBancoId());
                    $cxc->setOperacionPagoId($OperaPgo->getId());
                    $cxc->setValor($OperaPgo->getValor());
                    $cxc->setFecha($OperaPgo->getFechaCreo('Y-m-d'));
                    $cxc->setDocumento($OperaPgo->getDocumento());
                    $cxc->setUsuario($OperaPgo->getUsuario());
                    $cxc->setCreatedAt($OperaPgo->getFechaCreo());
                    $cxc->setObservaciones($OperaPgo->getTipo());
                    $cxc->save();
                }
                sfContext::getInstance()->getUser()->setAttribute('tab', 4, 'seguridad');
                $this->getUser()->setFlash('exito', 'Pago realizado con exito ' . $OperaPgo->getId());
                if (trim($operacion->getFaceEstado()) == "") {
                    if ($valores['factura_electronica']) {
                        $returna = Operacion::FacturaFel($operacion->getId());
                        if (trim($returna['ERROR']) <> "") {
                            $this->getUser()->setFlash('error', 'ERROR FEL ' . $returna['ERROR']);
                        }
                        if (trim($returna['CONTIGENCIA']) <> "") {
                            $this->getUser()->setFlash('error', 'FACTURA EN CONTINGENCIA ' . $returna['CONTIGENCIA']);
                        }
                        if (trim($returna['UUID']) <> "") {
                            $this->getUser()->setFlash('exito', 'FACTURA FEL creada con exito ' . $returna['UUID']);
                        }

//                      $returna['ERROR'] = $ERROR; // = '';
//        $returna['CONTIGENCIA'] = $CONTIGENCIA; // = '';
//        $returna['FECHA'] = $FECHA; // = '';
//        $returna['SERIE'] = $SERIE; // = '';
//        $returna['NUMERO'] = $NUMERO; // = '';
//        $returna['UUID'] = $UUID; // = '';
                    }
                }
                $this->redirect('lista_cobro/caja?id=' . $OperacionId);
            }
        }
        $this->partidaQ = PartidaQuery::create()->filterByConfirmada(false)->findOneByCodigo($operacion->getCodigo());
    }

}
