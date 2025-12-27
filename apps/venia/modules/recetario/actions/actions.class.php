<?php

/**
 * recetario actions.
 *
 * @package    plan
 * @subpackage recetario
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class recetarioActions extends sfActions
{
  public function executeEliminar(sfWebRequest $request) {
     $id = $request->getParameter('id');
      $recetarioDetalle = RecetarioDetalleQuery::create()
              ->filterByRecetarioId($id)
              ->find();
      if ($recetarioDetalle) {
          $recetarioDetalle->delete();
      }
      $receta = RecetarioQuery::create()->findOneById($id);
      if ($receta) {
          $receta->delete();
      }
              $this->getUser()->setFlash('error', 'Receta Medica Eliminada con exito');
        $this->redirect('recetario/nueva');
  }
    
  public function executeIndex()
  {
    $this->redirect('recetario/nueva');
  }
  public function executeNueva(sfWebRequest $request)
  {
      date_default_timezone_set("America/Guatemala");
            $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
    $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
    $defaults = array();
    $defaults['fecha'] =  date("d/m/Y");
    $this->form = new RecetaNuevaForm($defaults);
    $this->id = $request->getParameter('id');
    if ($request->isMethod('POST')) {
      $this->form->bind($request->getParameter('receta_nueva'));
      if ($this->form->isValid()) {
        $con = Propel::getConnection();
        $con->beginTransaction();
        $valores = $this->form->getValues();
        $Receta = new Recetario();
        $Receta->setClienteId($valores['cliente']);
        $Receta->setObservaciones($valores['observaciones_cabecera']);
        $Receta->setEmpresaId($empresaId);
        $Receta->setFecha(date('Y-m-d'));
        $Receta->setUsuario($usuarioQ->getUsuario());
        $Receta->save();
        $Detalles = json_decode($valores['detalle'],  true);
        foreach ($Detalles as $detalle) {
          $RecetaDetalle = new RecetarioDetalle();
          $RecetaDetalle->setRecetarioId($Receta->getId());
          $RecetaDetalle->setTipoDetalle($detalle['tipo']);
          if ($detalle['tipo'] == 'Producto') {
            $RecetaDetalle->setProductoId($detalle['producto']);
          } else {
            $RecetaDetalle->setServicio($detalle['servicio']);
          }
          $RecetaDetalle->setDosis($detalle['dosis']);
          if ($detalle['frecuencia'] <> 'cada'){ 
          $RecetaDetalle->setFrecuencia($detalle['frecuencia']);
          }
          $RecetaDetalle->setObservaciones($detalle['observaciones']);
          $RecetaDetalle->save();
        }
        $con->commit();
        $this->getUser()->setFlash('exito', 'Receta guardada correctamente');
        $this->redirect('recetario/nueva?id=' . $Receta->getId());
      }
    }
  }
  public function executeLista(sfWebRequest $request)
  {
    date_default_timezone_set("America/Guatemala");
    $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('consultaDEVO', null, 'consulta'));
    $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
    $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
    if (!$valores) {
      $valores['fechaInicio'] = date('d/m/Y');
      $valores['fechaFin'] = date('d/m/Y');
      sfContext::getInstance()->getUser()->setAttribute('consultaDEVO', serialize($valores), 'consulta');
    }
    $this->form = new ConsultaFechaSubmitForm($valores);
    if ($request->isMethod('post')) {
      $this->form->bind($request->getParameter('consulta'));
      if ($this->form->isValid()) {
        $valores = $this->form->getValues();
        sfContext::getInstance()->getUser()->setAttribute('consultaDEVO', serialize($valores), 'consulta');
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('consultaDEVO', null, 'consulta'));
        $this->redirect('recetario/lista?id=');
      }
    }

    $fechaInicio = $valores['fechaInicio'];
    $fechaInicio = explode('/', $fechaInicio);
    $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
    $fechaFin = $valores['fechaFin'];
    $fechaFin = explode('/', $fechaFin);
    $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
    $this->recetario = RecetarioQuery::create()
      ->where("Recetario.Fecha >= '" . $fechaInicio . " 00:00:00" . "'")
      ->where("Recetario.Fecha <= '" . $fechaFin . " 23:59:00" . "'")
      ->find();
  }
  public function executeDetalle(sfWebRequest $request)
  {
    $this->id = $request->getParameter('id');
  }
  public function executeImprimir(sfWebRequest $request)
  {
    $id = $request->getParameter("id");
    $Receta = RecetarioQuery::create()->findOneById($id);
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetTitle('Receta Médica');
    $pdf->SetAuthor('erp');
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '12');
    $contenido_receta = $this->getPartial('recetario/detalle', array('id' => $id));
    // Generar el contenido HTML en el PDF
    $pdf->writeHTML($contenido_receta, true, false, true, false, '');

    // Salida del PDF (puedes elegir guardar el PDF en lugar de mostrarlo en el navegador)
    $pdf->Output('receta_medica.pdf', 'I');
  }
}
