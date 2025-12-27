
<style>
* {
  box-sizing: border-box;
}

.box {
  float: left;
  width: 50%;

}

</style>
<?php $color[1]="#B7FAFA"; ?>
<?php $color[2]="#FAFC9E"; ?>
<?php $color[3]="#9EF79E"; ?>
<?php $color[4]="#ECCFF8"; ?>
<?php $color[5]="#61CFE5"; ?>
<?php $color[5]="#F7FBFB"; ?>
<?php $color[6]="#0C0C0C"; ?>
<?php $color[7]="#7AB6F9"; ?>
<?php $color[8]="#F4ECA6"; ?>
<?php $numero= rand(1,8); ?>
<?php $valor = $color[$numero]; ?>
<?php $can=0; ?>
    <?php foreach($registros as $reg) { ?>
         
                <?php $pendientes = OrdenCotizacionDetalleQuery::create()
                        ->filterByVerificado(false)
                        ->filterByOrdenCotizacionId($reg->getOrdenCotizacionId())
                        ->count(); ?>

<?php if ($pendientes ==0) {  ?>
<?php $can++; ?>
<?php } ?>
    <?php }  ?>
<?php if ($can>0) { ?>

    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="false">
        <div class="box" style="padding-top:3px;">
            <a href="<?php echo url_for('bodega_confirmo/index') ?>">
        <img alt="Logo" width="45px" src="./images/warning-icon.png">
            </a>
        </div>
        <div class="box" style="padding-top:1px; padding-left: 7px;">
            <br>
                           <span style="background-color: #F64E60 !important; padding-bottom: 5px; padding-top: 5px; padding-left: 8px; padding-right:  8px;">  
                               <font size="+1" color="<?php echo $valor; ?>"><strong> <?php echo $can; ?></strong> </font>    
                           </span>
        </div>
    </div>
    
    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-328px, 5px, 0px);">


        <div class="tab-content">
            <div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">
                <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll ps ps--active-y" data-scroll="true" data-height="200" data-mobile-height="200" style="height: 200px; overflow: hidden;">

                   <?php foreach($registros as $reg) { ?>
                    <?php $regi=$reg->getOrdenCotizacion(); ?>
                <?php $pendientes = OrdenCotizacionDetalleQuery::create()
                        ->filterByVerificado(false)
                        ->filterByOrdenCotizacionId($reg->getOrdenCotizacionId())
                        ->count(); ?>
<?php if ($pendientes ==0) {  ?>
              
                        <a href="<?php echo url_for('bodega_confirmo/index') ?>" class="kt-notification__item">
                            <div class="kt-notification__item-icon">
                                <i class="flaticon2-bell-alarm-symbol kt-font-info"></i>
                            </div>
                            <div class="kt-notification__item-details">
                                <div class="kt-notification__item-title">
                                    <strong> <?php echo $regi->getCodigo(); ?> </strong>
                                </div>
                                <div class="kt-notification__item-time">
                                    <?php echo $regi->getFecha('d/m'); ?>  <?php echo $regi->getFecha('H:i'); ?>
                                </div>
                            </div>
                        </a>
                    <?php  } ?>
         <?php } ?>


                </div>
            </div>
        </div>
    </div>

<?php } ?>