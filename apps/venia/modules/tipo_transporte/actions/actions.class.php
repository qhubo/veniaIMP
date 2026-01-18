<?php

/**
 * tipo_transporte actions.
 *
 * @package    plan
 * @subpackage tipo_transporte
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tipo_transporteActions extends sfActions {

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
        $lista = TipoTransporteQuery::create()->findOneById($id);
        $default['activo'] = true;
        $this->registro = $lista;
        if ($lista) {
            $default['codigo'] = $lista->getCodigo();
            $default['nombre'] = $lista->getNombre();
            $default['activo'] = $lista->getActivo();

            $default['descripcion'] = $lista->getDescripcion();
            $default['telefono'] = $lista->getTelefono();
            $default['clave'] = $lista->getClave();
            $default['clave_2'] = $lista->getClave2();
            $default['direccion'] = $lista->getDireccion();
            $default['correo'] = $lista->getCorreo();
        }
        $this->form = new CreaTipoTarnsporteForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();

                if ($valores['codigo']) {
                    $cantidad = TipoTransporteQuery::create()
                            ->filterByCodigo($valores['codigo'])
                            ->filterById($id, Criteria::NOT_EQUAL)
                            ->count();
                    if ($cantidad > 0) {
                        $this->getUser()->setFlash('error', 'Codigo de tipo transporte ya existe ' . $valores['codigo']);
                        $this->redirect('tipo_transporte/muestra?id=' . $id);
                    }
                }
                if (!$lista) {
                    $lista = new TipoTransporte();
                }
                $lista->setCodigo($valores['codigo']);
                $lista->setNombre($valores['nombre']);
                $lista->setActivo($valores['activo']);
                $lista->setDescripcion($valores['descripcion']);
                $lista->setTelefono($valores['telefono']);
                $lista->setClave($valores['clave']);
                $lista->setClave2($valores['clave_2']);
                $lista->setDireccion($valores['direccion']);
                $lista->setCorreo($valores['correo']);
                $lista->save();
                $this->getUser()->setFlash('exito', 'Informacion actualizado con exito ');
                $this->redirect('tipo_transporte/muestra?id=' . $lista->getId());
            }
        }
    }

}
