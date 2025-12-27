 <?php $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad'); ?>
  <?php $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId); ?>
<div class="kt-header__topbar-item kt-header__topbar-item--user">
    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
        <span class="kt-header__topbar-username kt-visible-desktop">
            <font size="-2">
            
            <?php echo strtoupper($usuarioQ->getNombreCompleto()); ?>
            </font>
        </span>
                      <?php if ($usuarioQ->getImagen()) { ?>

                   <img  height="80px" xclass="kt-hidden-" alt="Pic" src="<?php echo "/uploads/milclient/" . $usuarioQ->getImagen(); ?>" />
         
  <?Php } else { ?>
                   <img height="80px"  xclass="kt-hidden-" alt="Pic" src="/images/avatar2.png" />
                <?Php } ?>
        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
    </div>
    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
        <!--begin: Head -->
        <div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
            <div class="kt-user-card__avatar">
                               <?php if ($usuarioQ->getImagen()) { ?>
                   <img   height="80px"  xclass="kt-hidden-" alt="Pic" src="<?php echo "/uploads/milclient/" . $usuarioQ->getImagen(); ?>" />
                <?Php } else { ?>
                   <img  height="80px" xclass="kt-hidden-" alt="Pic" src="/images/avatar2.png" />
                <?Php } ?>
                <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
            </div>
            <div class="kt-user-card__name">
               <?php echo $usuarioQ->getUsuario(); ?>                
               <?php echo $usuarioQ->getNombreCompleto(); ?>
            </div>
<!--            <div class="kt-user-card__badge">
                <span class="btn btn-label-primary btn-sm btn-bold btn-font-md">23 messages</span>
            </div>-->
        </div>
        <!--end: Head -->
        <?php //include_partial('inicio/menuPanel') ?>  
        <!--begin: Navigation -->
            <div class="kt-notification">
              <a class="btn btn-sm btn btn-block btn-info flaticon-lock "   href="<?php echo url_for('inicio/cambiaClave') ?>"   > 
                             Cambio de Contraseña
                       </a> 
            <a href="<?php echo url_for('inicio/perfil') ?>" class="kt-notification__item">
                <div class="kt-notification__item-icon">
                    <i class="flaticon2-calendar-3 kt-font-success"></i>
                </div>                
                <div class="kt-notification__item-details">
                    <div class="kt-notification__item-title kt-font-bold">
                       Mi Perfil
                    </div>
                </div>               
            </a>          
        </div>
        <!--end: Navigation -->
    </div>
</div>