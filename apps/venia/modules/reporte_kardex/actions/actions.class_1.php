<?php

/**
 * reporte_kardex actions.
 *
 * @package    plan
 * @subpackage reporte_kardex
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporte_kardexActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaKa'));
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['bodega'] = null;
            $valores['tipo'] = null;
            $valores['tipo'] = null;
            $valores['motivo'] = null;
            $valores['nombrebuscar'] = null;
            sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'consultaKa');
        }

        $this->form = new ConsultaParaKardexForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'consultaKa');
//                echo "<pre>";
//                print_r($valores);
//                die();
            }
        }
        $fechaInicio = $valores['fechaInicio'];
        $fechaFin = $valores['fechaFin'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $operaciones = new ProductoMovimientoQuery();

        $operaciones->useProductoQuery();
        $operaciones->where("Producto.EmpresaId = " . $empresaId);
        $operaciones->where("ProductoMovimiento.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("ProductoMovimiento.Fecha <= '" . $fechaFin . " 23:59:00" . "'");
        if ($valores['tipo']) {
            $operaciones->filterByTipo($valores['tipo']);
            // => 
        }
        if ($valores['bodega']) {
            $operaciones->filterByBodegaId($valores['bodega']);
            // => 
        }
        if ($valores['motivo']) {
            $operaciones->filterByMotivo($valores['motivo']);
            // => 
        }
        if ($valores['nombrebuscar']) {
            $nombre = $valores['nombrebuscar'];
            $operaciones->where(" ( Producto.CodigoSku like  '%" . $nombre . "%' or Producto.Nombre like  '%" . $nombre . "%')");
        }
        $operaciones->orderById('Desc');
        $this->movimiento = $operaciones->find();
    }

    public function executeReporte(sfWebRequest $request) {
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('valores', null, 'consultaKa'));

        $bodegas = BodegaQuery::create()->orderByNombre()->find();
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOne();
        $nombreempresa = "Modelo";
        $pestanas[] = 'MOVIMIENTO';
        $nombreEMpresa = $EmpresaQuery->getNombre();
//        $color = $EmpresaQuery->getColorUno();
//        $color = str_replace("#", "", $color);
        //   $styleArray = $EmpresaQuery->getEstiloExcel();
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $logoFile = $EmpresaQuery->getLogo();
        $filename = "MOVIMIENTO_DE_PRODUCTOS" . date("d_m_Y");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $hoja = $xl->setActiveSheetIndex(0);
        //CABECERA  Y FILTRO        
        $hoja->getRowDimension('1')->setRowHeight(15);
        $hoja->getRowDimension('2')->setRowHeight(20);
        $textoBusqueda = $this->textobusqueda($valores);
        $hoja->mergeCells("A1:A2");
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit("REPORTE", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(13);
        // $hoja->getStyle("B1")->applyFromArray($styleArray);
        $hoja->getCell("C1")->setValueExplicit("Kardex productos ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C1")->getFont()->setBold(true);
        $hoja->getStyle("C1")->getFont()->setSize(10);

        $hoja->mergeCells("C1:E1");
        $hoja->getCell("B2")->setValueExplicit("Busqueda ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B2")->getFont()->setBold(true);
        $hoja->getStyle("B2")->getFont()->setSize(10);
        $hoja->getCell("C2")->setValueExplicit($textoBusqueda, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle('C2')->getAlignment()->setWrapText(true);
        $hoja->mergeCells("C2:G2");
        $fila = 3;
        $columna = 0;
        $encabezados = null;
        $encabezados[] = array("Nombre" => strtoupper("Fecha"), "width" => 22, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Bodega"), "width" => 45, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Tipo"), "width" => 15, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Identificador"), "width" => 15, "align" => "rigth", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Motivo"), "width" => 35, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Codigo"), "width" => 20, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Producto"), "width" => 50, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Inicial"), "width" => 15, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Cantidad"), "width" => 15, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Final"), "width" => 15, "align" => "rigth", "format" => "#,##0.00");

        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $fechaInicio = $valores['fechaInicio'];
        $fechaFin = $valores['fechaFin'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

        $operaciones = new ProductoMovimientoQuery();
        $operaciones->useProductoQuery();
        $operaciones->where("Producto.EmpresaId = " . $empresaId);
        $operaciones->where("ProductoMovimiento.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("ProductoMovimiento.Fecha <= '" . $fechaFin . " 23:59:00" . "'");
        if ($valores['tipo']) {
            $operaciones->filterByTipo($valores['tipo']);
            // => 
        }
        if ($valores['bodega']) {
            $operaciones->filterByBodegaId($valores['bodega']);
            // => 
        }
        if ($valores['motivo']) {
            $operaciones->filterByMotivo($valores['motivo']);
            // => 
        }
        if ($valores['nombrebuscar']) {
            $nombre = $valores['nombrebuscar'];
            $operaciones->where(" ( Producto.CodigoSku like  '%" . $nombre . "%' or Producto.Nombre like  '%" . $nombre . "%')");
        }

        $operaciones->orderByFecha('Desc');
        $movimiento = $operaciones->find();
        foreach ($movimiento as $reg) {
            $fila++;
            $datos = null;

            $datos[] = array("tipo" => 3, "valor" => $reg->getFecha('d/m/Y H:i:s'));
            $datos[] = array("tipo" => 3, "valor" => $reg->getTienda());
            $datos[] = array("tipo" => 3, "valor" => $reg->getTipo());
            $datos[] = array("tipo" => 3, "valor" => $reg->getIdentificador());
            $datos[] = array("tipo" => 3, "valor" => $reg->getMotivo());
            $datos[] = array("tipo" => 3, "valor" => $reg->getProducto()->getCodigoSku());
            $datos[] = array("tipo" => 3, "valor" => $reg->getProducto()->getNombre());
            $datos[] = array("tipo" => 3, "valor" => round($reg->getInicio(), 0));

            $datos[] = array("tipo" => 3, "valor" => round($reg->getCantidad(), 0));
            $datos[] = array("tipo" => 3, "valor" => round($reg->getFin(), 0));

            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;

        $LetraFin = UsuarioQuery::numeroletra(10);
        $hoja->getCell("A" . $fila)->setValueExplicit("ULTIMA LINEA", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B" . $fila . ":" . $LetraFin . $fila);
        //  $color = str_replace("#", "", $color);
        //  $hoja->getStyle("A" . $fila)->applyFromArray($styleArray);
        //  $hoja->getStyle("B" . $fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($color);


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function textobusqueda($valores) {
        $textoBusqueda = '';
        $Busqueda = null;

        foreach ($valores as $clave => $valor) {
            $clave = trim(strtoupper($clave));
//            echo $clave;
//            echo "<br>";
            if ($valor) {
                if ($clave == 'FECHAINICIO') {
                    $Busqueda[] = 'DEL ' . $valor;
                }
                if ($clave == 'FECHAFIN') {
                    $Busqueda[] = ' AL  ' . $valor;
                }
                if ($clave == 'BODEGA') {
                    $query = BodegaQuery::create()->findOneById($valor);
                    if ($query) {
                        $valor = $query->getNombre();
                    }
                    $Busqueda[] = ' BODEGA: ' . $valor;
                }
                if ($clave == 'TIPO') {
                    $Busqueda[] = ' TIPO: ' . $valor;
                }
                if ($clave == 'MOTIVO') {
                    $Busqueda[] = ' MOTIVO: ' . $valor;
                }
                if ($clave == 'NOMBRE') {
                    $Busqueda[] = ' BUSCA: ' . $valor;
                }
            }
        }
        if ($Busqueda) {
            $textoBusqueda = implode(",", $Busqueda);
        }
        return $textoBusqueda;
    }

}
