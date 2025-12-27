<?php

/**
 * carga_activo actions.
 *
 * @package    plan
 * @subpackage carga_activo
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class carga_activoActions extends sfActions {

    
        public function executeVista(sfWebRequest $request) {
            $codigo = $request->getParameter('id');
            
            $this->activo = ListaActivosQuery::create()->findOneByCodigo($codigo);
            
//            echo "<pre>";
//            print_r($ListAActivo);
//            die();
            
        }
    public function executeReporte(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $nombreempresa = "Modelo";
        $nombreEMpresa = 'Venialink';
        $pestanas[] = 'Carga';
        $nombre = "Modelo";

        $filename = "Archivo_Carga_Activos_" . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $fila = 1;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');

        $encabezados[] = array("Nombre" => 'Codigo', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Account', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Description', "width" => 40, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Adquisition', "width" => 18, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Life', "width" => 18, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Book', "width" => 20, "align" => "center", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => '%', "width" => 15, "align" => "center", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        $fila++;
        $encabezados = null;

        $encabezados[] = array("Nombre" => 'Codigo', "width" => 18, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => '', "width" => 18, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => '', "width" => 35, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Date', "width" => 16, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Years', "width" => 18, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => 'Value', "width" => 20, "align" => "center", "format" => "@");
        $encabezados[] = array("Nombre" => '%', "width" => 15, "align" => "center", "format" => "#,##0.00");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        //          die();
        $xl->save('php://output');
        die();
        throw new sfStopException();
    }

    public function executeConfirmar(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $datos = Cliente::pobladatos($id);
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $usuario = $usuarioQ->getUsuario();
        $registros = $datos['datos'];
        $cantidaIngresa = 0;
        $cantidadActualiza =0;
        $total = 0;
        foreach ($registros as $data) {
            if ($data['CUENTA_ID']) {
                $total = $total++;
                $registro = ListaActivosQuery::create()->findOneByCodigo($data['CODIGO']);
                if (!$registro) {
                    $cantidaIngresa++;
                    $registro = new ListaActivos();
                } else {
                  $cantidadActualiza++;
                    
                }
                $registro->setActivo(true);
//                if ($data['ADQUISITIONvENCE']) {
//                    $registro->setActivo(false);
//                }
                $registro->setCodigo($data['CODIGO']);
                $registro->setCuentaContable($data['ACCOUNT']); //=> 151008
                $registro->setDetalle($data['DESCRIPTION']); //=> Vehiculos
                $registro->setFechaAdquision($data['ADQUISITION']); //=> 01-01-97
                $registro->setAnioUtil($data['LIFE']); //=> 5
                $registro->setValorLibro($data['BOOK']); //=> 15000.00
                $registro->setPorcentaje($data['POR']); //=> 20
                $registro->setCuentaErpContableId($data['CUENTA_ID']); //=> 1858
                $registro->setUsuario($usuario);
                $registro->save();
            }
        }

//        $cantidaActualiza = $total - $cantidaIngresa;
        $this->getUser()->setFlash('exito', 'Activos registrados con exitos  nuevos ' . $cantidaIngresa. " actualizados " . $cantidadActualiza);
        $this->redirect('carga_activo/index');
    }

    public function executeCarga(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seledatos', null, 'carga'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $usuario = $usuarioQ->getUsuario();
        $id = $request->getParameter('id');
        $this->id = $id;
        sfContext::getInstance()->getUser()->setAttribute('seledatos', null, 'carga');
        $datos = Cliente::pobladatos($id);
        if (!$datos['valido']) {
            $texto = $datos['pendiente'];
            $textol = implode(' , ', $texto);
            $this->getUser()->setFlash('error', 'Las siguiente columnas no fueron encontradas: ' . $textol);
            $this->redirect('carga_activo/index');
        }
        $this->redirect('carga_activo/muestra?id=' . $id);
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seledatos', null, 'carga'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $usuario = $usuarioQ->getUsuario();
        $tab = 1;
        if ($request->getParameter('tab')) {
            $tab = $request->getParameter('tab');
        }
        $this->tab = $tab;

        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsACTI', null, 'consulta'));
        if (!$valores) {
            $fecha_actual = date("d-m-Y");
            $fecha = date("d/m/Y", strtotime($fecha_actual . "- 3 months"));
            $valores['fechaInicio'] = $fecha;
            $valores['fechaFin'] = date('d/m/Y');
            sfContext::getInstance()->getUser()->setAttribute('datoconsACTI', serialize($valores), 'consulta');
        }

        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('datoconsACTI', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('datoconsACTI', null, 'consulta'));
                $this->redirect('carga_activo/index?tab=2');
            }
        }

        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];

        $this->registros = ListaActivosQuery::create()
                ->where("ListaActivos.FechaAdquision >= '" . $fechaInicio . "'")
                ->where("ListaActivos.FechaAdquision <= '" . $fechaFin . "'")
                ->find();
    }

    public function executeMuestra(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seledatos', null, 'carga'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $usuario = $usuarioQ->getUsuario();
        $id = $request->getParameter('id');
        $this->id = $id;
        $datos = Cliente::pobladatos($id);
        $this->datos = $datos['datos'];
    }

}
