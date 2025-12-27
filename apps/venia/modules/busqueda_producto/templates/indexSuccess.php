
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venia Link</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        /* Estilos por defecto */
        .buscador-fullscreen {
            font-size: 1.5rem;
        }

        /* Modo pantalla completa en móvil */
        @media (max-width: 576px) {
            .buscador-fullscreen {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;

                font-size: 3rem;      /* Letra gigante */
                text-align: center;

                border-radius: 0;
                border: none;

                padding: 1rem;
                z-index: 9999;
                background-color: #f8f9fa;
            }

            .buscador-fullscreen:focus {
                outline: none;
            }

            body {
                overflow: hidden; /* Evita el scroll */
            }

            .btn-cerrar {
                position: fixed;
                top: 15px;
                right: 15px;
                z-index: 10000;
                background-color: red;
                color: white;
                font-size: 2rem;
                border-radius: 50%;
                padding: 0.5rem 1rem;
                border: none;
            }

            .btn-cerrar:hover {
                background-color: #dc3545;
            }
        }
    </style>
</head>


<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label w-100 text-center text-md-start">
            <h3 class="kt-portlet__head-title kt-font-info">
                🔍 Buscador de Productos
            </h3>
        </div>
          <div class="kt-portlet__head-toolbar">
        
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="row" style="padding-top:10px; padding-bottom: 10px;">
            <div class="col-10 ">
                <!-- Input de búsqueda -->
                <input type="text"
                       id="buscar"
                       class="form-control "
                       placeholder="Buscar por SKU o nombre"
                       autofocus>
            </div>
            <div class="col-2">
                 <a href="<?php echo url_for('inicio/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

            </div>


        </div>

        <div class="row">
            <div class="col-12">
                <div id="resultado"></div>
            </div>
        </div>
    </div>
</div>


<script>
    // Función para cerrar el input (cuando el botón cerrar es presionado)
    function cerrarBuscador() {
        document.getElementById('buscar').blur(); // Cierra el teclado
    }
</script>

<script>
    let page = 1;

    function buscar(reset = false) {
        if (reset)
            page = 1;

        $.get(
                '<?php echo url_for("busqueda_producto/buscar") ?>',
                {q: $('#buscar').val(), page: page},
                function (html) {
                    $('#resultado').html(html);
                }
        );
    }

    $('#buscar').on('keyup', function () {
        buscar(true);
    });

    $(document).on('click', '.page-link', function () {
        page = $(this).data('page');
        buscar();
    });
</script>

