<?php

/**
 * tipo_transporte actions.
 *
 * @package    plan
 * @subpackage tipo_transporte
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tipo_transporteActions extends sfActions
{
public function executeIndex(sfWebRequest $request) {
        $this->registros = TipoTransporteQuery::create()
                ->find();
    }
    
    public function executeElimina(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $producto = TipoTransporteQuery::create()->findOneById($id);
        $tokenPro = '';
        if ($producto) {
            $tokenPro = md5($producto->getCodigo());
        }
        if ($tokenPro <> $token) {
            $this->getUser()->setFlash('error', 'Token de registro incorrecto !Intentar Nuevamente');
            $this->redirect('tipo_transporte/index');
        }
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $codigo = $producto->getCodigo();
            $producto->delete();
            $con->commit();
            $this->getUser()->setFlash('error', 'Lista Precio ' . $codigo . ' eliminado con exito');
            $this->redirect('tipo_transporte/index');
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('tipo_transporte/index');
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
                    $lista = new TipoTransporte();
                }
                $lista->setCodigo($valores['codigo']);
                $lista->setNombre($valores['nombre']);
                $lista->setActivo($valores['activo']);
                $lista->save();
                $this->getUser()->setFlash('exito', 'Informacion actualizado con exito ');
                $this->redirect('tipo_transporte/muestra?id=' . $lista->getId());
            }
        }
    }

}
