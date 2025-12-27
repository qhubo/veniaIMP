<?php

/**
 * captura_datos actions.
 *
 * @package    plan
 * @subpackage captura_datos
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class captura_datosActions extends sfActions {

    public function executeElimina(sfWebRequest $request) {
                $id = $request->getParameter('id');
                $formularioLin = FormularioDetalleQuery::create()->findOneById($id);
                $id= $formularioLin->getFormularioDatosId();
                $formularioLin->delete();
                            $this->getUser()->setFlash('error', 'Detalle eliminado con exito');
                $this->redirect('captura_datos/index?id=' . $id);
        
    }
    public function executeLista(sfWebRequest $request) {

        $this->registros = FormularioDatosQuery::create()
                ->find();
    }
        public function executeConfirmar(sfWebRequest $request) {
                  sfContext::getInstance()->getUser()->setAttribute('modal', 1, 'seguridad');
                $this->getUser()->setFlash('exito', 'Visita Registrada Confirmada con exito');
                $this->redirect('captura_datos/index');  
        }

    public function executeIndex(sfWebRequest $request) {
            date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioq = UsuarioQuery::create()->findOneById($usuarioId);
        $default['fecha_visita'] = date('d/m/Y');
        $id = $request->getParameter('id');
        $this->id=$id;
        
        $formulaDatos = FormularioDatosQuery::create()->findOneById($id);
        if ($formulaDatos) {
            $default['establecimiento'] = $formulaDatos->getEstablecimiento();  // > ACEITERA DEL OLIMPO
            $default['tipo'] = $formulaDatos->getTipo();  // > ACEITERA
            $default['propietario'] = $formulaDatos->getPropietario();  // > Prueba de control 
            $default['telefono'] = $formulaDatos->getTelefono();  // > 50192439
            $default['email'] = $formulaDatos->getEmail();  // > abrantar@gmail.com
            $default['region'] = $formulaDatos->getRegionId();  // > 2
            $daepartamentoQ = DepartamentoQuery::create()->findOneById($formulaDatos->getDepartamentoId());
            $departaId = substr($daepartamentoQ->getNombre(), 0, 1) . $formulaDatos->getDepartamentoId();
            $default['departamento'] = $departaId;  // >  A48
            $municiQ = MunicipioQuery::create()->findOneById($formulaDatos->getMunicipioId());
            $muniId = substr($municiQ->getDescripcion(), 0, 3) . $formulaDatos->getMunicipioId();
                        sfContext::getInstance()->getUser()->setAttribute('regionID', $formulaDatos->getRegionId(), 'seguridad');
                        sfContext::getInstance()->getUser()->setAttribute('munID', $muniId, 'seguridad');
                        sfContext::getInstance()->getUser()->setAttribute('DepID', $departaId, 'seguridad');

            $default['municipio'] = $muniId;  // > Tam1211
            $default['direccion'] = $formulaDatos->getDireccion();  // > 13 calle 24-60 zona 7 Kaminal Juyu 2 , no entrar a Garita
            $default['nit'] = $formulaDatos->getNit();  // > 38321696
            $default['contacto'] = $formulaDatos->getContacto();  // > eqwe
            $default['WhtasApp'] = $formulaDatos->getWhtasApp();  // > 47938202
            $default['observaciones'] = $formulaDatos->getObservaciones();  // > dfsdf
//   

        }

        $this->detalle = FormularioDetalleQuery::create()->filterByFormularioDatosId($id)->find();
     
        $this->form = new CreaCapturaDatosForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();

                $dpto = $valores['departamento'];
                $dpto = substr($dpto, 1, 15);
                $dpto = (int) $dpto;

                $Mun = $valores['municipio'];
                $Mun = substr($Mun, 3, 15);
                $Mun = (int) $Mun;
               $nuevo =$formulaDatos;
                if (!$formulaDatos) {
                 $nuevo = New FormularioDatos();
                 }
                $nuevo->setEstablecimiento($valores['establecimiento']); // => ACEITERA DEL OLIMPO
                $nuevo->setTipo($valores['tipo']); //] => ACEITERA
                $nuevo->setPropietario($valores['propietario']); //] => xxxa
                $nuevo->setTelefono($valores['telefono']); //] => 544555
                $nuevo->setEmail($valores['email']); //] => abrantar@gmail.com
                $nuevo->setRegionId($valores['region']); //] => 1
                $nuevo->setDepartamentoId($dpto); //] => G46
                $nuevo->setMunicipioId($Mun); //] => Vil1197
                $nuevo->setDireccion($valores['direccion']); //] => aqui necesita 3 assllaasd
                $nuevo->setNit($valores['nit']); //] => 554555
                $nuevo->setContacto($valores['contacto']); //] => contactos
                $nuevo->setWhtasApp($valores['WhtasApp']); //] => 
                $nuevo->setObservaciones($valores['observaciones']); //] => observaciones de
                $nuevo->setFechaVisita(date('Y-m-d H:i:s')); //] => 16/05/2023      
                $nuevo->setCreatedAt(date('Y-m-d H:i:s'));
                $nuevo->setCreatedBy($usuarioq->getUsuario());
                $nuevo->setUsuario($usuarioq->getUsuario());
              
                   $con2 = Propel::getConnection();
        $con2->beginTransaction();
        try {
                $nuevo->save();
                
                if ($valores['repuesto']) {
                $repuesto = new FormularioDetalle();
                $repuesto->setFormularioDatosId($nuevo->getId());
                $repuesto->setHollander($valores['hollander']);
                $repuesto->setRepuesto($valores['repuesto']);
                $repuesto->save();
                }
                      $con2->commit();
        } catch (Exception $e) {
            $con2->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
              $this->redirect('captura_datos/index' );
        }
//                 sfContext::getInstance()->getUser()->setAttribute('modal', 1, 'seguridad');
                $this->getUser()->setFlash('exito', 'Visita Registrada con exito');
                $this->redirect('captura_datos/index?id=' . $nuevo->getId());
            }
        }
    }

}
