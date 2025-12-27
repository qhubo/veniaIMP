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
          <a href="<?php echo url_for('captura_datos/index') ?>" class="btn btn-success btn-secondary" > <i class="flaticon2-plus"></i> Nueva Visita </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        
             <?php $modulo = $sf_params->get('module'); ?>
        <?php echo $form->renderFormTag(url_for($modulo . '/index?id=1'), array('class' => 'form-horizontal"')) ?>
        <?php echo $form->renderHiddenFields() ?>
        <div class="row" style="padding-bottom:8px">
            <div class="col-lg-2 <?php if ($form['fechaInicio']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaInicio'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaInicio']->renderError() ?>  
                </span>
            </div>
            <div class="col-lg-2 <?php if ($form['fechaFin']->hasError()) echo "has-error" ?>">
                <?php echo $form['fechaFin'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['fechaFin']->renderError() ?>  
                </span>
            </div>
            
                  <div class="col-lg-2 <?php if ($form['tipo']->hasError()) echo "has-error" ?>">
                <?php echo $form['tipo'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['tipo']->renderError() ?>  
                </span>
            </div>
                  <div class="col-lg-2 <?php if ($form['region']->hasError()) echo "has-error" ?>">
                <?php echo $form['region'] ?>           
                <span class="help-block form-error"> 
                    <?php echo $form['region']->renderError() ?>  
                </span>
            </div>

            <div class="col-lg-2">
                <button class="btn btn-outline-success" type="submit">
                    <i class="fa fa-search "></i>
                    <span>Buscar</span>
                </button>
            </div>

                         <div class="col-lg-1">
                                 <a target="_blank" href="<?php echo url_for($modulo . '/reporte') ?>" class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white"> <i class="flaticon2-printer"></i> Excel </a>
                      </div>
        </div>
        <?php echo "</form>"; ?>
        
            <div class="row">
            <div class="col-lg-7"></div>
            <div class="col-lg-3"></div>
            <div class="col-lg-2">

                    <div class="kt-input-icon kt-input-icon--left">
                        <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-search"></i></span>
                        </span>
                    </div>
        
            </div>
        </div>
        <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin kt-datatable" id="html_table" width="100%">
            <tr>
                <th><font size="-2"> Fecha </font></th>
                <th><font size="-2">Establecimiento</font> </th>
                <th><font size="-2">Región</font></th>
                <th><font size="-2">Repuestos</font></th>
                <th><font size="-2">Propietario <br> Contacto</font></th>
                <th><font size="-2">Telefono <br> WhatsApp</font></th>
                <th><font size="-2">Departamento <br> Municipio</font></th>
                <th><font size="-2">Dirección</font></th>
                <th><font size="-2">Correo</font></th>
                <th><font size="-2">Observaciones</font></th>

                <th><font size="-2">Usuario</font></th>
            </tr>
            <?php foreach ($registros as $lista) { ?>
                <?php $lista = FormularioDatosQuery::create()->findOneById($lista->getId()); ?>
                <?php
                $detalle = FormularioDetalleQuery::create()
                        ->filterByFormularioDatosId($lista->getId())
                        ->find();
                ?>
                <tr>
                    <td><font size="-2"> <?php echo $lista->getFechaVisita('d/m/Y'); ?></font>
                        <br><font size="-2"> <?php echo $lista->getCreatedAt('H:i:s'); ?></font>
                    </td>
                    
                      <td>
                        <font size="-2"> <?php echo $lista->getEstablecimiento(); ?></font> <br>
                        <font size="-2"> <?php echo $lista->getTipo(); ?></font>               
                    </td>
                    <td><font size="-2"> <?php echo $lista->getRegion()->getDetalle(); ?></font></td>
                    <td><font size="-2"> 
                            <?php if ($detalle) { ?>

                            <ul>
                                <?php foreach ($detalle as $regi) { ?>

                                    <li><?php echo $regi->getHollander(); ?> <?php echo $regi->getRepuesto(); ?></li>
                            <?php } ?>
                            </ul>

    <?php } ?>
                        </font></td>
                  
                    <td>
                        <font size="-2"> <?php echo $lista->getPropietario(); ?></font> <br>
                        <font size="-2"> <?php echo $lista->getContacto(); ?></font>               
                    </td>
                    <td>
                        <font size="-2"> <?php echo $lista->getTelefono(); ?></font> <br>
                        <font size="-2"> <?php echo $lista->getWhtasApp(); ?></font>               
                    </td>

                    <td>
                        <font size="-2"> <?php echo $lista->getDepartamento(); ?></font> <br>
                        <font size="-2"> <?php echo $lista->getMunicipio(); ?></font>               
                    </td>

                    <td><font size="-2"> <?php echo $lista->getDireccion(); ?></font></td>
                    <td><font size="-2"> <?php echo $lista->getEmail(); ?></font></td>
                    <td><font size="-2"> <?php echo $lista->getObservaciones(); ?></font></td>

                    <td><font size="-2"> <?php echo $lista->getUsuario(); ?></font></td>

                </tr>
<?php } ?>

        </table>

    </div>
</div>