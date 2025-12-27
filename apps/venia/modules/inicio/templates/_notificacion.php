
<?php  $TIPO_USUARIO=  sfContext::getInstance()->getUser()->getAttribute("tipoUsuario", null, 'seguridad'); ?>
<?php    //$usuarioa=sfContext::getInstance()->getUser()->getAttribute("usuarioNombre",null, 'seguridad');       ?>
<?php //if ( (strtoupper($TIPO_USUARIO) =='FACTURAR')) { ?>
<div class="kt-header__topbar-item dropdown">
     <div id="feedback-bg-info"></div>
</div>
<div class="kt-header__topbar-item dropdown">
     <div id="feedback-bg-info3"></div>
</div>

<script src="https://code.jquery.com/jquery-latest.js"></script>

<script>
$(document).ready(function() {
var refreshId = setInterval( function(){
//$('#feedback-bg-info').load('revisionCXC.php');//actualizas el div automaticamente
$('#feedback-bg-info').load('<?php echo url_for('soporte/colaBoleta' ) ?>'); 
}, 9000 );
});
</script>
<?php if ( (strtoupper($TIPO_USUARIO) =='FACTURAR')) { ?>
<script>
$(document).ready(function() {
var refreshId = setInterval( function(){
//$('#feedback-bg-info').load('revisionCXC.php');//actualizas el div automaticamente
$('#feedback-bg-info3').load('<?php echo url_for('soporte/colaPago' ) ?>'); 
}, 9000 );
});
</script>
<?php } ?>
