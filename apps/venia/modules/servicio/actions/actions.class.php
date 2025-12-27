<?php

/**
 * servicio actions.
 *
 * @package    plan
 * @subpackage servicio
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class servicioActions extends sfActions
{
 public function executeElimina(sfWebRequest $request) {
        $modulo = 'servicio';
        $id = $request->getParameter('id');
        // die('a');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $REGISTRO = ServicioQuery::create()->findOneById($id);
            $codigo = $REGISTRO->getCodigo();
            $REGISTRO->delete();

            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage());
            }
            $this->redirect($modulo . '/index');
        }
        $this->getUser()->setFlash('eliminar', $codigo);
        $this->redirect($modulo . '/index');
    }

    public function executeIndex(sfWebRequest $request) {
        $this->titulo = "SERVICIO";
        $this->registros =ServicioQuery::create()->find();
    }

    public function executeMuestra(sfWebRequest $request) {
        $modulo = 'servicio';
        $this->titulo = 'SERVICIO';
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('usuario', null, 'nivel');
        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $default = null;
        $registro = ServicioQuery::create()->findOneById($Id);
        $default['activo'] = true;
        if ($registro) {
            $default['nombre'] = $registro->getNombre();
            $default['codigo'] = $registro->getCodigo();
            $default['observaciones'] = $registro->getObservaciones();
            $default['activo'] = $registro->getActivo();
            $default['precio']=$registro->getPrecio();
                   $default['impuesto_hotelero']=$registro->getImpuestoHotelero();
            $default['cuenta_contable']=$registro->getCuentaContable();
        }
        $this->registro = $registro;
        $this->form = new CreaServicioForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($valores);
//                die();
                $nuevo = new Servicio();
                if ($registro) {
                    $nuevo = $registro;
                }
                $nuevo->setCodigo($valores['codigo']);
                $nuevo->setNombre($valores['nombre']);
                $nuevo->setObservaciones($valores['observaciones']);
                $nuevo->setActivo($valores['activo']);
                $nuevo->setPrecio($valores['precio']);
                $nuevo->setImpuestoHotelero($valores['impuesto_hotelero']);

                
                $nuevo->setCuentaContable($valores['cuenta_contable']);
                
                $nuevo->save();

                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect($modulo . '/muestra?id=' . $nuevo->getId());
            }
        }
    }

}
