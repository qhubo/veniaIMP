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

    public function executePedido(sfWebRequest $request) {
        error_reporting(-1);
        $ordenId = sfContext::getInstance()->getUser()->getAttribute('CotizacionId', null, 'seguridad');
        $id = $request->getParameter('id');
        $bitacora = BitacoraArchivoQuery::create()->findOneById($id);
        sfContext::getInstance()->getUser()->setAttribute('muestrabusqueda', 0, 'busqueda');
        $filename = $bitacora->getNombre();
        $inputFileName = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . 'cargas' . DIRECTORY_SEPARATOR . $filename;
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $TIPO_USUARIO = strtoupper($usuarioQ->getTipoUsuario());
        $objReader = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $contador = 0;
        $columnaCodigo = null;
        $columnaCantidad = null;
        $columnaValor = null;
//        echo "<pre>";
//        print_r($sheetData);
//        die();

        $columnaCodigo = null;
        $columnaCantidad = null;
        $columnaValor = null;
        $contador = 0;
        foreach ($sheetData as $registro) {
            $contador++;
            /// FILA ENCABEZADO
            if ($contador == 2) {
                for ($i = 0; $i <= 3; $i++) {
                    $letra = sfContext::getInstance()->getUser()->numeroletra($i);
                    if (!isset($registro[$letra])) {
                        continue;
                    }
                    $valor = strtoupper(str_replace(" ", "", trim($registro[$letra])));
                    if ($valor == 'CANTIDAD') {
                        $columnaCantidad = $letra;
                    }
                    if ($valor == 'CODIGO') {
                        $columnaCodigo = $letra;
                    }
                    if ($valor == 'VALORUNITARIO') {
                        $columnaValor = $letra;
                    }
                }

                continue;
            }
            /// VALIDAR COLUMNAS
            if ($contador > 2) {
                if (!$columnaCodigo || !$columnaCantidad || !$columnaValor) {
                    sfContext::getInstance()->getUser()->setAttribute('carga', null, 'busqueda');
                    $this->getUser()->setFlash('error','Revisar archivo!! Columnas requeridas: CODIGO, CANTIDAD, VALOR UNITARIO');
                   $this->redirect('orden_cotizacion/index?id=' . $ordenId);
                }

                $codigo = isset($registro[$columnaCodigo]) ? trim($registro[$columnaCodigo]) : '';
                $cantidad = isset($registro[$columnaCantidad]) && is_numeric($registro[$columnaCantidad]) ? max(0, $registro[$columnaCantidad]) : 0;
                $valorUnitario = isset($registro[$columnaValor]) && is_numeric($registro[$columnaValor]) ? max(0, $registro[$columnaValor]) : 0;
                if ($cantidad <= 0 || $valorUnitario <= 0) {
                    continue;
                }
                $producto = ProductoQuery::create()
                        ->filterByCodigoSku($codigo)
                        ->findOne();
                if (!$producto) {
                    continue;
                }
                /// PRECIO MINIMO
                $menor = $producto->getPrecio();
                $precios = ListaPrecioQuery::create()
                        ->filterByActivo(true)
                        ->find();
                foreach ($precios as $deta) {
                    $precioLista = $producto->getPrecioLista($deta->getId());
                    if ($precioLista < $menor) {
                        $menor = $precioLista;
                    }
                }
                if ($TIPO_USUARIO == 'ADMINISTRADOR') {
                    $menor = 0;
                }
                if ($valorUnitario < $menor) {
                    $valorUnitario = $menor;
                }
                /// CALCULAR IVA CORRECTAMENTE
                $valoresIva = ParametroQuery::ObtenerIva($valorUnitario, false);
                $ordenQD = new OrdenCotizacionDetalle();
                $ordenQD->setProductoId($producto->getId());
                $ordenQD->setDetalle($producto->getNombre());
                $ordenQD->setCodigo($producto->getCodigoSku());
                $ordenQD->setCantidad($cantidad);
                $ordenQD->setValorUnitario($valorUnitario);
                $ordenQD->setValorTotal(round($valorUnitario * $cantidad, 2));
                $ordenQD->setTotalIva($valoresIva['IVA']);
                $ordenQD->setOrdenCotizacionId($ordenId);
                $ordenQD->setCostoUnitario($producto->getCostoProveedor());
                $ordenQD->save();
            }
        }
        $ordenQ = OrdenCotizacionQuery::create()->findOneById($ordenId);
        $lista = OrdenCotizacionDetalleQuery::create()
                ->withColumn('sum(OrdenCotizacionDetalle.ValorTotal)', 'TotalGeneral')
                ->filterByOrdenCotizacionId($ordenId)
                ->findOne();
        $suma = $lista->getTotalGeneral();
        $valores = ParametroQuery::ObtenerIva($suma, false);
        $iva = $valores['IVA'];
        $valorSInIVa = $valores['VALOR_SIN_IVA'];
        $ordenQ->setSubTotal($valorSInIVa);
        $ordenQ->setValorTotal($suma);
        $ordenQ->setIva($iva);
        $ordenQ->save();
        $this->getUser()->setFlash('exito', ' Archivo exportado con éxito ');
        $this->redirect('orden_cotizacion/index?id=' . $ordenId);
    }

    public function executeProveedor(sfWebRequest $request) {
        $filename = 'LISTAPROVE.xls';
        $inputFileName = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . $filename;
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
        echo "actualizado " . $contador;
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

                if ($this->tipo == 'ordencompra') {
                    $this->redirect('orden_compra/carga?id=' . $bitacora->getId());
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

                if ($this->tipo == 'pedido') {
                    $this->redirect('carga/pedido?id=' . $bitacora->getId());
                }


                $this->redirect('cuenta_contable/carga?id=' . $bitacora->getId());
            }
        }
    }

}
