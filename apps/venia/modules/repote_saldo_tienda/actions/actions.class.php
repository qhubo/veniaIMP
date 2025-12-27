<?php

/**
 * repote_saldo_tienda actions.
 *
 * @package    plan
 * @subpackage repote_saldo_tienda
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class repote_saldo_tiendaActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        
        $this->getResponse()->setContentType('charset=utf-8');
        $id = $request->getParameter('id');
        $text = 'FECHA';

        $file = "REPORTE_SALDOS_FECHA" . $text . ".csv";
 
        header('Expires: 0');
        header('Cache-control: private');
        header('Content-Type: application/x-octet-stream'); // Archivo de Excel
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
        header('Last-Modified: ' . date('D, d M Y H:i:s'));
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header("Content-Transfer-Encoding: binary");
        
        
        $cuenta = CuentaErpContableQuery::create()
                ->orderByCuentaContable("Asc")
//                ->where("SUBSTR(CuentaErpContable.CuentaContable, length(cuenta_contable)-1, 2) <> '00'")
//                ->where('length(CuentaErpContable.CuentaContable) >6 ')
                        ->where('(CuentaErpContable.CuentaContable) >=4010-00 ')
                ->where('(CuentaErpContable.CuentaContable) <8010-00 ')
                ->find();

        $bandera = '';
        $listaDoPrefi = null;
        foreach ($cuenta as $regitro) {
            $valores = explode("-", $regitro->getCuentaContable());
            $prefijo = $valores[0];
            $dta = null;
            $listaDoPrefi[$prefijo]['prefijo'] = $prefijo;
            $listaDoPrefi[$prefijo]['nombre'] = $regitro->getNombre();
            for ($i = 1; $i <= 12; $i++) {
                if ($i < 10) {
                    $listaDoPrefi[$prefijo]['cuentas'][$prefijo . "-0" . $i] = $prefijo . "-0" . $i;
                } else {
                    $listaDoPrefi[$prefijo]['cuentas'][$prefijo . "-" . $i] = $prefijo . "-" . $i;
                }
            }
        }

//        echo "<pre>";
//        print_r($listaDoPrefi);
//        die();
//       $linea=null;
        echo "Cuenta , Descripcion, 01,02,03,04,05,06,07,08,09,10,11,12";
         echo "\r\n";
        foreach ($listaDoPrefi as $regi) {
            echo $regi['prefijo'] . "," . $regi['nombre'];
            foreach ($regi['cuentas'] as $detalle) {
                echo ",".$this->saldo("2023-01-01", '2023-06-30', $detalle);
            }
            echo "\r\n";
        }
       die();
    }

    public function saldo($fechaInicio, $fechafin, $cuenta) {


        $Partidas = PartidaDetalleQuery::create()
                ->usePartidaQuery()
                ->endUse()
                ->filterByCuentaContable($cuenta)
                ->withColumn('sum(PartidaDetalle.Haber)', 'TotalHaber')
                ->withColumn('sum(PartidaDetalle.Debe)', 'TotalDebe')
//                ->where("(Partida.Mes) < '" . $mesl . "'")
//                ->where("(Partida.Ano) = '" . $ano . "'")
                ->where("Partida.FechaContable >= '". $fechaInicio. "'")
                ->where("Partida.FechaContable <= '". $fechafin ."'")
                ->findOne();

        $retorna = 0;
        if ($Partidas) {
            $debe = $Partidas->getTotalDebe();
            $haber = $Partidas->getTotalHaber();
            $retorna = $debe - $haber;
        }

        return $retorna;
    }

}
