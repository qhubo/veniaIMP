        <div class="row">

                <label class="col-lg-1 control-label right "> Tienda </label>
                <div class="col-lg-3 <?php if ($form['bodega']->hasError()) echo "has-error" ?>">
                    <?php echo $form['bodega'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['bodega']->renderError() ?>  
                    </span>
                </div>
                <label class="col-lg-1 control-label right "> Inicio </label>
                <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaInicio'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaInicio']->renderError() ?>  
                    </span>
                </div>
                        <div class="col-lg-1 <?php if ($form['inicio']->hasError()) echo "has-error" ?>">
                    <?php echo $form['inicio'] ?>           
                           </div>

            </div>

            <div class="row">
                <label class="col-lg-4"></label>

<!--                <label class="col-lg-1 control-label right "> usuario </label>
                <div class="col-lg-3 <?php if ($form['usuario']->hasError()) echo "has-error" ?>">
                    <?php echo $form['usuario'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['usuario']->renderError() ?>  
                    </span>
                </div>-->
                <label class="col-lg-1 control-label right ">Fin  </label>
                <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fechaFin'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['fechaFin']->renderError() ?>  
                    </span>
                </div>
                          <div class="col-lg-1 <?php if ($form['fin']->hasError()) echo "has-error" ?>">
                    <?php echo $form['fin'] ?>           
                           </div>

             

                <div class="col-lg-2">
                    <button class="btn btn-sm btn-info" type="submit">
                        <i class="fa fa-search "></i>
                        Buscar
                    </button>
                </div>
            </div>