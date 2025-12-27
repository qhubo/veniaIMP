<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-bell-5 kt-font-danger"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-warning">
                Rechazo de Proceso <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong></span>
                     </small>
            </h3>

        </div>
        <div class="kt-portlet__head-toolbar">

        </div>
    </div>
       <?php $modulo = $sf_params->get('module'); ?>
        <?php echo $form->renderFormTag(url_for($modulo . '/rechaza?token=' . $token . "&tipo=" . $tipo), array('class' => 'form-horizontal"')) ?>
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
        <div class="row">
            <div class="col-lg-12"><hr></div>
        </div>
      <div class="row" style="background-color:  #F5EFF7">
             <div class="col-lg-3"><strong> Observaciones</strong><font color='red' size='+3' >*</font> </div>
            <div class="col-lg-9 ">
                <?php echo $form['observaciones'] ?>           
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12"><br></div>
        </div>

       
          <div class="row">
            <div class="col-lg-3"><strong> Grabación </strong></div>
            <div class="col-lg-5 ">
                <?php echo $form['usuario'] ?>           
            </div>
            <div class="col-lg-4 ">
                <?php echo $form['fecha'] ?>           
            </div>
        </div>
  
        
         <div class="row">
            <div class="col-lg-12"><br></div>
        </div>

        <div class="row" >
            <div class="col-lg-5" style="background-image: url(./assets/media//bg/granfonn0000.jpg); padding-top: 3px;padding-bottom: 3px"></div>
            <div class="col-lg-3" style="padding-top: 10px;padding-bottom: 10px">                <button type="button" data-dismiss="modal" class="btn btn-block btn-secondary btn-hover-brand">Cancelar</button>
            </div>


            <div class="col-lg-4 " style="background-image: url(./assets/media//bg/granfonn0000.jpg); padding-top: 10px;padding-bottom: 3px">

                <button class="btn btn-sm btn-danger btn-block " type="submit"> <i class="flaticon2-cross "></i> Rechazar </button>
            </div>
        </div>
    </div>
          <?php echo '</form>'; ?>
</div>
