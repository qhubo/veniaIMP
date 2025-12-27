<?php

/**
 * edita_tienda actions.
 *
 * @package    plan
 * @subpackage edita_tienda
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class edita_tiendaActions extends sfActions
{
 public function executeElimina(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $cliente = TiendaQuery::create()->findOneById($id);
        $tokenPro = '';
        if ($cliente) {
            $tokenPro = md5($cliente->getCodigo());
        }
        if ($tokenPro <> $token) {
            $this->getUser()->setFlash('error', 'Token  incorrecto !Intentar Nuevamente');
            $this->redirect('edita_tienda/index');
        }
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $codigo = $cliente->getCodigo();
            $cliente->delete();
            $con->commit();
            $this->getUser()->setFlash('error', 'Tienda ' . $codigo . ' eliminado con exito');
            $this->redirect('edita_tienda/index');
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('edita_tienda/index');
        }
    }

    public function executeIndex(sfWebRequest $request) {
        
        $acceso = MenuSeguridad::Acceso('edita_tienda');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
        $datos = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaProveedo'));
        $valores = null;
        $default = null;
        if ($datos) {
            $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaProveedo'));
            $default = $valores;
        }
        $this->Proveedores = TiendaQuery::create()->find();
        
     

    
    }

    public function executeMuestra(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $leyenda = 'Ingreso Proveedor';
        $color = 'font-blue';
        sfContext::getInstance()->getUser()->setAttribute("departamento", null, 'seleccion');
        $this->id = $id;
        $defaults['activo'] = true;
        $proveedor = TiendaQuery::create()->findOneById($id);
//        echo "<pre>";
//        print_R($proveedor);
//        die();
        $this->proveedor = $proveedor;
        $this->texto = '';
        if ($proveedor) {
            $color = 'font-green';
            $leyenda = 'Actualizar proveedor  ' . $proveedor->getCodigo();
                 $defaults['codigo'] = $proveedor->getCodigo(); // 
            $defaults['codigo_establecimiento'] = $proveedor->getCodigoEstablecimiento(); // 
            $defaults['activo'] = $proveedor->getActivo(); //> on
            $defaults['nombre'] = $proveedor->getNombre(); //> AAaaa  
            $defaults['nombre_comercial']=$proveedor->getNombreComercial();
            $defaults['departamento'] = $proveedor->getDepartamentoId(); //> 
            sfContext::getInstance()->getUser()->setAttribute("departamento", $proveedor->getDepartamentoId(), 'seleccion');
            $defaults['direccion'] = $proveedor->getDireccion(); //> 
             $defaults['municipio'] = $proveedor->getMunicipioId(); //> 
                      $valores['feel_usuario'] = $proveedor->getFeelUsuario();  // => 
            $defaults['feel_token'] = $proveedor->getFeelToken();  // => 
            $defaults['feel_llave'] = $proveedor->getFeelLlave();  // => 
            $defaults['nit'] = $proveedor->getNit();  // => 
            $defaults['activa_buscador']=$proveedor->getActivaBuscador();
            
           
            $defaults['telefono'] = $proveedor->getTelefono(); //> 
            $defaults['correo'] = $proveedor->getCorreo(); 
            $defaults['tipo'] = $proveedor->getTipo; 
            $this->texto = $proveedor->getObservaciones();
          


        }

//        echo $defaults['observacion'];
//        die();

        $this->leyenda = $leyenda;
        $this->color = $color;
        $carpetaArchivos = sfConfig::get('sf_upload_dir'); // $ParametroConexion['ruta']; 
        $this->form = new IngresoTiendaForm($defaults);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                
//                echo "<pre>";
//                print_r($valores);
//                die();
                $nueva = New Tienda();
                if ($proveedor) {
                    $nueva = $proveedor;
                }
                 //    $nueva->setCodigo($valores['codigo']);
                $nueva->setCodigoEstablecimiento($valores['codigo_establecimiento']);
                $nueva->setNombre($valores['nombre']);
                $nueva->setNombreComercial($valores['nombre_comercial']);
                $nueva->setActivaBuscador($valores['activa_buscador']);
                $nueva->setDepartamentoId(null);
                $nueva->setMunicipioId(null);
                if ($valores['departamento']) {
                    $nueva->setDepartamentoId($valores['departamento']);
                }
                if ($valores['municipio']) {
                    $nueva->setMunicipioId($valores['municipio']);
                }
                $nombre = $valores['nombre'];
//                $contenido = ArticuloQuery::LimpiezaImagen($valores['observacion'], $nombre, 1);
                //  $contenido = ArticuloPeer::encriptar_AES($contenido, 'key');   
              $contenido =$valores['observacion'];
                $contenido = htmlspecialchars_decode($contenido);
                $contenido = str_replace('&quot;', '"', $contenido);
                $contenido = str_replace('/&gt;&lt;', '/>', $contenido);
                $contenido = str_replace('&lt;', '<', $contenido);
                //  
//                $nueva->setObservaciones($valores['observacion']);
                $nueva->setTipo($valores['tipo']);
                $nueva->setObservaciones($contenido);
                $nueva->setTelefono($valores['telefono']);
                $nueva->setCorreo($valores['correo']);
                $nueva->setActivo($valores['activo']);
                $nueva->setDireccion($valores['direccion']);
                $nueva->setFeelUsuario($valores['feel_usuario']); // 
                $nueva->setFeelToken($valores['feel_token']); // 
                $nueva->setFeelLlave($valores['feel_llave']); //
                $nueva->setNit($valores['nit']);
                
                if ($valores["archivo"]) {
                    $archivo = $valores["archivo"];
                    $nombre = $archivo->getOriginalName();
                    $nombre = str_replace(" ", "_", $nombre);
                    $nombre = str_replace(".", "", $nombre);
                    $filename = $nombre . date("ymdh") . $archivo->getExtension($archivo->getOriginalExtension());
                    $archivo->save(sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . 'proveedor' . DIRECTORY_SEPARATOR . $filename);
                    $archivo->save($carpetaArchivos . 'proveedor' . DIRECTORY_SEPARATOR . $filename);
                    $nueva->setImagen($filename);
                    $nueva->save();
                }

                $nueva->save();
                if ($id) {
                    $this->getUser()->setFlash('exito', ' Cliente Actualizado con exito');
                } else {
                    $this->getUser()->setFlash('exito', 'Cliente creado con exito ');
                }
                $this->redirect('edita_tienda/muestra?id=' . $nueva->getId());
            }
        }
    }
}
