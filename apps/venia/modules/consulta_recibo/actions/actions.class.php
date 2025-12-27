<?php

/**
 * consulta_recibo actions.
 *
 * @package    plan
 * @subpackage consulta_recibo
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class consulta_reciboActions extends sfActions
{
 
   public function executeIndex(sfWebRequest $request) {
          error_reporting(-1);
        $acceso = MenuSeguridad::Acceso('pagos_realizado');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaGasto', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('datoconsultaGasto', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsultaGasto', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaGasto', null, 'consulta'));
                $this->redirect('consulta_recibo/index?id=1');
            }
        }
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '01:00';
        $valores['fin'] = '23:00';
        $this->registros = OperacionPagoQuery::create()
                ->filterByTipo('CXC COBRAR', Criteria::NOT_EQUAL)
                ->where("OperacionPago.FechaCreo >= '" . $fechaInicio . " 00:00:00" . "'")
                ->where("OperacionPago.FechaCreo <=  '" . $fechaFin . " 23:59:00" . "'")
                ->orderById('Asc')
                ->find();
   }
   
    public function executeReporteExcel(sfWebRequest $request) {
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsultaGasto', null, 'consulta'));
         if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
      
            sfContext::getInstance()->getUser()->setAttribute('datoconsultaGasto', serialize($valores), 'consulta');
        }
        $this->getResponse()->setContentType('text/html;charset=utf-8');
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $EmpresaQuery = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "Modelo";
        $pestanas[] = substr($EmpresaQuery->getNombre(), 0, 30);
        $nombre = "Modelo";
        $nombreEMpresa = $EmpresaQuery->getNombre();
        $nombreEMpresa = str_replace(" ", "_", $nombreEMpresa);
        $filename = "Reporte recibos " . $nombreEMpresa . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("FECHAS", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->getCell("B1")->setValueExplicit($valores['fechaInicio'] . " al  " . $valores['fechaFin'], PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B1:D1");
        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $encabezados[] = array("Nombre" => "RECIBO", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Fecha"), "width" => 20, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => "Factura", "width" => 25, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Tienda", "width" => 30, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Cliente", "width" => 50, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Medio Pago", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Banco", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => strtoupper("Documento"), "width" => 20, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => "Fecha Documento", "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Valor", "width" => 20, "align" => "center", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => "Usuario", "width" => 15, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => "Comisión", "width" => 20, "align" => "center", "format" => "#,##0.00");       
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        $valores['inicio'] = '01:00';
        $valores['fin'] = '23:00';
        $operaciones = OperacionPagoQuery::create()
                ->filterByTipo('CXC COBRAR', Criteria::NOT_EQUAL)
                ->where("OperacionPago.FechaCreo >= '" . $fechaInicio . " 00:00:00" . "'")
                ->where("OperacionPago.FechaCreo <=  '" . $fechaFin . " 23:59:00" . "'")
                ->orderById('Asc')
                ->find();
        foreach ($operaciones as $reg) {
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => "'".$reg->getCodigo());  // ENTERO   
            $datos[] = array("tipo" => 3, "valor" => $reg->getFechaCreo('d/m/Y'));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $reg->getOperacion()->getCodigo());
            $datos[] = array("tipo" => 3, "valor" => substr($reg->getOperacion()->getTienda()->getNombre(), 0, 30));  // ENTERO
            $datos[] = array("tipo" => 3, "valor" => $reg->getOperacion()->getNombre());
            $datos[] = array("tipo" => 3, "valor" => $reg->getTipo());
            $datos[] = array("tipo" => 3, "valor" => $reg->getTipo());
            $datos[] = array("tipo" => 3, "valor" => "");
            if ($reg->getBancoId()) {
              $datos[] = array("tipo" => 3, "valor" => $reg->getBanco()->getNombre());   
                
            }
            $datos[] = array("tipo" => 3, "valor" =>$reg->getDocumento());       
            $datos[] = array("tipo" => 3, "valor" =>$reg->getFechaDocumento('d/m/Y'));       
            
            $datos[] = array("tipo" => 2, "valor" => $reg->getValor());
           
            $datos[] = array("tipo" => 3, "valor" =>$reg->getUsuario() );
       $datos[] = array("tipo" => 2, "valor" => $reg->getComision());
          
            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }
        $fila++;
     

//        die();
        header("Content-Type: text/html;charset=utf-8");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

}
