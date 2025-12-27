<?php

/**
 * concilia_banco actions.
 *
 * @package    plan
 * @subpackage concilia_banco
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class concilia_bancoActions extends sfActions {

    public function executeConcilia(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $fecha = $request->getParameter('fecha');
        $bancoId = $request->getParameter('idv');
        $bancoQuer = BancoQuery::create()->findOneById($bancoId);
        $valor = $request->getParameter('id');
        sfContext::getInstance()->getUser()->setAttribute('valor'.$bancoId, $valor, 'seguridad');
        if ($fecha) {
        $ano = substr($fecha, 0, 4);
        $mes = substr($fecha, 4, 2);
        $dia = substr($fecha, -2);
        $fecha = $ano . "-" . $mes . "-" . $dia;
        }  
        if (!$fecha) {
            $fecha=date('Y-m-d');
        }
        $tasa = 1;
        if ($bancoQuer->getDolares()) {
        $tasaQ = TasaCambioQuery::create()->findOneByFecha($fecha);
        if (!$tasaQ) {
            $tasaQ = TasaCambioQuery::create()
                    ->where("TasaCambio.Fecha < '" . $fecha . "'")
                    ->findOne();
        }
        if ($tasaQ) {
            $tasa = $tasaQ->getValor();
       }
     
        }
        $acceso = MenuSeguridad::Acceso('concilia_banco');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
             $saldoEnLibros = round($bancoQuer->getSaldoLibros(), 2);
        if ($bancoQuer->getDolares()){
            $saldoEnLibros=$bancoQuer->getHSaldoLibros($fecha);
        }
        
        $diferencia = $valor * $tasa;
        $diferencia = round($diferencia, 2);
        $difencial = $saldoEnLibros - ($valor*$tasa);
        $difencial=round($difencial,2);
        $diferencia=$difencial;
        $saldoConciliado = round($bancoQuer->getSaldoTransitoBanco(), 2);
//        echo $saldoConciliado;
//        die();
   
      
        $ValorBanco = $valor + $saldoConciliado;
        $retorna = $ValorBanco - $saldoEnLibros;
        $retorna = round($retorna, 2);

        if ($bancoQuer->getDolares()) {
            $ValorBanco=$ValorBanco *$tasa;
            $ValorBanco=round($ValorBanco,2);
            $retorna=0;
        }
        $SaldoBancoQ = SaldoBancoQuery::create()
                ->filterByBancoId($bancoId)
                ->filterByFecha($fecha)
                ->findOne();
        if (!$SaldoBancoQ) {
            $SaldoBancoQ = new SaldoBanco();
            $SaldoBancoQ->setBancoId($bancoId);
            $SaldoBancoQ->setFecha($fecha);
            $SaldoBancoQ->save();
        }
        $SaldoBancoQ->setUsuario($usuarioQ->getUsuario());
        $SaldoBancoQ->setSaldoBanco($valor);

        $SaldoBancoQ->setSaldoLibro($saldoEnLibros);
        $SaldoBancoQ->setSaldoConciliado($ValorBanco);
        $SaldoBancoQ->setDiferencia($retorna);
        $SaldoBancoQ->save();
        $SaldoLibros = round($bancoQuer->getHSaldoLibros($fecha), 2);
 
        $SaldoBancoQ->setDepositoTransito(($bancoQuer->getDepositoTransito()));
        $SaldoBancoQ->setNotaCredito(($bancoQuer->getNotasCreditoTransito()));
        $SaldoBancoQ->setChequesCircula(($bancoQuer->getNotasChequesCircula()));
        $SaldoBancoQ->setNotaTransito(($bancoQuer->getNotasDebitoTransito()));
        $SaldoBancoQ->setDiferencial($diferencia);
        $SaldoBancoQ->save();
         
//         echo $difencial;
//         echo "--------";
//        echo $valor*$tasa;
//        die();

//        echo $retorna."|".$ValorBanco;
        
        echo $ValorBanco . "|" . $retorna . "|" . $diferencia;
        sfContext::getInstance()->getUser()->setAttribute('valor' . $bancoId, $ValorBanco, 'conciliado');
        sfContext::getInstance()->getUser()->setAttribute('valor' . $bancoId, $retorna, 'diferencia');
        die();
    }

    public function executeConfirmar(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        date_default_timezone_set("America/Guatemala");
        $acceso = MenuSeguridad::Acceso('concilia_banco');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }

        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $movi = $request->getParameter('movi');
        $ordenQ = BancoQuery::create()->findOneById($id);
        if ($ordenQ) {
            $tokenGuardado = sha1($ordenQ->getCodigo());
            if ($tokenGuardado == $token) {
//                $movimientos = MovimientoBancoQuery::create()
//                        ->filterByBancoId($id)
//                        ->filterByConfirmadoBanco(false)
//                        ->filterByRevisado(true)
//                        ->find();
//                
                $movimient = new MovimientoBancoQuery();
                $movimient->filterByConfirmadoBanco(false);
                $movimient->filterByRevisado(true);
                if ($id) {
                    $movimient->filterByBancoId($id);
                }

                if ($movi == 'deposito') {
                    $movimient->filterByTipo('Venta');
                    $movimient->useMedioPagoQuery();
                    $movimient->where("(MedioPago.nombre like  '%deposito%' or MedioPago.nombre like  '%credo%' or MedioPago.nombre like  '%visa%' )");
                }
                if ($movi == 'credito') {
                    $movimient->filterByTipo('credito');
                }
                if ($movi == 'cheque') {
                    $movimient->filterByTipo('cheque');
                }
                if ($movi == 'debito') {
                    $tipos[] = 'Debito';
                    $tipos[] = 'Gasto';
                    $tipos[] = 'Orden Compra';
                    $movimient->filterByTipo($tipos);
                }
                $movimientos = $movimient->find();
//        echo "<pre>";
//        print_r($movimientos);
//        die();



                $total = 0;
                foreach ($movimientos as $movimiento) {
                    $total = $total + $movimiento->getValor();
                    $BancoMovimiento = MovimientoBancoQuery::create()->findOneById($movimiento->getId());
                    $existe = CuentaBancoQuery::create()->findOneByMovimientoBancoId($BancoMovimiento->getId());
                    if (!$existe) {
                        $cxc = New CuentaBanco();
                        $cxc->setBancoId($movimiento->getBancoId());
                        $cxc->setMovimientoBancoId($movimiento->getId());
                        $cxc->setValor($movimiento->getValor());
                        $cxc->setFecha($movimiento->getCreatedAt());
                        $cxc->setDocumento($movimiento->getDocumento());
                        $cxc->setUsuario($movimiento->getUsuario());
                        $cxc->setCreatedAt($movimiento->getCreatedAt());
                        $cxc->setObservaciones($movimiento->getTipo());
                        $cxc->save();
                    }
                    $BancoMovimiento->setConfirmadoBanco(true);
                    $BancoMovimiento->setFechaConfirmoBanco(date('Y-m-d H:i:s'));
                    $BancoMovimiento->setUsuarioConfirmoBanco($usuarioQ->getUsuario());
                    $BancoMovimiento->save();
                }
                $valor = Parametro::formato($total, false);
                $this->getUser()->setFlash('exito', 'Movimientos confirmados banco ' . $ordenQ->getNombre() . " valor " . $valor);
            }
        }
        $this->redirect('concilia_banco/index?bancover=' . $id . "&movi=" . $movi);
    }

    public function executeVista(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $BancoQ = BancoQuery::create()->findOneById($id);
        $this->banco = $BancoQ;
    }

    public function suma($bancoId, $movi = null) {
        $valorTotal = 0;
        $movimient = new MovimientoBancoQuery();
        $movimient->filterByConfirmadoBanco(false);
        $movimient->filterByRevisado(true);
        if ($bancoId) {
            $movimient->filterByBancoId($bancoId);
        }
        $movimient->withColumn('sum(MovimientoBanco.Valor)', 'ValorTotal');
        if ($movi == 'deposito') {
            $movimient->filterByTipo('Venta');
            $movimient->useMedioPagoQuery();
            $movimient->where("MedioPago.Nombre like '%deposito%'");
        }
        if ($movi == 'credito') {
            $movimient->filterByTipo('credito');
        }
        if ($movi == 'cheque') {
            $movimient->filterByTipo('cheque');
        }
        if ($movi == 'debito') {
            $tipos[] = 'Debito';
            $tipos[] = 'Gasto';
            $tipos[] = 'Orden Compra';
            $movimient->filterByTipo($tipos);
        }
        $movimient->filterByMedioPagoId(27, Criteria::NOT_EQUAL);
        $movimiento = $movimient->findOne();
        if ($movimiento) {
            if ($movimiento->getValorTotal()) {
                $valorTotal = $movimiento->getValorTotal();
            }
        }
        return $valorTotal;
    }

    public function Pendiente($bancoId) {
        $TOTALSelec = 0;
        $TOTAL = 0;
        if ($bancoId) {
            $movimientosele = MovimientoBancoQuery::create()
                    ->filterByConfirmadoBanco(false)
                    ->filterByBancoId($bancoId)
                    ->filterByRevisado(true)
                    ->withColumn('sum(MovimientoBanco.Valor)', 'ValorTotal')
                    ->findOne();
//            echo "<pre>";
//            print_r($movimientosele);
//            echo "</pre>";
            if ($movimientosele) {
                if ($movimientosele->getValorTotal()) {
                    $TOTALSelec = $movimientosele->getValorTotal();
                }
            }

            $movimientoTodos = MovimientoBancoQuery::create()
                    ->filterByBancoId($bancoId)
                    ->filterByConfirmadoBanco(false)
                    ->withColumn('sum(MovimientoBanco.Valor)', 'ValorTotal')
                    ->findOne();
            if ($movimientoTodos) {
                if ($movimientoTodos->getValorTotal()) {
                    $TOTAL = $movimientoTodos->getValorTotal();
                }
            }
//            echo "<pre>";
//            print_r($movimientoTodos);
//            echo "</pre>";
        } else {
            $movimientosele = MovimientoBancoQuery::create()
                    ->filterByConfirmadoBanco(false)
                    ->filterByRevisado(true)
                    ->withColumn('sum(MovimientoBanco.Valor)', 'ValorTotal')
                    ->findOne();
//            echo "<pre>";
//            print_r($movimientosele);
//            echo "</pre>";
            if ($movimientosele) {
                if ($movimientosele->getValorTotal()) {
                    $TOTALSelec = $movimientosele->getValorTotal();
                }
            }

            $movimientoTodos = MovimientoBancoQuery::create()
                    ->filterByConfirmadoBanco(false)
                    ->withColumn('sum(MovimientoBanco.Valor)', 'ValorTotal')
                    ->findOne();
            if ($movimientoTodos) {
                if ($movimientoTodos->getValorTotal()) {
                    $TOTAL = $movimientoTodos->getValorTotal();
                }
            }
//            echo "<pre>";
//            print_r($movimientoTodos);
//            echo "</pre>";
        }







        $valorTotal = $TOTAL - $TOTALSelec;
        return $valorTotal;
    }

    public function executePendiente(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $bancoId = $request->getParameter('banco');
        $suma = $this->Pendiente($bancoId);
        echo Parametro::formato($suma, false);
        die();
    }

    public function executeActiva(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $bancoId = $request->getParameter('banco');
        $movi = $request->getParameter('movi');
        $activar = MovimientoBancoQuery::create()->findOneById($id);
        $activar->setRevisado(true);
        $activar->save();
        $suma = $this->suma($bancoId, $movi);
        echo Parametro::formato($suma, false);
        die();
    }

    public function executeDesactiva(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $bancoId = $request->getParameter('banco');
        $movi = $request->getParameter('movi');
        $activar = MovimientoBancoQuery::create()->findOneById($id);
        $activar->setRevisado(false);
        $activar->save();
        $suma = $this->suma($bancoId, $movi);
        echo Parametro::formato($suma, false);
        die();
    }

    public function executeIndex(sfWebRequest $request) {
        $acceso = MenuSeguridad::Acceso('concilia_banco');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }

        date_default_timezone_set("America/Guatemala");
        $this->ver = $request->getParameter('ver');
        $this->bancover = 0;
        if ($request->getParameter('bancover')) {
            $this->bancover = $request->getParameter('bancover');
        }
        $fechaINI = $request->getParameter('fechaINI');
        $fechaFIN = $request->getParameter('fechaFIN');
        if (!$fechaINI) {
            $fecha_actual = date("d-m-Y");
            $fechaINI = date("d/m/Y", strtotime($fecha_actual . "- 3 days"));
        }
        if (!$fechaFIN) {
            $fechaFIN = date('d/m/Y');
        }
        $this->fechaINI = $fechaINI;
        $this->fechaFIN = $fechaFIN;
        $this->movi = 'Todos';
        if ($request->getParameter('movi')) {
            $this->movi = $request->getParameter('movi');
        }
        $registros = new MovimientoBancoQuery();
        $registros->filterByConfirmadoBanco(false);

        if ($this->bancover) {
            $registros->filterByBancoId($this->bancover);
        }
        if ($this->movi == 'deposito') {
            $registros->filterByTipo('Venta');
            $registros->useMedioPagoQuery();
            $registros->where("MedioPago.Nombre like '%deposito%'");
        }
        if ($this->movi == 'credito') {
            $registros->filterByTipo('credito');
        }
        if ($this->movi == 'cheque') {
            $registros->filterByTipo('cheque');
        }
        if ($this->movi == 'debito') {
            $tipos[] = 'Debito';
            $tipos[] = 'Gasto';
            $tipos[] = 'Orden Compra';
            $registros->filterByTipo($tipos);
        }
        $fechaInicio = explode('/', $fechaINI);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = explode('/', $fechaFIN);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $registros->where("MovimientoBanco.FechaDocumento >= '" . $fechaInicio . " 00:00:00" . "'");
        $registros->where("MovimientoBanco.FechaDocumento <= '" . $fechaFin . " 23:59:00" . "'");
        $this->registros = $registros->find();

        $this->bancos = BancoQuery::create()
                ->filterByActivo(true)
                ->orderByNombre()
                ->find();
        $this->total = $this->suma($this->bancover, $this->movi);
        $this->banco = BancoQuery::create()->findOneById($this->bancover);
        $valores['todos'] = '[TODOS]';
        $valores['deposito'] = 'DEPOSITO';
        $valores['credito'] = 'CREDITO';
        $valores['cheque'] = 'CHEQUE';
        $valores['debito'] = 'DÉBITO';
        $this->movimientos = $valores;
    }

}
