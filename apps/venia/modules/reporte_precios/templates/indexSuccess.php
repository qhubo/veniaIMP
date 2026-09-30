<?php $modulo=$sf_params->get('module'); ?>
<?php $usuarioId=sfContext::getInstance()->getUser()->getAttribute('usuario',null,'seguridad'); ?>
<?php $usuarioQ=UsuarioQuery::create()->findOneById($usuarioId); ?>
<?php $TIPO_USUARIO=strtoupper($usuarioQ->getTipoUsuario()); ?>

<style>
#html_table{width:100%!important;white-space:nowrap}
#html_table th,#html_table td{white-space:nowrap!important;vertical-align:middle!important}
#html_table th{text-align:center}
#html_table td{font-size:13px}
#html_table td:nth-child(2){white-space:normal!important;min-width:250px}
.table-responsive{overflow-x:auto;width:100%}
#html_table tbody tr.child{display:none!important}
</style>
<style>
#html_table{
    width:100%!important;
    white-space:nowrap;
    border-collapse:separate;
    border-spacing:0;
}

#html_table th{
    background:#198754!important;
    color:#fff!important;
    font-weight:600;
    text-align:center;
    vertical-align:middle!important;
    border-color:#157347!important;
    padding:10px 8px!important;
}

#html_table td{
    white-space:nowrap!important;
    vertical-align:middle!important;
    padding:8px!important;
    border-color:#dee2e6!important;
    font-size:13px;
}

#html_table td:nth-child(2){
    white-space:normal!important;
    min-width:250px;
}

#html_table tbody tr:nth-child(even){
    background:#f3faf6!important;
}

#html_table tbody tr:hover{
    background:#dff3e7!important;
}

#html_table td:nth-child(3){
    font-weight:600;
    text-align:right;
}

#html_table td:nth-child(n+4){
    text-align:right;
}

.table-responsive{
    overflow-x:auto;
    width:100%;
    border:1px solid #d8e8df;
    border-radius:4px;
}

#html_table tbody tr.child{
    display:none!important;
}

#html_table .precio{
    color:#198754;
    font-weight:600;
}
</style>

<style>
.btn-excel{
    background:#198754!important;
    border:1px solid #157347!important;
    color:#fff!important;
    font-weight:600;
    padding:7px 16px!important;
    border-radius:4px!important;
    box-shadow:0 2px 4px rgba(0,0,0,.12);
    transition:all .2s ease;
}

.btn-excel:hover{
    background:#157347!important;
    border-color:#146c43!important;
    color:#fff!important;
    box-shadow:0 3px 6px rgba(0,0,0,.18);
    text-decoration:none;
}

.btn-excel i{
    margin-right:5px;
}
</style>
<style>
.reporte-help{
    display:flex;
    align-items:flex-start;
    gap:8px;
    margin-top:7px;
    padding:8px 10px;
    border-radius:4px;
    font-size:12px;
    line-height:17px;
}

.reporte-help i{
    font-size:15px;
    margin-top:1px;
}

.reporte-help-green{
    background:#e8f6ef;
    border:1px solid #b7dfc8;
    color:#176b3a;
}

.reporte-help-green i{
    color:#198754;
}

.reporte-help-blue{
    background:#eef5ff;
    border:1px solid #c9ddf7;
    color:#285b8f;
}

.reporte-help-blue i{
    color:#337ab7;
}

.reporte-help strong{
    font-weight:600;
}

.btn-consultar-precios{
    min-width:110px;
    font-weight:600;
}
</style>


<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-list-2 kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                REPORTE DE PRECIOS
                <small>&nbsp;&nbsp;&nbsp;Precios actuales de productos con existencia</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="actions">
          <a class="btn btn-excel"
   target="_blank"
   href="<?php echo url_for($modulo.'/reporte'); ?>">
    <i class="fa fa-file-excel-o"></i> Excel
</a>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">

<?php echo $form->renderFormTag(url_for($modulo.'/index'),array('class'=>'form-horizontal')); ?>
<?php echo $form->renderHiddenFields(); ?>

<div class="row" style="padding-top:5px;padding-bottom:15px;">

    <label class="col-lg-1 control-label right">
        Producto
    </label>

    <div class="col-lg-4 <?php if($form['nombrebuscar']->hasError()) echo 'has-error'; ?>">
        <?php echo $form['nombrebuscar']; ?>

        <span class="help-block form-error">
            <?php echo $form['nombrebuscar']->renderError(); ?>
        </span>

        <div class="reporte-help reporte-help-blue">
            <i class="fa fa-search"></i>
            <span>
                Puede buscar por código SKU o nombre del producto.
            </span>
        </div>
    </div>


    <label class="col-lg-1 control-label right">
        Precios
    </label>

    <div class="col-lg-3 <?php if($form['tipoprecio']->hasError()) echo 'has-error'; ?>">

        <?php echo $form['tipoprecio']; ?>

        <span class="help-block form-error">
            <?php echo $form['tipoprecio']->renderError(); ?>
        </span>

        <div class="reporte-help reporte-help-green">
            <i class="fa fa-info-circle"></i>

            <div>
                <strong>Selección de precios</strong><br>
                Mantenga presionada la tecla <strong>Ctrl</strong> y haga clic
                sobre los precios que desea incluir en el reporte.
            </div>
        </div>

    </div>


    <div class="col-lg-2" style="padding-top:0;">

        <button class="btn btn-sm btn-success btn-consultar-precios" type="submit">
            <i class="fa fa-search"></i>
            Consultar
        </button>

    </div>

</div>

<?php echo '</form>'; ?>

        <div class="row" style="padding-bottom:10px;">
            <div class="col-lg-10"></div>
            <div class="col-lg-2">
                <div class="kt-input-icon kt-input-icon--left">
                    <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                        <span><i class="la la-search"></i></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="table-responsive">

            <table class="table table-striped table-bordered table-hover no-footer"
                   id="html_table"
                   width="100%">

                <thead>
                    <tr class="info">
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Existencia</th>

                        <?php foreach($precios as $precio) { ?>
                            <th><?php echo $precio['nombre']; ?></th>
                        <?php } ?>

                    </tr>
                </thead>

                <tbody>

                    <?php foreach($registros as $data) { ?>

                        <tr>

                            <td><?php echo $data['codigo_sku']; ?></td>

                            <td><?php echo $data['nombre']; ?></td>

                            <td style="text-align:right;">
                                <?php echo number_format($data['existencia'],0,'.',','); ?>
                            </td>

                            <?php foreach($precios as $precio) {

                                $campo=($precio['id']==='PRECIO')
                                    ? 'precio_PRECIO'
                                    : 'precio_'.$precio['id'];

                                $valor=isset($data[$campo])
                                    ? $data[$campo]
                                    : null;
                            ?>

                                <td style="text-align:right;">
                                    <?php
                                    if($valor!==null && $valor!==''){
                                        echo Parametro::formato($valor);
                                    }
                                    ?>
                                </td>

                            <?php } ?>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<script>
$(document).ready(function(){
    $("#generalSearch").on("keyup",function(){
        var value=$(this).val().toLowerCase();
        $("#html_table tbody tr").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1);
        });
    });
});
</script>