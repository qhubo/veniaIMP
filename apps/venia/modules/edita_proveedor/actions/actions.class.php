<?php

/**
 * edita_proveedor actions.
 *
 * @package    plan
 * @subpackage edita_proveedor
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class edita_proveedorActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $empresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "Modelo";
        $nombreEMpresa = $empresaQ->getNombre();
        $pestanas[] = 'Carga';
        $nombre = "Modelo";
        $filename = "Reporte Proveedores_" . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("TIPO DE ARCHIVO ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->getCell("B1")->setValueExplicit("Reporte Proveedores " . strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B1:D1");

        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');
        $encabezados[] = array("Nombre" => 'Código', "width" => 25, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Nit', "width" => 25, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Nombre', "width" => 70, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Telefono', "width" => 25, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => 'Dirección', "width" => 100, "align" => "left", "format" => "@");

        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $hoja->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('819BFB');
        $hoja->getStyle('F')->getAlignment()->setWrapText(true);

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaProve'));
        $nombre = $valores['nombrebuscar']; // => 4555
        $departamento = $valores['departamento']; // => 4
        $municipio = $valores['municipio']; // => 4
        $estado = $valores['estado'];
        $operaciones = new ProveedorQuery();
        if ($departamento) {
            $operaciones->filterByDepartamentoId($departamento);
        }
        if ($municipio) {
            $operaciones->filterByMunicipioId($municipio);
        }
        if ($estado == "ACTIVO") {
            $operaciones->filterByActivo(true);
        }
        if ($estado == "NOACTIVO") {
            $operaciones->filterByActivo(false);
        }

        $busca = " ( Proveedor.Nombre  like  '%" . $nombre . "%'  "
                . "  or Proveedor.Nit like  '%" . $nombre . "%' )  ";
        $operaciones->where($busca);
        $datos=$operaciones->find();
        foreach ($datos as $lista) {
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 1, "valor" => $lista->getCodigo());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $lista->getNit());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $lista->getNombre());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $lista->getTelefono());  // ENTERO
            $dire = $lista->getDireccionCompleta();
           $datos[] = array("tipo" => 3, "valor" => $dire);  // ENTERO
            $hoja->getStyle('E' . $fila)->getAlignment()->setWrapText(true);



            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;
        
        

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        //          die();
        $xl->save('php://output');
        die();
        throw new sfStopException();
    }

    public function executeOrdenes(sfWebRequest $request) {
        $id = $request->getParameter('id');

        $this->registros = OrdenProveedorQuery::create()
                ->filterByProveedorId($id)
//                ->where("OrdenProveedor.Fecha >= '" . $fechaInicio . " " . $valores['inicio'] . ":00" . "'")
//                ->where("OrdenProveedor.Fecha <= '" . $fechaFin . " " . $valores['fin'] . ":00" . "'")
                ->find();
    }

    public function executeElimina(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $cliente = ProveedorQuery::create()->findOneById($id);
        $tokenPro = '';
        if ($cliente) {
            $tokenPro = md5($cliente->getCodigo());
        }
        if ($tokenPro <> $token) {
            $this->getUser()->setFlash('error', 'Token  incorrecto !Intentar Nuevamente');
            $this->redirect('edita_proveedor/index');
        }

        $con = Propel::getConnection();
        $con->beginTransaction();
        try {

            $codigo = $cliente->getCodigo();
            $cliente->delete();

            $con->commit();
            $this->getUser()->setFlash('error', 'Proveedor ' . $codigo . ' eliminado con exito');
            $this->redirect('edita_proveedor/index');
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('edita_proveedor/index');
        }
    }

    public function executeIndex(sfWebRequest $request) {
        $datos = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaProve'));
        $valores = null;
        $default = null;
        $default['estado'] = 'ACTIVO';
        if ($datos) {
            $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaProve'));
            $default = $valores;
        }
        $this->Proveedores = null;
        $this->form = new consultaClienteForm($default);

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'consultaProve');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaProve'));
            }
        }

        if ($valores) {
            $nombre = $valores['nombrebuscar']; // => 4555
            $departamento = $valores['departamento']; // => 4
            $municipio = $valores['municipio']; // => 4
            $estado = $valores['estado'];
            $operaciones = new ProveedorQuery();
            if ($departamento) {
                $operaciones->filterByDepartamentoId($departamento);
            }
            if ($municipio) {
                $operaciones->filterByMunicipioId($municipio);
            }
            if ($estado == "ACTIVO") {
                $operaciones->filterByActivo(true);
            }
            if ($estado == "NOACTIVO") {
                $operaciones->filterByActivo(false);
            }

            $busca = " ( Proveedor.Nombre  like  '%" . $nombre . "%'  "
                    . "  or Proveedor.Nit like  '%" . $nombre . "%' )  ";
            $operaciones->where($busca);
            $this->Proveedores = $operaciones->find();
        }
    }

    public function executeMuestra(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $leyenda = 'Ingreso Proveedor';
        $color = 'font-blue';
        sfContext::getInstance()->getUser()->setAttribute("departamento", null, 'seleccion');
        $this->id = $id;
        $defaults['activo'] = true;
        $proveedor = ProveedorQuery::create()->findOneById($id);
//        echo "<pre>";
//        print_R($proveedor);
//        die();
        $this->proveedor = $proveedor;
        $this->texto = '';
        if ($proveedor) {
            $color = 'font-green';
            $leyenda = 'Actualizar proveedor  ' . $proveedor->getCodigo();
            $defaults['cuenta_contable']=$proveedor->getCuentaContable();
            $defaults['codigo'] = $proveedor->getCodigo(); // 
            $defaults['nit'] = $proveedor->getNit(); // 
            $defaults['activo'] = $proveedor->getActivo(); //> on
            $defaults['nombre'] = $proveedor->getNombre(); //> AAaaa
            $defaults['razon_social'] = $proveedor->getRazonSocial(); //> 
            $defaults['departamento'] = $proveedor->getDepartamentoId(); //> 
            sfContext::getInstance()->getUser()->setAttribute("departamento", $proveedor->getDepartamentoId(), 'seleccion');
            $defaults['direccion'] = $proveedor->getDireccion(); //> 
            $defaults['avenida_calle'] = $proveedor->getAvenidaCalle(); //> 
            $defaults['zona'] = $proveedor->getZona(); //> 
            $defaults['telefono'] = $proveedor->getTelefono(); //> 
            $defaults['correo_electronico'] = $proveedor->getCorreoElectronico(); //> 
            $defaults['tipo_proveedor'] = $proveedor->getTipoProveedor(); //> Local
            $defaults['dias_credito'] = $proveedor->getDiasCredito(); //> 
            $defaults['sitio_web'] = $proveedor->getSitioWeb(); //> 
            $defaults['contacto'] = $proveedor->getContacto(); //> 
            $defaults['observacion'] = $proveedor->getObservaciones(); //> 
            $defaults['tipo_regimen'] = $proveedor->getRegimenIsr();
            //   $texto =ArticuloPeer::desencriptar_AES($proveedor->getObservaciones(), 'key');
            $this->texto = $proveedor->getObservaciones();
//            echo $this->texto;
//            die();
            //  $texto=htmlspecialchars_decode($texto);
            // echo $texto;
            //  die();
            //    $texto = str_replace('&quot;', '"', $texto);
            // $texto= str_replace('/&gt;&lt;', '/>', $texto);
            //  $texto= str_replace('&lt;', '<', $texto);
//            
//            $proveedor->setObservaciones($texto);
            //    $defaults['observacion']  = $texto;
            $defaults['correo_contacto'] = $proveedor->getCorreoContacto(); //> 
            $defaults['tiene_credito'] = $proveedor->getTieneCredito(); //> 
            $defaults['municipio'] = $proveedor->getMunicipioId(); //> 
            $defaults['telefono_contacto'] = $proveedor->getTelefonoContacto();
            $defaults['ExentoIsr'] = $proveedor->getExentoIsr();
            $defaults['RetieneIva'] = $proveedor->getRetieneIva();
            $defaults['RetineIsr'] = $proveedor->getRetineIsr();
            $defaults['tipo_regimen'] = $proveedor->getRegimenIsr();
        }

//        echo $defaults['observacion'];
//        die();

        $this->leyenda = $leyenda;
        $this->color = $color;
        $carpetaArchivos = sfConfig::get('sf_upload_dir'); // $ParametroConexion['ruta']; 
        $this->form = new IngresoProveedorForm($defaults);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($valores);
//                die();
                $nueva = New Proveedor();
                if ($proveedor) {
                    $nueva = $proveedor;
                    $nueva->setCodigo($proveedor->getCodigo());

                    }
                $nueva->setNit($valores['nit']);
                $nueva->setNombre($valores['nombre']);
                $nueva->setRazonSocial($valores['razon_social']);
                $nueva->setRegimenIsr($valores['tipo_regimen']);

                $nueva->setDepartamentoId(null);
                $nueva->setMunicipioId(null);
                $nueva->setExentoIsr($valores['ExentoIsr']);
                $nueva->setRetieneIva($valores['RetieneIva']);
                $nueva->setRetineIsr($valores['RetineIsr']);
                if ($valores['departamento']) {
                    $nueva->setDepartamentoId($valores['departamento']);
                }
                if ($valores['municipio']) {
                    $nueva->setMunicipioId($valores['municipio']);
                }
                $nombre = $valores['nombre'];
//                $contenido = ArticuloQuery::LimpiezaImagen($valores['observacion'], $nombre, 1);
                //  $contenido = ArticuloPeer::encriptar_AES($contenido, 'key');   
                $contenido = $valores['observacion'];
                $contenido = htmlspecialchars_decode($contenido);
                $contenido = str_replace('&quot;', '"', $contenido);
                $contenido = str_replace('/&gt;&lt;', '/>', $contenido);
                $contenido = str_replace('&lt;', '<', $contenido);
                //  
//                $nueva->setObservaciones($valores['observacion']);
                $nueva->setObservaciones($contenido);
                $nueva->setZona($valores['zona']);
                $nueva->setTelefono($valores['telefono']);
                $nueva->setCorreoElectronico($valores['correo_electronico']);
                $nueva->setTipoProveedor($valores['tipo_proveedor']);
                $nueva->setDiasCredito($valores['dias_credito']);
                $nueva->setSitioWeb($valores['sitio_web']);
                $nueva->setContacto($valores['contacto']);
                $nueva->setCorreoContacto($valores['correo_contacto']);
                $nueva->setActivo($valores['activo']);
                $nueva->setTelefonoContacto($valores['telefono_contacto']);
                $nueva->setDireccion($valores['direccion']);
                $nueva->setRegimenIsr($valores['tipo_regimen']);
 $nueva->setCuentaContable($valores['cuenta_contable']);
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
                    $this->getUser()->setFlash('exito', ' Proveedor Actualizado con exito');
                } else {
                    $this->getUser()->setFlash('exito', 'Proveedor creado con exito ');
                }
                $this->redirect('edita_proveedor/muestra?id=' . $nueva->getId());
            }
        }
    }

}
