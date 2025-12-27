<?php

/**
 * menu_seguridad actions.
 *
 * @package    plan
 * @subpackage menu_seguridad
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class menu_seguridadActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
   public function executeElimina(sfWebRequest $request) {
        $modulo = 'menu_seguridad';
        $id = $request->getParameter('id');
        // die('a');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $REGISTRO = MenuSeguridadQuery::create()->findOneById($id);
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
        $this->titulo = "Menú";
        $this->registros = MenuSeguridadQuery::create()->find();
    }

    public function executeMuestra(sfWebRequest $request) {
        $modulo = 'menu_seguridad';
        $this->titulo = 'Menú  Acceso';
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('usuario', null, 'nivel');
        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $default = null;
        $registro = MenuSeguridadQuery::create()->findOneById($Id);
        
        $default['orden'] = MenuSeguridadQuery::create()->count()+1;
        if ($registro) {
            $default['descripcion'] = $registro->getDescripcion();
            $default['modulo'] = $registro->getModulo();
            $default['orden'] = $registro->getOrden();
            $default['superior'] = $registro->getSuperior();
            $default['icono']=$registro->getIcono();
            $default['submenu']=$registro->getSubMenu();
        }
        $this->registro = $registro;
        $this->form = new CreaMenuForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($valores);
//                die();
                $nuevo = new MenuSeguridad();
                if ($registro) {
                    $nuevo = $registro;
                }
                $superiroQ = MenuSeguridadQuery::create()->findOneById($valores['superior']);
                $nuevo->setDescripcion($valores['descripcion']);
                $nuevo->setModulo($valores['modulo']);
                $nuevo->setOrden($valores['orden']);
                $nuevo->setSuperior($valores['superior']);
                $nuevo->setIcono($valores['icono']);
                $nuevo->setSubMenu($valores['submenu']);
//                if ($valores['superior']) {
//                if (!$superiroQ) {
//                   
//                     $nuevo->setSubMenu(true);        
//                    
//                }
//                }
                $nuevo->save();

                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                 $this->redirect($modulo . '/muestra');
                $this->redirect($modulo . '/muestra?id=' . $nuevo->getId());
            }
        }
    }

}
