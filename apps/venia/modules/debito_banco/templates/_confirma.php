    <?php if ($partida) { ?>
                        <?php if ($partida->getValor() > 0) { ?>
                            <br>
                            <table width="80%" height="70px" style="height:70px" >
                                <tr>
                                    <td><br></td>
                                </tr>
                                <tr>
                                    <td><font size="+2">Procede a cerrar la partida creada</font></td>
                                </tr>
                                <tr>
                                    <td><br></td>
                                </tr>
                                <tr>
                                    <td>
                                        <a data-toggle="modal" href="#staticCONFIRMA" class="btn btn-secondary btn-success" > <i class="fa fa-lock"></i> Confirmar</a>


                                    </td>
                                </tr>
                            </table>
                        <?php } ?>
                    <?php } ?>