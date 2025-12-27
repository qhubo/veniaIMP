<?php

/**
 * crea_contrasena actions.
 *
 * @package    plan
 * @subpackage crea_contrasena
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class crea_contrasenaActions extends sfActions {

  



    public function executeReporte(sfWebRequest $request) {

        $id = $request->getParameter('id');
        $contranse = ContrasenaCreaQuery::create()->findOneById($id);
        $lista = CuentaProveedorQuery::create()
                ->filterByContrasenaNo($contranse->getId())
                ->find();
        $logo = $contranse->getEmpresa()->getLogo();
        $titulo = ' ';
        $referencia = "" . $contranse->getCodigo();
        $observaciones = "Anillo Periferico 3-00 zona 3 "; //. $ordenCompra->getTipoDocumento()." ".$ordenCompra->getDocumento()."";
        $nombre2 = 'Guatemala';
        $html = $this->getPartial('reporte/encabezado', array('nombre2' => $nombre2, 'logo' => $logo, 'titulo' => $titulo, 'observaciones' => $observaciones, 'referencia' => $referencia));
        $html .= $this->getPartial('crea_contrasena/reporte', array('contranse' => $contranse, 'lista' => $lista));
//
//        echo $html;
//        die();
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle($titulo . " " . $referencia);
        $pdf->SetSubject('Contraseña Gasto');
        $pdf->SetKeywords('Contraseña,Gasto,Cuenta'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetMargins(3, 5, 0, true);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetHeaderMargin(0.1);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont('dejavusans', '', 9);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $pdf->Output('Contraseña' . $contranse->getCodigo() . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeConfirmar(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $registros = CuentaProveedorQuery::create()
                      ->useProveedorQuery()
                ->endUse()
                ->filterByContrasenaNo(0)
//               ->groupByFecha()
                ->groupByProveedorId()
                ->find();
        $can = 0;
        foreach ($registros as $data) {
            $can++;
            $proveedorId = $data->getProveedorId();
            $fecha = $data->getFecha();
            $contranueva = new ContrasenaCrea();
            $contranueva->setFecha(date('Y-m-d'));
            $dias = 15;
            if ($data->getProveedor()->getDiasCredito()) {
                $dias = $data->getProveedor()->getDiasCredito();
            }
            $contranueva->setDiasCredito($dias);
            $contranueva->setProveedorId($proveedorId);
            $contranueva->setFechaPago(Parametro::ProximoFechaPago(date('Y-m-d'), $dias));
            $contranueva->setEstatus("Nueva");
            $contranueva->save();
            $cuenta = CuentaProveedorQuery::create()
//                    ->filterByFecha($fecha)
                    ->filterByProveedorId($proveedorId)
                    ->filterByContrasenaNo(0)
                    ->find();
            $valorTotal = 0;
            foreach ($cuenta as $lista) {
                $lista->setContrasenaNo($contranueva->getId());
                $lista->save();
                $valorTotal = $valorTotal + $lista->getValorTotal();
            }
            $contranueva->setValor($valorTotal);
            $contranueva->save();
        }


        $this->getUser()->setFlash('exito', $can . ' Contraseñas creadas con exito ');
        $this->redirect('crea_contrasena/index');
    }

    public function executeIndex(sfWebRequest $request) {
        $this->registros = CuentaProveedorQuery::create()
                ->useProveedorQuery()
                ->endUse()
                ->filterByContrasenaNo(0)
                ->orderBy('Proveedor.Nombre')
                ->find();

        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('selectcontra', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $bodegaId = null;
        if ($usuarioQue) {
            $bodegaId = $usuarioQue->getTiendaId();
        }
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('selectcontra', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('selectcontra', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('selectcontra', null, 'consulta'));
                $this->redirect('crea_contrasena/index');
            }
        }

        $this->contrasenas = ContrasenaCreaQuery::create()
                ->find();
    }

}
