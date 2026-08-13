<?php

class reporte_inventario_marcaActions extends sfActions {

    
    public function executeReporte(sfWebRequest $request)
{
    error_reporting(-1);

    $empresaId = sfContext::getInstance()
            ->getUser()
            ->getAttribute("usuario", null, 'empresa');

    /*
     * Recuperar los filtros utilizados
     * en la última búsqueda
     */
    $valores = unserialize(
            sfContext::getInstance()
                    ->getUser()
                    ->getAttribute(
                            'valores',
                            null,
                            'reporteInventarioMarca'
                    )
    );

    if (!$valores) {
        $valores = array();
    }

    /*
     * Obtener los productos utilizando
     * exactamente los mismos filtros
     */
    $productos = $this->buscarProductos(
            $empresaId,
            $valores
    );

    /*
     * Obtener marcas de vehículo
     */
    $marcasVehiculo = array();

    if ($productos) {

        $productoIds = array();

        foreach ($productos as $producto) {
            $productoIds[] = $producto->getId();
        }

        if (!empty($productoIds)) {

            $productoMarcas = ProductoMarcaQuery::create()
                    ->filterByEmpresaId($empresaId)
                    ->filterByProductoId($productoIds)
                    ->orderByMarca('Asc')
                    ->find();

            foreach ($productoMarcas as $productoMarca) {

                $productoId = $productoMarca->getProductoId();

                if (!isset($marcasVehiculo[$productoId])) {
                    $marcasVehiculo[$productoId] = array();
                }

                $marcasVehiculo[$productoId][] =
                        $productoMarca->getMarca();
            }
        }
    }


    /*
     * ==========================================
     * CREAR EXCEL
     * ==========================================
     */

    $nombreempresa = "Golden";

    $pestanas = array(
        'PRODUCTOS'
    );

    $filename = "REPORTE_PRODUCTOS_MARCA_VEHICULO";

    $xl = sfContext::getInstance()
            ->getUser()
            ->nuevoExcel(
                    $nombreempresa,
                    $pestanas,
                    $pestanas[0]
            );

    $sheet = $xl->setActiveSheetIndex(0);


    /*
     * ==========================================
     * ANCHOS
     * ==========================================
     */

    $widths = array(
        5,      // No
        18,     // SKU
        60,     // Producto
        25,     // Marca Producto
        50,     // Marcas Vehículo
        15,     // Existencia
        15      // Precio
    );

    $col = 'A';

    foreach ($widths as $w) {

        $sheet
                ->getColumnDimension($col)
                ->setWidth($w);

        $col++;
    }


    /*
     * ==========================================
     * TITULO
     * ==========================================
     */

    $sheet->mergeCells("A1:G1");

    $sheet->setCellValue(
            "A1",
            "REPORTE DE PRODUCTOS POR MARCA DE VEHÍCULO"
    );

    $sheet
            ->getStyle("A1")
            ->getFont()
            ->setSize(16)
            ->setBold(true);

    $sheet
            ->getStyle("A1")
            ->getAlignment()
            ->setHorizontal(
                    PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            );


    /*
     * ==========================================
     * FILTRO
     * ==========================================
     */

    $marcaFiltro = '';

    if (!empty($valores['marcaVehiculo'])) {
        $marcaFiltro = $valores['marcaVehiculo'];
    } else {
        $marcaFiltro = 'TODAS LAS MARCAS';
    }

    $sheet->mergeCells("A2:G2");

    $sheet->setCellValue(
            "A2",
            "Marca de vehículo: " . $marcaFiltro
    );

    $sheet
            ->getStyle("A2")
            ->getAlignment()
            ->setHorizontal(
                    PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            );


    /*
     * ==========================================
     * ENCABEZADOS
     * ==========================================
     */

    $fila = 4;

    $headers = array(
        "No",
        "Código SKU",
        "Producto",
        "Marca Producto",
        "Marcas Vehículo",
        "Existencia",
        "Precio"
    );

    $col = "A";

    foreach ($headers as $h) {

        $sheet->setCellValue(
                $col . $fila,
                $h
        );

        $sheet
                ->getStyle($col . $fila)
                ->getFont()
                ->setBold(true);

        $sheet
                ->getStyle($col . $fila)
                ->getAlignment()
                ->setHorizontal(
                        PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                );

        $sheet
                ->getStyle($col . $fila)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(
                        PHPExcel_Style_Border::BORDER_THIN
                );

        $col++;
    }


    /*
     * ==========================================
     * DETALLE
     * ==========================================
     */

    $numero = 0;

    foreach ($productos as $producto) {

        $numero++;

        $fila++;

        /*
         * Marcas del producto
         */
        $marcas = array();

        if (isset($marcasVehiculo[$producto->getId()])) {
            $marcas = $marcasVehiculo[$producto->getId()];
        }

        $marcasTexto = implode(
                ", ",
                $marcas
        );


        /*
         * Datos
         */
        $sheet->setCellValue(
                "A" . $fila,
                $numero
        );

        $sheet->setCellValue(
                "B" . $fila,
                $producto->getCodigoSku()
        );

        $sheet->setCellValue(
                "C" . $fila,
                $producto->getNombre()
        );

        $sheet->setCellValue(
                "D" . $fila,
                $producto->getMarcaProducto()
        );

        $sheet->setCellValue(
                "E" . $fila,
                $marcasTexto
        );

        $sheet->setCellValue(
                "F" . $fila,
                $producto->getExistencia()
        );

        $sheet->setCellValue(
                "G" . $fila,
                (float) $producto->getPrecio()
        );


        /*
         * Bordes
         */
        foreach (range('A', 'G') as $c) {

            $sheet
                    ->getStyle($c . $fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                            PHPExcel_Style_Border::BORDER_THIN
                    );
        }
    }


    /*
     * ==========================================
     * FORMATO NUMÉRICO
     * ==========================================
     */

    if ($fila >= 5) {

        $sheet
                ->getStyle("F5:F" . $fila)
                ->getNumberFormat()
                ->setFormatCode('#,##0');

        $sheet
                ->getStyle("G5:G" . $fila)
                ->getNumberFormat()
                ->setFormatCode('#,##0.00');
    }


    /*
     * ==========================================
     * ALINEACIÓN
     * ==========================================
     */

    $sheet
            ->getStyle("A5:A" . $fila)
            ->getAlignment()
            ->setHorizontal(
                    PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            );

    $sheet
            ->getStyle("F5:G" . $fila)
            ->getAlignment()
            ->setHorizontal(
                    PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
            );


    /*
     * ==========================================
     * FILTRO EXCEL
     * ==========================================
     */

    $sheet->setAutoFilter(
            "A4:G4"
    );

    /*
     * Congelar encabezado
     */
    $sheet->freezePane('A5');


    /*
     * ==========================================
     * SALIDA
     * ==========================================
     */

    header(
            'Content-Type: application/vnd.ms-excel'
    );

    header(
            'Content-Disposition: attachment;filename="' .
            $filename .
            '.xls"'
    );

    header(
            'Cache-Control: max-age=0'
    );

    $writer = PHPExcel_IOFactory::createWriter(
            $xl,
            'Excel5'
    );

    $writer->save(
            'php://output'
    );

    throw new sfStopException();
}
    public function executeIndex(sfWebRequest $request) {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $datos = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'reporteInventarioMarca'));
        $default = array();
        if ($datos) {
            $default = $datos;
        }
        $this->form = new consultaProductoMarcaVehiculoForm($default);
        $valores = $default;
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'reporteInventarioMarca');
            }
        }
        $this->productos = $this->buscarProductos($empresaId, $valores);
        $this->marcasVehiculo = array();
        if ($this->productos) {
            $productoIds = array();
            foreach ($this->productos as $producto) {
                $productoIds[] = $producto->getId();
            }
            if (!empty($productoIds)) {
                $productoMarcas = ProductoMarcaQuery::create()
                        ->filterByEmpresaId($empresaId)
                        ->filterByProductoId($productoIds)
                        ->orderByMarca('Asc')
                        ->find();
                foreach ($productoMarcas as $productoMarca) {
                    $productoId = $productoMarca->getProductoId();
                    if (!isset($this->marcasVehiculo[$productoId])) {
                        $this->marcasVehiculo[$productoId] = array();
                    }
                    $this->marcasVehiculo[$productoId][] = $productoMarca->getMarca();
                }
            }
        }
        $this->total = count($this->productos);
    }

    private function buscarProductos($empresaId, $valores) {
        $query = new ProductoQuery();
        $query->filterByComboProductoId(null);
        if (!empty($valores['producto'])) {
            $texto = trim($valores['producto']);
            $query->where("(Producto.CodigoSku LIKE '%" . $texto . "%' OR Producto.Nombre LIKE '%" . $texto . "%')");
        }

        if (!empty($valores['marcaVehiculo'])) {
            $productoMarcas = ProductoMarcaQuery::create()
                    ->filterByEmpresaId($empresaId)
                    ->filterByMarca($valores['marcaVehiculo'])
                    ->find();
            $productoIds = array();
            foreach ($productoMarcas as $productoMarca) {
                $productoIds[] = $productoMarca->getProductoId();
            }
            if (empty($productoIds)) {
                return array();
            }
            $query->filterById($productoIds);
        }

        return $query
                        ->orderByCodigoSku('Asc')
                        ->find();
    }
}
