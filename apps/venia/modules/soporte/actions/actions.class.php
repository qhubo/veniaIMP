<?php

class soporteActions extends sfActions {

    
    
    public function executeBuscaNit(sfWebRequest $request) {
        

error_reporting(-1);
              $NIT = $request->getParameter('nit');
    $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $NIT = str_replace("-", "", $NIT);
        $NIT = str_replace(".", "", $NIT);
        $NIT = trim($NIT);
        $NIT = strtoupper($NIT);
        // $NIT='38321696';

        $dt['emisor_clave'] = $usuarioQue->getEmpresa()->getFeelToken(); // '694B2B49CF96EF5BCF7F18B764A4533A';
        $dt['emisor_codigo'] = $usuarioQue->getEmpresa()->getFeelNombre(); // 'DEMOPRUEBASTGC';
        $dt['nit_consulta'] = $NIT;
        $json_code = json_encode($dt);
        $username = $usuarioQue->getEmpresa()->getFeelUsuario(); //  '630001';
        $password = $usuarioQue->getEmpresa()->getFeelLlave(); // 'kuHag&xo9?w22pr#ka-A';
        $base64 = base64_encode($username . ":" . $password);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://consultareceptores.feel.com.gt/rest/action',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $json_code,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . $base64
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $results = json_decode($response, true);
     $results = json_decode($response, true);
$NOMBRE='';
        $mensaje = trim($results['mensaje']);
        if ($mensaje == "") {
            $NOMBRE =$results['nombre'];
        }
        echo $NOMBRE;
        die();
        }


    public function executeMarcaProducto(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $id = $request->getParameter('id');
        $Municipio = ProductoQuery::create()
                ->filterByEmpresaId($empresaId)
                //->filterByAfectoInventario(false)
                ->filterByMarcaId($id)
                ->orderByNombre()
                ->find();
        
//        echo "<pre>";
//        print_r($Municipio);
//        die();
        $listado = array();
        $listado[0] = '[Seleccione  Producto]';
        foreach ($Municipio as $valor) {
            $pre = substr($valor->getNombre(), 0,2)."-";
            $listado[$pre.$valor->getId()] = $valor->getNombre()." ". substr($valor->getDescripcion(), 0,100);
        }
//           echo "<pre>";
//        print_r($listado);
//        die();
        return $this->renderText(json_encode($listado));
    }

    public function executeTipoMarcaProducto(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $id = $request->getParameter('id');
        $Municipio = ProductoQuery::create()
                //   ->filterByEmpresaId($empresaId)
                ->filterByTipoAparatoId($id)
                //->filterByAfectoInventario(false)
                // ->filterByMarcaId(null)
                ->orderByNombre()
                ->find();
        $listado = array();
        $listado[0] = '[Seleccione  Producto]';
        foreach ($Municipio as $valor) {
            $pre = substr($valor->getNombre(), 0,5)."-";
            $listado[$pre.$valor->getId()] = $valor->getNombre()." ". substr($valor->getDescripcion(), 0,100);
        }
    
     
        return $this->renderText(json_encode($listado));
    }

    public function executeTipoMarcaModelo(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $id = $request->getParameter('id');
        $Municipio = ProductoQuery::create()
                ->filterByModeloId(null, Criteria::NOT_EQUAL)
                //   ->filterByEmpresaId($empresaId)
                ->filterByTipoAparatoId($id)
                //->filterByAfectoInventario(false)
                // ->filterByMarcaId(null)
                ->orderByModeloId()
                ->find();
        $listado = array();
        $listado[0] = '[Seleccione  Producto]';
        foreach ($Municipio as $valor) {
            $listado[$valor->getModeloId()] = $valor->getModelo()->getDescripcion();
        }
        return $this->renderText(json_encode($listado));
    }

    
      public function executeDptoRegion(sfWebRequest $request) {
        $id = $request->getParameter('id');
        sfContext::getInstance()->getUser()->setAttribute("usuario", $id, 'ProyectoId');

        $viviendas= RegionDetalleQuery::create()
                ->useDepartamentoQuery()
                ->endUse()
                 ->filterByRegionId($id)
                ->orderBy("Departamento.Nombre","Asc")
                
                ->find();
        
        $listado = array();
        $listado[0] = '[Seleccion ]';
        foreach ($viviendas as $valor) {
            $pre = substr($valor->getDepartamento()->getNombre(), 0,1);
            $listado[$pre.$valor->getDepartamentoId()] = $valor->getDepartamento()->getNombre();
        }
        return $this->renderText(json_encode($listado));
    }
    

    public function executeCola(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioq = UsuarioQuery::create()->findOneById($usuarioId);
        $this->registros = SolicitudDevolucionQuery::create()
                ->filterByEstatus("Nueva")
                ->find();
    }
    
