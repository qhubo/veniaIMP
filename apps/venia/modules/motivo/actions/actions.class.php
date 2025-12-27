<?php

/**
 * motivo actions.
 *
 * @package    plan
 * @subpackage motivo
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class motivoActions extends sfActions
{
   public function executeElimina(sfWebRequest $request) {
        $modulo = 'motivo';
        $id = $request->getParameter('id');
        // die('a');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $REGISTRO = MotivoMovimientoProductoQuery::create()->findOneById($id);
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
        $this->titulo = "Motivos";
        $this->registros = MotivoMovimientoProductoQuery::create()->find();
    }

    public function executeMuestra(sfWebRequest $request) {
        $modulo = 'motivo';
        $this->titulo = 'MOTIVOS';
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('usuario', null, 'nivel');
        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $default = null;
        $registro = MotivoMovimientoProductoQuery::create()->findOneById($Id);
        $default['activo'] = true;
        if ($registro) {
            $default['nombre'] = $registro->getNombre();
            $default['observaciones'] = $registro->getDescripcion();
            $default['activo'] = $registro->getActivo();
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
                $nuevo = new MotivoMovimientoProducto();
                if ($registro) {
                    $nuevo = $registro;
                }
                $nuevo->setNombre($valores['nombre']);
                $nuevo->setDescripcion($valores['observaciones']);
                $nuevo->setActivo($valores['activo']);
                $nuevo->save();

                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect($modulo . '/muestra?id=' . $nuevo->getId());
            }
        }
    }
}
