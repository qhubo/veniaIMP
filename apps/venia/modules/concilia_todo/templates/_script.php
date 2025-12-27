<!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>


} );

</script>
    <?php $fecha= str_replace("-", "", $fecha); ?>

<?php foreach ($bancos as $banco) { ?>
    <?php $i = $banco->getId(); ?>


    <script type="text/javascript">
     
          $( "#target<?php echo $i; ?>" ).on( "click", function() {
                var id = $("#totalbanco<?php echo $i; ?>").val();
                var idv = <?php echo $banco->getId(); ?>;
                var fecha=<?php echo $fecha; ?>;
                $.get('<?php echo url_for("concilia_banco/concilia") ?>', {fecha:fecha, id: id, idv: idv}, function (response) {
                    var respuestali = response;
                    var arr = respuestali.split('|');
                    var conciliado = arr[0];
                    var diferencia = arr[1];
                      var diferencial = arr[2];
                    $("#totalconcilia<?php echo $i; ?>").val(conciliado);
                    $("#totaldiferencia<?php echo $i; ?>").val(diferencia);
                    $("#diferencial<?php echo $i; ?>").val(diferencial);
                    $("#actu<?php echo $i; ?>").show( "slow" );              
                });

            });

   
    </script>


    <script type="text/javascript">
        $(document).ready(function () {
            $('#activar<?php echo $i ?>').click(function () {
                var valorId = $(this).attr('dat');
                var vivi = $(this).attr('vivi');
                $.ajax({
                    type: 'GET',
                    url: '/venia_dev.php/concilia_todo/check',
                    data: {'id': valorId, 'vivi': vivi},
                    success: function (data) {
                        $('#totalv').html(data);
                    }
                });
                $('#activar0').hide();
                $('#lin<?php echo $i ?>').css('background', '#D7ECEA');

                $('#bNtactiva<?php echo $i ?>').slideToggle(250);
                $('#btactiva<?php echo $i ?>').hide();
                $('#bNtlista<?php echo $i ?>').slideToggle(250);
                $('#btlista<?php echo $i ?>').hide();

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#Nactivar<?php echo $i ?>').click(function () {
                var valorId = $(this).attr('dat');
                var vivi = $(this).attr('vivi');
                $.ajax({
                    type: 'GET',
                    url: '/venia_dev.php/concilia_todo/uncheck',
                    data: {'id': valorId, 'vivi': vivi},
                    success: function (data) {
                        $('#totalv').html(data);
                    }
                });
                $('#lin<?php echo $i ?>').css('background', 'white');
                $('#activar0').slideToggle(250);
                $('#btactiva<?php echo $i ?>').slideToggle(250);
                $('#bNtactiva<?php echo $i ?>').hide();
                $('#btlista<?php echo $i ?>').slideToggle(250);
                $('#bNtlista<?php echo $i ?>').hide();
            });
        });
    </script>




    <script type="text/javascript">
        $(document).ready(function () {
            $("#totalbanco<?php echo $i; ?>").on('change', function () {
                var id = $("#totalbanco<?php echo $i; ?>").val();
                var idv = <?php echo $banco->getId(); ?>;
                var fecha=<?php echo $fecha; ?>;
                $.get('<?php echo url_for("concilia_banco/concilia") ?>', {fecha:fecha, id: id, idv: idv}, function (response) {
                    var respuestali = response;
                    var arr = respuestali.split('|');
                    var conciliado = arr[0];
                    var diferencia = arr[1];
                      var diferencial = arr[2];
                    $("#totalconcilia<?php echo $i; ?>").val(conciliado);
                    $("#totaldiferencia<?php echo $i; ?>").val(diferencia);
                    $("#diferencial<?php echo $i; ?>").val(diferencial);
                });

            });

        });
    </script>
    
    <div class="modal fade" id="ajaxmodal<?php echo $i ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
     role="dialog" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel6">Detalle Partida</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<?php } ?>

<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.mi-selector').select2();
        });
    });
</script>





<!--<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>-->




