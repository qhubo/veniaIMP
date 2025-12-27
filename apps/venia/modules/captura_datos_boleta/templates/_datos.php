<?php echo $form->renderFormTag(url_for($modulo . '/index?id=' . $id), array('class' => 'form-horizontal"')) ?>
<?php echo $form->renderHiddenFields() ?>

<div class="row " style='padding-top:1px;'>

    <div class="col-lg-2 titulo" >Banco </div>
    <div class="col-lg-9 <?php if ($form['banco_id']->hasError()) echo "has-error" ?>">
        <?php echo $form['banco_id'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['banco_id']->renderError() ?>  
        </span>
    </div>
</div>      


<div class="row " style='padding-top:1px;'>

    <div class="col-lg-2 titulo" >Tienda </div>
    <div class="col-lg-9 <?php if ($form['tienda_id']->hasError()) echo "has-error" ?>">
        <?php echo $form['tienda_id'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['tienda_id']->renderError() ?>  
        </span>
    </div>
</div>

<div class="row " style='padding-top:1px;'>
   
    <div class="col-lg-2 titulo" >Vendedor </div>
    <div class="col-lg-9 <?php if ($form['vendedor']->hasError()) echo "has-error" ?>">
        <?php echo $form['vendedor'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['vendedor']->renderError() ?>  
        </span>
    </div>
</div>


<div class="row " style='padding-top:4px;'>
    
    <div class="col-lg-2 titulo" >Boleta </div>
    <div class="col-lg-4 <?php if ($form['boleta']->hasError()) echo "has-error" ?>">
        <?php echo $form['boleta'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['boleta']->renderError() ?>  
        </span>
    </div>
    <div class="col-lg-3 titulo" >Fecha Deposito </div>
    <div class="col-lg-3 <?php if ($form['fecha_deposito']->hasError()) echo "has-error" ?>">
        <?php echo $form['fecha_deposito'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['fecha_deposito']->renderError() ?>  
        </span>
    </div>

</div>



<div class="row " style='padding-top:4px;'>
 
    <div class="col-lg-2 titulo" >Total </div>
    <div class="col-lg-4 <?php if ($form['total']->hasError()) echo "has-error" ?>">
        <?php echo $form['total'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['total']->renderError() ?>  
        </span>
    </div>
</div>


<div class="row " style='padding-top:4px;'>
  
    <div class="col-lg-2 titulo" >Cliente </div>
    <div class="col-lg-10 <?php if ($form['cliente']->hasError()) echo "has-error" ?>">
        <?php echo $form['cliente'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['cliente']->renderError() ?>  
        </span>
    </div>
</div>

<div class="row " style='padding-top:4px;'>
 
    <div class="col-lg-2 titulo" >Telefono</div>
    <div class="col-lg-5 <?php if ($form['telefono']->hasError()) echo "has-error" ?>">
        <?php echo $form['telefono'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['telefono']->renderError() ?>  
        </span>
    </div>
</div>
<div class="row " style='padding-top:4px;'>

    <div class="col-lg-2 titulo" >Pieza </div>
    <div class="col-lg-4 <?php if ($form['pieza']->hasError()) echo "has-error" ?>">
        <?php echo $form['pieza'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['pieza']->renderError() ?>  
        </span>
    </div>
    <div class="col-lg-1 titulo" >Stock </div>
    <div class="col-lg-5 <?php if ($form['stock']->hasError()) echo "has-error" ?>">
        <?php echo $form['stock'] ?>           
        <span class="help-block form-error"> 
            <?php echo $form['stock']->renderError() ?>  
        </span>
    </div>

</div>


<div class="row " style='padding-top:4px;'>
    <div class="col-lg-8">       </div>
    <div class="col-lg-4" style="padding-top:10px; padding-left: 10px; ">

        <button class="btn btn-block btn-sm  btn-secondary btn-dark" " type="submit">
            <i class="flaticon2-plus "></i>
            Aceptar
        </button>

    </div>
    <div class="col-lg-2"> </div>
</div>


<?php echo "</form>"; ?>