<?php $modulo = 'orden_cotizacion'; ?>
<?php $i = 1; ?>
<?php $estiloDos = ''; ?>
<?php $estiloUno = 'style="display:none;"'; ?>
<?php echo $forma->renderFormTag(url_for($modulo . '/manual' ), array('class' => 'form-horizontal"')) ?>
<?php echo $forma->renderHiddenFields() ?>


<div class="row">
    <div  class="col-md-1"> </div>
    <div  class="col-md-3">
      Descripción  
    </div>
    <div class="col-md-8  <?php if ($forma['nombre']->hasError()) echo "has-error" ?>">
        <?php echo $forma['nombre'] ?>          
        <span class="help-block form-error"> 
            <?php echo $forma['nombre']->renderError() ?>       
        </span>
    </div>
</div>
<div class="row">
    <div  class="col-md-1"> </div>
    <div  class="col-md-3">
      Valor Unitario 
    </div>
    <div class="col-md-4  <?php if ($forma['valor_unitario']->hasError()) echo "has-error" ?>">
        <?php echo $forma['valor_unitario'] ?>          
        <span class="help-block form-error"> 
            <?php echo $forma['valor_unitario']->renderError() ?>       
        </span>
    </div>
</div>

<div class="row">
    <div  class="col-md-1"> </div>
    <div  class="col-md-3">
      Cantidad
    </div>
    <div class="col-md-4  <?php if ($forma['cantidad']->hasError()) echo "has-error" ?>">
        <?php echo $forma['cantidad'] ?>          
        <span class="help-block form-error"> 
            <?php echo $forma['cantidad']->renderError() ?>       
        </span>
    </div>
       <div class="col-lg-2"> <br>
                <button class="btn btn-primary btn-sm " type="submit">
            <i class="  flaticon2-next"></i><i class="  flaticon2-next"></i> Agregar                </button>
            </div>
</div>


<div class="row">
    <div class="col-lg-10"></div>
 
</div>
<div class="row">
    <div class="col-lg-10"><br><br><br></div>
</div>
<?php echo '</form>'; ?>