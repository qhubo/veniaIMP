<style>
    .portafolio-card {
        background: #fff;
        border: 1px solid #e6e6e6;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 25px;
        height: 100%;
        transition: all .20s ease;
    }
    .portafolio-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 18px rgba(0,0,0,.12);
    }
    .portafolio-imagen {
        height: 220px;
        background: #f7f7f7;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        cursor: pointer;
    }
    .portafolio-imagen img {
        max-width: 100%;
        max-height: 210px;
        object-fit: contain;
        transition: transform .25s ease;
    }
    .portafolio-card:hover .portafolio-imagen img {
        transform: scale(1.06);
    }
    .portafolio-info {
        padding: 15px;
    }
    .portafolio-sku {
        font-size: 11px;
        color: #999;
        margin-bottom: 5px;
    }
    .portafolio-nombre {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        line-height: 20px;
        min-height: 40px;
    }
    .portafolio-nombre-ingles {
        font-size: 12px;
        color: #999;
        min-height: 18px;
        margin-top: 3px;
    }
    .portafolio-marca {
        font-size: 12px;
        color: #555;
        margin-top: 10px;
    }
    .marcas-vehiculo {
        margin-top: 8px;
        min-height: 25px;
    }
    .marca-vehiculo {
        display: inline-block;
        padding: 3px 7px;
        margin: 2px;
        background: #146EBE;
        color: #fff;
        border-radius: 3px;
        font-size: 10px;
    }
    .portafolio-existencia {
        margin-top: 12px;
    }
    .existencia-label {
        display: inline-block;
        background: #00AA96;
        color: #fff;
        padding: 5px 9px;
        border-radius: 4px;
        font-size: 11px;
    }
    .portafolio-precio {
        margin-top: 10px;
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }
    .portafolio-busqueda {
        width: 250px;
    }
 .imagen-modal-contenedor {
    text-align: center;
    padding: 10px;
    overflow: auto;
    max-height: 80vh;
}

#imagenModal {
    max-width: 100%;
    max-height: 75vh;
    width: auto;
    height: auto;
    object-fit: contain;
    transition: transform .2s ease;
    transform-origin: center center;
    cursor: zoom-in;
}
</style>
<script src="/assets/global/plugins/jquery.min.js"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>

    <?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
              Productos
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a  href="<?php echo url_for('reporte_portafolio/portafolioPdf'); ?>"    target="_blank"  class="btn btn-danger btn-outline">
    <i class="fa fa-file-pdf-o"></i>
    PDF
