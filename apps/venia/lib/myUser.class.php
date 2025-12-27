<?php

class myUser extends sfBasicSecurityUser {

    static function restadosfechas($fechauno, $fechados) {
        $fechauno = strtotime($fechauno);
        $fechados = strtotime($fechados);
        $ano1 = date('Y', $fechauno);
        $mes1 = date('m', $fechauno);
        $dia1 = date('d', $fechauno);
        $ano2 = date('Y', $fechados);
        $mes2 = date('m', $fechados);
        $dia2 = date('d', $fechados);
        $timestamp1 = mktime(0, 0, 0, $mes1, $dia1, $ano1);
        $timestamp2 = mktime(0, 0, 0, $mes2, $dia2, $ano2);
        $segundos_diferencia = $timestamp1 - $timestamp2;
        $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
        $dias_diferencia = abs($dias_diferencia);
        $dias = floor($dias_diferencia);
        return $dias + 1;
    }

    static function FechaHumanoToFechaSql($fechaIni) {
        $fecha = explode('/', $fechaIni);
        if ((count($fecha)) > 1) {
            $Nuevafecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
        } else {
            $Nuevafecha = $fechaIni;
        }
        return $Nuevafecha;
    }

    public function nuevoExcel($empresa, $pestanas, $titulo, $logoFile = null) {
        $xl = new PHPExcel();
        $xl->getProperties()->setCreator("Pos_Venta")
                ->setLastModifiedBy("Pos_Venta")
                ->setTitle($titulo)
                ->setSubject($titulo)
                ->setDescription($titulo)
                ->setCategory("Reporte");
        $xl->getDefaultStyle()->getFont()->setName('Arial');
        $xl->getDefaultStyle()->getFont()->setSize(8);
        $xl->setActiveSheetIndex(0);
        $xl->setActiveSheetIndex()->setTitle($pestanas[0]);


        $contador = 0;
        foreach ($pestanas as $pestana) {
            if ($contador > 0) {
                $xl->createSheet($contador)->setTitle($pestana);
                $hoja = $xl->getActiveSheetIndex($contador);
                //   $hoja = $xl->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
                //   $hoja = $xl->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);
                //    $hoja = $xl->getActiveSheet()->setCellValue('A2', $empresa);
                //    $xl->getActiveSheet()->getStyle('A2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFe0e0e0');
            }
            $contador = $contador + 1;
        }
        if ($logoFile) {
            
        }
        return $xl;
    }

    public function numeroletra($numero) {
        switch ($numero) {
            case 0: $letra = "A";
                break;
            case 1: $letra = "B";
                break;
            case 2: $letra = "C";
                break;
            case 3: $letra = "D";
                break;
            case 4: $letra = "E";
                break;
            case 5: $letra = "F";
                break;
            case 6: $letra = "G";
                break;
            case 7: $letra = "H";
                break;
            case 8: $letra = "I";
                break;
            case 9: $letra = "J";
                break;
            case 10: $letra = "K";
                break;
            case 11: $letra = "L";
                break;
            case 12: $letra = "M";
                break;
            case 13: $letra = "N";
                break;
            case 14: $letra = "O";
                break;
            case 15: $letra = "P";
                break;
            case 16: $letra = "Q";
                break;
            case 17: $letra = "R";
                break;
            case 18: $letra = "S";
                break;
            case 19: $letra = "T";
                break;
            case 20: $letra = "U";
                break;
            case 21: $letra = "V";
                break;
            case 22: $letra = "W";
                break;
            case 23: $letra = "X";
                break;
            case 24: $letra = "Y";
                break;
            case 25: $letra = "Z";
                break;
            case 26: $letra = "AA";
                break;
            case 27: $letra = "AB";
                break;
            case 28: $letra = "AC";
                break;
            case 29: $letra = "AD";
                break;
            case 30: $letra = "AE";
                break;
            case 31: $letra = "AF";
                break;
            case 32: $letra = "AG";
                break;
            case 33: $letra = "AH";
                break;
            case 34: $letra = "AI";
                break;
            case 35: $letra = "AJ";
                break;
            case 36: $letra = "AK";
                break;
            case 37: $letra = "AL";
                break;
            case 38: $letra = "AM";
                break;
            case 39: $letra = "AN";
                break;
            case 40: $letra = "AO";
                break;
            case 41: $letra = "AP";
                break;
            case 42: $letra = "AQ";
                break;
            case 43: $letra = "AR";
                break;
            case 44: $letra = "AS";
                break;
            case 45: $letra = "AT";
                break;
            case 46: $letra = "AU";
                break;
            case 47: $letra = "AV";
                break;
            case 48: $letra = "AW";
                break;
            case 49: $letra = "AY";
                break;
            case 50: $letra = "AZ";
                break;
        }
        return $letra;
    }

