<?Php $tipoDocumento = "Cliente"; ?>
<?php $tipo[] = $tipoDocumento ?>
<?php $tipo[] = ""; ?>
<?php $IdOPV = sfContext::getInstance()->getUser()->getAttribute('ClienteId', null, 'seguridad'); ?>
<?php
$campoUsuario = CampoUsuarioQuery::create()
        ->filterByTipoDocumento($tipo, Criteria::IN)
        ->filterByActivo(true)
        ->orderByOrden("Asc")
        ->find();
?>

<div class="row">
    <div class="col-lg-10">
        
<div class="row" style="background-color:#F9FBFE;border-radius: 0.0px; padding: 8px">
    <input  type="hidden" value="<?php echo $tipoDocumento; ?> "  name="val_tipo" id="val_tipo" >

    <?php foreach ($campoUsuario as $registro) { ?>
        <div class="col-lg-1"></div>
        <div class="col-lg-2"><?php echo $registro->getNombre(); ?></div>
        <div class="col-lg-3">
            <input  type="hidden" value="<?php echo $registro->getId(); ?> "  name="val_<?php echo $registro->getId() ?>" id="val_<?php echo $registro->getId() ?>" >

            <?php if ($registro->getTipoCampo() == "texto") { ?>
            <input class="form-control" value="<?php echo Parametro::ValorCampo($registro->getId(), $tipoDocumento, $IdOPV); ?>"   name="reg_<?php echo $registro->getId() ?>" id="reg_<?php echo $registro->getId() ?>" >
            <?php } ?>
            <?php if ($registro->getTipoCampo() == "entero") { ?>
                <input class="form-control" value="<?php echo Parametro::ValorCampo($registro->getId(), $tipoDocumento, $IdOPV); ?>" onkeypress='validate<?php echo $registro->getId() ?>(event)' type="number"   name="reg_<?php echo $registro->getId() ?>" id="reg_<?php echo $registro->getId() ?>" >

                <script>
                    function validate<?php echo $registro->getId() ?>(evt) {
                        var theEvent = evt || window.event;
                        var key = theEvent.keyCode || theEvent.which;
                        key = String.fromCharCode(key);

                        var regex = /[0-9]|\0/;
                        if (!regex.test(key)) {
                            theEvent.returnValue = false;
                            if (theEvent.preventDefault)
                                theEvent.preventDefault();
                        }
                    }
                </script>

            <?php } ?>

            <?php if ($registro->getTipoCampo() == "decimal") { ?>
                <input class="form-control" value="<?php echo Parametro::ValorCampo($registro->getId(), $tipoDocumento, $IdOPV); ?>" onkeypress='validate<?php echo $registro->getId() ?>(event)' type="number" step="any"   name="reg_<?php echo $registro->getId() ?>" id="reg_<?php echo $registro->getId() ?>" >

                <script>
                    function validate<?php echo $registro->getId() ?>(evt) {
                        var theEvent = evt || window.event;
                        var key = theEvent.keyCode || theEvent.which;
                        key = String.fromCharCode(key);

                        var regex = /[0-9]|\./;
                        if (!regex.test(key)) {
                            theEvent.returnValue = false;
                            if (theEvent.preventDefault)
                                theEvent.preventDefault();
                        }
                    }
                </script>
            <?php } ?>

            <?php if ($registro->getTipoCampo() == "fecha") { ?>
                <input class="form-control" value="<?php echo Parametro::ValorCampo($registro->getId(), $tipoDocumento, $IdOPV); ?>" data-provide="datepicker" data-date-format="dd/mm/yyyy" value="<?php echo date('d/m/Y') ?>"  type="text" name="reg_<?php echo $registro->getId() ?>" id="reg_<?php echo $registro->getId() ?>" >
            <?php } ?>
            <?php if ($registro->getTipoCampo() == "texto_largo") { ?>
                <textarea rows="3" cols="20" value="<?php echo Parametro::ValorCampo($registro->getId(), $tipoDocumento, $IdOPV); ?>" class="form-control noEditorMce" name="reg_<?php echo $registro->getId() ?>" id="reg_<?php echo $registro->getId() ?>" spellcheck="false"><?php echo Parametro::ValorCampo($registro->getId(), $tipoDocumento, $IdOPV); ?></textarea>           
            <?php } ?>
            <?php if ($registro->getTipoCampo() == "lista") { ?>
                <?php $datos = explode(",", $registro->getValores()); ?>
                <select class="form-control"  name="reg_<?php echo $registro->getId() ?>" id="reg_<?php echo $registro->getId() ?>">
                    <option value="" selected="selected">[Seleccione]</option>
 <?php $val= Parametro::ValorCampo($registro->getId(), $tipoDocumento, $IdOPV); ?>              
    <?php foreach ($datos as $li) { ?>                    
                    <option value="<?php echo $li; ?>" <?php if ($val==$li) { ?> selected="selected" <?Php } ?> ><?php echo $li; ?></option>
                    <?php } ?>
                </select>
            <?php } ?>

        </div>
    <?php } ?>
</div>

    </div>
    
</div>

<script src="./assets/vendors/general/jquery/dist/jquery.js" type="text/javascript"></script>

<?php foreach ($campoUsuario as $registro) { ?>
    <?php $id = $registro->getId(); ?>
    <script type="text/javascript">
                      $(document).ready(function () {
                          $("#reg_<?php echo $id ?>").on('change', function () {
                              var opera = <?php echo $IdOPV  ?>;
                              var tipo = $("#val_tipo").val();
                              var id =<?php echo $id ?>;
                              var valor = $("#reg_<?php echo $id ?>").val();
                              $.get('<?php echo url_for("soporte/grabaCampo") ?>', {id: id, opera: opera, valor: valor, tipo: tipo}, function (response) {
                              });
                          });

                      });
    </script>
<?php } ?>