<?php

/**
 * rest actions.
 *
 * @package    plan
 * @subpackage rest
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class restActions extends sfActions {

    public function executeCorrecion(sfWebRequest $request) {
        $id = $request->getParameter('id');
     $partida= PartidaQuery::create()
             ->filterByDetalle(null)
             ->find();
             $actualizado = 0;
     
     foreach($partida as $par) {
     $actualizado++;
         $detalle = $par->getCompleto();
         $par->setDetalle($detalle);
         $par->save();
     }
     $partida= PartidaQuery::create()
             ->filterByDetalle('')
             ->find();
     
     foreach($partida as $par) {
     $actualizado++;
         $detalle = $par->getCompleto();
         $par->setDetalle($detalle);
         $par->save();
     }

        echo "actyualiados " . $actualizado;

        die('---');
    }

    public function executePartidaNota(sfWebRequest $request) {
        echo $id = $request->getParameter('id');
        echo "<br>";
        echo "<br>";

        $nota = NotaCreditoQuery::create()->findOneById($id);
//        echo " <pre>";
//        print_r($nota);
//        die();
//        
        error_reporting(-1);
        $partidaQ = PartidaQuery::create()->findOneById($nota->getPartidaNo());
        $partidaQ->setFechaContable($nota->getFecha('Y-m-d'));
        $partidaQ->setUsuario($nota->getUsuario());
        $partidaQ->setTipo('Nota Cliente');
        $partidaQ->setCodigo($nota->getCodigo());
        $partidaQ->setValor($nota->getValorTotal());
        $partidaQ->setConfirmada(false);
        // $partidaQ->setTiendaId($egreso->getTiendaId());
        //  $partidaQ->setMedioPagoId($egreso->getMedioPagoId());
        $partidaQ->save();
        $Deposito = $nota->getValorTotal();
        $tienda = '';

        $partidaD = PartidaDetalleQuery::create()->filterByPartidaId($partidaQ->getId())->find();
        if ($partidaD) {
            $partidaD->delete();
        }
        $valoresIva = ParametroQuery::ObtenerIva($nota->getValorTotal());
        $VALORSINIVA = $valoresIva['VALOR_SIN_IVA'];
        $IVA = $valoresIva['IVA'];

        //4010-08	VENTAS Periferico	4010-08
        $cuentaPartida = Partida::busca("DEVOLUCION NOTA", 0, 1);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaQ->getId());
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe($VALORSINIVA);
        $partidaLinea->setHaber(0);
        $partidaLinea->setGrupo("DEVOLUCION NOTA");
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();
        $nota->setPartidaNo($partidaQ->getId());
        $nota->save();
        $cuentaPartida = Partida::busca("IVA%NOTA%", 0, 1);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaQ->getId());
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe($IVA);
        $partidaLinea->setHaber(0);
        $partidaLinea->setGrupo("IVA NOTA");
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();
        $cuentaPartida = Partida::busca("NOTA DEPOS", 0, 1);
        $cuentaContable = $cuentaPartida['cuenta'];
        $nombreCuenta = $cuentaPartida['nombre'];
        $partidaLinea = new PartidaDetalle();
        $partidaLinea->setPartidaId($partidaQ->getId());
        $partidaLinea->setDetalle($nombreCuenta);
        $partidaLinea->setCuentaContable($cuentaContable);
        $partidaLinea->setDebe(0);
        $partidaLinea->setHaber($Deposito);
        $partidaLinea->setGrupo("NOTA DEPOS");
        $partidaLinea->setAdicional($tienda);
        $partidaLinea->setTipo(0);
        $partidaLinea->save();
        echo "partida Id  " . $partidaQ->getId();
        die();
    }

    public function executeRevisar(sfWebRequest $request) {
        error_reporting(-1);
        $inputFileName = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . "CUENTA_COBRAR.xls";
        $objReader = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $cont = 0;
        $ingresa = 0;
        foreach ($sheetData as $regisr) {
            $cont++;
            if ($cont > 1) {
                $CODIGO_CLIENTE = trim($regisr['G']);
                if ($CODIGO_CLIENTE <> "") {
                    $fecha = $regisr['A'];
                    if ($fecha <> "") {
                        $documento = $regisr['B'] . "-" . trim($regisr['C']);
                        $valor = $regisr['E'];
                        $valor = str_replace("Q", '', $valor);
                        $valor = str_replace(",", '', $valor);
                        $NOMBRE_CLIENTE = trim($regisr['H']);
                        $vendedor = trim($regisr['I']);
                        $vendeDorQ = VendedorQuery::create()->findOneByNombre($vendedor);
                        if (!$vendeDorQ) {
                            $vendeDorQ = new Vendedor();
                            $vendeDorQ->setNombre($vendedor);
                            $vendeDorQ->save();
                        }

                        $clienteQ = ClienteQuery::create()->findOneByCodigo($CODIGO_CLIENTE);
                        if (!$clienteQ) {
                            $clienteQ = new Cliente();
                            $clienteQ->setCodigo($CODIGO_CLIENTE);
                            $clienteQ->setNombre($NOMBRE_CLIENTE);
                            $clienteQ->setActivo(true);
                            $clienteQ->save();
                        }
                        $OPERACION = OperacionQuery::create()->findOneByCodigo($documento);
                        if (!$OPERACION) {
                            $OPERACION = new Operacion();
                            $OPERACION->setCodigo($documento);
                            $OPERACION->save();
                        }
                        $OPERACION->setCodigoFactura($documento);
                        $OPERACION->setTipo('MIGRACION');
                        $OPERACION->setNombre($NOMBRE_CLIENTE);
                        $OPERACION->setNit($clienteQ->getNit());
                        $OPERACION->setFecha($fecha);
                        $OPERACION->setClienteId($clienteQ->getId());
                        $OPERACION->setValorPagado(0);
                        $OPERACION->setValorTotal($valor);
                        $OPERACION->setEstatus('Cuenta Cobrar');
                        $OPERACION->setTiendaId(16);
                        $OPERACION->setFaceEstado('FIRMADO');
                        $OPERACION->setPagado(0);
                        $OPERACION->setVendedorId($vendeDorQ->getId());
                        $OPERACION->save();
//                    echo $fecha;
//                    echo "<br>";
                        $ingresa++;
                    }
                }
            }
        }
        echo "actualizados " . $ingresa;
        die();
    }

    public function executePartidas(sfWebRequest $request) {
        $cuenta = '2035-08';
        if ($request->getParameter('cuenta')) {
            $cuenta = $request->getParameter('cuenta');
        }
        $partidaDetalle = PartidaDetalleQuery::create()
                ->usePartidaQuery()
                ->where("month(Partida.FechaContable)=1")
                ->endUse()
                ->filterByCuentaContable($cuenta)
                ->find();

        foreach ($partidaDetalle as $regi) {
            $valor = $regi->getHaber() + $regi->getDebe();
            $partida = PartidaQuery::create()->findOneById($regi->getPartidaId());
            echo $partida->getId() . ", " . $partida->getFechaContable() . "," . $regi->getCuentaContable() . ", " . $regi->getDetalle() . "," . $valor . " , ";
            echo $partida->getTipo();
            echo "<br>";
        }

        die();

//        $can=0;
//         $movimientoBanco = MovimientoBancoQuery::create()
//                 ->find();
//         foreach ($movimientoBanco as $regi){
//             $partidaNO= $regi->getPartidaNo();
//             $fecha= $regi->getFechaDocumento();
//             
//             $partidaQ = PartidaQuery::create()->findOneById($partidaNO);
//             if ($partidaQ) {
//                 $can++;
//                 $partidaQ->setFechaContable($fecha);
//                 $partidaQ->save();
//             }
//         }
//         echo "actualizados ".$can;
//         die();
//          
    }

    public function executeMovimiento(sfWebRequest $request) {
        $banco = $request->getParameter('banco');
        $dia = $request->getParameter('dia');
        $mes = $request->getParameter('mes');
        $bancoQuer = BancoQuery::create()->filterByNombre("%" . $banco . "%")->findOne();
        if ($bancoQuer) {
            echo "<strong>" . $bancoQuer->getNombre() . "</strong>";
            echo "<br>";
            if ($dia) {
                $movimientoBanco = MovimientoBancoQuery::create()
                        ->filterByUsuario("migracion", Criteria::NOT_EQUAL)
                        ->filterByBancoId($bancoQuer->getId())
                        ->where("month(MovimientoBanco.FechaDocumento)  =" . date('m'))
                        ->where("day(MovimientoBanco.FechaDocumento)  =" . $dia)
                        ->find();
            } else {
                $movimientoBanco = MovimientoBancoQuery::create()
                        ->filterByUsuario("migracion", Criteria::NOT_EQUAL)
                        ->filterByBancoId($bancoQuer->getId())
                        ->where("month(MovimientoBanco.FechaDocumento)  =" . $mes)
                        // ->where("day(MovimientoBanco.FechaDocumento)  =".$dia)
                        ->find();
            }
            $TOTAL = 0;
            $TOTALCUENTA = 0;
            $totalHaber = 0;
            foreach ($movimientoBanco as $Lista) {
                echo $Lista->getId() . " , ";
                echo $Lista->getFechaDocumento();
                echo ", ";
                echo $Lista->getTipo();
                echo ", ";
                echo $Lista->getValor();
                echo ", ";
                echo $Lista->getUsuario();
                echo ", ";
                echo $Lista->getDocumento();
                echo ", ";

                $TOTAL = $Lista->getValor() + $TOTAL;
                $totalline = 0;

                $partidaId = $Lista->getPartidaNo();
                if ($Lista->getTipo() == "Gasto") {
                    $ordenGa = GastoPagoQuery::create()
                            ->filterByBancoId($bancoQuer->getId())
                            ->filterByDocumento($Lista->getDocumento())
                            ->findOne();
                    if ($ordenGa) {
                        $partidaId = $ordenGa->getPartidaNo();
                    }
                }
                if ($Lista->getTipoMovimiento() == "Transferencia") {
                    $movimB = MovimientoBancoQuery::create()
                            ->filterByTipoMovimiento("Transferencia")
                            ->filterByDocumento($Lista->getDocumento())
                            // ->filterByBancoId($Lista->getBancoId())
                            ->filterByPartidaNo(0, Criteria::GREATER_THAN)
                            ->findOne();

                    if ($movimB) {
                        $partidaId = $movimB->getPartidaNo();
                    }
                }
                if ($Lista->getTipoMovimiento() == "Devolucion") {
                    $chequeq = ChequeQuery::create()
                            ->filterByBancoId($bancoQuer->getId())
                            ->filterByNumero($Lista->getDocumento())
                            ->findOne();
                    if ($chequeq) {
                        $partidaId = $chequeq->getOrdenDevolucion()->getPartidaNo();
                    }
                }
                if ($Lista->getVentaResumidaLineaId()) {
                    if ($Lista->getVentaResumidaLinea()->getVentaResumida()->getPartidaNo()) {
                        $partidaId = $Lista->getVentaResumidaLinea()->getVentaResumida()->getPartidaNo();
                    }
                }
                if (($Lista->getTipo() == "Cheque") && ($Lista->getTipoMovimiento() == "Gasto")) {


                    $chque = GastoPagoQuery::create()
                            ->filterByBancoId($bancoQuer->getId())
                            ->filterByDocumento($Lista->getDocumento())
                            ->filterByTipoPago("CHEQUE")
                            ->findOne();
                    if ($chque) {
                        $partidaId = $chque->getPartidaNo();
                    }
                }

                if ($Lista->getPartidaNo()) {
                    $partidaId = $Lista->getPartidaNo();
                }

                $PartidaDetalle = PartidaDetalleQuery::create()
                        ->orderByDetalle("Desc")
                        ->filterByPartidaId($partidaId)
                        //   ->filterByDebe(0, Criteria::GREATER_THAN)
                        ->find();
                foreach ($PartidaDetalle as $det) {
                    echo " <br>";
                    echo $det->getPartida()->getCodigo();

                    echo " , , , , ," . $det->getCuentaContable() . " -- " . $det->getDetalle() . " ," . $det->getDebe() . " ," . $det->getHaber();
                    if ($det->getCuentaContable() == $bancoQuer->getCuentaContable()) {
                        $TOTALCUENTA = $TOTALCUENTA + $det->getDebe();
                        $totalHaber = $totalHaber + $det->getHaber();

                        $totalline = $det->getDebe() - $det->getHaber();

                        echo "<br>";
                        echo $totalline . " " . $Lista->getValor();

                        if ($totalline <> $Lista->getValor()) {
                            echo "<font color='red'>DIFRENCIA </font>";
                        }
                    }
                }


                echo "<hr>";

                if ($partidaId) {
                    $Lista->setPartidaNo($partidaId);
                    $Lista->save();
                }
                echo "partida  id " . $partidaId;
                echo "<hr>";
            }
        }
        ECHO "<BR><BR><BR><BR>";
        ECHO "<STRONG> total " . $TOTAL . "</STRONG>";
        ECHO "<BR>";
        $TOTALCUENTA = $TOTALCUENTA - $totalHaber;
        ECHO "<STRONG> total debe " . $TOTALCUENTA . "</STRONG>";

        die();
    }

}
