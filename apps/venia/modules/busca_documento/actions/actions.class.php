<?php

/**
 * busca_documento actions.
 *
 * @package    plan
 * @subpackage busca_documento
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class busca_documentoActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
              date_default_timezone_set("America/Guatemala");
        $NoDTE = sfContext::getInstance()->getUser()->getAttribute('seleN', null, 'consulta');
        $default['numero'] = $NoDTE;
        $this->form = new ConsultaNumeroForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $numero = $valores['numero'];
                sfContext::getInstance()->getUser()->setAttribute('seleN', $numero, 'consulta');
                $NoDTE = sfContext::getInstance()->getUser()->getAttribute('seleN', null, 'consulta');
                $this->getUser()->setFlash('exito', 'Consulta realizada ');
                $this->redirect('busca_documento/index?id=1');
            }
        }

        if (trim($NoDTE) == "") {
            $NoDTE = "0000000000000000000000";
        }



        $ordenPago = GastoQuery::create()
                ->filterByDocumento('%' . $NoDTE . "%")
                ->useProveedorQuery()
                ->endUse()
                ->find();
        $registros = null;
        foreach ($ordenPago as $data) {
            $docu = $data->getDocumento();
          $docu = str_replace($NoDTE, "<font color='blue' size='+1'><strong>".$NoDTE."</strong></font>", $docu);

            $lista['TIPO'] = 'GASTO';
            $lista['ID'] = $data->getId();
            $lista['CODIGO'] = $data->getCodigo();
            $lista['ESTATUS'] = $data->getEstatus();
            $lista['FECHA'] = $data->getFecha('d/m/Y');
            $lista['PROVEEDOR_ID'] = $data->getProveedorId();
            $lista['PROVEEDOR'] = $data->getProveedor()->getNombre();
            $lista['TOTAL'] = $data->getValorTotal();
            $lista['PARTIDA_NO'] = $data->getPartidaNo();
            $lista['TIPO_DOCUMENTO'] = $data->getTipoDocumento();
            $lista['DOCUMENTO'] =$docu;
            $lista['CONFRONTADO'] = $data->getConfrontadoSat();
            $lista['NO_SAT'] = '';
            $sta = CargaComprasSatQuery::create()->findOneById($data->getNoSat());
            if ($sta) {

                $lista['NO_SAT'] = $sta->getAutorizacion();
                $lista["numero="] = $sta->getAutorizacion();
                $lista["emisor"] = $sta->getNitEmisor();
                $lista["receptor"] = 7933053; // . $receptor  
                $lista["monto"] = $sta->getMonto();
            }


            $gastoPago = GastoPagoQuery::create()->filterByGastoId($data->getId())->find();
            $pagos = null;
            foreach ($gastoPago as $pago) {
                $dtPago = null;
                $dtPago['id'] = $pago->getId();
                $dtPago['fecha'] = $pago->getFecha('d/m/Y');
                $dtPago['usuario'] = $pago->getUsuario();
                $dtPago['partida_no'] = $pago->getPartidaNo();
                $dtPago['banco'] = null;
                if ($pago->getBancoId()) {
                    $dtPago['banco'] = $pago->getBanco()->getNombre();
                }
                $dtPago['cheque_id'] = $pago->getChequeId();
                $dtPago['tipo_pago'] = $pago->getTipoPago();
                $dtPago['documento'] = $pago->getDocumento();
                if ($pago->getChequeId()) {
                    $dtPago['documento'] = $pago->getCheque()->getNumero();
                }
                $dtPago['valor_total'] = $pago->getValorTotal();
                $pagos[] = $dtPago;
            }
            $lista['PAGOS'] = $pagos;
            if ($data->getPartidaNo()) {
                $registros[] = $lista;
            }
        }


        $ordenProveedor = OrdenProveedorQuery::create()
                ->filterByNoDocumento('%' . $NoDTE . "%")
                ->find();

        foreach ($ordenProveedor as $data) {
            
                        $docu = $data->getSerie() . " " . $data->getNoDocumento();
             $docu = str_replace($NoDTE, "<font color='blue' size='+1'><strong>".$NoDTE."</strong></font>", $docu);



            
            $lista = null;
            $lista['TIPO'] = 'ORDEN COMPRA';
            $lista['ESTATUS'] = $data->getEstatus();
            $lista['ID'] = $data->getId();
                     $lista['CODIGO'] = $data->getCodigo();
            $lista['FECHA'] = $data->getFecha('d/m/Y');
            $lista['PROVEEDOR_ID'] = $data->getProveedorId();
            $lista['PROVEEDOR'] = $data->getProveedor()->getNombre();
            $lista['TOTAL'] = $data->getValorTotal();
            $lista['PARTIDA_NO'] = $data->getPartidaNo();
            $lista['TIPO_DOCUMENTO'] = '';
            $lista['DOCUMENTO'] = $docu;
            $lista['CONFRONTADO'] = $data->getConfrontadoSat();
            $lista['NO_SAT'] = '';
            $sta = CargaComprasSatQuery::create()->findOneById($data->getNoSat());
            if ($sta) {
                $lista['NO_SAT'] = $sta->getAutorizacion();
                $lista["numero="] = $sta->getAutorizacion();
                $lista["emisor"] = $sta->getNitEmisor();
                $lista["receptor"] = 7933053; // . $receptor  
                $lista["monto"] = $sta->getMonto();
            }



            $gastoPago = OrdenProveedorPagoQuery::create()->filterByOrdenProveedorId($data->getId())->find();
            $pagos = null;
            foreach ($gastoPago as $pago) {
         
            
                $dtPago = null;
                $dtPago['id'] = $pago->getId();
                $dtPago['fecha'] = $pago->getFecha('d/m/Y');
                $dtPago['usuario'] = $pago->getUsuario();
                $dtPago['partida_no'] = $pago->getPartidaNo();
                $dtPago['banco'] = null;
                if ($pago->getBancoId()) {
                    $dtPago['banco'] = $pago->getBanco()->getNombre();
                }
                $dtPago['cheque_id'] = $pago->getChequeId();
                $dtPago['tipo_pago'] = $pago->getTipoPago();
                $dtPago['documento'] = $pago->getDocumento();
                if ($pago->getChequeId()) {
                    $dtPago['documento'] = $pago->getCheque()->getNumero();
                }
                $dtPago['valor_total'] = $pago->getValorTotal();
                $pagos[] = $dtPago;
            }
            $lista['PAGOS'] = $pagos;

            $registros[] = $lista;
        }





        $gastoCajaDetalle = GastoCajaDetalleQuery::create()
        
                ->filterByFactura('%' . $NoDTE . "%")
                ->find();
        foreach ($gastoCajaDetalle as $data) {
                                       $docu = $data->getSerie() . " " . $data->getFactura();
                    $docu = str_replace($NoDTE, "<font color='blue' size='+1'><strong>".$NoDTE."</strong></font>", $docu);


            
            $lista = null;
            $lista['TIPO'] = 'GASTO CAJA';
            $lista['ESTATUS'] = $data->getGastoCaja()->getEstatus();
        //                $lista['CODIGO'] = $data->getGastoCaja()->getCodigo();
            $lista['ID'] = $data->getId();
            $lista['FECHA'] = $data->getFecha('d/m/Y');
            $lista['PROVEEDOR_ID'] = $data->getProveedorId();
            $lista['PROVEEDOR'] = $data->getProveedor()->getNombre();
            $lista['TOTAL'] = $data->getValor();
            $lista['PARTIDA_NO'] = $data->getGastoCaja()->getPartidaNo();
            $lista['TIPO_DOCUMENTO'] = $data->getSerie();
            $lista['DOCUMENTO'] = $docu;
            $lista['CONFRONTADO'] = $data->getConfrontadoSat();
            $lista['NO_SAT'] = '';
            $sta = CargaComprasSatQuery::create()->findOneById($data->getNoSat());
            if ($sta) {
                $lista['NO_SAT'] = $sta->getAutorizacion();
                $lista['NO_SAT'] = $sta->getAutorizacion();
                $lista["emisor"] = $sta->getNitEmisor();
                $lista["receptor"] = 7933053; // . $receptor  
                $lista["monto"] = $sta->getMonto();
            }


            $pagos = null;
            $GastoQ = GastoQuery::create()->findOneByCodigo('Caja'.$data->getGastoCajaId());
            if ($GastoQ){
            $gastoPago = GastoPagoQuery::create()->filterByGastoId($GastoQ->getId())->find();
            foreach ($gastoPago as $pago) {
                $dtPago = null;
                $dtPago['id'] = $pago->getId();
                $dtPago['fecha'] = $pago->getFecha('d/m/Y');
                $dtPago['usuario'] = $pago->getUsuario();
                $dtPago['partida_no'] = $pago->getPartidaNo();
                $dtPago['banco'] = null;
                if ($pago->getBancoId()) {
                    $dtPago['banco'] = $pago->getBanco()->getNombre();
                }
                $dtPago['cheque_id'] = $pago->getChequeId();
                $dtPago['tipo_pago'] = $pago->getTipoPago();
                $dtPago['documento'] = $pago->getDocumento();
                if ($pago->getChequeId()) {
                    $dtPago['documento'] = $pago->getCheque()->getNumero();
                }
                $dtPago['valor_total'] = $pago->getValorTotal();
                $pagos[] = $dtPago;
            }
            }
            $lista['PAGOS'] = $pagos;
            $registros[] = $lista;
        }
        $this->registros = $registros;
//            echo "<pre>";
//        print_r($registros);
//        die();
    }

}
