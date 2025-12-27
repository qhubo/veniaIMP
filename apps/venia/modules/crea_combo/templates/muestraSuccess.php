<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-layers kt-font-brand"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success">
                <?php if ($combo) { ?>
                    EDITAR COMBO <?php echo $combo->getCodigoSku() ?> <small> <?php echo $combo->getNombre() ?> &nbsp;&nbsp;&nbsp;&nbsp;</small>
                <?php } else { ?>
                    NUEVO COMBO      
                <?Php } ?>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
        </div>
    </div>
    
        <?php if (($estatus=='Autorizado') or ($estatus=='Rechazado')) { ?>
    <div class="kt-section">
        <div class="kt-section__content">
            <?php if ($estatus=='Autorizado') { ?>
            <div class="alert alert-info" role="alert">
                <div class="alert-text">COMBO AUTORIZADO</div>
            </div>
            <?php } ?>
           <?php if ($estatus=='Rechazado') { ?>
            <div class="alert alert-danger" role="alert">
                <div class="alert-text">COMBO RECHAZADO</div>
            </div>
           <?php } ?>
        </div>
    </div>
    <?php } ?>

    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_portlet_base_demo_2_3_tab_content" role="tab" aria-selected="false">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Informativo
                        </a>
                    </li>
                    <?php if ($id) { ?>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_portlet_base_demo_2_2_tab_content" role="tab" aria-selected="false">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>Productos
                                <span class="kt-badge kt-badge--success"><?php echo count($campos) ?></span>
                            </a>
                        </li>
                    <?php } ?>

                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-lg-10">
                    <div class="tab-content">
                        <div class="tab-pane <?php if ($tab == 1) { ?> active <?php } ?> " id="kt_portlet_base_demo_2_3_tab_content" role="tabpanel">
                            <div class="row">
                                <?php if ($combo) { ?>
                                    <?php if ($combo->getImagen()) { ?>
                                        <div class="col-lg-2"> 
                                            <img src="<?php echo $combo->getImagen() ?>"  width="150px">
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <div class="col-lg-10">  
                                    <?php include_partial($modulo . '/ficha', array('modulo' => $modulo, 'id' => $id, 'combo' => $combo, 'form' => $form)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane <?php if ($tab == 2) { ?> active <?php } ?>" id="kt_portlet_base_demo_2_2_tab_content" role="tabpanel">
                            <?php include_partial($modulo . '/detalle', array(  
                                'costo'=>$costo,
                                'unidad'=>$unidad,
                                'costo_unidad'=>$costo_unidad,
                                              'costo2'=>$costo2,
                                'unidad2'=>$unidad2,
                                'costo_unidad2'=>$costo_unidad2,
                                'campos' => $campos, 'combo' => $combo, 'id' => $id, 'val' => $val, 'modulo' => $modulo, 'forma' => $forma)) ?>
                        </div>

                    </div>      


                </div>
                <div class="col-lg-2">
                    <?php if ($combo) { ?>
                      <?php if (($combo->getEstatus() == 'Pendiente')   or ($combo->getEstatus() == 'Confirmado'))  { ?>
                     
                            <br><br><br><br>
                            <button type="button" class="btn btn-bold btn-label-brand btn-sm" data-toggle="modal" data-target="#kt_modal_1"> <i class="flaticon-lock"></i> CONFIRMACIÓN </button>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>


</div>

<?php if ($combo) { ?>
<?PHp $toke = sha1($combo->getCodigoSku()); ?>
<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CONFIRMAR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <p>Al confirmar <strong>EL COMBO</strong> no podra ser modificado , este  sera enviaro a un proceso de autorización para
                    para poder ser publicado. (unicamente se podra modificar los precios)
               </p>
            </div>
            <div class="modal-footer">
           <button type="button" data-dismiss="modal"  class="btn btn-secondary btn-dark">Cancelar</button>
           <a class="btn btn-bold btn-label-brand btn-sm flaticon-lock"  href="<?php echo url_for($modulo . '/confirmar?id=' . $combo->getId()."&tok=".$toke) ?>" ><li class="fa fa-picture-o"></li> Confirmar&nbsp;&nbsp;&nbsp;&nbsp;</a>  
            </div>
        </div>
    </div>
</div>
<?php } ?>