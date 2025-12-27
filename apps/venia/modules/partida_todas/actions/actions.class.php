<?php

/**
 * partida_manual actions.
 *
 * @package    plan
 * @subpackage partida_manual
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class partida_todasActions extends sfActions {

    public function executeCarga(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $this->getResponse()->setContentType('charset=utf-8');
        $id = $request->getParameter('id');
        $this->id = $id;
        $datos = CuentaErp::pobladatosPartida($id, true);
        if (!$datos['valido']) {
            $texto = $datos['pendiente'];
            $textol = implode(' , ', $texto);
            $this->getUser()->setFlash('error', 'Las siguiente columnas no fueron encontradas: ' . $textol);
            $this->redirect('partida_todas/index');
        }

        $this->datos = $datos;

//     $this->redirect('partida_manual/index?carga=1');
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

        $filename = "Archivo_Carga_VariasPartidas_" . date("Ymd");
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
        $encabezados[] = array("Nombre" => 'cuenta', "width" => 35, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'descripcion', "width" => 35, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'asiento', "width" => 35, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'documento', "width" => 40, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'fecha', "width" => 15, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'tipo', "width" => 15, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'numero', "width" => 15, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'detalle', "width" => 15, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'debe', "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => 'haber', "width" => 15, "align" => "left", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $hoja->getStyle('A2:F2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('819BFB');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
//          die();
        $xl->save('php://output');
        die();
        throw new sfStopException();
    }

    public function executeConfirmar(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $datos = CuentaErp::pobladatosPartida($id, true);
        $token = $request->getParameter('token');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $partidaDella = PartidaDetalleQuery::create()
                ->usePartidaQuery()
                ->filterByEstatus('Proceso')
                ->filterByUsuario($usuarioQ->getUsuario())
                ->endUse()
                ->find();
        foreach ($partidaDella as $linea) {
            $partidaDe = PartidaDetalleQuery::create()->findOneById($linea->getId());
            $partidaDe->delete();
        }
        $cont = 0;
        foreach ($datos['datos'] as $reg) {
            $fecha = $reg['FECHA'];
//            echo $fecha;
//            die();
//            die();
            $fecha = date("Y-m-d", strtotime($reg['FECHA']));
//            echo $fecha;
//            die();
            $cont++;
            $pendiente = PartidaQuery::create()
//                    ->filterByEstatus('Proceso')
//                    ->filterByUsuario($usuarioQ->getUsuario())
                    ->filterByCodigo($reg['ASIENTO'])
                    ->findOne();
            if (!$pendiente) {
                $pendiente = new Partida();
                $pendiente->setEstatus('Proceso');
                $pendiente->setUsuario($usuarioQ->getUsuario());
                $pendiente->setCodigo($reg['ASIENTO']);
                $pendiente->save();
            }
            $pendiente->setFechaContable($fecha);
            $pendiente->setMes($pendiente->getFechaContable('M'));
            $pendiente->setAno($pendiente->getFechaContable('Y'));

            $pendiente->setTipo($reg['DOCUMENTO']);
            $pendiente->setTipoPartida($reg['TIPO']);
            $pendiente->setTipoNumero($reg['NUMERO']);
            $pendiente->setDetalle($reg['DETALLE']);
            // $pendiente->save();


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
        $pendientes = PartidaQuery::create()
                ->filterByEstatus('Proceso')
                ->filterByUsuario($usuarioQ->getUsuario())
                ->find();
        foreach ($pendientes as $pendiente) {
            $Partidas = PartidaDetalleQuery::create()
                    ->filterByPartidaId($pendiente->getId())
                    ->withColumn('sum(PartidaDetalle.Debe)', 'ValorTotal')
                    ->findOne();
            if ($Partidas) {
                $pendiente->setConfirmada(true);
                $pendiente->setEstatus('Cerrada');
                $pendiente->setValor($Partidas->getValorTotal());
                $pendiente->save();
            }
//            echo "<pre>";
//            print_r($pendiente);
//            echo "</pre>";
        }
        $this->getUser()->setFlash('exito', 'Partidas cargadas con exito   ');
        $this->redirect('partida_todas/index');
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $defaulta['fecha'] = date('d/m/Y');
        if ($request->getParameter('edit')) {
            $edit = $request->getParameter('edit');
        }
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
    }

}
