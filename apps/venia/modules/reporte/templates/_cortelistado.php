
<table cellspacing="0" cellpadding="3"   width="740px">
    <tr>

        <td  width="260px"> 
            <table cellspacing="0" style=" border: 0.2px solid #B8B8B8;" cellpadding="3"  width="260px">

                <tr  style="background-color:#cbd6ec;border: 0.2px solid #B8B8B8; " >
                    <td style=" border: 0.2px solid #B8B8B8;" width="50px" align="center">#</td>
                    <td style=" border: 0.2px solid #B8B8B8;" width="135px" align="center">Medio Pago </td>
                    <td style=" border: 0.2px solid #B8B8B8;" width="75px" align="center">Valor </td>
                </tr>

                <?php $gratotal = 0; ?>
                <?php $gratotalV = 0; ?>
                <?php $can = 0; ?>
                <?php foreach ($operacionPago as $regis) { ?>
                    <?php if (strtoupper($regis->getTipo()) == 'EFECTIVO') { ?>
                        <?php $gratotal = $gratotal + $regis->getValorTotal(); ?>
                    <?php } ?>
                    <?php $gratotalV = $gratotalV + $regis->getValorTotal(); ?>                        
                    <?php $can++; ?>
                    <tr>
                        <td style=" border: 0.8px solid #B8B8B8;" width="50px"><?php echo $can; ?></td>
                        <td style=" border: 0.8px solid #B8B8B8;" width="135px"><font size="-1"><?php echo $regis->getTipo(); ?></font></td>
                        <td style=" border: 0.8px solid #B8B8B8;" width="75px" align="right"><font size="-1"><strong><?php echo number_format($regis->getValorTotal(), 2); ?></strong></font></td>
                    </tr>
                <?php } ?>

                <tr style="background-color:#cbd6ec;border: 0.2px solid #B8B8B8; " >
                    <td width="50px"></td>
                    <th width="135px">GRAN TOTAL CAJA</th>
                    <th  width="75px" align="right" ><div align="right"><?php echo number_format($gratotalV, 2); ?></div></th>
                </tr>
            </table>

            <BR>
<BR>
            <table cellspacing="0" style=" border: 0.2px solid #B8B8B8;" cellpadding="3"  width="260px">

              <tr  style="background-color:#cbd6ec;border: 0.2px solid #B8B8B8; " >
                    <td  style=" border: 0.8px solid #B8B8B8;" width="50px">Código</td>
                    <td  style=" border: 0.8px solid #B8B8B8;" width="90px">Detalle</td>
                    <td  style=" border: 0.8px solid #B8B8B8;" width="40px">#</td>
                    <td   style=" border: 0.8px solid #B8B8B8;" width="80px">Valor </td>
                </tr>

                <?php $total = 0; ?>
                <?php foreach ($detalle as $regi) { ?>
                    <?php $total = $total + $regi->getTotalValor(); ?>
                    <tr>
                        <td style=" border: 0.8px solid #B8B8B8;" width="50px"><font size="-2"><?php echo $regi->getCuentaVivienda()->getServicio()->getCodigo(); ?></font></td>
                        <td style=" border: 0.8px solid #B8B8B8;" width="90px"><font size="-2"><?php echo $regi->getCuentaVivienda()->getServicio()->getNombre(); ?></font></td>
                        <td style=" border: 0.8px solid #B8B8B8;" width="40px" align="right"><font size="-1"><strong><?php echo number_format($regi->getTotalCantidad(), 0); ?></strong></font></td>
                        <td style=" border: 0.8px solid #B8B8B8;" width="80px" align="right"><font size="-1"><strong><?php echo number_format($regi->getTotalValor(), 2); ?></strong></font></td>
                    </tr>
                <?php } ?>
               <tr  style="background-color:#cbd6ec;border: 0.2px solid #B8B8B8; " >
                        <td style=" border: 0.8px solid #B8B8B8;" width="50px"><font size="-2"><?php //echo $regi->getCuentaVivienda()->getServicio()->getCodigo(); ?></font></td>
                        <td style=" border: 0.8px solid #B8B8B8;" width="90px"><strong>Total</strong></td>
                        <td style=" border: 0.8px solid #B8B8B8;" width="40px" align="right"><font size="-1"><strong><?php //echo number_format($regi->getTotalCantidad(), 0); ?></strong></font></td>
                        <td style=" border: 0.8px solid #B8B8B8;" width="80px" align="right"><font size="-1"><strong><?php echo number_format($total, 2); ?></strong></font></td>
                    </tr>

            </table>



        </td>
        <td width="10px" ></td>
        <td width="470px" >
            <table cellspacing="0" style=" border: 0.2px solid #B8B8B8;" cellpadding="3"  width="470px">

                <tr  style="background-color:#cbd6ec;border: 0.2px solid #B8B8B8; " >
                    <td style=" border: 0.2px solid #B8B8B8;" width="110px">Fecha </td>
                    <td style=" border: 0.2px solid #B8B8B8;" width="60px"> Usuario</td>
                    <td style=" border: 0.2px solid #B8B8B8;" width="100px"> Documento </td>
                    <td style=" border: 0.2px solid #B8B8B8;" width="120px">Feel</td>
                    <td style=" border: 0.2px solid #B8B8B8;" width="80px">Valor </td>
                </tr>

                <?php $total = 0; ?>
                <?php foreach ($operaciones as $regi) { ?>
                    <?php $total = $total + $regi->getValorTotal(); ?>
                    <tr>
                        <td style=" border: 0.8px solid #B8B8B8;" width="110px" align="center"> <font size="-2"> <?php echo $regi->getFecha('d/m/Y H:i'); ?></font></td>

                        <td style=" border: 0.8px solid #B8B8B8;" width="60px"><font size="-2"><?php echo $regi->getUsuario(); ?></font></td>
                        <td style=" border: 0.8px solid #B8B8B8;" width="100px"><font size="-2"><?php echo $regi->getCodigo(); ?></font></td>
                        <td style=" border: 0.8px solid #B8B8B8;" width="120px"><font size="-2"><?php echo $regi->getFaceReferencia(); ?></font></td>
                        <td style=" border: 0.8px solid #B8B8B8;" width="80px" align="right"><font size="-1"><strong><?php echo number_format($regi->getValorTotal(), 2); ?></strong></font></td>

                    </tr>                       
                <?php } ?>
                <tr  style="background-color:#cbd6ec;border: 0.2px solid #B8B8B8; " >
                    <td style=" border: 0.8px solid #B8B8B8;" width="110px" align="center"> <font size="-2"> <?php //echo $regi->getFecha('d/m/Y H:i');   ?></font></td>
                    <td style=" border: 0.8px solid #B8B8B8;" width="60px"><font size="-2"><?php //echo $regi->getUsuario();   ?></font></td>
                    <td style=" border: 0.8px solid #B8B8B8;" width="100px"><font size="-2"><?php //echo $regi->getCodigo();   ?></font></td>
                    <td style=" border: 0.8px solid #B8B8B8;" width="120px"><font size="-2">TOTAL</font></td>
                    <td style=" border: 0.8px solid #B8B8B8;" width="80px" align="right"><font size="-1"><strong><?php echo number_format($total, 2); ?></strong></font></td>

                </tr>

            </table>

        </td>
    </tr>

</table>






