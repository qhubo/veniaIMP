<script src='/assets/global/plugins/jquery.min.js'></script>
<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-piggy-bank"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">
                <small>Grabación de Histórico de Bancos &nbsp;&nbsp;&nbsp;&nbsp;</small>
            </h3>
        </div>

    </div>
    <div class="kt-portlet__body">
        <form action="<?php echo url_for($modulo . '/index?id=0') ?>" method="get">
            <div class="row">
                <div class="col-lg-1"> </div>
                <div class="col-lg-2">Selección Bancos </div>
                <div class="col-lg-3">
                    <select  onchange="this.form.submit()" class="form-control"  name="med" id="med">
                        <option value="">[Seleccione]</option>
                        <?php foreach ($bancos as $lista) { ?>
                            <option <?php if ($med == $lista->getId()) { ?> selected="selected"  <?php } ?>  value="<?php echo $lista->getId(); ?>"><?php echo $lista->getNombre(); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </form>
<?php if ($bancoQ) { ?>
        <div class="row">
            <div class="col-lg-12"><br> </div>
        </div>
        <div class="row">
            <div class="col-lg-6">  
                <div class="row">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-3">Fecha </div>
                    <div class="col-lg-4">
                        <input class="form-control"  data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text" name="fecha" value="<?php echo $bancoQ->getFecha('d/m/Y'); ?>" id="fecha">
                    </div>
                </div>
                <div class="row" style="padding-top: 10px;">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-4"><strong>Saldo Banco</strong> </div>
                    <div class="col-lg-6">
                        <input class="form-control" placeholder="0" value="<?php echo $bancoQ->getSaldoBanco(); ?>" onkeypress="validate(event)" type="text" name="saldob" id="saldob">
                    </div>
                </div>



                <div class="row" style="padding-top: 10px;">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-4">Deposito Transito </div>
                    <div class="col-lg-6">
                        <input class="form-control" placeholder="0" value="<?php echo $bancoQ->getDepositoTransito(); ?>" onkeypress="validate(event)" type="text" name="dt" id="dt">
                    </div>
                </div>
                <div class="row" style="padding-top: 10px;">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-4">Nota Credito Transito</div>
                    <div class="col-lg-6">
                        <input class="form-control" placeholder="0" value="<?php echo $bancoQ->getNotaCreditoTransito(); ?>" onkeypress="validate(event)" type="text" name="nct" id="nct">
                    </div>
                </div> 
                <div class="row" style="padding-top: 10px;">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-4">Cheques Circulacion </div>
                    <div class="col-lg-6">
                        <input class="form-control" placeholder="0"  value="<?php echo $bancoQ->getChequesCirculacion(); ?>" onkeypress="validate(event)" type="text" name="cc" id="cc">
                    </div>
                </div>
                <div class="row" style="padding-top: 10px;">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-4">Nota Debito Transito </div>
                    <div class="col-lg-6">
                        <input class="form-control" placeholder="0"  value="<?php echo $bancoQ->getNotaDebitoTransito(); ?>" onkeypress="validate(event)" type="text" name="ndt" id="ndt">
                    </div>
                </div>



            </div>
            <div class="col-lg-6">  
            
                  <div class="row">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-3"><br> </div>
                    <div class="col-lg-4">
                    </div>
                </div>
                
                <div class="row" style="padding-top: 10px;">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-4"><strong>Saldo Libros</strong> </div>
                    <div class="col-lg-6">
                        <input class="form-control" placeholder="0"  value="<?php echo $bancoQ->getSaldoLibros(); ?>" onkeypress="validate(event)" type="text" name="saldol" id="saldol">
                    </div>
                </div>



                <div class="row" style="padding-top: 10px;">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-4">Deposito Registrar </div>
                    <div class="col-lg-6">
                        <input class="form-control" placeholder="0" value="<?php echo $bancoQ->getDepositoRegistrar(); ?>" onkeypress="validate(event)" type="text" name="dr" id="dr">
                    </div>
                </div>
                <div class="row" style="padding-top: 10px;">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-4">Nota Credito Registrar</div>
                    <div class="col-lg-6">
                        <input class="form-control" placeholder="0" value="<?php echo $bancoQ->getNotaCreditoRegistrar(); ?>" onkeypress="validate(event)" type="text" name="ncr" id="ncr">
                    </div>
                </div> 
                <div class="row" style="padding-top: 10px;">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-4">Cheques Registrar</div>
                    <div class="col-lg-6">
                        <input class="form-control" placeholder="0" value="<?php echo $bancoQ->getChequesRegistrar(); ?>" onkeypress="validate(event)" type="text" name="cr" id="cr">
                    </div>
                </div>
                <div class="row" style="padding-top: 10px;">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-4">Nota Debito Registrar </div>
                    <div class="col-lg-6">
                        <input class="form-control" placeholder="0" value="<?php echo $bancoQ->getNotaDebitoRegistrar(); ?>" onkeypress="validate(event)" type="text" name="ndr" id="ndr">
                    </div>
                </div>

            </div>

        </div>
<?php } ?>
    </div>
</div>
<script src='/assets/global/plugins/jquery.min.js'></script>


  <script type="text/javascript">
        $(document).ready(function () {
            $("#fecha").on('change', function () {
                var id =<?php echo $med ?>;
                var val = $("#fecha").val();
                var tipo = 'fecha';
                $.get('<?php echo url_for("historico_banco/valor") ?>', {val: val, id: id, tipo:tipo}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>
 <script type="text/javascript">
        $(document).ready(function () {
            $("#saldob").on('change', function () {
                var id =<?php echo $med ?>;
                var val = $("#saldob").val();
                var tipo = 'saldob';
                $.get('<?php echo url_for("historico_banco/valor") ?>', {val: val, id: id, tipo:tipo}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>
  <script type="text/javascript">
        $(document).ready(function () {
            $("#dt").on('change', function () {
                var id =<?php echo $med ?>;
                var val = $("#dt").val();
                var tipo = 'dt';
                $.get('<?php echo url_for("historico_banco/valor") ?>', {val: val, id: id, tipo:tipo}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>

  <script type="text/javascript">
        $(document).ready(function () {
            $("#nct").on('change', function () {
                var id =<?php echo $med ?>;
                var val = $("#nct").val();
                var tipo = 'nct';
                $.get('<?php echo url_for("historico_banco/valor") ?>', {val: val, id: id, tipo:tipo}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>

  <script type="text/javascript">
        $(document).ready(function () {
            $("#cc").on('change', function () {
                var id =<?php echo $med ?>;
                var val = $("#cc").val();
                var tipo = 'cc';
                $.get('<?php echo url_for("historico_banco/valor") ?>', {val: val, id: id, tipo:tipo}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>

  <script type="text/javascript">
        $(document).ready(function () {
            $("#ndt").on('change', function () {
                var id =<?php echo $med ?>;
                var val = $("#ndt").val();
                var tipo = 'ndt';
                $.get('<?php echo url_for("historico_banco/valor") ?>', {val: val, id: id, tipo:tipo}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>



  <script type="text/javascript">
        $(document).ready(function () {
            $("#saldol").on('change', function () {
                var id =<?php echo $med ?>;
                var val = $("#saldol").val();
                var tipo = 'saldol';
                $.get('<?php echo url_for("historico_banco/valor") ?>', {val: val, id: id, tipo:tipo}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>

  <script type="text/javascript">
        $(document).ready(function () {
            $("#dr").on('change', function () {
                var id =<?php echo $med ?>;
                var val = $("#dr").val();
                var tipo = 'dr';
                $.get('<?php echo url_for("historico_banco/valor") ?>', {val: val, id: id, tipo:tipo}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>

  <script type="text/javascript">
        $(document).ready(function () {
            $("#ncr").on('change', function () {
                var id =<?php echo $med ?>;
                var val = $("#ncr").val();
                var tipo = 'ncr';
                $.get('<?php echo url_for("historico_banco/valor") ?>', {val: val, id: id, tipo:tipo}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>

  <script type="text/javascript">
        $(document).ready(function () {
            $("#cr").on('change', function () {
                var id =<?php echo $med ?>;
                var val = $("#cr").val();
                var tipo = 'cr';
                $.get('<?php echo url_for("historico_banco/valor") ?>', {val: val, id: id, tipo:tipo}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>
 
   <script type="text/javascript">
        $(document).ready(function () {
            $("#ndr").on('change', function () {
                var id =<?php echo $med ?>;
                var val = $("#ndr").val();
                var tipo = 'ndr';
                $.get('<?php echo url_for("historico_banco/valor") ?>', {val: val, id: id, tipo:tipo}, function (response) {
                    var respuestali = response;
                      });
            });
        });
 </script>


