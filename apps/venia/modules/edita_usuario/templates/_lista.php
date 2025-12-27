   
    <table class="table table-bordered  dataTable table-condensed flip-content" id="xxsample_2">
        <thead class="flip-content">
            <tr class="info">

                <th align="center" width="25px"> Usuario</th>
                <th  align="center"> Nombre Completo</th>
                <th  align="center"> Tipo Usuario</th>
                <th  width="10px" align="center"><font size="-2"> Activo</font> </th>
                <th width="20px">Acción </th>
                <th width="20px">Tiendas </th>
                <th width="40px"  align="center">Claves</th>
                <th width="10px">Elimina</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($usuarios) { ?>
                <?php foreach ($usuarios as $lis) { ?>
                    <?php $lisP = null; ?>
                    <tr>
                        <td><?php echo $lis->getUsuario() ?></td>
                        <td><?php echo $lis->getNombreCompleto() ?></td>
                        <td><?php echo $lis->getTipoUsuario() ?></td>
                            <td align="center"><?php if ($lis->getActivo()) { ?>
                    <li class="fa flaticon2-arrow-up kt-font-info "></li>
                <?php } else { ?>
                    <li class="fa flaticon2-arrow-down kt-font-danger "></li> 
                <?php } ?>
                </td>
                <td>
                    <a class="btn btn-xs btn-block  blue-steel"  href="<?php echo url_for($modulo . '/muestra?id=' . $lis->getId()) ?>" > <li class="fa fa-edit"></li> Editar&nbsp;&nbsp;&nbsp;&nbsp;</a>  
                </td>
                <td width="5px">
                    <a class="btn btn-xs btn-block  yellow-crusta"  href="<?php echo url_for($modulo . '/tienda?id=' . $lis->getId()) ?>" > <i class="fa fa-list-ol"></i> Tiendas</a>    
                </td>
                <td width="20px">
                    <a class="btn btn-xs  blue-hoki btn-outline  "  href="<?php echo url_for($modulo . '/cambioClave?id=' . $lis->getId()) ?>"  data-toggle="modal" data-target="#ajaxmodal<?php echo $lis->getId() ?> ">
                        <i class="fa fa-lock"></i> Cambiar </a>    
                </td>
                <td>
                    <?php if ($usuarioId <> $lis->getId()) { ?>
                        <a class="btn btn-block  btn-xs btn-danger" data-toggle="modal" href="#static<?php echo $lis->getId() ?>"><i class="fa fa-trash"></i>   </a>
                    <?php } else { ?>
                        <a class="btn  btn-block  btn-xs btn-danger disabled"  href="#"><i class="fa fa-trash"></i>  </a>

                    <?php } ?>
                </td>
                </tr>
                <?php $reg = $lis; ?>
                <?php $lista = $lis; ?>
                <div class="modal fade" id="ajaxmodal<?php echo $reg->getId() ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
                     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" style="width: 550px">
                        <div class="modal-content" style=" width: 550px">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                                <h4 class="modal-title" id="myModalLabel6">Detalle de Usuario</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <li class="fa fa-cogs"></li>
                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Eliminar Usuario</span>
                            </div>
                            <div class="modal-body">
                                <p> Esta seguro de eliminar Usuario
                                    <span class="caption-subject font-green bold uppercase"> 
                                        <?php echo $lista->getUsuario() ?>
                                    </span> ?
                                </p>
                            </div>
                            <?php $token = md5($lista->getUsuario()); ?>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                                <a class="btn  btn green " href="<?php echo url_for($modulo . '/elimina?token=' . $token . '&id=' . $lista->getId()) ?>" >
                                    <i class="fa fa-trash-o "></i> Confirmar</a> 
                            </div>
                        </div>
                    </div>
                </div> 


            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
