<div style="width: 100px;" class="fileinput fileinput-new <?php if ($form['imagen']->hasError()) echo "has-error" ?>"  data-provides="fileinput">
    <div class="fileinput-new thumbnail" style="width: 100px; ">
        <?php echo html_entity_decode($url); ?>
    </div>
    <div class="fileinput-preview fileinput-exists thumbnail"  style="width: 100px" > </div>
    <div class="row">
        <div class="col-md-12">
            <span class="btn btn-xs blue-steel btn-file">
                    <span class="fileinput-new"><font size="-2"> Seleccione  (Medida 300px X 300px)</font> <li class="fa fa-image"></li>  </span>
                <span class="fileinput-exists"><font size="-2"> Cambiar</font>  </span>
                <input type="file" name="consulta[imagen]"  id="consulta_imagen"> </span>
            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"><font size="-2"> Remover</font>  </a>
        </div>
    </div>
    <span class="help-block form-error">
        <?php echo $form['imagen']->renderError() ?>
    </span>

</div>