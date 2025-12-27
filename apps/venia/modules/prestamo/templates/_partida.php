        <?php echo $form->renderFormTag(url_for('prestamo/partida?id='.$id), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>
                <div class="row">
                        <label class="col-lg-1 control-label right "> Fecha </label>
                        <div class="col-lg-2 <?php if ($form['fecha']->hasError()) echo "has-error" ?>">
                            <?php echo $form['fecha'] ?>
                            <span class="help-block form-error">
                                <?php echo $form['fecha']->renderError() ?>
                            </span>
                        </div>
                        <div class="col-lg-2"></div>
                        <label class="col-lg-1 control-label right "> Numero </label>
                        <div class="col-lg-3 <?php if ($form['numero']->hasError()) echo "has-error" ?>">
                            <?php echo $form['numero'] ?>
                            <span class="help-block form-error">
                                <?php echo $form['numero']->renderError() ?>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-lg-1 control-label right "> Detalle </label>
                        <div class="col-lg-7 <?php if ($form['detalle']->hasError()) echo "has-error" ?>">
                            <?php echo $form['detalle'] ?>
                            <span class="help-block form-error">
                                <?php echo $form['detalle']->renderError() ?>
                            </span>
                        </div>
                    </div>
  
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped- table-bordered table-hover no-footer dtr-inlin " width="100%">
                    <tr class="active">
                        <td></td>
<!--                        <td><strong>Cuenta Contable</strong></td>
                        <td><strong>Detalle</strong></td>-->
                        <td></td> 
                        <td></td> 
                    </tr>
                    <?Php $total1 = 0; ?>
                    <?Php $total2 = 0; ?>
                    <?php $cont=0; ?>
                    <?php foreach ($partidaDetalle as $reg) { ?>
                    <?php $cont++; ?>
                        <?php $total1 = $reg['debe'] + $total1; ?>
                        <?php $total2 = $reg['haber'] + $total2; ?>
                        <?php $listaCuentas = $cuentasUno; ?>
                        <tr>
                            <td>

                                <select class="mi-selector form-control" name="cuenta<?php echo $cont ?>" id="cuenta<?php echo $cont ?>">
                                    <?php foreach ($listaCuentas as $dat) { ?>
                                        <option 
                                        <?php if ($dat->getCuentaContable() == $reg['cuenta']) { ?>
                                                selected="selected"
                                            <?php } ?>
                                            value="<?php echo $dat->getCuentaContable(); ?>"><?php echo $dat->getCuentaContable(); ?> - <?php echo $dat->getNombre(); ?></option>
                                        <?php } ?>
                                </select>
                            </td>
   
                            <td style="text-align: right" ><?php echo Parametro::formato( $reg['debe']) ?></td>
                            <td style="text-align: right"><?php echo Parametro::formato($reg['haber']); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="1" style="text-align: right" >Totales&nbsp;&nbsp;</td>
                        <td style="text-align: right" ><font size="+1"> <?php echo Parametro::formato($total1) ?></font></td>
                       <td style="text-align: right"><font size="+1"><?php echo Parametro::formato($total2); ?></font></td>
                    </tr>
                </table>
            </div>    

        </div>
        <div class="row" >
            <div class="col-lg-5" ></div>
            <div class="col-lg-3" style="padding-top: 10px;  padding-bottom: 10px">                <button type="button" data-dismiss="modal" class="btn btn-block btn-secondary btn-hover-brand">Cancelar</button>
            </div>


            <div class="col-lg-4 " style="xxbackground-size: contain; background-image: url(./assets/media//bg/300.jpg); padding-top: 13px;padding-bottom: 3px">

                <button class="btn btn-block btn-sm btn-primary " type="submit"> <i class="flaticon2-accept "></i> GRABAR PARTIDA </button>
            </div>
        </div>
        <?php echo "</form>"; ?>