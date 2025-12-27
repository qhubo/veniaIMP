<script src='/assets/global/plugins/jquery.min.js'></script>
<?php echo $form->renderFormTag(url_for($modulo . '/index'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-spinner font-purple-plum"></i>
            <span class="caption-subject bold font-purple-plum uppercase"> Buscador de Productos </span>
            <span class="caption-helper">&nbsp;&nbsp;&nbsp; puedes filtrar tu busqueda&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                 <div class="portlet-input input-inline input-small">
                <div class="input-icon right">
                    <i class="icon-magnifier"></i>
                    <?php echo $form['nombrebuscar'] ?> 
                </div>
            </div>
        </div>
        <div class="inputs">
       
        </div>
    </div>
    <div class="portlet-body">

        <div class="form-body">

            <div class="row">
                <div class="col-md-1"> </div>        
                <label class="col-md-1 control-label right ">Estatus </label>
                <div class="col-md-4 <?php if ($form['estatus']->hasError()) echo "has-error" ?>">
                    <?php echo $form['estatus'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['estatus']->renderError() ?>  
                    </span>



                    <!--                    <a class="btn red btn-outline sbold" data-toggle="modal" href="#basic"> View Demo </a>-->
                </div>


            </div>

            <div class="row">
                <div class="col-md-1"> </div>        
                <label class="col-md-1 control-label right "><?php echo TipoAparatoQuery::tipo(); ?>  </label>
                <div class="col-md-4 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                    <?php echo $form['tipo'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['tipo']->renderError() ?>  
                    </span>
                </div>

                <div class="col-md-4">
                    <font color="#9eacb4" size="2px">   No Productos Total&nbsp;&nbsp;<strong> <?php echo $total ?> </strong> </font>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1"> </div>        
                <label class="col-md-1 control-label right "><?php echo TipoAparatoQuery::marca(); ?>  </label>
                <div class="col-md-4 <?php if ($form['marca']->hasError()) echo "has-error" ?>">
                    <?php echo $form['marca'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['marca']->renderError() ?>  
                    </span>
                </div>


                <div class="col-md-3">
                    <font color="#9eacb4" size="2px">   No Productos Busqueda&nbsp;&nbsp;<strong> <?php echo $totalB ?></strong> </font>
                </div>


            </div>

   
        <div class="row">
            <div class="col-md-1"> </div>        
            <label class="col-md-1 control-label right "><?php echo TipoAparatoQuery::modelo(); ?>  </label>
            <div class="col-md-4 <?php if ($form['modelo']->hasError()) echo "has-error" ?>">
                <?php echo $form['modelo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['modelo']->renderError() ?>  
                </span>
            </div>
            <div class="col-md-1">


            </div>
            <div class="col-md-1">

                <button class="btn green btn-outline" type="submit">
                    <i class="fa fa-search "></i>
                    <span>Buscar</span>
                </button>
            </div>
        </div>
                 </div>
    </div>
</div>

<?php echo '</form>'; ?>