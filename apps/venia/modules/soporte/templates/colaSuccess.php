
<style>
* {
  box-sizing: border-box;
}

.box {
  float: left;
  width: 50%;

}

</style>
<?php $color[1]="#263663"; ?>
<?php $color[2]="#19AD07"; ?>
<?php $color[3]="#E9E752"; ?>
<?php $color[4]="#E50A07"; ?>
<?php $color[5]="#070CAD"; ?>
<?php $color[5]="#AA07AD"; ?>

<?php $numero= rand(1,5); ?>
<?php $valor = $color[$numero]; ?>
<?php if (count($registros)>0) { ?>

    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="false">
        <div class="box">
            <a href="<?php echo url_for('cola_solicitud/index') ?>">
        <img alt="Logo" width="45px" src="./images/alerta.png">
            </a>
        </div>
        <div class="box" style="padding:5px;">
            <br>
            <font size="+1" color="<?php echo $valor; ?>"><strong> <?php echo count($registros); ?></strong> </font>    
        </div>
    </div>
    
    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-328px, 5px, 0px);">


        <div class="tab-content">
            <div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">
                <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll ps ps--active-y" data-scroll="true" data-height="200" data-mobile-height="200" style="height: 200px; overflow: hidden;">

                    <?php foreach ($registros as $regi) { ?>
                        <?php $id = $regi->getId(); ?>
                        <?php $token = sha1($regi->getCodigo()); ?>  

                        <a href="<?php echo url_for('cola_solicitud/index') ?>" class="kt-notification__item">
                            <div class="kt-notification__item-icon">
                                <i class="flaticon2-bell-alarm-symbol kt-font-info"></i>
                            </div>
                            <div class="kt-notification__item-details">
                                <div class="kt-notification__item-title">
                                    <strong> <?php echo $regi->getCodigo(); ?> </strong>
                                </div>
                                <div class="kt-notification__item-time">
                                    <?php echo $regi->getFecha('d/m'); ?>  <?php echo $regi->getCreatedAt('H:i'); ?>
                                </div>
                            </div>
                        </a>
                    <?php } ?>


                </div>
            </div>
        </div>
    </div>

<?php } ?>