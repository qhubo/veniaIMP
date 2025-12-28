<?php

/**
 * marca_producto actions.
 *
 * @package    plan
 * @subpackage marca_producto
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class marca_productoActions extends sfActions
{
  public function executeElimina(sfWebRequest $request) {
             error_reporting(-1);
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $producto = MarcaProductoQuery::create()->findOneById($id);
        $tokenPro = '';
        if ($producto) {
            $tokenPro = md5($producto->getCodigo());
        }
        if ($tokenPro <> $token) {
            $this->getUser()->setFlash('error', 'Token de registro incorrecto !Intentar Nuevamente');
            $this->redirect('marca_p/index');
        }

        $con = Propel::getConnection();
        $con->beginTransaction();
        try {

            $codigo = $producto->getCodigo();
//            $productoMovimiento = ProductoQuery::create()
//                    ->filterByMarcaId($producto->getId())
//                    ->find();
//            foreach ($productoMovimiento as $reg) {
//                $reg->setMarcaId(null);
//                $reg->save();
//            }

            $producto->delete();
            $con->commit();
            $this->getUser()->setFlash('error', 'Producto ' . $codigo . ' eliminado con exito');
            $this->redirect('marca_producto/index');
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('marca_producto/index');
        }
    }

    public function executeMuestra(sfWebRequest $request) {
               error_reporting(-1);
        $id = $request->getParameter('id');
        $this->id = $id;
        $marca = MarcaQuery::create()->findOneById($id);
        $default['activo'] = true;
        $this->marca = $marca;
        if ($marca) {
            $default['nombre'] = $marca->getNombre();
            $default['activo'] = $marca->getActivo();
        }
        $this->form = new EditaMarcaProductoForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                if (!$marca) {
                    $marca = new MarcaProducto();
                }
                $marca->setNombre($valores['descripcion']);
                $marca->setActivo($valores['activo']);
                $marca->save();
                $this->getUser()->setFlash('exito', 'Informacion actualizado con exito ');
                $this->redirect('marca_producto/muestra?id=' . $marca->getId());
            }
        }
    }

    public function executeIndex(sfWebRequest $request) {
               error_reporting(-1);
        $this->marcas = MarcaProductoQuery::create()->find();

    }

}