    public function graficaColumna() {
        $grafica = array();
        $grafica['chart'] = array('type' => 'column');
        $grafica['title'] = array('text' => 'Titulo');
        $grafica['subtitle'] = array('text' => 'Subtitulo');
        $grafica['xAxis'] = array('categories' => 'Labels Titulos');
        $grafica['yAxis'] = array(
            'min' => 0,
            'title' => array('text' => 'Titulo Y', 'align' => 'high'),
            'labels' => array('overflow' => 'justify')
        );
        $grafica['tooltip'] = array('valueSuffix' => 'cantidad');
        $grafica['plotOptions'] = array('bar' => array('dataLabels' => array('enabled' => true)));
        $grafica['series'] = array(array('name' => 'Valor', 'data' => array(1)));
        $grafica['credits'] = false;
        return $grafica;
    }

    public function graficaPie() {
        $grafica = array();
        $grafica['chart'] = array(
            'plotBackgroundColor' => null,
            'plotBorderWidth' => null,
            'plotShadow' => 'false'
        );
        $grafica['title'] = array('text' => 'Titulo');
        $grafica['subtitle'] = array('text' => 'Titulo');
        $grafica['tooltip'] = array('pointFormat' => '{series.name}: <b>{point.y}</b>');
        $grafica['plotOptions'] = array(
            'pie' => array(
                'allowPointSelect' => true,
                'cursor' => 'pointer',
                'dataLabels' => array(
                    'enabled' => true,
                    'format' => '<b>{point.name}</b>: {point.percentage:.1f} %',
                ),
                'showInLegend' => true,
            )
        );
        $grafica['series'] = array(
            array(
                'type' => 'pie',
                'name' => 'Nombre Pie',
                'data' => array(array('Sin Datos', 0))
            )
        );
        $grafica['credits'] = false;
        return $grafica;
    }

