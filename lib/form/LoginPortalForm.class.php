<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginPortalForm extends sfForm {

    public function configure() {
        $this->setWidgets(array(
            "usuario" => new sfWidgetFormInputText(array("label" => "Usuario",), array("size" => "16",
                "maxlength" => "32",
                "title" => "Ingrese Usuario a Validar",
                "class" => "validate form-control",
                "placeholder" => "Usuario",
                "autocomplete" => "off",)),
            "clave" => new sfWidgetFormInputPassword(array("label" => "Clave",), array("size" => "16",
                "maxlength" => "32",
                "title" => "Ingrese la Clave del Usuario para su Validación",
                "placeholder" => "Clave",
                "class" => "validate form-control",)),
        ));

        $this->setValidators(array(
            'usuario' => new sfValidatorString(
                    array('min_length' => 1), array("min_length" => "Longitud Mínima 1 Caracteres",)),
            'clave' => new sfValidatorString(
                    array(), array("invalid" => "Campo Obligatorio",))
        ));

        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
            'callback' => array($this, "validaUsuario")
        )));

        $this->widgetSchema->setNameFormat('login[%s]');
    }

    public function validaUsuario(sfValidatorBase $validator, array $values) {

        $usuario = $values['usuario'];
        $clave = sha1($values['clave']);
//                echo $usuario;
//echo "<br>";
//        echo $clave;
//        
//      die();
        
        $user = sfContext::getInstance()->getUser();
        $user->clearCredentials();
        if ($usuario != "" && $values['clave'] != "") {
            $valido = UsuarioQuery::validaUsuario($usuario, $clave);
            $user = sfContext::getInstance()->getUser();
            if ($valido) {
                if ($valido->getValidado()) {
                    $user->setAuthenticated(true);
                    $user->setAttribute('usuario', $valido->getId(), 'seguridad');
                    $user->setAttribute('administrador', $valido->getAdministrador(), 'seguridad');
                    sfContext::getInstance()->getUser()->setAttribute('usuario', $valido->getId(), 'seguridad');
                    if ($valido->getImagen()) {
                        sfContext::getInstance()->getUser()->setAttribute('usuario', $valido->getImagen(), 'imagen');
                    }
                    $user->setAttribute('usuarioNombre', $valido->getUsuario(), 'seguridad');
                    $user->setAttribute('NombreCompleto', $valido->getNombreCompleto(), 'seguridad');
                    $user->setAttribute('imagen', 'images/margo.png', 'seguridad');

                    sfContext::getInstance()->getUser()->setAttribute('usuario', strtoupper($valido->getTipoUsuario()), 'tipo_usuario');
           
                    
                  // sfContext::getInstance()->getUser()->setAttribute("usuario", $valido->getPaisId(), 'pais');
                    $nombre = "";

                    $empresaId=null;
                    if ($valido->getEmpresaId()) {
                       $empresaq = EmpresaQuery::create()->findOneById($valido->getEmpresaId());
                        $nombre = $empresaq->getNombre();
                        $empresaId=$empresaq->getId();
                        if ($empresaq->getLogo() <> "") {
                       $user->setAttribute('imagen', 'uploads/images/'.$empresaq->getLogo(), 'seguridad');
                        }
                    }
                   
                    if ( strtoupper($valido->getTipoUsuario())=='ADMINISTRADOR') {
                     $tiendas = TiendaQuery::create()
                            ->filterByEmpresaId($empresaId)
                            ->find();
                    foreach ($tiendas as $tienda) {
                     $usuarioT = UsuarioTiendaQuery::create()
                             ->filterByTiendaId($tienda->getId())
                             ->filterByUsuarioId($valido->getId())
                             ->findOne();
                     if (!$usuarioT) {
                         $usuarioT= new UsuarioTienda();
                         $usuarioT->setTiendaId($tienda->getId());
                         $usuarioT->setUsuarioId($valido->getId());
                         $usuarioT->save();
                     }
                    }

                    
                    }
                    
                    
                    sfContext::getInstance()->getUser()->setAttribute("tienda", $valido->getTiendaId(), 'seguridad');
                    sfContext::getInstance()->getUser()->setAttribute("usuario", $valido->getTiendaId(), 'bodega');
                    sfContext::getInstance()->getUser()->setAttribute("usuario", $valido->getTiendaId(), 'bodegaSele');
                   sfContext::getInstance()->getUser()->setAttribute("nombreTienda", "N/A", 'seguridad');
                   if ($valido->getTiendaId()) {
                 //      echo $valido->getTienda()->getNombre();
                 
                   sfContext::getInstance()->getUser()->setAttribute("nombreTienda", $valido->getTienda()->getNombre(), 'seguridad');
                   
                   } 
     
                   
                   
//                    if ($valido->getGasolineraId()) {
//                        $gaso = GasolineraQuery::create()->findOneById($valido->getGasolineraId());
//                        $nombre = $gaso->getNombre();
//                    }
                    $valido->setUltimoIngreso(date('Y-m-d H:i:s'));
                    $valido->setIp($_SERVER['REMOTE_ADDR']);
                    $valido->save();
                    sfContext::getInstance()->getUser()->setAttribute("nombrelinea", $nombre, 'seguridad');
                   sfContext::getInstance()->getUser()->setAttribute("empresa", $valido->getEmpresaId(), 'seguridad');
                    sfContext::getInstance()->getUser()->setAttribute("usuario",$valido->getEmpresaId(), 'empresa');
//                    sfContext::getInstance()->getUser()->setAttribute("gasolinera", $valido->getGasolineraId(), 'seguridad');
                    sfContext::getInstance()->getUser()->setAttribute("tipoUsuario", strtoupper($valido->getTipoUsuario()), 'seguridad');
                    sfContext::getInstance()->getUser()->setAttribute("NivelUsuario", strtoupper($valido->getNivelUsuario()), 'seguridad');

                    $newLog = New UsuarioLogueo();
                    $newLog->setUsuario($valido->getUsuario());
                    $newLog->setFecha(date('Y-m-d H:i:s'));
                    $newLog->setIp($_SERVER['REMOTE_ADDR']);
                    $newLog->save();

                    UsuarioQuery::menuUsuario($valido->getId());
                } else {
                    $user->setFlash('error', 'Usuario no validado.');
                    throw new sfValidatorErrorSchema($validator, array("usuario" => new sfValidatorError($validator, 'Usuario no validado')));
                }
            } else {
                $msg = sfContext::getInstance()->getUser()->getFlash("login");
                $user->setAuthenticated(false);
               // $user->getAttributeHolder('seguridad')->removeNamespace('seguridad');
                $user->setFlash('error', 'Ingrese credenciales correctas.');
              sfContext::getInstance()->getUser()->setAttribute("error", 'Ingrese credenciales correctas.', 'seguridad');

                throw new sfValidatorErrorSchema($validator, array("clave" => new sfValidatorError($validator, $msg)));
            }
        }
        return $values;
    }

}
