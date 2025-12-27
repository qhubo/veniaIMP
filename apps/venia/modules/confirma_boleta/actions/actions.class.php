<?php

/**
 * confirma_boleta actions.
 *
 * @package    plan
 * @subpackage confirma_boleta
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class confirma_boletaActions extends sfActions {


    
    public function executeReporteExcel(sfWebRequest $request) {
        
                 
                     $acceso = MenuSeguridad::Acceso('confirma_boleta');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
        
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBan', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['banco'] = null;
            $valores['estatus'] = null;
        }
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = $EmpresaQuery->getNombre();

        $pestanas[] = 'Boletas Deposito';

        $filename = "Listado de boleta deposito  " . $nombreempresa . date("d_m_Y");
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

        $hoja->getCell("C1")->setValueExplicit("Listado de boletas depositos ", PHPExcel_Cell_DataType::TYPE_STRING);
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
        
        
        
        $encabezados[] = array("Nombre" => strtoupper("Fecha"), "width" => 12, "align" => "left", "format" => "#,##0");	
        $encabezados[] = array("Nombre" => strtoupper("Codigo"), "width" => 20, "align" => "left", "format" => "#,##0");	
        $encabezados[] = array("Nombre" => strtoupper("Tienda"), "width" => 25, "align" => "left", "format" => "#,##0");	
        $encabezados[] = array("Nombre" => strtoupper("Banco"), "width" => 25, "align" => "left", "format" => "#,##0");	
        $encabezados[] = array("Nombre" => strtoupper("Fecha Deposito"), "width" => 15, "align" => "left", "format" => "#,##0");	
        $encabezados[] = array("Nombre" => strtoupper("Boleta"), "width" => 20, "align" => "left", "format" => "#,##0");	
        $encabezados[] = array("Nombre" => strtoupper("Total"), "width" => 15, "align" => "left", "format" => "#,##0.00");	
        $encabezados[] = array("Nombre" => strtoupper("Vendedor"), "width" => 25, "align" => "left", "format" => "#,##0");	
        $encabezados[] = array("Nombre" => strtoupper("Cliente"), "width" => 25, "align" => "left", "format" => "#,##0");	
        $encabezados[] = array("Nombre" => strtoupper("Telefono"), "width" => 20, "align" => "left", "format" => "#,##0");	
        $encabezados[] = array("Nombre" => strtoupper("Pieza"), "width" => 20, "align" => "left", "format" => "#,##0");	
        $encabezados[] = array("Nombre" => strtoupper("Stock"), "width" => 20, "align" => "left", "format" => "#,##0");	
        $encabezados[] = array("Nombre" => strtoupper("Documento Banco"), "width" => 25, "align" => "left", "format" => "#,##0");	
        $encabezados[] = array("Nombre" => strtoupper("Usuario Confirmo"), "width" => 25, "align" => "left", "format" =>"#,##0");	
        $encabezados[] = array("Nombre" => strtoupper("Estatus"), "width" => 18, "align" => "left", "format" =>"#,##0");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

     $boletas = new SolicitudDepositoQuery();
        $boletas->where("SolicitudDeposito.CreatedAt >= '" . $fechaInicio . " 00:00:00" . "'");
        $boletas->where("SolicitudDeposito.CreatedAt <= '" . $fechaFin . " 23:59:00" . "'");
        if ($valores['banco']) {
            $boletas->filterByBancoId($valores['banco']);
        }
        if ($valores['estatus']) {
            $boletas->filterByEstatus($valores['estatus']);
        }
        $this->boletas = $boletas->find();
        $total = 0;
        foreach ($this->boletas as $registro) {
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $registro->getCreatedAt('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getCodigo());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getTienda()->getNombre());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getBanco()->getNombre());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getFechaDeposito('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getBoleta());  // ENTERO
            $datos[] = array("tipo" => 2, "valor" => $registro->getTotal());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getVendedor());  // ENTERO
            
            
            $datos[] = array("tipo" => 3, "valor" => $registro->getCliente());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getTelefono());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getPieza());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getStock());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getDocumentoConfirmacion());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getUsuarioConfirmo());  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $registro->getEstatus());  // ENTERO
            
            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;
        $hoja = $xl->setActiveSheetIndex(0);
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
                if ($clave == 'BANCO') {
                    $query = BancoQuery::create()->findOneById($valor);
                    if ($query) {
                        $valor = $query->getNombre();
                    }
                    $Busqueda[] = ' BANCO : ' . $valor;
                }
                
                    if ($clave == 'ESTATUS') {
                  if  ($valor=="") {
                       $Busqueda[] = ' Todos los Estatus ';
                  } else {
                    $Busqueda[] = 'ESTADO : ' . $valor;
                  }
                }
            }
        }
        if ($Busqueda) {
            $textoBusqueda = implode(",", $Busqueda);
        }
        return $textoBusqueda;
    }

    
    
    
    public function executeIndex(sfWebRequest $request) {
                      $acceso = MenuSeguridad::Acceso('confirma_boleta');
        if (!$acceso) {
             $this->redirect('inicio/index');
        }
        
        
           date_default_timezone_set("America/Guatemala");
        $this->registros = SolicitudDepositoQuery::create()
                ->filterByEstatus('Nuevo')
                ->find();

        $this->tab = 1;
        if ($request->getParameter('tab')) {
            $this->tab = $request->getParameter('tab');
        }
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBan', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['banco'] = null;
            $valores['estatus'] = null;
        }
        $this->form = new ConsultaBoletaBancoFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsultaBan', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaBan', null, 'consulta'));
                $this->redirect('confirma_boleta/index?tab=2');
            }
        }

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

        $boletas = new SolicitudDepositoQuery();
        $boletas->where("SolicitudDeposito.CreatedAt >= '" . $fechaInicio . " 00:00:00" . "'");
        $boletas->where("SolicitudDeposito.CreatedAt <= '" . $fechaFin . " 23:59:00" . "'");
        if ($valores['banco']) {
            $boletas->filterByBancoId($valores['banco']);
        }
        if ($valores['estatus']) {
            $boletas->filterByEstatus($valores['estatus']);
        }
        $this->boletas = $boletas->find();
    }

}
