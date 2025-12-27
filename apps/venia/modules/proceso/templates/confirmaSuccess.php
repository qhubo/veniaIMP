<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-bell-4 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                Confirmación de Proceso <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                    Verifica la información  </small>
            </h3>

        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
         <?php $modulo = $sf_params->get('module'); ?>
        <?php echo $form->renderFormTag(url_for($modulo . '/confirma').'?token=' . $token . "&tipo=" . $tipo, array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
    <div class="kt-portlet__body">

   

        <div class="row">

            <div class="col-lg-3"><strong> Documento </strong></div>
            <div class="col-lg-5 ">
                <?php echo $form['tipo'] ?>           
            </div>
            <div class="col-lg-4 ">
                <?php echo $form['codigo'] ?>           
            </div>
        </div>
    
        <div class="row" style="padding-top: 5px;">
            <div class="col-lg-3"><strong> Autorización </strong></div>
            <div class="col-lg-5 ">
                <?php echo $form['usuario'] ?>           
            </div>
            <div class="col-lg-4 ">
                <?php echo $form['fecha'] ?>           
            </div>
        </div>

        <?php if ($grabaPago) { ?>
      <div class="row" style="padding-top: 5px;">
            <div class="col-lg-3"><strong> Banco </strong></div>
            <div class="col-lg-5 ">
                <?php echo $form['banco_id'] ?>           
            </div>
            <div class="col-lg-4 ">
                <?php echo $form['no_documento'] ?>           
            </div>
        </div>
        <?php } ?>

         <div class="row" style="background-color:  #D1DEF6; margin-top:5px; padding-bottom: 10px;">
             <div class="col-lg-3"><strong> Observaciones</strong><font color='red' size='+3' >*</font> </div>
            <div class="col-lg-9 " style="padding-top: 5px;">
                <?php echo $form['observaciones'] ?>           
            </div>
        </div>
        
       

      
        <div class="row" style="padding-top: 5px;">
            <div class="col-lg-3"><strong> Valor Total</strong></div>
            <div class="col-lg-3 ">
                <?php echo $form['valor'] ?>           
            </div>
            <?php if ($retenido >0) { ?>
            <div class="col-lg-2"><strong> Valor Retenido</strong></div>
            <div class="col-lg-3 ">
                <input class="form-control" readonly="1"  value="<?php echo Parametro::formato($retenido,false);  ?>" >        
            </div>
            <?php } ?>
            <?php if ($pideConfirma) { ?>
              <div class="col-lg-2"><strong> No Confirmación</strong></div>
                    <div class="col-lg-3 " style="padding-top: 5px;">
                <?php echo $form['no_confirmacion'] ?>           
            </div>
            <?php } ?>
        </div>
      
         <div class="row">
            <div class="col-lg-12"><br></div>
        </div>

        <div class="row" >
            <div class="col-lg-5" ></div>
            <div class="col-lg-3" style="padding-top: 10px;  padding-bottom: 10px">                <button type="button" data-dismiss="modal" class="btn btn-block btn-secondary btn-hover-brand">Cancelar</button>
            </div>


            <div class="col-lg-4 " style="xxbackground-size: contain; background-image: url(./assets/media//bg/300.jpg); padding-top: 13px;padding-bottom: 3px">

                <button class="btn btn-block btn-sm btn-primary " type="submit"> <i class="flaticon2-accept "></i> Confirmar </button>
            </div>
        </div>
    </div>
      <?php echo '</form>'; ?>
</div>
