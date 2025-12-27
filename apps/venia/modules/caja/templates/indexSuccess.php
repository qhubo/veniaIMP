<?php $modulo = $sf_params->get('module'); ?>
       <?php $estiloUno = ''; ?>
 <?php $estiloDos = 'style="display:none;"'; ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-coins kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                CAJA <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                Procede a grabar el pago de algun servicio o agregara un servicio nuevo a cobrar</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-8">
                <?php include_partial('caja/vivienda', array (
                    'nombre'=>$nombre,
                    'nit'=>$nit,
                    'detalleFactura'=>$detalleFactura,
                    'propi'=>$propi,'Propietarios'=>$Propietarios, 'vivienda'=>$viviendaQ)) ?>  
            </div>
            <div class="col-lg-2">
                
                         <a class="btn btn-outline-success "   href="<?php echo url_for('busca/indexPro?id=1') ?>"  data-toggle="modal" data-target="#ajaxmodalv">
                    <li class="fa fa-search"></li> Buscar Propiedad
                </a>
                
                
<!--                <a href="#" class="btn btn-outline-success  ">
                    <i class="flaticon2-search-1"></i>
                    Busca  Propiedad
                </a>-->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <br>
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                        <?php if ($viviendaQ) { ?>
                <?php include_partial('caja/lista', array('em'=>$em, 'Propietarios'=>$Propietarios, 'grandTotal'=>$grandTotal, 'cuenta' => $cuenta,'vivienda'=>$vivienda)) ?> 
                        <?php } ?>
            </div>
            <div class="col-lg-4">
                <?php include_partial('caja/pago' , array('Propietarios'=>$Propietarios,'form'=>$form,  'listaPago'=>$listaPago, 'grandTotal'=>$grandTotal, 'cuenta' => $cuenta,'vivienda'=>$vivienda) ) ?> 
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<div class="modal fade" id="ajaxmodal" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 750px">
        <div class="modal-content" style=" width: 750px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <h4 class="modal-title" id="myModalLabel6">Agrega Servicio</h4>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxmodalv" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 750px">
        <div class="modal-content" style=" width: 750px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <h4 class="modal-title" id="myModalLabel6">Busqueda Propiedad</h4>
            </div>
        </div>
    </div>
</div>

<!--<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>-->
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


  <script type="text/javascript">
        $(document).ready(function () {
            $("#factura").on('change', function () {
                var id = $("#factura").val();
                var vivi =<?php echo $vivienda; ?> 
                $.get('<?php echo url_for("caja/factura") ?>', {id: id, vivi: vivi}, function (response) {
               $("#detalleFactura").html(response);
                });
            });
        });
    </script>
     <script type="text/javascript">
        $(document).ready(function () {
            $("#factura").on('change', function () {
                var id = $("#factura").val();
                var vivi =<?php echo $vivienda; ?> 
                $.get('<?php echo url_for("caja/Nitfactura") ?>', {id: id, vivi: vivi}, function (response) {
               $("#nit_factura").val(response);
                });
            });
        });
    </script>
    
    
    
      <script type="text/javascript">
        $(document).ready(function () {
            $("#factura").on('change', function () {
                var id = $("#factura").val();
                var vivi =<?php echo $vivienda; ?> 
                $.get('<?php echo url_for("caja/Nombrefactura") ?>', {id: id, vivi: vivi}, function (response) {
               $("#nom_factura").val(response);
                });
            });
        });
    </script>
    
    
      <script type="text/javascript">
        $(document).ready(function () {
            $("#nit_factura").on('change', function () {
                var id = $("#nit_factura").val();
                var vivi =<?php echo $vivienda; ?> 
                $.get('<?php echo url_for("caja/grabaNit") ?>', {id: id, vivi: vivi}, function (response) {
             
                });
            });
        });
    </script>
    
    
    
          <script type="text/javascript">
        $(document).ready(function () {
            $("#nom_factura").on('change', function () {
                var id = $("#nom_factura").val();
                var vivi =<?php echo $vivienda; ?> 
                $.get('<?php echo url_for("caja/grabaNombre") ?>', {id: id, vivi: vivi}, function (response) {
            
                });
            });
        });
    </script>