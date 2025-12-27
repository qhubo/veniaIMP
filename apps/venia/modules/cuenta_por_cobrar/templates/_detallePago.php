
<br>

<table class="table table-bordered">
    <thead>
        <tr>
            <th><span class="kt-font-bold kt-font-success">Tipo</span></th>
            <th  ><span class="kt-font-bold kt-font-success">Documento</span></th>
            <th width="60px" align="center"><span class="kt-font-bold kt-font-success">Valor</span></th>
        </tr>
    </thead>
    <tbody>
        <?php $totalP = 0; ?>
        <?php foreach ($pagos as $reg) { ?>
            <?php $totalP = $reg->getValor() + $totalP; ?>

            <tr>
                <td><?php echo strtoupper($reg->getTipo()); ?></td>
                <td><?php echo $reg->getDocumento(); ?></td>
                <td aling="right"><?php echo number_format($reg->getValor(), 2); ?></td>

            </tr>

        <?php } ?>

    </tbody>
    <tr>
        <td colspan="2" align="right"> <strong>TOTAL</strong></td>
        <td align="right"><?php echo number_format($totalP, 2); ?></td>

    </tr>
</table>
<br>

<?php if (count($prefechado) >0) { ?>
<h5>Cheque Prefechado</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th><span class="kt-font-bold kt-font-success">Tipo</span></th>
            <th  ><span class="kt-font-bold kt-font-success">Documento</span></th>
            <th width="60px" align="center"><span class="kt-font-bold kt-font-success">Valor</span></th>
            <th></th>
            <th width="10px"></th>
        </tr>
    </thead>
    <tbody>
        <?php $totalP = 0; ?>
        <?php foreach ($prefechado as $reg) { ?>
            <?php $totalP = $reg->getValor() + $totalP; ?>

            <tr>
                <td><?php echo strtoupper($reg->getTipo()); ?></td>
                <td><?php echo $reg->getDocumento(); ?></td>
                <td aling="right"><?php echo Parametro::formato($reg->getValor(), 2); ?></td>
                <td>
                                         <a data-toggle="modal" href="#staticCONFIRMA<?Php echo $reg->getId(); ?>" class="btn btn-small" > Procesar</a>
            
                </td>
                <td>
                   <a class="btn btn-sm btn-danger"  href="<?php echo url_for( 'cuenta_por_cobrar/eliminapago?id=' . $reg->getId()) ?>" > </a>  
                    
                </td>
            </tr>

        <?php } ?>

    </tbody>
    <tr>
        <td colspan="2" align="right"> <strong>TOTAL</strong></td>
        <td align="right"><?php echo number_format($totalP, 2); ?></td>

    </tr>
</table>
<?php } ?>
<?php $bancos = BancoQuery::create()->find(); ?>

        <?php foreach ($prefechado as $reg) { ?>
        <form action="<?php echo url_for('cuenta_por_cobrar/confirmarCheque?id='.$reg->getId()) ?>" method="get">
<div id="staticCONFIRMA<?Php echo $reg->getId(); ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <li class="fa fa-cogs"></li>
                <span class="caption-subject bold font-yellow-casablanca uppercase"> Confirmar Ingresos</span>
            </div>
            <div class="modal-body">
                <p> Esta seguro confirma el cheque pre fechado <strong><?php echo $reg->getDocumento(); ?></strong> 
                    <br> Por valor de <br>
<?php echo Parametro::formato($reg->getValor(), 2); ?>
                    <span class="caption-subject font-green bold uppercase"> 
                        <?php //echo $lista->getUsuario() ?>
                    </span> ?
                </p>
                
                <div class="row">
                    <div class="col-lg-2" style=" font-weight: bold;">Banco</div>
                    <div class="col-lg-4">
               <select class="form-control" name="banco" id="banco">
<option value="" selected="selected">[Seleccione]</option>
<?php foreach($bancos as $banc) { ?>
<option value="<?php echo $banc->getId(); ?>"><?php echo $banc->getNombre(); ?></option>
<?php  } ?>
</select>
                    </div>
                </div>
                
         
                <div class="row">
                    <div class="col-lg-2" style=" font-weight: bold;">No Deposito</div>
                    <div class="col-lg-4">
                        <input type="text" class="form-control"  name="deposito" id="deposito">
                    </div>
                </div>
                
                
                
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                    <button class="btn btn-primary " type="submit">
            <i class="flaticon2-plus-1"></i>  Aceptar 
        </button>
            </div>
        </div>
    </div>
</div> 
<?php echo '</form>' ?>
<?php } ?>
