<?php $cliente = $operacion->getCliente(); ?>
<div class="row"  style="background-color:#F9FBFE; padding: 10px">
    <div class="col-lg-1" ><div style="text-align:right">Fecha</div> </div>
    <div class="col-lg-2" >
       <input class="form-control"  readonly="1"  type="text"  value="<?php echo $operacion->getFecha('d/m/Y'); ?>" >
    </div>
    <?php if ($cliente) { ?>
        <div class="col-lg-3"><strong>  Cliente</strong> 
       <?php echo $cliente->getCodigo(); ?> <br>
    
       <?php echo $cliente->getNombre(); ?> </div>
    <?php } ?>
    <div class="col-lg-4">
        <?php if ($operacion->getVendedorId()) { ?>
        Vendedor 
        <?php echo $operacion->getVendedor()->getNombre(); ?>
       <?php } ?>
    </div>
</div>
<div class="row" style="background-color:#F9FBFE;padding-bottom:  5px;" >
    <div class="col-lg-1" ><div style="text-align:right">Nit</div> </div>
    <div class="col-lg-2">
        <input class="form-control"  style="background-color:#F0F8FA" readonly="1"  type="text"  value="<?php echo $operacion->getNit(); ?>" >
    </div>


    <div class="col-lg-1"><div style="text-align:right">Nombre</div> </div>
    <div class="col-lg-4 ">
          <input class="form-control" style="background-color:#F0F8FA"  readonly="1"  type="text"  value="<?php echo $operacion->getNombre(); ?>" >
    </div>

    <div class="col-lg-1"><div style="text-align:right">Tienda</div> </div>
    <div class="col-lg-3">
              <input class="form-control"  style="background-color:#F0F8FA"  readonly="1"  type="text"  value="<?php echo $operacion->getTienda(); ?>" >
        
    </div>

</div>


<div class="row" style="background-color:#F9FBFE " >

    <div class="col-lg-1" ><div style="text-align:right">Télefono</div> </div>
    <div class="col-lg-2">
      <input class="form-control" style="background-color:#F0F8FA"  readonly="1"  type="text"  value="<?php echo $cliente->getTelefono(); ?>" >
   
    </div>

    <div class="col-lg-1" >  <div style="text-align:right"> Correo</div> </div>
    <div class="col-lg-3">
             <input class="form-control" style="background-color:#F0F8FA"   readonly="1"  type="text"  value="<?php echo $operacion->getCorreo(); ?>" >     
   
    </div>
    <div class="col-lg-1" >  <div style="text-align:right"> Dirección</div> </div>
    <div class="col-lg-4">
            <input class="form-control" style="background-color:#F0F8FA"   readonly="1"  type="text"  value="<?php echo $cliente->getDireccion(); ?>" >
   
    </div>    
</div>


<div class="row"  style="background-color:#F9FBFE; padding-top:5px;  "  >
    <div class="col-lg-1" >  <div style="text-align:right"> Observaciones</div> </div>
    <div class="col-lg-11 ">
           <input class="form-control"  style="background-color:#F0F8FA"  readonly="1"  type="text"  value="<?php echo $operacion->getObservaciones(); ?>" >         
    </div>
</div>

<div class="row"  style="background-color:#F9FBFE; padding-top:5px;  "  >
    <div class="col-lg-1" >  <div style="text-align:right"> Transporte</div> </div>
    <div class="col-lg-5 ">
           <input class="form-control"   name="transporte" id="transporte" type="text"  value="<?php echo $operacion->getTransporte(); ?>" >         
    </div>
</div>



