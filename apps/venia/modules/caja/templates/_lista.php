
<form action="<?php echo url_for('caja/index?id=0') ?>" method="get">
    <div class="row">
        <div class="col-lg-9"></div>
        <div class="col-lg-3">
            <select  onchange="this.form.submit()" class="form-control" name="em" id="em">
                <option <?php if ($em == 1) { ?> selected="selected" <?php } ?> value="1" >Mes Actual</option>
                <option value="2"  <?php if ($em == 2) { ?> selected="selected" <?php } ?> >Vencidos</option>
                <option value="3"  <?php if ($em == 3) { ?> selected="selected" <?php } ?> >Todos</option>

            </select>
        </div>
    </div>
</form>
<table class="table table-striped- table-bordered table-hover "  width="100%">
    <thead>
        <tr class="active">
            <th  align="center"><span class="kt-font-success"> Código</span></th>
            <th   align="center"><span class="kt-font-success"> Detalle </span></th>
            <th  align="center"><span class="kt-font-success"> Fecha Pago </span></th>
            <th   align="center"><span class="kt-font-success"> Valor</span></th>
            <th  align="center"><span class="kt-font-success"> Moroso</span></th>
            <th   align="center"><span class="kt-font-success"> Valor Mora</span></th>
            <th   align="center"><span class="kt-font-info"> Check</span></th>
        </tr>
    </thead>
    <tbody>
        <?php if ($cuenta) { ?>
        <?php foreach ($cuenta as $registro) { ?>
            <?php $lista = $registro; ?>
            <?php $i = $registro->getId(); ?>
            <?php if ($registro->getTemporal()) { ?>
                <?php $estiloDos = ''; ?>
                <?php $estiloUno = 'style="display:none;"'; ?>
            <?php } else { ?>
                <?php $estiloUno = ''; ?>
                <?php $estiloDos = 'style="display:none;"'; ?>
            <?php } ?>

            <tr id="lin<?php echo $i ?>" class="lin<?php echo $i ?>"
            <?php if ($registro->getTemporal()) { ?>
                    style="background-color:#D7ECEA"
                <?php } ?>            
                >
                <td><?php echo $registro->getCodigo() ?>
                
                </td>
                <td>
                    <font size="-2"> 
                    <?php echo $registro->getServicio()->getCodigo() ?>
                    </font>
                    <?php echo $registro->getDetalle() ?></td>
                <td><?php echo $registro->getFecha('d/m/Y') ?></td>
                <td align="right"><?php echo number_format($registro->getValor(), 2); ?></td>
                <td></td>
                <td align="right">
                    <?php if ($registro->getNumero() == 'Agregado') { ?>
                        <a class="btn btn-sm  btn-danger" data-toggle="modal" href="#static<?php echo $registro->getId() ?>">
                            <i class="fa fa-trash"></i>  
                        </a>
                    <?php } else { ?>
                        <?php echo number_format($registro->getValorMora()); ?>
                    <?php } ?>

                </td>  
                <td>
                    <div  id="btlista<?php echo $i ?>"  <?php echo $estiloUno ?> >
                        <a id="activar<?php echo $i ?>" vivi="<?php echo $vivienda; ?>" dat="<?php echo $i ?>" class="btn btn-outline  "><img src="/images/UnCheck.png"> </a>     
                    </div> 
                    <div  id="bNtactiva<?php echo $i ?>" <?php echo $estiloDos ?>>
                        <a id="Nactivar<?php echo $i ?>"  vivi="<?php echo $vivienda; ?>"  dat="<?php echo $i ?>" class="btn btn-outline  "><img src="/images/Check.png"></a> 
                    </div>                   

                </td>
            </tr>


        <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <p> Confirma Eliminar 
                            <span class="caption-subject font-green bold uppercase"> 
                                <?php echo $lista->getCodigo() ?>
                            </span> ?
                        </p>
                    </div>
                    <?php $token = md5($lista->getId()); ?>
                    <div class="modal-footer">
                        <a class="btn  btn-danger " href="<?php echo url_for('caja/elimina?token=' . $token . '&id=' . $lista->getId()) ?>" >
                            <i class="fa fa-trash-o "></i> Confirmar </a> 
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                    </div>

                </div>
            </div>
        </div> 


    <?php } ?>
        <?php } ?>
</tbody>
</table>



<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<?php if ($cuenta) { ?>
<?php foreach ($cuenta as $registro) { ?>
    <?php $i = $registro->getId(); ?>
    <script type="text/javascript">
                    $(document).ready(function () {
                        $('#activar<?php echo $i ?>').click(function () {
                            var valorId = $(this).attr('dat');
                            var vivi = $(this).attr('vivi');
                            $.ajax({
                                type: 'GET',
                                url: '/index.php/caja/check',
                                data: {'id': valorId, 'vivi': vivi},
                                success: function (data) {
                                    $('#totalv').html(data);
                                }
                            });
                            $('#activar0').hide();
                            $('#lin<?php echo $i ?>').css('background', '#D7ECEA');

                            $('#bNtactiva<?php echo $i ?>').slideToggle(250);
                            $('#btactiva<?php echo $i ?>').hide();
                            $('#bNtlista<?php echo $i ?>').slideToggle(250);
                            $('#btlista<?php echo $i ?>').hide();

                        });
                    });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#Nactivar<?php echo $i ?>').click(function () {
                var valorId = $(this).attr('dat');
                var vivi = $(this).attr('vivi');
                $.ajax({
                    type: 'GET',
                    url: '/index.php/caja/uncheck',
                    data: {'id': valorId, 'vivi': vivi},
                    success: function (data) {
                        $('#totalv').html(data);
                    }
                });
                $('#lin<?php echo $i ?>').css('background', 'white');
                $('#activar0').slideToggle(250);
                $('#btactiva<?php echo $i ?>').slideToggle(250);
                $('#bNtactiva<?php echo $i ?>').hide();
                $('#btlista<?php echo $i ?>').slideToggle(250);
                $('#bNtlista<?php echo $i ?>').hide();
            });
        });
    </script>
<?php } ?>
<?php } ?>