<?php if ($sf_user->hasFlash("error")) : ?>
    <div class="kt-section">
        <div class="kt-section__content">
            <div class="alert alert-danger" role="alert">
                <strong>Alerta!</strong>&nbsp;<?php echo "ALERTA"; ?>
                <div class="alert-text">&nbsp;&nbsp; <?php echo ($sf_user->getFlash("error")); ?></div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($sf_user->hasFlash("exito")) : ?>
    <br>
    <div class="kt-section">
        <div class="kt-section__content">
            <div class="alert alert-info" role="alert">
                <b><strong>Exito!</strong>&nbsp;</b>
                <div class="alert-text">&nbsp;&nbsp; <?php echo ($sf_user->getFlash("exito")); ?></div>
            </div>
        </div>
    </div>
    <br>
<?php endif; ?>
<?php if ($sf_user->hasFlash("guardar")) : ?>
    <br>
    <div class="kt-notes__info">
        <div class="row">

            <div class="col-lg-12 kt-badge kt-badge--success kt-badge--inline fade show " role="alert">
                <button data-dismiss="alert" class="close"></button>
                <strong>Exito!</strong>&nbsp;<?php echo 'Información almacenada con éxito'; ?><?php echo $sf_user->getFlash("guardar"); ?>
            </div>
        </div>
    </div>
    <br>
<?php endif; ?>
<?php if ($sf_user->hasFlash("eliminar")) : ?>
    <div class="kt-section">
        <div class="kt-section__content">
            <div class="alert alert-danger" role="alert">
                <strong>Alerta!</strong>&nbsp;<?php echo  'Información  eliminada con éxito'; ?>
                <div class="alert-text"></div><?php echo $sf_user->getFlash("eliminar"); ?>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php if ($sf_user->hasFlash("alerta")) : ?>
    <div class="kt-section">
        <div class="kt-section__content">
            <div class="alert alert-warning" role="alert">
                <strong>Alerta!</strong>&nbsp;
                <div class="alert-text">&nbsp;&nbsp; <?php echo ($sf_user->getFlash("alerta")); ?></div>
            </div>
        </div>
    </div>
<?php endif; ?>