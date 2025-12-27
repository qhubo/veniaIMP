<div class="form-bodyxx">  

<?php //echo $texto; ?>

    <div class="row">
        <div  class="col-lg-2">
            Observaciones    
        </div>
        <div class="col-lg-8  <?php if ($form['observacion']->hasError()) echo "has-error" ?>">
            <?php //echo $form['observacion'] ?>  
                <textarea rows="25" cols="30" class="form-control EditorMce" name="consulta[observacion]" id="consulta_observacion"><?php echo $texto; ?></textarea>     
            <span class="help-block form-error"> 
                <?php echo $form['observacion']->renderError() ?>       
            </span>
        </div>
        <div  class="col-lg-1">  </div>
    </div>
    
    
    
</div>