<div class="row">
    <div class="col-lg-12">

        <div class="row" >
            <div class="col-lg-2 kt-font-brand" style="text-align: right"></div>
            <div class="col-lg-6" > 
            <div<?php if (count($pendientes)>0 ) { ?>
                class="scroller" style="background-size: contain; padding-top:5PX; height:250px; overflow-y: scroll; width: auto;color: white; background-image: url(./assets/media//bg/300.jpg);" data-always-visible="1" data-rail-visible="0" data-initialized="1">
            <?php } else { ?>                
            <div class=" kt-font-brand"  style="padding-top:10PX; content:center; align-content: center; background-color:white; background-image: url(./assets/media//bg/300.jpg); color:#146CB5;  border-color: white;   border: ridge;border-radius: 1px; height: 100px">
                <?php } ?>
<div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-6">
                        <span class=" kt-font-brand"><font color="white"> <h5> CREA UN NUEVO GASTO </h5></font> </span>
                    </div>
               
                    <div class="col-lg-4">                     
                        <a href="<?php echo url_for($modulo . '/nueva') ?>" class="btn btn-sm btn-success btn-secondary" >  <i class="flaticon2-plus"></i> Nuevo </a>
                        <br>&nbsp;
                    </div>
                </div>
                
                  <div<?php if (count($pendientes)>0 ) { ?>
                 <div class="row">
                     <div class="col-lg-1"></div>
                      <div class="col-lg-10">
                          
                <table class="table table-bordered " >
                    <thead >
                    <th  align="center"> <font color="#E2ECFA">Código</font> </th>
                           <th  align="center"> <font color="#E2ECFA">Fecha</font>  </th>
                           <th  align="center"> <font color="#E2ECFA">Estatus</font>  </th>
                           <th  align="center"> <font color="#E2ECFA">Continuar</font>  </th>
                        </thead>
                        <tbody>
                            <?php foreach ($pendientes as $registro) { ?>
                            <tr>
                                <td><font color="white"><?php echo $registro->getGasto()->getCodigo(); ?> </font></td>
                                <td><font color="white"><?php echo $registro->getGasto()->getFecha('d/m/Y'); ?></font> </td>
                                <td><font color="white"><?php echo $registro->getGasto()->getEstatus(); ?> </font></td>
                                <td>       <a href="<?php echo url_for($modulo . '/nueva?codigo='.$registro->getGasto()->getCodigo()) ?>" class="btn btn-sm btn-success btn-secondary" >  <i class="  flaticon2-next"></i> </a> </td>
              
                            </tr>
                            <?php } ?>
                            
                        </tbody>
                </table>
                      </div>
                        <div class="col-lg-1"></div>
                 </div>
                  <?php } ?>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <br> 
            </div>
        </div>
    </div>

</div>

