<div class="row"  style="background-color:#e1e1ef ">
    <div class="col-lg-1"> </div>
    <div class="col-lg-1">Sector </div>
    <div class="col-lg-5 ">
        <input  style="background-color:#e1e1ef " class="form-control"   placeholder="Sector" 
          enabled="true"     <?php if ($vivienda) { ?>  value="<?php echo $vivienda->getSector(); ?>"   <?php } ?> readonly="true"> 
    </div>
    <div class="col-lg-1">Número </div>
    <div class="col-lg-3 ">
        <input class="form-control"  style="background-color:#e1e1ef " placeholder="Número" 
               <?php if ($vivienda) { ?>  value="<?php echo $vivienda->getNumero(); ?>"
               <?php } ?>    readonly="true">          
    </div>
</div>
<?php if ($vivienda) { ?>
    <div class="row" style="background-color:#e1e1ef ">
        <div class="col-lg-1"> </div>
        <div class="col-lg-1"> Dirección</div>
        <div class="col-lg-9">
            <input style="background-color:#e1e1ef "  class="form-control" readonly="true"  type="text"  value="<?php echo $vivienda->getDireccion(); ?>" >
        </div>        
    </div>
<?php } ?>
<div class="row">
    <div class="col-lg-10"><br></div>
</div>
 <div class="row">
<div class="col-lg-1"></div>
     <div class="col-lg-1"> Factura</div>
<div class="col-lg-3">
    <select class="form-control" name="factura" id="factura">
        <option value="-99" selected="selected">[Facturar ]</option>
        <?php foreach ($Propietarios as $data) { ?>
        <?php $nombre =  $data->getPropietario()->getNombre()." ".$data->getPropietario()->getApellido(); ?>
          <option  value="<?php echo $data->getPropietarioId(); ?>" 
                   <?php if ($propi==$data->getPropietarioId()) { ?>
                   selected="selected" 
                   <?php } ?>
                   ><?php echo $nombre; ?></option>
        <?php   } ?>
    </select>
</div>
     <div class="col-lg-2 detalleFacturaz" id ="detalleFacturaz">
     <input class="form-control"
            
             <?php if ($vivienda) { ?>  value="<?php echo $nit; ?>"
               <?php } ?>   
            placeholder="Nit Factura" type="text" name="nit_factura" id="nit_factura">
    <?php //echo html_entity_decode($detalleFactura) ?>
     </div>
     
     <div class="col-lg-4 detalleFacturax" id ="detalleFacturax">
<input class="form-control" placeholder="Nombre Factura" type="text"
           <?php if ($vivienda) { ?>  value="<?php echo $nombre; ?>"
               <?php } ?>   
       name="nom_factura" id="nom_factura">
     </div>
     
     
 </div>