<?php

/**
 * proyecto actions.
 *
 * @package    plan
 * @subpackage proyecto
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class proyectoActions extends sfActions
{
 
    public function executeElimina(sfWebRequest $request) {
        $modulo = 'proyecto';
        $id = $request->getParameter('id');
        // die('a');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $REGISTRO = ProyectoQuery::create()->findOneById($id);
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
        $this->titulo = "BANCOS";
        $this->registros = ProyectoQuery::create()->find();
    }

    public function executeMuestra(sfWebRequest $request) {
        $modulo = 'proyecto';
        $this->titulo = 'PROYECTO';
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('usuario', null, 'nivel');
        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $default = null;
        $registro = ProyectoQuery::create()->findOneById($Id);
        $default['activo'] = true;
        if ($registro) {
            $default['nombre'] = $registro->getNombre();
            $default['centro_costo'] = $registro->getCodigo();
            $default['activo'] = $registro->getActivo();
                     $default['observaciones'] = $registro->getObservaciones();
            
        }
        $this->registro = $registro;
        $this->form = new CreaProyectoForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($valores);
//                die();
                $nuevo = new Proyecto();
                if ($registro) {
                    $nuevo = $registro;
                }
                $nuevo->setNombre($valores['nombre']);
                $nuevo->setCodigo($valores['centro_costo']);
                $nuevo->setActivo($valores['activo']);
                $nuevo->setObservaciones($valores['observaciones']);
                $nuevo->save();

                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect($modulo . '/muestra?id=' . $nuevo->getId());
            }
        }
    }

}
