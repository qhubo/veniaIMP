<table class="table table-bordered  dataTable table-condensed flip-content" >
    <tr>
        <th align="center"  >Cuenta</th>
        <th  align="center" width="150px"> Debe</th>
        <th  align="center" width="150px" > Haber</th>
        <th width="50px">Acción </th>
    </tr>
    <?php $totalDebe = $valor1; ?>
    <?php $totalHaber = $valor2; ?>
    <?php foreach ($detalle as $data) { ?>
        <?php $totalDebe = $data->getDebe() + $totalDebe; ?>
        <?php $totalHaber = $totalHaber + $data->getHaber(); ?>
        <tr>
            <td><?php echo $data->getCuentaContable(); ?> <?php echo $data->getDetalle(); ?> </td>
            <td style="text-align:right"><?php echo Parametro::formato($data->getDebe()); ?></td>
            <td style="text-align:right"><?php echo Parametro::formato($data->getHaber()); ?></td>
            <td>
                         <a href="<?php echo url_for($modulo.'/index?edit='.$data->getId()) ?>" class="btn btn-sm btn-secondary btn-dark" > <i class="flaticon-edit"></i>  </a>
            </td>

        </tr>
    <?php } ?>

    <tr>
        <td><?php echo $form['cuenta_debe'] ?></td>
        <td><?php echo $form['valor_debe'] ?></td>
        <td style="text-align:right">0.00</td>
        <td>
            <?php if ($borra==1) { ?>
           <a href="<?php echo url_for($modulo.'/elimina?edit='.$edit) ?>" class="btn btn-sm btn-danger" > <i class="flaticon-delete"></i>  </a>
            <?php } ?>
            
        </td>

    </tr>
    <tr>
        <td><?php echo $form['cuenta_haber'] ?></td>
        <td style="text-align:right">0.00</td>
        <td><?php echo $form['valor_haber'] ?></td>
        <td> 
                    <?php if ($borra==2) { ?>
           <a href="<?php echo url_for($modulo.'/elimina?edit='.$edit) ?>" class="btn btn-sm btn-danger" > <i class="flaticon-delete"></i>  </a>
            <?php } ?>

        </td>
    </tr>
    <tr>
        <td><strong>TOTALES</strong></td>
        <td style="text-align:right">
            <div id="total1" name="total1">
                <font size="+1"><strong><?php echo Parametro::formato($totalDebe); ?></strong></font> 
            </div>
        </td>
        <td style="text-align:right">
            <div id="total2" name="total2">
                <font size="+1"><strong><?php echo Parametro::formato($totalHaber); ?></strong></font>
            </div>
        </td>
        <td></td>

    </tr>

    <tr>
        <td></td>
        <td colspan="2">
           <?php if ($edit) { ?>
            <button class="btn btn-outline-success btn-block " value="agregar" type="submit">
                <i class="fa fa-save "></i>Actualizar
            </button>
            <?php }  else  { ?>
       <button class="btn btn-outline-success btn-block " value="agregar" type="submit">
                <i class="fa fa-plus "></i>Agregar
            </button>
          
       <?php } ?>


        </td>
        <td></td>

    </tr>
</table>