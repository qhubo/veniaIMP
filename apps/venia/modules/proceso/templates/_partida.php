<?php $partida = PartidaQuery::create()->findOneById($id); ?>
<?php $partidaDeta = PartidaDetalleQuery::create()->filterByPartidaId($id)->find(); ?>

<?php if ($partida) { ?>
<div class="row">
   
    <div class="col-lg-12" style=" border: ridge;border-radius: 1px" > 
        <div class="row" style="background-color:  #D1DEF6; padding-top: 5px; padding-bottom: 5px">
            <div class="col-lg-12" style="text-align: center">
                Partida <?php echo $partida->getNoAsiento(); ?>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12" style="padding-top:5px; padding-bottom: 5px"><?php echo $partida->getDetalle(); ?></div>
        </div>
        <div class="row">
        
            <div class="col-lg-3"><strong> <?php echo $partida->getFechaContable('d/m/Y'); ?> </strong>       </div>


           
            <div class="col-lg-5"><?php echo $partida->getTipo(); ?>  <?php echo $partida->getCodigo(); ?>        </div>
            <div class="col-lg-2"><strong>Usuario </strong></div>
            <div class="col-lg-2"><?php echo $partida->getUsuario(); ?>  <?php //echo $partida->getCodigo();   ?>        </div>
        </div>        
        <div class="row">
            <div class="col-lg-12"><br></div>
        </div>


        <table class="table table-striped- table-bordered table-hover no-footer dtr-inlin " width="100%">

            <tr class="active">
                <td><strong>Cuenta Contable</strong></td>
                <td><strong>Detalle</strong></td>
                <td></td> 
                <td></td> 
            </tr>
            <?Php $total1=0; ?>
                        <?Php $total2=0; ?>
            <?php foreach ($partidaDeta as $reg) { ?>
            <?php $total1= $reg->getDebe() + $total1; ?>
                        <?php $total2= $reg->getHaber() + $total2; ?>
            <tr>
                <td><?php echo $reg->getCuentaContable() ?></td>
                  <td><?php echo $reg->getDetalle() ?></td>
                  <td style="text-align: right" ><?php echo Parametro::formato($reg->getDebe(),false) ?></td>
                      <td style="text-align: right"><?php echo Parametro::formato($reg->getHaber(),false); ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="2" style="text-align: right" >Totales&nbsp;&nbsp;</td>
                <td style="text-align: right" ><font size="+1"> <?php echo Parametro::formato($total1) ?></font></td>
                      <td style="text-align: right"><font size="+1"><?php echo Parametro::formato($total2); ?></font></td>
            </tr>
        </table>
    </div>    

</div>

<?php } ?>


