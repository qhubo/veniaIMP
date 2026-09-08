<?php

class reporte_portafolioActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        if (!$empresaId) {
            sfContext::getInstance()->getUser()->setAttribute('usuario', false, 'filtra_empresa');
        }
        // Productos que cumplen las condiciones del portafolio
        $this->productos = ProductoQuery::create()
                ->filterByActivo(true)
                ->filterByImagen('', Criteria::NOT_EQUAL)
                ->find();
        // Obtener existencia acumulada por producto
        $existencias = ProductoExistenciaQuery::create()
                ->withColumn('SUM(producto_existencia.cantidad)', 'existencia_total')
                ->groupByProductoId()
                ->find();
        // Convertir las existencias en un arreglo
        $this->existencias = array();
        foreach ($existencias as $existencia) {
            $this->existencias[$existencia->getProductoId()] = (float) $existencia->getVirtualColumn('existencia_total');
        }
        foreach ($this->productos as $key => $producto) {
            $productoId = $producto->getId();
            $existencia = isset($this->existencias[$productoId]) ? $this->existencias[$productoId] : 0;
            if ($existencia <= 0) {
                unset($this->productos[$key]);
            }
        }

        $this->marcasVehiculo = array();
        foreach ($this->productos as $producto) {
            $productoId = $producto->getId();
            $marcasVehiculo = ProductoMarcaQuery::create()
                    ->filterByProductoId($productoId)
                    ->orderByMarca('Asc')
                    ->find();
            $this->marcasVehiculo[$productoId] = array();
            foreach ($marcasVehiculo as $productoMarca) {
                $this->marcasVehiculo[$productoId][] = $productoMarca->getMarca();
            }
        }
        $this->marcas = $this->marcasVehiculo;
        sfContext::getInstance()->getUser()->setAttribute('usuario', false, 'filtra_empresa');
    }

    public function executePdf(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        error_reporting(-1);
        $empresaId = 1;
        $productos = ProductoQuery::create()->filterByActivo(true)->filterByImagen('', Criteria::NOT_EQUAL)->find();
        $existenciasQuery = ProductoExistenciaQuery::create()
                ->withColumn('SUM(producto_existencia.cantidad)', 'existencia_total')
                ->groupByProductoId()
                ->find();
        $existencias = array();
        foreach ($existenciasQuery as $existencia) {
            $existencias[$existencia->getProductoId()] = (float) $existencia->getVirtualColumn('existencia_total');
        }
        $marcasVehiculo = array();
        foreach ($productos as $producto) {
            $productoId = $producto->getId();
            $marcas = ProductoMarcaQuery::create()
                    ->filterByEmpresaId($empresaId)
                    ->filterByProductoId($productoId)
                    ->orderByMarca('Asc')
                    ->find();
            $marcasVehiculo[$productoId] = array();
            foreach ($marcas as $productoMarca) {
                $marca = trim($productoMarca->getMarca());
                if ($marca != '') {
                    $marcasVehiculo[$productoId][] = $marca;
                }
            }
        }
//    foreach ($productos as $key => $producto) {
//        $productoId = $producto->getId();
//        $existencia = isset($existencias[$productoId])
//            ? $existencias[$productoId]
//            : 0;
//        if ($existencia <= 0) {
//            unset($productos[$key]);
//        }
//    }
        $empresa = null;
        if ($productos) {
            foreach ($productos as $producto) {
                $empresa = $producto->getEmpresa();
                break;
            }
        }
        $logo = '';
        if ($empresa) {
            $logo = $empresa->getLogo();
        }
        $html = $this->getPartial('reporte/portafolioProductos', array('productos' => $productos, 'existencias' => $existencias, 'marcasVehiculo' => $marcasVehiculo, 'empresa' => $empresa));
        $pdf = new sfTCPDF("P", "mm", "Letter");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Venia Link');
        $pdf->SetTitle("Portafolio de Productos");
        $pdf->SetSubject('Portafolio de Productos');
        $pdf->SetKeywords('Productos, Portafolio, Repuestos');
        $pdf->SetMargins(5, 8, 5);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetAutoPageBreak(true, 8);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('dejavusans', '', 8);
        $pdf->AddPage();
        if ($logo != '') {
            $img_file = "uploads/images/" . $logo;
            if (file_exists($img_file)) {
                $pdf->Image($img_file, 10, 5, 35);
            }
        }
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('Portafolio de Productos.pdf', 'I');
        die();
    }
}
