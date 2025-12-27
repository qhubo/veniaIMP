<?php

/**
 * campo_usuario actions.
 *
 * @package    plan
 * @subpackage campo_usuario
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class campo_usuarioActions extends sfActions
{
    public function executeElimina(sfWebRequest $request) {
        $modulo = 'campo_usuario';
        $id = $request->getParameter('id');
        // die('a');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $usuarioCampo = ValorUsuarioQuery::create()
                    ->filterByCampoUsuarioId($id)
                    ->find();
            if ($usuarioCampo) {
                $usuarioCampo->delete();
            }
            $REGISTRO = CampoUsuarioQuery::create()->findOneById($id);
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
        $this->titulo = "CAMPOS USUARIO";
        $this->registros = CampoUsuarioQuery::create()->find();
    }

    public function executeMuestra(sfWebRequest $request) {
        $modulo = 'campo_usuario';
        $this->titulo = 'CAMPO DE USUARIO';
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('usuario', null, 'nivel');
        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $default = null;
        $registro = CampoUsuarioQuery::create()->findOneById($Id);
        $registroMax = CampoUsuarioQuery::create()->orderByOrden("Desc")->findOne();
        if ($registroMax) {
             $default['orden']=$registroMax->getOrden()+1;
        }
        
        $default['activo'] = true;
        if ($registro) {
            $default['nombre'] = $registro->getNombre();
            $default['tipo_documento'] = $registro->getTipoDocumento();
            $default['tipo_campo'] = $registro->getTipoCampo();
            $default['activo'] = $registro->getActivo();
            $default['valores'] = $registro->getValores();
            $default['requerido'] = $registro->getRequerido();
            $default['orden'] = $registro->getOrden();
            $default['tiendaId']=$registro->getTiendaId();
            
        }
        $this->registro = $registro;
        $this->form = new CreaCampoUsuarioForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $nuevo = new CampoUsuario();
                if ($registro) {
                    $nuevo = $registro;
                }
                $nuevo->setNombre($valores['nombre']);
                $nuevo->setTipoDocumento($valores['tipo_documento']);
                $nuevo->setTipoCampo($valores['tipo_campo']);
                $nuevo->setActivo($valores['activo']);
                $nuevo->setValores($valores['valores']);
                $nuevo->setRequerido($valores['requerido']);
                $nuevo->setOrden($valores['orden']);
                $nuevo->setTiendaId(null);
                if ($valores['tiendaId']){
                $nuevo->setTiendaId($valores['tiendaId']);
                    
                }
                $nuevo->save();

                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect($modulo . '/muestra?id=' . $nuevo->getId());
            }
        }
    }
}
