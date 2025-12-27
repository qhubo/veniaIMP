<?php

/**
 * lista_precio actions.
 *
 * @package    plan
 * @subpackage lista_precio
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lista_precioActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
    public function executeIndex(sfWebRequest $request) {
        $this->registros = ListaPrecioQuery::create()
                ->find();
    }
    
    public function executeElimina(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $producto = ListaPrecioQuery::create()->findOneById($id);
        $tokenPro = '';
        if ($producto) {
            $tokenPro = md5($producto->getCodigo());
        }
        if ($tokenPro <> $token) {
            $this->getUser()->setFlash('error', 'Token de registro incorrecto !Intentar Nuevamente');
            $this->redirect('lista_precio/index');
        }

        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $codigo = $producto->getCodigo();
            $producto->delete();
            $con->commit();
            $this->getUser()->setFlash('error', 'Lista Precio ' . $codigo . ' eliminado con exito');
            $this->redirect('lista_precio/index');
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('lista_precio/index');
        }
    }

    public function executeMuestra(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $this->id = $id;
        $lista = ListaPrecioQuery::create()->findOneById($id);
        $default['activo'] = true;
        $this->registro = $lista;
        if ($lista) {
            $default['codigo'] = $lista->getCodigo();
            $default['nombre'] = $lista->getNombre();
            $default['activo'] = $lista->getActivo();
        }
        $this->form = new TipoPrecioForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                if (!$lista) {
                    $lista = new ListaPrecio();
                }
                $lista->setCodigo($valores['codigo']);
                $lista->setNombre($valores['nombre']);
                $lista->setActivo($valores['activo']);
                $lista->save();
                $this->getUser()->setFlash('exito', 'Informacion actualizado con exito ');
                $this->redirect('lista_precio/muestra?id=' . $lista->getId());
            }
        }
    }

    
}
