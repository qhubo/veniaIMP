
<?php

class reporte_preciosActions extends sfActions {

    private function obtenerListasPrecio($empresaId) {
        $con = Propel::getConnection();
        $stmt = $con->prepare("SELECT id,nombre FROM lista_precio WHERE empresa_id=:empresa AND activo=1 ORDER BY nombre");
        $stmt->execute(array(':empresa'=>(int)$empresaId));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function obtenerPreciosSeleccionados($valores,$empresaId) {
        $listas=$this->obtenerListasPrecio($empresaId);
        $seleccionados=isset($valores['tipoprecio'])?(array)$valores['tipoprecio']:array();
        $precios=array();

        if(in_array('PRECIO',$seleccionados,true))
            $precios[]=array('id'=>'PRECIO','nombre'=>'Precio Venta');

        foreach($listas as $lista) {
            if(in_array((string)$lista['id'],$seleccionados,true))
                $precios[]=array('id'=>(int)$lista['id'],'nombre'=>$lista['nombre']);
        }

        return $precios;
    }


private function obtenerRegistros($valores,$empresaId) {
    $con=Propel::getConnection();
    $empresaId=(int)$empresaId;
    $precios=$this->obtenerPreciosSeleccionados($valores,$empresaId);

    if(empty($precios))
        return array('registros'=>array(),'precios'=>array());

    $select='';
    $columnasPrecios='';

    foreach($precios as $precio) {
        if($precio['id']==='PRECIO') {
            $select.=',pro.precio AS precio_PRECIO';
        } else {
            $id=(int)$precio['id'];
            $select.=',pp.precio_'.$id;
            $columnasPrecios.=',MAX(CASE WHEN lista_precio_id='.$id.' THEN valor ELSE NULL END) AS precio_'.$id;
        }
    }

    $sql="SELECT pro.id AS producto_id,pro.codigo_sku,pro.nombre,
                 ex.existencia".$select."
          FROM producto pro
          INNER JOIN (
              SELECT producto_id,SUM(cantidad) AS existencia
              FROM producto_existencia
              WHERE empresa_id=:empresa_existencia
              GROUP BY producto_id
              HAVING SUM(cantidad)>0
          ) ex ON ex.producto_id=pro.id";

    if($columnasPrecios!=='') {
        $sql.=" LEFT JOIN (
                    SELECT producto_id".$columnasPrecios."
                    FROM producto_precio
                    GROUP BY producto_id
                ) pp ON pp.producto_id=pro.id";
    }

    $sql.=" WHERE pro.empresa_id=:empresa_producto";

    $params=array(
        ':empresa_existencia'=>$empresaId,
        ':empresa_producto'=>$empresaId
    );

    if(isset($valores['nombrebuscar']) && trim($valores['nombrebuscar'])!=='') {
        $sql.=" AND (pro.codigo_sku LIKE :buscar_codigo OR pro.nombre LIKE :buscar_nombre)";
        $buscar='%'.trim($valores['nombrebuscar']).'%';
        $params[':buscar_codigo']=$buscar;
        $params[':buscar_nombre']=$buscar;
    }

    $sql.=" ORDER BY pro.codigo_sku,pro.nombre";
    $stmt=$con->prepare($sql);
    $stmt->execute($params);

    return array(
        'registros'=>$stmt->fetchAll(PDO::FETCH_ASSOC),
        'precios'=>$precios
    );
}


    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set('America/Guatemala');

        $usuario=$this->getUser();
        $valores=unserialize($usuario->getAttribute('valores',null,'reporte_precios_costo'));

        if(!is_array($valores)) {
            $valores=array('nombrebuscar'=>'','tipoprecio'=>array('PRECIO'));
            $usuario->setAttribute('valores',serialize($valores),'reporte_precios_costo');
        }

        $empresaId=(int)$usuario->getAttribute('usuario',null,'empresa');
        $this->form=new ConsultaParaPreciosForm($valores);

        if($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'),$request->getFiles('consulta'));

            if($this->form->isValid()) {
                $valores=$this->form->getValues();
                $usuario->setAttribute('valores',serialize($valores),'reporte_precios_costo');
                $this->redirect('reporte_precios/index');
            }
        }

        $datos=$this->obtenerRegistros($valores,$empresaId);
        $this->registros=$datos['registros'];
        $this->precios=$datos['precios'];
    }

    public function executeReporte(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set('America/Guatemala');

        $usuario=$this->getUser();
        $valores=unserialize($usuario->getAttribute('valores',null,'reporte_precios_costo'));

        if(!is_array($valores))
            $valores=array('nombrebuscar'=>'','tipoprecio'=>array('PRECIO'));

        $empresaId=(int)$usuario->getAttribute('usuario',null,'empresa');
        $datos=$this->obtenerRegistros($valores,$empresaId);
        $registros=$datos['registros'];
        $precios=$datos['precios'];

        if(empty($precios)) {
            $this->getUser()->setFlash('error','Seleccione al menos una lista de precios.');
            $this->redirect('reporte_precios/index');
        }

        $xl=new PHPExcel();
        $sheet=$xl->setActiveSheetIndex(0);
        $sheet->setTitle('Reporte de precios');

        $headers=array('Código','Producto','Existencia');
        foreach($precios as $precio)
            $headers[]=$precio['nombre'];

        foreach($headers as $i=>$header)
            $sheet->setCellValueByColumnAndRow($i,1,$header);

        $fila=2;

        foreach($registros as $row) {
            $col=0;
            $sheet->setCellValueExplicitByColumnAndRow($col++,$fila,$row['codigo_sku'],PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueByColumnAndRow($col++,$fila,$row['nombre']);
            $sheet->setCellValueByColumnAndRow($col++,$fila,$row['existencia']);

            foreach($precios as $precio) {
                $campo=$precio['id']==='PRECIO'?'precio_PRECIO':'precio_'.$precio['id'];
                $valor=isset($row[$campo])?$row[$campo]:null;

                if($valor!==null && $valor!=='') {
                    $sheet->setCellValueByColumnAndRow($col,$fila,$valor);
                    $sheet->getStyleByColumnAndRow($col,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
                }
                $col++;
            }

            $fila++;
        }

        $ultimaColumna=PHPExcel_Cell::stringFromColumnIndex(count($headers)-1);
        $ultimaFila=max(1,$fila-1);

        $sheet->getStyle('A1:'.$ultimaColumna.'1')->getFont()->setBold(true);
        $sheet->getStyle('C2:C'.$ultimaFila)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->setAutoFilter('A1:'.$ultimaColumna.$ultimaFila);

        for($i=0;$i<count($headers);$i++)
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setAutoSize(true);

        $filename='Reporte_Precios_'.date('Ymd_His').'.xls';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        PHPExcel_IOFactory::createWriter($xl,'Excel5')->save('php://output');
        exit;
    }
}
