<?php $partida = PartidaQuery::create()->findOneById($id); ?>
<?php $partidaDeta = PartidaDetalleQuery::create()->filterByPartidaId($id)->find(); ?>

<div class="row">

    <div class="col-lg-12"  > 
        <div class="row" >
            <div class="col-lg-1"></div>
            <div class="col-lg-10" style="background-color:  #D1DEF6; padding-top: 2px; padding-bottom: 2px; text-align: center">
                Partida <?php echo $partida->getNoAsiento(); ?>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12"><br></div>
        </div>
        <div class="row">

            <div class="col-lg-1"><strong><font size="-2"> Fecha</font> </strong></div>
            <div class="col-lg-2"><font size="-2"><?php echo $partida->getFechaContable('d/m/Y'); ?></font>        </div>


            <div class="col-lg-2"><strong><font size="-2"> Identificador</font></strong></div>
            <div class="col-lg-3"><font size="-2">
                
                <?php if ($partida->getMedioPagoId()) { ?> 
                      <?php echo $partida->getMedioPago()->getNombre(); ?>
                <?php } else { ?>
                <?php echo $partida->getTipo(); ?>
                 <?php echo $partida->getCodigo(); ?>  
                <?php } ?>
                
                </font> 

      </div>
            <div class="col-lg-2"><strong><font size="-2">Usuario</font> </strong></div>
            <div class="col-lg-2"><font size="-2"><?php echo $partida->getUsuario(); ?></font>  <?php //echo $partida->getCodigo();    ?>        </div>
        </div>        
        <div class="row">
            <div class="col-lg-12"><br></div>
        </div>


        <table class="table table-striped- table-bordered table-hover no-footer dtr-inlin " width="100%">

            <tr class="active">
                <td><strong><font size="-2">Cuenta&nbsp;Contable</font></strong></td>
                <td><strong><font size="-2">Detalle</font></strong></td>
                <td></td> 
                <td></td> 
            </tr>
            <?Php $total1 = 0; ?>
            <?Php $total2 = 0; ?>
            <?php foreach ($partidaDeta as $reg) { ?>
                <?php $total1 = $reg->getDebe() + $total1; ?>
                <?php $total2 = $reg->getHaber() + $total2; ?>
                <tr>
                    <td><font size="-2"><?php echo $reg->getCuentaContable() ?></font></td>
                    <td><font size="-2"><?php echo $reg->getDetalle() ?></font> </td>
                    <td style="text-align: right" ><font size="-2"><?php echo Parametro::formato($reg->getDebe(),false) ?></font></td>
                    <td style="text-align: right"><font size="-2"><?php echo Parametro::formato($reg->getHaber(),false); ?></font></td>
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




