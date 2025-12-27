<?php

/**
 * poliza_recibe actions.
 *
 * @package    plan
 * @subpackage poliza_recibe
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class poliza_recibeActions extends sfActions {

    public function executePartida(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
         $EMPRESAID=1;
        $DATA = $request->getParameter('DATA');
        $ASIENTO = $request->getParameter('ASIENTO');
        $POLIZA= $request->getParameter('POLIZA');
        $FECHA_PARTIDA = $request->getParameter('FECHA_PARTIDA');
        $fechaInicio = explode('/', $FECHA_PARTIDA);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
       
//        echo $DATA;
//        die();
        if ($DATA <> "") {
            $new = new Facturas();
            $new->setTipoDocumento('POLIZA');
           // $new->setMotivo(serialize($DATA));
            $new->setFecha($fechaInicio);
            $new->save();
//            $facturaQ = FacturasQuery::create()->findOneById(14178);
//            $DATA = unserialize($facturaQ->getMotivo());
//convert xml string into an object
            $xml = simplexml_load_string($DATA);
//convert into json
            $json = json_encode($xml);
//convert into associative array
            $cont=0;
            $xmlArr = json_decode($json, true);
             $pendiente = PartidaQuery::create()
                        ->filterByCodigo($ASIENTO)
                        ->filterByEmpresaId($EMPRESAID)
                        ->findOne();
             
             if ($pendiente) {
                 $detalles = PartidaDetalleQuery::create()
                         ->filterByPartidaId($pendiente->getId())
                         ->find();
                 if ($detalles) {
                     $detalles->delete();
                 }
             }
             
             
            foreach ($xmlArr['REGISTRO'.$POLIZA] as $registro) {
           
                $TIPO = $request->getParameter('TIPO_POLIZA');  // => Planilla
               
                $TIPO = str_replace($POLIZA, "", $TIPO);
                $TIPO = str_replace("-", "", $TIPO);

                $CUENTA =(string) $registro['CUENTA'];  // => 6029-01
               // $DOCUMENTO =  $registro['DOCUMENTO'];  // => Array
                
                $DETALLE = $registro['DETALLE'];  // => Aguinaldo
                $DEBE = $registro['DEBE'];  // => 1194.83
                $HABER = $registro['HABER'];  // => 0.00
                
//                     echo "<pre>";
//                print_r($registro);
//                die();
                $cont++;
                $pendiente = PartidaQuery::create()
                        ->filterByCodigo($ASIENTO)
                        ->filterByEmpresaId($EMPRESAID)
                        ->findOne();
                if (!$pendiente) {
                    $pendiente = new Partida();
                    $pendiente->setEstatus('Proceso');
                    $pendiente->setUsuario("CARGA");
                    $pendiente->setCodigo($ASIENTO);
                    $pendiente->setEmpresaId($EMPRESAID);
                    $pendiente->save();
                }
                $pendiente->setFechaContable($fechaInicio);
                $pendiente->setMes($pendiente->getFechaContable('M'));
                $pendiente->setAno($pendiente->getFechaContable('Y'));
                $pendiente->setTipo($TIPO);
                $pendiente->setTipoPartida('PLANILLA');
                $pendiente->setTipoNumero('PLANILLA '.$POLIZA);
                $pendiente->setDetalle($DETALLE);
                $pendiente->save();
              
                
                $cuentaQ = CuentaErpContableQuery::create()
                        ->filterByEmpresaId($EMPRESAID)
                        ->filterByCuentaContable($CUENTA)
                        ->findOne();
                if ($cuentaQ) {
                $cuenta = $cuentaQ->getCuentaContable();
                $nombreCuenta = $cuentaQ->getNombre();
                }
                $partidaNe = new PartidaDetalle();
                $partidaNe->setEmpresaId($EMPRESAID);
                $partidaNe->setPartidaId($pendiente->getId());
                $partidaNe->setCuentaContable($cuenta);
                $partidaNe->setDetalle($nombreCuenta);
                $partidaNe->setDebe(0);
                $partidaNe->setHaber(0);
                if ($DEBE) {
                    $partidaNe->setDebe(round($DEBE, 2));
                }
                if ($HABER) {
                    $partidaNe->setHaber(round($HABER, 2));
                }
                $partidaNe->save();
            }

            $Partidas = PartidaDetalleQuery::create()
                    ->filterByEmpresaId($EMPRESAID)
                    ->filterByPartidaId($pendiente->getId())
                    ->withColumn('sum(PartidaDetalle.Debe)', 'ValorTotal')
                    ->findOne();
            if ($Partidas) {
                $pendiente->setConfirmada(true);
                $pendiente->setEstatus('Cerrada');
                $pendiente->setValor($Partidas->getValorTotal());
                $pendiente->save();
            }
    echo $pendiente->getId();
    die();
        }
//   
//   
die('aqui');
//   
//   
//   
    }

}
