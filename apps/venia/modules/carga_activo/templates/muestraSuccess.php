
<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Carga de Activos <small>Confirma la información presentada</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
        </div>
    </div>
    <div class="kt-portlet__body">




        <div class="row"  style="padding-top:10px;">
            <table class="table table-bordered  dataTable table-condensed flip-content" >
                <thead class="flip-content">
                    <tr class="active">
                        <th align="center" ><font size="-1">CODIGO&nbsp;</font></th>
                        <th align="center" ><font size="-1">ACCOUNT</font></th>
                        <th align="center" ><font size="-1">DESCRIPTION</font></th>
                        <th align="center" ><font size="-1">ENDING DATE</font></th>
                        <th align="center" ><font size="-1">LIFE YEARS</font></th>
                        <th align="center" ><font size="-1">ADQUISITION EDDING</font></th>
                        <th align="center" ><font size="-1"> BOOK VALUE</font></th>
                        <th align="center" ><font size="-1">% </font></th>
                        <th align="center" ><font size="-1">NOMBRE CUENTA </font></th>
                    </tr>
                </thead>
                <?php $total=0; ?>
                
                <?php $conta=0; ?>
                <?php foreach ($datos as $data) { ?>
                <?php $conta++; ?>
                
                <?php $total=$data['BOOK'] + $total; ?>
                    <tbody>
                        <tr <?php if ($data['ACUALIZADO'] >0) { ?> style="background-color: #ffffdf"  <?php } ?> >
                            <td>
                                
                                <?php if ($data['ID']) { ?>
                                           <a href="<?php echo url_for($modulo."/vista?id=" . $data['CODIGO']) ?>" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodal<?php echo $conta; ?>">
                <?php echo $data['CODIGO']; ?>
                        </a>
                                <?php } else  { ?>
                                
                                 <?php echo $data['CODIGO']; ?>
                                <?php } ?>
                            </td>
                            <td><?php echo $data['ACCOUNT']; ?></td>
                            <td><?php echo $data['DESCRIPTION']; ?></td>
                            <td><?php echo $data['ADQUISITION']; ?></td>
                            <td style="text-align: right"><?php echo $data['LIFE']; ?></td>
                            <td><?php echo $data['ADQUISITIONvENCE']; ?></td>
                            <td  style="text-align: right"><?php echo Parametro::formato($data['BOOK'],true); ?></td>
                            <td style="text-align: right" ><?php echo $data['POR']; ?> <strong>%</strong> </td>
                            <td><?php echo $data['NOMBRE_CUENTA']; ?> <?php //echo $data['ID']; ?></td>
                        </tr>
                    </tbody>

                <?php } ?>


            </table>
        </div>
        
            <div class="row">
                <div class="col-md-10"></div>
                               <div class="col-md-2">
                     <a data-toggle="modal" href="#staticCONFIRMA" class="btn btn-secondary btn-success  btn-block" > <i class="fa fa-lock"></i> Confirmar</a>
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

<div id="staticCONFIRMA" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <li class="fa fa-cogs"></li>
                <span class="caption-subject bold font-yellow-casablanca uppercase"> Confirmar Ingresos</span>
            </div>
            <div class="modal-body">
                <p> Esta seguro confirma el listado activos  <?php echo Parametro::formato($total,true); ?>
                    <span class="caption-subject font-green bold uppercase"> 
                        <?php //echo $lista->getUsuario() ?>
                    </span> ?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                <a class="btn  btn green " href="<?php echo url_for($modulo . '/confirmar?id='.$id) ?>" >
                    <i class="fa fa-trash-o "></i> Confirmar</a> 
            </div>
        </div>
    </div>
</div> 


<?php $conta = 0; ?>
  <?php foreach ($datos as $data) { ?>
    <?php $conta++; ?>
   
    <div class="modal fade"  id="ajaxmodal<?php echo $conta; ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle Activo  <?php echo $data['CODIGO']; ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
<?php } ?>







<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  