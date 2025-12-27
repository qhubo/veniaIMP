<?php $modulo = $sf_params->get("module"); ?>
<?php //include_partial("soporte/avisos");      ?>


<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Asignación de Accesos Perfil 
                <small>&nbsp;&nbsp;&nbsp; Dale check  a los accesos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </small> </h3>
        </div>
        <div class="kt-portlet__head-toolbar">

            <div class="inputs">           
                <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

            </div>
        </div>

    </div>


    <div class="kt-portlet__body">
        <h3>
            <b>Perfil <?php echo $perfil->getDescripcion() ?> </b>
        </h3>

        <?php echo $form->renderFormTag(url_for("perfil/accesos?id=" . $id), array("class" => "form",)); ?>
        <?php echo $form->renderHiddenFields() ?>  
        <?php foreach ($superiores as $registroSUP) : ?>

            <div class="row">
                <div class="col-lg-2">
                    <span class="primary-info">    <strong>      <?php echo $registroSUP->getDescripcion() ?>  </strong>
                    </span>
                </div>
                <div class="col-lg-9">
                    <?php
                    $menus = MenuSeguridadQuery::create()
                            ->orderByOrden()
                            ->filterBySubMenu(false)
                            ->filterBySuperior($registroSUP->getId())
                            ->find();
                    ?>
                    <?php $contador = 0 ?>
                    <?php foreach ($menus as $registro) { ?>
                        <?php $contador++ ?>
                        <?php if ($contador == 1) { ?>
                            <div class="row">
                                <div class="col-lg-2"> </div>
                                <div class="col-lg-4">   <span class="primary-info">    <strong>      <?php echo $registroSUP->getDescripcion() ?>  </strong>
                                    </span>
                                </div>
                            </div>
                        <?php } ?>


                        <div class="row">
                            <div class="col-lg-4">  <?php echo $registro->getDescripcion() ?>   </div>
                            <div class="col-lg-4">
                                <?php echo $form['menu_' . $registro->getId()] ?>      
                                <label for="consulta_menu_<?php echo $registro->getId() ?>"><span></span></label>
                            </div>
                        </div>
                    <?php } ?>


                    <?php
                    $submenus = MenuSeguridadQuery::create()
                            ->filterByModulo('')
                            ->filterBySubMenu(true)
                            ->orderByOrden("Asc")
                            ->filterBySuperior($registroSUP->getId())
                            ->find();
                    ?>
                    <?php foreach ($submenus as $sub) { ?>
                        <div class="row">

                            <div class="col-lg-4"><strong> <?php echo $sub->getDescripcion(); ?></strong></div>
                        </div>
                        <?php $hijos2 = MenuSeguridadQuery::create()->filterBySubMenu(false)->orderByOrden("Asc")->filterBySuperior($sub->getId())->find(); ?>
                        <?php foreach ($hijos2 as $registro) : ?> 

                            <div class="row">
                                <div class="col-lg-4">  <?php echo $registro->getDescripcion() ?>   </div>
                                <div class="col-lg-4">
                                    <?php echo $form['menu_' . $registro->getId()] ?>      
                                    <label for="consulta_menu_<?php echo $registro->getId() ?>"><span></span></label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php } ?>
                </div>
            </div>
        

                            <div class="row">
                                <div class="col-lg-8"> <hr></div>
                            </div>
                 
        <?php endforeach; ?>
        
        <hr/>

        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-2">
                <button class="btn btn-primary btn-icon-primary btn-icon-block btn-icon-blockleft" type="submit">
                    <i class="fa fa-save"></i>
                    Guardar
                </button>
            </div>
            <div class="col-lg-1">

            </div>
            <div class="col-lg-2">
                <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>
            </div>
        </div>
        <?php echo '</form>'; ?>
    </div>
</div>