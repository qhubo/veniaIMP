    <?php $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa'); ?>


<?php $modulo = $sf_params->get('module'); ?>


<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Carga de Productos <small> puedes actualizar una carga de productos con un archivo excel </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/reporte') ?>" class="btn btn-secondary btn-hover-brand" > <i class="flaticon-download-1"></i> Archivo Modelo Carga  </a>
         </div>


    </div>
    <div class="kt-portlet__body">
        
             <div class="row">
            <div class="col-lg-2"><span class="caption-subject  kt-font-info uppercase">Códigos</span></div>
            <div class="col-lg-8"> Las columnas codigos al estar vacia , son generadas automaticamente</div>
        </div>
        <div class="row">
            <div class="col-lg-2"><span class="caption-subject  kt-font-info uppercase">Código Sku</span></div>
            <div class="col-lg-8"> Es generado automaticamente al dejarlo en blanco </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-2"><span class="caption-subject  kt-font-info  uppercase">Código Sku </span></div>
            <div class="col-lg-8"> NO se permite códigos repetidos , al encontrar uno  existente lo renombrara con <strong>@</strong> al final </div>
        </div>
        <hr>
<!--        <div class="row">
            <div class="col-lg-2"><span class="caption-subject kt-font-info uppercase">Valores CHECK </span></div>
            <div class="col-lg-8">Columnas  <strong>Azul</strong> unicamente se permiten valores  SI  / NO </div>
        </div>
        <hr>
             <div class="row">
            <div class="col-lg-2"><span class="caption-subject kt-font-info uppercase">Valores CHECK </span></div>
            <div class="col-lg-8">Si la columna esta vacia se grabara con  SI por default </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-2"><span class="caption-subject kt-font-info uppercase">Valores CHECK </span></div>
            <div class="col-lg-8">Cualquier valor diferente a  SI, se grabara <strong>NO</strong> </div>
        </div>
        <hr>-->

        <div class="row">
            <div class="col-lg-8"><br></div>
        </div>
        <div class="row ">
            <div class="col-lg-7 note note-info note-bordered">
                <p>Tomando en cuentas las observaciones anteriores puedes proceder a cargar el arhivo    </p>
            </div>
            <div class="col-lg-3">   

                <a href="<?php echo url_for("carga/index?tipo=cargaproducto") ?>" class="btn btn-dark" data-toggle="modal" data-target="#ajaxmodal"> <li class="fa flaticon-upload"></li> Importar archivo   </a>
            </div>
        </div>
        <div class="row">
            <br><br><br>

        </div>
        
         
       
    </div>
</div>    

<div class="modal modal-stick-to-bottom fade" id="kt_modal_7" role="dialog" data-backdrop="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxmodal" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Carga Archivo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>







<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <li class="fa fa-image"></li>
                <span class="caption-subject bold font-purple-plum uppercase">Caracteristica Producto</span>
            </div>
            <div class="modal-body"> 

                <img  src="/uploads/Captura.PNG" alt="Ejemplo de carga" title="Ejemplo de carga"/>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


                                 <div id="staticV<?php echo $empresaId ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title kt-font-brand " id="exampleModalLabel">Confirmación Limpieza Productos</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p> Esta seguro de eliminar los productos de la empresa actual
                                        <span class="caption-subject font-green bold uppercase"> 
                                            <?php echo $empresa->getCodigo() ?>
                                        </span> ?
                                    </p>
                                </div>
                                <?php $token = md5($empresa->getCodigo()); ?>
                                <div class="modal-footer">
                                    <a class="btn  btn-danger " href="<?php echo url_for($modulo . '/eliminaProd?token=' . $token . '&id=' . $empresaId) ?>" >
                                        <i class="fa fa-trash-o "></i> Confirmar</a> 
                                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>

                                </div>

                            </div>
                        </div>
                    </div> 
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>