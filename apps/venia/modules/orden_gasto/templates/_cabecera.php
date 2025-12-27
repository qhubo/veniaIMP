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
    <div class="col-lg-1" ><div style="text-align:right">Proyecto</div> </div>
    <div class="col-lg-3 <?php if ($form['proyecto_id']->hasError()) echo "has-error" ?>">
        <?php if ($orden) { ?>    <?php echo $form['proyecto_id'] ?> <?php } ?>          
        <span class="help-block form-error"> 
            <?php echo $form['proyecto_id']->renderError() ?>  
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

    <div class="col-lg-2 <?php if ($form['tipo_documento']->hasError()) echo "has-error" ?>">
        <?php if ($orden) { ?>      <?php echo $form['tipo_documento'] ?>    <?php } ?>        
        <span class="help-block form-error"> 
            <?php echo $form['tipo_documento']->renderError() ?>  
        </span>
    </div>

    <div class="col-lg-1" ><div style="text-align:right">Documento </div> </div>

    <div class="col-lg-2 <?php if ($form['documento']->hasError()) echo "has-error" ?>">
        <?php if ($orden) { ?>      <?php echo $form['documento'] ?>    <?php } ?>        
        <span class="help-block form-error"> 
            <?php echo $form['documento']->renderError() ?>  
        </span>
    </div>


    <div class="col-lg-2 ">Dias Crédito</div>
    <div class="col-lg-2 <?php if ($form['dia_credito']->hasError()) echo "has-error" ?>">
      <?php if ($orden) { ?>   <?php echo $form['dia_credito'] ?>     <?php } ?>       
        <span class="help-block form-error"> 
            <?php echo $form['dia_credito']->renderError() ?>  
        </span>
    </div>
    
    <div class="col-lg-1" > </div>
    
    
  
</div>


<div class="row">
<div class="col-lg-2"><div style="text-align:right">Tienda</div> </div>
    <div class="col-lg-2">      <?php if ($orden) { ?>      <?php echo $form['tienda_id'] ?>    <?php } ?> </div>
  
       <div class="col-lg-2">
           <div style="text-align:right">Aplica IVA&nbsp;<?php if ($orden) { ?> <?php echo $form['aplica_iva'] ?>  <?php } ?> 
               <BR>Retiene IVA&nbsp;&nbsp;<?php if ($orden) { ?><?php echo $form['aplica_isr'] ?>  <?php } ?>
               
               <BR>Exento ISR&nbsp;&nbsp;<?php if ($orden) { ?><?php echo $form['exento_isr'] ?>  <?php } ?>
<!--           <BR>Retiene IVA&nbsp;&nbsp;
               -->
               <?php if ($orden) { ?><?php //echo $form['retiene_iva'] ?>  <?php } ?>
           
           </div> 
       
       </div>
 
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





