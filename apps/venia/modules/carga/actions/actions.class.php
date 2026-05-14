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

public function executePedido(sfWebRequest $request)
{
    error_reporting(-1);

    $ordenId  = sfContext::getInstance()->getUser()->getAttribute('CotizacionId', null, 'seguridad');
    $precioId = sfContext::getInstance()->getUser()->getAttribute('PrecioID', null, 'seguridad');
    $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');

    $id = $request->getParameter('id');

    $bitacora = BitacoraArchivoQuery::create()->findOneById($id);

    if (!$bitacora) {
        $this->getUser()->setFlash('error', 'Archivo no encontrado');
        $this->redirect('orden_cotizacion/index?id=' . $ordenId);
    }

    /*
    |--------------------------------------------------------------------------
    | EVITAR DOBLE PROCESO
    |--------------------------------------------------------------------------
    */

//    if ($bitacora->getProcesado()) {
//        $this->getUser()->setFlash('error', 'El archivo ya fue procesado');
//        $this->redirect('orden_cotizacion/index?id=' . $ordenId);
//    }

    sfContext::getInstance()->getUser()->setAttribute('muestrabusqueda', 0, 'busqueda');

    $filename = $bitacora->getNombre();

    $inputFileName = sfConfig::get("sf_upload_dir")
        . DIRECTORY_SEPARATOR
        . 'cargas'
        . DIRECTORY_SEPARATOR
        . $filename;

    if (!file_exists($inputFileName)) {
        $this->getUser()->setFlash('error', 'Archivo físico no encontrado');
        $this->redirect('orden_cotizacion/index?id=' . $ordenId);
    }

    $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);

    $TIPO_USUARIO = strtoupper($usuarioQ->getTipoUsuario());

    /*
    |--------------------------------------------------------------------------
    | LEER EXCEL
    |--------------------------------------------------------------------------
    */

    $objReader = new PHPExcel_Reader_Excel5();
    $objPHPExcel = $objReader->load($inputFileName);

    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

    $contador = 0;

    $columnaCodigo = null;
    $columnaCantidad = null;
    $columnaValor = null;

    /*
    |--------------------------------------------------------------------------
    | AGRUPAR PRODUCTOS
    |--------------------------------------------------------------------------
    */

    $productosAgrupados = [];

    foreach ($sheetData as $registro) {

        $contador++;

        /*
        |--------------------------------------------------------------------------
        | ENCABEZADO
        |--------------------------------------------------------------------------
        */

        if ($contador == 2) {

            for ($i = 0; $i <= 10; $i++) {

                $letra = sfContext::getInstance()->getUser()->numeroletra($i);

                if (!isset($registro[$letra])) {
                    continue;
                }

                $valor = strtoupper(
                    str_replace(
                        [" ", "_"],
                        "",
                        trim($registro[$letra])
                    )
                );

                if ($valor == 'CODIGO') {
                    $columnaCodigo = $letra;
                }

                if ($valor == 'CANTIDAD') {
                    $columnaCantidad = $letra;
                }

                if ($valor == 'VALORUNITARIO') {
                    $columnaValor = $letra;
                }
            }

            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDAR COLUMNAS
        |--------------------------------------------------------------------------
        */

        if (
            !$columnaCodigo ||
            !$columnaCantidad ||
            !$columnaValor
        ) {

            $this->getUser()->setFlash(
                'error',
                'Columnas requeridas: CODIGO, CANTIDAD, VALOR UNITARIO'
            );

            $this->redirect('orden_cotizacion/index?id=' . $ordenId);
        }

        /*
        |--------------------------------------------------------------------------
        | SOLO DATOS
        |--------------------------------------------------------------------------
        */

        if ($contador <= 2) {
            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | OBTENER DATOS
        |--------------------------------------------------------------------------
        */

        $codigo = isset($registro[$columnaCodigo])
            ? strtoupper(trim($registro[$columnaCodigo]))
            : '';

        if (empty($codigo)) {
            continue;
        }

        $cantidad = isset($registro[$columnaCantidad]) &&
            is_numeric($registro[$columnaCantidad])
            ? (double)$registro[$columnaCantidad]
            : 0;

        $valorTexto = isset($registro[$columnaValor])
            ? trim($registro[$columnaValor])
            : 0;

        $valorTexto = str_replace(
            [',', 'Q', '$', ' '],
            '',
            $valorTexto
        );

        $valorUnitario = is_numeric($valorTexto)
            ? (double)$valorTexto
            : 0;

        if ($cantidad <= 0) {
            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | AGRUPAR SKU REPETIDOS DEL EXCEL
        |--------------------------------------------------------------------------
        */

        if (!isset($productosAgrupados[$codigo])) {

            $productosAgrupados[$codigo] = [
                'cantidad' => 0,
                'valor' => $valorUnitario
            ];
        }

        $productosAgrupados[$codigo]['cantidad'] += $cantidad;
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR PRODUCTOS
    |--------------------------------------------------------------------------
    */

    foreach ($productosAgrupados as $codigo => $datos) {

        $cantidad = $datos['cantidad'];
        $valorUnitario = $datos['valor'];

        $producto = ProductoQuery::create()
            ->filterByCodigoSku($codigo)
            ->findOne();

        if (!$producto) {
            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | PRECIO MINIMO
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | SI NO VIENE PRECIO
        |--------------------------------------------------------------------------
        */

        if (!$valorUnitario) {

            if ($precioId == 999) {
                $valorUnitario = $producto->getPrecio();
            }

            $precioq = ProductoPrecioQuery::create()
                ->filterByProductoId($producto->getId())
                ->filterByListaPrecioId($precioId)
                ->findOne();

            if ($precioq) {
                $valorUnitario = $precioq->getValor();
            }
        }

        $valoresIva = ParametroQuery::ObtenerIva($valorUnitario, false);

        /*
        |--------------------------------------------------------------------------
        | VALIDAR SI YA EXISTE EN LA ORDEN
        |--------------------------------------------------------------------------
        */

        $detalleExistente = OrdenCotizacionDetalleQuery::create()
            ->filterByOrdenCotizacionId($ordenId)
            ->filterByProductoId($producto->getId())
            ->findOne();

        if ($detalleExistente) {

            $nuevaCantidad = $detalleExistente->getCantidad() + $cantidad;

            $detalleExistente->setCantidad($nuevaCantidad);

            $detalleExistente->setValorUnitario($valorUnitario);

            $detalleExistente->setValorTotal(
                round($valorUnitario * $nuevaCantidad, 2)
            );

            $detalleExistente->save();

        } else {

            $ordenQD = new OrdenCotizacionDetalle();

            $ordenQD->setProductoId($producto->getId());
            $ordenQD->setDetalle($producto->getNombre());
            $ordenQD->setCodigo($producto->getCodigoSku());
            $ordenQD->setCantidad($cantidad);
            $ordenQD->setValorUnitario($valorUnitario);
            $ordenQD->setValorTotal(
                round($valorUnitario * $cantidad, 2)
            );
            $ordenQD->setTotalIva($valoresIva['IVA']);
            $ordenQD->setOrdenCotizacionId($ordenId);
            $ordenQD->setCostoUnitario(
                $producto->getCostoProveedor()
            );
            $ordenQD->setArchivo(true);

            $ordenQD->save();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RECALCULAR TOTALES
    |--------------------------------------------------------------------------
    */

    $ordenQ = OrdenCotizacionQuery::create()
        ->findOneById($ordenId);

    $lista = OrdenCotizacionDetalleQuery::create()
        ->withColumn(
            'SUM(OrdenCotizacionDetalle.ValorTotal)',
            'TotalGeneral'
        )
        ->filterByOrdenCotizacionId($ordenId)
        ->findOne();

    $suma = (double)$lista->getTotalGeneral();

    $valores = ParametroQuery::ObtenerIva($suma, false);

    $ordenQ->setSubTotal($valores['VALOR_SIN_IVA']);
    $ordenQ->setIva($valores['IVA']);
    $ordenQ->setValorTotal($suma);

    $ordenQ->save();

    /*
    |--------------------------------------------------------------------------
    | MARCAR ARCHIVO PROCESADO
    |--------------------------------------------------------------------------
    */

    $bitacora->setProcesado(true);
    $bitacora->save();

    $this->getUser()->setFlash(
        'exito',
        'Archivo cargado correctamente'
    );

    $this->redirect(
        'orden_cotizacion/index?id=' . $ordenId
    );
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
               
                
                sfContext::getInstance()->getUser()->setAttribute('PrecioID', $valores['precio'], 'seguridad');
                
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
