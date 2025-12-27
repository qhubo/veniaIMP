
<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>

<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-zig-zag-line-sign kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
               ASIGNADOS   PRODUCTOS <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Listado de los productos asignados a vendedor
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-lg-8"></div>
            <div class="col-lg-4"> 
                            <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link   active" data-toggle="tab" href="#kt_portlet_base_2_3_tab_content" role="tab" aria-selected="false">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Ingreso
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link "  href="<?php echo url_for($modulo . '/historial') ?>" role="tab" aria-selected="false">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>Historial
                </a>
            </li>
        </ul>

            </div>            
        </div>
        <?php if (count($confirmados) >0) { ?>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-6">
                <table class="table  table-bordered " width="100%">
        <tr>
            <th  align="center"># </th>
            <th  align="center"> Fecha</th>
            <th  align="center">Vendedor</th>
            <th  align="center">Estado</span></th>
            <th></th>
        </tr>
        <?php foreach($confirmados as $confi) { ?>
        <tr>
            <td><?php echo $confi->getId(); ?></td>
            <td><?php echo $confi->getFecha('d/m/Y'); ?></td>
            <td><?php echo $confi->getVendedor()->getNombre(); ?></td>
            <td><?php echo $confi->getEstado(); ?></td>
                                 <td><a class="btn  btn-sm btn-info" data-toggle="modal" href="#static<?php echo $confi->getId() ?>"><i class="flaticon2-check-mark"></i>CONFIRMAR</a></td>               
        </tr>
        <?php } ?>
                </table>             
            </div>
        </div>
        <?php } ?>
        
        
        
        
        <form action="<?php echo url_for($modulo . '/index') ?>" method="get">
            <div class='row' style="padding-bottom:5px;">
                <div class="col-lg-2" style="text-align: right; font-weight: bold;">Seleccione Vendedor</div>
                <div class="col-lg-6">
                    <select  onchange="this.form.submit()" class="form-control"  name="movi" id="movi">
                        <option value="" >Seleccione </option>
                        <?php foreach ($registros as $data) { ?>
                            <option <?php if ($movi == $data->getId()) { ?> selected="selected"  <?php } ?>   value="<?php echo $data->getId(); ?>"><?php echo $data->getNombre(); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class='row' style="padding-bottom:5px;">
                 <div class="col-lg-2" style="text-align: right; font-weight: bold;">Obsevaciones</div>
                 <div class="col-lg-6">
                     <textarea <?php if (!$movi) { ?> disabled="" <?php } ?> name="consulta[det_]" id="consulta_det_"  name="textarea" rows="2" class="form-control" ><?php if ($orden) { ?><?php echo $orden->getObservaciones(); ?> <?php } ?></textarea>
                 </div>
            </div>
  
                  
            
        </form>
        
         <div class="row">
             <div class="col-lg-12"><hr></div>
         </div>
        <?php if ($movi) { ?> 
        <div class="row">
            <div class="col-lg-4" style="background-color:#D7EBF5;">
                <h3>Buscador</h3>

   <?php  include_partial('busca/ordenVendedor', array('movi'=>$movi)) ?>  
            </div>
            <div class="col-lg-8">
                <h3>Listado de Producto</h3>
            <?php include_partial($modulo . '/lista', array('id'=>$movi,'listado'=>$listado)) ?>      
            </div>
        </div>
        <?php } ?>
        <?php if (count($listado) >0) { ?>
        <div class="row" style="background-image: url(./assets/media/bg/bg-6.jpg);">
    <div class="col-lg-5"></div>
      <div class="col-lg-2">

    </div>
    <div class="col-lg-3" style="text-align: right"><font color="white"><br>  Confirmar pedido </font></div>
    <div class="col-lg-2">`
          <a href="<?php echo url_for($modulo . '/confirmar?id='.$orden->getId())."&token=" ?>" class="btn btn-small btn-success btn-block" > <i class="flaticon-black"></i><br> Enviar </a>
    </div>
     <div class="col-lg-1">
</div>
     </div>
        <?php } ?>
    </div>
</div>


<script src='/assets/global/plugins/jquery.min.js'></script>

<?php if ($orden) { ?>
  <script type="text/javascript">
        $(document).ready(function () {
            $("#consulta_det_").on('change', function () {
                var id = $("#consulta_det_").val();
                var idv = <?php echo $orden->getId() ?>;
                   $.get('<?php echo url_for($modulo . "/detalleCabecera") ?>', {id: id, idv: idv}, function (response) {
                });
            });
        });
    </script>
`<?php } ?>

  <?php foreach($confirmados as $confi) { ?>
  <div id="static<?php echo $confi->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p> 
                        <strong>Vendedor</strong>
                        <span class="caption-subject font-green bold uppercase"> 
                            <?php echo $confi->getVendedor()->getNombre() ?>
                        </span> 
                    </p>

                    <p> Confirma Procesar Documento
                        <strong>Pedido</strong>
                        <span class="caption-subject font-green bold uppercase"> 
                            <?php echo $confi->getId() ?>
                        </span> ?
                    </p>
                </div>

                <div class="modal-footer">
                    <a class="btn  btn-success " href="<?php echo url_for($modulo.'/confirmarpedi?id=' . $confi->getId()  . "&token=" . sha1($confi->getId() )) ?>" >
                        <i class="flaticon2-lock "></i> Confirmar </a> 
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                </div>

            </div>
        </div>
    </div> 


  <?php } ?>
