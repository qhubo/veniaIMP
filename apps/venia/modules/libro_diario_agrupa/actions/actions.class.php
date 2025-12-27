<?php

/**
 * libro_salario_agrupa actions.
 *
 * @package    plan
 * @subpackage libro_salario_agrupa
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class libro_diario_agrupaActions extends sfActions {

    public function executeReportePdf(sfWebRequest $request) {
        $this->fecha = date('d/m/Y');
        $this->tiendaver = $request->getParameter('tiendaver');
        if ($request->getParameter('fecha')) {
            $this->fecha = $request->getParameter('fecha');
        }
        $fechaFin = explode('/', $this->fecha);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

        $listado = new VentaResumidaQuery();
        $listado->filterByFecha($fechaFin);
        $listado->useMedioPagoQuery();
        if ($this->tiendaver) {
            $listado->filterByTiendaId($this->tiendaver);
        }
        $cuotas = MedioPagoQuery::create()
                ->groupByNumeroCuotas()
                ->orderByNumeroCuotas()
                ->find();
        if ($request->getParameter('med')) {
            $medioPago = MedioPagoQuery::create()->findOneById($request->getParameter('med'));
            if ($medioPago) {
                $cuotas = MedioPagoQuery::create()
                        ->filterByNombre($medioPago->getNombre())
                        ->groupByNumeroCuotas()
                        ->orderByNumeroCuotas()
                        ->find();
                $listado->where("MedioPago.Nombre ='" . $medioPago->getNombre() . "'");
            }
        }
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoPart', null, 'consulta'));
        $operaciones = $this->datos($valores);
        $html = $this->getPartial('libro_diario_agrupa/reporte', array('operaciones' => $operaciones,
            "inicio" => $valores['fechaInicio'], "fin" => $valores['fechaFin']));

//echo $html;
//die();


        $PDF_HEADER_TITLE = "Libro Diario ";
        $PDF_HEADER_STRING = " " . $valores['fechaInicio'] . " AL " . $valores['fechaFin'];
        $PDF_HEADER_STRING .= '';
        $PDF_HEADER_LOGO = "logoC.png"; //Solo me funciona si esta dentro de la carpeta images de la libreria
        $nombre_archivo = "LIBRO DIARIO  DEL " . $valores['fechaInicio'] . " AL " . $valores['fechaFin'];
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle($nombre_archivo);
        $pdf->SetSubject('Libro Diario Contable');
        $pdf->SetKeywords('Libro,Contbale, Gasto , Compra'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetLeftMargin(3.5);
        $pdf->SetRightMargin(25);

//      $pdf->SetMargins(3, 5, 0, true);
        //$pdf->SetMargins(0, 25.5);
        $pdf->SetTopMargin(2.5);

//        $pdf->setHeaderMargin(0.10);

        $pdf->SetHeaderData($PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetHeaderMargin(0.1);
        $pdf->SetFooterMargin(0.1);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont('courier', '', 9);
        $pdf->AddPage();
        $pdf->writeHTML($html);
//        $pdf->writeHTMLCell($w=20, $h=20, $x=30, $y=10, $html, $border=1, $ln=1, $fill=false, $rese=true, $align='', $autopadding=false);
//        $pdf->writeHTMLCell(20, 20, 150, 10, "Paginana aoax", 1, 1, false, true, '', false);

        $pdf->Output($nombre_archivo . '.pdf', 'I');

        die('kk');
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoPart', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $bodegaId = null;
        if ($usuarioQue) {
            $bodegaId = $usuarioQue->getTiendaId();
        }
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('seleccionDatoPart', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('seleccionDatoPart', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccionDatoPart', null, 'consulta'));
                $this->redirect('libro_diario_agrupa/index');
            }
        }


        $valo = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccion', null, 'consulta'));

        if (!$valo) {

            $valo['mes_inicio'] = (int) date('m');
            $valo['anio_inicio'] = date('Y');
            sfContext::getInstance()->getUser()->setAttribute('seleccion', serialize($valo), 'consulta');
        }
        $this->forma = new ConsultaMesAnioForm($valo);
        if ($request->isMethod('post')) {
            $this->forma->bind($request->getParameter('periodo'));
            if ($this->forma->isValid()) {
                $valores = $this->forma->getValues();

//                echo "<pre>";
//                print_r($valores);
//                die();
                date_default_timezone_set("America/Guatemala");
                $ano = date('Y');
                $mes = '01';
                $dia = '01';
                $fecha = $ano . "-" . $mes . "-" . $dia;
                $paratidaQ = PartidaQuery::create()->filterByFechaContable($fecha)->findOne();
                $PARTIDAaPERTURA = $paratidaQ->getCodigo();
                $asientoAPERTURA = Parametro::CabeceraPartida($PARTIDAaPERTURA);
                Parametro::PartidaAgrupaApertura($asientoAPERTURA, $PARTIDAaPERTURA);
                $cantidad = Parametro::PartidaAgrupaDetalle($asientoAPERTURA, $PARTIDAaPERTURA, $valores['mes_inicio'], $valores['anio_inicio']);
                $partidaAgrupaLin = PartidaAgrupaLineaQuery::create()
                        ->filterByHaber(0)
                        ->filterByDebe(0)
                        ->find();
                foreach ($partidaAgrupaLin as $line) {
                    $line->delete();
                }

                $this->getUser()->setFlash('exito', 'Partidas agrupadadas ' . $cantidad);
                //    $this->getUser()->setFlash('exito', 'Usuario actualizada con exito ');
                $this->redirect('libro_diario_agrupa/index');
            }
        }




        $partidasAgrupa = PartidaAgrupaLineaQuery::create()
                ->groupByPartidaAgrupaId()
                ->withColumn('round(sum(round(PartidaAgrupaLinea.Haber,2)),2)', 'TotalHaber')
                ->withColumn('round(sum(round(PartidaAgrupaLinea.Debe,2)),2)', 'TotalDebe')
                ->find();

        foreach ($partidasAgrupa as $regi) {
            $partidaId = $regi->getPartidaAgrupaId();
            $totalHaber = $regi->getTotalDebe();
            $totalDebe = $regi->getTotalHaber();
//                echo $partidaId;
//                echo "<br>";
//                echo $totalDebe." ".$totalHaber;
            $diferencia = $totalHaber - $totalDebe;
            $diferencia = round($diferencia, 2);

            if (($diferencia > 0 )or ($diferencia < 0)) {
                $partidaDetalle = PartidaAgrupaLineaQuery::create()
                        ->filterByPartidaAgrupaId($partidaId)
                        ->orderByHaber('Desc')
                        ->findOne();
                $detalleId = $partidaDetalle->getId();
                $valorHaber = $partidaDetalle->getHaber();
                $valorHaberNuevo = $valorHaber + $diferencia;
                //               echo $detalleId." ".$valorHaber." ".$valorHaberNuevo;
                $partidaDetalle->setHaber($valorHaberNuevo);
                $partidaDetalle->save();
            }
        }
        $this->operaciones = $this->datos($valores);
//        echo "<pre>";
//        print_r($this->operaciones);
//        die();
    }

    public function datos($valores) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        // $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('selecciondato', null, 'consulta'));
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $operaciones = PartidaAgrupaLineaQuery::create();
        $operaciones->usePartidaAgrupaQuery();
      //  $operaciones->filterByEmpresaId($empresaId);
        $operaciones->where("PartidaAgrupa.EmpresaId = '" . $empresaId . "'");
        $operaciones->where("PartidaAgrupa.FechaContable >= '" . $fechaInicio . "'");
        $operaciones->where("PartidaAgrupa.FechaContable <= '" . $fechaFin . " 23:59:00" . "'");
        // $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones->orderByPartidaAgrupaId();
        $operaciones->orderByCuentaContable();
        $operaciones = $operaciones->find();
        return $operaciones;
    }

}