    public function HojaEncabezadoX($hoja, $titulo, $filtros, $rutaimagen = null) {
        $styleArray = array(
            'font' => array(
                'size' => 8,
                'name' => 'Arial'
        ));
         $styleArray= array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '766f6e'),)));
        
        
        $rutaimagen = sfContext::getInstance()->getUser()->getAttribute('empresa', null, 'logo');

        if ($rutaimagen) {
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setWorksheet($hoja);
            $objDrawing->setName('Paid');
            $objDrawing->setDescription('Paid');

            // 
            $objDrawing->setPath($rutaimagen);

            $objDrawing->setWidthAndHeight(90, 50);
            $objDrawing->setCoordinates('A2');
            $objDrawing->setOffsetX(0);
            $objDrawing->setRotation(15);
            $objDrawing->getShadow()->setVisible(true);
            $objDrawing->getShadow()->setDirection(15);
        }

        $contador = 2;
        $texto = ($titulo['texto']);
        $inicio = sfContext::getInstance()->getUser()->numeroletra($titulo['inicio']);
        $fin = sfContext::getInstance()->getUser()->numeroletra($titulo['fin']);
        $centroN = $titulo['centro'];
        $centro = sfContext::getInstance()->getUser()->numeroletra($centroN);
        $centroM = sfContext::getInstance()->getUser()->numeroletra($centroN + 1);
        $hoja->mergeCells($inicio . $contador . ':' . $fin . $contador);
        $hoja->getRowDimension(2)->setRowHeight('25');
        $hoja->getStyle($inicio . $contador)->getAlignment()->setHorizontal("center");
        $hoja->getStyle($inicio . $contador)->getFont()->setBold(true);
        $hoja->getStyle($inicio . $contador)->getFont()->setSize(11);
        $hoja->getStyle($inicio . $contador . ":" . $fin . $contador)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $hoja->getStyle($inicio . $contador . ":" . $fin . $contador)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $hoja->getStyle($inicio . $contador . ":" . $fin . $contador)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $hoja->getStyle($inicio . $contador . ":" . $fin . $contador)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $hoja->setCellValue($inicio . $contador, $texto);
        $hoja->getStyle($inicio . $contador . ":" . $fin . $contador)->applyFromArray($styleArray);
        foreach ($filtros as $subtitulo) {
            $filtro = $subtitulo['titulo'];
            $descripcion = ($subtitulo['descripcion']);
            $contador++;
            $hoja->getStyle($inicio . $contador . ":" . $centro . $contador)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFe0e0e0');
            $hoja->getStyle($inicio . $contador . ":" . $centro . $contador)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $hoja->getStyle($inicio . $contador . ":" . $centro . $contador)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $hoja->getStyle($inicio . $contador . ":" . $centro . $contador)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $hoja->getStyle($inicio . $contador . ":" . $centro . $contador)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $hoja->getStyle($inicio . $contador)->getFont()->setBold(true);
            $hoja->getStyle($inicio . $contador)->getFont()->setSize(8);
            $hoja->setCellValue($inicio . $contador, $filtro);
            $hoja->getStyle($centroM . $contador . ":" . $fin . $contador)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $hoja->getStyle($centroM . $contador . ":" . $fin . $contador)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $hoja->getStyle($centroM . $contador . ":" . $fin . $contador)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $hoja->getStyle($centroM . $contador . ":" . $fin . $contador)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $hoja->getStyle($centroM . $contador)->getFont()->setBold(true);
            $hoja->getStyle($centroM . $contador)->getFont()->setSize(8);
            $hoja->getStyle($centroM . $contador . ":" . $fin . $contador)->applyFromArray($styleArray);

            $hoja->setCellValue($centroM . $contador, $descripcion);
        }
        $contador++;
        $contador++;
        return $contador;
    }

    public function HojaImprimeEncabezadoHorizontal($lista, $columna, $fila, $hoja) {
        foreach ($lista as $registro) {
            $letra = sfContext::getInstance()->getUser()->numeroletra($columna);
            $nombre = ($registro["Nombre"]);
            $width = $registro["width"];
            $align = $registro["align"];
            $format = $registro["format"];

            $hoja->getColumnDimension($letra)->setWidth($width);
            $hoja->getStyle($letra)->getNumberFormat()->setFormatCode($format);

            //      $textFormat='@';//'General','0.00','@'
//$excel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode($currencyFormat);
//$excel->getActiveSheet()->getStyle('C1')->getNumberFormat()->setFormatCode($textFormat);
            $hoja->getStyle($letra . $fila)->getAlignment()->setHorizontal($align);
            $color = 'E6E6FF';
            $color='819BFB';
            $styleArray = array(
                'font' => array(
                    'bold' => true,
                //    'color' => array('rgb' => 'a8b3d7'),
                    'size' => 8,
                    'name' => 'Arial'
            ));

           $hoja->getStyle($letra . $fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($color);
            $hoja->getStyle($letra . $fila)->getFont()->setBold(true);
            $hoja->getStyle($letra . $fila)->getFont()->setSize(10);
            //$hoja->getStyle($letra . $fila)->applyFromArray($styleArray);
            $hoja->setCellValueByColumnAndRow($columna, $fila, $nombre);
            $columna++;
        }
        return $columna - 1;
    }

    public function HojaImprimeListaHorizontal($lista, $columna, $fila, $hoja) {
        $styleArray = array(
            'font' => array(
                'size' => 8,
                'name' => 'Arial'
        ));
        $styleArrayfINAL = array(
            'font' => array(
                'size' => 8,
                'name' => 'Arial'
        ));

        foreach ($lista as $registro) {
            $valor = ($registro["valor"]);
            $tipo = $registro["tipo"];
            $letra = sfContext::getInstance()->getUser()->numeroletra($columna);
            if ($tipo == 1) {
                $hoja->setCellValueByColumnAndRow($columna, $fila, $valor);
            }
            if ($tipo == 2) {
                $hoja->getCell($letra . $fila)->setValueExplicit($valor, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            }
            if ($tipo == 3) {
                $hoja->getCell($letra . $fila)->setValueExplicit($valor, PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $hoja->getStyle($letra . $fila)->getAlignment()->setHorizontal("rigth");
            $hoja->getStyle($letra . $fila)->applyFromArray($styleArray);
            if ($tipo == 4) {
                $hoja->getCell($letra . $fila)->setValueExplicit($valor, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $hoja->getStyle($letra . $fila)->applyFromArray($styleArrayfINAL);
                $hoja->getStyle($letra . $fila)->getFont()->setBold(true);
            }
            if ($tipo == 5) {
                $hoja->getCell($letra . $fila)->setValueExplicit($valor, PHPExcel_Cell_DataType::TYPE_STRING);
                $hoja->getStyle($letra . $fila)->applyFromArray($styleArrayfINAL);
                $hoja->getStyle($letra . $fila)->getFont()->setBold(true);
            }

            $columna++;
        }
        return $columna - 1;
    }

    public function HojaImprimeListaHorizontalFormato($lista, $columna, $fila, $hoja) {
        foreach ($lista as $registro) {
            $letra = sfContext::getInstance()->getUser()->numeroletra($columna);
            $valor = $registro["valor"];
            $tipo = $registro["tipo"];
            $hoja->getStyle($letra . $fila)->getFont()->setBold(true);
            $hoja->getStyle($letra . $fila)->getFont()->setSize(8);
            if ($tipo == 1) {
                $hoja->getStyle($letra . $fila)->getNumberFormat()->setFormatCode("#,##0.00");
                $hoja->setCellValueByColumnAndRow($columna, $fila, $valor);
            }
            if ($tipo == 2) {
                $hoja->getCell($letra . $fila)->setValueExplicit($valor, PHPExcel_Cell_DataType::TYPE_NUMERIC);
            }
            if ($tipo == 3) {
                $hoja->getCell($letra . $fila)->setValueExplicit($valor, PHPExcel_Cell_DataType::TYPE_STRING);
            }
            if ($tipo == 4) {
                $hoja->getCell($letra . $fila)->setValueExplicit($valor, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $hoja->getStyle($letra . $fila)->getFont()->setBold(true);
                $hoja->getStyle($letra . $fila)->getFont()->setSize(10);
            }
            $hoja->getStyle($letra . $fila)->getAlignment()->setHorizontal("rigth");
            $columna++;
        }
        return $columna - 1;
    }

}
