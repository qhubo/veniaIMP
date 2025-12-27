<?php

/**
 * factura actions.
 *
 * @package    plan
 * @subpackage factura
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class facturaActions extends sfActions {


    public function executeGraba(sfWebRequest $request) {

        $this->getResponse()->setContentType('application/json');
        date_default_timezone_set("America/Guatemala");
        $tienda = $request->getParameter('tienda');
        $referencia = $request->getParameter('referencia');
        $tipo_documento = $request->getParameter('tipo_documento');
        $firma = $request->getParameter('firma');
        $motivo = $request->getParameter('motivo');
        $firmav = true;
        if (trim($referencia) == "") {
            $firmav = false;
        }
        if (trim($tienda) == "") {
            $firmav = false;
        }
        if (trim($tipo_documento) == "") {
            $firmav = false;
        }
        $resultado['mensaje'] = "Campos pendientes";
        if ($firmav) {
            $nuevo = new Facturas();
            $nuevo->setTipoDocumento($tipo_documento);
            $nuevo->setTienda($tienda);
            $nuevo->setFirma($firma);
            $nuevo->setFecha(date('Y-m-d H:i:s'));
            $nuevo->setReferencia($referencia);
            $nuevo->setMotivo($motivo);

            $nuevo->save();
            $resultado['mensaje'] = "Registro ingresado # " . $nuevo->getId();
        }

        $data_json = json_encode($resultado);
        header("HTTP/1.1 200 " . $resultado['mensaje']);
        header('Content-type: application/json');
        echo $data_json;

        die();
    }

    public function executeIndex(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $ativaBita = 0;
        $serieFirma = ''; //$resultado['serie']; // => 
        $uuidFirma = ''; // $resultado['uuid']; // => 
        $numeroFirma = 'NN'; //$resultado['numero'];
        $listaerror = '';
        $XML = $request->getParameter('XML');
        $XML = str_replace('<dte:Descripcion/>', '<dte:Descripcion>servicio</dte:Descripcion>', $XML);
        $XML = str_replace('<dte:Descripcion></dte:Descripcion>', '<dte:Descripcion>servicio</dte:Descripcion>', $XML);
        $ALIAS_FIRMA = $request->getParameter('ALIAS_FIRMA');
        $LLAVE_FIRMA = $request->getParameter('LLAVE_FIRMA');
        $CODIGO_FA = $request->getParameter('CODIGO_FA') . "_" . date('md');

        $CORREO_EMISOR = $request->getParameter('CORREO');
        $NIT_EMISOR = $request->getParameter('NIT_EMISOR');
        $USUARIO = $request->getParameter('USUARIO');
        $ANULA = $request->getParameter('ANULA');
        $FECHA = $request->getParameter('FECHA');
        if ($FECHA <> "") {
            $CODIGO_FA = $request->getParameter('CODIGO_FA') . "_" . $FECHA;
        }
        $ALIAS_FIRMA = '3FC83662F567D561B67766B292CD36BE';
        $USUARIO = 'CPOSAPRO';
        $LLAVE_FIRMA = 'a1940a0f489f79a89d0e3f3f0d1a00ba';
        $LLAVE_FIRMA = '1e20b8926ccf904ab8acb9ae438671b3';

        $URLFIRMA = 'https://signer-emisores.feel.com.gt/sign_solicitud_firmas/firma_xml';
        $envio['llave'] = trim($LLAVE_FIRMA);
        $envio['archivo'] = base64_encode($XML);
        $envio['codigo'] = $CODIGO_FA;
        $envio['alias'] = 'CPOSAPRO';  // $ALIAS_FIRMA;
        $envio['es_anulacion'] = 'N';
        if ($FECHA <> "") {
            $envio['es_anulacion'] = 'Y';
        }
        $postData = json_encode($envio);
        $handler = curl_init();
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($handler, CURLOPT_URL, $URLFIRMA);
        curl_setopt($handler, CURLOPT_POST, true);
        curl_setopt($handler, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($handler, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($postData)));
        $resultado = curl_exec($handler);
        $info = curl_getinfo($handler);
        curl_close($handler);
        $info2 = $resultado;
        $resultado = json_decode($resultado, true);
        if (!$resultado['resultado']) {
            $errores[] = $resultado['descripcion'];
        }
        $texto = $URLFIRMA;
        $texto .= "\n  \n \n";    
        
        $texto .= $postData;
        $texto .= "\n  \n";    
           $texto .= " RESPUESTA \n  ";
            $texto .= json_encode($info);
        $texto .= "\n  \n";    
    
            $texto .= json_encode($info2);
            
        $ruta = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . "facturalog.txt";
        $fh = fopen($ruta, 'w');
        $texto .= $URLFIRMA . "-" . $XML;
        fwrite($fh, $texto);
        fclose($fh);
        if ($ativaBita) {
            $bitacora = new BitacoraProceso();
            $bitacora->setMetodo($URLFIRMA);
            $bitacora->setRequest($postData);
            $bitacora->setResponse($resultado);
            $bitacora->setFecha(date('Y-m-d H:i'));
            $bitacora->save();
        }

        if ($resultado['archivo']) {
            if ($resultado['archivo']) {
                $XML = $resultado['archivo'];
            }
            $certi['nit_emisor'] = $NIT_EMISOR;
            $certi['correo_copia'] = $CORREO_EMISOR;
            $certi['xml_dte'] = $XML;
            $certificacion = json_encode($certi);
            $request_headers['usuario'] = $USUARIO;
            $request_headers['llave'] = $ALIAS_FIRMA;
            $request_headers['identificador'] = $CODIGO_FA; //$operacionQ->getCodigoFactura();
            $request_headers['Content-Type'] = 'application/json';
            $request_headers['Content-Length'] = strlen($postData);
            $request_headers = array();
            $request_headers[] = 'usuario: ' . $USUARIO;
            $request_headers[] = 'llave: ' . $ALIAS_FIRMA;
            $request_headers[] = 'Content-Type: application/json';
            $request_headers[] = 'identificador: ' . $CODIGO_FA; // $operacionQ->getCodigoFactura();
            $URLCERTIFICACION = 'https://certificador.feel.com.gt/fel/certificacion/v2/dte';
            if ($ANULA == 1) {
                $URLCERTIFICACION = 'https://certificador.feel.com.gt/fel/anulacion/v2/dte';
            }

            $handler = curl_init();
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($handler, CURLOPT_URL, $URLCERTIFICACION);
            curl_setopt($handler, CURLOPT_POST, true);
            curl_setopt($handler, CURLOPT_POSTFIELDS, $certificacion);
            curl_setopt($handler, CURLOPT_HTTPHEADER, $request_headers);
            //        curl_setopt($handler, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($postData)));
            $resultado = curl_exec($handler);
            curl_close($handler);
            $ruta = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . "facturap.txt";
            $fh = fopen($ruta, 'w');
            $texto = $URLCERTIFICACION . "<br> /n   " . $XML;
            $texto .= " RESPUESTA <BR> /n  ";
            $texto .= json_encode($resultado);
            fwrite($fh, $texto);
            fclose($fh);
            if ($ativaBita) {
                $bitacora = new BitacoraProceso();
                $bitacora->setMetodo($URLCERTIFICACION);
                $bitacora->setRequest($certificacion);
                $bitacora->setResponse($resultado);
                $bitacora->setObservaciones(serialize($request_headers));
                $bitacora->setFecha(date('Y-m-d H:i'));
                $bitacora->save();
            }
            $resultado = json_decode($resultado, true);
            if ($resultado) {
                if (count($resultado['descripcion_errores']) <> 0) {
                    $Berrores = $resultado['descripcion_errores'][0]['mensaje_error'];
                    $Berrores = str_replace("|", "", $Berrores);
                    $erorN = explode("NIT", strtoupper($Berrores));
                    $can = count($erorN);
                    if ($can > 1) {
                        $retorna['reenvia'] = 1;
                    }
                    $erorN = explode("IDRECEPTOR", strtoupper($Berrores));
                    $can = count($erorN);
                    if ($can > 1) {
                        $retorna['reenvia'] = 1;
                    }
                    $errores[] = $Berrores;
                }
                $serieFirma = $resultado['serie']; // => 
                $uuidFirma = $resultado['uuid']; // => 
                $numeroFirma = $resultado['numero'];
            }
        }
        if ($errores) {
            $listaerror = implode(",", $errores);
        }
        
        $texto .= "\n";
        
   
        

        $RESULTADO = $serieFirma . "|" . $uuidFirma . "|" . $numeroFirma . "|" . $listaerror;
        echo $RESULTADO;
        die();
//        $bitacora = new BitacoraProceso();
//        $bitacora->setRequest($XML);
//        $bitacora->save();
//        echo "actualizado";
//        die();
    }

}
