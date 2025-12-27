<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1766610029.
 * Generated on 2025-12-24 22:00:29 
 */
class PropelMigration_1766610029
{

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'propel' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `anticipo_recibido`;

DROP TABLE IF EXISTS `categoria_respuesta`;

DROP TABLE IF EXISTS `centro_tecnico`;

DROP TABLE IF EXISTS `cliente_vehiculo`;

DROP TABLE IF EXISTS `cliente_vehiculo_detalle`;

DROP TABLE IF EXISTS `cliente_vehiculo_foto`;

DROP TABLE IF EXISTS `cuenta_cobrar_nota`;

DROP TABLE IF EXISTS `cuenta_cobrar_pago`;

DROP TABLE IF EXISTS `cuenta_por_cobrar`;

DROP TABLE IF EXISTS `encuesta`;

DROP TABLE IF EXISTS `encuesta_detalle`;

DROP TABLE IF EXISTS `historico_devolucion`;

DROP TABLE IF EXISTS `pw_bitacora`;

DROP TABLE IF EXISTS `pw_venta_diaria`;

DROP TABLE IF EXISTS `recepcion_factura`;

DROP TABLE IF EXISTS `recepcion_orden_compra`;

DROP TABLE IF EXISTS `recepcion_repuesto`;

DROP TABLE IF EXISTS `recepcion_valores`;

DROP TABLE IF EXISTS `recepcion_vehiculo`;

DROP TABLE IF EXISTS `recepcion_vehiculo_nota`;

DROP TABLE IF EXISTS `recibo_caja_cobrar`;

DROP TABLE IF EXISTS `respuesta_detalle`;

DROP TABLE IF EXISTS `respuesta_encuesta`;

DROP TABLE IF EXISTS `ticket_nota`;

DROP TABLE IF EXISTS `ticket_orden_compra`;

DROP TABLE IF EXISTS `ticket_proceso`;

DROP TABLE IF EXISTS `usuario_encuesta`;

DROP TABLE IF EXISTS `vale_devolucion`;

DROP TABLE IF EXISTS `vehiculo_marca`;

DROP TABLE IF EXISTS `vehiculo_modelo`;

ALTER TABLE `operacion` CHANGE `observa_facturar` `observa_facturar` VARCHAR(250);

ALTER TABLE `operacion_detalle`
    ADD `linea_no` VARCHAR(50) AFTER `costo_unitario`;

CREATE UNIQUE INDEX `llave` ON `operacion_detalle` (`linea_no`);

ALTER TABLE `partida` CHANGE `ano` `ano` INTEGER DEFAULT false;

ALTER TABLE `partida` CHANGE `mes` `mes` INTEGER DEFAULT false;

ALTER TABLE `partida_agrupa` CHANGE `ano` `ano` INTEGER DEFAULT false;

ALTER TABLE `partida_agrupa` CHANGE `mes` `mes` INTEGER DEFAULT false;

ALTER TABLE `precio_producto`
    ADD `tipo_no` VARCHAR(50) AFTER `empresa_id`;

ALTER TABLE `producto_movimiento` CHANGE `linea_no` `linea_no` VARCHAR(50);

ALTER TABLE `tienda`
    ADD `activa_buscador` TINYINT(1) DEFAULT 0 AFTER `feel_llave`;

CREATE TABLE `cambio_vendedor`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo_opera` VARCHAR(50),
    `vendedor_anterior` VARCHAR(250),
    `vendedor_actualizado` VARCHAR(250),
    `usuario` VARCHAR(50),
    `fecha` DATE,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `traslado_ubicacion`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `tienda_id` INTEGER,
    `observaciones` VARCHAR(450),
    `usuario` VARCHAR(50),
    `fecha` DATE,
    `estado` VARCHAR(50),
    PRIMARY KEY (`id`),
    INDEX `traslado_ubicacion_FI_1` (`empresa_id`),
    INDEX `traslado_ubicacion_FI_2` (`tienda_id`),
    CONSTRAINT `traslado_ubicacion_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `traslado_ubicacion_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `traslado_ubicacion_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `traslado_ubicacion_id` INTEGER,
    `producto_id` INTEGER,
    `ubicacion_original` VARCHAR(50),
    `cantidad` INTEGER,
    `tienda_id` INTEGER,
    `nueva_ubicacion` VARCHAR(50),
    PRIMARY KEY (`id`),
    INDEX `traslado_ubicacion_detalle_FI_1` (`traslado_ubicacion_id`),
    INDEX `traslado_ubicacion_detalle_FI_2` (`producto_id`),
    INDEX `traslado_ubicacion_detalle_FI_3` (`tienda_id`),
    CONSTRAINT `traslado_ubicacion_detalle_FK_1`
        FOREIGN KEY (`traslado_ubicacion_id`)
        REFERENCES `traslado_ubicacion` (`id`),
    CONSTRAINT `traslado_ubicacion_detalle_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `traslado_ubicacion_detalle_FK_3`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'propel' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `cambio_vendedor`;

DROP TABLE IF EXISTS `traslado_ubicacion`;

DROP TABLE IF EXISTS `traslado_ubicacion_detalle`;

ALTER TABLE `operacion` CHANGE `observa_facturar` `observa_facturar` VARCHAR(240);

DROP INDEX `llave` ON `operacion_detalle`;

ALTER TABLE `operacion_detalle` DROP `linea_no`;

ALTER TABLE `partida` CHANGE `ano` `ano` INTEGER DEFAULT 0;

ALTER TABLE `partida` CHANGE `mes` `mes` INTEGER DEFAULT 0;

ALTER TABLE `partida_agrupa` CHANGE `ano` `ano` INTEGER DEFAULT 0;

ALTER TABLE `partida_agrupa` CHANGE `mes` `mes` INTEGER DEFAULT 0;

ALTER TABLE `precio_producto` DROP `tipo_no`;

ALTER TABLE `producto_movimiento` CHANGE `linea_no` `linea_no` INTEGER;

ALTER TABLE `tienda` DROP `activa_buscador`;

CREATE TABLE `anticipo_recibido`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(20),
    `tienda_id` INTEGER,
    `banco_id` INTEGER,
    `usuario` VARCHAR(50),
    `fecha` DATETIME,
    `valor` DOUBLE,
    `porcentaje_anticipo` DOUBLE,
    `descripcion` VARCHAR(350),
    `cliente_nombre` VARCHAR(150),
    `cliente_identifica` VARCHAR(50),
    `cliente_telefono` VARCHAR(20),
    `vendedor` VARCHAR(100),
    `referencia_wo` VARCHAR(20),
    `hollander` VARCHAR(20),
    `stock` VARCHAR(20),
    `fecha_vence` DATE,
    `partida_no` INTEGER DEFAULT 0,
    `estado` VARCHAR(50),
    `empresa_id` INTEGER,
    `no_boleta` VARCHAR(50),
    PRIMARY KEY (`id`),
    BTREE INDEX `anticipo_recibido_I_1` (`partida_no`),
    BTREE INDEX `anticipo_recibido_FI_1` (`tienda_id`),
    BTREE INDEX `anticipo_recibido_FI_2` (`banco_id`),
    BTREE INDEX `anticipo_recibido_FI_3` (`empresa_id`),
    CONSTRAINT `anticipo_recibido_FK_1`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `anticipo_recibido_FK_2`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`),
    CONSTRAINT `anticipo_recibido_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `categoria_respuesta`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(32),
    `nombre` VARCHAR(200),
    `nombre_2` VARCHAR(200),
    `observaciones` TEXT,
    `activo` TINYINT(1) DEFAULT 1,
    `codigo_pais` VARCHAR(32),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `centro_tecnico`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(150),
    `area` VARCHAR(150),
    `usuario_pw` VARCHAR(50),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `cliente_vehiculo`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(150),
    `direccion` VARCHAR(350),
    `telefono` VARCHAR(50),
    `correo` VARCHAR(150),
    `nombre_factura` VARCHAR(350),
    `nit` VARCHAR(50),
    `observaciones` VARCHAR(450),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `cliente_vehiculo_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `cliente_vehiculo_id` INTEGER,
    `vehiculo_marca_id` INTEGER,
    `vehiculo_modelo_id` INTEGER,
    `anio` INTEGER,
    `tipo_placa` VARCHAR(10),
    `placa` VARCHAR(50),
    `combustible` VARCHAR(100),
    `color` VARCHAR(150),
    `nit` VARCHAR(50),
    `transmision` VARCHAR(150),
    `procedencia` VARCHAR(150),
    PRIMARY KEY (`id`),
    BTREE INDEX `cliente_vehiculo_detalle_FI_1` (`cliente_vehiculo_id`),
    BTREE INDEX `cliente_vehiculo_detalle_FI_2` (`vehiculo_marca_id`),
    BTREE INDEX `cliente_vehiculo_detalle_FI_3` (`vehiculo_modelo_id`),
    CONSTRAINT `cliente_vehiculo_detalle_FK_1`
        FOREIGN KEY (`cliente_vehiculo_id`)
        REFERENCES `cliente_vehiculo` (`id`),
    CONSTRAINT `cliente_vehiculo_detalle_FK_2`
        FOREIGN KEY (`vehiculo_marca_id`)
        REFERENCES `vehiculo_marca` (`id`),
    CONSTRAINT `cliente_vehiculo_detalle_FK_3`
        FOREIGN KEY (`vehiculo_modelo_id`)
        REFERENCES `vehiculo_modelo` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `cliente_vehiculo_foto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `cliente_vehiculo_detalle_id` INTEGER,
    `foto` VARCHAR(250),
    `created_at` DATETIME,
    PRIMARY KEY (`id`),
    BTREE INDEX `cliente_vehiculo_foto_FI_1` (`cliente_vehiculo_detalle_id`),
    CONSTRAINT `cliente_vehiculo_foto_FK_1`
        FOREIGN KEY (`cliente_vehiculo_detalle_id`)
        REFERENCES `cliente_vehiculo_detalle` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `cuenta_cobrar_nota`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `cuenta_por_cobrar_id` INTEGER,
    `usuario` VARCHAR(50),
    `comentario` VARCHAR(350),
    `fecha` DATETIME,
    PRIMARY KEY (`id`),
    BTREE INDEX `cuenta_cobrar_nota_FI_1` (`cuenta_por_cobrar_id`),
    CONSTRAINT `cuenta_cobrar_nota_FK_1`
        FOREIGN KEY (`cuenta_por_cobrar_id`)
        REFERENCES `cuenta_por_cobrar` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `cuenta_cobrar_pago`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `cuenta_por_cobrar_id` INTEGER,
    `banco_id` INTEGER,
    `no_documento` VARCHAR(32),
    `tipo_pago` VARCHAR(45),
    `fecha` DATE,
    `valor` DOUBLE DEFAULT 0,
    `partida_no` INTEGER DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    BTREE INDEX `cuenta_cobrar_pago_I_1` (`partida_no`),
    BTREE INDEX `cuenta_cobrar_pago_FI_1` (`cuenta_por_cobrar_id`),
    BTREE INDEX `cuenta_cobrar_pago_FI_2` (`banco_id`),
    BTREE INDEX `cuenta_cobrar_pago_FI_3` (`empresa_id`),
    CONSTRAINT `cuenta_cobrar_pago_FK_1`
        FOREIGN KEY (`cuenta_por_cobrar_id`)
        REFERENCES `cuenta_por_cobrar` (`id`),
    CONSTRAINT `cuenta_cobrar_pago_FK_2`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`),
    CONSTRAINT `cuenta_cobrar_pago_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `cuenta_por_cobrar`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `referencia_factura` VARCHAR(50),
    `fecha` DATE,
    `vendedor` VARCHAR(250),
    `cliente` VARCHAR(250),
    `motivo` VARCHAR(450),
    `nit` VARCHAR(50),
    `telefono` VARCHAR(50),
    `correo` VARCHAR(150),
    `direccion` VARCHAR(450),
    `valor_total` DOUBLE DEFAULT 0,
    `valor_pagado` DOUBLE DEFAULT 0,
    `usuario` VARCHAR(50),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `empresa_id` INTEGER,
    `partida_no` INTEGER DEFAULT 0,
    `estatus` VARCHAR(50),
    `dias` INTEGER DEFAULT 0,
    `tipo` VARCHAR(50),
    `tienda_id` INTEGER,
    `no_pagos` INTEGER DEFAULT 0,
    `seleccionado` TINYINT(1) DEFAULT 0,
    `recibo_no` VARCHAR(50),
    `factura_no` VARCHAR(50),
    PRIMARY KEY (`id`),
    BTREE INDEX `cuenta_por_cobrar_I_1` (`partida_no`),
    BTREE INDEX `cuenta_por_cobrar_FI_1` (`empresa_id`),
    BTREE INDEX `cuenta_por_cobrar_FK_2` (`tienda_id`),
    CONSTRAINT `cuenta_por_cobrar_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `cuenta_por_cobrar_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `encuesta`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(32),
    `nombre` VARCHAR(200),
    `fecha_inicio` DATE,
    `observaciones` TEXT,
    `fecha_fin` DATE,
    `activo` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `encuesta_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `encuesta_id` INTEGER,
    `nombre` VARCHAR(450),
    `fecha` DATE,
    `estado` VARCHAR(32),
    `categoria_respuesta_id` INTEGER,
    `orden` INTEGER,
    `tipo_campo` VARCHAR(100),
    PRIMARY KEY (`id`),
    BTREE INDEX `encuesta_detalle_FI_1` (`encuesta_id`),
    BTREE INDEX `encuesta_detalle_FI_2` (`categoria_respuesta_id`),
    CONSTRAINT `encuesta_detalle_FK_1`
        FOREIGN KEY (`encuesta_id`)
        REFERENCES `encuesta` (`id`),
    CONSTRAINT `encuesta_detalle_FK_2`
        FOREIGN KEY (`categoria_respuesta_id`)
        REFERENCES `categoria_respuesta` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `historico_devolucion`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `vendedor` VARCHAR(200),
    `fecha` VARCHAR(10),
    `identificador` INTEGER,
    `valor` DOUBLE,
    `tipo` INTEGER,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `pw_bitacora`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fecha` DATETIME,
    `fecha_venta` DATE,
    `cantidad` INTEGER,
    `valor_total` DOUBLE,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `pw_venta_diaria`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fecha` DATE,
    `invoice` INTEGER,
    `cliente` VARCHAR(250),
    `nit` VARCHAR(50),
    `valor` DOUBLE,
    `store_number` INTEGER,
    `firma` VARCHAR(50),
    `hora` VARCHAR(10),
    `vendedor` VARCHAR(50),
    `detail` VARCHAR(150),
    `medio_pago` VARCHAR(50),
    PRIMARY KEY (`id`),
    BTREE INDEX `pw_venta_diaria_I_1` (`fecha`),
    BTREE INDEX `pw_venta_diaria_I_2` (`invoice`),
    BTREE INDEX `pw_venta_diaria_I_3` (`store_number`),
    BTREE INDEX `pw_venta_diaria_I_4` (`vendedor`(50))
) ENGINE=InnoDB;

