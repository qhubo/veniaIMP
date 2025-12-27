<?php $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad'); ?>
<?php $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId); ?>   
<?php $tipoUsua=  sfContext::getInstance()->getUser()->getAttribute("tipoUsuario", null, 'seguridad'); ?>
<?php $usuarioa=sfContext::getInstance()->getUser()->getAttribute("usuarioNombre",null, 'seguridad');  ?>


<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inlin "  width="100%">
<!-- <table class="kt-datatable" id="html_table" width="100%"> -->
    <thead >
        <tr class="active">
            <th  align="center"> Fecha</th>
            <th  align="center"> Devolución</th>
            <th  align="center"> Garantia </th>
            <th  align="center">Vendedor </th>
            <th  align="center"> Hollander</th>
            <th  align="center"> Stock  </th>
            <th  align="center"> Descripción </th>
             <th  align="center"> Motivo </th>
              <th  align="center"> Status </th>
        </tr>
    </thead>
    <tbody>
 <?php foreach ($devoluciones as $devolucion) { ?>
        <?php $ordeDev = OrdenDevolucionQuery::create()->findOneBySolicitudDevolucionId($devolucion->getId()); ?>
        <?php if ($ordeDev) { ?>
        <tr>
            <td><?php echo $devolucion->getSolicitudDevolucion()->getFecha(); ?></td>
            <td><?php if ($ordeDev) echo $ordeDev->getCodigo(); ?></td>
            <td><?php echo $devolucion->getSolicitudDevolucion()->getCodigo(); ?></td>
            <td><?php if ($ordeDev) echo $ordeDev->getVendedor() ?></td>
            <td><?php echo $devolucion->getHollander(); ?></td>
            <td><?php echo $devolucion->getStock(); ?></td>
            <td><?php echo $devolucion->getDescripcion(); ?></td>
                        <td><?php echo $devolucion->getSolicitudDevolucion()->getDescripcion(); ?></td>
                   <td><?php if ($ordeDev) echo $ordeDev->getEstatus() ?></td>
            
        </tr>
        
 <?php } ?>
        
 <?php } ?>
        

    </tbody>
</table>
