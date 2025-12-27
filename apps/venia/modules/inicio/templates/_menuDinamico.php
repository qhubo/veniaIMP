
<?php $tipo_usuario = strtoupper(sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'tipo_usuario')); ?>
<?php $menus = MenuSeguridadQuery::Acceso(); ?>
<?php $tipoUsu = strtoupper(sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'tipo_usuario')); ?>
<?php $li = $menus['superiores']; ?>
<?php $permisos = $menus['opciones']; ?>
<?php $modules = $menus['modules']; ?>
<?php //$tipoUsu = 'ADMINISTRADOR';    ?>
<?php $superiors = MenuSeguridadQuery::create()->filterById($li, Criteria::IN)->filterBySuperior(0)->filterBySubMenu(false)->orderByOrden("Asc")->find(); ?>
<?php if (($tipoUsu == 'ADMINISTRADOR') or ( $tipoUsu == 'SUPERADMINISTRADOR')) { ?>
    <?php $superiors = MenuSeguridadQuery::create()->filterBySuperior(0)->filterBySubMenu(false)->orderByOrden("Asc")->find(); ?>
<?php } ?>
<?php $submenu = false; ?>
<div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
<!--    <a class="kt-aside-toggler kt-aside-toggler--left" href="<?php echo url_for('inicio/index') ?>" id="kt_aside_toggler"><span></span></a>-->

    <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile "  >
        <ul class="kt-menu__nav ">
            <?php foreach ($superiors as $reg) { ?>
                <?php $hijos = MenuSeguridadQuery::create()->filterBySubMenu(false)->orderByOrden("Asc")->filterBySuperior($reg->getId())->find(); ?>
                <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                    <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text"><?php echo $reg->getIcono(); ?><?php echo $superior = $reg->getDescripcion(); ?></span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                        <ul class="kt-menu__subnav">


                            <?php foreach ($hijos as $data) { ?>
                                <?php $valido = false; ?>
                                <?php $modu = $data->getModulo(); ?>
                                <?php if (array_key_exists($modu, $permisos)) { ?>
                                    <?php $valido = true; ?>
                                <?php } ?> 
                                <li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo url_for($modu . '/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text"><?php echo $data->getDescripcion(); ?></span></a></li>
                            <?php } ?>   
                            <?php
                            $submenus = MenuSeguridadQuery::create()
                                    ->filterByModulo('')
                                    ->filterBySubMenu(true)
                                    ->orderByOrden("Asc")
                                    ->filterBySuperior($reg->getId())
                                    ->find();
                            ?>
                                
                         
                                
                                
                            <?php foreach ($submenus as $sub) { ?>
                                           <?php
                            $subValido = MenuSeguridadQuery::create()
                                    ->filterByModulo($modules, Criteria::IN)
                                    ->filterBySuperior($sub->getId())
                                    ->count();
                            ?>
                                <?php if ($subValido >0 ) { ?>
        <?php $hijos2 = MenuSeguridadQuery::create()->filterBySubMenu(false)->orderByOrden("Asc")->filterBySuperior($sub->getId())->find(); ?>
                                <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--hover" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                    <?php echo $sub->getDescripcion(); ?>
                                        <i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                        <ul class="kt-menu__subnav">
        <?php foreach ($hijos2 as $data2) { ?>
                                                <?php $modu = $data2->getModulo(); ?>
                                           
                                                   <?php $valido = false; ?>
                          
                                <?php if (array_key_exists($modu, $permisos)) { ?>
                                    <?php $valido = true; ?>
                                <?php } ?> 
                                            
                                            <?php if ($valido) { ?>
                                                <li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo url_for($modu . '/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                                        <span class="kt-menu__link-text">
                                                    <?php echo $data2->getDescripcion(); ?>
                                                        </span></a></li>
                                            <?php } ?>

        <?php } ?>
                                        </ul>
                                    </div>
                                </li>
 <?php } ?>
    <?php } ?>
                        </ul>
                    </div>                     
                </li>
<?php } ?>


        </ul>
    </div>
</div>
