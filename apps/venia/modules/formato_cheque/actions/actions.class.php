<?php

/**
 * formato_cheque actions.
 *
 * @package    plan
 * @subpackage formato_cheque
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class formato_chequeActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        $id = $request->getParameter('id'); //=155555&

        $documentoCheque = DocumentoChequeQuery::create()->findOneById($id);
        $X = $documentoCheque->getAncho();
        $Y = $documentoCheque->getAlto();
        if ($request->getParameter('X')) {
            $X = $request->getParameter('X');
        }
        if ($request->getParameter('Y')) {
            $Y = $request->getParameter('Y');
        }
        $medidas = array($X, $Y);
        $pdf = new TCPDF('P', 'mm', $medidas, true, 'UTF-8', false);

    if (($X==0)  && ($Y==0)) {
         $pdf = new sfTCPDF("P", "mm", "Letter");
    }
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins($documentoCheque->getMargenIzquierdo(), $documentoCheque->getMargenSuperior());
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('VeniaLink');
        $pdf->SetTitle("Formato cheque");
        $pdf->SetSubject('Cheque,formato');
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('dejavusans', '', 11);
        $html = $documentoCheque->getFormato();
       $html = html_entity_decode($html);
        
//       echo $html;
//       die();

        //  $pdf->AddPage('P', $page_format, false, false);
        $pdf->AddPage();

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('Documento.' . $documentoCheque->getId() . '.pdf', 'I');
    }

    public function executeIndex(sfWebRequest $request) {
        $this->registros = DocumentoChequeQuery::create()->find();
    }

    public function executeMuestra(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $modulo = 'formato_cheque';
        $this->titulo = "Notificaciones Portal Usuario";
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usaurioQ = UsuarioQuery::create()->findOneById($usuarioId);
        sfContext::getInstance()->getUser()->setAttribute('usuario', null, 'nivel');
        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $default = null;

        $registro = DocumentoChequeQuery::create()->findOneById($Id);
        $default['activo'] = true;
        if ($registro) {
            $default['titulo'] = $registro->getTitulo(); // => Banco Industrial VOUCHER
            $default['tipo_negociable'] = $registro->getTipoNegociable(); //] => NoNegociable
            $default['banco'] = $registro->getBancoId(); //] => 4
            $default['ancho'] = $registro->getAncho(); //] => 100
            $default['alto'] = $registro->getAlto(); //] => 200
            $default['margen_superior'] = $registro->getMargenSuperior(); //] => 45
            $default['margen_izquierdo'] = $registro->getMargenIzquierdo(); //] => 50
            $default['observaciones'] = $registro->getFormato(); //] => TEXTO   AQUI  
            $default['activo'] = $registro->getActivo(); //] => on
            $default['correlativo']=$registro->getCorrelativo();
        }
        $this->registro = $registro;
        $this->form = new CreaPoliticaForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $nuevo = new DocumentoCheque();
                if ($registro) {
                    $nuevo = $registro;
                }
                $nuevo->setCorrelativo($valores['correlativo']);
                $nuevo->setTitulo($valores['titulo']);  // => Banco Industrial VOUCHER
                $nuevo->setTipoNegociable($valores['tipo_negociable']);  //] => NoNegociable
                $nuevo->setBancoId($valores['banco']);  //] => 4
                $nuevo->setAncho($valores['ancho']);  //] => 100
                $nuevo->setAlto($valores['alto']);  //] => 200
                $nuevo->setMargenSuperior($valores['margen_superior']);  //] => 45
                $nuevo->setMargenIzquierdo($valores['margen_izquierdo']);  //] => 50
                $nuevo->setFormato($valores['observaciones']);  //] => TEXTO   AQUI  
                $nuevo->setActivo($valores['activo']);  //] => o
                $nuevo->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect($modulo . '/muestra?id=' . $nuevo->getId());
            }
        }
    }

}
