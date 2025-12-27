<?php

/**
 * cuenta_contable actions.
 *
 * @package    plan
 * @subpackage cuenta_contable
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cuenta_contableActions extends sfActions {

    public function executeEliminaCompleto(sfWebRequest $request) {
        $modulo = 'cuenta_contable';
        $id = $request->getParameter('id');
        // die('a');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $REGISTRO = CuentaErpContableQuery::create()->find();

            $REGISTRO->delete();

            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage());
            }
            $this->redirect($modulo . '/index');
        }
        $this->getUser()->setFlash('eliminar', "Cuentas eliminadas");
        $this->redirect($modulo . '/index');
    }

    public function executeReporteModelo(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $empresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = strtoupper($empresaQ->getNombre());
        $nombreEMpresa = strtoupper($empresaQ->getNombre());
        $pestanas[] = 'Cuentas Contable';
        $nombre = "Reporte";
        $filename = "Reporte_cuenta_contable" . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("LISTADO DE CUENTAS CONTABLES " . strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        // $hoja->getCell("B1")->setValueExplicit(strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("A1:D1");
        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');
        $encabezados[] = array("Nombre" => (strtoupper(("Tipo"))), "width" => 15, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => (strtoupper(("Grupo"))), "width" => 20, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => (strtoupper(("Cuenta"))), "width" => 25, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => (strtoupper(("Nombre"))), "width" => 55, "align" => "left", "format" => "@");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);


        $registros = CuentaErpContableQuery::create()->orderByCuentaContable('Desc')->find();
        foreach ($registros as $data) {

            //$totalDos = $totalDos + $data->getValorPagado();
            $fila++;
            $datos = null;
            $datos[] = array("tipo" => 3, "valor" => $data->getTipo());
            $datos[] = array("tipo" => 3, "valor" => $data->getCampo());
            $datos[] = array("tipo" => 3, "valor" => $data->getCuentaContable());
            $datos[] = array("tipo" => 3, "valor" => $data->getNombre());

            $columnafinal = sfContext::getInstance()->getUser()->HojaImprimeListaHorizontal($datos, $columna, $fila, $hoja);
        }


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeElimina(sfWebRequest $request) {

        $acceso = MenuSeguridad::Acceso('cuenta_contable');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }


        $modulo = 'cuenta_contable';
        $id = $request->getParameter('id');
        // die('a');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $REGISTRO = CuentaErpContableQuery::create()->findOneById($id);
            $codigo = $REGISTRO->getNombre() . "  " . $REGISTRO->getCuentaContable();
            $REGISTRO->delete();

            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage());
            }
            $this->redirect($modulo . '/index');
        }
        $this->getUser()->setFlash('eliminar', $codigo);
        $this->redirect($modulo . '/index');
    }

    public function executeProcesa(sfWebRequest $request) {
           error_reporting(-1);
        $datos = unserialize(sfContext::getInstance()->getUser()->getAttribute('usuarioDato', null, 'seguridad'));
        $cantidad = 0;
        foreach ($datos as $Linea) {
            $valido = $Linea['VALIDO'];
//            echo "<pre>";
//            print_r($Linea);
//            die();
            if ($valido) {
                $cantidad++;
                CuentaErpContablePeer::procesa($Linea);
            }
        }
        sfContext::getInstance()->getUser()->setAttribute('usuarioDato', null, 'seguridad');
        $this->getUser()->setFlash('exito', 'Registros grabados: ' . $cantidad);
        $this->redirect('cuenta_contable/index');
    }

    public function executeCarga(sfWebRequest $request) {
        error_reporting(-1);
        $this->getResponse()->setContentType('charset=utf-8');
        $id = $request->getParameter('id');
        $this->id = $id;
        $datos = CuentaErpContablePeer::pobladatos($id);
        if (!$datos['valido']) {
            $texto = $datos['pendiente'];

            $textol = implode(' , ', $texto);
            $this->getUser()->setFlash('error', 'Las siguiente columnas no fueron encontradas: ' . $textol);
            $this->redirect('cuenta_contable/index');
        }
        $this->datos = $datos['datos'];

        sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');

        sfContext::getInstance()->getUser()->setAttribute('usuarioDato', serialize($datos['datos']), 'seguridad');
        $this->redirect('cuenta_contable/index');
        //   die();
    }

    public function executeReporte(sfWebRequest $request) {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $empresaQ = EmpresaQuery::create()->findOneById($empresaId);
        $nombreempresa = "Modelo Carga Cuenta";
        $nombreEMpresa = strtoupper($empresaQ->getNombre());
        $pestanas[] = 'Carga';
        $nombre = "Modelo";
        $filename = "Archivo_carga_cuenta" . date("Ymd");
        $xl = sfContext::getInstance()->getUser()->nuevoExcel($nombreempresa, $pestanas, $nombre);
        $hoja = $xl->setActiveSheetIndex(0);
        $hoja->getCell("A1")->setValueExplicit("TIPO DE ARCHIVO ", PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->getStyle("A1")->getFont()->setBold(true);
        $hoja->getStyle("A1")->getFont()->setSize(10);
        $hoja->getCell("B1")->setValueExplicit("Documento Carga Cuentas " . strtoupper($nombreEMpresa), PHPExcel_Cell_DataType::TYPE_STRING);
        $hoja->mergeCells("B1:D1");
        $fila = 2;
        $columna = 0;
        $encabezados = null;
        $this->getResponse()->setContentType('charset=utf-8');
        $encabezados[] = array("Nombre" => (strtoupper(("Tipo"))), "width" => 20, "align" => "left", "format" => "#,##0.00");
        $encabezados[] = array("Nombre" => (strtoupper(("Cuenta"))), "width" => 25, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => (strtoupper(("Grupo"))), "width" => 25, "align" => "left", "format" => "@");
        $encabezados[] = array("Nombre" => (strtoupper(("Nombre"))), "width" => 25, "align" => "left", "format" => "@");
        sfContext::getInstance()->getUser()->HojaImprimeEncabezadoHorizontal($encabezados, $columna, $fila, $hoja);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $xl = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
        $xl->save('php://output');
        throw new sfStopException();
    }

    public function executeIndex(sfWebRequest $request) {
           error_reporting(-1);
        $modulo = 'cuenta_contable';
        $acceso = MenuSeguridad::Acceso('cuenta_contable');
        if (!$acceso) {
            $this->redirect('inicio/index');
        }

        $this->datos = unserialize(sfContext::getInstance()->getUser()->getAttribute('usuarioDato', null, 'seguridad'));
        $this->cuentas = CuentaErpContableQuery::create()->orderByCuentaContable("Asc")->find();

        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $default = null;
        $registro = CuentaErpContableQuery::create()->findOneById($Id);

        if ($registro) {
            $default['grupo'] = $registro->getCampo();
            $default['tipo'] = $registro->getTipo();
            $default['cuenta'] = $registro->getCuentaContable();
            $default['nombre'] = $registro->getNombre();
        }
        $this->registro = $registro;
        $this->form = new CreaCuentaForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                if (!$registro) {
                    $registro = New CuentaErpContable();
                    $this->getUser()->setFlash('exito', 'Registro ingresado  con exito ');
                }
                $registro->setTipo($valores['tipo']);
                $registro->setCampo($valores['grupo']);
                $registro->setCuentaContable($valores['cuenta']);
                $registro->setNombre($valores['nombre']);
                $registro->save();


                $this->redirect($modulo . '/index');
            }
        }
    }

}
