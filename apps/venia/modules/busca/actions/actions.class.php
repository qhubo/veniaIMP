<?php

class buscaActions extends sfActions {

    
       public function executeProducto(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $this->id = $id;
    }

    
        public function executeTabJsProductoSalida(sfWebRequest $r) {
        $ini = 0;
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');

        if ($r->getParameter('iDisplayStart')) {
            $ini = $r->getParameter('iDisplayStart');
        }
        $sqlexp = "SELECT count(id) as cantidad FROM  producto where id=-1";
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');

        if ($r->getParameter('sSearch') != "") {
            $busqueda = $r->getParameter('sSearch');
            $busqueda = str_replace(" ", "%", $busqueda);
            $sqlexp = "select count(vi.id) as cantidad from producto vi  where vi.activo=1 and  (vi.nombre like  '%" . $busqueda . "%'
                or vi.codigo_sku like '%" . $busqueda . "%' or vi.codigo_barras like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId;
        }


        $OperacionId = sfContext::getInstance()->getUser()->getAttribute('CotizacionId', null, 'seguridad');
        $tiendaId = 0;
        $Cotizacion = OrdenCotizacionQuery::create()->findOneById($OperacionId);
        if ($Cotizacion) {
            $tiendaId = $Cotizacion->getTiendaId();
        }
//         
        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $iTotal = $result[0]["cantidad"];
//    $query = new ProductoQuery();
        if ($r->getParameter('sSearch') != "") {
            $sqlexp = "select codigo_barras, vi.id,imagen, codigo_sku,nombre  from producto vi  where  vi.activo=1 and  (vi.nombre like  '%" . $busqueda . "%'
                or vi.codigo_sku like '%" . $busqueda . "%' or vi.codigo_barras like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId . " limit " . $ini . ", 5";
        } else {
            $sqlexp = "select  id, '' as nombre, nit,  codigo   from proveedor  where id= -9";
        }
//                echo $sqlexp;
//        die();
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
//        $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodega');
        foreach ($rResult as $reg) {
            $exit = 0;
            $productoQ = ProductoQuery::create()->findOneById($reg['id']);
            if (trim($productoQ->getComboProductoId()) == "") {
                if ($productoQ) {
                    $exit = $productoQ->getExistencia();   // - $productoQ->getTransito();
                }
                $row = array();
                $regid = $reg['id'];
                $nombre = $reg['nombre'];
                $codigov= $reg['codigo_barras'];
                $imagen = $reg['imagen'];
                $codigo = $reg['codigo_sku'];
                $rutaimage = "/uploads/nofoto.jpg";
                if ($reg['imagen']) {
                    $rutaimage = $reg['imagen'];
                }




                $url = '/index.php/actualiza_inventario/producto?id=' . $regid;
                if ($_SERVER['SERVER_NAME'] == "veniaimp") {
                    $url = '/venia_dev.php/actualiza_inventario/producto?id=' . $regid;
       
                }
//                $row[] = ' <button class="open-producto btn" data-url="' . $url . '">' . '<img src="' . $rutaimage . '" height="45px" >' . '</button>';
                $row[] = '<a href="' . $url . '"><font size="-1">' . $codigo . '<font></a>';
               //       $row[] = '<a href="' . $url . '"><font size="-1">' . $codigov . '<font></a>';
                $row[] = '<a href="' . $url . '"><font size="-1">' . $nombre . '<font></a>';
//            $row[] = '<a href="' . $url . '"><font size="-1"><i class="  flaticon2-next"></i><i class="  flaticon2-next"></i><font></a>';
                $row[] = '<a href="' . $url . '"><font size="-1">' . $exit . '<font></a>';

                $output["aaData"][] = $row;
            }
        }
        $this->renderText(json_encode($output));
        return sfView::NONE;
    }
    
    
    public function executeTabJsProductoBusca(sfWebRequest $r) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $ini = (int) $r->getParameter('iDisplayStart', 0);
        $busqueda = trim($r->getParameter('sSearch', ''));
        $con = Propel::getConnection();
        $where = "vi.activo = 1 AND vi.empresa_id = :empresa";
        $params = [':empresa' => $empresaId];
        if ($busqueda != "") {
            $busquedaLike = "%" . str_replace(" ", "%", $busqueda) . "%";
            $where .= " AND (vi.nombre LIKE :busqueda 
                    OR vi.codigo_sku LIKE :busqueda 
                    OR vi.codigo_barras LIKE :busqueda)";
            $params[':busqueda'] = $busquedaLike;
        }
        $stmt = $con->prepare("SELECT COUNT(vi.id) FROM producto vi WHERE $where");
        $stmt->execute($params);
        $iTotal = $stmt->fetchColumn();
        $sql = "  SELECT vi.id,  vi.nombre,vi.codigo_barras,   vi.codigo_sku,
            vi.imagen,   vi.precio, vi.costo_proveedor,  vi.combo_producto_id FROM producto vi
        WHERE $where     LIMIT :ini, 125 ";
        $stmt = $con->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':ini', $ini, PDO::PARAM_INT);
        $stmt->execute();

        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ðŸ¬ TIENDAS (1 sola vez)
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $TIPO_USUARIO = strtoupper($usuarioQ->getTipoUsuario());

        $tiendaQuery = TiendaQuery::create()->filterByActivo(true);
        if ($TIPO_USUARIO != 'ADMINISTRADOR') {
            $tiendaQuery->filterByActivaBuscador(true);
        }
        $tiendaQuery->orderById();
        $tiendas = $tiendaQuery->find();

        // ðŸ’° LISTAS DE PRECIO
        $tipoPrecios = ListaPrecioQuery::create()
                ->filterByActivo(true)
                ->orderByNombre()
                   ->orderById()
                ->find();

        // âš¡ IDS
        $ids = array_column($productos, 'id');

        // âš¡ EXISTENCIA POR BODEGA (ANTES: getExistenciaBodega = N queries)
        $existencias = [];
        if (!empty($ids)) {
            $sqlExist = "
            SELECT producto_id, tienda_id, cantidad 
            FROM producto_existencia
            WHERE producto_id IN (" . implode(',', $ids) . ")
        ";
            foreach ($con->query($sqlExist)->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $existencias[$row['producto_id']][$row['tienda_id']] = $row['cantidad'];
            }
        }
        // âš¡ PRECIOS POR LISTA (ANTES: getPrecioLista = N queries)
        $preciosLista = [];
        if (!empty($ids)) {
            $sqlPrecios = "
            SELECT producto_id, lista_precio_id, valor 
            FROM producto_precio 
            WHERE producto_id IN (" . implode(',', $ids) . ")
        ";
            foreach ($con->query($sqlPrecios)->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $preciosLista[$row['producto_id']][$row['lista_precio_id']] = $row['valor'];
            }
        }


        $output = [
            "sEcho" => (int) $r->getParameter('sEcho'),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => []
        ];

        $base = ($_SERVER['SERVER_NAME'] == "veniaerp") ? '/venia_dev.php' : '/index.php';

        foreach ($productos as $reg) {
            $url = $base . '/ubicacion/index?id=' . $reg['id'];
            $row = [];
            $nombre = $reg['nombre'] . " | " . $reg['codigo_barras'];
            $row[] = '<a href="' . $url . '"><div style="text-align:right">' . $reg['codigo_sku'] . '</div></a>';
            $row[] = '<a href="' . $url . '"><div style="text-align:right">' . $nombre . '</div></a>';
            foreach ($tiendas as $regi) {
                $exit = 0;
                if (isset($existencias[$reg['id']]) && isset($existencias[$reg['id']][$regi->getId()])) {
                    $exit = $existencias[$reg['id']][$regi->getId()];
                }
                $row[] =' <a href="' . $url . '"><div style="text-align:right">' . $exit . '</div></a>';
            }
          $row[] = '<div style="text-align:right">  ' . Parametro::formato($reg['precio'], false) . '</div>';
            foreach ($tipoPrecios as $prec) {
                $precioLista = 0;
                if (isset($preciosLista[$reg['id']]) && isset($preciosLista[$reg['id']][$prec->getId()])) {
                    $precioLista = $preciosLista[$reg['id']][$prec->getId()];
                }
                $row[] =Parametro::formato($precioLista, false);
            }

            // 
            $row[] = '<div style="text-align:right; display:block">' . Parametro::formato($reg['costo_proveedor'], false) . '</div>';

            $output["aaData"][] = $row;
        }





        return $this->renderText(json_encode($output));
    }

    public function executeTabJsProductoUbica(sfWebRequest $r) {
        $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodega');
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $movi = $r->getParameter('movi');
        $tiendaId = null;
        $trasladoProducto = TrasladoUbicacionQuery::create()->findOneById($movi);
        if ($trasladoProducto) {
            $tiendaId = $trasladoProducto->getTiendaId();
            $empresaId = $trasladoProducto->getEmpresaId();
        }
        $ini = 0;


        if ($r->getParameter('iDisplayStart')) {
            $ini = $r->getParameter('iDisplayStart');
        }
        $sqlexp = "SELECT count(id) as cantidad FROM  producto where  empresa_id=" . $empresaId;
        if ($r->getParameter('sSearch') != "") {
            $busqueda = $r->getParameter('sSearch');
        }
        if ($r->getParameter('sSearch') != "") {
            $sqlexp = " select count(vi.id) as cantidad from producto vi  inner join producto_existencia ee on ee.cantidad >0   ";
            $sqlexp .= " and ee.producto_id= vi.id  and tienda_id =" . $tiendaId . "   where   (vi.nombre like  '%" . $busqueda . "%'";
            $sqlexp .= " or vi.codigo_sku like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId;
        }


        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $iTotal = $result[0]["cantidad"];
//    $query = new ProductoQuery();
        $sqlexp = "select vi.id,imagen, codigo_sku,nombre ,  cantidad from producto vi inner join producto_existencia ee on ee.cantidad >0  and ee.producto_id= vi.id and tienda_id =" . $tiendaId . "   where   vi.empresa_id=" . $empresaId . " limit 0, 5";

        if ($r->getParameter('sSearch') != "") {
            $sqlexp = "select vi.id,imagen, codigo_sku,nombre, cantidad  from producto vi  inner join producto_existencia ee on ee.cantidad >0 ";
            $sqlexp .= " and ee.producto_id= vi.id and tienda_id =" . $tiendaId . "   where  (vi.nombre like  '%" . $busqueda . "%' or vi.codigo_sku like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId . " limit " . $ini . ", 5";
//        } else {
//            $sqlexp = "select  id, '' as nombre, nit,  codigo   from proveedor  where id= -9";
        }
//                echo $sqlexp;
//        die();
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
        foreach ($rResult as $reg) {
            $row = array();
            $regid = $reg['id'];
            $nombre = $reg['nombre'];
            $imagen = $reg['imagen'];
            $codigo = $reg['codigo_sku'];

            $rutaimage = "/uploads/nofoto.jpg";
            if ($reg['imagen']) {
                $rutaimage = $reg['imagen'];
            }

            $url = '/index.php/traslado_ubica/producto?movi=' . $movi . '&id=' . $regid;
            if ($_SERVER['SERVER_NAME'] == "veniaerp") {
                $url = '/venia_dev.php/traslado_ubica/producto?movi=' . $movi . '&id=' . $regid;
            }

//            $row[] = '<a href="' . $url . '">' . '<img src="' . $rutaimage . '" height="45px" >' . '</a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $codigo . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $nombre . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $reg['cantidad'] . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1"><i class="  flaticon2-next"></i><i class="  flaticon2-next"></i><font></a>';

            $output["aaData"][] = $row;
        }
        $this->renderText(json_encode($output));
        return sfView::NONE;
    }

    public function executeTabJsProductoVendedor(sfWebRequest $r) {
        $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodega');
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $movi = $r->getParameter('movi');
        $ini = 0;
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');

        if ($r->getParameter('iDisplayStart')) {
            $ini = $r->getParameter('iDisplayStart');
        }
        $sqlexp = "SELECT count(id) as cantidad FROM  producto where  empresa_id=" . $empresaId;
        if ($r->getParameter('sSearch') != "") {
            $busqueda = $r->getParameter('sSearch');
        }
        if ($r->getParameter('sSearch') != "") {
            $sqlexp = "select count(vi.id) as cantidad from producto vi  where   (vi.nombre like  '%" . $busqueda . "%'
                or vi.codigo_sku like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId;
        }


        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $iTotal = $result[0]["cantidad"];
//    $query = new ProductoQuery();
        $sqlexp = "select vi.id,imagen, codigo_sku,nombre  from producto vi  where   vi.empresa_id=" . $empresaId . " limit 0, 5";

        if ($r->getParameter('sSearch') != "") {
            $sqlexp = "select vi.id,imagen, codigo_sku,nombre  from producto vi   where  (vi.nombre like  '%" . $busqueda . "%'
                or vi.codigo_sku like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId . " limit " . $ini . ", 5";
//        } else {
//            $sqlexp = "select  id, '' as nombre, nit,  codigo   from proveedor  where id= -9";
        }
//                echo $sqlexp;
//        die();
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
        foreach ($rResult as $reg) {
            $row = array();
            $regid = $reg['id'];
            $nombre = $reg['nombre'];
            $imagen = $reg['imagen'];
            $codigo = $reg['codigo_sku'];

            $rutaimage = "/uploads/nofoto.jpg";
            if ($reg['imagen']) {
                $rutaimage = $reg['imagen'];
            }

            $url = '/index.php/producto_vendedor/producto?movi=' . $movi . '&id=' . $regid;
            if ($_SERVER['SERVER_NAME'] == "veniaerp") {
                $url = '/venia_dev.php/producto_vendedor/producto?movi=' . $movi . '&id=' . $regid;
            }

//            $row[] = '<a href="' . $url . '">' . '<img src="' . $rutaimage . '" height="45px" >' . '</a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $codigo . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $nombre . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1"><i class="  flaticon2-next"></i><i class="  flaticon2-next"></i><font></a>';

            $output["aaData"][] = $row;
        }
        $this->renderText(json_encode($output));
        return sfView::NONE;
    }

    public function executeIndex(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $this->id = $id;
    }

    public function executeIndexPro(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $this->id = $id;
    }

    public function executeIndexCliente(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $this->id = $id;
    }

    public function executeIndexProducto(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $this->id = $id;
    }

    public function executeTabJsProductoCotiTodas(sfWebRequest $r) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $busqueda = trim($r->getParameter('sSearch', ''));

        $con = Propel::getConnection();

        // ðŸ” WHERE seguro
        $where = "vi.empresa_id = :empresa";
        $params = [':empresa' => $empresaId];

        if ($busqueda != "") {
            $busquedaLike = "%" . str_replace(" ", "%", $busqueda) . "%";
            $where .= " AND (vi.nombre LIKE :busqueda OR vi.codigo_sku LIKE :busqueda)";
            $params[':busqueda'] = $busquedaLike;
        } else {
            // si no hay bÃºsqueda â†’ no devuelve nada
            $output = [
                "sEcho" => (int) $r->getParameter('sEcho'),
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => []
            ];
            return $this->renderText(json_encode($output));
        }

        // ðŸ”¢ COUNT
        $stmt = $con->prepare("SELECT COUNT(vi.id) FROM producto vi WHERE $where");
        $stmt->execute($params);
        $iTotal = $stmt->fetchColumn();

        // ðŸ“¦ DATA (YA TRAE EXISTENCIA Y TRANSITO â†’ elimina ProductoQuery)
        $sql = " SELECT vi.id,vi.nombre,vi.codigo_sku,vi.imagen, vi.combo_producto_id,( select sum(cantidad) from producto_existencia ee where ee.producto_id= vi.id)  existencia  FROM producto vi  WHERE $where    LIMIT 0, 500    ";

        $stmt = $con->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();

        $rResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $output = [
            "sEcho" => (int) $r->getParameter('sEcho'),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => []
        ];

        $base = ($_SERVER['SERVER_NAME'] == "veniaimp") ? '/venia_dev.php' : '/index.php';

        foreach ($rResult as $reg) {

            // ðŸš« misma lÃ³gica original
            if (!empty(trim($reg['combo_producto_id']))) {
                continue;
            }

            // âš¡ ya no hay query aquÃ­
            $exit = (float) $reg['existencia'];

            $url = $base . '/orden_cotizacion/producto?id=' . $reg['id'];

            $row = [];
            $row[] = '<a href="' . $url . '"><font size="-1">' . $reg['codigo_sku'] . '</font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $reg['nombre'] . '</font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $exit . '</font></a>';

            $output["aaData"][] = $row;
        }

        return $this->renderText(json_encode($output));
    }

    public function executeTabJsProveedor(sfWebRequest $r) {
        $ini = 0;
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        if ($r->getParameter('iDisplayStart')) {
            $ini = $r->getParameter('iDisplayStart');
        }
        $sqlexp = "SELECT count(id) as cantidad FROM  proveedor where id=-1";
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');

        if ($r->getParameter('sSearch') != "") {
            $busqueda = $r->getParameter('sSearch');
            $sqlexp = "select count(vi.id) as cantidad  from proveedor vi  where  (vi.nombre like  '%" . $busqueda . "%'
                or vi.nit like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId;
        }
        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $iTotal = $result[0]["cantidad"];
//    $query = new ProductoQuery();
        if ($r->getParameter('sSearch') != "") {
            $sqlexp = "select vi.id,nit, codigo,nombre  from proveedor vi  where  (vi.nombre like  '%" . $busqueda . "%'
                or vi.nit like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId . " limit " . $ini . ", 10";
        } else {
            $sqlexp = "select  id, '' as nombre, nit,  codigo   from proveedor  where id= -9";
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
            $nombre = $reg['nombre'];
            $nit = $reg['nit'];
            $codigo = $reg['codigo'];
            $url = '/index.php/orden_compra/propi?id=' . $regid;
            if ($_SERVER['SERVER_NAME'] == "veniaerp") {
                $url = '/venia_dev.php/orden_compra/propi?id=' . $regid;
            }
            if ($_SERVER['SERVER_NAME'] == "veniaimp") {
                $url = '/venia_dev.php/orden_compra/propi?id=' . $regid;
            }
            $row[] = '<a href="' . $url . '"><font size="-2">' . $codigo . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $nombre . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $nit . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1"><i class="  flaticon2-next"></i><font></a>';

            $output["aaData"][] = $row;
        }
        $this->renderText(json_encode($output));
        return sfView::NONE;
    }

    public function executeTabJsProducto(sfWebRequest $r) {
        $ini = 0;
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');

        if ($r->getParameter('iDisplayStart')) {
            $ini = $r->getParameter('iDisplayStart');
        }
        $sqlexp = "SELECT count(id) as cantidad FROM  producto where  empresa_id=" . $empresaId;
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');

        if ($r->getParameter('sSearch') != "") {
            $busqueda = $r->getParameter('sSearch');
        }

        if ($r->getParameter('sSearch') != "") {

            $sqlexp = "select count(vi.id) as cantidad from producto vi  where  (vi.nombre like  '%" . $busqueda . "%'
                or vi.codigo_sku like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId;
        }


        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $iTotal = $result[0]["cantidad"];
//    $query = new ProductoQuery();
        $sqlexp = "select vi.id,imagen, codigo_sku,nombre  from producto vi  where    vi.empresa_id=" . $empresaId . " limit 0, 5";

        if ($r->getParameter('sSearch') != "") {
            $sqlexp = "select vi.id,imagen, codigo_sku,nombre  from producto vi   where  (vi.nombre like  '%" . $busqueda . "%'
                or vi.codigo_sku like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId . " limit " . $ini . ", 5";
//        } else {
//            $sqlexp = "select  id, '' as nombre, nit,  codigo   from proveedor  where id= -9";
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
            $nombre = $reg['nombre'];
            $imagen = $reg['imagen'];
            $codigo = $reg['codigo_sku'];

            $rutaimage = "/uploads/nofoto.jpg";
            if ($reg['imagen']) {
                $rutaimage = $reg['imagen'];
            }

            $url = '/index.php/orden_compra/producto?id=' . $regid;

            if ($_SERVER['SERVER_NAME'] == "veniaerp") {
                $url = '/venia_dev.php/orden_compra/producto?id=' . $regid;
            }
//            $row[] = '<a href="' . $url . '">' . '<img src="' . $rutaimage . '" height="45px" >' . '</a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $codigo . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $nombre . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1"><i class="  flaticon2-next"></i><i class="  flaticon2-next"></i><font></a>';

            $output["aaData"][] = $row;
        }
        $this->renderText(json_encode($output));
        return sfView::NONE;
    }

    public function executeTabJsProductoCoti(sfWebRequest $r) {
        $ini = 0;
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');

        if ($r->getParameter('iDisplayStart')) {
            $ini = $r->getParameter('iDisplayStart');
        }
        $sqlexp = "SELECT count(id) as cantidad FROM  producto where id=-1";
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');

        if ($r->getParameter('sSearch') != "") {
            $busqueda = $r->getParameter('sSearch');
            $sqlexp = "select count(vi.id) as cantidad from producto vi  where  (vi.nombre like  '%" . $busqueda . "%'
                or vi.codigo_sku like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId;
        }


        $OperacionId = sfContext::getInstance()->getUser()->getAttribute('CotizacionId', null, 'seguridad');
        $tiendaId = 0;
        $Cotizacion = OrdenCotizacionQuery::create()->findOneById($OperacionId);
        if ($Cotizacion) {
            $tiendaId = $Cotizacion->getTiendaId();
        }
//         
        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $iTotal = $result[0]["cantidad"];
//    $query = new ProductoQuery();
        if ($r->getParameter('sSearch') != "") {
            $sqlexp = "select vi.id,imagen, codigo_sku,nombre  from producto vi  where  (vi.nombre like  '%" . $busqueda . "%'
                or vi.codigo_sku like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId . " limit " . $ini . ", 5";
        } else {
            $sqlexp = "select  id, '' as nombre, nit,  codigo   from proveedor  where id= -9";
        }
//                echo $sqlexp;
//        die();
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
//        $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodega');
        foreach ($rResult as $reg) {

            $productoQ = ProductoQuery::create()->findOneById($reg['id']);
            if (trim($productoQ->getComboProductoId()) == "") {
                if ($productoQ) {
                    $exit = $productoQ->getExistenciaBodega($tiendaId);
                }
                $row = array();
                $regid = $reg['id'];
                $nombre = $reg['nombre'];
                $imagen = $reg['imagen'];
                $codigo = $reg['codigo_sku'];
                $rutaimage = "/uploads/nofoto.jpg";
                if ($reg['imagen']) {
                    $rutaimage = $reg['imagen'];
                }
                $url = '/index.php/orden_cotizacion/producto?id=' . $regid;
                if ($_SERVER['SERVER_NAME'] == "veniaerp") {
                    $url = '/venia_dev.php/orden_cotizacion/producto?id=' . $regid;
                }
                $row[] = '<a href="' . $url . '">' . '<img src="' . $rutaimage . '" height="45px" >' . '</a>';
                $row[] = '<a href="' . $url . '"><font size="-1">' . $codigo . '<font></a>';
                $row[] = '<a href="' . $url . '"><font size="-1">' . $nombre . '<font></a>';
//            $row[] = '<a href="' . $url . '"><font size="-1"><i class="  flaticon2-next"></i><i class="  flaticon2-next"></i><font></a>';
                $row[] = '<a href="' . $url . '"><font size="-1">' . $exit . '<font></a>';

                $output["aaData"][] = $row;
            }
        }
        $this->renderText(json_encode($output));
        return sfView::NONE;
    }

    public function executeTabJsCliente(sfWebRequest $r) {
        $ini = 0;
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');

        if ($r->getParameter('iDisplayStart')) {
            $ini = $r->getParameter('iDisplayStart');
        }
        $sqlexp = "SELECT count(id) as cantidad FROM  cliente where id=-1";
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');

        if ($r->getParameter('sSearch') != "") {
            $busqueda = $r->getParameter('sSearch');
            $sqlexp = "select count(vi.id) as cantidad  from cliente vi  where  (vi.nombre like  '%" . $busqueda . "%'
                or vi.nit like '%" . $busqueda . "%' or  vi.codigo like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId;
        }
        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $iTotal = $result[0]["cantidad"];
//    $query = new ProductoQuery();
        if ($r->getParameter('sSearch') != "") {
            $sqlexp = "select vi.id,nit, codigo,nombre  from cliente vi  where  (vi.nombre like  '%" . $busqueda . "%'
                or vi.nit like '%" . $busqueda . "%' or  vi.codigo like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId . " limit " . $ini . ", 10";
        } else {
            $sqlexp = "select  id, '' as nombre, nit,  codigo   from cliente  where id= -9";
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
            $nombre = $reg['nombre'];
            $nit = $reg['nit'];
            $codigo = $reg['codigo'];
            $clienteQ = ClienteQuery::create()->findOneById($regid);
            $color = "#121111";
            if ($clienteQ->getFacturaPendiente() <> "") {
                $color = '#E62802';
            }

            $url = '/index.php/orden_cotizacion/propi?id=' . $regid;
            $row[] = '<a href="' . $url . '"><font size="-2" color="' . $color . '">' . $codigo . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1"  color="' . $color . '">' . $nombre . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1"  color="' . $color . '">' . $nit . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1"  color="' . $color . '"><i class="  flaticon2-next"></i><font></a>';

            $output["aaData"][] = $row;
        }
        $this->renderText(json_encode($output));
        return sfView::NONE;
    }

}