</a>
            <div class="kt-input-icon kt-input-icon--left portafolio-busqueda">
                <input  type="text" class="form-control"  placeholder="Buscar producto..."  id="generalSearch" autocomplete="off" >
                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                    <span>
                        <i class="la la-search"></i>
                    </span>
                </span>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row" id="portafolioProductos" >
            <?php if ($productos && count($productos) > 0) { ?>
                <?php foreach ($productos as $lista) { ?>
                    <?php
                    $existencia = isset($existencias[$lista->getId()]) ? $existencias[$lista->getId()] : 0;
                    $textoBusqueda = strtolower(
                            $lista->getCodigoSku() . ' ' .
                            $lista->getNombre() . ' ' .
                            $lista->getNombreIngles() . ' ' .
                            $lista->getMarcaProducto());
                    ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 producto-card">
                        <div class="portafolio-card">
                            <div  class="portafolio-imagen img-producto"  data-imagen="<?php echo $lista->getImagen(); ?>" >
                                <img  src="<?php echo $lista->getImagen(); ?>" alt="<?php echo htmlspecialchars($lista->getNombre()); ?>"  >
                            </div>
                            <div class="portafolio-info">
                                <div class="portafolio-sku">
                                    SKU: <?php echo $lista->getCodigoSku(); ?>
                                </div>
                                <div class="portafolio-nombre">
        <?php echo $lista->getNombre(); ?>
                                </div>
                                    <?php if ($lista->getNombreIngles() != '') { ?>
                                    <div class="portafolio-nombre-ingles">
                                    <?php echo $lista->getNombreIngles(); ?>
                                    </div>
                                    <?php } ?>
                                <div class="portafolio-marca">
                                    <strong>Marca:</strong> <?php echo $lista->getMarcaProducto(); ?>
                                </div>

        <?php $marcas = isset($marcasVehiculo[$lista->getId()]) ? $marcasVehiculo[$lista->getId()] : array(); ?>
               <?php if (!empty($marcas)) { ?>
                                <?php if (count($marcas) >0 ) { ?>
                                    <div class="marcas-vehiculo">
                                        <div style="font-size:11px;color:#777;margin-bottom:4px;">
                                            <strong>
                                                Compatible con:
                                            </strong>
                                        </div>
            <?php foreach ($marcas as $marcaVehiculo) { ?>
                                            <span class="marca-vehiculo">
                <?php echo htmlspecialchars($marcaVehiculo, ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
            <?php } ?>
                                    </div>

                                        <?php } ?>
                                <div class="portafolio-existencia">
                                    <span class="existencia-label">
                                        <i class="fa fa-cubes"></i>
                                        Existencia:
                                <?php echo number_format($existencia, 0, '.', ','); ?>
                                    </span>
                                </div>
                                <div class="portafolio-precio">
        <?php echo Parametro::formato($lista->getPrecio(), true); ?>
                                </div>
                            </div>
                        </div>
                    </div>
             <?php } ?>
                                <?php } ?>
                            <?php } else { ?>
                <div class="col-md-12">
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle"></i>
                        No existen productos disponibles en el portafolio.
                    </div>
                </div>
<?php } ?>
        </div>
        <div id="sinResultados" class="alert alert-warning text-center" style="display:none;" >
            <i class="fa fa-search"></i>
            No se encontraron productos con el criterio de búsqueda.
        </div>
    </div>
</div>

<div class="modal fade" id="imagenProductoModal"  tabindex="-1"  role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"  role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Imagen del producto
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <div class="modal-body imagen-modal-contenedor">
                <img id="imagenModal"    src=""  alt="Imagen producto"  >
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        /*
         * =====================================================
         * BUSCADOR DE PRODUCTOS
         * =====================================================
         */

        $('#generalSearch').on('keyup input', function () {

            var texto = $.trim($(this).val()).toLowerCase();
            var encontrados = 0;

            $('.producto-card').each(function () {

                var card = $(this);
                var contenido = card.text().toLowerCase();

                if (texto === '' || contenido.indexOf(texto) !== -1) {

                    card.show();
                    encontrados++;

                } else {

                    card.hide();

                }

            });

            if (encontrados === 0 && texto !== '') {

                $('#sinResultados').show();

            } else {

                $('#sinResultados').hide();

            }

        });


        /*
         * =====================================================
         * ABRIR IMAGEN GRANDE
         * =====================================================
         */

        $(document).on('click', '.img-producto', function () {

            var imagen = $(this).attr('data-imagen');

            if (!imagen) {
                return;
            }

            $('#imagenModal').attr('src', imagen);

            $('#imagenProductoModal')
                .css('display', 'block')
                .addClass('show');

            $('body').addClass('modal-open');

        });


        /*
         * =====================================================
         * CERRAR MODAL
         * =====================================================
         */

        $(document).on('click', '#imagenProductoModal .close', function () {

            cerrarModalImagen();

        });


        /*
         * CERRAR AL HACER CLICK FUERA DE LA IMAGEN
         */

        $(document).on('click', '#imagenProductoModal', function (e) {

            if ($(e.target).is('#imagenProductoModal')) {

                cerrarModalImagen();

            }

        });


        /*
         * =====================================================
         * FUNCIÓN CERRAR MODAL
         * =====================================================
         */

        function cerrarModalImagen() {

            $('#imagenProductoModal')
                .removeClass('show')
                .css('display', 'none');

            $('#imagenModal').attr('src', '');

            $('body').removeClass('modal-open');

        }

    });
</script>