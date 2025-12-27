<div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
    <a class="kt-aside-toggler kt-aside-toggler--left" href="<?php echo url_for('inicio/index') ?>" id="kt_aside_toggler"><span></span>
    </a>

    <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile "  >
        <ul class="kt-menu__nav ">
            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text"><i class="warning kt-menu__link-icon flaticon2-layers"></i>Catálogos</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">


                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('proyecto/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Proyectos</span></a></li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('banco/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Bancos</span></a></li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('medio_pago/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Medio de Pago</span></a></li>

                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('motivo/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Motivos </span></a></li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('campo_usuario/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Campos de Usuario </span></a></li>

                    </ul>
                </div>
            </li>
            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text"><i class="warning kt-menu__link-icon flaticon2-gift"></i>Productos</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--hover" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">Catálogos<i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('tipo_aparato_p/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Grupo Producto</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('marca_p/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Sub GrupoProducto</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('modelo_p/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Categoria Producto</span></a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('edita_producto/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Producto</span></a></li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('servicio/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Servicio</span></a></li>
                        <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--hover" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">Movimientos<i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('carga_producto/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Carga Producto</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('actualiza_inventario/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Inventarios</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('actualiza_precio/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Precios</span></a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>




            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text"><i class="warning kt-menu__link-icon flaticon2-browser"></i>Administración</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('edita_tienda/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text"> Tiendas</span></a></li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('edita_proveedor/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Proveedores</span></a></li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('edita_cliente/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text"> Clientes</span></a></li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('orden_devolucion/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Orden Devolución</span></a></li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('pro_orden_devolucion/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Confirma Devolución</span></a></li>                        
                    </ul>
                </div>
            </li>


            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text"><i class="warning kt-menu__link-icon flaticon2-analytics-1"></i>Finanzas </span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">






                 
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('orden_gasto/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Gastos de Compra</span></a></li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('lista_cobro/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Caja Cobro</span></a></li>
       <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('cxc_por_pagar/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Cuentas por Pagar</span></a></li>

                        <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--hover" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">Gestión  de  Bancos<i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('crea_cheque/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Cheques</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('debito_banco/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Debito</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('movimiento_banco/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Transferencias Bancos</span></a></li>

                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('tranfer_deposito/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Depositos / Transferencias </span></a></li>

                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="#" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">=>>> Conciliación Bancaria</span></a></li>

                                </ul>
                            </div>
                        </li>
                        <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--hover" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">Administración Cuentas<i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('cuenta_contable/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Cuentas Contables</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('partida_inicial/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Saldo Iniciales</span></a></li>          
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('cuenta_default/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Cuentas Default</span></a></li>  
                                </ul>
                            </div>
                        </li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('partida_manual/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Partida Manual</span></a></li>
<!--                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="#<?php echo url_for('producto/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Transferencia Bancaria</span></a></li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="#<?php echo url_for('producto/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Notas Credito</span></a></li>-->


                    </ul>
                </div>
            </li>
            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text"><i class="warning kt-menu__link-icon flaticon2-rocket"></i>Procesos</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                       <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('venta_tienda/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text"> Venta Tienda</span></a></li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('venta_resumida/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text"> Venta Resumida</span></a></li>
                  
                        <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--hover" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">Ordenes Compra<i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('orden_compra/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Crear</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('con_ordencompra/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Confirmar</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('pro_ordencompra/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Procesar </span></a></li>

                                </ul>
                            </div>
                        </li>

                        <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--hover" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">Ventas<i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('orden_cotizacion/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Cotizaciones</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('con_ordencotiza/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Confirma Cotización</span></a></li>

<!--                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('caja/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Caja </span></a></li>

<li class="kt-menu__item "  aria-haspopup="true"><a  href="#<?php echo url_for('pago_proveedor/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Ventas</span></a></li>
<li class="kt-menu__item "  aria-haspopup="true"><a  href="#<?php echo url_for('pago_proveedor/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Facturar</span></a></li>-->
                                </ul>
                            </div>
                        </li>
                </div>
            </li>



            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text"><i class="warning kt-menu__link-icon flaticon2-checking"></i>Reporte</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
  <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('reporte_tienda/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Reporte Tienda</span></a></li>
                                   
                        <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--hover" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">Productos<i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('reporte_kardex/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Reporte Kardex</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('reporte_inventario/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Reporte Inventario</span></a></li>

                                </ul>
                            </div>
                        </li>

                        <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--hover" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">Ventas<i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('reporte_cotizacion/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Cotizaciones</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('reporte_caja/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Corte Caja</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('reporte_venta/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Reporte Venta</span></a></li>
                                </ul>
                            </div>
                        </li>                 


                        <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--hover" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">Egresos<i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                <ul class="kt-menu__subnav">

                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('consulta_gasto_proveedor/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Gastos</span></a></li>
                                </ul>
                                
                                        <ul class="kt-menu__subnav">

                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('consulta_orden_proveedor/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Ordenes de Compra</span></a></li>
                                </ul>
                            </div>
                        </li>                 



                        <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--hover" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">Finanzas<i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                <ul class="kt-menu__subnav">

                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('cuenta_proveedor/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Estado Cuenta Proveedor</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('cuenta_banco/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Estado Cuenta Banco</span></a></li>
<!--                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('cuenta_cliente/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Estado Cuenta Cliente</span></a></li>-->

                                </ul>
                            </div>
                        </li>   
                        <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--hover" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">Contable<i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                <ul class="kt-menu__subnav">

                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('reporte_partida/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Partidas</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('libro_diario/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Libro Diaro</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('libro_diario_agrupa/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Libro Diaro Agrupado</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('libro_mayor/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Libro Mayor</span></a></li>
                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="#<?php echo url_for('cuenta_banco/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Libro Balance</span></a></li>
<!--                                    <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('cuenta_cliente/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Estado Cuenta Cliente</span></a></li>-->

                                </ul>
                            </div>
                        </li>   


                    </ul>
                </div>
            </li>


            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text"><i class="warning kt-menu__link-icon flaticon2-settings"></i>Configuración</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('crea_empresa/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Empresa</span></a></li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('edita_usuario/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Usuario</span></a></li>
                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('formato_cheque/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Formato Cheque</span></a></li>
<li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('perfil/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Accesos</span></a></li>

<!--                        <li class="kt-menu__item "  aria-haspopup="true"><a  href="<?php echo url_for('menu_seguridad/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Menu</span></a></li>                                


<li class="kt-menu__item "  aria-haspopup="true"><a  href="#<?php echo url_for('parametro/index') ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Parametro</span></a></li>-->

                    </ul>
                </div>
            </li>


        </ul>
    </div>
</div>