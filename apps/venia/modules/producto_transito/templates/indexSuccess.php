<?php $modulo = $sf_params->get('module'); ?>


<script src='/assets/global/plugins/jquery.min.js'></script>
<script src='/assets/global/plugins/select2.min.js'></script>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-add-label-button kt-font-warning"></i>

                <h3 class="kt-portlet__head-title kt-font-info">
                    PRODUCTOS EN TRANSITO <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </small>
                </h3>
        </div>
        <div class="kt-portlet__head-toolbar">      
        
           
        </div>
    </div>
    <div class="kt-portlet__body">
        <?php $modulo = $sf_params->get('module'); ?>
                <?php $modulo = $sf_params->get('module'); ?>
        <form action="<?php echo url_for($modulo . '/index') ?>" method="get">
            <div class="row"  style="padding-bottom:10px;">
                <div class="col-lg-2">Vendedor</div>
                <div class="col-lg-5">
                    <select  onchange="this.form.submit()" class="form-control mi-selector"  name="prover" id="prover">
                        <option value="0">[    Todos    ]</option>
                        <?php foreach ($seleccion as $key => $value) { ?>
                            <option <?php if ($prover == $key) { ?> selected="selected"  <?php } ?>  value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <a target="_blank" href="<?php echo url_for($modulo . '/reporte?prover=' . $prover) ?>" class="btn  btn-sm  " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
                </div>

            </div>
        </form>

        
        <div class="row">
            <div class="col-lg-10"></div>
            <div class="col-lg-2">				
                <div class="kt-input-icon kt-input-icon--left">
                    <input type="text" class="form-control" placeholder="Buscar..." id="generalSearch">
                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                        <span><i class="la la-search"></i></span>
                    </span>
                </div>
            </div>
        </div>

        <table class="kt-datatable  table table-bordered  dataTable table-condensed flip-content" id="html_table" width="100%" >
       
            <thead >
                <tr class="active">
                    <th  align="center"> Fecha</th>
                    <th  align="center">Pedido </th>
  
                    <th  align="center">Codigo </th>
                    <th  align="center">Producto </th>
                   
                    <th  align="center"> Cantidad </th>
                    <th  align="center">Retornar  </th>
                     <th  align="center">Ubicacion </th>                  
                    <th  align="center">Vendedor </th>
                         <th  align="center"># </th>
                                      
                </tr>
            </thead>
            <tbody>
                
                
                <?php foreach ($productos as $regis) { ?>
               <?php if ($regis->getOrdenVendedorId()) { ?>
               <?php if ($regis->getProductoId()) { ?>
                    <tr>
                        <td><?php //echo $regis->getOrdenVendedor()->getFecha(); ?></td>
                        <td><?php echo "PEDIDO " . $regis->getOrdenVendedorId(); ?></td>
                   
                        <td><?php echo $regis->getProducto()->getCodigoSku(); ?></td>
                        <td><?php echo $regis->getProducto()->getNombre(); ?></td>
                    
                        <td style="text-align: right;"><?php echo $regis->getCantidad(); ?></td>
                        <td>

                              <a class="btn  btn-info btn-sm  "   href="#"  data-toggle="modal" data-target="#ajaxmodalC<?php echo $regis->getId() ?>">
                                        <i class="fa fa-refresh"> </i> Retornar
                                    </a>

                        </td>
                            <td><?php echo $regis->getUbicacionId(); ?></td>
                                 <td><?php echo $regis->getOrdenVendedor()->getVendedor()->getNombre(); ?></td>
                                  <td><?php echo $regis->getOrdenVendedorId(); ?></td>
                    </tr>
                <?php } ?>
                           <?php } ?>
                     <?php } ?>
            </tbody>
        </table>

    </div>
</div>

<?php foreach ($productos as $regis) { ?>
    <form action="<?php echo url_for($modulo . '/modificarP') ?>" method="get">
              <input type="hidden" value="<?php echo $regis->getId(); ?>"  id="id" name="id">
 <div class="modal fade" id="ajaxmodalC<?php echo $regis->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 550px">
            <div class="modal-content" style=" width: 550px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                    <h4 class="modal-title" id="myModalLabel6">Retornar Producto Inventario </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding-top:10px">
                        <div class="col-lg-2 kt-font-info " style="font-weight:bold;">Codigo</div>
                        <div class="col-lg-8"><?php echo $regis->getProducto()->getCodigoSku(); ?> </div>
                    </div>
                    <div class="row" style="padding-top:10px">
                        <div class="col-lg-2 kt-font-info " style="font-weight:bold;">Producto</div>
                        <div class="col-lg-8" style="font-weight:bold;"><?php echo $regis->getProducto()->getNombre(); ?> </div>
                    </div>
                         <div class="row"  style="padding-top:10px">
                       <div class="col-lg-4 kt-font-info"  style="font-weight:bold;">Cantidad Transito</div>
                        <div class="col-lg-4"><?php echo $regis->getCantidad(); ?> </div>
                    </div>
                    
                        <div class="row"  style="padding-top:10px">
                       <div class="col-lg-4 kt-font-info"  style="font-weight:bold;">Cantidad Retornar</div>
                        <div class="col-lg-4">
                        <input class="form-control cantidad" value="" type="number" max="<?php echo $regis->getCantidad(); ?>" min="1" name="cantidad" id="cantidad">
                        </div>
                    </div>
                </div> 
                <div class="modal-footer">
                        <button class="btn btn-primary " type="submit">
                    <i class="fa fa-save "></i> Aceptar  
                </button>
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
<?php } ?>




       <script>
    const inputs = document.querySelectorAll('.cantidad');

    inputs.forEach(input => {
      input.addEventListener('input', () => {
        const max = Number(input.getAttribute('max'));
        const min = Number(input.getAttribute('min'));
        let valor = Number(input.value);

        if (valor > max) {
          input.value = max; // Forzar el valor máximo
        } else if (valor < min) {
          input.value = min; // Evitar valores negativos
        }
      });
    });
  </script>
  
  <script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.mi-selector').select2();
        });
    });
</script>
