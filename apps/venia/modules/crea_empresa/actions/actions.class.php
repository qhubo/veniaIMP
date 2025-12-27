<?php

/**
 * crea_empresa actions.
 *
 * @package    plan
 * @subpackage crea_empresa
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class crea_empresaActions extends sfActions {

    public function executeRespaldo(sfWebRequest $request) {
        $filename = "backup-" . date("d-m-Y") . ".sql.gz";
        $this->getResponse()->setContentType('application/x-gzip');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $DBUSER = "clinica";
        $DBPASSWD = "Clinica2023!";
        $DATABASE = "clinica";
        $cmd = "mysqldump -u $DBUSER --password=$DBPASSWD $DATABASE | gzip --best";
        passthru($cmd);
        exit(0);
        die();
    }

    public function executeIndex(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $empresas = EmpresaQuery::create()->find();

        $lista = $request->getParameter('lista');
        if ($lista <> 1) {
            $this->redirect('crea_empresa/muestra?id=' . $empresaId);
        }
        $this->registros = EmpresaQuery::create()->find();
    }

    public function executeMuestra(sfWebRequest $request) {
        $tab = 1;
        if ($request->getParameter('tab')) {
            $tab = $request->getParameter('tab');
        }
        $this->tab = $tab;
        //   $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        //    sfContext::getInstance()->getUser()->setAttribute('usuario', null, 'nivel');
        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $valores = null;
        $registro = EmpresaQuery::create()->findOneById($Id);
        $this->urlImagen = '/images/margo.png';
        if ($registro) {
            sfContext::getInstance()->getUser()->setAttribute("departamento", $registro->getDepartamentoId(), 'seleccion');
            $valores['nombre'] = $registro->getNombre();  //
            $valores['nomenclatura'] = $registro->getNomenclatura();  // => 
            $valores['direccion'] = $registro->getDireccion();  // => 
            $valores['telefono'] = $registro->getTelefono();  // => 
            $valores['departamento'] = $registro->getDepartamentoId();  // => 
            $valores['mapa_geo'] = $registro->getMapaGeo();  // => 
            $valores['contacto_nombre'] = $registro->getContactoNombre();  // => 
            $valores['contacto_telefono'] = $registro->getContactoTelefono();  // => 
            $valores['contacto_movil'] = $registro->getContactoMovil();  // => 
            $valores['contacto_correo'] = $registro->getContactoCorreo();  // => 
            $valores['dias_credito'] = $registro->getDiasCredito();
            //   $valores['tipo_cuenta'] = $registro->getTipoCuenta();  // => Propietario
            //   $valores['maximo_usuario'] = $registro->getMaximoUsuarioPropiedad();  // => 
            //   $valores['feel_establecimiento'] = $registro->getFeelEstablecimiento();  // => 
            $valores['feel_nombre'] = $registro->getFeelNombre();  // => 
            $valores['feel_usuario'] = $registro->getFeelUsuario();  // => 
            $valores['feel_token'] = $registro->getFeelToken();  // => 
            $valores['feel_llave'] = $registro->getFeelLlave();  // => 
            $valores['archivo'] = $registro;  // =>
            $valores['retiene_isr'] = $registro->getRetieneIsr();
            $valores['moneda_q'] = $registro->getMonedaQ();
            if ($registro->getLogo() <> "") {
                $this->urlImagen = '/uploads/images/' . $registro->getLogo();
            }
            $valores['municipio'] = $registro->getMunicipioId();  // => 
            //  $valores['activo'] = $registro->getAc;  // => 
            $valores['factura_electronica'] = $registro->getFacturaElectronica();  // => 
            //   $valores['pago_ach'] = $registro->getPagoAch();  // => 
        }

        $this->registro = $registro;
        $this->form = new CreaEmpresaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $nuevo = new Empresa();
                if ($registro) {
                    $nuevo = $registro;
                }
                $nuevo->setNombre($valores['nombre']); // Tierra NUEVA
                $nuevo->setNomenclatura($valores['nomenclatura']); // 
                $nuevo->setDireccion($valores['direccion']); // 
                $nuevo->setTelefono($valores['telefono']); // 
                if ($valores['departamento']) {
                    $nuevo->setDepartamentoId($valores['departamento']); // 58
                }
                if ($valores['municipio']) {
                    $nuevo->setMunicipioId($valores['municipio']); // 1328
                }
                $nuevo->setDiasCredito($valores['dias_credito']);
                $nuevo->setMapaGeo($valores['mapa_geo']); // 
                $nuevo->setContactoNombre($valores['contacto_nombre']); // 
                $nuevo->setContactoTelefono($valores['contacto_telefono']); // 
                $nuevo->setContactoMovil($valores['contacto_movil']); // 
                $nuevo->setContactoCorreo($valores['contacto_correo']); // 

                $nuevo->setFeelNombre($valores['feel_nombre']); // 
                $nuevo->setFeelUsuario($valores['feel_usuario']); // 
                $nuevo->setFeelToken($valores['feel_token']); // 
                $nuevo->setFeelLlave($valores['feel_llave']); //
                $nuevo->setRetieneIsr($valores['retiene_isr']);
                $nuevo->setMonedaQ($valores['moneda_q']);

//   $nuevo->setActivo($valores['activo']); // 
                $nuevo->setFacturaElectronica($valores['factura_electronica']); // 

                $nuevo->save();
                if ($valores["archivo"]) {
                    $archivo = $valores["archivo"];
                    $nombre = $archivo->getOriginalName();
                    $nombre = str_replace(" ", "_", $nombre);
                    $nombre = str_replace(".", "", $nombre);
                    $filename = $nuevo->getId() . "_" . $nombre . date("ymdhis") . $archivo->getExtension($archivo->getOriginalExtension());
                    $archivo->save(sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $filename);
                    $nuevo->setLogo($filename);
                    $nuevo->save();
                }
                if ($Id > 0) {
                    $this->getUser()->setFlash('exito', 'Empresa Administradora Creado con exito ');
                    $this->redirect('crea_empresa/muestra?id=' . $Id);
                } else {
                    $this->getUser()->setFlash('exito', 'Empresa Administradora actualizado con exito ');

                    $this->redirect('crea_empresa/muestra?id=' . $nuevo->getId());
                }
            }
        }
    }

}
