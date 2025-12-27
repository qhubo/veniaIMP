<?php

/**
 * modelo_p actions.
 *
 * @package    plan
 * @subpackage modelo_p
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class modelo_pActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
   public function executeElimina(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $producto = ModeloQuery::create()->findOneById($id);
        $tokenPro = '';
        if ($producto) {
            $tokenPro = md5($producto->getCodigo());
        }
        if ($tokenPro <> $token) {
            $this->getUser()->setFlash('error', 'Token de registro incorrecto !Intentar Nuevamente');
            $this->redirect('modelo_p/index');
        }

        $con = Propel::getConnection();
        $con->beginTransaction();
        try {

            $codigo = $producto->getCodigo();
            $productoMovimiento = ProductoQuery::create()
                    ->filterByModeloId($producto->getId())
                    ->find();
            foreach ($productoMovimiento as $reg) {
                $reg->setModeloId(null);
                $reg->save();
            }

            $producto->delete();
            $con->commit();
            $this->getUser()->setFlash('error', 'Producto ' . $codigo . ' eliminado con exito');
            $this->redirect('modelo_p/index');
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('modelo_p/index');
        }
    }
    
    
    public function executeMuestra(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $this->id = $id;
        $marca = ModeloQuery::create()->findOneById($id);
        $default['activo'] = true;
        $this->marca = $marca;
        if ($marca) {
            $default['tipo_aparato_id'] = $marca->getMarca()->getTipoAparatoId();
            $default['marca_id'] = $marca->getMarcaId();
            $default['descripcion'] = $marca->getDescripcion();
            $default['activo'] = $marca->getActivo();

        }
        $this->form = new EditaModeloForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                if (!$marca) {
                    $marca = new Modelo();
                }
                $marca->setDescripcion($valores['descripcion']);
                $marca->setMarcaId($valores['marca_id']);
                $marca->setActivo($valores['activo']);
                
                                        $carpetaArchivos = sfConfig::get('sf_upload_dir'); // $ParametroConexion['ruta'];
        $carpetaArchivos .= DIRECTORY_SEPARATOR;
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
            //    $marca->setReceta($valores['receta']);
                $marca->save();
                 $this->getUser()->setFlash('exito', 'Informacion actualizado con exito ');
                $this->redirect('modelo_p/muestra?id=' . $marca->getId());

            }
        }
    }

    public function executeIndex(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $this->marcas = ModeloQuery::create()->find();
    }
}