        public function executeColaPago(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioq = UsuarioQuery::create()->findOneById($usuarioId);
    $this->registros = OperacionQuery::create()
                ->filterByPagado(false)
                ->filterByEstatus('Procesada')
                ->orderByFecha("Desc")
                ->find();

//        $this->registros = SolicitudDepositoQuery::create()
//                ->filterByEstatus("Nuevo")
//                ->find();
    }

    
    
    public function executeColaBoleta(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioq = UsuarioQuery::create()->findOneById($usuarioId);
       $this->registros= OrdenCotizacionDetalleQuery::create()
                ->filterByVerificado(true)
                ->useOrdenCotizacionQuery()
                ->filterBySolicitarBodega(true)
               ->filterByUsuario($usuarioq->getUsuario())
                ->endUse()
                ->groupByOrdenCotizacionId()
                 ->withColumn('sum(OrdenCotizacionDetalle.Cantidad)', 'CantidadTotal')
                ->find();

//        $this->registros = SolicitudDepositoQuery::create()
//                ->filterByEstatus("Nuevo")
//                ->find();
    }

    public function executeGrabaCampo(sfWebRequest $request) {
        $Campoid = $request->getParameter('id'); //  id campoUsuario
        $tipo = $request->getParameter('tipo'); /// tipo Documento
        $valor = $request->getParameter('valor'); //  valor 
        $opera = $request->getParameter('opera');
        echo $Campoid . "- " . $tipo . " " . $valor . " " . $opera;
        $campouario = CampoUsuarioQuery::create()->findOneById($Campoid);
        if ($campouario) {
            $query = ValorUsuarioQuery::create()
                    ->filterByTipoDocumento($tipo)
                    ->filterByCampoUsuarioId($Campoid)
                    ->filterByNoDocumento($opera)
                    ->findOne();
            if (!$query) {
                $query = new ValorUsuario();
                $query->setTipoDocumento($tipo);
                $query->setCampoUsuarioId($Campoid);
                $query->setNoDocumento($opera);
                $query->save();
            }
            $query->setNombreCampo($campouario->getNombre());
            $query->setValor($valor);
            $query->save();
            echo "  actualizado " . $query->getId();
        }
        die();
    }

    public function executeTipoMarca(sfWebRequest $request) {
        $id = $request->getParameter('id');
        sfContext::getInstance()->getUser()->setAttribute("usuario", $id, 'TipoId');
        $Municipio = MarcaQuery::create()
                ->filterByTipoAparatoId($id)
                ->orderByDescripcion()
                ->find();
        $listado = array();
        $listado[0] = '[Seleccione ' . TipoAparatoQuery::marca() . ']';
        foreach ($Municipio as $valor) {
            $listado[$valor->getId()] = $valor->getDescripcion();
        }
        return $this->renderText(json_encode($listado));
    }

    public function executeMarcaModelo(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $id = $request->getParameter('id');
        sfContext::getInstance()->getUser()->setAttribute("usuario", $id, 'MarcaId');

        $Municipio = ModeloQuery::create()
                ->filterByMarcaId($id)
                ->orderByDescripcion()
                ->find();
        $listado = array();
        $listado[0] = '[Seleccione ' . TipoAparatoQuery::modelo() . ']';
        foreach ($Municipio as $valor) {
            $listado[$valor->getId()] = $valor->getDescripcion();
        }
        return $this->renderText(json_encode($listado));
    }

