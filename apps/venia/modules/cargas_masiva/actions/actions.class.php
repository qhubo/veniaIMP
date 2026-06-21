<?php

/**
 * cargas_masiva actions.
 *
 * @package    plan
 * @subpackage cargas_masiva
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cargas_masivaActions extends sfActions {

    
    public function executeProveedores(sfWebRequest $request) {
        error_reporting(-1);
        $inputFileName = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . "PROVEDORES.xls";
        $objReader = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $cont = 0;
        foreach ($sheetData as $regisr) {
            $cont++;
            if ($cont > 1) {
                $codigo = $regisr['A'];
                $nombre = $regisr['B'];
                $nit = $regisr['C'];
                $telefono = $regisr['D'];
                 $pais = $regisr['E'];
                 $PROVEERO = ProveedorQuery::create()->findOneByCodigo($codigo);
                 if (!$PROVEERO) {
                     $PROVEERO = new Proveedor();
                     $PROVEERO->setCodigo($codigo);
                     $PROVEERO->save();
                 }
                 $paisq = PaisQuery::create()->findOneByNombre($pais);
                 if (!$paisq) {
                     $paisq = new Pais();
                     $paisq->setNombre($pais);
                     $paisq->setActivo(true);
                     $paisq->save();
                 }
                 $PROVEERO->setNombre($nombre);
                 $PROVEERO->setNit($nit);
                 $PROVEERO->setTelefono($telefono);
                 $PROVEERO->setPaisId($paisq->getId());
                 $PROVEERO->setDireccion($pais);
                 $PROVEERO->save();
            }
        }
          echo "actualizado " . $cont;
        die();
    }
    
    public function executeCliente(sfWebRequest $request) {
        $filename = 'Clientes.xls';
        $inputFileName = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . $filename;
        $objReader = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $contador = 0;
        foreach ($sheetData as $registro) {
            $contador++;
            if ($contador > 1) {
                $CODIGO_CLIENTE = $registro['A'];
                $RUC = $registro['B'];
                $NOMBRE_FACTURAR = $registro['C'];
                $NOMBRE = $registro['D'];
                $TELEFONO = $registro['E'];
                $DIRECCION = $registro['F'];
                $PAIS = $registro['G'];
                $PROVINCIA = $registro['H'];
                $CORREGIMIENTO = $registro['I'];
                $CORREO = $registro['J'];
                $VENDEDOR = $registro['K'];
                $PRECIO = $registro['L'];
                $TIPO_CLIENTE = $registro['M'];
         
                $FECHA_DE_INGRESO = $registro['N'];
            
                $FUENTE = $registro['O'];
                $LIMITE_CREDITO = $registro['P'];
                $OBSERVACION_INTERNAS = $registro['Q'];
                if ($NOMBRE <> "") {
                    $cliente = ClienteQuery::create()->findOneByCodigo($CODIGO_CLIENTE);
                    if (!$cliente) {
                        $cliente = new Cliente();
                        $cliente->setCodigo($CODIGO_CLIENTE);
                    }
                    $cliente->setNit($RUC);
                    $cliente->setNombre($NOMBRE);
                    $cliente->setNombreFacturar($NOMBRE_FACTURAR);
                    $cliente->setDireccion($DIRECCION);
                    $cliente->setTelefono($TELEFONO);
                    $cliente->setCorreoContacto($CORREO);
                    $cliente->setCorreoElectronico($CORREO);
                    $cliente->setActivo(true);
                    $cliente->setLimiteCredito($LIMITE_CREDITO);
                    $PAISQ = PaisQuery::create()->findOneByNombre($PAIS);
                    if (!$PAISQ) {
                        $PAISQ = new Pais();
                        $PAISQ->setNombre($PAIS);
                        $PAISQ->save();
                    }
                    $cliente->setPaisId($PAISQ->getId());
                    $deparq = DepartamentoQuery::create()
                            ->filterByPaisId($PAISQ->getId())
                            ->filterByNombre($PROVINCIA)
                            ->findOne();
                    if (!$deparq) {
                        $deparq = new Departamento();
                        $deparq->setPaisId($PAISQ->getId());
                        $deparq->setNombre($PROVINCIA);
                        $deparq->setActivo(true);
                        $deparq->save();
                    }
                    $cliente->setDepartamentoId($deparq->getId());
                    $munici = MunicipioQuery::create()
                            ->filterByDescripcion($CORREGIMIENTO)
                            ->filterByDepartamentoId($deparq->getId())
                            ->findOne();
                    if (!$munici) {
                        $munici = new Municipio();
                        $munici->setDescripcion($CORREGIMIENTO);
                        $munici->setDepartamentoId($deparq->getId());
                        $munici->save();
                    }
                    $cliente->setMunicipioId($munici->getId());
                    $vendedorQ = VendedorQuery::create()->findOneByNombre($VENDEDOR);
                    if (!$vendedorQ) {
                        $vendedorQ = new Vendedor();
                        $vendedorQ->setNombre($VENDEDOR);
                        $vendedorQ->save();
                    }
                    $cliente->setVendedorId($vendedorQ->getId());
                    $cliente->setObservaciones($OBSERVACION_INTERNAS);
                    $cliente->setTipoProducto($PRECIO);
                    $cliente->setTipoReferencia($FUENTE);
                    $cliente->setTipoCliente($TIPO_CLIENTE);
                    $cliente->save();
                    $con = Propel::getConnection();
                    $con->beginTransaction();
                    try {
                        if ($FECHA_DE_INGRESO) {
                            $cliente->setFecha($FECHA_DE_INGRESO);
                            $cliente->save();
                        }
                        $con->commit();
                    } catch (Exception $e) {
                        $con->rollback();
                        echo $e->getMessage() . " " . $CODIGO_CLIENTE . " " . $NOMBRE . " ==> " . $FECHA_DE_INGRESO . " --> " . $FECHA . " <br>";
                    }
                }
            }
        }
        echo "actualizado " . $contador;
        die();
    }

    public function executeDeptos(sfWebRequest $request) {
        error_reporting(-1);
        $inputFileName = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . "Departamentos.xls";
        $objReader = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $cont = 0;
        foreach ($sheetData as $regisr) {
            $cont++;
            if ($cont > 1) {
                $paris = $regisr['A'];
                $dpto = $regisr['B'];
                $mun = $regisr['C'];
                $paisqQue = PaisQuery::create()->findOneByNombre($paris);
                if (!$paisqQue) {
                    $paisqQue = new Pais();
                    $paisqQue->setCodigoIso(substr($paris, 0, 5));
                    $paisqQue->setActivo(true);
                    $paisqQue->setNombre($paris);
                    $paisqQue->save();
                }
                $Depque = DepartamentoQuery::create()
                        ->filterByNombre($dpto)
                        ->filterByPaisId($paisqQue->getId())
                        ->findOne();
                if (!$Depque) {
                    $Depque = new Departamento();
                    $Depque->setPaisId($paisqQue->getId());
                    $Depque->setCodigo(substr($dpto, 0, 15));
                    $Depque->setNombre($dpto);
                    $Depque->setActivo(true);
                    $Depque->save();
                }
                $MUNQue = MunicipioQuery::create()
                        ->filterByDepartamentoId($Depque->getId())
                        ->filterByDescripcion($mun)
                        ->findOne();
                if (!$MUNQue) {
                    $MUNQue = new Municipio();
                    $MUNQue->setAbreviatura(substr($mun, 0, 30));
                    $MUNQue->setActivo(true);
                    $MUNQue->setDepartamentoId($Depque->getId());
                    $MUNQue->setDescripcion($mun);
                    $MUNQue->save();
                }
            }
        }
        echo "Actualizados " . $cont;
        die();
    }
    
        public function executeCuentaCobrarssssss(sfWebRequest $request) {
        $filename = 'CuentaCobrar.xlsxxxxxxxxxx';
        $inputFileName = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . $filename;
        $objReader = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $contador = 0;
//        
//        echo "<pre>";
//        print_r($sheetData);
//        die();
        foreach ($sheetData as $registro) {
            $contador++;
            if ($contador > 1) {
             $FECHA_FACTURA= $registro['A'];
            $DOCUMENTO= $registro['B'];
            $NODOCUMENTO= $registro['C'];
            $FECHAVENCIMIENTO= $registro['D'];
            $Total= $registro['E'];
            $CODIGO_CLIENTE= $registro['F'];
            $NOMBRE_CLIENTE = $registro['G'];
            $CODIGO_VENDEDOR= $registro['H'];
            $NOMBRE_VENDEDOR= $registro['I'];
            
            $codigoOperacion = $DOCUMENTO."-".$NODOCUMENTO;
            $operacioQ= OperacionQuery::create()->findOneByCodigo($codigoOperacion);
            if (!$operacioQ) {
                $operacioQ= new Operacion();
                $operacioQ->setCodigo($codigoOperacion);
            }
            $operacioQ->setCodigoFactura($codigoOperacion);
             $operacioQ->setFecha($FECHA_FACTURA);
             $operacioQ->setFechaCobro($FECHAVENCIMIENTO);
             $operacioQ->setValorPagado(0);
             $operacioQ->setValorTotal($Total);
             $operacioQ->setNombre($NOMBRE_CLIENTE);
             $clienteQ = ClienteQuery::create()->findOneByCodigo($CODIGO_CLIENTE);
             if (!$clienteQ) {
                 $clienteQ = New Cliente();
                 $clienteQ->setCodigo($CODIGO_CLIENTE);
                 $clienteQ->setNombre($NOMBRE_CLIENTE);
                 $clienteQ->save();
             }
             $operacioQ->setClienteId($clienteQ->getId());
             $Vendedro= VendedorQuery::create()->findOneByCodigo($CODIGO_VENDEDOR);
             if (!$Vendedro) {
                 $Vendedro= new Vendedor();
                 $Vendedro->setCodigo($CODIGO_VENDEDOR);
             $Vendedro->setNombre($NOMBRE_VENDEDOR);
                 $Vendedro->save();
             }
             $operacioQ->setEstatus('Cuenta Cobrar');
             $operacioQ->setPagado(false);
             $operacioQ->setVendedorId($Vendedro->getId());
             $operacioQ->save();
                

               
                }
            }
      
        echo "actualizado " . $contador;
        die();
    }

}
