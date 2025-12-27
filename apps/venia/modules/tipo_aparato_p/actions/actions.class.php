<?php

/**
 * tipo_aparato_p actions.
 *
 * @package    plan
 * @subpackage tipo_aparato_p
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tipo_aparato_pActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeElimina(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $producto = TipoAparatoQuery::create()->findOneById($id);
        $tokenPro = '';
        if ($producto) {
            $tokenPro = md5($producto->getCodigo());
        }
        if ($tokenPro <> $token) {
            $this->getUser()->setFlash('error', 'Token de registro incorrecto !Intentar Nuevamente');
            $this->redirect('tipo_aparato_p/index');
        }

        $con = Propel::getConnection();
        $con->beginTransaction();
        try {

            $codigo = $producto->getCodigo();
//            $productoMovimiento = ProductoQuery::create()
//                    ->filterByTipoAparatoId($producto->getTipoAparatoId())
//                    ->find();
//            foreach ($productoMovimiento as $reg) {
//                $reg->setTipoAparatoId(null);
//                $reg->save();
//            }

            $producto->delete();
            $con->commit();
            $this->getUser()->setFlash('error', 'Producto ' . $codigo . ' eliminado con exito');
            $this->redirect('tipo_aparato_p/index');
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('tipo_aparato_p/index');
        }
    }

    public function executeMuestra(sfWebRequest $request) {
                $carpetaArchivos = sfConfig::get('sf_upload_dir'); // $ParametroConexion['ruta'];
        $carpetaArchivos .= DIRECTORY_SEPARATOR;
        $id = $request->getParameter('id');
        $this->id = $id;
        $marca = TipoAparatoQuery::create()->findOneById($id);
        $default['activo'] = true;
        $this->marca = $marca;
        if ($marca) {
            $default['descripcion'] = $marca->getDescripcion();
            $default['cuenta_contable']=$marca->getCuentacontable();
            $default['activo'] = $marca->getActivo();
            $default['receta'] = $marca->getReceta();
            $default['venta'] = $marca->getVenta();
        }
        $this->form = new EditaTipoAparatoForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                if (!$marca) {
                    $marca = new TipoAparato();
                }
                
                        $imagen = $valores['archivo'];
                        if ($imagen) {
                            $nombre = "IMAGEN" . sha1(rand(1, 10) . date('YmdHi'));
                            $filename = $nombre . date("ymd") . $imagen->getExtension($imagen->getOriginalExtension());
                            $imagen->save($carpetaArchivos . 'tipo/' . DIRECTORY_SEPARATOR . $filename);
                            $marca->setImagen('/uploads/tipo/' . $filename);
                            $marca->save();
                        }
                           if ($valores['limpia']) {
                    $marca->setImagen();
                }
                $marca->setVenta($valores['venta']);
                $marca->setCuentaContable($valores['cuenta_contable']);
                $marca->setDescripcion($valores['descripcion']);
                $marca->setActivo($valores['activo']);
               
                $marca->save();
                $this->getUser()->setFlash('exito', 'Informacion actualizado con exito ');
                $this->redirect('tipo_aparato_p/muestra?id=' . $marca->getId());
            }
        }
    }

    public function executeIndex(sfWebRequest $request) {
         $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
         $filtro[]='COMBO';
         $filtro[]='RECETA';
        $this->marcas = TipoAparatoQuery::create()
               // ->filterByDescripcion($filtro, Criteria::NOT_IN)
                ->filterByEmpresaId($empresaId)
                ->find();
//        echo $empresaId;
//        die('aaa');
    }

}
