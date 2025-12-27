<?php

/**
 * carga actions.
 *
 * @package    plan
 * @subpackage carga
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cargaActions extends sfActions {
    
    
 public function executeProveedor(sfWebRequest $request) {
        $filename='LISTAPROVE.xls';
        $inputFileName = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR. $filename;
        $objReader = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $contador = 0;
        
        foreach ($sheetData as $registro) {
           $contador++;
           $codigo = $registro['A'];
           $NOMBRE = $registro['B'];
           $PROVE = ProveedorQuery::create()->findOneByCodigo($codigo);
           if (!$PROVE) {
               $PROVE = new Proveedor();
              $PROVE->getCodigo($codigo);
              }
              $PROVE->setNombre($NOMBRE);
              $PROVE->setActivo(true);
              $PROVE->save();
        }
           echo "actualizado ".$contador;
        die();
 }
    
    
    
    
    public function executeCliente(sfWebRequest $request) {
        $filename='listaCliente2.xls';
        $inputFileName = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR. $filename;
        $objReader = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $contador = 0;
        
        foreach ($sheetData as $registro) {
           $contador++;
           if ($contador >1) {
               $nit=$registro['A'];
               $codigo=$registro['B'];
               $Nombre=$registro['C'];
               $direccion=$registro['D'];
               $telefono=$registro['E'];
               $correo=$registro['F'];
               $limite=$registro['G'];
               $departmento = $registro['H'];
               $muni = $registro['I'];
               $vendeor = $registro['J'];  
               if ($Nombre <> "") {
               $cliente = ClienteQuery::create()->findOneByCodigo($codigo);
               if (!$cliente) {
                   $cliente = new Cliente();
               }
               $cliente->setNit($nit);
               $cliente->setCodigo($codigo);
               $cliente->setNombre($Nombre);
               $cliente->setDireccion($direccion);
               $cliente->setTelefono($telefono);
               $cliente->setCorreoContacto($correo);
               $cliente->setCorreoElectronico($correo);
               $cliente->setLimiteCredito($limite);
               $cliente->setActivo(true);
               $deparq = DepartamentoQuery::create()->findOneByNombre($departmento);
               if ($deparq) {
                   $cliente->setDepartamentoId($deparq->getId());
               }
               $munici = MunicipioQuery::create()->findOneByDescripcion($muni);
               if ($munici) {
                   $cliente->setMunicipioId($munici->getId());
               }
               $cliente->setContacto($vendeor);
               $cliente->save();               
           }
           }
        }
        echo "actualizado ".$contador;
        die();
    }

    public function executeIndex(sfWebRequest $request) {
        ///     echo "aaa";
        $this->tipo = $request->getParameter('tipo');
        $this->form = new CargaArchivoForm ();
        if ($request->isMethod('post')) {
//            $this->form->bind($request->getParameter('consulta'));
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($valores);
                sfContext::getInstance()->getUser()->setAttribute('valores', serialize($valores), 'busqueda');
                $archivo = $valores["archivo"];
                $filename = sha1($archivo->getOriginalName() . date("Ymdhis") . rand(111111, 999999)) . $archivo->getExtension($archivo->getOriginalExtension());
//                echo sfConfig::get("sf_upload_dir");
//                die();
                $archivo->save(sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . 'cargas' . DIRECTORY_SEPARATOR . $filename);
                $nombreOriginal = $archivo->getOriginalName();
                $bitacora = New BitacoraArchivo();
                $bitacora->setNombre($filename);
                $bitacora->setTipo($this->tipo);
                $bitacora->setNombreOriginal($nombreOriginal);
                $bitacora->save();
                sfContext::getInstance()->getUser()->setAttribute('valores', $bitacora->getId(), 'bitacora');
//                echo $this->tipo;
//                die();
                if ($this->tipo == 'creavivienda') {
                    $this->redirect('carga_vivienda/carga?id=' . $bitacora->getId());
                }
                if ($this->tipo == 'precio') {
                    $this->redirect('actualiza_precio/carga?id=' . $bitacora->getId());
                }

                if ($this->tipo == 'precio') {
                    $this->redirect('carga_precio/carga?id=' . $bitacora->getId());
                }
                if ($this->tipo == 'factura') {
                    $this->redirect('envia_fact_sap/carga?id=' . $bitacora->getId());
                }
                if ($this->tipo == 'oferta') {
                    $this->redirect('ofertado/carga?id=' . $bitacora->getId());
                }

                if ($this->tipo == 'existencia') {
                    $this->redirect('actualiza_inventario/carga?id=' . $bitacora->getId());
                }
                
                   if ($this->tipo == 'salida') {
                    $this->redirect('salida_inventario/carga?id=' . $bitacora->getId());
                }
                 if ($this->tipo == 'existenciaUbica') {
                    $this->redirect('actualiza_inventario_ubica/carga?id=' . $bitacora->getId());
                }
                

                if ($this->tipo == 'existencianueva') {
                    $this->redirect('actualiza_tienda_ubica/carga?id=' . $bitacora->getId());
                }
                
                
                if ($this->tipo == 'creaproducto') {
                    $this->redirect('carga_producto/carga?id=' . $bitacora->getId());
                }

                if ($this->tipo == 'creaproductoreceta') {
                    $this->redirect('carga_producto_detalle/carga?id=' . $bitacora->getId());
                }
                if ($this->tipo == 'partida') {
                    $this->redirect('partida_inicial/carga?id=' . $bitacora->getId());
                }

                if ($this->tipo == 'cargaproducto') {
                    $this->redirect('carga_producto/carga?id=' . $bitacora->getId());
                }

                if ($this->tipo == 'cargapartida') {
                    $this->redirect('partida_manual/carga?id=' . $bitacora->getId());
                }
                if ($this->tipo == 'cargahistorico') {
                    $this->redirect('carga_partida/carga?id=' . $bitacora->getId());
                }
                if ($this->tipo == 'cargahistorico') {
                    $this->redirect('carga_partida/carga?id=' . $bitacora->getId());
                }
                if ($this->tipo == 'cargapartidatodas') {
                    $this->redirect('partida_todas/carga?id=' . $bitacora->getId());
                }

                if ($this->tipo == 'cargagasto') {
                    $this->redirect('carga_gasto/carga?id=' . $bitacora->getId());
                }

                if ($this->tipo == 'comparacompra') {
                    $this->redirect('compara_compra/carga?id=' . $bitacora->getId());
                }
                if ($this->tipo == 'cargactivo') {
                    $this->redirect('carga_activo/carga?id=' . $bitacora->getId());
                }

                $this->redirect('cuenta_contable/carga?id=' . $bitacora->getId());
            }
        }
    }

}
