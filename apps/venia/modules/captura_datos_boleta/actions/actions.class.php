<?php

/**
 * captura_datos_boleta actions.
 *
 * @package    plan
 * @subpackage captura_datos_boleta
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class captura_datos_boletaActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        
                    $acceso = MenuSeguridad::Acceso('captura_datos_boleta');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
        
        $id = $request->getParameter('id');
        $registro = SolicitudDepositoQuery::create()
                ->filterByEstatus('Autorizado')
                ->filterById($id)
                ->findOne();
        if (!$registro) {
            $this->redirect('captura_datos_boleta/index?tab=2');
        }

        $titulo = "Deposito Confirmado " . $registro->getCodigo();

        $html = $this->getPartial('captura_datos_boleta/reporte', array('registro' => $registro));

        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle($titulo);
        $pdf->SetSubject('Cobros Deposito Autorizado Ventas');
        $pdf->SetKeywords('Cobros Deposito Autorizado Ventas'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetMargins(5, 20, 5, true);

        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetHeaderMargin(0.1);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont('dejavusans', '', 13);
        $pdf->AddPage();
        $marca = 'images/marcaAgua99.png';
        $pdf->Image($marca, 550, 10, 0, 0, '', '', '', false, 100, 'C', false, false, 0);

        $pdf->writeHTML($html);

        $pdf->Output($titulo . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeElimina(sfWebRequest $request) {
        $id = $request->getParameter('id');
        //  die('a');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $usuario = SolicitudDepositoQuery::create()
                    ->filterByEstatus("Nuevo")
                    ->filterById($id)
                    ->findOne();
            //   BitacoraInternaQuery::nueva('Eliminacion', 'usuario', $usuario->getUsuario(), serialize($usuario), '', '', $id);

            $ua = $usuario->getCodigo();
            $usuario->delete();
            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('captura_datos_boleta/index?tab=2');
        }
        $this->getUser()->setFlash('error', 'Eliminacion de usuario ' . $ua . ' realizada con exito  ');
        $this->redirect('captura_datos_boleta/index?tab=2');
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioq = UsuarioQuery::create()->findOneById($usuarioId);
        $default['tienda_id'] = $usuarioq->getTiendaId();
        $default['fecha_deposito'] = date('d/m/Y');
        $default['banco_id'] = 6;
        $id = $request->getParameter('id');
        $this->tab = 1;
        if ($request->getParameter('tab')) {
            $this->tab = $request->getParameter('tab');
        }
        $this->id = $id;
        $this->form = new CapturaDatosBOleta($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $fechaFin = $valores['fecha_deposito'];
                $fechaFin = explode('/', $fechaFin);
                $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
                $nuevo = New SolicitudDeposito();
                $nuevo->setBancoId($valores['banco_id']);
                $nuevo->setTiendaId($valores['tienda_id']);
                $nuevo->setVendedor($valores['vendedor']);
                $nuevo->setFechaDeposito($fechaFin);
                $nuevo->setTotal($valores['total']);
                $nuevo->setCliente($valores['cliente']);
                $nuevo->setTelefono($valores['telefono']);
                $nuevo->setPieza($valores['pieza']);
                $nuevo->setStock($valores['stock']);
                $nuevo->setBoleta($valores['boleta']);
                $nuevo->setCreatedBy($usuarioq->getUsuario());
                $nuevo->setCreatedAt(date('Y-m-d H:i:s'));
                $nuevo->setEstatus("Nuevo");
                $con2 = Propel::getConnection();
                $con2->beginTransaction();
                try {
                    $nuevo->save();
                    $codigo = $nuevo->getCodigo();
                    $con2->commit();
                } catch (Exception $e) {
                    $con2->rollback();
                    if ($e->getMessage()) {
                        $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
                    }
                    $this->redirect('captura_datos/index');
                }
//                 sfContext::getInstance()->getUser()->setAttribute('modal', 1, 'seguridad');
                $this->getUser()->setFlash('exito', 'Solicitud de Boleta  ' . $codigo . ' ingresado con exito');
                $this->redirect('captura_datos_boleta/index?id=' . $codigo);
            }
        }


        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datosBoletaFE', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $fecha_actual = date("d-m-Y");
            $fecha = date("d/m/Y", strtotime($fecha_actual . "- 3 days"));
            $valores['fechaInicio'] = $fecha;
            $valores['fechaFin'] = date('d/m/Y');
            $valores['usuario'] = trim($usuarioQue->getUsuario());

            sfContext::getInstance()->getUser()->setAttribute('datosBoletaFE', serialize($valores), 'consulta');
        }
//        echo "<pre>";
//        print_r($valores);
//        die();
        $this->forma = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->forma->bind($request->getParameter('consulta'));
            if ($this->forma->isValid()) {
                $valores = $this->forma->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datosBoletaFE', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datosBoletaFE', null, 'consulta'));
                $this->redirect('captura_datos_boleta/index?tab=2');
            }
        }


        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

        $tipoUsuario = strtoupper($usuarioq->getTipoUsuario());
        $registros = new SolicitudDepositoQuery();
        if ($tipoUsuario != "ADMINISTRADOR") {
            $registros->filterByCreatedBy($usuarioq->getUsuario());
        }
        $registros->where("SolicitudDeposito.CreatedAt >= '" . $fechaInicio . " 01:00:00" . "'");
        $registros->where("SolicitudDeposito.CreatedAt <= '" . $fechaFin . " 23:23:00" . "'");
        $this->registros = $registros->find();
        $this->datosConfirmados = SolicitudDepositoQuery::create()
                ->filterByCreatedBy($usuarioq->getUsuario())
                ->filterByEstatus('Autorizado')
                ->orderById("Desc")
                ->setLimit(10)
                ->find();
    }

}
