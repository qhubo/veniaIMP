<div class="row" style="padding-bottom:10px;">
    <div class="col-lg-1"> </div>
    <div class="col-lg-3">Tipo </div>
    <div class="col-lg-5 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
        <?php echo $form['tipo'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['tipo']->renderError() ?>  
        </span>
    </div>
</div>

<div class="row "  style="padding-bottom:10px;">
    <div class="col-lg-1"> </div>
    <div class="col-lg-3" style="display: none;"  id="valbanco">Banco </div>
    <div  id="valbanco1" style="display: none;" class="col-lg-5 <?php if ($form['banco_id']->hasError()) echo "has-error" ?>">
        <?php echo $form['banco_id'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['banco_id']->renderError() ?>  
        </span>
    </div>
</div>



<div class="row "   >
    <div class="col-lg-1"> </div>
    <div  id="valfecha" class="col-lg-3">Fecha Inicio</div>
    <div  id="valfecha1" class="col-lg-5 <?php if ($form['fecha_inicio']->hasError()) echo "has-error" ?>">
        <?php echo $form['fecha_inicio'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['fecha_inicio']->renderError() ?>  
        </span>
    </div>
</div>

<div class="row" style="padding-bottom:10px;">
    <div class="col-lg-1"> </div>
    <div class="col-lg-3">Fecha </div>
    <div class="col-lg-5 <?php if ($form['fecha']->hasError()) echo "has-error" ?>">
        <?php echo $form['fecha'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['fecha']->renderError() ?>  
        </span>
    </div>
    <div class="col-lg-2">

        <div id="valdia">
            <div style="float:left">
                <input class="form-control"  style="background-color:#F9FBFE ;" readonly="true" value="<?php echo $dias; ?>" name="vdia" id="vdia">
            </div>
            <div style="float:right">

                <strong>Dias </strong>

            </div>
        </div>
    </div>
</div>


<div class="row" style="padding-bottom:2px;">
    <div class="col-lg-1"> </div>
    <div class="col-lg-3">Valor <strong>$</strong> </div>
    <div class="col-lg-5 <?php if ($form['valor_dolares']->hasError()) echo "has-error" ?>">
<input class="form-control" step="any" type="number" placeholder="0.00" name="consulta[valor_dolares]" value="<?php echo $interes; ?>" id="consulta_valor_dolares" readonly="" style="background-color: rgb(249, 251, 254);">        
        <span class="help-block form-error"> 
            <?php echo $form['valor_dolares']->renderError() ?>  
        </span>
    </div>
</div>

<div class="row" style="padding-bottom:10px;">
    <div class="col-lg-1"> </div>
    <div class="col-lg-3">Valor <strong>Q</strong> </div>
    <div class="col-lg-5 <?php if ($form['valor_quetzales']->hasError()) echo "has-error" ?>">
<input class="form-control" step="any" type="number" placeholder="0.00" name="consulta[valor_quetzales]" value="<?php echo $quetzales; ?>" id="consulta_valor_quetzales" readonly="" style="background-color: rgb(249, 251, 254);"> 
        <?php //echo $form['valor_quetzales']; ?>
<span class="help-block form-error"> 
            <?php echo $form['valor_quetzales']->renderError() ?>  
        </span>
    </div>
</div>





<div class="row" style="padding-bottom:10px;">
    <div class="col-lg-1"> </div>
    <div class="col-lg-3">Comentario </div>
    <div class="col-lg-7 <?php if ($form['comentario']->hasError()) echo "has-error" ?>">
        <?php echo $form['comentario'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['comentario']->renderError() ?>  
        </span>
    </div>
</div>





