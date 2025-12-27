<?php

/**
 * inicio actions.
 *
 * @package    plan
 * @subpackage inicio
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class inicioActions extends sfActions {

    public function executePartidas(sfWebRequest $request) {
        $partidasQ = PartidaQuery::create()
                ->where("MONTH(Partida.FechaContable) > 2")
                ->find();
        foreach ($partidasQ as $partida) {
            $mesUno = (int) $partida->getFechaContable('m');
            $mesDOs = (int) substr($partida->getFechaOperacion(), 6, 2);

//            echo $mesDOs;
//            die();
            if ($mesUno <> $mesDOs) {
                echo $partida->getId() . "," . $partida->getUsuario() . ", " . $partida->getTipo() . ", " . $partida->getCodigo() . ", " . $partida->getValor() . ", " . $partida->getFechaContable() . ", " . $partida->getFechaOperacion();
                echo "<br>";
            }
        }
        die();
    }

    public function executeTest(sfWebRequest $request) {
        $this->getResponse()->setContentType('charset=utf-8');
        $id = $request->getParameter('id');
        $text = '';
        $file = fopen("uploads/partidas" . $text . ".csv", "w");
        $file = fopen("uploads/partidas" . $text . ".csv", "w");
        $file = "uploads/partidas" . $text . ".csv";
        $query = "select codigo, fecha_contable, valor,tipo_partida,tipo_numero as documento,  p.detalle  as descripcion, cuenta_contable, de.detalle, debe, haber   from partida p inner join partida_detalle de on partida_id = p.id  and p.empresa_id= de.empresa_id  where p.empresa_id =3  order by partida_id asc  ";
        header('Expires: 0');
        header('Cache-control: private');
        header('Content-Type: application/x-octet-stream'); // Archivo de Excel
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
        header('Last-Modified: ' . date('D, d M Y H:i:s'));
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header("Content-Transfer-Encoding: binary");

        $Datos = 'codigo ,fecha_contable ,valor,tipo_partida,documento ,descripcion,cuenta_contable,detalle, debe, haber ';
        $Datos .= "\r\n";

        $con = Propel::getConnection();
        $stmt = $con->prepare($query);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $re) {
            $Datos .= str_replace(',', '', $re['codigo']) . ",";
            $Datos .= str_replace(',', '', $re['fecha_contable']) . ","; // ,
            $Datos .= str_replace(',', '', $re['valor']) . ","; //,
            $Datos .= str_replace(',', '', $re['tipo_partida']) . ","; //,
            $Datos .= str_replace(',', '', $re['documento']) . ","; // ,
            $Datos .= str_replace(',', '', $re['descripcion']) . ","; //,
            $Datos .= str_replace(',', '', $re['cuenta_contable']) . ","; //,
            $Datos .= str_replace(',', '', $re['detalle']) . ","; //, 
            $Datos .= str_replace(',', '', $re['debe']) . ","; //, 
            $Datos .= str_replace(',', '', $re['haber']) . ","; // 
// if (trim($fechap) == "") {
            $Datos .= "\r\n";
//            fwrite($file, $data . PHP_EOL);
// }
        }
        //      fclose($file);
        ECHO $Datos;
        die();

        echo "<pre>";
        print_R($result);
        die();

//$cuentaPartida = Partida::busca('Depositos Clientes', 3, 1, '', 'Periferico');
//        echo "<pre>";
//    print_r($cuentaPartida);
//        die();
//        
    }

    public function executeCambiaClave(sfWebRequest $request) {
        $valores = null;
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $this->id = $usuarioId;
        $this->usuario = UsuarioQuery::create()->findOneById($this->id);
        $usuario = UsuarioQuery::create()->findOneById($this->id);
        $this->form = new CreaClaveForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $username = $this->usuario->getUsuario();
                $datos['oldPassword'] = $valores['clave'];
                $datos['newPassword'] = $valores['clave_anterior'];
//                
//                echo "<pre>";
//                print_r($valores);
//                die();
//                $valido = $resultado['valido'];
//                if (!$resultado['valido']) {
//                    $this->getUser()->setFlash('error', $resultado['mensaje']);
//                    $this->redirect('inicio/index?t=1');
//                }
                $usuario->setClave(sha1($valores['clave']));
                $usuario->save();
                $this->getUser()->setFlash('exito', $username . " Cambio de Contraseña realizado con exito");
                $this->redirect('inicio/index?t=1');
            }
        }
    }

    public function executePerfil(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $default = null;
        $registro = UsuarioQuery::create()->findOneById($usuarioId);
        $usuario = UsuarioQuery::create()->findOneById($usuarioId);

        $this->usuario = $usuario;
        $default['activo'] = true;
        if ($usuario) {
            $default['primer_nombre'] = $usuario->getNombreCompleto();
            $default['correo'] = $usuario->getCorreo(); //
        }



        $this->registro = $registro;
        $this->form = new EditaFichaForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $nuevo = $usuario;
                $nuevo->setNombreCompleto($valores['primer_nombre']); // => ads
                $nuevo->setCorreo($valores['correo']); // => demo@correo.com
//               echo "<pre>";
//                print_r($valores);
//                die();
                $imagen = $valores['archivo'];
                if ($imagen) {
                    $carpetaArchivos = sfConfig::get('sf_upload_dir'); // $ParametroConexion['ruta']; 
                    $nombre = $nuevo->getId() . "_" . $nuevo->getId();
                    $filename = $nombre . date("ymd") . $imagen->getExtension($imagen->getOriginalExtension());
                    $imagen->save($carpetaArchivos . DIRECTORY_SEPARATOR . 'milclient' . DIRECTORY_SEPARATOR . $filename);
                    $nuevo->setImagen($filename);
                    $nuevo->save();
                }


                $nuevo->save();
                $this->getUser()->setFlash('exito', 'Usuario actualizado  con exito ');
                $this->redirect('inicio/perfil');
            }
        }
    }

    // $nombreTienda= sfContext::getInstance()->getUser()->getAttribute("nombreTienda", null, 'seguridad');
    public function executeSeleccionTienda(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $id = $request->getParameter("id");
        sfContext::getInstance()->getUser()->setAttribute("tienda", $id, 'seguridad');
// sfContext::getInstance()->getUser()->setAttribute("usuario", $id, 'empresa');
        $USuarioQuery = UsuarioQuery::create()->findOneById($usuarioId);
        $USuarioQuery->setTiendaId($id);
        $USuarioQuery->save();
        sfContext::getInstance()->getUser()->setAttribute("nombreTienda", $USuarioQuery->getTienda()->getNombre(), 'seguridad');
        $this->getUser()->setFlash('exito', 'Tienda  ' . $USuarioQuery->getTienda()->getNombre() . '   seleccionada con exito');
        $this->redirect("inicio/index");
    }

    public function executeSeleccionEmpresa(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $id = $request->getParameter("id");
        sfContext::getInstance()->getUser()->setAttribute("empresa", $id, 'seguridad');

        sfContext::getInstance()->getUser()->setAttribute("usuario", $id, 'empresa');

// sfContext::getInstance()->getUser()->setAttribute("usuario", $id, 'empresa');
        $USuarioQuery = UsuarioQuery::create()->findOneById($usuarioId);
        $USuarioQuery->setEmpresaId($id);
        $USuarioQuery->save();
        $empresaQ = EmpresaQuery::create()->findOneById($id);
        $tiendausuario = UsuarioTiendaQuery::create()
                ->useTiendaQuery()
                ->endUse()
                ->findOne();
        sfContext::getInstance()->getUser()->setAttribute("tienda", $tiendausuario->getTiendaId(), 'seguridad');
        $USuarioQuery->setTiendaId($tiendausuario->getTiendaId());
        $USuarioQuery->save();
        sfContext::getInstance()->getUser()->setAttribute("imagen", "uploads/images/" . $empresaQ->getLogo(), 'seguridad');

        sfContext::getInstance()->getUser()->setAttribute("nombrelinea", $USuarioQuery->getEmpresa()->getNombre(), 'seguridad');
    
        
        
        $tiendaQUERY = UsuarioTiendaQuery::create()
                ->filterByUsuarioId($USuarioQuery->getId())
                ->useTiendaQuery()
                ->filterByEmpresaId($empresaQ->getId())
                ->endUse()
                ->findOne();
        
            
//        echo "<pre>";
//        print_r($tiendaQUERY->getTienda()->getNombre());
//        die();
        $tiendaId= $tiendaQUERY->getTiendaId();
        sfContext::getInstance()->getUser()->setAttribute("nombreTienda", $tiendaQUERY->getTienda()->getNombre(), 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute("tienda", $tiendaId, 'seguridad');
// sfContext::getInstance()->getUser()->setAttribute("usuario", $id, 'empresa');
        $USuarioQuery = UsuarioQuery::create()->findOneById($usuarioId);
        $USuarioQuery->setTiendaId($tiendaId);
        $USuarioQuery->save();

        
        
        
        $this->getUser()->setFlash('exito', 'Empresa ' . $USuarioQuery->getEmpresa()->getNombre() . '   seleccionada con exito');
        $this->redirect("inicio/index");
    }

    public function executeTienda(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $UsuarioQuer = UsuarioQuery::create()->findOneById($usuarioId);
        $list = UsuarioPaisQuery::create()
                ->filterByUsuarioId($usuarioId)
                ->find();
        $lista[] = $UsuarioQuer->getPaisId();
        foreach ($list as $li) {
            $lista[] = $li->getPaisId();
        }


        $this->empresas = PaisQuery::create()->filterById($lista, Criteria::IN)->find();

        $this->actual = $UsuarioQuer->getPaisId();
    }

    public function executeCambioClave(sfWebRequest $request) {
        $usuario_id = $this->getUser()->getAttribute('usuario', null, 'seguridad');
        $this->usuariodescripcion = UsuarioQuery::create()->findOneById($usuario_id);
        $this->form = new cambioClaveForm();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                if ($valores['nueva'] <> $valores['verifica']) {
                    $this->getUser()->setFlash('error', 'Las claves no conciden');
                    $this->redirect("inicio/cambioClave");
                }
                $Usuario = UsuarioQuery::create()->findOneById($usuario_id);
                $Usuario->setClave(sha1($valores['nueva']));
                $Usuario->save();
                $this->getUser()->setFlash('exito', 'Cambio de Clave Efectuado Exitosamente');
                $this->redirect("inicio/index");
            }
        }
    }

    public function executeCambio(sfWebRequest $request) {
        $this->id = $request->getParameter("id");
        $variable = $request->getParameter("id");
        sfContext::getInstance()->getUser()->setAttribute('valor', $variable, 'busca');
        die();
    }

    public function executeCorreo(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $UsuarioQuer = UsuarioQuery::create()->findOneById($usuarioId);
        $UsuarioQuer->setCorreo($id);
        $UsuarioQuer->save();
    }

    public function executeNombre(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $UsuarioQuer = UsuarioQuery::create()->findOneById($usuarioId);
        $UsuarioQuer->setNombreCompleto($id);
        $UsuarioQuer->save();
    }

    public function executeIndex(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
//        if (!$usuarioId) {
//            $this->redirect("seguridad/logout");
//        }
//        $tipoUsu = strtoupper(sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'tipo_usuario'));
//
//        if ($tipoUsu == 2) {
//            $this->redirect("venta_tienda/index");
//        }
//        
//            $tipoUsu = strtoupper(sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'tipo_usuario'));
//
//        if ($tipoUsu == 8) {
//            $this->redirect("captura_datos/index");
//        }
//        
//        
//        $UsuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
//        $nombreusuario = strtolower($UsuarioQ->getUsuario());
//        if ($nombreusuario=='ctoledo') {
//            $this->redirect("histo_devolucion/index");
//            
//        }
//        



        $can = Partida::Pendientes();

        $movimientoBanco = MovimientoBancoQuery::create()
                ->filterByMedioPagoId(27)
                ->find();
        foreach ($movimientoBanco as $regi) {
            $regi = MovimientoBancoQuery::create()->findOneById($regi->getId());
            $cuentaP = CuentaBancoQuery::create()->filterByMovimientoBancoId($regi->getId())->find();
            if ($cuentaP) {
                $cuentaP->delete();
            }
            $regi->delete();
        }
    }

    public function executeImagen(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $UsuarioQuer = UsuarioQuery::create()->findOneById($usuarioId);
        $this->UsuarioQuer = $UsuarioQuer;
        $carpetaArchivos = sfConfig::get('sf_upload_dir'); // $ParametroConexion['ruta']; 
        $this->form = new CargaImagenForm();
        $this->id = $request->getParameter('id');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                if ($valores["archivo"]) {
                    $archivo = $valores["archivo"];
                    $nombre = $archivo->getOriginalName();
                    $nombre = str_replace(" ", "_", $nombre);
                    $nombre = str_replace(".", "", $nombre);
                    $filename = $usuarioId . "_" . $nombre . $archivo->getExtension($archivo->getOriginalExtension());
                    $archivo->save(sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . 'empresas' . DIRECTORY_SEPARATOR . $filename);
                    $archivo->save($carpetaArchivos . 'empresas' . DIRECTORY_SEPARATOR . $filename);
                    sfContext::getInstance()->getUser()->setAttribute('usuario', $filename, 'imagen');
                    $UsuarioQuer->setImagen($filename);
                    $UsuarioQuer->setLogo($filename);
                    $UsuarioQuer->save();
                    $this->getUser()->setFlash('exito', ' Foto perfil actualizada con exito  ');
                    $this->redirect('inicio/index');
                }
            }
        }
    }

}
