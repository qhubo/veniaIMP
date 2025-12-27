<?php

/**
 * agenda actions.
 *
 * @package    plan
 * @subpackage agenda
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class agendaActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
         date_default_timezone_set("America/Guatemala");
       $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
      date_default_timezone_set("America/Guatemala");
    $defaults = array('fecha' => date("d/m/Y"));
    $this->form = new NuevaCitaForm($defaults);
    $error = false;
    $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
    if ($request->isMethod('POST')) {
      $this->form->bind($request->getParameter('nueva_cita'));
      if ($this->form->isValid()) {
        $values = $this->form->getValues();
        $Agenda = new Agenda();
        $Agenda->setClienteId($values['cliente']);
        $fecha_objeto = DateTime::createFromFormat('d/m/Y', $values['fecha']);
        $fecha_y_m_d = $fecha_objeto->format('Y-m-d');
        $Agenda->setFecha($fecha_y_m_d);
        $Agenda->setHoraInicio($values['hora_inicio']);
        $Agenda->setHoraFin($values['hora_fin']);
        $Agenda->setObservaciones($values['observaciones']);
        $Agenda->setDoctor($values['usuario']);
        $Agenda->setTiendaId($usuarioQ->getTiendaId());
        $Agenda->setEmpresaId($empresaId);
        $Agenda->setEstatus("Pendiente");
              $Agenda->setNoSesion('');
        if ($values['sesion']) {
                  $Agenda->setNoSesion("Sesion ".$values['sesion']);
        }
  
        
        $Agenda->save();
        $this->getUser()->setFlash('exito', 'Nueva cita agendada');
        $this->redirect('agenda/index');
      } else {
        $error = true;
      }
    }
    $this->error = $error;
    $registro_bd = AgendaQuery::create()
      ->filterByTiendaId($usuarioQ->getTiendaId())
      ->filterByEmpresaId($empresaId)
      ->joinCliente()
      ->select(array("Agenda.NoSesion", "Cliente.Nombre", 'Agenda.Fecha', 'Agenda.HoraInicio', 'Agenda.HoraFin', 'Agenda.Estatus'))
      ->orderById('desc')
      ->limit(5000)
      ->find();
    $registros_vista = array();
    foreach ($registro_bd as $fila) {
      $registros_vista[] = $fila;
    }
    $this->registros = json_encode($registros_vista);
  }
  public function executeCambioEstatus(sfWebRequest $request)
  {
    $Agenda = AgendaQuery::create()->findOneById($request->getParameter('id'));
    $Estatus = $request->getParameter('estatus');
    if ($Agenda) {
      $Agenda->setEstatus($Estatus);
      $Agenda->save();
      $this->getUser()->setFlash('exito', 'Cita modificada correctamente');
    } else {
      $this->getUser()->setFlash('error', 'Cita con errores');
    }
    $this->redirect('agenda/index');
  }

  public function executeEliminar(sfWebRequest $request)
  {
    $Agenda = AgendaQuery::create()->findOneById($request->getParameter('id'));
    $Estatus = $request->getParameter('estatus');
    if ($Agenda) {
      $Agenda->delete();
      $this->getUser()->setFlash('exito', 'Cita eliminada correctamente');
    } else {
      $this->getUser()->setFlash('error', 'Cita con errores');
    }
    $this->redirect('agenda/index');
  }
  public function executeDetalle(sfWebRequest $request)
  {
$valoresCliente = explode("|", $request->getParameter('cliente'));
$cliente = $valoresCliente[0];
      $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
    $this->Agenda = self::obtiene_agenda($request->getParameter('fecha'), $cliente, $empresaId);
  }
  public static function obtiene_agenda($fecha, $cliente, $empresa)
  {
       $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
    $fecha = explode('T', $fecha);
    $hora_12h = date("g:i A", strtotime($fecha[1]));
    return AgendaQuery::create()
      ->filterByTiendaId($usuarioQ->getTiendaId())
      ->filterByFecha($fecha[0])
      ->filterByHoraInicio($hora_12h)
      ->filterByEmpresaId($empresa)
      ->useClienteQuery()
      ->filterByNombre($cliente)
      ->endUse()
      ->findOne();
  }
}