CREATE TABLE `recepcion_factura`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `recepcion_vehiculo_id` INTEGER,
    `referencia` VARCHAR(20),
    `valor` DOUBLE,
    `fecha` DATETIME,
    PRIMARY KEY (`id`),
    BTREE INDEX `recepcion_factura_FI_1` (`recepcion_vehiculo_id`),
    CONSTRAINT `recepcion_factura_FK_1`
        FOREIGN KEY (`recepcion_vehiculo_id`)
        REFERENCES `recepcion_vehiculo` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `recepcion_orden_compra`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `orden_proveedor_id` INTEGER,
    `recepcion_vehiculo_id` INTEGER,
    PRIMARY KEY (`id`),
    BTREE INDEX `recepcion_orden_compra_FI_1` (`orden_proveedor_id`),
    BTREE INDEX `recepcion_orden_compra_FI_2` (`recepcion_vehiculo_id`),
    CONSTRAINT `recepcion_orden_compra_FK_1`
        FOREIGN KEY (`orden_proveedor_id`)
        REFERENCES `orden_proveedor` (`id`),
    CONSTRAINT `recepcion_orden_compra_FK_2`
        FOREIGN KEY (`recepcion_vehiculo_id`)
        REFERENCES `recepcion_vehiculo` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `recepcion_repuesto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `recepcion_vehiculo_id` INTEGER,
    `detalle` VARCHAR(350),
    `cantidad` INTEGER,
    `asesor` VARCHAR(150),
    PRIMARY KEY (`id`),
    BTREE INDEX `recepcion_repuesto_FI_1` (`recepcion_vehiculo_id`),
    CONSTRAINT `recepcion_repuesto_FK_1`
        FOREIGN KEY (`recepcion_vehiculo_id`)
        REFERENCES `recepcion_vehiculo` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `recepcion_valores`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `recepcion_vehiculo_id` INTEGER,
    `tecnico` VARCHAR(200),
    `detalle` VARCHAR(200),
    `valor` DOUBLE,
    PRIMARY KEY (`id`),
    BTREE INDEX `recepcion_valores_FI_1` (`recepcion_vehiculo_id`),
    CONSTRAINT `recepcion_valores_FK_1`
        FOREIGN KEY (`recepcion_vehiculo_id`)
        REFERENCES `recepcion_vehiculo` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `recepcion_vehiculo`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `cliente_vehiculo_id` INTEGER,
    `cliente_vehiculo_detalle_id` INTEGER,
    `fecha` DATETIME,
    `estatus` VARCHAR(50),
    `usuario` VARCHAR(50),
    `codigo` VARCHAR(50),
    `autorizado_cliente` VARCHAR(50),
    `observaciones` VARCHAR(450),
    `tarjeta_detalle` VARCHAR(150),
    `llave_detalle` VARCHAR(150),
    `alarma_detalle` VARCHAR(150),
    `radio_detalle` VARCHAR(150),
    `a_c_detalle` VARCHAR(150),
    `alfombra_detalle` VARCHAR(150),
    `cigarrete_detalle` VARCHAR(150),
    `cerradura_detalle` VARCHAR(150),
    `retrovisor_detalle` VARCHAR(150),
    `vidrios_detalle` VARCHAR(150),
    `herramienta_detalle` VARCHAR(150),
    `llanta_detalle` VARCHAR(150),
    `tricket_detalle` VARCHAR(150),
    `triangulos_detalle` VARCHAR(150),
    `extinguidor_detalle` VARCHAR(150),
    `retro_derecho_detalle` VARCHAR(150),
    `retro_izquier_detalle` VARCHAR(150),
    `antena_detalle` VARCHAR(150),
    `emblema_detalle` VARCHAR(150),
    `plato_detalle` VARCHAR(150),
    `aros_detalle` VARCHAR(150),
    `tapones_llanta_detalle` VARCHAR(150),
    `neblinera_detalle` VARCHAR(150),
    `spoiler_detalle` VARCHAR(150),
    `otros` TEXT,
    `raspones_rayon` TEXT,
    `otros2` TEXT,
    `diagnostico` TEXT,
    `presupuesto` DOUBLE,
    `tarjeta` TINYINT(1) DEFAULT 0,
    `llave` TINYINT(1) DEFAULT 0,
    `alarma` TINYINT(1) DEFAULT 0,
    `radio` TINYINT(1) DEFAULT 0,
    `a_c` TINYINT(1) DEFAULT 0,
    `alfombra` TINYINT(1) DEFAULT 0,
    `cigarrete` TINYINT(1) DEFAULT 0,
    `cerradura` TINYINT(1) DEFAULT 0,
    `retrovisor` TINYINT(1) DEFAULT 0,
    `vidrios` TINYINT(1) DEFAULT 0,
    `herramienta` TINYINT(1) DEFAULT 0,
    `llanta` TINYINT(1) DEFAULT 0,
    `tricket` TINYINT(1) DEFAULT 0,
    `triangulos` TINYINT(1) DEFAULT 0,
    `extinguidor` TINYINT(1) DEFAULT 0,
    `retro_derecho` TINYINT(1) DEFAULT 0,
    `retro_izquier` TINYINT(1) DEFAULT 0,
    `antena` TINYINT(1) DEFAULT 0,
    `emblema` TINYINT(1) DEFAULT 0,
    `plato` TINYINT(1) DEFAULT 0,
    `aros` TINYINT(1) DEFAULT 0,
    `tapones_llanta` TINYINT(1) DEFAULT 0,
    `neblinera` TINYINT(1) DEFAULT 0,
    `spoiler` TINYINT(1) DEFAULT 0,
    `caja` TINYINT(1) DEFAULT 0,
    `alternador` TINYINT(1) DEFAULT 0,
    `compresor` TINYINT(1) DEFAULT 0,
    `observaciones_entrega` TEXT,
    `fecha_entrega` DATETIME,
    `firma` VARCHAR(150),
    `orden_proveedor_id` INTEGER,
    `nombre_tecnico` VARCHAR(150),
    `referencia` VARCHAR(20),
    `valor_referencia` DOUBLE,
    `encuestado` TINYINT(1) DEFAULT 0,
    `fecha_referencia` DATETIME,
    `trabajo_realizado` VARCHAR(450),
    `garantia` VARCHAR(450),
    `firma_recibido` VARCHAR(150),
    PRIMARY KEY (`id`),
    BTREE INDEX `recepcion_vehiculo_FI_1` (`cliente_vehiculo_id`),
    BTREE INDEX `recepcion_vehiculo_FI_2` (`cliente_vehiculo_detalle_id`),
    BTREE INDEX `recepcion_vehiculo_FK_3` (`orden_proveedor_id`),
    CONSTRAINT `recepcion_vehiculo_FK_1`
        FOREIGN KEY (`cliente_vehiculo_id`)
        REFERENCES `cliente_vehiculo` (`id`),
    CONSTRAINT `recepcion_vehiculo_FK_2`
        FOREIGN KEY (`cliente_vehiculo_detalle_id`)
        REFERENCES `cliente_vehiculo_detalle` (`id`),
    CONSTRAINT `recepcion_vehiculo_FK_3`
        FOREIGN KEY (`orden_proveedor_id`)
        REFERENCES `orden_proveedor` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `recepcion_vehiculo_nota`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `recepcion_vehiculo_id` INTEGER,
    `usuario` VARCHAR(50),
    `comentario` VARCHAR(350),
    `fecha` DATETIME,
    PRIMARY KEY (`id`),
    BTREE INDEX `recepcion_vehiculo_nota_FI_1` (`recepcion_vehiculo_id`),
    CONSTRAINT `recepcion_vehiculo_nota_FK_1`
        FOREIGN KEY (`recepcion_vehiculo_id`)
        REFERENCES `recepcion_vehiculo` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `recibo_caja_cobrar`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `fecha` DATETIME,
    `valor` DOUBLE,
    `observaciones` VARCHAR(450),
    `usuario` VARCHAR(50),
    `empresa_id` INTEGER,
    `estatus` VARCHAR(50),
    `partida_no` INTEGER,
    PRIMARY KEY (`id`),
    BTREE INDEX `recibo_caja_cobrar_FI_1` (`empresa_id`),
    CONSTRAINT `recibo_caja_cobrar_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `respuesta_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `categoria_respuesta_id` INTEGER,
    `nombre` VARCHAR(200),
    `puntos` INTEGER,
    PRIMARY KEY (`id`),
    BTREE INDEX `respuesta_detalle_FI_1` (`categoria_respuesta_id`),
    CONSTRAINT `respuesta_detalle_FK_1`
        FOREIGN KEY (`categoria_respuesta_id`)
        REFERENCES `categoria_respuesta` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `respuesta_encuesta`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `encuesta_id` INTEGER,
    `usuario_encuesta_id` INTEGER,
    `encuesta_detalle_no` INTEGER,
    `respuesta_detalle_no` INTEGER,
    `estado` VARCHAR(20),
    `fecha` DATETIME,
    `pregunta` VARCHAR(200),
    `respuesta` VARCHAR(300),
    PRIMARY KEY (`id`),
    BTREE INDEX `respuesta_encuesta_FI_1` (`encuesta_id`),
    BTREE INDEX `respuesta_encuesta_FI_2` (`usuario_encuesta_id`),
    CONSTRAINT `respuesta_encuesta_FK_1`
        FOREIGN KEY (`encuesta_id`)
        REFERENCES `encuesta` (`id`),
    CONSTRAINT `respuesta_encuesta_FK_2`
        FOREIGN KEY (`usuario_encuesta_id`)
        REFERENCES `usuario_encuesta` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `ticket_nota`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `ticket_proceso_id` INTEGER,
    `cantidad` INTEGER,
    `detalle` VARCHAR(450),
    `tipo` VARCHAR(50),
    PRIMARY KEY (`id`),
    BTREE INDEX `ticket_nota_FI_1` (`ticket_proceso_id`),
    CONSTRAINT `ticket_nota_FK_1`
        FOREIGN KEY (`ticket_proceso_id`)
        REFERENCES `ticket_proceso` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `ticket_orden_compra`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `ticket_proceso_id` INTEGER,
    `orden_proveedor_id` INTEGER,
    PRIMARY KEY (`id`),
    BTREE INDEX `ticket_orden_compra_FI_1` (`ticket_proceso_id`),
    BTREE INDEX `ticket_orden_compra_FI_2` (`orden_proveedor_id`),
    CONSTRAINT `ticket_orden_compra_FK_1`
        FOREIGN KEY (`ticket_proceso_id`)
        REFERENCES `ticket_proceso` (`id`),
    CONSTRAINT `ticket_orden_compra_FK_2`
        FOREIGN KEY (`orden_proveedor_id`)
        REFERENCES `orden_proveedor` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `ticket_proceso`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fecha` DATE,
    `estado` VARCHAR(30),
    `codigo` VARCHAR(20),
    `usuario` VARCHAR(50),
    `tienda_id` INTEGER,
    `comentario` VARCHAR(450),
    `fecha_confirma` DATETIME,
    `usuario_confirma` VARCHAR(50),
    `tienda_origen` INTEGER NOT NULL,
    `cliente` VARCHAR(450),
    `asunto` VARCHAR(450),
    `encargado` VARCHAR(250),
    `orden_proveedor_id` INTEGER,
    PRIMARY KEY (`id`),
    BTREE INDEX `ticket_proceso_I_1` (`fecha`),
    BTREE INDEX `ticket_proceso_FI_1` (`tienda_id`),
    BTREE INDEX `ticket_proceso_I_2` (`tienda_origen`),
    BTREE INDEX `ticket_proceso_FI_3` (`orden_proveedor_id`),
    CONSTRAINT `ticket_proceso_FK_1`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `ticket_proceso_FK_2`
        FOREIGN KEY (`tienda_origen`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `ticket_proceso_FK_3`
        FOREIGN KEY (`orden_proveedor_id`)
        REFERENCES `orden_proveedor` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `usuario_encuesta`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `recepcion_vehiculo_id` INTEGER,
    `encuesta_id` INTEGER,
    `fecha` DATETIME,
    PRIMARY KEY (`id`),
    BTREE INDEX `usuario_encuesta_FI_1` (`recepcion_vehiculo_id`),
    BTREE INDEX `usuario_encuesta_FI_2` (`encuesta_id`),
    CONSTRAINT `usuario_encuesta_FK_1`
        FOREIGN KEY (`recepcion_vehiculo_id`)
        REFERENCES `recepcion_vehiculo` (`id`),
    CONSTRAINT `usuario_encuesta_FK_2`
        FOREIGN KEY (`encuesta_id`)
        REFERENCES `encuesta` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `vale_devolucion`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `codigo` VARCHAR(20),
    `tienda_id` INTEGER,
    `nombre_cliente` VARCHAR(200),
    `valor` DOUBLE,
    `observaciones` VARCHAR(450),
    `referencia` VARCHAR(50),
    `hollander` VARCHAR(50),
    `vendedor_id` INTEGER,
    `usuario` VARCHAR(50),
    `fecha_ingreso` DATETIME,
    `estado` VARCHAR(50),
    `usuario_canjeo` VARCHAR(50),
    `fecha_canjeo` DATETIME,
    `codigo_devolucion` VARCHAR(50),
    PRIMARY KEY (`id`),
    BTREE INDEX `vale_devolucion_FI_1` (`empresa_id`),
    BTREE INDEX `vale_devolucion_FI_2` (`tienda_id`),
    BTREE INDEX `vale_devolucion_FI_3` (`vendedor_id`),
    CONSTRAINT `vale_devolucion_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `vale_devolucion_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `vale_devolucion_FK_3`
        FOREIGN KEY (`vendedor_id`)
        REFERENCES `vendedor` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `vehiculo_marca`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(350),
    `activo` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `vehiculo_modelo`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `vehiculo_marca_id` INTEGER,
    `nombre` VARCHAR(350),
    `activo` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`id`),
    BTREE INDEX `vehiculo_modelo_FI_1` (`vehiculo_marca_id`),
    CONSTRAINT `vehiculo_modelo_FK_1`
        FOREIGN KEY (`vehiculo_marca_id`)
        REFERENCES `vehiculo_marca` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}