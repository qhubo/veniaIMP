<?php

class buscaActions extends sfActions {


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
            $sqlexp = " select count(vi.id) as cantidad from producto vi  inner join producto_existencia ee on ee.cantidad >0   " ;
            $sqlexp .=" and ee.producto_id= vi.id  and tienda_id =".$tiendaId."   where   (vi.nombre like  '%" . $busqueda . "%'";
            $sqlexp .=" or vi.codigo_sku like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId;
        }


        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $iTotal = $result[0]["cantidad"];
//    $query = new ProductoQuery();
        $sqlexp = "select vi.id,imagen, codigo_sku,nombre ,  cantidad from producto vi inner join producto_existencia ee on ee.cantidad >0  and ee.producto_id= vi.id and tienda_id =".$tiendaId."   where   vi.empresa_id=" . $empresaId . " limit 0, 5";

        if ($r->getParameter('sSearch') != "") {
            $sqlexp = "select vi.id,imagen, codigo_sku,nombre, cantidad  from producto vi  inner join producto_existencia ee on ee.cantidad >0 ";
            $sqlexp .= " and ee.producto_id= vi.id and tienda_id =".$tiendaId."   where  (vi.nombre like  '%" . $busqueda . "%' or vi.codigo_sku like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId . " limit " . $ini . ", 5";
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
            $codigo = substr($reg['codigo_sku'], -6);

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
            $codigo = substr($reg['codigo_sku'], -6);

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
            $exit = 0;
            $productoQ = ProductoQuery::create()->findOneById($reg['id']);
            if (trim($productoQ->getComboProductoId()) == "") {
                if ($productoQ) {
                    $exit = $productoQ->getExistencia() - $productoQ->getTransito();
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
              //  $url = '/index.php/ubicacion/vista?id=' . $regid;
                if ($_SERVER['SERVER_NAME'] == "veniaerp") {
                    $url = '/venia_dev.php/orden_cotizacion/producto?id=' . $regid;
                 //   $url = '/venia_dev.php/ubicacion/vista?id=' . $regid;
                }
//                $row[] = ' <button class="open-producto btn" data-url="' . $url . '">' . '<img src="' . $rutaimage . '" height="45px" >' . '</button>';
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
        $sqlexp = "SELECT count(id) as cantidad FROM  producto where top_venta=1 and empresa_id=" . $empresaId;
        ;
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');

        if ($r->getParameter('sSearch') != "") {
            $busqueda = $r->getParameter('sSearch');
        }

        if ($r->getParameter('sSearch') != "") {

            $sqlexp = "select count(vi.id) as cantidad from producto vi  where top_venta=1 and  (vi.nombre like  '%" . $busqueda . "%'
                or vi.codigo_sku like '%" . $busqueda . "%') and  vi.empresa_id=" . $empresaId;
        }


        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $iTotal = $result[0]["cantidad"];
//    $query = new ProductoQuery();
        $sqlexp = "select vi.id,imagen, codigo_sku,nombre  from producto vi  where top_venta=1 and   vi.empresa_id=" . $empresaId . " limit 0, 5";

        if ($r->getParameter('sSearch') != "") {
            $sqlexp = "select vi.id,imagen, codigo_sku,nombre  from producto vi   where top_venta=1 and  (vi.nombre like  '%" . $busqueda . "%'
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
        $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodega');
        foreach ($rResult as $reg) {
            $row = array();
            $regid = $reg['id'];
            $nombre = $reg['nombre'];
            $imagen = $reg['imagen'];
            $codigo = substr($reg['codigo_sku'], -6);

            $rutaimage = "/uploads/nofoto.jpg";
            if ($reg['imagen']) {
                $rutaimage = $reg['imagen'];
            }

            $url = '/index.php/orden_compra/producto?id=' . $regid;
//            $row[] = '<a href="' . $url . '">' . '<img src="' . $rutaimage . '" height="45px" >' . '</a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $codigo . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $nombre . '<font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1"><i class="  flaticon2-next"></i><i class="  flaticon2-next"></i><font></a>';

            $output["aaData"][] = $row;
        }
        $this->renderText(json_encode($output));
        return sfView::NONE;
    }

    public function executeTabJsProductoBusca(sfWebRequest $r) {
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

        $tiendas = TiendaQuery::create()->find();

//        $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodega');
        foreach ($rResult as $reg) {

            $productoQ = ProductoQuery::create()->findOneById($reg['id']);
            if (trim($productoQ->getComboProductoId()) == "") {
                if ($productoQ) {
                    $exit = $productoQ->getExistencia();
                }
                $precio = $productoQ->getPrecio();
                $row = array();
                $regid = $reg['id'];
                $nombre = $reg['nombre'];
                $imagen = $reg['imagen'];
                $codigo = $reg['codigo_sku'];
                $rutaimage = "/uploads/nofoto.jpg";
                if ($reg['imagen']) {
                    $rutaimage = $reg['imagen'];
                }
                $url = '/index.php/ubicacion/index?id=' . $regid;
                if ($_SERVER['SERVER_NAME'] == "veniaerp") {
                    $url = '/venia_dev.php/ubicacion/index?id=' . $regid;
                }
                $row[] = '<a href="' . $url . '"><div "style:text-align:right">' . $codigo . "</div></a>";
                ;
                $row[] = '<a href="' . $url . '"><div "style:text-align:right">' . $nombre . "</div></a>";
                ;



//            $row[] = '<a href="' . $url . '"><font size="-1"><i class="  flaticon2-next"></i><i class="  flaticon2-next"></i><font></a>';

                foreach ($tiendas as $regi) {
                    $exit = $productoQ->getExistenciaBodega($regi->getId());
                    $row[] = '<a href="' . $url . '"><div "style:text-align:right">' . $exit . "</div></a>";
                }

                $row[] = '<div "style:text-align:right">' . Parametro::formato($precio, false) . "</div>";

                $output["aaData"][] = $row;
            }
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
