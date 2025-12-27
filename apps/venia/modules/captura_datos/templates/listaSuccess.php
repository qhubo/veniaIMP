<?php $modulo = $sf_params->get('module'); ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-list-1 text-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                HISTORIAL DE VISITAS <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  </strong>
                </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-sm btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin kt-datatable" id="html_table" width="100%">
            <tr>
                <th><font size="-2"> Fecha </font></th>
                <th><font size="-2">Establecimiento</font> </th>
                <th><font size="-2">Tipo</font></th>
                <th><font size="-2">Telefono</font></th>
                <th><font size="-2">Municipio</font></th>
                <th><font size="-2">Usuario</font></th>
            </tr>
            <?php foreach ($registros as $lista) { ?>
                <tr>
              <td><font size="-2"> <?php echo $lista->getFechaVisita('d/m/Y'); ?></font></td>
              <td><font size="-2"> <?php echo $lista->getEstablecimiento(); ?></font></td>
              <td><font size="-2"> <?php echo $lista->getTipo(); ?></font></td>
              <td><font size="-2"> <?php echo $lista->getTelefono(); ?></font></td>
              <td><font size="-2"> <?php echo $lista->getMunicipio(); ?></font></td>
              <td><font size="-2"> <?php echo $lista->getUsuario(); ?></font></td>

                </tr>
            <?php } ?>

        </table>

    </div>
</div>