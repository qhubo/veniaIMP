<?php $modulo = 'orden_gasto'; ?>
<?php $i = 1; ?>
<?php $estiloDos = ''; ?>
<?php $estiloUno = 'style="display:none;"'; ?>


<div class="row"  style="background-color:#F9FBFE; padding: 10px">
    <div class="col-lg-2" ><div style="text-align:right">Proveedor </div> </div>

    <div class="col-lg-3 <?php if ($form['proveedor_id']->hasError()) echo "has-error" ?>">
        <?php if ($orden) { ?>      <?php echo $form['proveedor_id'] ?>    <?php } ?>        
        <span class="help-block form-error"> 
            <?php echo $form['proveedor_id']->renderError() ?>  
        </span>
    </div>
    <div class="col-lg-1" ><div style="text-align:right">Tienda</div> </div>
    <div class="col-lg-3 <?php if ($form['tienda_id']->hasError()) echo "has-error" ?>">
        <?php if ($orden) { ?>    <?php echo $form['tienda_id'] ?> <?php } ?>          
        <span class="help-block form-error"> 
            <?php echo $form['tienda_id']->renderError() ?>  
        </span>
    </div>

    <div class="col-lg-1" ><div style="text-align:right">Fecha </div> </div>

    <div class="col-lg-2 <?php if ($form['fecha_documento']->hasError()) echo "has-error" ?>">
        <?php if ($orden) { ?>      <?php echo $form['fecha_documento'] ?>     <?php } ?>      
        <span class="help-block form-error"> 
            <?php echo $form['fecha_documento']->renderError() ?>  
        </span>
    </div>
</div>

<div class="row">
   <div class="col-lg-2" ><div style="text-align:right">Tipo Documento </div> </div>

    <div class="col-lg-3 <?php if ($form['tipo_documento']->hasError()) echo "has-error" ?>">
        <?php if ($orden) { ?>      <?php echo $form['tipo_documento'] ?>    <?php } ?>        
        <span class="help-block form-error"> 
            <?php echo $form['tipo_documento']->renderError() ?>  
        </span>
    </div>



    <div class="col-lg-2 " style="text-align:right !important;">Dias Crédito</div>
    <div class="col-lg-2 <?php if ($form['dia_credito']->hasError()) echo "has-error" ?>">
      <?php if ($orden) { ?>   <?php echo $form['dia_credito'] ?>     <?php } ?>       
        <span class="help-block form-error"> 
            <?php echo $form['dia_credito']->renderError() ?>  
        </span>
    </div>
</div>
<div class="row">
     <div class="col-lg-2" ><div style="text-align:right">Documento (CUFE) </div> </div>

    <div class="col-lg-9 <?php if ($form['documento']->hasError()) echo "has-error" ?>">
        <?php if ($orden) { ?>      <?php echo $form['documento'] ?>    <?php } ?>        
        <span class="help-block form-error"> 
            <?php echo $form['documento']->renderError() ?>  
        </span>
    </div>

    </div>


<div class="row">
<div class="col-lg-7"> </div>

 
     <?php if (count($detalles) >0) { ?>
                <?php if ($id) { ?>
                <?php if (!$agrega) { ?>
                 <?php if (!$id_detalle) { ?> 
                    <div class="col-lg-2"> 
                        <br>
                        <button class="btn btn-primary btn-sm " type="submit">
                            <i class="fa fa-save "></i> Actualizar
                        </button>
                    </div>
                 <?php  } ?>
                <?php } ?>
                <?php } ?>
                <?php } ?>
</div>





