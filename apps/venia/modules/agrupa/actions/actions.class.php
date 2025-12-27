<?php

/**
 * agrupa actions.
 *
 * @package    plan
 * @subpackage agrupa
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class agrupaActions extends sfActions {

    public function executeCuenta(sfWebRequest $request) {
        $cuentaEr = CuentaErpContableQuery::create()
                ->filterByUpdatedBy(null)
                ->setLimit(500)
                ->find();
        $can = 0;
        foreach ($cuentaEr as $registro) {
            $nombre = $registro->getNombre();
            $cuenta = $registro->getCuentaContable();
            $partidaDetlle = PartidaDetalleQuery::create()
                    ->filterByCuentaContable($cuenta)
                    ->find();
            foreach ($partidaDetlle as $li) {
                $can++;
                $li->setDetalle($nombre);
                $li->save();
            }
            $registro->setUpdatedBy('updated_by');
            $registro->save();
        }

        echo "actualizados " . $can;
        die();
    }

    public function executePendientes(sfWebRequest $request) {
        $can = Partida::Pendientes();
        echo " paridas confirmadas " . $can;
        die();
    }

    public function executeReporte(sfWebRequest $request) {
        $this->getResponse()->setContentType('charset=utf-8');
        date_default_timezone_set("America/Guatemala");
        $nombre = 'partidas_agrupados_mes_ano.csv';
        header('Expires: 0');
        header('Cache-control: private');
        header('Content-Type: application/x-octet-stream'); // Archivo de Excel
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
        header('Last-Modified: ' . date('D, d M Y H:i:s'));
        header('Content-Disposition: attachment; filename="' . $nombre . '"');
        header("Content-Transfer-Encoding: binary");
        $Datos = 'Partida,Fecha,Detalle,No Cuenta,Cuenta,Debe, Haber, Cantidad Partidas';
        $Datos .= "\r\n";

        $query = 'select a.codigo,a.fecha_contable,a.detalle, l.cuenta_contable,l.detalle as cuenta, debe, haber, cantidad from partida_agrupa a inner join partida_agrupa_linea l on l.partida_agrupa_id=a.id;';

        $con = Propel::getConnection();
        $stmt = $con->prepare($query);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $re) {
            $detalle = $re['detalle'];
            $detalle = str_replace(",", " ", $detalle);
            $cuenta = $re['cuenta'];
            $cuenta = str_replace(",", " ", $cuenta);

            $Datos .= $re['codigo'] . "," . $re['fecha_contable'] . "," . $detalle . "," . $re['cuenta_contable'] . "," . $cuenta . "," . $re['debe'] . "," . $re['haber'] . "," . $re['cantidad'];
            $Datos .= "\r\n";
        }


        $Datos .= "\r\n";

        echo $Datos;
        die();
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $ano = date('Y');
        $mes = '01';
        $dia = '01';
        $fecha = $ano . "-" . $mes . "-" . $dia;
        $paratidaQ = PartidaQuery::create()->filterByFechaContable($fecha)->findOne();
        $PARTIDAaPERTURA = $paratidaQ->getCodigo();
        $asientoAPERTURA = Parametro::CabeceraPartida($PARTIDAaPERTURA);
        Parametro::PartidaAgrupaApertura($asientoAPERTURA, $PARTIDAaPERTURA);
        Parametro::PartidaAgrupaDetalle($asientoAPERTURA, $PARTIDAaPERTURA);
        $partidaAgrupaLin = PartidaAgrupaLineaQuery::create()
                ->filterByHaber(0)
                ->filterByDebe(0)
                ->find();
        foreach ($partidaAgrupaLin as $line) {
            $line->delete();
        }
        die();
    }

}
