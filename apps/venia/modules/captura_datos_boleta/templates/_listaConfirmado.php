      <table class="table" >
                            <tr style="background-color:#ebedf2">
                                <th align="center"  width="80px">Codigo</th>
                                <th align="center"   >Fecha</th>
                                <th align="center" >Banco</th>
                                <th align="center" >Boleta</th>
                                <th align="center" >Cliente</th>
                            </tr>
                            <?php foreach($datosConfirmados  as $confir) { ?>
                            <tr>
                                <td><?php echo $confir->getCodigo(); ?></td>
                                <td><?php echo $confir->getFechaDeposito('d/m/Y'); ?></td>
                                <td><?php echo $confir->getBanco(); ?></td>
                                <td>
                                      <a target="_blank" href="<?php echo url_for($modulo.'/reporte?id=' . $confir->getId()) ?>" class="btn btn-outline btn-block  btn-sm " > <i class="flaticon2-printer"></i><?php echo $confir->getBoleta(); ?> </a>

                                </td>
                                <td><?php echo $confir->getCliente(); ?></td>
                                
                            </tr>
                            <?php } ?>
                        </table>
