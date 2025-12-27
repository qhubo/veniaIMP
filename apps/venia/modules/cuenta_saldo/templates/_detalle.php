          <div class="row" style="padding-top:10px">
                <div class="col-lg-12">
                    <table class="table table-bordered  dataTable table-condensed flip-content" >
                        <thead class="flip-content">
                            <tr class="active">
                                <th  align="center"><font size="-1"> Cuenta</font></th>
                                <th  align="center"><font size="-1"> Saldo Inicial</font></th>
                                <?php foreach ($periodos as $Perido) { ?>
                                <td><font size="-1"><?php echo $Perido['detalle']; ?></font> </td>
                                <?php } ?>
                                <th  align="center"><font size="-1"> Total</font></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php $graTOtal =0; ?>
                            <?php $TOtalFInal =0; ?>
                              <?php $lineaTotal =null; ?>
                            <?php if ($resultado) { ?>
                            <?php foreach ($periodos as $Perido) { ?>
                            <?php //echo "<pre>"; print_r($Perido['periodo']); ?>
                             <?php $lineaTotal[$Perido['periodo']] =0; ?>
                            <?php  } ?> 
                            <?php foreach ($resultado as $regi) { ?>
                                  <tr>
                                <td><font size="-2"><strong> <?php echo $regi['cuenta']; ?></strong>  <?php echo $regi['nombre']; ?></font> </td>
                                    <td style="text-align: right"><font size="-2"><?php echo Parametro::formato($regi['inicial'], false);;; ?></font> </td>
                                                                <?php $graTOtal =$graTOtal+$regi['inicial']; ?>
                                    
                                    <?php foreach ($periodos as $Perido) { ?>
                                    <?php $lineaTotal[$Perido['periodo']] =$lineaTotal[$Perido['periodo']]+$regi[$Perido['periodo']]; ?>
                                    <?php //$valor=$cuenta->getValorPeriodo($Perido['periodo']); ?>
                                     <td style="text-align: right"><font size="-2"><?php echo Parametro::formato( $regi[$Perido['periodo']], false);; ?></font> </td>
                                    <?php } ?>
                                    <td style="text-align: right"><font size="-2"><?php echo Parametro::formato($regi['total'], false);;; ?></font> </td>
                                                             <?php $TOtalFInal =$TOtalFInal+$regi['total']; ?>
                                  </tr>
                            <?php } ?>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Totales</td>
                                <td style="text-align: right"><font size="-2"><?php echo Parametro::formato( $graTOtal, false);; ?></font> </td>
                                <?php foreach ($periodos as $Perido) { ?>
                                        <td style="text-align: right"><font size="-2"><?php echo Parametro::formato($lineaTotal[$Perido['periodo']], false);;; ?></font> </td>
                                    <?php } ?>
                                                                        <td style="text-align: right"><font size="-2"><?php echo Parametro::formato( $TOtalFInal, false);; ?></font> </td>

                            </tr>
                        </tfoot>
                    </table>
                </div>         
            </div>