    public function executeTabJsUsuario(sfWebRequest $r) {
        $ini = 0;
        if ($r->getParameter('iDisplayStart')) {
            $ini = $r->getParameter('iDisplayStart');
        }
        $sqlexp = "SELECT count(id) as cantidad FROM vivienda_usuario where id=-1";
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');

        if ($r->getParameter('sSearch') != "") {
            $busqueda = $r->getParameter('sSearch');
            $sqlexp = "select count(*) as cantidad  from vivienda_usuario vi where  (vi.nombre_completo like  '%" . $busqueda . "%'  or 
             vi.usuario_vivienda like '%" . $busqueda . "%' or vi.correo like '%" . $busqueda . "%') and vi.empresa_id = " . $empresaId;
        }
//           echo $sqlexp;
//        die();
        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $iTotal = $result[0]["cantidad"];
//    $query = new ProductoQuery();
        if ($r->getParameter('sSearch') != "") {
            $sqlexp = "select vi.id ,usuario_vivienda, telefono, nombre_completo, correo from vivienda_usuario vi  
              where  ( vi.nombre_completo  like  '%" . $busqueda . "%'  or 
             vi.usuario_vivienda   like '%" . $busqueda . "%'    or vi.correo like '%" . $busqueda . "%' ) and vi.empresa_id=" . $empresaId . "    limit " . $ini . ",5";
        } else {
            $sqlexp = "select vi.id usuario_vivienda, telefono, nombre_completo, correo from vivienda_usuario vi    where id= -9";
        }


        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $rResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $output = array(
            "sEcho" => intval($r->getParameter('sEcho')),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );
        $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodega');
        foreach ($rResult as $reg) {
            $row = array();
            $regid = $reg['id'];
            $usuario = $reg['usuario_vivienda'];
            $telefono = $reg['telefono'];
            $nombre_completo = $reg['nombre_completo'];
            $correo = $reg['correo'];
            $url = '/index.php/vivienda/usuario?id=' . $regid;
            $row[] = '<a href="' . $url . '"><font size="-1">' . $usuario . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-2">' . $telefono . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-2">' . $nombre_completo . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $correo . '<font></a>';

            $output["aaData"][] = $row;
        }
        $this->renderText(json_encode($output));
        return sfView::NONE;
    }

    public function executeBusca(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $datos = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));
        $default['estatus'] = 2;
        $valores = null;
        if ($datos) {
            $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));
            $default = $valores;
        }
        $this->form = new consultaProductoForm($default);
        $this->total = ProductoQuery::create()->count();
        $this->productos = ProductoQuery::create()->filterBySuperiorId(0)->find();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'consultaproducto');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaproducto'));
            }
        }
        if ($valores) {
            $nombre = $valores['nombrebuscar']; // => 4555
            $tipo = $valores['tipo']; // => 4
            $marca = $valores['marca']; // => 
            $modelo = $valores['modelo']; // => 
            $estatus = $valores['estatus'];
            $operaciones = new ProductoQuery();
            if ($tipo) {
                $operaciones->filterByTipoAparatoId($tipo);
            }
            if ($estatus == 0) {
                $operaciones->filterByEstatus(0);
            }
            if ($estatus == 1) {
                $operaciones->filterByEstatus(1);
            }
            if ($marca) {
                $operaciones->filterByMarcaId($marca);
            }
            if ($modelo) {
                $operaciones->filterByModeloId($modelo);
            }
            $operaciones->filterBySuperiorId(0);
            $operaciones->where(" ( campo_busca like  '%" . $nombre . "%' or codigo_sku like  '%" . $nombre . "%')");
            $this->productos = $operaciones->find();
        }
        $this->totalB = count($this->productos);
    }

    public function executeIndex(sfWebRequest $request) {
        
    }

    public function executeAvisos(sfWebRequest $request) {
        
    }

    public function executeChequeFormato(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $Municipio = DocumentoChequeQuery::create()
                ->filterByBancoId($id)
                ->orderByTitulo()
                ->find();
        $listado = array();
        if (count($Municipio) > 1) {
            $listado[null] = '[Seleccione Formato]';
        }
        foreach ($Municipio as $valor) {
            $listado[$valor->getId()] = $valor->getTitulo();
        }
        return $this->renderText(json_encode($listado));
    }

    public function executeDptoMunicipio(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $id = $request->getParameter('id');
        $opera = $request->getParameter('opera');
        $Municipio = MunicipioQuery::create()
                ->filterByDepartamentoId($id)
                ->orderByDescripcion()
                ->find();
        $listado = array();
        $listado[null] = '[Seleccione Municipio]';
        foreach ($Municipio as $valor) {
            $listado[$valor->getId()] = $valor->getDescripcion();
        }
        return $this->renderText(json_encode($listado));
    }
    
       public function executeDptoPais(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $id = $request->getParameter('id');
        $opera = $request->getParameter('opera');
        $Municipio = DepartamentoQuery::create()
                ->filterByPaisId($id)
                ->orderByNombre()
                ->find();
        $listado = array();
        $listado[null] = '[Seleccione Municipio]';
        foreach ($Municipio as $valor) {
            $listado[$valor->getId()] = $valor->getNombre();
        }
        return $this->renderText(json_encode($listado));
    }
    
      public function executeDptoMunicipioL(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $id = $request->getParameter('id');
        $id= substr($id, 1,5);
        $id=trim($id);
        $opera = $request->getParameter('opera');
        $Municipio = MunicipioQuery::create()
                ->filterByDepartamentoId($id)
                ->orderByDescripcion()
                ->find();
        
        
        $listado = array();
        $listado[null] = '[Seleccione Municipio]';
        foreach ($Municipio as $valor) {
            $pre = substr($valor->getDescripcion(), 0,3);
            $listado[$pre.$valor->getId()] = $valor->getDescripcion();
        }
        return $this->renderText(json_encode($listado));
    }


    public function executeEmpresaTienda(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $id = $request->getParameter('id');
//        $Municipio = BodegaQuery::create()
//                ->filterByEmpresaId($id)
//                ->orderByNombre()
//                ->find();
        $listado = array();
        //  $listado[0] = '[Seleccione  Tienda]';
        $sqlexp = 'select id,nombre from tienda  where empresa_id =' . $id;
        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $rResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rResult as $reg) {
            $nombre = $reg['nombre'];
            $id = $reg['id'];
            $listado[$id] = $nombre;
        }
//        foreach ($Municipio as $valor) {
//            $listado[$valor->getId()] = $valor->getNombre();
//        }
        return $this->renderText(json_encode($listado));
    }

}
