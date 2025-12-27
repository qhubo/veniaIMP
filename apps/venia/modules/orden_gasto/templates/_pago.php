<div class="row">
    <Div class="col-lg-6">
        <div class="row">
            <div class="col-lg-10" style="background-size: contain; color:white; background-image: url(./assets/media//bg/300.jpg); padding-top: 6px; padding-bottom: 6px">Ingresa un abono y/o pago</div>

        </div>
        <div class="row">
            <div class="col-lg-12"><br></div>

        </div>
<?Php if (!$ocultaPago) { ?>
        <?php echo $form->renderFormTag(url_for('orden_gasto/muestra?token=' . $orden->getToken()), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>          
        <div class="row">
            <div class="col-lg-3">Tipo Pago </div>
            <div class="col-lg-6   <?php if ($form['tipo_pago']->hasError()) echo "has-error" ?>">
                <font size ="-1">  </font>
                <?php echo $form['tipo_pago'] ?>          
                <span class="help-block form-error"> 
                    <?php echo $form['tipo_pago']->renderError() ?>       
                </span>


            </div>
        </div>
        <div class="row">               
            <div class="col-lg-3">Documento </div>
            <div class="col-lg-6   <?php if ($form['no_documento']->hasError()) echo "has-error" ?>">
                <font size ="-1"> </font>                           
                <?php echo $form['no_documento'] ?>          
                <span class="help-block form-error"> 
                    <?php echo $form['no_documento']->renderError() ?>       
                </span>


            </div>
        </div>

        <div class="row">               
            <div class="col-lg-3">Banco </div>
            <div class="col-lg-6   <?php if ($form['banco_id']->hasError()) echo "has-error" ?>">
                <font size ="-1"> </font>                           
                <?php echo $form['banco_id'] ?>          
                <span class="help-block form-error"> 
                    <?php echo $form['banco_id']->renderError() ?>       
                </span>


            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">Fecha Documento </div> 
            <div class="col-lg-6   <?php if ($form['fecha']->hasError()) echo "has-error" ?>">

                <font size ="-1">  </font>
                <?php echo $form['fecha'] ?>          
                <span class="help-block form-error"> 
                    <?php echo $form['fecha']->renderError() ?>       
                </span>


            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <br>

            </div>
        </div>
        <div class="row">
               <div class="col-lg-3">Valor </div> 
             <div class="col-lg-5   <?php if ($form['valor']->hasError()) echo "has-error" ?>">

                <font size ="-1">  </font>
                <?php echo $form['valor'] ?>          
                <span class="help-block form-error"> 
                    <?php echo $form['valor']->renderError() ?>       
                </span>


            </div>
            <div class="col-lg-3">
                <button class="btn btn-primary " type="submit">
                    <i class="flaticon2-plus-1"></i>  Aceptar 
                </button>
            </div>
        </div>

        <?php echo '</form>' ?>
<?php }  else {?> 
        <h3> No tiene saldo pendiente </h3>
<?php } ?>

    </Div>
    <Div class="col-lg-6">
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-4"><strong> Valor Total</strong></div>
            <div class="col-lg-4">
                <input class="form-control"  background-color="#F9FBFE" readonly="true" value="<?php echo  Parametro::formato($orden->getValorTotal()- $orden->getValorImpuesto(),false); ?> " >
            </div>
        </div>
      <div class="row">
          <Div class="col-lg-12"><br></Div>
      </div>
        <div class="row">
            <Div class="col-lg-12">
                <table class="table table-bordered  xdataTable table-condensed flip-content" >
                    <thead class="flip-content">
                        <tr class="active">
                             <td><font size="-1">Código</font></td>
                      
                            <td><font size="-1">Fecha</font></td>
                            <td><font size="-1"> Usuario</font> </td>
                      
                             <td><font size="-1">Tipo</font></td>
                            <td><font size="-1">Documento</font></td>
                            <td><font size="-1">Valor</font></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pagos as $regi) { ?>
                        <tr>
                            <td><font size="-1"><?php echo $regi->getCodigo(); ?> </font></td>
                            <td><font size="-1"><?php echo $regi->getFechaCreo('d/m/Y H:i') ?> </font></td>
                            <td><font size="-1"><?php echo $regi->getUsuario(); ?> </font></td>
                         
                            <td><font size="-1"><?php echo $regi->getTipoPago(); ?> </font></td>
                             <td><font size="-1"> <?php echo $regi->getBanco() ?><?php echo $regi->getDocumento() ?> </font></td>
                             <td style="text-align: right"><font size="-1"><?php echo Parametro::formato($regi->getValorTotal()); ?> </font></td>
                        </tr>
                        <?php  } ?>

                    </tbody>
                    <?php $valor=  round($orden->getValorTotal(),2)-round($orden->getValorImpuesto(),2)-round($orden->getValorPagado(),2); ?>
                    
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Valor Pagado</strong></td>
                            <td style="text-align: right"><?php echo Parametro::formato($orden->getValorPagado()); ?></td>
                        </tr>
                         <tr>
                            <td colspan="3"><strong>Saldo</strong></td>
                            <td style="text-align: right">
                                <strong>
              
                                <?php echo Parametro::formato($valor,true); ?>
                       </strong></td>
                                </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </Div>


</div>