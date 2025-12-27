[?php if ($sf_user->hasFlash('error')): ?]
  <div class="app-alerts alert alert-danger fade in">
    <button data-dismiss="alert" class="close"></button>
    <strong>Error!</strong>&nbsp;[?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?]
  </div>
[?php endif; ?]
[?php if ($sf_user->hasFlash('notice')): ?]
  <div class="alert alert-success">
    <button data-dismiss="alert" class="close"></button>
    <strong>Exito!</strong>&nbsp;[?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?]
  </div>
[?php endif; ?]