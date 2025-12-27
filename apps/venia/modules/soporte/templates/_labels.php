 
<?php  $idioma = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'idioma'); ?>
<?php if ($idioma==1) { ?>
 <?php include_partial('soporte/espanol') ?> 
<?php } else { ?>
 <?php include_partial('soporte/ingles') ?> 
<?php  } ?>