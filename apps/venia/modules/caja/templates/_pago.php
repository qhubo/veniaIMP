<?php echo $form->renderFormTag(url_for('caja/index'), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>   
<div class="row" style="background-color: #00E400; color: white">
                    <div class="col-lg-4"><br><h3> Total</h3> </div>
                    <div class="col-lg-8"><br>
                        <div class="totalv" id ="totalv">    
                            <h3> <?php echo number_format($grandTotal,2); ?> </h3> 
                        </div>                    
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4"> <h3>Pago</h3></div>
                    <?php if ($vivienda) { ?>
                    <div class="col-lg-8">
                        <a href="<?php echo url_for( 'caja/agrega') ?>"  data-toggle="modal" data-target="#ajaxmodal" class="btn-sm btn-info" > <i class="flaticon2-plus"></i>Agregar Servicio </a>
                        <br>                  
                    </div>
                    <?php } ?>
                </div>
     <?php if ($vivienda) { ?>
                <div class="row">
                    <div class="col-lg-12">
                        <br>
                    </div>
                </div>
                <div class="row">

                          <div class="col-lg-8   <?php if ($form['tipo_pago']->hasError()) echo "has-error" ?>">
                              <font size ="-1"> Tipo Pago </font>
                            <?php echo $form['tipo_pago'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['tipo_pago']->renderError() ?>       
                            </span>
                  
             
                    </div>
                </div>
                <div class="row">               
                        
                             <div class="col-lg-8   <?php if ($form['no_documento']->hasError()) echo "has-error" ?>">
       <font size ="-1">Documento </font>                           
 <?php echo $form['no_documento'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['no_documento']->renderError() ?>       
                            </span>
                  
             
                    </div>
                </div>
           <div class="row">               
                        
                             <div class="col-lg-8   <?php if ($form['banco_id']->hasError()) echo "has-error" ?>">
       <font size ="-1">Banco </font>                           
 <?php echo $form['banco_id'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['banco_id']->renderError() ?>       
                            </span>
                  
             
                    </div>
                </div>


                <div class="row">
                          <div class="col-lg-8   <?php if ($form['fecha']->hasError()) echo "has-error" ?>">
                          
       <font size ="-1"> Fecha Documento </font>
  <?php echo $form['fecha'] ?>          
                            <span class="help-block form-error"> 
                                <?php echo $form['fecha']->renderError() ?>       
                            </span>
                  
             
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <br>
                        <div style="display: none;">
                          <?php echo $form['viviendaId'] ?> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4"> </div>
                    <div class="col-lg-8">
                        <button class="btn btn-primary " type="submit">
                            <i class="fa fa-save "></i>
                            <span> Aceptar  </span>
                        </button>
                    </div>
                </div>
     <?php } ?>
         <?php echo '</form>' ?>