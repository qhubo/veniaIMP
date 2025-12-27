<?php

/**
 * libro_balance actions.
 *
 * @package    plan
 * @subpackage libro_balance
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class libro_balanceActions extends sfActions {

    public function executeObserva(sfWebRequest $request) {

        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $val = $request->getParameter('val');
        $empresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $empresaQ->setObservaciones($val);
        $empresaQ->save();
        die('aa');
    }

    public function executeReporte(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");

        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $empresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $observaciones = $empresaQ->getObservaciones();
        $this->d = $request->getParameter('d');
        $fechaFin = sfContext::getInstance()->getUser()->getAttribute('fecha', null, 'consulta');

        $registros = LibroAgrupadoQuery::create()->filterByTipo('Libro Balance')->orderByOrden()->find();
        $resultado = $this->resultado($fechaFin);

        $arfechaFin = explode("-", $fechaFin);
        $mes[1] = 'Enero';
        $mes[2] = 'Febrero';
        $mes[3] = 'Marzo';
        $mes[4] = 'Abril';
        $mes[5] = 'Mayo';
        $mes[6] = 'Junio';
        $mes[7] = 'Julio';
        $mes[8] = 'Agosto';
        $mes[9] = 'Septiembre';
        $mes[10] = 'Octubre';
        $mes[11] = 'Noviembre';
        $mes[12] = 'Diciembre';
        $n = (int) $arfechaFin[1];

        $fechadet = $arfechaFin[2] . " de " . $mes[$n] . "  del " . $arfechaFin[0];

        $html = $this->getPartial('libro_balance/reporte', array('fechafin' => $fechaFin,
            'registros' => $registros, 'resultado' => $resultado, 'd' => $this->d,
            'observaciones' => $observaciones, 'fechadet' => $fechadet
        ));
//       echo $html;
//       die();


        $PDF_HEADER_TITLE = "Libro Contable  ";
        $PDF_HEADER_STRING = " Balance General al  " . $fechaFin;
        $PDF_HEADER_LOGO = "logoC.png"; //Solo me funciona si esta dentro de la carpeta images de la libreria
        $nombre_archivo = "  LIBRO_BALANCE AL " . $fechaFin;
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle($nombre_archivo);
        $pdf->SetSubject('Libro Diario Contable');
        $pdf->SetKeywords('Libro,Contable, Mayor, Balance'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        //      $pdf->SetMargins(3, 5, 0, true);
        $pdf->SetMargins(3, 20);
        $pdf->SetHeaderData($PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//        $pdf->SetHeaderMargin(0.1);
//        $pdf->SetFooterMargin(0.1);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetFont('courier', '', 9);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $pdf->Output($nombre_archivo . '.pdf', 'I');

        die();
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $this->fecha = date('d/m/Y');
        if ($request->getParameter('fecha')) {
            $this->fecha = $request->getParameter('fecha');
        }
        $fechaFin = explode('/', $this->fecha);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $this->fechafin = $fechaFin;
        $this->registros = LibroAgrupadoQuery::create()->filterByTipo('Libro Balance')->orderByOrden()->find();
        $this->resultado = $this->resultado($fechaFin);

        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $empresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $this->observaciones = $empresaQ->getObservaciones();
        sfContext::getInstance()->getUser()->setAttribute('fecha', $fechaFin, 'consulta');
    }

    public function resultado($fechaFin) {
//        $fechaFin='2023-03-21';
        $operaciones = $this->datos($fechaFin, 4);
        $total4 = 0;
        foreach ($operaciones as $registro) {
            $cuenta = 4;  //registro->getCuentaContable();
            $total4 = ($registro->getTotalHaber() - $registro->getTotalDebe()) + $total4;
        }
        $total4 = $total4 * -1;
        $datos['cuenta'] = $cuenta;
        $datos['monto'] = $total4;
        $datos['detalle'] = "<strong>Ventas Netas</strong>";
        $listaDatos[$cuenta][] = $datos;
        $listaCuentas[$cuenta] = $cuenta;

        $operaciones = $this->datos($fechaFin, 5);
        $total5 = 0;
        foreach ($operaciones as $registro) {
            $cuenta = 5;  //registro->getCuentaContable();
            $total5 = ($registro->getTotalHaber() - $registro->getTotalDebe()) + $total5;
        }
        $total5 = $total5 * -1;
        $datos['cuenta'] = $cuenta;
        $datos['monto'] = $total5;
        $datos['detalle'] = "<strong>Costo de ventas</strong>";
        $listaDatos[$cuenta][] = $datos;
        $listaCuentas[$cuenta] = $cuenta;
        $operaciones = $this->datos($fechaFin, null);
        $total6 = 0;
        $total7 = 0;
        foreach ($operaciones as $registro) {
            $cuenta = $registro->getCuentaContable();
            $monto = $registro->getTotalHaber() - $registro->getTotalDebe();
            $monto = $monto * -1;
            if (substr($cuenta, 0, 1) == 6) {
                $total6 = $total6 + $monto;
            }
            if (substr($cuenta, 0, 1) == 7) {
                $total7 = $total7 + $monto;
            }
            $datos['cuenta'] = $cuenta;
            $datos['monto'] = $monto;
            $datos['detalle'] = $registro->getDetalle();
            $listaDatos[$cuenta][] = $datos;
            $listaCuentas[$cuenta] = $cuenta;
        }
        $totalEjercicio = $total4 + $total5 + $total6 + $total7;
        return $totalEjercicio;
//        echo $totalEjercicio;
//        echo "<pre>";
//        print_r($listaDatos);
//        echo "</pre>";
//        die();
    }

    public function datos($fechaFin, $tipo = null) {
        // $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('selecciondato', null, 'consulta'));
        $ValoresFecha = explode('-', $fechaFin);
        $anoInicio = $ValoresFecha[0];
        $fechaInicio = $anoInicio . "-01-01";
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $operaciones = PartidaDetalleQuery::create();
        $operaciones->usePartidaQuery();
        $operaciones->where("Partida.FechaContable >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Partida.FechaContable <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones->where("substring(PartidaDetalle.CuentaContable,1,1) >3");
        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->withColumn('sum(PartidaDetalle.Debe)', 'TotalDebe');
        $operaciones->withColumn('sum(PartidaDetalle.Haber)', 'TotalHaber');
        if ($tipo) {
            $operaciones->where("substring(PartidaDetalle.CuentaContable,1,1) =" . $tipo);
        } else {
            $operaciones->where("substring(PartidaDetalle.CuentaContable,1,1)  not in (4,5)");
        }

        $operaciones->groupBy('PartidaDetalle.CuentaContable');
        $operaciones = $operaciones->find();
        return $operaciones;
    }

}
