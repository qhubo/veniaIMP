<?php

/**
 * edita_cliente actions.
 *
 * @package    plan
 * @subpackage edita_cliente
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class edita_clienteActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $cliente = ClienteQuery::create()->findOneById($id);
        $logo = $cliente->getEmpresa()->getLogo();
        $titulo = 'Cliente';
        $lista = null;  /// lista de producto recetas;
        $referencia = $cliente->getCodigo();
        $observaciones = $cliente->getNombre(); //  $ordenCompra->getSerie()." ".$ordenCompra->getNoDocumento()."";
        $nombre2 = ' ';
        $tipocliente = $cliente->getTipoCliente();
        
        $operaciones = OperacionQuery::create()->filterByClienteId($id)->find();
        $html = $this->getPartial('edita_cliente/encabezado', array('tipocliente'=>$tipocliente,
            'cliente'=>$cliente,'operaciones'=>$operaciones,
            'nombre2' => $nombre2, 'logo' => $logo, 'titulo' => $titulo, 'observaciones' => $observaciones, 'referencia' => $referencia));
        //  $html .= $this->getPartial('edita_cliente/reporte', array('orden' => $cliente, 'lista' => $lista));
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle($titulo . " " . $referencia);
        $pdf->SetSubject('Datos, expediente, historico, cliente');
        $pdf->SetKeywords('Datos, expediente, historico, cliente'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetMargins(3, 5, 0, true);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetHeaderMargin(0.1);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont('dejavusans', '', 9);
        $pdf->AddPage();
        // $pdf->Image($img_file, 140, 5, 50, '', '', '', '300', false, 0);
        $pdf->writeHTML($html);
        $pdf->Output('cliente ' . $cliente->getCodigo() . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeReporteMedico(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $cliente = ClienteQuery::create()->findOneById($id);
        $logo = $cliente->getEmpresa()->getLogo();
        $titulo = 'Cliente';
        $lista = null;  /// lista de producto recetas;
        $referencia = $cliente->getCodigo();
        $observaciones = $cliente->getNombre(); //  $ordenCompra->getSerie()." ".$ordenCompra->getNoDocumento()."";
        $nombre2 = ' ';
        $html = $this->getPartial('reporte/encabezado', array('nombre2' => $nombre2, 'logo' => $logo, 'titulo' => $titulo, 'observaciones' => $observaciones, 'referencia' => $referencia));
        $html .= $this->getPartial('edita_cliente/reporte', array('orden' => $cliente, 'lista' => $lista));
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $this->id = $request->getParameter("id");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle($titulo . " " . $referencia);
        $pdf->SetSubject('Datos, expediente, historico, cliente');
        $pdf->SetKeywords('Datos, expediente, historico, cliente'); // set default header data
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetMargins(3, 5, 0, true);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetHeaderMargin(0.1);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont('dejavusans', '', 9);
        $pdf->AddPage();
        // $pdf->Image($img_file, 140, 5, 50, '', '', '', '300', false, 0);
        $pdf->writeHTML($html);
        $pdf->Output('cliente ' . $cliente->getCodigo() . '.pdf', 'I');
        die();
        echo $html;
        die();
    }

    public function executeElimina(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $cliente = ClienteQuery::create()->findOneById($id);
        $tokenPro = '';
        if ($cliente) {
            $tokenPro = md5($cliente->getCodigo());
        }
        if ($tokenPro <> $token) {
            $this->getUser()->setFlash('error', 'Token  incorrecto !Intentar Nuevamente');
            $this->redirect('edita_cliente/index');
        }

        $con = Propel::getConnection();
        $con->beginTransaction();
        try {

            $codigo = $cliente->getCodigo();
            $cliente->delete();

            $con->commit();
            $this->getUser()->setFlash('error', 'Cliente' . $codigo . ' eliminado con exito');
            $this->redirect('edita_cliente/index');
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage() . ', !Intentar Nuevamente');
            }
            $this->redirect('edita_cliente/index');
        }
    }

    public function executeIndex(sfWebRequest $request) {

        $datos = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaProveedo'));
        $valores = null;
        $default = null;
        if ($datos) {
            $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaProveedo'));
            $default = $valores;
        }
        $this->Proveedores = null;
        $this->form = new consultaClienteForm($default);

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'consultaProveedo');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaProveedo'));
            }
        }

        
        if ($valores) {
            $nombre = $valores['nombrebuscar']; // => 4555
            $departamento = $valores['departamento']; // => 4
            $municipio = $valores['municipio']; // => 4
            $pais =$valores['pais'];

            $operaciones = new ClienteQuery();
            if ($departamento) {
                $operaciones->filterByDepartamentoId($departamento);
            }
            if ($municipio) {
                $operaciones->filterByMunicipioId($municipio);
            }
            if ($pais) {
                  $operaciones->filterByPaisId($pais);
            }
            $busca = " ( Cliente.Nombre  like  '%" . $nombre . "%'  "
                    . "  or Cliente.Nit like  '%" . $nombre . "%'   or Cliente.Codigo like  '%" . $nombre . "%' )  ";
            $operaciones->where($busca);
            $this->Proveedores = $operaciones->find();
        }
    }

    public function executeMuestra(sfWebRequest $request) {
        $id = $request->getParameter('id');

        $this->tab = 1;
        if ($request->getParameter('tab')) {
            $this->tab = $request->getParameter('tab');
        }

        if ($request->getParameter('idr')) {
            $id = $request->getParameter('idr');
            $this->tab = 3;
        }

        $leyenda = 'Ingreso Proveedor';
        $color = 'font-blue';
        sfContext::getInstance()->getUser()->setAttribute("departamento", null, 'seleccion');
        $this->id = $id;
        sfContext::getInstance()->getUser()->setAttribute('ClienteId', $id, 'seguridad');

        $defaults['activo'] = true;
        $proveedor = ClienteQuery::create()->findOneById($id);
        //        echo "<pre>";
        //        print_R($proveedor);
        //        die();
        $this->proveedor = $proveedor;
        $this->texto = '';
        if ($proveedor) {
            $color = 'font-green';
            $leyenda = 'Actualizar proveedor  ' . $proveedor->getCodigo();
            $defaults['codigo'] = $proveedor->getCodigo(); // 
            $defaults['nit'] = $proveedor->getNit(); // 
            $defaults['activo'] = $proveedor->getActivo(); //> on
            $defaults['nombre'] = $proveedor->getNombre(); //> AAaaa          
            $defaults['pais'] = $proveedor->getPaisId(); //> 
            $defaults['departamento'] = $proveedor->getDepartamentoId(); //> 
            $defaults['nombre_factura']=$proveedor->getNombreFacturar();
            sfContext::getInstance()->getUser()->setAttribute("departamento", $proveedor->getDepartamentoId(), 'seleccion');
            $defaults['direccion'] = $proveedor->getDireccion(); //> 
            $defaults['avenida_calle'] = $proveedor->getAvenidaCalle(); //> 
            $defaults['zona'] = $proveedor->getZona(); //> 
            $defaults['telefono'] = $proveedor->getTelefono(); //> 
            $defaults['correo_electronico'] = $proveedor->getCorreoElectronico(); //> 
            $defaults['limite_credito'] = $proveedor->getLimiteCredito(); //> 
            $defaults['observacion'] = $proveedor->getObservaciones(); //> 
            //   $texto =ArticuloPeer::desencriptar_AES($proveedor->getObservaciones(), 'key');
            $this->texto = $proveedor->getObservaciones();
            $defaults['tiene_credito'] = $proveedor->getTieneCredito(); //> 
            $defaults['municipio'] = $proveedor->getMunicipioId(); //> 
            $defaults['contacto'] = $proveedor->getContacto();
        }







        $this->leyenda = $leyenda;
        $this->color = $color;
        $carpetaArchivos = sfConfig::get('sf_upload_dir'); // $ParametroConexion['ruta']; 
        $this->form = new IngresoClienteForm($defaults);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $nueva = new Cliente();
                if ($proveedor) {
                    $nueva = $proveedor;
                    $this->CamposObligatorios($id);
                }
                $nueva->setCodigo($valores['codigo']);
                $nueva->setNit($valores['nit']);
                $nueva->setNombre($valores['nombre']);
                $nueva->setTieneCredito($valores['tiene_credito']);
                $nueva->setLimiteCredito($valores['limite_credito']);
                $nueva->setNombreFacturar($valores['nombre_factura']);

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
                $nueva->setContacto($valores['contacto']);


                $nueva->setActivo($valores['activo']);

                $nueva->setDireccion($valores['direccion']);

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
                $this->redirect('edita_cliente/muestra?id=' . $nueva->getId());
            }
        }
    }

    public function CamposObligatorios($id) {
        $camposOblitatorios = CampoUsuarioQuery::create()
                ->filterByTipoDocumento('Cliente')
                ->filterByTiendaId(null)
                ->filterByActivo(true)
                ->filterByRequerido(true)
                ->find();
        foreach ($camposOblitatorios as $regitr) {
            $datos = ValorUsuarioQuery::create()
                    ->filterByTipoDocumento('Cliente')
                    ->filterByCampoUsuarioId($regitr->getId())
                    ->filterByNoDocumento($id)
                    ->findOne();
            if (!$datos) {
                $this->getUser()->setFlash('error', 'Debe completar información  ' . $regitr->getNombre());
                $this->redirect('edita_cliente/muestra?idr=' . $id);
            }
            if (trim($datos->getValor()) == "") {
                $this->getUser()->setFlash('error', 'Debes completar información  ' . $regitr->getNombre());
                $this->redirect('edita_cliente/muestra?&idr=' . $id);
            }
        }
    }

}
