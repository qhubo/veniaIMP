    <?php $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa'); ?>


<?php $modulo = $sf_params->get('module'); ?>


<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Carga de Partidas Historico <small> puedes actualizar una listado de partida mediante un archivo excel </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/reporte') ?>" class="btn btn-secondary btn-hover-brand" > <i class="flaticon-download-1"></i> Archivo Modelo Carga  </a>
         </div>


    </div>
    <div class="kt-portlet__body">
        
   

        <div class="row">
            <div class="col-lg-8"><br></div>
        </div>
        <div class="row ">
            <div class="col-lg-7 note note-info note-bordered">
                <p>Procede a cargar el archivo  </p>
            </div>
            <div class="col-lg-3">   

                <a href="<?php echo url_for("carga/index?tipo=cargahistorico") ?>" class="btn btn-dark" data-toggle="modal" data-target="#ajaxmodal"> <li class="fa flaticon-upload"></li> Importar archivo   </a>
            </div>
        </div>
        <div class="row">
            <br><br><br>

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


              
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>