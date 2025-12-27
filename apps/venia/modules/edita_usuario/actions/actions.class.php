<?php

/**
 * edita_usuario actions.
 *
 * @package    plan
 * @subpackage edita_usuario
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class edita_usuarioActions extends sfActions {

    public function executeTienda(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $this->id = $id;
        $this->usuario = UsuarioQuery::create()->findOneById($id);
        $bodegas = TiendaQuery::create()->orderByNombre()->find();
        $defa = null;
        $usarioBO = UsuarioTiendaQuery::create()->filterByUsuarioId($id)->find();
        foreach ($usarioBO as $re) {
            $defa['numero_' . $re->getTiendaId()] = true;
        }
        $this->form = new UsuarioBodegaForm($defa);
        $this->bodegas = TiendaQuery::create()->orderByNombre()->find();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $usauro = UsuarioTiendaQuery::create()
                        ->filterByUsuarioId($id)
                        ->find();
                if ($usauro) {
                    $usauro->delete();
                }
                $valores = $this->form->getValues();
                foreach ($bodegas as $lista) {
                    $seleccion = $valores['numero_' . $lista->getId()];
                    if ($seleccion) {
                        $bodega = new UsuarioTienda();
                        $bodega->setUsuarioId($id);
                        $bodega->setTiendaId($lista->getId());
                        $bodega->save();
                    }
                }
                $this->getUser()->setFlash('exito', 'Usuario actualizada con exito ');
                $this->redirect('edita_usuario/tienda?id=' . $id);
            }
        }
    }

    public function executeCodigo(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $canti = UsuarioQuery::create()
                ->filterByUsuario($id)
                ->count();
        $retun = 0;
        if ($canti > 0) {
            $retun = 1;
        }
        echo $retun;
        die();
    }

    public function executeEmpresa(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $this->usuario = UsuarioQuery::create()->findOneById($id);
    }

    public function executeElimina(sfWebRequest $request) {
        $id = $request->getParameter('id');
        //  die('a');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $usuarioQ = UsuarioTiendaQuery::create()->filterByUsuarioId($id)->find();
            if ($usuarioQ) {
                $usuarioQ->delete();
            }
            $usuarioQ = UsuarioEmpresaQuery::create()->filterByUsuarioId($id)->find();
            if ($usuarioQ) {
                $usuarioQ->delete();
            }


//            $usuarioQ = UsuarioPerfilQuery::create()->filterByUsuarioId($id)->find();
//
//            if ($usuarioQ) {
//                $usuarioQ->delete();
//            }
            $usuario = UsuarioQuery::create()->findOneById($id);
            //   BitacoraInternaQuery::nueva('Eliminacion', 'usuario', $usuario->getUsuario(), serialize($usuario), '', '', $id);

            $ua = $usuario->getUsuario();
            $usuario->delete();
            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('edita_usuario/index');
        }
        $this->getUser()->setFlash('error', 'Eliminacion de usuario ' . $ua . ' realizada con exito  ');
        $this->redirect('edita_usuario/index');
    }

    public function executeCambioClave(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $valors['usuarioId'] = $id;
        $this->usuariodescripcion = UsuarioQuery::create()->findOneById($id);
        $this->form = new CambioClaveUsuarioForm($valors);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('clave'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $usuarioQ = UsuarioQuery::create()->findOneById($id);
                $usuarioQ->setClave((sha1($valores['nueva'])));
                $usuarioQ->save();
//                echo "<pre>";
//                print_r($valores);
//                die();

                $this->getUser()->setFlash('exito', 'Cambio de Clave Efectuado Exitosamente');
                $this->redirect("edita_usuario/index");
            }
        }
    }

    public function executeIndex(sfWebRequest $request) {
        $tipoUsu = strtoupper(sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'tipo_usuario'));
        $lista[] = 'Administrador';
        if ($tipoUsu == 'SUPERADMINISTRADOR') {
            $lista[] = 'SUPERADMINISTRADOR';
        }

//           $corpoID= sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'corporacion');
//        $coporacion = CorporacionMenuQuery::create()
//                ->filterByCorporacionId($corpoID)
//                ->find();
//        $listaeM[]=0;
//        foreach ($coporacion  as $re){
//            $listaeM[]=$re->getEmpresaId();
//        }
//          

        $this->usuarios = UsuarioQuery::create()
                //   ->filterByEmpresaId($listaeM, Criteria::IN)
                ->filterByTipoUsuario($lista, Criteria::IN)
                ->orderByNombreCompleto()
                ->find();
        $lista[] = 'SUPERADMINISTRADOR';
        $this->vendedores = UsuarioQuery::create()
                //  ->filterByEmpresaId($listaeM, Criteria::IN)
                ->filterByTipoUsuario($lista, Criteria::NOT_IN)
                ->orderByNombreCompleto()
                ->find();

//            echo "<pre>";
//            print_r($this->usuarios);
//            print_r( $this->vendedores);
//            
//        die();
    }

    public function executeMuestra(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $default = null;
        $this->usuario = UsuarioQuery::create()->findOneById($Id);
        $default['activo'] = true;
        sfContext::getInstance()->getUser()->setAttribute('empresa', null, 'sele');
        if ($this->usuario) {
            $default['nombre_completo'] = $this->usuario->getNombreCompleto();
            $default['correo'] = $this->usuario->getCorreo();
            $default['usuario'] = $this->usuario->getUsuario();
            $default['activo'] = $this->usuario->getActivo();
            $default['tipo'] = $this->usuario->getTipoUsuario();
            $default['clave'] = $this->usuario->getClave();
            $default['empresa'] = $this->usuario->getEmpresaId();
            $default['bodega'] = $this->usuario->getTiendaId();
            $default['vendedor_id'] = $this->usuario->getVendedorId();
            sfContext::getInstance()->getUser()->setAttribute('empresa', $this->usuario->getEmpresaId(), 'sele');
//            $default['gasolinera'] = $this->usuario->getGasolineraId();
//            $this->admin = $this->usuario->getAdministrador();
        }
 
        $this->form = new CreaUsuarioForm ($default);
  
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $nuevo = new Usuario();
                $nuevoUSuario = true;
                $nuevo->setValidado(true);
                if ($this->usuario) {
                    $nuevoUSuario = false;
                    $nuevo = $this->usuario;
                }
                $nuevo->setNombreCompleto($valores['nombre_completo']); // => Jose Antonio 
                $nuevo->setCorreo($valores['correo']); // => abrantar@hotmail.com
                $nuevo->setUsuario($valores['usuario']); // => Publico
                $nuevo->setActivo($valores['activo']); // => Publico
                $nuevo->setValidado(true);
                $nuevo->setTipoUsuario($valores['tipo']);
                $nuevo->setNivelUsuario($valores['nivel']);
                $nuevo->setClave($valores['clave']);
                 $nuevo->setVendedorId($valores['vendedor_id']);
                $nuevo->setTiendaId(null);
                $nuevo->setEmpresaId(null);
                if ($valores['bodega']) {
                    $nuevo->setTiendaId($valores['bodega']);
                }
                if ($valores['empresa']) {
                    $nuevo->setEmpresaId($valores['empresa']);
                }
                //$nuevo->setFiltraEmpresa(true);
//                if ($nuevo->getTipoUsuario() == 'Administrador') {
//                    $nuevo->setFiltraEmpresa(false);
//                }
                $nuevo->save();
//                if ($nuevoUSuario) {
//                    UsuarioPeer::correoBienvenido($valores['nombre_completo'], $valores['usuario'], $valores['clave'], $valores['correo']);
//                }
                $this->getUser()->setFlash('exito', 'Usuario actualizado  con exito ');
                $this->redirect('edita_usuario/muestra?id=' . $nuevo->getId());
            }
        }
    }

}
