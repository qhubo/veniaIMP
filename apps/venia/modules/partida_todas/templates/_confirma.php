


<br>

<table width="80%" height="70px" style="height:70px" >

    <tr>
        <td>
            <div class="row">
                <div class="col-md-6"> Puedes visualizar  el ejemplo  de modelo de carga aqui!</div>
                <div class="col-md-2"> 
                    <a data-toggle="modal" href="#large"><i class="fa fa-eye"></i> <font color="#006600"> <strong> Visualizar</strong> </font>  </a>

                </div>
            </div>
        </td>
    </tr>
      <tr>
        <td>
            <br> 
        </td>
    </tr>
        <tr>
        <td>
            <div class="row">
                <div class="col-md-6"> Para la columna fecha el Formato de fecha permitido  dd/mm/YYYY</div>
                <div class="col-md-2"> 
                    <strong>                 Ejemplo  <?php echo date('d/m/Y'); ?>  </strong>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <br> 
        </td>
    </tr>
           <tr>
        <td>
            <div class="row">

                <div class="col-md-12"> 
                    <strong> <font color="red" size="+1">* Importante</font> Si el # ASIENTO existe  </strong>
      La información de la partida se actualizara</div>
                               </div>
        </td>
    </tr>
    
        <tr>
        <td>
            <br>   <br>   <br> 
        </td>
    </tr>
    
    <tr>
        <td>
            <a href="<?php echo url_for("carga/index?tipo=cargapartidatodas") ?>" class="btn btn-dark btn-block" data-toggle="modal" data-target="#ajaxmodal"> <li class="fa flaticon-upload"></li> Importar archivo   </a>
            <br>

        </td>
    </tr>
   <tr>
        <td>
            <br> 
        </td>
    </tr>

</table>




<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <li class="fa fa-image"></li>
                <span class="caption-subject bold font-purple-plum uppercase">Ejemplo  Carga</span>
            </div>
            <div class="modal-body"> 

                <img src="/images/modelocarga.PNG"  width="950px" >   

            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>