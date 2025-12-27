<?php
$campoUsuario = ValorUsuarioQuery::create()
        ->filterByTipoDocumento($tipoDocumento)
        ->filterByNoDocumento($idDoc)
        ->find();
?>
                <?php foreach($campoUsuario as $campo) { ?>
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-2"></DIV>
                        <div class="col-lg-6"><strong><?php echo $campo->getNombreCampo(); ?></strong></div>
                        <div class="col-lg-4"><?php echo $campo->getValor(); ?></div>
                    </div>                    
                </div>
                <?php } ?>