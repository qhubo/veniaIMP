
                            <br>
                            <table width="80%" height="70px" style="height:70px" >
                                <tr>
                                    <td>
                                            <a href="<?php echo url_for("partida_todas/index") ?>" class="btn btn-dark btn-block" > <li class="fa flaticon-upload"></li> Carga por archivo   </a>
                                            <br>
                                        
                                    </td>
                                </tr>
                                    <?php if ($partida) { ?>
                        <?php if ($partida->getValor() > 0) { ?>
                                <tr>
                                    <td><font size="+2">Procede a cerrar la partida creada</font></td>
                                </tr>
                                <tr>
                                    <td><br></td>
                                </tr>
                                <tr>
                                    <td>
                                        <a data-toggle="modal" href="#staticCONFIRMA" class="btn btn-secondary btn-success  btn-block" > <i class="fa fa-lock"></i> Confirmar</a>


                                    </td>
                                </tr>
                                    <?php } ?>
                    <?php } ?>
                            </table>
                    