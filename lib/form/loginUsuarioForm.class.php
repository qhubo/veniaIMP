<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginUsuarioForm extends sfForm {

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
        $clave = ($values['clave']);


       




        $user = sfContext::getInstance()->getUser();
        $user->clearCredentials();
        if ($usuario != "" && $values['clave'] != "") {

die('al');
            $usuarioVivienda = ViviendaUsuarioQuery::create()
                    ->filterByUsuarioVivienda($usuario)
                    ->filterByClave($clave)
                    ->findOne();

//            echo "<pre>";
//            print_r($usuarioVivienda);
//            die();

            $user = sfContext::getInstance()->getUser();
            if ($usuarioVivienda) {
                if ($usuarioVivienda) {
                    $user->setAuthenticated(true);
                    $user->setAttribute('usuarioWebID', $usuarioVivienda->getId(), 'seguridad');
                    $user->setAttribute('usuarioWeb', $usuarioVivienda->getUsuarioVivienda(), 'seguridad');
                    $user->setAttribute('usuarioWebNombre', $usuarioVivienda->getNombreCompleto(), 'seguridad');
                    $user->setAttribute('usuarioWebNombre', $usuarioVivienda->getNombreCompleto(), 'seguridad');
                    $user->setAttribute('imagen', 'images/margo.png', 'seguridad');
                    $nombre = '';
                    if ($usuarioVivienda->getEmpresaId()) {
                        $empresaq = EmpresaQuery::create()->findOneById($usuarioVivienda->getEmpresaId());
                        $nombre = $empresaq->getNombre();
                        if ($empresaq->getLogo() <> "") {
                            $user->setAttribute('imagen', 'uploads/images/' . $empresaq->getLogo(), 'seguridad');
                        }
                    }
                    
                    sfContext::getInstance()->getUser()->setAttribute("tienda", $usuarioVivienda->getTiendaId(), 'seguridad');
                   sfContext::getInstance()->getUser()->setAttribute("nombreTienda", "N/A", 'seguridad');
                   if ($usuarioVivienda->getTiendaId()) {
                       echo $usuarioVivienda->getTienda()->getNombre();
                       die();
                   sfContext::getInstance()->getUser()->setAttribute("nombreTienda", $usuarioVivienda->getTienda()->getNombre(), 'seguridad');
                   
                   } 
     
                       
                    
                    
                    $retorna = MenuSeguridadQuery::Viviendas();
                    foreach ($retorna as $k=>$v) {
                    sfContext::getInstance()->getUser()->setAttribute("viviendaId", $k, 'seguridad');
                    sfContext::getInstance()->getUser()->setAttribute("viviendaNombre", $v, 'seguridad');
               
                    }
                    sfContext::getInstance()->getUser()->setAttribute("nombrelinea", $nombre, 'seguridad');
                    sfContext::getInstance()->getUser()->setAttribute("empresa", $usuarioVivienda->getEmpresaId(), 'seguridad');
                } else {
                    $user->setFlash('error', 'Usuario no validado.');
                    throw new sfValidatorErrorSchema($validator, array("usuario" => new sfValidatorError($validator, 'Usuario no validado')));
                }
            } else {
                $msg = sfContext::getInstance()->getUser()->getFlash("login");
                $user->setAuthenticated(false);
                $user->getAttributeHolder('seguridad')->removeNamespace('seguridad');
                $user->setFlash('error', 'Ingrese credenciales correctas.');
                throw new sfValidatorErrorSchema($validator, array("clave" => new sfValidatorError($validator, $msg)));
            }
        }
        return $values;
    }

}
