
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .sin-borde td {
            border: none;
            padding: 3px;
        }

        .borde td, .borde th {
            border: 1px solid #000;
            padding: 5px;
        }

        .titulo {
            font-size: 40px;
            font-weight: bold;
        }

        .negrita {
            font-weight: bold;
        }

        .centrado {
            text-align: center;
        }

        .derecha {
            text-align: right;
        }

        .logo {
            width: 120px;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .espacio {
            height: 10px;
        }
    </style>

<!-- ================= ENCABEZADO ================= -->
<table class="sin-borde">
    <tr>
        <td width="20%" style="text-align:center;">
  
        </td>
        <td width="65%" style="text-align:center;">
            <span class="titulo" style="display:block"><?php echo $orden->getEmpresa()->getNombre(); ?></span><br>
            <span style="display:block">RUC: <?php echo $orden->getEmpresa()->getTelefono(); ?></span><br>
            <span style="display:block">Teléfono: <?php echo $orden->getEmpresa()->getContactoTelefono(); ?></span><br>
            <span style="display:block"><?php echo $orden->getEmpresa()->getDireccion(); ?></span>
        </td>
        <td width="15%" class="borde">
            <table width="100%">
                <tr>
                    <td class="negrita">PEDIDO No.</td>
                </tr>
                <tr>
                    <td class="centrado titulo"><?php echo $orden->getCodigo(); ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div class="espacio" style="text-align: right; font-size: 28px;"> Fecha Impresión <?php echo date('d/m/Y'); ?> <hr></div>



<!-- ================= SEGUNDO ENCABEZADO ================= -->
<table >
    <tr>
        <td class="negrita" style="width:120px; height: 18px;">Fecha</td>
        <td style="width:350px;"><?php echo $orden->getFecha('d/m/Y'); ?></td>
          <td class="negrita" style="width:120px;">Código Cliente</td>
        <td><?php echo $orden->getCliente()->getCodigo(); ?></td>
     
    </tr>
    <tr>
         <td class="negrita" style="width:120px; height: 18px;">Cliente</td>
        <td style="width:350px;"><?php echo $orden->getCliente()->getNombre(); ?>.</td>
    </tr>
    <tr>
        <td class="negrita" style="width:120px; height: 18px;" >Dirección </td>
        <td colspan="3" style="width:350px;"><?php echo $orden->getCliente()->getDireccion(); ?></td>
    </tr>
    <tr>
        <td class="negrita" style="width:120px;  ">Acuerdo de Pago</td>
        <td  style="width:350px;">Crédito 30 días</td>
        <td class="negrita" style="width:120px;">Vendedor</td>
        <td><?php if ($orden->getVendedorId()) { echo $orden->getVendedor()->getNombre(); } ?></td>
    </tr>
    <tr>
        <td class="negrita" style="width:120px;">País</td>
        <td style="width:350px;"><?php echo $orden->getCliente()->getPais(); ?></td>
        <td class="negrita" style="width:120px;">Teléfono</td>
        <td><?php echo $orden->getCliente()->getTelefono(); ?></td>
    </tr>
</table>

<div class="espacio"></div>

<!-- ================= DETALLE ================= -->
<table>
    <thead>
        <tr class="centrado" style="background-color:#F2F2F2">
            <th style="width:30px;font-size: 30px; border-top: 1px solid #000; border-left: 1px solid #000;">No</th>
            <th  style="width:90px;font-size: 30px; border-top: 1px solid #000;">Código</th>
            <th  style="width:230px;font-size: 30px; border-top: 1px solid #000;">Descripción</th>
            <th  style="width:90px;font-size: 30px; border-top: 1px solid #000;">Marca</th>
            <th  style="width:100px;font-size: 30px; border-top: 1px solid #000;">Características</th>
            <th  style="width:60px;font-size: 30px; border-top: 1px solid #000;">Cantidad</th>
            <th  style="width:75px;font-size: 30px; border-top: 1px solid #000;">Precio</th>
            <th  style="width:75px;font-size: 30px; border-top: 1px solid #000; border-right: 1px solid #000;">Total</th>
        </tr>
    </thead>
    <tbody>
 <?php $can=0; ?>
 <?php $totalPeso=0; ?>
 <?php $totalMetros=0; ?>
 <?php $totalUnidades=0; ?>       
 <?php foreach($lista as $regist) { ?>
     <?php $can++; ?>
<?php $pro=$regist->getProducto(); ?>
 <?php $totalPeso=$totalPeso+$regist->getProducto()->getPeso(); ?>
 <?php $totalMetros=$totalMetros+ ( ($pro->getAlto() *$pro->getAncho()*$pro->getLargo()) * $regist->getCantidad()) ; ?>
 <?php $totalUnidades=$totalUnidades+$regist->getCantidad(); ?>       
        <tr>
            <td style="width:30px; font-size: 30px; border-top: 1px solid #000; border-left: 1px solid #000;" class="centrado"><?php echo $can; ?></td>
            <td style="width:90px;font-size: 30px; border-top: 1px solid #000;" ><?php echo $regist->getCodigo(); ?></td>
            <td style="width:230px;font-size: 30px; border-top: 1px solid #000;"><?php echo $regist->getDetalle(); ?></td>
            <td class="centrado" style="width:90px;font-size: 30px; border-top: 1px solid #000;"><?php echo $regist->getProducto()->getMarcaProducto(); ?></td>
            <td style="width:100px;font-size: 30px; border-top: 1px solid #000;"><?php echo $regist->getProducto()->getCaracteristica(); ?></td>
            <td style="width:60px;font-size: 30px; border-top: 1px solid #000;" class="centrado"><?php echo $regist->getCantidad(); ?></td>
            <td style="width:75px;font-size: 30px; border-top: 1px solid #000;" class="derecha"><?php echo $regist->getValorUnitario(); ?></td>
            <td style="width:75px;font-size: 30px; border-top: 1px solid #000; border-right: 1px solid #000;" class="derecha"><?php echo $regist->getValorTotal(); ?></td>
        </tr>
   <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" class="derecha negrita" style=" border-top: 1px solid #000;"></td>
            <td class="derecha negrita" style=" border-top: 1px solid #000;"></td>
        </tr>
    </tfoot>
</table>



<table class="sin-borde" >
    <tr>
        <td style="width: 470px;">
            
            <table>
                <tr>
                    <td class="negrita" style="width:130px;"> Metros Cúbicos</td>
                    <td style="text-align: right;width:100px;"><?php echo round($totalMetros,2); ?></td>
                </tr>
                  <tr>
                    <td class="negrita"> Kilogramos</td>
                    <td style="text-align: right;"><?php echo round($totalPeso,2); ?></td>
               
                </tr>
                 <tr>
                    <td class="negrita"> Unidades</td>
                    <td style="text-align: right;"><?php echo round($totalUnidades,2); ?></td>
                </tr>
            </table>
            <BR>
                 <BR>
            <?php echo $totalImprime; ?>
            
        </td>
        <td style="width: 400px;">
              <table>
                <tr>
                    <td class="negrita" style="height: 18px;"> Subtotal</td>
                    <td style="text-align: right;"><?php echo Parametro::formato($orden->getValorTotal()); ?></td>
                    <td style="text-align: right;"></td>
                </tr>
                   <tr>
                    <td class="negrita" style="height: 18px;"> (+) Impuesto</td>
                    <td style="text-align: right;">$ 0.00</td>
                    <td style="text-align: right;"></td>
                </tr>
                   <tr>
                    <td class="negrita" style="height: 18px;"> (+) Recarga</td>
                    <td style="text-align: right;">$ 0.00</td>
                    <td style="text-align: right;"></td>
                </tr>
                   <tr>
                    <td class="negrita" style="height: 18px;"> (-) Descuento</td>
                    <td style="text-align: right;">$ 0.00</td>
                    <td style="text-align: right;"></td>
                </tr>
                   <tr>
                       <td class="negrita" style="font-size:38px; height: 18px; border-top: 1px solid #000;"> TOTAL</td>
                    <td style="font-size:38px;text-align: right; border-top: 1px solid #000;"><?php echo Parametro::formato($orden->getValorTotal()); ?></td>
                    <td style="text-align: right;"></td>
                </tr>
            </table>
            
        </td>

    </tr>
    
</table>