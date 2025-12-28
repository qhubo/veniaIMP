<?php

class ProveedorPeer extends BaseProveedorPeer {

    static public function limpiatil($subject) {
        $subject = str_replace("á", 'a', $subject);
        $subject = str_replace("é", 'e', $subject);
        $subject = str_replace("í", 'i', $subject);
        $subject = str_replace("ó", 'o', $subject);
        $subject = str_replace("ú", 'u', $subject);
        $subject = str_replace("Á", 'A', $subject);
        $subject = str_replace("É", 'E', $subject);
        $subject = str_replace("Í", 'I', $subject);
        $subject = str_replace("Ó", 'O', $subject);
        $subject = str_replace("Ú", 'U', $subject);
        return $subject;
    }

    static public function pobladatos($id, $empresaId = null) {

        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $empresaId = $usuarioQue->getEmpresaId();
        $lineaInicial = 2;
        //     header('Content-type: text/plain; charset=utf-8');
        $bitacora = BitacoraArchivoQuery::create()->findOneById($id);
        sfContext::getInstance()->getUser()->setAttribute('muestrabusqueda', 0, 'busqueda');
        $filename = $bitacora->getNombre();
        $inputFileName = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . 'cargas' . DIRECTORY_SEPARATOR . $filename;
        $objReader = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $contador = 0;
        $colcodigo_sku = null;
        $colcodigo_barras = null;
        $colcodigo_arancel = null;
        $colCodGrupo = null;
        $colGRUPO = null;
        $colCodSUBGRUPO = null;
        $colSUBGRUPO = null;
        $colCodProveedor = null;
        $colProveedor = null;
        $colMarca = null;
        $colCARACTERISTICAS = null;
        $colNOMBRE = null;
        $colDESCRIPCION = null;
        $colNOMBREingles = null;
        $colPrecio = null;
        $colCosto = null;
        $colEXISTENCIA = null;
        $colalto = null;
        $colancho = null;
        $collargo = null;
        $colpeso = null;
        $colcostofabrica = null;
        $colcostocif = null;

        $datos = null;
        $NUMERO = 0;

        foreach ($sheetData as $registro) {
            $codigo_sku = '';
            $codigo_barras = '';
            $codigo_arancel = '';
            $CodGrupo = '';
            $GRUPO = '';
            $CodSUBGRUPO = '';
            $SUBGRUPO = '';
            $CodProveedor = '';
            $Proveedor = '';
            $Marca = '';
            $CARACTERISTICAS = '';
            $NOMBRE = '';
            $DESCRIPCION = '';
            $NOMBREingles = '';
            $Precio = 0;
            $Costo = 0;
            $EXISTENCIA = 0;
            $alto = 0;
            $ancho = 0;
            $largo = 0;
            $peso = 0;
            $costofabrica = 0;
            $costocif = 0;
            $valido = true;
            $contador++;
            $textoPendiente = '';
            $pendientes = null;
            $lin = $lineaInicial;
            /// encabezado
            //   echo  'codigo_sku');
            if ($contador == $lineaInicial) {
                for ($i = 0; $i <= 25; $i++) {
                    $letra = CorrelativoCodigoQuery::numeroletra($i); //sfContext::getInstance()->getUser()->numeroletra($i);
                    $campo = trim(strtoupper(($registro[$letra])));
                    $campo = ($campo);
                    $campo = trim(strtoupper($campo));
                    $campo = str_replace(" ", "", $campo); //                  
                    switch ($campo) {
                        case trim(strtoupper(('codigo_sku'))):
                            $colcodigo_sku = $letra;
                            break;
                        case trim(strtoupper(('codigo_barras'))):
                            $colcodigo_barras = $letra;
                            break;
                        case trim(strtoupper(('codigo_arancel'))):
                            $colcodigo_arancel = $letra;
                            break;
                        case trim(strtoupper(('codigo_grupo'))):
                            $colCodGrupo = $letra;
                            break;
                        case trim(strtoupper(('grupo'))):
                            $colGRUPO = $letra;
                            break;
                        case trim(strtoupper(('codigo_subgrupo'))):
                            $colCodSUBGRUPO = $letra;
                            break;
                        case trim(strtoupper(('subgrupo'))):
                            $colSUBGRUPO = $letra;
                            break;
                        case trim(strtoupper(('codigo_proveedor'))):
                            $colCodProveedor = $letra;
                            break;
                        case trim(strtoupper(('proveedor'))):
                            $colProveedor = $letra;
                            break;
                        case trim(strtoupper(('Marca'))):
                            $colMarca = $letra;
                            break;
                        case trim(strtoupper(('CARACTERISTICAS'))):
                            $colCARACTERISTICAS = $letra;
                            break;
                        case trim(strtoupper(('nombre'))):
                            $colNOMBRE = $letra;
                            break;
                        case trim(strtoupper(('descripcion'))):
                            $colDESCRIPCION = $letra;
                            break;
                        case trim(strtoupper(('nombreingles'))):
                            $colNOMBREingles = $letra;
                            break;
                        case trim(strtoupper(('precio'))):
                            $colPrecio = $letra;
                            break;
                        case trim(strtoupper(('costo'))):
                            $colCosto = $letra;
                            break;
                        case trim(strtoupper(('EXISTENCIA'))):
                            $colEXISTENCIA = $letra;
                            break;
                        case trim(strtoupper(('EXISTENCIAs'))):
                            $colEXISTENCIA = $letra;
                            break;
                        case trim(strtoupper(('alto'))):
                            $colalto = $letra;
                            break;
                        case trim(strtoupper(('ancho'))):
                            $colancho = $letra;
                            break;
                        case trim(strtoupper(('largo'))):
                            $collargo = $letra;
                            break;
                        case trim(strtoupper(('peso'))):
                            $colpeso = $letra;
                            break;
                        case trim(strtoupper(('costofabrica'))):
                            $colcostofabrica = $letra;
                            break;
                        case trim(strtoupper(('costocif'))):
                            $colcostocif = $letra;
                            break;
                    }
                }
                //     die();
            }
            if ($contador > $lineaInicial) {
                //  die();
                $NUMERO++;
                if (array_key_exists($colcodigo_sku, $registro)) {
                    $codigo_sku = $registro[$colcodigo_sku];
                } else {
                    $valido = false;
                    $pendientes[] = 'codigo_sku';
                }
                if (array_key_exists($colcodigo_barras, $registro)) {
                    $codigo_barras = ($registro[$colcodigo_barras]);
                } else {
                    $valido = false;
                    $pendientes[] = 'codigo_barras';
                }
                 if (array_key_exists($colcodigo_arancel, $registro)) {
                    $codigo_arancel = ($registro[$colcodigo_arancel]);
                } else {
                    $valido = false;
                    $pendientes[] = 'codigo_arancel';
                }
                if (array_key_exists($colCodGrupo, $registro)) {
                    $CODIGO_GRUPO = ($registro[$colCodGrupo]);
                } else {
                    $valido = false;
                    $pendientes[] = 'codigo_grupo';
                }
                if (array_key_exists($colGRUPO, $registro)) {
                    $GRUPO = ($registro[$colGRUPO]);
                } else {
                    $valido = false;
                    $pendientes[] = 'grupo';
                }
                if (array_key_exists($colCodSUBGRUPO, $registro)) {
                    $CODIGO_SUBGRUPO = ($registro[$colCodSUBGRUPO]);
                } else {
                    $valido = false;
                    $pendientes[] = 'codigo_subgrupo';
                }
                if (array_key_exists($colSUBGRUPO, $registro)) {
                    $SUBGRUPO = ($registro[$colSUBGRUPO]);
                } else {
                    $valido = false;
                    $pendientes[] = 'subgrupo';
                }
                if (array_key_exists($colCodProveedor, $registro)) {
                    $COD_PROVEEDOR = ($registro[$colCodProveedor]);
                } else {
                    $pendientes[] = 'codigo_proveedor';
                }
                if (array_key_exists($colProveedor, $registro)) {
                    $PROVEEDOR = ($registro[$colProveedor]);
                } else {
                    $pendientes[] = 'proveedor';
                }                
                if (array_key_exists($colMarca, $registro)) {
                    $Marca = ($registro[$colMarca]);
                } else {
                    $valido = false;
                    $pendientes[] = 'Marca';
                }
                if (array_key_exists($colCARACTERISTICAS, $registro)) {
                    $CARACTERISTICAS = ($registro[$colCARACTERISTICAS]);
                } else {
                    $valido = false;
                    $pendientes[] = 'CARACTERISTICAS';
                }

                if (array_key_exists($colNOMBRE, $registro)) {
                    $NOMBRE = ($registro[$colNOMBRE]);
                } else {
                    $valido = false;
                    $pendientes[] = 'nombre';
                }
                if (array_key_exists($colDESCRIPCION, $registro)) {
                    $DESCRIPCION = ($registro[$colDESCRIPCION]);
                } else {
                }
               if (array_key_exists($colNOMBREingles, $registro)) {
                    $NOMBREingles= ($registro[$colNOMBREingles]);
                } else {
                    $valido = false;
                    $pendientes[] = 'nombre ingles';
                }      
                
                if (array_key_exists($colPrecio, $registro)) {
                    $precio = strtoupper($registro[$colPrecio]);
                    $precio = str_replace("Q", "", $precio);
                    $precio = str_replace("$", "", $precio);
                    $precio = str_replace(",", "", $precio);
                    $precio = (double) $precio;
                    $precio = round($precio, 2);
                } else {
                    $valido = false;
                    $pendientes[] = 'precio';
                }
                if (array_key_exists($colCosto, $registro)) {
                    $COSTO = strtoupper($registro[$colCosto]);
                    $COSTO = str_replace("Q", "", $COSTO);
                    $COSTO = str_replace("$", "", $COSTO);
                    $COSTO = str_replace(",", "", $COSTO);
                    $COSTO = (double) $COSTO;
                    $COSTO = round($COSTO, 2);
                } else {
                    $pendientes[] = 'costo';
                }
                if (array_key_exists($colEXISTENCIA, $registro)) {
                    $EXISTENCIA = ($registro[$colEXISTENCIA]);
                }
                IF (is_numeric($EXISTENCIA)) {
                } else {
                    $EXISTENCIA = 0;
                }
                
                if (array_key_exists($colalto, $registro)) {
                    $alto = strtoupper($registro[$colalto]);
                    $alto = str_replace(",", "", $alto);
                    $alto = (double) $alto;
                } else {
                    $pendientes[] = 'alto';
                }
                  if (array_key_exists($colancho, $registro)) {
                    $ancho = strtoupper($registro[$colancho]);
                    $ancho = str_replace(",", "", $ancho);
                    $ancho = (double) $ancho;
                } else {
                    $pendientes[] = 'ancho';
                }
                if (array_key_exists($collargo, $registro)) {
                    $largo = strtoupper($registro[$collargo]);
                    $largo = str_replace(",", "", $largo);
                    $largo = (double) $largo;
                } else {
                    $pendientes[] = 'largo';
                }
                if (array_key_exists($colpeso, $registro)) {
                    $peso = strtoupper($registro[$colpeso]);
                    $peso = str_replace(",", "", $peso);
                    $peso = (double) $peso;
                } else {
                    $pendientes[] = 'peso';
                }
                if (array_key_exists($colcostofabrica, $registro)) {
                    
                    $costofabrica = strtoupper($registro[$colcostofabrica]);
                    $costofabrica = str_replace("Q", "", $costofabrica);
                    $costofabrica = str_replace("$", "", $costofabrica);
                    $costofabrica = str_replace(",", "", $costofabrica);
                    $costofabrica = (double) $costofabrica;
                } else {
                    $pendientes[] = 'costo fabrica';
                }
           
                if (array_key_exists($colcostocif, $registro)) {
                    $costocif = strtoupper($registro[$colcostocif]);
                    $costocif = str_replace(",", "", $costocif);
                       $costocif = str_replace("Q", "", $costocif);
                    $costocif = str_replace("$", "", $costocif);
                    $costocif = (double) $costocif;
                } else {
                    $pendientes[] = 'costo cif';
                }                
                $CODIGO = TRIM($CODIGO);
                IF ($CODIGO_GRUPO == "") {
                    $CODIGO_GRUPO = substr($GRUPO, 0, 4) . "-" . substr($GRUPO, -4);
                }
                if ($GRUPO == "") {
                    $GRUPO = 'N/A';
                    $CODIGO_GRUPO = 'NA';
                }
                if ($SUBGRUPO == "") {
                    $SUBGRUPO = 'N/A';
                    $CODIGO_SUBGRUPO = 'NA';
                }
                $lista['LINEA'] = $contador;
                $lista['CODIGO_SKU'] = $codigo_sku;
                $lista['CODIGOBARRAS'] = $codigo_barras;
                $lista['CODIGO_ARANCEL'] = $codigo_arancel;
                $lista['COD_GRUPO'] = $CODIGO_GRUPO;
                $lista['GRUPO'] = $GRUPO;
                $lista['COD_SUBGRUPO'] = $CODIGO_SUBGRUPO;
                $lista['SUBGRUPO'] = $SUBGRUPO;
                $lista['COD_PROVEEDOR'] = $COD_PROVEEDOR;
                $lista['PROVEEDOR'] = $PROVEEDOR;
                $lista['MARCA'] = $Marca;
                $lista['CARACTERISTICAS'] = $CARACTERISTICAS;
                $lista['NOMBRE'] = $NOMBRE;
                $lista['DESCRIPCION'] = $DESCRIPCION;
                $lista['NOMBRE_INGLES'] = $NOMBREingles;
                $lista['PRECIO'] = $precio;
                $lista['COSTO'] = $COSTO;
                $lista['EXISTENCIA'] = $EXISTENCIA;
                $lista['ALTO'] = $alto;
                $lista['ANCHO'] =$ancho;	
                $lista['LARGO']=$largo;
                $lista['PESO'] =$peso;	 
                $lista['COSTO_FABRICA']=$costofabrica; 	 
                $lista['COSTO_CIF']= $costocif;
                if (($NOMBRE <> "") && ($GRUPO <> "")) {
                    $datos[] = $lista;
                }
            }
        }
        $resultado['datos'] = $datos;
        $resultado['valido'] = $valido;
        $resultado['pendiente'] = $pendientes;

        return $resultado;
    }

}
