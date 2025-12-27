<?php

/**
 * perfil actions.
 *
 * @package    plan
 * @subpackage perfil
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class perfilActions extends sfActions {

    public function executeAccesos(sfWebRequest $request) {
        $this->id = $request->getParameter('id'); //=155555& 
        $perfilMenu = MenuSeguridadQuery::create()
                ->usePerfilMenuQuery()
                ->filterByPerfilId($this->id)
                ->endUse()
                ->find();
        $default = null;
        foreach ($perfilMenu as $registro) {
            $default['menu_' . $registro->getId()] = true;
        }
//        echo "<pre>";
//        print_r($default);
//        die();
        $this->form = new PerfilAccesoMenuForm($default);
        $this->menus = MenuSeguridadQuery::create()               
                ->orderByDescripcion()
                ->filterBySuperior(0, Criteria::NOT_EQUAL)
                //->setlimit(1)
                ->find();

        $this->superiores = MenuSeguridadQuery::create()
                ->orderByOrden()

                ->filterBySuperior(0, Criteria::EQUAL)
                //->setlimit(1)
                ->find();

        if ($request->isMethod('POST')) {
            $this->form->bind($request->getParameter('consulta'));
            $perfilMenu = PerfilMenuQuery::create()->filterByPerfilId($this->id)->find();
            if ($this->form->isValid()) {
                if ($perfilMenu) {
                    $perfilMenu->delete();
                }
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($valores);
//                die();
                
                foreach ($this->menus as $registro) {
                    if ($valores['menu_' . $registro->getId()]) {
                        $perfilMenuN = new PerfilMenu();
                        $perfilMenuN->setPerfilId($this->id);
                        $perfilMenuN->setMenuSeguridadId($registro->getId());
                        $perfilMenuN->save();
                    }
                }
                $this->getUser()->setFlash('exito', 'Asignacion de Perfil realizada correctamente.');
                $this->redirect('perfil/accesos?id='.$this->id);
            }
        }
        $this->perfil = PerfilQuery::create()->findOneById($this->id);
    }

    public function executeElimina(sfWebRequest $request) {
        $modulo = 'perfil';
        $id = $request->getParameter('id');
        // die('a');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $REGISTRO = PerfilQuery::create()->findOneById($id);
            $codigo = $REGISTRO->getId();
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
        $this->titulo = "PERFIL ACCCESO";
        $this->registros = PerfilQuery::create()->find();
    }

    public function executeMuestra(sfWebRequest $request) {
        $modulo = 'perfil';
        $this->titulo = 'PERFIL';
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('usuario', null, 'nivel');
        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $default = null;
        $registro = PerfilQuery::create()->findOneById($Id);
        $default['activo'] = true;
        if ($registro) {
            $default['descripcion'] = $registro->getDescripcion();
            $default['observaciones'] = $registro->getObservaciones();
            $default['activo'] = $registro->getActivo();
        }
        $this->registro = $registro;
        $this->form = new CreaPerfilForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($valores);
//                die();
                $nuevo = new Perfil();
                if ($registro) {
                    $nuevo = $registro;
                }
                $nuevo->setDescripcion($valores['descripcion']);
                $nuevo->setObservaciones($valores['observaciones']);
                $nuevo->setActivo($valores['activo']);
                $nuevo->save();

                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
//                $this->redirect($modulo . '/muestra?id=' . $nuevo->getId());
                 $this->redirect('perfil/accesos?id='.$nuevo->getId());
            }
        }
    }

}
