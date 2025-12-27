<?php $modulo = 'orden_compra'; ?>
<?php $i = 1; ?>
<?php $estiloDos = ''; ?>
<?php $estiloUno = 'style="display:none;"'; ?>



<?php echo $form->renderFormTag(url_for($modulo . '/index?id=' . $id), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>

<div class="row"  style="background-color:#F9FBFE; padding: 10px">
<?php $tex='Documento'; ?>
        <?php if ($orden) { ?>
    <?php if (strtoupper($orden->getEstatus())=="AUTORIZADO") { ?>
    <?php  $tex="FACTURA"; ?>
    <?php } ?>
        <?php } ?>
        <div class="col-lg-2" ><div style="text-align:right"><?php echo $tex; ?></div> </div>
    <?php if ($orden) { ?>
    <?php if (strtoupper($orden->getEstatus())=="AUTORIZADO") { ?>
        <div class="col-lg-1 <?php if ($form['serie']->hasError()) echo "has-error" ?>">
          <?php if ($orden) { ?>      <?php echo $form['serie'] ?>    <?php } ?>        
                <span class="help-block form-error"> 
                    <?php echo $form['serie']->renderError() ?>  
                </span>
            </div>
    <?php } ?>

    <?php } ?>
    <div class="col-lg-2 <?php if ($form['no_documento']->hasError()) echo "has-error" ?>">
            <?php if ($orden) { ?>    <?php echo $form['no_documento'] ?> <?php } ?>          
                <span class="help-block form-error"> 
                    <?php echo $form['no_documento']->renderError() ?>  
                </span>
            </div>
    <div class="col-lg-2" ><div style="text-align:right">Fecha/Documento</div> </div>
  
       <div class="col-lg-2 <?php if ($form['fecha_documento']->hasError()) echo "has-error" ?>">
          <?php if ($orden) { ?>      <?php echo $form['fecha_documento'] ?>     <?php } ?>      
                <span class="help-block form-error"> 
                    <?php echo $form['fecha_documento']->renderError() ?>  
                </span>
            </div>
    <?php if ($orden) { ?>
 <div class="col-lg-1"><div style="text-align:right"><strong> Tienda </strong> </div> </div>
    <div class="col-lg-2"><?php echo $form['tienda_id'] ?></div>
<!--        <div class="col-lg-2" ><div style="text-align:right">Fecha Contabilización</div> </div>
     <div class="col-lg-2 <?php if ($form['fecha_contabilizacion']->hasError()) echo "has-error" ?>">
             <?php if ($orden) { ?>   <?php echo $form['fecha_contabilizacion'] ?>  <?php } ?>          
                <span class="help-block form-error"> 
                    <?php echo $form['fecha_contabilizacion']->renderError() ?>  
                </span>
            </div>-->
    <?php } ?>
</div>
<?php //if (!$proveedor) { ?>

<?php if ($orden) { ?>

    <div class="row">
        <div class="col-lg-2"><div style="text-align:right"><strong> Proveedor </strong> </div> </div>
        <div class="col-lg-4" <?php if ($form['proveedor']->hasError()) echo "has-error" ?>>
            <select class="mi-selector  form-control" name="consulta[proveedor]" id="consulta_proveedor">
<option value="" selected="selected">[Seleccione Proveedor]</option>
<?php foreach ($proveedoresl as $datar) { ?>
<option <?php if ($provedorId==$datar->getId()) { ?> selected="selected" <?php } ?>  value="<?php echo $datar->getId(); ?>"><?php echo $datar->getNombre();  ?></option>
<?Php  } ?>
</select>
            <span class="help-block form-error"> 
                    <?php echo $form['proveedor']->renderError() ?>  
                </span>
            
<!--            <font color ="#9E3421"> <strong> Orden sin  proveedor asignado </strong> </font>-->
        
        </div>
        <div class="col-lg-2 " style="text-align:right">Dias Crédito</div>
       <div class="col-lg-2 <?php if ($form['dia_credito']->hasError()) echo "has-error" ?>">
                <?php echo $form['dia_credito'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['dia_credito']->renderError() ?>  
                </span>
            </div>
         <div class="col-lg-2"><div style="text-align:right">Aplica IVA&nbsp;<?php if ($orden) { ?> <?php echo $form['aplica_iva'] ?>  <?php } ?> 
                <BR>Retiene IVA&nbsp;&nbsp;<?php if ($orden) { ?><?php echo $form['aplica_isr'] ?>  <?php } ?>
               <BR>Exento ISR&nbsp;&nbsp;<?php if ($orden) { ?><?php echo $form['exento_isr'] ?>  <?php } ?>
           
             </div> </div>
    </div>
<?php } ?>
<?php // } ?>

<?php if ($proveedor) { ?>
    <div class="row">
        <div class="col-lg-3"><div style="text-align:right"><strong> Código Proveedor</strong></div> </div>
        <div class="col-lg-4"><?php echo $proveedor->getCodigo(); ?> </div>
<!--        <div class="col-lg-2 " style="text-align:right" >Dias Crédito</div>
       <div class="col-lg-1 <?php if ($form['dia_credito']->hasError()) echo "has-error" ?>">
                <?php //echo $form['dia_credito'] ?>           
                <span class="help-block form-error"> 
                    <?php //echo $form['dia_credito']->renderError() ?>  
                </span>
            </div>-->
      
        </div>
<?php } ?>

<?php if ($orden) { ?>
<div class="row" style="background-color:#F9FBFE " >
<!--    <div class="col-lg-1"> </div>-->
<!--    <div class="col-lg-1" ><div style="text-align:right">Nit</div> </div>
    <div class="col-lg-2 <?php if ($form['nit']->hasError()) echo "has-error" ?>">
        <input   class="form-control"  <?php if ($orden) { ?>  value="<?php echo $orden->getNit(); ?>"  <?php } ?> style="background-color:#F9FBFE ;"  placeholder="Nit"  name="consulta[nit]" id ="consulta_nit" readonly="true">
                <span class="help-block form-error"> 
                    <?php echo $form['nit']->renderError() ?>  
                </span>
     </div>-->
    
    
<!--    <div class="col-lg-1"><div style="text-align:right">Nombre</div> </div>
   <div class="col-lg-3 <?php if ($form['nombre']->hasError()) echo "has-error" ?>">
        <input   class="form-control"  <?php if ($orden) { ?>  value="<?php echo $orden->getNombre(); ?>"  <?php } ?> style="background-color:#F9FBFE ;"  placeholder="Nombre"  name="consulta[nombre]"  id ="consulta_nombre" readonly="true">
                <span class="help-block form-error"> 
                    <?php echo $form['nombre']->renderError() ?>  
                </span>
     </div>-->
<!--    <div class="col-lg-1">
<?php if ($id) { ?>
        <div class="row">
            <div class="col-lg-10">
                <div  id="btlista<?php echo $i ?>"  <?php echo $estiloUno ?> >
                    <a id="activar<?php echo $i ?>" vivi="1" dat="<?php echo $i ?>" class="btn btn-outline  "><img src="/images/UnCheck.png"> </a>     
                </div> 
                <div  id="bNtactiva<?php echo $i ?>" <?php echo $estiloDos ?>>
                    <a id="Nactivar<?php echo $i ?>"  vivi="1"  dat="<?php echo $i ?>" class="btn btn-outline  "><img src="/images/Check.png"></a> 
                </div> 
            </div>
        </div>
<?php } ?>
    </div>-->
   
       
    
        <div class="col-lg-2" >  <div style="text-align:right"> Observaciones</div> </div>
       <div class="col-lg-6 <?php if ($form['observaciones']->hasError()) echo "has-error" ?>">
                <?php echo $form['observaciones'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['observaciones']->renderError() ?>  
                </span>
            </div>
    <?php if ($orden) { ?>
     <?php  if ($orden->getEstatus() =="Autorizado") {  ?>
    <div class="col-lg-4">
     <img  src="/images/autorizado.png" width="300px" >
        
    </div>
     <?php } ?>
    <?php } ?>
        <div class="col-lg-2"> </div>
    
             <?php if ($id) { ?>
     <div class="col-lg-2"> 
        <br>
                <button class="btn btn-primary btn-sm " type="submit">
                    <i class="fa fa-save "></i> Actualizar
                </button>
            </div>
     <?php } ?>   
</div>

<?php } ?>

<div class="row" <?php if (!$id) { ?>  style="background-color:#F9FBFE " <?php } ?> >



</div>



<?php echo '</form>'; ?>


<?php $i = 1; ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#activar<?php echo $i ?>').click(function () {
            var valorId = $(this).attr('dat');
            var vivi = $(this).attr('vivi');
//            $.ajax({
//                type: 'GET',
//                url: '/index.php/caja/check',
//                data: {'id': valorId, 'vivi': vivi},
//                success: function (data) {
//                    $('#totalv').html(data);
//                }
//            });
            $('#activar0').hide();
            $('#lin<?php echo $i ?>').css('background', '#D7ECEA');
            $("#consulta_nombre").css("background-color", "#F9FBFE");
            $("#consulta_nit").css("background-color", "#F9FBFE");
            $('#consulta_nit').attr('readonly', 'true');
            $('#consulta_nombre').attr('readonly', 'true');
            $('#bNtactiva<?php echo $i ?>').slideToggle(250);
            $('#btactiva<?php echo $i ?>').hide();
            $('#bNtlista<?php echo $i ?>').slideToggle(250);
            $('#btlista<?php echo $i ?>').hide();

        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#Nactivar<?php echo $i ?>').click(function () {
            var valorId = $(this).attr('dat');
            var vivi = $(this).attr('vivi');
            $("#consulta_nit").removeAttr("readonly");
            $("#consulta_nombre").removeAttr("readonly");
            $("#consulta_nombre").css("background-color", "white");
            $("#consulta_nit").css("background-color", "white");

//            $.ajax({
//                type: 'GET',
//                url: '/index.php/caja/uncheck',
//                data: {'id': valorId, 'vivi': vivi},
//                success: function (data) {
//                    $('#totalv').html(data);
//                }
//            });
            $('#lin<?php echo $i ?>').css('background', 'white');
            $('#activar0').slideToggle(250);
            $('#btactiva<?php echo $i ?>').slideToggle(250);
            $('#bNtactiva<?php echo $i ?>').hide();
            $('#btlista<?php echo $i ?>').slideToggle(250);
            $('#bNtlista<?php echo $i ?>').hide();
        });
    });
</script>

