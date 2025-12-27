<?php $modulo = 'orden_cotizacion'; ?>
<?php $i = 1; ?>
<?php $estiloDos = ''; ?>
<?php $estiloUno = 'style="display:none;"'; ?>
<?php echo $form->renderFormTag(url_for($modulo . '/index?id=' . $id), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>

<div class="row"  style="background-color:#F9FBFE; padding: 10px">

    <div class="col-lg-2" ><div style="text-align:right">Fecha</div> </div>

    <div class="col-lg-2 <?php if ($form['fecha_documento']->hasError()) echo "has-error" ?>">
        <?php if ($orden) { ?>      

<!--            <input class="form-control"  readonly="1"  type="text" name="consulta[fecha_documento]" value="<?php echo date('d/m/Y'); ?>" id="consulta_fecha_documento">-->
 <?php echo $form['fecha_documento']; ?>
        <?php } ?>      
        <span class="help-block form-error"> 
            <?php echo $form['fecha_documento']->renderError() ?>  
        </span>
    </div>

    <div class="col-lg-" > 
        <?php if ($orden) { ?>
            <?php if ($orden->getRecetarioId()) { ?>
                <h3>Receta <?php echo $orden->getRecetarioId(); ?></h3>   
            <?php } ?>
        <?php } ?>
    </div>
<!--    <div class="col-lg-2 <?php if ($form['fecha_contabilizacion']->hasError()) echo "has-error" ?>">
        <?php if ($orden) { ?>   <?php echo $form['fecha_contabilizacion'] ?>  <?php } ?>          
        <span class="help-block form-error"> 
            <?php echo $form['fecha_contabilizacion']->renderError() ?>  
        </span>
    </div>-->
    <?php if ($cliente) { ?>
        <div class="col-lg-2"><strong> Código Cliente</strong> 
       <?php echo $cliente->getCodigo(); ?> </div>
    <?php } ?>
            <div class="col-lg-1">
        <?php if ($id) { ?>
            <div class="row">
                <div class="col-lg-10">
                    <div  id="btlista<?php echo $i ?>"  <?php echo $estiloUno ?> >
                        <a id="activar<?php echo $i ?>" vivi="1" dat="<?php echo $i ?>" class="btn btn-outline  "><img src="/images/UnCheck.png"> </a>     
                    </div> 
                    <div  id="bNtactiva<?php echo $i ?>" <?php echo $estiloDos ?>>
                        <a id="Nactivar<?php echo $i ?>"  vivi="1"  dat="<?php echo $i ?>" class="btn btn-outline  "><img src="/images/Check.png"></a> 
                    </div> 
                </div>
            </div>
        <?php } ?>
    </div>
      <div class="col-lg-2">
         <?php if ($id) { ?>
                            <a class="btn btn-outline-success "   href="<?php echo url_for('busca/indexCliente?id=1') ?>"  data-toggle="modal" data-target="#ajaxmodalv">
                                <li class="fa fa-search"></li> Cliente
                            </a>
                        <?php } ?>
      </div>
    <div class="col-lg-3">
        <?php echo $form['vendedor_id'] ?> 
    </div>
</div>





<div class="row" style="background-color:#F9FBFE;padding-bottom:  5px;" >

    <div class="col-lg-1" ><div style="text-align:right">Nit</div> </div>
    <div class="col-lg-2 <?php if ($form['nit']->hasError()) echo "has-error" ?>">
        <input   class="form-control"  <?php if ($orden) { ?>  value="<?php echo $orden->getNit(); ?>"  <?php } ?> style="background-color:#F9FBFE ;"  placeholder="Nit"  name="consulta[nit]" id ="consulta_nit" readonly="true">
        <span class="help-block form-error"> 
            <?php echo $form['nit']->renderError() ?>  
        </span>
    </div>


    <div class="col-lg-1"><div style="text-align:right">Nombre</div> </div>
    <div class="col-lg-4 <?php if ($form['nombre']->hasError()) echo "has-error" ?>">
        <input   class="form-control"  <?php if ($orden) { ?>  value="<?php echo $orden->getNombre(); ?>"  <?php } ?> style="background-color:#F9FBFE ;"  placeholder="Nombre"  name="consulta[nombre]"  id ="consulta_nombre" readonly="true">
        <span class="help-block form-error"> 
            <?php echo $form['nombre']->renderError() ?>  
        </span>
    </div>

    <div class="col-lg-1"><div style="text-align:right">Tienda</div> </div>
    <div class="col-lg-3"><?php echo $form['tienda_id'] ?></div>

</div>


<div class="row" style="background-color:#F9FBFE " >

    <div class="col-lg-1" ><div style="text-align:right">Télefono</div> </div>
    <div class="col-lg-2 <?php if ($form['telefono']->hasError()) echo "has-error" ?>">
        <?php if ($id) { ?>       <?php echo $form['telefono'] ?>          <?php } ?>      
        <span class="help-block form-error"> 
            <?php echo $form['telefono']->renderError() ?>  
        </span>
    </div>

    <div class="col-lg-1" >  <div style="text-align:right"> Correo</div> </div>
    <div class="col-lg-3 <?php if ($form['correo']->hasError()) echo "has-error" ?>">
        <?php if ($id) { ?>        <?php echo $form['correo'] ?>        <?php } ?>        
        <span class="help-block form-error"> 
            <?php echo $form['correo']->renderError() ?>  
        </span>
    </div>
    <div class="col-lg-1" >  <div style="text-align:right"> Dirección</div> </div>
    <div class="col-lg-4 <?php if ($form['direccion']->hasError()) echo "has-error" ?>">
        <?php if ($id) { ?>         <?php echo $form['direccion'] ?>     <?php } ?>     
        <span class="help-block form-error"> 
            <?php echo $form['direccion']->renderError() ?>  
        </span>
    </div>    
</div>





<div class="row" <?php if (!$id) { ?>  style="background-color:#F9FBFE; padding-top:5px;  " <?php } ?> >

    <div class="col-lg-1" >  <div style="text-align:right"> Observaciones</div> </div>
    <div class="col-lg-8 <?php if ($form['observaciones']->hasError()) echo "has-error" ?>">
        <?php echo $form['observaciones'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['observaciones']->renderError() ?>  
        </span>
    </div>
    <div class="col-lg-1" ></div>
    <?php if ($id) { ?>
        <div class="col-lg-2" style="padding-top:10px;"> 

            <button class="btn btn-primary btn-sm " type="submit">
                <i class="fa fa-save "></i> Actualizar
            </button>
        </div>
    <?php } ?>
</div>



<?php echo '</form>'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<?php $i = 1; ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#activar<?php echo $i ?>').click(function () {
            var valorId = $(this).attr('dat');
            var vivi = $(this).attr('vivi');
//            $.ajax({
//                type: 'GET',
//                url: '/index.php/caja/check',
//                data: {'id': valorId, 'vivi': vivi},
//                success: function (data) {
//                    $('#totalv').html(data);
//                }
//            });
            $('#activar0').hide();
            $('#lin<?php echo $i ?>').css('background', '#D7ECEA');
            $("#consulta_nombre").css("background-color", "#F9FBFE");
            $("#consulta_nit").css("background-color", "#F9FBFE");
            $("#consulta_telefono").css("background-color", "#F9FBFE");
            $("#consulta_correo").css("background-color", "#F9FBFE");
            $("#consulta_direccion").css("background-color", "#F9FBFE");
            $('#consulta_nit').attr('readonly', 'true');
            $('#consulta_nombre').attr('readonly', 'true');
            $('#consulta_telefono').attr('readonly', 'true');
            $('#consulta_correo').attr('readonly', 'true');
            $('#consulta_direccion').attr('readonly', 'true');

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
            $("#consulta_nit").removeAttr("readonly");
            $("#consulta_nombre").removeAttr("readonly");
            $("#consulta_telefono").removeAttr("readonly");
            $("#consulta_correo").removeAttr("readonly");
            $("#consulta_direccion").removeAttr("readonly");
            $("#consulta_nombre").css("background-color", "white");
            $("#consulta_nit").css("background-color", "white");
            $("#consulta_telefono").css("background-color", "white");
            $("#consulta_correo").css("background-color", "white");
            $("#consulta_direccion").css("background-color", "white");
//            $.ajax({
//                type: 'GET',
//                url: '/index.php/caja/uncheck',
//                data: {'id': valorId, 'vivi': vivi},
//                success: function (data) {
//                    $('#totalv').html(data);
//                }
//            });
            $('#lin<?php echo $i ?>').css('background', 'white');
            $('#activar0').slideToggle(250);
            $('#btactiva<?php echo $i ?>').slideToggle(250);
            $('#bNtactiva<?php echo $i ?>').hide();
            $('#btlista<?php echo $i ?>').slideToggle(250);
            $('#bNtlista<?php echo $i ?>').hide();
        });
    });
</script>


    <?php foreach ($pendientes as $lista) { ?>

        <div id="staticB<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmación de Proceso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <p> <strong> Confirma Eliminar </strong> 
                            <span class="caption-subject font-green bold uppercase"> 
                                <?php echo $lista->getOrdenCotizacion()->getCodigo() ?>
                            </span> ?
                        </p>
                    </div>
                    <?php $token = md5($lista->getOrdenCotizacion()->getCodigo()); ?>
                    <div class="modal-footer">
                        <a class="btn  btn-danger " href="<?php echo url_for($modulo . '/eliminaOR?token=' . $token . '&id=' . $lista->getOrdenCotizacionId()) ?>" >
                            <i class="fa fa-trash-o "></i> Confirmar </a> 
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar </button>

                    </div>

                </div>
            </div>
        </div> 
    <?php } ?>