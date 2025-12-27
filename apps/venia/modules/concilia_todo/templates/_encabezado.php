<?php $i = $banco->getId(); ?>  
<div class="row" style="background-image: url(./assets/media/bg/300.jpg); color:white; padding-top:10px; padding-bottom:5px ">
    <div class="col-lg-1"></div>
    <div class="col-lg-6"><font size="+1"> <?php echo $banco->getNombre(); ?></font> </div>

</div>
<table class="table table-striped- table-bordered table-hover table-checkable xdataTable no-footer dtr-inlin " width="100%">
    <thead>
        <tr class="active">
            <th  style="text-align: left; padding-left: 40px">Saldo en  Libros  </th>
            <td  style="text-align: right; padding-right: 40px"><?php echo Parametro::formato($banco->getHSaldoLibros($dia)); ?> 
            
            <button class="btn  btn-sm btn-success"  id="target<?php echo $banco->getId(); ?>"><i class="flaticon-refresh"></i> </button>
            </td>
        </tr>
        <tr class="active">
            <th style="text-align: left;  padding-bottom: 20px;  padding-left: 40px">Saldo&nbsp;en&nbsp;Bancos 
            <?php if ($banco->getDolares()) { ?> <span style="padding-top: 5px;  padding-bottom: 5px; background-color:#F8ED82">&nbsp;&nbsp; DOLARES &nbsp;&nbsp;</span>  <?php } ?>
            </th>
                                <?php //if ($dia <date('Y-m-d')) { ?> 
<!--            readonly='true' style="background-color:#F9FBFE ;"-->
 <?php //} ?>
            <td style="text-align: right; padding-right: 10px"> <input 

                    onkeypress="validate(event)"   class="form-control" placeholder="0.00"  <?php if ($valor) { ?> value="<?php echo $valor; ?>" <?php } ?>  name="totalbanco<?php echo $i; ?>" id="totalbanco<?php echo $i; ?>"> </td>
        </tr>
         <?php if ($banco->getDolares()) { ?> 
        <?php $diferencial =0; ?>
             <?php $saldoQ = SaldoBancoQuery::create()->filterByBancoId($banco->getId())->filterByFecha($dia)->findOne(); ?> 
        <?php if ($saldoQ) { $diferencial = $saldoQ->getDiferencial();
          }?> 
        <tr class="active">
           <th style="text-align: left;  padding-bottom: 20px;  padding-left: 40px"> 
            <span style=" padding-top: 5px;  padding-bottom: 5px; ">&nbsp;&nbsp; Diferencial Cambiario &nbsp;&nbsp;</span>  
            </th>   
            <td style="text-align: right; padding-right: 10px"> 
                
                <div>
                    <div style="float:left">
                <strong>Q </strong>
                    </div>
                    <div style="float:right">
                
                <input   id="diferencial<?php echo $i; ?>" name="diferencial<?php echo $i; ?>" readonly="true" onkeypress="validate(event)"  style="background-color:#F9FBFE ;"  class="form-control" placeholder="0.00" <?php if ($diferencial) { ?> value="<?php echo $diferencial; ?>" <?php } ?> >
                    </div>
                    </div>
                </td>
            
        </tr>
        
            <tr class="active">
           <th style="text-align: left;  padding-bottom: 20px;  padding-left: 40px"> 
             </th>   
            <td style="text-align: right; padding-right: 10px"> 
                    <a href="<?php echo url_for("concilia_todo/partida?fecha=".$dia."&id=".$banco->getId()) ?>" class="btn-dark btn  btn-sm btn-block" data-toggle="modal" data-target="#ajaxmodal<?php echo  $banco->getId(); ?>"> <i class="flaticon-list"></i> Partida   </a>
                                    
                </td>
            
        </tr>
   
                                             
         <?php } ?>
        
        <tr >
            <th colspan="2"><div   class="actu<?php echo $banco->getId(); ?>" id="actu<?php echo $banco->getId(); ?>" style="background-color:#646c9a; color:white; font-size: 20px; display: none" >Actualizado</div></th>    
        </tr>
        
    </thead> 
</table>