<?php

class reporte_preciosActions extends sfActions {

    private function obtenerListasPrecio($empresaId) {
        $con = Propel::getConnection();
        $sql = "SELECT id,nombre FROM lista_precio WHERE empresa_id=" . (int) $empresaId . " AND activo=1 ORDER BY nombre";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function obtenerPreciosSeleccionados($valores, $empresaId) {
        $listas = $this->obtenerListasPrecio($empresaId);
        $precios = array();
        $seleccionados = array();
        if (isset($valores['tipoprecio']) && !empty($valores['tipoprecio'])) {
            $seleccionados = $valores['tipoprecio'];
            if (!is_array($seleccionados))
                $seleccionados = array($seleccionados);
        }
        if (in_array('PRECIO', $seleccionados))
            $precios[] = array('id' => 'PRECIO', 'nombre' => 'Precio Venta');
        foreach ($listas as $lista) {
            if (in_array((string) $lista['id'], $seleccionados) || in_array((int) $lista['id'], $seleccionados))
                $precios[] = array('id' => (int) $lista['id'], 'nombre' => $lista['nombre']);
        }
        return $precios;
    }

    private function obtenerRegistros($valores, $empresaId) {
        $con = Propel::getConnection();
        $precios = $this->obtenerPreciosSeleccionados($valores, $empresaId);
        if (empty($precios))
            return array('registros' => array(), 'precios' => array());
        $query = "SELECT pro.id AS producto_id,pro.codigo_sku,pro.nombre,COALESCE(SUM(pe.cantidad),0) AS existencia";
        foreach ($precios as $precio) {
            if ($precio['id'] === 'PRECIO')
                $query .= ",MAX(pro.precio) AS precio_PRECIO";
            else {
                $id = (int) $precio['id'];
                $query .= ",MAX(CASE WHEN pp.lista_precio_id=" . $id . " THEN pp.valor ELSE NULL END) AS precio_" . $id;
            }
        }
        $query .= " FROM producto pro INNER JOIN producto_existencia pe ON pe.producto_id=pro.id AND pe.empresa_id=" . (int) $empresaId . " LEFT JOIN producto_precio pp ON pp.producto_id=pro.id AND pp.empresa_id=" . (int) $empresaId . " WHERE pro.empresa_id=" . (int) $empresaId;
        if (isset($valores['nombrebuscar']) && trim($valores['nombrebuscar']) != '') {
            $nombre = addslashes(trim($valores['nombrebuscar']));
            $query .= " AND (pro.codigo_sku LIKE '%" . $nombre . "%' OR pro.nombre LIKE '%" . $nombre . "%')";
        }
        $query .= " GROUP BY pro.id,pro.codigo_sku,pro.nombre HAVING COALESCE(SUM(pe.cantidad),0)>0 ORDER BY pro.codigo_sku,pro.nombre";
        $stmt = $con->prepare($query);
        $stmt->execute();
        return array('registros' => $stmt->fetchAll(PDO::FETCH_ASSOC), 'precios' => $precios);
    }

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $usuario = sfContext::getInstance()->getUser();
        $valores = unserialize($usuario->getAttribute('valores', null, 'reporte_precios_costo'));
        if (!$valores) {
            $valores = array('nombrebuscar' => null, 'tipoprecio' => array('PRECIO'));
            $usuario->setAttribute('valores', serialize($valores), 'reporte_precios_costo');
        }
        $empresaId = $usuario->getAttribute("usuario", null, 'empresa');
        $this->form = new ConsultaParaPreciosForm($valores);
        $listas = $this->obtenerListasPrecio($empresaId);
        $choices = array('PRECIO' => 'Precio Venta');
        foreach ($listas as $lista)
            $choices[$lista['id']] = $lista['nombre'];
        $this->form->setWidget('tipoprecio', new sfWidgetFormChoice(array('choices' => $choices, 'multiple' => true, 'expanded' => false)));
        $this->form->setValidator('tipoprecio', new sfValidatorChoice(array('choices' => array_keys($choices), 'multiple' => true, 'required' => false)));
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $usuario->setAttribute('valores', serialize($valores), 'reporte_precios_costo');
                $this->redirect('reporte_precios/index');
            }
        }
        $datos = $this->obtenerRegistros($valores, $empresaId);
        $this->registros = $datos['registros'];
        $this->precios = $datos['precios'];
    }

    public function executeReporte(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $usuario = sfContext::getInstance()->getUser();
        $valores = unserialize($usuario->getAttribute('valores', null, 'reporte_precios_costo'));
        if (!$valores)
            $valores = array('nombrebuscar' => null, 'tipoprecio' => array('PRECIO'));
        $empresaId = $usuario->getAttribute("usuario", null, 'empresa');
        $datos = $this->obtenerRegistros($valores, $empresaId);
        $result = $datos['registros'];
        $precios = $datos['precios'];
        $xl = new PHPExcel();
        $sheet = $xl->setActiveSheetIndex(0);
        $headers = array('Código', 'Producto', 'Existencia');
        foreach ($precios as $precio)
            $headers[] = $precio['nombre'];
        $col = 0;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($col, 1, $header);
            $col++;
        }
        $rowNumber = 2;
        foreach ($result as $row) {
            $col = 0;
            $sheet->setCellValueExplicit(PHPExcel_Cell::stringFromColumnIndex($col) . $rowNumber, $row['codigo_sku'], PHPExcel_Cell_DataType::TYPE_STRING);
            $col++;
            $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($col) . $rowNumber, $row['nombre']);
            $col++;
            $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($col) . $rowNumber, $row['existencia']);
            $col++;
            foreach ($precios as $precio) {
                $campo = $precio['id'] === 'PRECIO' ? 'precio_PRECIO' : 'precio_' . $precio['id'];
                $valor = isset($row[$campo]) ? $row[$campo] : null;
                $celda = PHPExcel_Cell::stringFromColumnIndex($col) . $rowNumber;
                if ($valor !== null) {
                    $sheet->setCellValue($celda, $valor);
                    $sheet->getStyle($celda)->getNumberFormat()->setFormatCode('#,##0.00');
                }
                $col++;
            }
            $rowNumber++;
        }
        $lastColumn = PHPExcel_Cell::stringFromColumnIndex(count($headers) - 1);
        $lastRow = max(1, $rowNumber - 1);
        $sheet->setAutoFilter('A1:' . $lastColumn . $lastRow);
        $sheet->getStyle('A1:' . $lastColumn . '1')->getFont()->setBold(true);
        if ($lastRow >= 2)
            $sheet->getStyle('C2:C' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');
        for ($i = 0; $i < count($headers); $i++) {
            $column = PHPExcel_Cell::stringFromColumnIndex($i);
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        $filename = 'Reporte_Precios_' . date('Ymd_His') . '.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $writer->save('php://output');
        exit;
    }
}
