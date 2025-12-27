<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-more-v2 kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Selección de Producto    
                <small></small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
        </div>
    </div>
    <form action="<?php echo url_for('crea_combo/producto?id=' . $receta->getId()) ?>" method="post">
          <?php $tip = TipoAparatoQuery::create()->findOneById( $receta->getSeleccion()); ?>
      
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-3 kt-font-success kt-font-bold">Combo</div>
                <div class="col-lg-8"><?php echo $receta->getComboProducto()->getNombre(); ?></div>
            </div>
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-3  kt-font-success kt-font-bold">Grupo</div>
                <div class="col-lg-8"><strong> <?php echo $tip; ?></strong> </div>
            </div>
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-3  kt-font-success kt-font-bold">Producto</div>
                <div class="col-lg-8"><?php echo $receta->getProducto(); ?></div>
            </div>
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-3 font font-blue bold Bold">Adicionar</div>
                <div class="col-lg-6">
                    <select   class="form-control" name="em" id="em">
                        <option value="">[Seleccione]</option>
                        <?php foreach ($Productos as $lista) { ?>
                        <?php if ($lista->getId() <>  $receta->getProductoDefault()) { ?>
                        <option   value="<?php echo $lista->getId(); ?>"><?php echo $lista->getNombre(); ?>  <?php echo substr($lista->getDescripcion(),0,200); ?> </option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-3 font font-blue bold Bold">Precio Adicional</div>
                <div class="col-lg-3">
                    <input class="form-control" placeholder="0"  step="any" type="number" id="precio_d" name="precio_d" onkeypress="validated(event)">

                </div>

            </div>
            <div class="row">          
                <div class="col-lg-2"><br></div>
            </div>
            <div class="row">
                <div class="col-lg-7"></div>
                <div class="col-lg-5"></div>
            </div>
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <?php
                    $combolista = ListaComboDetalleQuery::create()
                            ->filterByComboProductoDetalleId($receta->getId())
                            ->find();
                    ?>
                    <?php if ($combolista) { ?>
                        <ul>
                            <?php foreach ($combolista as $list) { ?>

                                <li><?php echo $list->getProducto()->getNombre(); ?>
                                    <a href="<?php echo url_for($modulo . '/eliminaLista?id=' . $list->getId()) ?>" class=" btn-xs btn-danger "><i class="fa fa-remove"></i></a> 

                                </li>
                            <?php } ?>
                        </ul>  
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success " type="submit"><i class="flaticon-plus kt-font-info"></i> Agregar</button>
                <button type="button" data-dismiss="modal"  class="btn btn-secondary btn-dark">Cancelar</button>
            </div>
        </div>
    </form>
</div>


<script>
    function validated(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault)
                theEvent.preventDefault();
        }
    }
</script>