<?php

/**
 * reporte_visita actions.
 *
 * @package    plan
 * @subpackage reporte_visita
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reporte_visitaActions extends sfActions {

    public function executeReporte(sfWebRequest $request) {
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('dataCaptura', null, 'consulta'));
        if (!$valores) {
            $fecha_actual = date("d-m-Y");
            $fecha = date("d/m/Y", strtotime($fecha_actual . "- 3 months"));
            $valores['fechaInicio'] = $fecha;
            $valores['fechaFin'] = date('d/m/Y');
            $valores['tipo'] = null;
            $valores['region'] = null;
            sfContext::getInstance()->getUser()->setAttribute('dataCaptura', serialize($valores), 'consulta');
        }

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $registros = new FormularioDatosQuery();
        if ($valores['tipo']) {
            $registros->filterByTipo($valores['tipo']);
        }
        if ($valores['region']) {
            $registros->filterByRegionId($valores['region']);
        }
        $registros->where("FormularioDatos.FechaVisita >= '" . $fechaInicio . "'");
        $registros->where("FormularioDatos.FechaVisita <= '" . $fechaFin . "'");
        $this->registros = $registros->find();

        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = $EmpresaQuery->getNombre();
        $pestanas[] = 'Datos Capturados';
        $filename = "Datos Capturados Visita  " . $nombreempresa . date("d_m_Y");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $pestanas[0]);
        $hoja = $xl->setActiveSheetIndex(0);
//CABECERA  Y FILTRO
        $hoja->getRowDimension('1')->setRowHeight(15);
        $hoja->getRowDimension('2')->setRowHeight(20);

        $hoja->mergeCells("A1:A2");
        $hoja = $xl->getActiveSheet();
        $hoja->getCell("B1")->setValueExplicit(strtoupper($nombreempresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B1")->getFont()->setBold(true);
        $hoja->getStyle("B1")->getFont()->setSize(13);
// $hoja->getStyle("B1")->applyFromArray($styleArray);

        $hoja->getCell("C1")->setValueExplicit("Datos Capturados Visita", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("C1")->getFont()->setBold(true);
        $hoja->getStyle("C1")->getFont()->setSize(10);

        $textoBusqueda = $this->textobusqueda($valores);
        $hoja->mergeCells("C1:E1");
        $hoja->getCell("B2")->setValueExplicit("Busqueda ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("B2")->getFont()->setBold(true);
        $hoja->getStyle("B2")->getFont()->setSize(10);
        $hoja->getCell("C2")->setValueExplicit($textoBusqueda, PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle('C2')->getAlignment()->setWrapText(true);
        $hoja->mergeCells("C2:E2");

        $fila = 3;
        $columna = 0;
        $encabezados = null;

        $encabezados[] = array("Nombre" => strtoupper("Fecha"), "width" => 16, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Establecimiento"), "width" => 35, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Tipo"), "width" => 21, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Propietario"), "width" => 30, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Contacto"), "width" => 30, "align" => "rigth", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => strtoupper("Región"), "width" => 24, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Departamento"), "width" => 24, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Municipio"), "width" => 27, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Dirección"), "width" => 35, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Correo"), "width" => 21, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Telefono"), "width" => 15, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("WhatsApp"), "width" => 15, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Observaciones"), "width" => 35, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Repuestos"), "width" => 35, "align" => "left", "format" => "#,##0");
        $encabezados[] = array("Nombre" => strtoupper("Usuario"), "width" => 20, "align" => "left", "format" => "#,##0");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $hoja->getStyle('I')->getAlignment()->setWrapText(true);
        $hoja->getStyle('D')->getAlignment()->setWrapText(true);
        $hoja->getStyle('E')->getAlignment()->setWrapText(true);
        $hoja->getStyle('M')->getAlignment()->setWrapText(true);
        $hoja->getStyle('N')->getAlignment()->setWrapText(true);
        $total = 0;
        foreach ($this->registros as $regi) {
            $fila++;

            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $regi->getFechaVisita('d/m/Y') . " " . $regi->getCreatedAt('H:i'));  // ENTERO
            //ESTABLECIMIENTO	
            $datos[] = array("tipo" => 3, "valor" => $regi->getEstablecimiento());  // ENTERO
            //TIPO	
            $datos[] = array("tipo" => 3, "valor" => $regi->getTipo());  // ENTERO
            //PROPIETARIO	
            $datos[] = array("tipo" => 3, "valor" => $regi->getPropietario());  // ENTERO
            //CONTACTO	
            $datos[] = array("tipo" => 3, "valor" => $regi->getContacto());  // ENTERO
            // REGIóN	
            $datos[] = array("tipo" => 3, "valor" => $regi->getRegion()->getDetalle());  // ENTERO
            // DEPARTAMENTO	
            $datos[] = array("tipo" => 3, "valor" => $regi->getDepartamento()->getNombre());  // ENTERO
            //   MUNICIPIO	
            $datos[] = array("tipo" => 3, "valor" => $regi->getMunicipio()->getDescripcion());  // ENTERO
            //   DIRECCIóN	
            $datos[] = array("tipo" => 3, "valor" => $regi->getDireccion());  // ENTERO
            //  CORREO	
            $datos[] = array("tipo" => 3, "valor" => $regi->getEmail());  // ENTERO
            //   TELEFONO	
            $datos[] = array("tipo" => 3, "valor" => $regi->getTelefono());  // ENTERO
            //  WHATSAPP	
            $datos[] = array("tipo" => 3, "valor" => $regi->getWhtasApp());  // ENTERO
             $datos[] = array("tipo" => 3, "valor" => $regi->getObservaciones());  // ENTERO
            $detalle = FormularioDetalleQuery::create()
                    ->filterByFormularioDatosId($regi->getId())
                    ->find();
            $repuesto = '';
            $listare = null;
            foreach ($detalle as $dat) {
                $listare[] = $dat->getHollander() . " " . $dat->getRepuesto();
            }
            if ($listare) {
                $repuesto = implode(PHP_EOL, $listare);
            }

            //  REPUESTOS	
            $datos[] = array("tipo" => 3, "valor" => $repuesto);  // ENTERO
            //  USUARIO
            $datos[] = array("tipo" => 3, "valor" => $regi->getUsuario());  // ENTERO



            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;

        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getStyle('I')->getAlignment()->setWrapText(true);
        $hoja->getStyle('D')->getAlignment()->setWrapText(true);
        $hoja->getStyle('E')->getAlignment()->setWrapText(true);
        $hoja->getStyle('M')->getAlignment()->setWrapText(true);
        $hoja->getStyle('N')->getAlignment()->setWrapText(true);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeIndex(sfWebRequest $request) {

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('dataCaptura', null, 'consulta'));
        if (!$valores) {
            $fecha_actual = date("d-m-Y");
            $fecha = date("d/m/Y", strtotime($fecha_actual . "- 3 months"));
            $valores['fechaInicio'] = $fecha;
            $valores['fechaFin'] = date('d/m/Y');
            $valores['tipo'] = null;
            $valores['region'] = null;
            sfContext::getInstance()->getUser()->setAttribute('dataCaptura', serialize($valores), 'consulta');
        }

        $this->form = new ConsultaFechaVisitaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('dataCaptura', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('dataCaptura', null, 'consulta'));
                $this->redirect('reporte_visita/index?tab=2');
            }
        }

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $registros = new FormularioDatosQuery();
        if ($valores['tipo']) {
            $registros->filterByTipo($valores['tipo']);
        }
        if ($valores['region']) {
            $registros->filterByRegionId($valores['region']);
        }
        $registros->where("FormularioDatos.FechaVisita >= '" . $fechaInicio . "'");
        $registros->where("FormularioDatos.FechaVisita <= '" . $fechaFin . "'");
        $this->registros = $registros->find();
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
                if ($clave == 'TIPO') {
                    $Busqueda[] = ' TIPO : ' . $valor;
                }
                if ($clave == 'REGION') {
                    $Busqueda[] = ' REGIÓN : ' . $valor;
                }
            }
        }
        if ($Busqueda) {
            $textoBusqueda = implode(",", $Busqueda);
        }
        return $textoBusqueda;
    }

}
