<?php

/**
 * seguridad actions.
 *
 * @package    
 * @subpackage seguridad
 * @author     
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

/**
 * seguridad actions.
 *
 * @package    
 * @subpackage seguridad
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class seguridadActions extends sfActions
{

    public function executeLogin(sfWebRequest $request)
    {
        error_reporting(-1);
        $this->id = $request->getParameter('id');
        $this->lo = $request->getParameter('lo');
        $this->co = $request->getParameter('co');
        $this->idv = $request->getParameter('idv');
        $this->idc = $request->getParameter('idc');
        //   $this->getUser()->getAttributeHolder()->clear();
        $this->form = new LoginPortalForm();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("login"));
            if ($this->form->isValid()) {
                $user = sfContext::getInstance()->getUser();
                $user->setAuthenticated(true);
                $this->redirect("inicio/index");
            }
            $this->redirect("inicio/index");
        }
        if ($this->getUser()->isAuthenticated()) {
            $this->redirect('inicio/index');
        }
    }

    public function executeLogout(sfWebRequest $request)
    {
        $this->getUser()->getAttributeHolder('seguridad')->removeNamespace('seguridad');
        $this->getUser()->setAuthenticated(false);
        $this->getUser()->clearCredentials();
        $this->redirect("inicio/index");
    }

    public function executeCambioclave(sfWebRequest $request)
    {
        $this->form = new CambioClaveForm();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('cambio_clave'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $usuario_id = $this->getUser()->getAttribute('usuario', null, 'seguridad');
                $Usuario = UsuarioQuery::create()->findOneById($usuario_id);
                $Usuario->setClave(sha1($valores['Clave']));
                $Usuario->save();
                $this->getUser()->setFlash('exito', 'Cambio de Clave Efectuado Exitosamente');
                $this->redirect("inicio/index");
            }
        }
    }

    public function executeRegistrar(sfWebRequest $request)
    {
        date_default_timezone_set("America/Guatemala");
        $this->form = new RegistrarForm();
        if ($request->isMethod('POST')) {
            $this->form->bind($request->getParameter('registro_usuario'));
            if ($this->form->isValid()) {
                $url = ParametroPeer::obtenerValor('url');
                $valores = $this->form->getValues();
                $con = Propel::getConnection();
                $con->beginTransaction();
                $Usuario = new Usuario();
                $Usuario->setClave(sha1($valores['Clave']));
                $Usuario->setCorreo($valores['Correo']);
                $Usuario->setUsuario($valores['Usuario']);
                $Usuario->setAdministrador(false);
                $Usuario->setValidado(false);
                $Usuario->save();
                $Token = new TokenUsuario();
                $Token->setUsuarioId($Usuario->getId());
                $Token->setClave(sha1($Usuario->getId() . date('YmdHis')));
                $Token->setTipo('Registro');
                $Token->save();
                $formato = FormatoCorreoQuery::create()->findOneByTipo('Token');
                if ($formato) {
                    $Correo = new Correo();
                    $Correo->setReceptor($valores['Correo']);
                    $Correo->setAsunto('Nuevo Registro');
                    $datos = array('url' => $url, 'token' => $Token->getClave());
                    $contenido = $formato->getFormatoPlano($datos);
                    $Correo->setContenido($contenido);
                    $Correo->save();
                }
                $con->commit();
                $this->getUser()->setFlash('exito', 'Usuario creado correctamente');
                $this->redirect('seguridad/login');
            }
        }
    }

    public function executeValidaToken(sfWebRequest $request)
    {
        $token = $request->getParameter('token');
        $fecha = new DateTime(date('Y-m-d H:i:s'));
        $fechaMaxima = $fecha->modify('+1 day')->format('Y-m-d H:i:s');
        $TokenQuery = TokenUsuarioQuery::create()
            ->filterByClave($token)
            ->filterByTipo('Registro')
            ->where("created_at <= '$fechaMaxima'")
            ->findOne();
        if ($TokenQuery) {
            $valido = $TokenQuery->getUsuario();
            $valido->setValidado(true);
            $valido->save();
            $user = sfContext::getInstance()->getUser();
            $user->setAuthenticated(true);
            $user->setAttribute('administrador', $valido->getAdministrador(), 'seguridad');
            $user->setAttribute('usuario', $valido->getId(), 'seguridad');
            sfContext::getInstance()->getUser()->setAttribute('usuario', $valido->getId(), 'seguridad');
            $user->setAttribute('usuarioNombre', $valido->getUsuario(), 'seguridad');
            UsuarioQuery::menuUsuario($valido->getId());
            sfContext::getInstance()->getUser()->setFlash('exito', 'Bienvenido por primera vez a Kunes!');
            $this->redirect('inicio/index');
        } else {
            sfContext::getInstance()->getUser()->setAttribute('mensaje', 'Token inexistente', 'error');
        }
        $this->redirect('seguridad/login');
    }

    public function executeRecuperaclave(sfWebRequest $request)
    {
        $this->form = new RecuperaclaveForm();
        if ($request->isMethod('POST')) {
            $this->form->bind($request->getParameter('recupera_clave'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $Usuario = UsuarioQuery::create()
                    ->filterByCorreo($valores['Correo'])
                    ->findOne();
                if ($Usuario) {
                    $Token = TokenUsuarioQuery::create()
                        ->filterByUsuarioId($Usuario->getId())
                        ->filterByUtilizado(false)
                        ->filterByTipo('Recuperacion')
                        ->findOne();
                    if (!$Token) {
                        $Token = new TokenUsuario();
                        $Token->setUsuarioId($Usuario->getId());
                        $Token->setClave(sha1($Usuario->getId() . date('YmdHis')));
                        $Token->setTipo('Recuperacion');
                        $Token->save();
                    }
                    $formato = FormatoCorreoQuery::create()->findOneByTipo('Recuperacion');
                    if ($formato) {
                        $url = ParametroPeer::obtenerValor('url');
                        $Correo = new Correo();
                        $Correo->setReceptor($valores['Correo']);
                        $Correo->setAsunto('Recuperacion de clave');
                        $datos = array('url' => $url, 'token' => $Token->getClave());
                        $contenido = $formato->getFormatoPlano($datos);
                        $Correo->setContenido($contenido);
                        $Correo->save();
                    }
                    $this->getUser()->setFlash('exito', 'Correo de recuperacion enviado correctamente');
                    $this->redirect('seguridad/login');
                } else {
                    $this->getUser()->setFlash('error', 'Correo ingresado no registrado');
                }
            }
        }
    }

    public function executeRecupera(sfWebRequest $request)
    {
        $token_consulta = $request->getParameter('token');
        $Token = TokenUsuarioQuery::create()
            ->filterByClave($token_consulta)
            ->filterByTipo('Recuperacion')
            ->filterByUtilizado(false)
            ->findOne();
        if ($Token) {
            $this->form = new CambioClaveForm();
            if ($request->isMethod('POST')) {
                $this->form->bind($request->getParameter('cambio_clave'));
                if ($this->form->isValid()) {
                    $valores = $this->form->getValues();
                    $Token->setUtilizado(true);
                    $Token->save();
                    $Usuario = $Token->getUsuario();
                    $Usuario->setClave(sha1($valores['Clave']));
                    $Usuario->save();
                    $this->redirect('seguridad/login');
                } else {
                    $this->getUser()->setFlash('error', 'Password Invalido');
                }
            }
        } else {
            $this->getUser()->setFlash('error', 'Token inexistente');
            $this->redirect('seguridad/login');
        }
        $this->token = $token_consulta;
    }
}
