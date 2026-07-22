<?php

/**
 * reporte_inventario actions.
 *
 * @package    plan
 * @subpackage reporte_inventario
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporte_inventarioActions extends sfActions {




public function executeReporteCBMExcel(sfWebRequest $request)
{
    $productos = $this->datos();

    $xl = sfContext::getInstance()->getUser()->nuevoExcel(
        "REPORTE CBM",
        array('Reporte CBM'),
        'Reporte CBM'
    );

    $hoja = $xl->setActiveSheetIndex(0);

    // Encabezados
    $headers = array(
        "CODIGO",
        "DESCRIPCION",
        "MARCA",
        "EXISTENCIA",
        "PESO UND",
        "CBM UND"
    );

    $fila = 1;
    $col = 0;

    foreach ($headers as $h) {
        $hoja->setCellValueByColumnAndRow($col++, $fila, $h);
    }

    // Estilo encabezado
    $hoja->getStyle("A1:F1")->applyFromArray(array(
        'font' => array(
            'bold' => true,
            'size' => 11,
            'color' => array('rgb' => 'FFFFFF')
        ),
        'fill' => array(
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '1F4E78')
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    ));

    $hoja->freezePane('A2');

    $fila++;

    foreach ($productos as $producto) {

        $existencia = $producto->getExistencia();

//        if ($existencia <= 0) {
//            continue;
//        }

        // CBM
        $cbm = 0;

        if (
            $producto->getLargo() > 0 &&
            $producto->getAncho() > 0 &&
            $producto->getAlto() > 0
        ) {
            $cbm = round(
                $producto->getLargo() *
                $producto->getAncho() *
                $producto->getAlto(),
                3
            );
        }

        $col = 0;

        $hoja->setCellValueByColumnAndRow($col++, $fila, $producto->getCodigoSku());
        $hoja->setCellValueByColumnAndRow($col++, $fila, $producto->getNombre());
        $hoja->setCellValueByColumnAndRow($col++, $fila, $producto->getMarcaProducto());
        $hoja->setCellValueByColumnAndRow($col++, $fila, $existencia);
        $hoja->setCellValueByColumnAndRow($col++, $fila, (float)$producto->getPeso());
        $hoja->setCellValueByColumnAndRow($col++, $fila, (float)$cbm);

        $fila++;
    }

    // Formatos numéricos
    $hoja->getStyle("D2:D{$fila}")
            ->getNumberFormat()
            ->setFormatCode('#,##0');

    $hoja->getStyle("E2:E{$fila}")
            ->getNumberFormat()
            ->setFormatCode('#,##0.00');

    $hoja->getStyle("F2:F{$fila}")
            ->getNumberFormat()
            ->setFormatCode('0.000');

    // Auto ancho
    foreach (range('A', 'F') as $c) {
        $hoja->getColumnDimension($c)->setAutoSize(true);
    }

    // Bordes
    $hoja->getStyle("A1:F{$fila}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    // Autofiltro
    $hoja->setAutoFilter("A1:F1");

    // Salida
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Reporte_CBM.xls"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
    $writer->save('php://output');

    exit;
}


    
    public function executeReporteCBM(sfWebRequest $request)
{
  
    $text = date('YmdHis');
    $file = "Reporte_CBM_$text.csv";

    $this->getResponse()->setContentType('charset=utf-8');
    header('Expires: 0');
    header('Cache-Control: private');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $file . '"');
    header("Content-Transfer-Encoding: binary");

    $Datos = '';

    // Encabezados
    $encabezados = array(
        'CODIGO',
        'DESCRIPCION',
        'MARCAS',
        'EXISTENCIA',
        'PESO UND',
        'CBM UND'
    );

    $Datos .= implode(",", $encabezados) . "\r\n";

    $productos = $this->datos();

    foreach ($productos as $producto)
    {
        $existencia = $producto->getExistencia();

        if ($existencia <= 0)
            continue;

        // CBM
        $cbm = 0;

        if ($producto->getLargo() > 0 &&
            $producto->getAncho() > 0 &&
            $producto->getAlto() > 0)
        {
            $cbm = round(
                $producto->getLargo() *
                $producto->getAncho() *
                $producto->getAlto(),
                3
            );
        }

        $fila = array(
            "'" . str_replace(",", "", $producto->getCodigoSku()),
            '"' . str_replace('"', '""', $producto->getNombre()) . '"',
            '"' . str_replace('"', '""', $producto->getMarcaProducto()) . '"',
            $existencia,
            round($producto->getPeso(),2),
            $cbm
        );

        $Datos .= implode(",", $fila) . "\r\n";
    }

    echo "\xEF\xBB\xBF"; // UTF-8 BOM para Excel
    echo $Datos;
die();
}


    public function executeReporte(sfWebRequest $request) {
        $tipoPrecios = ListaPrecioQuery::create()->filterByConfidencial(false)->orderByNombre()->filterByActivo(true)->find();
        $tipoPrecioscon = ListaPrecioQuery::create()->filterByConfidencial(true)->orderByNombre()->filterByActivo(true)->find();
        $tipoUsua = strtoupper(sfContext::getInstance()->getUser()->getAttribute("tipoUsuario", null, 'seguridad'));
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        error_reporting(-1);
//        $bodegas = TiendaQuery::create()->orderByNombre()->find();
        $bodegas = ProductoExistenciaQuery::create()->useTiendaQuery()->endUse()->groupByTiendaId()->filterByEmpresaId($empresaId)->filterByCantidad(0, Criteria::GREATER_THAN)->find();
        $text = date('Ymd');
        $file = fopen("uploads/reporteInventario" . $text . ".csv", "w");
        $file = "reporteInventario" . $text . ".csv";
        $this->getResponse()->setContentType('charset=utf-8');
        header('Expires: 0');
        header('Cache-control: private');
        header('Content-Type: application/x-octet-stream'); // Archivo de Excel
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
        header('Last-Modified: ' . date('D, d M Y H:i:s'));
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header("Content-Transfer-Encoding: binary");

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'inventaConsu'));
        $filtro = false;
        if ($valores['tipo_filtro']) {
            $filtro = true;
        }
        $bodegaId = $valores['bodega'];
        $encabezados = null;
        $encabezados[] = "Codigo Sku";
        $encabezados[] = "Nombre";
        $encabezados[] = "Proveedor";
        $encabezados[] = "Marca";
        foreach ($bodegas as $data) {
            $bode = $data->getTienda();
            $encabezados[] = strtoupper($bode);
        }
        $encabezados[] = strtoupper("Precio");
        foreach ($tipoPrecios as $datad) {
            $encabezados[] = $datad->getNombre();
        }
        if ($tipoUsua == "ADMINISTRADOR") { 
             foreach ($tipoPrecioscon as $datad) {
            $encabezados[] = $datad->getNombre();
        }
        $encabezados[] = strtoupper("Costo");
        }
        $Datos = implode(",", $encabezados);
        $Datos .= "\r\n";
        $datosR = $this->datos();
        foreach ($datosR as $lista) {
            $pinta = true;
            if ($filtro) {
                $existencia = $lista->getExistenciaTotal($bodegaId);
                $pinta = false;
                if ($existencia > 0) {
                    $pinta = true;
                }
            }
            if ($pinta) {
                $datos = null;
                $datos[] = "'" . str_replace(",", "", $lista->getCodigoSku());  // ENTERO
                $datos[] = str_replace(",", "", $lista->getNombre());  // ENTERO
                $prove="";
                if ($lista->getProveedorId()) {
                    $prove= $lista->getProveedor()->getNombre();
                    
                }
                $datos[] =str_replace(",", "", $prove);
                $apar = TipoAparatoQuery::create()->findOneById($lista->getTipoAparatoId());
                $datos[] = $lista->getMarcaProducto(); //->getDescripcion();  // ENTERO

                
                
                foreach ($bodegas as $data) {
                    $bode = $data->getTienda();
                    $datos[] = $lista->getExistenciaBodega($bode->getId());  // ENTERO
                }
                $datos[] = round($lista->getPrecio(), 2);  // ENTERO

                foreach ($tipoPrecios as $datad) {
                    $datos[] = round($lista->getPrecioLista($datad->getId()), 2);  // ENTERO                          
                }
if ($tipoUsua == "ADMINISTRADOR") { 
       foreach ($tipoPrecioscon as $datad) {
                    $datos[] = round($lista->getPrecioLista($datad->getId()), 2);  // ENTERO                          
                }
                $datos[] = round($lista->getCostoProveedor(), 2);  // ENTERO
}
                $lineas = implode(",", $datos);
                $Datos .= $lineas;
                $Datos .= "\r\n";
            }
        }
        echo $Datos;
        die();
    }
    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        sfContext::getInstance()->getUser()->setAttribute("filtraExistencia", false, 'empresa');


        $datos = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'inventaConsu'));
        $default['bodega'] = $bodegaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'bodega');
        $valores = null;
        if ($datos) {
            $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'inventaConsu'));
            $default = $valores;
        }
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');

        //$this->bodegas = TiendaQuery::create()->orderByNombre()->find();
        $this->bodegas = ProductoExistenciaQuery::create()->useTiendaQuery()->endUse()->groupByTiendaId()->filterByEmpresaId($empresaId)->filterByCantidad(0, Criteria::GREATER_THAN)->find();


        $this->bodegaId = null;
        $this->form = new consultaProductoInventarioForm($default);
        // $this->total = ProductoQuery::create()->filterByComboProductoId(null)->count();
        //$this->productos = ProductoQuery::create()->find();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'inventaConsu');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'inventaConsu'));
            }
        }
        if ($valores) {
            if ($valores['bodega']) {
                $this->bodegas = ProductoExistenciaQuery::create()->filterByTiendaId($valores['bodega'])->groupByTiendaId()->find(); //TiendaQuery::create()->filterById($valores['bodega'])->find();
            }
            sfContext::getInstance()->getUser()->setAttribute("filtraExistencia", null, 'empresa');
            if ($valores['tipo_filtro']) {
                sfContext::getInstance()->getUser()->setAttribute("filtraExistencia", 1, 'empresa');
            }
        }
        $this->productos = $this->datos();
        $this->totalB = count($this->productos);
        $this->productosVence =null;
        $filtro = sfContext::getInstance()->getUser()->getAttribute("filtraExistencia", null, 'empresa');
        $this->filtro = $filtro;
        $this->bodegaId = $valores['bodega'];
//        echo $filtro;
//        die();
//    echo "<pre>";
//    print_r($this->productosVence);
//    die();
    }
    public function textobusqueda() {
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'inventaConsu'));
        $textoBusqueda = 'Todo los productos';
        $Busqueda = null;
        foreach ($valores as $clave => $valor) {
            $clave = strtoupper($clave);
            if ($valor) {
                if ($clave == 'NOMBREBUSCAR') {
                    $Busqueda[] = ': ' . $valor;
                }
                if ($clave == 'TIPO') {
                    $query = TipoAparatoQuery::create()->findOneById($valor);
                    if ($query) {
                        $valor = $query->getDescripcion();
                    }
                    $Busqueda[] = strtoupper(TipoAparatoQuery::tipo()) . ": " . $valor;
                }
                if ($clave == 'MODELO') {
                    $query = ModeloQuery::create()->findOneById($valor);
                    if ($query) {
                        $valor = $query->getDescripcion();
                    }
                    $Busqueda[] = strtoupper(TipoAparatoQuery::modelo()) . ": " . $valor;
                }
//            if ($clave == 'BODEGA') {
//                $Busqueda[]='BUSQUEDA : '; 
//            }
                if ($clave == 'MARCA') {
                    $query = MarcaQuery::create()->findOneById($valor);
                    if ($query) {
                        $valor = $query->getDescripcion();
                    }
                    $Busqueda[] = strtoupper(TipoAparatoQuery::marca()) . ": " . $valor;
                }
            }
        }
        if ($Busqueda) {
            $textoBusqueda = implode(",", $Busqueda);
        }
        return $textoBusqueda;
    }

    public function datos() {
        $productos = null;
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'inventaConsu'));
        if ($valores) {

            sfContext::getInstance()->getUser()->setAttribute("filtraExistencia", null, 'empresa');
            if ($valores['tipo_filtro']) {
                sfContext::getInstance()->getUser()->setAttribute("filtraExistencia", 1, 'empresa');
            }
            $nombre = $valores['nombrebuscar']; // => 4555
            $tipo = $valores['tipo']; // => 4
            $marca = $valores['marca']; // => 
            $modelo = $valores['modelo']; // =>
            $proveedor = $valores['proveedor'];             
            //   $estatus = $valores['estatus'];
            $operaciones = new ProductoQuery();
            $operaciones->filterByComboProductoId(null);
            if ($proveedor) {
             $operaciones->filterByProveedorId($proveedor);
            }
            if ($tipo) {
                $operaciones->filterByTipoAparatoId($tipo);
            }
            if ($marca) {
                $operaciones->filterByMarcaId($marca);
            }
            if ($modelo) {
                $operaciones->filterByModeloId($modelo);
            }
            // $operaciones->where(" ( nombre like  '%" . $nombre . "%' or codigo_sku like  '%" . $nombre . "%'  or descripcion like  '%" . $nombre . "%')");
            $productos = $operaciones->find();
        }
        return $productos;
    }

}
