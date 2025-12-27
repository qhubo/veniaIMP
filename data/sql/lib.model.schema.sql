
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- usuario
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `usuario` VARCHAR(32) NOT NULL,
    `nombre_completo` VARCHAR(320),
    `tipo_usuario` VARCHAR(50),
    `clave` VARCHAR(50),
    `correo` VARCHAR(255),
    `estado` VARCHAR(32),
    `imagen` VARCHAR(255),
    `administrador` TINYINT(1) DEFAULT 0,
    `ultimo_ingreso` DATETIME,
    `token` TEXT,
    `activo` TINYINT(1) DEFAULT 1,
    `validado` TINYINT(1) DEFAULT 0,
    `nivel_usuario` VARCHAR(50) DEFAULT '',
    `ip` VARCHAR(15),
    `tienda_id` INTEGER,
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `llave` (`usuario`),
    INDEX `usuario_FI_1` (`tienda_id`),
    INDEX `usuario_FI_2` (`empresa_id`),
    CONSTRAINT `usuario_FK_1`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `usuario_FK_2`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- usuario_logueo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `usuario_logueo`;

CREATE TABLE `usuario_logueo`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `usuario` VARCHAR(255),
    `fecha` DATETIME,
    `ip` VARCHAR(15),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- usuario_tienda
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `usuario_tienda`;

CREATE TABLE `usuario_tienda`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `usuario_id` INTEGER,
    `tienda_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `usuario_tienda_FI_1` (`usuario_id`),
    INDEX `usuario_tienda_FI_2` (`tienda_id`),
    CONSTRAINT `usuario_tienda_FK_1`
        FOREIGN KEY (`usuario_id`)
        REFERENCES `usuario` (`id`),
    CONSTRAINT `usuario_tienda_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- usuario_empresa
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `usuario_empresa`;

CREATE TABLE `usuario_empresa`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `usuario_id` INTEGER,
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `usuario_empresa_FI_1` (`usuario_id`),
    INDEX `usuario_empresa_FI_2` (`empresa_id`),
    CONSTRAINT `usuario_empresa_FK_1`
        FOREIGN KEY (`usuario_id`)
        REFERENCES `usuario` (`id`),
    CONSTRAINT `usuario_empresa_FK_2`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- empresa
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `empresa`;

CREATE TABLE `empresa`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `nombre` VARCHAR(150) NOT NULL,
    `nomenclatura` VARCHAR(50),
    `telefono` VARCHAR(50),
    `departamento_id` INTEGER,
    `municipio_id` INTEGER,
    `direccion` VARCHAR(250),
    `mapa_geo` TEXT,
    `logo` VARCHAR(150),
    `contacto_nombre` VARCHAR(250),
    `contacto_telefono` VARCHAR(50),
    `contacto_movil` VARCHAR(50),
    `observaciones` TEXT,
    `factura_electronica` TINYINT(1) DEFAULT 0,
    `contacto_correo` VARCHAR(150),
    `feel_nombre` VARCHAR(150),
    `feel_usuario` VARCHAR(150),
    `feel_token` VARCHAR(150),
    `feel_llave` VARCHAR(150),
    `feel_escenario_frase` VARCHAR(150),
    `dias_credito` INTEGER,
    `retiene_isr` TINYINT(1) DEFAULT 0,
    `moneda_q` VARCHAR(2) DEFAULT 'Q',
    PRIMARY KEY (`id`),
    INDEX `empresa_FI_1` (`departamento_id`),
    INDEX `empresa_FI_2` (`municipio_id`),
    CONSTRAINT `empresa_FK_1`
        FOREIGN KEY (`departamento_id`)
        REFERENCES `departamento` (`id`),
    CONSTRAINT `empresa_FK_2`
        FOREIGN KEY (`municipio_id`)
        REFERENCES `municipio` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- banco
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `banco`;

CREATE TABLE `banco`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `codigo` VARCHAR(50),
    `nombre` VARCHAR(150) NOT NULL,
    `cuenta` VARCHAR(150),
    `tipo_banco` VARCHAR(50),
    `observaciones` TEXT,
    `activo` TINYINT(1) DEFAULT 1,
    `cuenta_contable` VARCHAR(50),
    `nombre_banco_id` INTEGER,
    `pago_cheque` TINYINT(1) DEFAULT 0,
    `dolares` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `banco_FI_1` (`empresa_id`),
    INDEX `banco_FI_2` (`nombre_banco_id`),
    CONSTRAINT `banco_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `banco_FK_2`
        FOREIGN KEY (`nombre_banco_id`)
        REFERENCES `nombre_banco` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- banco_termporal
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `banco_termporal`;

CREATE TABLE `banco_termporal`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `fecha` DATE,
    `banco_id` INTEGER,
    `saldo_banco` DOUBLE,
    `deposito_transito` DOUBLE,
    `nota_credito_transito` DOUBLE,
    `cheques_circulacion` DOUBLE,
    `nota_debito_transito` DOUBLE,
    `saldo_libros` DOUBLE,
    `deposito_registrar` DOUBLE,
    `nota_credito_registrar` DOUBLE,
    `cheques_registrar` DOUBLE,
    `nota_debito_registrar` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `banco_termporal_FI_1` (`empresa_id`),
    INDEX `banco_termporal_FI_2` (`banco_id`),
    CONSTRAINT `banco_termporal_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `banco_termporal_FK_2`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- operacion
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `operacion`;

CREATE TABLE `operacion`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `tipo` VARCHAR(50),
    `estatus` VARCHAR(50),
    `empresa_id` INTEGER,
    `usuario` VARCHAR(50),
    `nombre` VARCHAR(300),
    `nit` VARCHAR(50) DEFAULT '',
    `correo` VARCHAR(150) DEFAULT '',
    `fecha` DATETIME,
    `valor_total` DOUBLE DEFAULT 0,
    `valor_pagado` DOUBLE DEFAULT 0,
    `codigo_factura` VARCHAR(25) DEFAULT '',
    `face_serie_factura` VARCHAR(250),
    `face_numero_factura` VARCHAR(250),
    `face_referencia` VARCHAR(250),
    `face_fecha_emision` DATETIME,
    `face_firma` VARCHAR(250),
    `face_error` VARCHAR(450),
    `face_estado` VARCHAR(50) DEFAULT '',
    `cuenta_contable` VARCHAR(50) DEFAULT '',
    `partida_no` INTEGER DEFAULT 0,
    `codigo_establecimiento` VARCHAR(50),
    `sub_total` DOUBLE,
    `iva` DOUBLE,
    `tienda_id` INTEGER,
    `pagado` TINYINT(1) DEFAULT 0,
    `anulado` TINYINT(1) DEFAULT 0,
    `observaciones` VARCHAR(250),
    `anulo_usuario` VARCHAR(50),
    `fecha_anulo` DATETIME,
    `docentry` VARCHAR(50),
    `recetario_id` INTEGER,
    `anula_face_serie_factura` VARCHAR(250),
    `anula_face_numero_factura` VARCHAR(250),
    `anula_face_referencia` VARCHAR(250),
    `anula_face_fecha_emision` VARCHAR(200),
    `anula_docentry` VARCHAR(50),
    `anula_face_firma` VARCHAR(250),
    `cliente_id` INTEGER,
    `cantidad_total_caja` INTEGER,
    `peso_total` VARCHAR(150),
    PRIMARY KEY (`id`),
    INDEX `operacion_FI_1` (`empresa_id`),
    INDEX `operacion_FI_2` (`tienda_id`),
    INDEX `operacion_FI_3` (`recetario_id`),
    INDEX `operacion_FI_4` (`cliente_id`),
    CONSTRAINT `operacion_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `operacion_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `operacion_FK_3`
        FOREIGN KEY (`recetario_id`)
        REFERENCES `recetario` (`id`),
    CONSTRAINT `operacion_FK_4`
        FOREIGN KEY (`cliente_id`)
        REFERENCES `cliente` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- operacion_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `operacion_detalle`;

CREATE TABLE `operacion_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `empresa_id` INTEGER,
    `operacion_id` INTEGER,
    `producto_id` INTEGER,
    `detalle` VARCHAR(250),
    `cantidad` INTEGER,
    `valor_total` DOUBLE,
    `servicio_id` INTEGER,
    `valor_unitario` DOUBLE DEFAULT 0,
    `descuento` DOUBLE DEFAULT 0,
    `total_iva` DOUBLE,
    `costo_unitario` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `operacion_detalle_FI_1` (`empresa_id`),
    INDEX `operacion_detalle_FI_2` (`operacion_id`),
    INDEX `operacion_detalle_FI_3` (`producto_id`),
    INDEX `operacion_detalle_FI_4` (`servicio_id`),
    CONSTRAINT `operacion_detalle_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `operacion_detalle_FK_2`
        FOREIGN KEY (`operacion_id`)
        REFERENCES `operacion` (`id`),
    CONSTRAINT `operacion_detalle_FK_3`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `operacion_detalle_FK_4`
        FOREIGN KEY (`servicio_id`)
        REFERENCES `servicio` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- operacion_pago
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `operacion_pago`;

CREATE TABLE `operacion_pago`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `operacion_id` INTEGER,
    `tipo` VARCHAR(50),
    `valor` DOUBLE,
    `documento` VARCHAR(50),
    `fecha_documento` DATE,
    `banco_id` INTEGER,
    `cuenta_contable` VARCHAR(50) DEFAULT '',
    `partida_no` INTEGER DEFAULT 0,
    `usuario` VARCHAR(52),
    `fecha_creo` DATETIME,
    `cxc_cobrar` VARCHAR(50),
    `comision` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `operacion_pago_FI_1` (`empresa_id`),
    INDEX `operacion_pago_FI_2` (`operacion_id`),
    INDEX `operacion_pago_FI_3` (`banco_id`),
    CONSTRAINT `operacion_pago_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `operacion_pago_FK_2`
        FOREIGN KEY (`operacion_id`)
        REFERENCES `operacion` (`id`),
    CONSTRAINT `operacion_pago_FK_3`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- pais
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `pais`;

CREATE TABLE `pais`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `principal` TINYINT(1) DEFAULT 0,
    `codigo_iso` VARCHAR(32),
    `nombre` VARCHAR(260) DEFAULT '' NOT NULL,
    `activo` TINYINT(1) DEFAULT 1,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `observaciones` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- departamento
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `departamento`;

CREATE TABLE `departamento`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `pais_id` INTEGER,
    `codigo` VARCHAR(32),
    `nombre` VARCHAR(260) DEFAULT '' NOT NULL,
    `activo` TINYINT(1) DEFAULT 1,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `observaciones` TEXT,
    `codigo_cargo` VARCHAR(32),
    PRIMARY KEY (`id`),
    INDEX `departamento_FI_1` (`pais_id`),
    CONSTRAINT `departamento_FK_1`
        FOREIGN KEY (`pais_id`)
        REFERENCES `pais` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- municipio
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `municipio`;

CREATE TABLE `municipio`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `departamento_id` INTEGER,
    `descripcion` VARCHAR(260) DEFAULT '' NOT NULL,
    `abreviatura` VARCHAR(32),
    `codigo_postal` VARCHAR(20),
    `activo` TINYINT(1) DEFAULT 1,
    `observaciones` TEXT,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `codigo_cargo` VARCHAR(32),
    PRIMARY KEY (`id`),
    INDEX `municipio_FI_1` (`departamento_id`),
    CONSTRAINT `municipio_FK_1`
        FOREIGN KEY (`departamento_id`)
        REFERENCES `departamento` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- proveedor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `proveedor`;

CREATE TABLE `proveedor`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `codigo` VARCHAR(32),
    `nombre` VARCHAR(260) DEFAULT '' NOT NULL,
    `razon_social` VARCHAR(160),
    `pequeno_contribuye` TINYINT(1) DEFAULT 0,
    `regimen_isr` VARCHAR(160),
    `direccion` VARCHAR(160),
    `sitio_web` VARCHAR(260),
    `telefono` VARCHAR(60),
    `correo_electronico` VARCHAR(160),
    `observaciones` TEXT,
    `nit` VARCHAR(20),
    `dias_credito` INTEGER,
    `tipo_proveedor` VARCHAR(120),
    `activo` TINYINT(1) DEFAULT 1,
    `tiene_credito` TINYINT(1) DEFAULT 0,
    `avenida_calle` VARCHAR(10),
    `zona` VARCHAR(10),
    `departamento_id` INTEGER,
    `municipio_id` INTEGER,
    `contacto` VARCHAR(160),
    `correo_contacto` VARCHAR(160),
    `imagen` VARCHAR(160),
    `telefono_contacto` VARCHAR(60),
    `tipificacion` INTEGER DEFAULT 0,
    `fecha` DATETIME,
    `tipo_producto` VARCHAR(30),
    `porcentaje_negociado` DOUBLE DEFAULT 0,
    `token_visa` TEXT,
    `token_visa_test` TEXT,
    `epay_terminal` VARCHAR(450),
    `epay_merchant` VARCHAR(450),
    `epay_user` VARCHAR(450),
    `epay_key` VARCHAR(450),
    `test_visa` TINYINT(1) DEFAULT 1,
    `merchand_id` VARCHAR(260),
    `org_id` VARCHAR(50),
    `numero_cliente_vol` VARCHAR(50),
    `retiene_iva` TINYINT(1) DEFAULT 0,
    `retine_isr` TINYINT(1) DEFAULT 0,
    `exento_isr` TINYINT(1) DEFAULT 0,
    `cuenta_contable` VARCHAR(20),
    PRIMARY KEY (`id`),
    INDEX `proveedor_FI_1` (`empresa_id`),
    INDEX `proveedor_FI_2` (`departamento_id`),
    INDEX `proveedor_FI_3` (`municipio_id`),
    CONSTRAINT `proveedor_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `proveedor_FK_2`
        FOREIGN KEY (`departamento_id`)
        REFERENCES `departamento` (`id`),
    CONSTRAINT `proveedor_FK_3`
        FOREIGN KEY (`municipio_id`)
        REFERENCES `municipio` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- tipo_servicio
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tipo_servicio`;

CREATE TABLE `tipo_servicio`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `codigo` VARCHAR(50),
    `nombre` VARCHAR(150) NOT NULL,
    `activo` TINYINT(1) DEFAULT 1,
    `dia_credito` INTEGER DEFAULT 0,
    `cuenta_contable` VARCHAR(50),
    `precio` DOUBLE DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `tipo_servicio_FI_1` (`empresa_id`),
    CONSTRAINT `tipo_servicio_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- orden_proveedor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `orden_proveedor`;

CREATE TABLE `orden_proveedor`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `empresa_id` INTEGER,
    `proveedor_id` INTEGER,
    `nit` VARCHAR(50),
    `nombre` VARCHAR(150),
    `no_documento` VARCHAR(50),
    `fecha_documento` DATE,
    `fecha_contabilizacion` DATE,
    `fecha` DATETIME,
    `dia_credito` INTEGER DEFAULT 0,
    `excento` TINYINT(1) DEFAULT 0,
    `usuario` VARCHAR(50),
    `estatus` VARCHAR(50),
    `comentario` VARCHAR(450),
    `sub_total` DOUBLE,
    `iva` DOUBLE,
    `valor_total` DOUBLE,
    `partida_no` INTEGER DEFAULT 0,
    `tienda_id` INTEGER,
    `serie` VARCHAR(50),
    `token` VARCHAR(50),
    `usuario_confirmo` VARCHAR(50),
    `fecha_confirmo` DATETIME,
    `despacho` TINYINT(1) DEFAULT 0,
    `valor_pagado` DOUBLE,
    `aplica_isr` TINYINT(1) DEFAULT 1,
    `aplica_iva` TINYINT(1) DEFAULT 1,
    `valor_impuesto` DOUBLE,
    `excento_isr` TINYINT(1) DEFAULT 0,
    `valor_isr` DOUBLE,
    `valor_retiene_iva` DOUBLE,
    `confrontado_sat` TINYINT(1) DEFAULT 0,
    `no_sat` INTEGER DEFAULT 0,
    `impuesto_gas` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `orden_proveedor_I_1` (`no_sat`),
    INDEX `orden_proveedor_FI_1` (`empresa_id`),
    INDEX `orden_proveedor_FI_2` (`proveedor_id`),
    INDEX `orden_proveedor_FI_3` (`tienda_id`),
    CONSTRAINT `orden_proveedor_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `orden_proveedor_FK_2`
        FOREIGN KEY (`proveedor_id`)
        REFERENCES `proveedor` (`id`),
    CONSTRAINT `orden_proveedor_FK_3`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- orden_proveedor_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `orden_proveedor_detalle`;

CREATE TABLE `orden_proveedor_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `orden_proveedor_id` INTEGER,
    `producto_id` INTEGER,
    `servicio_id` INTEGER,
    `codigo` VARCHAR(50),
    `detalle` VARCHAR(150),
    `valor_unitario` DOUBLE,
    `cantidad` DOUBLE,
    `valor_total` DOUBLE,
    `total_iva` DOUBLE,
    `observaciones` VARCHAR(450),
    `valor_isr` DOUBLE,
    `impuesto_gas` DOUBLE,
    `valor_retiene_iva` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `orden_proveedor_detalle_FI_1` (`orden_proveedor_id`),
    INDEX `orden_proveedor_detalle_FI_2` (`producto_id`),
    INDEX `orden_proveedor_detalle_FI_3` (`servicio_id`),
    CONSTRAINT `orden_proveedor_detalle_FK_1`
        FOREIGN KEY (`orden_proveedor_id`)
        REFERENCES `orden_proveedor` (`id`),
    CONSTRAINT `orden_proveedor_detalle_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `orden_proveedor_detalle_FK_3`
        FOREIGN KEY (`servicio_id`)
        REFERENCES `servicio` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cuenta_proveedor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cuenta_proveedor`;

CREATE TABLE `cuenta_proveedor`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `orden_proveedor_id` INTEGER,
    `proveedor_id` INTEGER,
    `fecha` DATE,
    `detalle` VARCHAR(350),
    `valor_total` DOUBLE,
    `fecha_pago` DATE,
    `valor_pagado` DOUBLE,
    `cuenta_contable` VARCHAR(50) DEFAULT '',
    `pagado` TINYINT(1) DEFAULT 0,
    `updated_by` VARCHAR(32),
    `updated_at` DATETIME,
    `gasto_id` INTEGER,
    `contrasena_no` INTEGER DEFAULT 0,
    `seleccionado` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `cuenta_proveedor_I_1` (`pagado`),
    INDEX `cuenta_proveedor_I_2` (`contrasena_no`),
    INDEX `cuenta_proveedor_FI_1` (`empresa_id`),
    INDEX `cuenta_proveedor_FI_2` (`orden_proveedor_id`),
    INDEX `cuenta_proveedor_FI_3` (`proveedor_id`),
    INDEX `cuenta_proveedor_FI_4` (`gasto_id`),
    CONSTRAINT `cuenta_proveedor_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `cuenta_proveedor_FK_2`
        FOREIGN KEY (`orden_proveedor_id`)
        REFERENCES `orden_proveedor` (`id`),
    CONSTRAINT `cuenta_proveedor_FK_3`
        FOREIGN KEY (`proveedor_id`)
        REFERENCES `proveedor` (`id`),
    CONSTRAINT `cuenta_proveedor_FK_4`
        FOREIGN KEY (`gasto_id`)
        REFERENCES `gasto` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- contrasena_crea
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `contrasena_crea`;

CREATE TABLE `contrasena_crea`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `fecha` DATE,
    `estatus` VARCHAR(50),
    `proveedor_id` INTEGER,
    `dias_credito` INTEGER,
    `fecha_pago` DATE,
    `valor` DOUBLE,
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `contrasena_crea_FI_1` (`proveedor_id`),
    INDEX `contrasena_crea_FI_2` (`empresa_id`),
    CONSTRAINT `contrasena_crea_FK_1`
        FOREIGN KEY (`proveedor_id`)
        REFERENCES `proveedor` (`id`),
    CONSTRAINT `contrasena_crea_FK_2`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- orden_proveedor_pago
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `orden_proveedor_pago`;

CREATE TABLE `orden_proveedor_pago`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `empresa_id` INTEGER,
    `proveedor_id` INTEGER,
    `orden_proveedor_id` INTEGER,
    `tipo_pago` VARCHAR(50),
    `documento` VARCHAR(150),
    `fecha` DATE,
    `valor_total` DOUBLE,
    `usuario` VARCHAR(50),
    `fecha_creo` DATETIME,
    `cuenta_proveedor_id` INTEGER,
    `banco_id` INTEGER,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `cuenta_contable` VARCHAR(50) DEFAULT '',
    `partida_no` INTEGER DEFAULT 0,
    `cheque_id` INTEGER,
    `temporal` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `orden_proveedor_pago_FI_1` (`empresa_id`),
    INDEX `orden_proveedor_pago_FI_2` (`proveedor_id`),
    INDEX `orden_proveedor_pago_FI_3` (`orden_proveedor_id`),
    INDEX `orden_proveedor_pago_FI_4` (`cuenta_proveedor_id`),
    INDEX `orden_proveedor_pago_FI_5` (`banco_id`),
    INDEX `orden_proveedor_pago_FI_6` (`cheque_id`),
    CONSTRAINT `orden_proveedor_pago_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `orden_proveedor_pago_FK_2`
        FOREIGN KEY (`proveedor_id`)
        REFERENCES `proveedor` (`id`),
    CONSTRAINT `orden_proveedor_pago_FK_3`
        FOREIGN KEY (`orden_proveedor_id`)
        REFERENCES `orden_proveedor` (`id`),
    CONSTRAINT `orden_proveedor_pago_FK_4`
        FOREIGN KEY (`cuenta_proveedor_id`)
        REFERENCES `cuenta_proveedor` (`id`),
    CONSTRAINT `orden_proveedor_pago_FK_5`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`),
    CONSTRAINT `orden_proveedor_pago_FK_6`
        FOREIGN KEY (`cheque_id`)
        REFERENCES `cheque` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- correlativo_codigo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `correlativo_codigo`;

CREATE TABLE `correlativo_codigo`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `numero_asginar` INTEGER,
    `prefijo` VARCHAR(50),
    `tipo` VARCHAR(250),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- bitacora_archivo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bitacora_archivo`;

CREATE TABLE `bitacora_archivo`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `tipo` VARCHAR(60),
    `nombre` VARCHAR(260) DEFAULT '' NOT NULL,
    `nombre_original` VARCHAR(260),
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `empresa_id` INTEGER,
    `carpeta` VARCHAR(150),
    PRIMARY KEY (`id`),
    INDEX `bitacora_archivo_FI_1` (`empresa_id`),
    CONSTRAINT `bitacora_archivo_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- menu_seguridad
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu_seguridad`;

CREATE TABLE `menu_seguridad`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `descripcion` VARCHAR(100) DEFAULT '',
    `credencial` VARCHAR(100),
    `modulo` VARCHAR(100),
    `icono` VARCHAR(150),
    `accion` VARCHAR(100),
    `superior` INTEGER,
    `orden` INTEGER,
    `sub_menu` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- perfil_menu
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `perfil_menu`;

CREATE TABLE `perfil_menu`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `perfil_id` INTEGER,
    `menu_seguridad_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `perfil_menu_FI_1` (`perfil_id`),
    INDEX `perfil_menu_FI_2` (`menu_seguridad_id`),
    CONSTRAINT `perfil_menu_FK_1`
        FOREIGN KEY (`perfil_id`)
        REFERENCES `perfil` (`id`),
    CONSTRAINT `perfil_menu_FK_2`
        FOREIGN KEY (`menu_seguridad_id`)
        REFERENCES `menu_seguridad` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- usuario_perfil
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `usuario_perfil`;

CREATE TABLE `usuario_perfil`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `perfil_id` INTEGER,
    `usuario_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `usuario_perfil_FI_1` (`perfil_id`),
    INDEX `usuario_perfil_FI_2` (`usuario_id`),
    CONSTRAINT `usuario_perfil_FK_1`
        FOREIGN KEY (`perfil_id`)
        REFERENCES `perfil` (`id`),
    CONSTRAINT `usuario_perfil_FK_2`
        FOREIGN KEY (`usuario_id`)
        REFERENCES `usuario` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- perfil
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `perfil`;

CREATE TABLE `perfil`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `descripcion` VARCHAR(100) DEFAULT '',
    `observaciones` TEXT,
    `activo` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- bitacora_elimino
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bitacora_elimino`;

CREATE TABLE `bitacora_elimino`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `tipo` VARCHAR(60),
    `codigo` VARCHAR(60),
    `fecha` DATETIME,
    `observaciones` TEXT,
    `datos` TEXT,
    `empresa_id` INTEGER,
    `usuario` VARCHAR(50),
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `bitacora_elimino_FI_1` (`empresa_id`),
    CONSTRAINT `bitacora_elimino_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- parametro
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `parametro`;

CREATE TABLE `parametro`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `logo` VARCHAR(150),
    `puerto_correo` VARCHAR(50),
    `smtp_correo` VARCHAR(50),
    `usuario_correo` VARCHAR(100),
    `clave_correo` VARCHAR(100),
    `bienvenida` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- medio_pago
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `medio_pago`;

CREATE TABLE `medio_pago`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `codigo` VARCHAR(50),
    `nombre` VARCHAR(150) NOT NULL,
    `activo` TINYINT(1) DEFAULT 1,
    `cuenta_contable` VARCHAR(50),
    `orden` INTEGER,
    `pos` TINYINT(1) DEFAULT 1,
    `aplica_mov_banco` TINYINT(1) DEFAULT 0,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `aplica_cuotas` TINYINT(1) DEFAULT 0,
    `numero_cuotas` INTEGER,
    `comision` DOUBLE,
    `retiene_isr` TINYINT(1) DEFAULT 0,
    `pide_banco` TINYINT(1) DEFAULT 0,
    `banco_id` INTEGER,
    `pago_proveedor` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `medio_pago_FI_1` (`empresa_id`),
    INDEX `medio_pago_FI_2` (`banco_id`),
    CONSTRAINT `medio_pago_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `medio_pago_FK_2`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- tienda
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tienda`;

CREATE TABLE `tienda`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `codigo` VARCHAR(50),
    `nombre` VARCHAR(150) NOT NULL,
    `codigo_establecimiento` VARCHAR(50),
    `direccion` VARCHAR(250),
    `departamento_id` INTEGER,
    `municipio_id` INTEGER,
    `observaciones` TEXT,
    `correo` VARCHAR(150),
    `telefono` VARCHAR(150),
    `nombre_comercial` VARCHAR(250),
    `activo` TINYINT(1) DEFAULT 1,
    `cuenta_debe` VARCHAR(50),
    `cuenta_haber` VARCHAR(50),
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `tipo` VARCHAR(32),
    PRIMARY KEY (`id`),
    INDEX `tienda_FI_1` (`empresa_id`),
    INDEX `tienda_FI_2` (`departamento_id`),
    INDEX `tienda_FI_3` (`municipio_id`),
    CONSTRAINT `tienda_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `tienda_FK_2`
        FOREIGN KEY (`departamento_id`)
        REFERENCES `departamento` (`id`),
    CONSTRAINT `tienda_FK_3`
        FOREIGN KEY (`municipio_id`)
        REFERENCES `municipio` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- movimiento_banco
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `movimiento_banco`;

CREATE TABLE `movimiento_banco`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `tipo` VARCHAR(50),
    `identificador` VARCHAR(1),
    `tipo_movimiento` VARCHAR(150),
    `banco_id` INTEGER,
    `documento` VARCHAR(50),
    `fecha_documento` DATE,
    `valor` DOUBLE,
    `usuario` VARCHAR(50),
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `cuenta_contable` VARCHAR(50) DEFAULT '',
    `partida_no` INTEGER DEFAULT 0,
    `concepto` VARCHAR(150),
    `banco_origen` INTEGER NOT NULL,
    `estatus` VARCHAR(50),
    `observaciones` TEXT,
    `medio_pago_id` INTEGER,
    `tienda_id` INTEGER,
    `bitacora_archivo_id` INTEGER,
    `confirmado_banco` TINYINT(1) DEFAULT 0,
    `usuario_confirmo_banco` VARCHAR(50),
    `fecha_confirmo_banco` DATETIME,
    `venta_resumida_linea_id` INTEGER,
    `revisado` TINYINT(1) DEFAULT 0,
    `tasa_cambio` DOUBLE DEFAULT 1,
    PRIMARY KEY (`id`),
    INDEX `movimiento_banco_I_1` (`banco_origen`),
    INDEX `movimiento_banco_FI_1` (`empresa_id`),
    INDEX `movimiento_banco_FI_2` (`banco_id`),
    INDEX `movimiento_banco_FI_4` (`medio_pago_id`),
    INDEX `movimiento_banco_FI_5` (`tienda_id`),
    INDEX `movimiento_banco_FI_6` (`bitacora_archivo_id`),
    INDEX `movimiento_banco_FI_7` (`venta_resumida_linea_id`),
    CONSTRAINT `movimiento_banco_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `movimiento_banco_FK_2`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`),
    CONSTRAINT `movimiento_banco_FK_3`
        FOREIGN KEY (`banco_origen`)
        REFERENCES `banco` (`id`),
    CONSTRAINT `movimiento_banco_FK_4`
        FOREIGN KEY (`medio_pago_id`)
        REFERENCES `medio_pago` (`id`),
    CONSTRAINT `movimiento_banco_FK_5`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `movimiento_banco_FK_6`
        FOREIGN KEY (`bitacora_archivo_id`)
        REFERENCES `bitacora_archivo` (`id`),
    CONSTRAINT `movimiento_banco_FK_7`
        FOREIGN KEY (`venta_resumida_linea_id`)
        REFERENCES `venta_resumida_linea` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- partida
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `partida`;

CREATE TABLE `partida`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fecha_contable` DATE,
    `usuario` VARCHAR(50),
    `empresa_id` INTEGER,
    `codigo` VARCHAR(50),
    `tipo` VARCHAR(150),
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `valor` DOUBLE,
    `tienda_id` INTEGER,
    `confirmada` TINYINT(1) DEFAULT 0,
    `estatus` VARCHAR(50) DEFAULT '',
    `numero` INTEGER,
    `medio_pago_id` INTEGER,
    `tipo_partida` VARCHAR(150),
    `tipo_numero` VARCHAR(20),
    `detalle` VARCHAR(150),
    `ano` INTEGER DEFAULT false,
    `mes` INTEGER DEFAULT false,
    `partida_agrupa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `partida_I_1` (`fecha_contable`),
    INDEX `partida_I_2` (`confirmada`),
    INDEX `partida_I_3` (`ano`),
    INDEX `partida_I_4` (`mes`),
    INDEX `partida_FI_1` (`empresa_id`),
    INDEX `partida_FI_2` (`tienda_id`),
    INDEX `partida_FI_3` (`medio_pago_id`),
    INDEX `partida_FI_4` (`partida_agrupa_id`),
    CONSTRAINT `partida_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `partida_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `partida_FK_3`
        FOREIGN KEY (`medio_pago_id`)
        REFERENCES `medio_pago` (`id`),
    CONSTRAINT `partida_FK_4`
        FOREIGN KEY (`partida_agrupa_id`)
        REFERENCES `partida_agrupa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- partida_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `partida_detalle`;

CREATE TABLE `partida_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `partida_id` INTEGER,
    `detalle` VARCHAR(50),
    `cuenta_contable` VARCHAR(50),
    `debe` DOUBLE,
    `haber` DOUBLE,
    `tipo` INTEGER DEFAULT 0,
    `grupo` VARCHAR(50),
    `adicional` VARCHAR(150) DEFAULT '',
    PRIMARY KEY (`id`),
    INDEX `partida_detalle_I_1` (`cuenta_contable`),
    INDEX `partida_detalle_FI_1` (`empresa_id`),
    INDEX `partida_detalle_FI_2` (`partida_id`),
    CONSTRAINT `partida_detalle_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `partida_detalle_FK_2`
        FOREIGN KEY (`partida_id`)
        REFERENCES `partida` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- partida_agrupa
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `partida_agrupa`;

CREATE TABLE `partida_agrupa`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `fecha_contable` DATE,
    `detalle` VARCHAR(50),
    `empresa_id` INTEGER,
    `revisado` TINYINT(1) DEFAULT 0,
    `ano` INTEGER DEFAULT false,
    `mes` INTEGER DEFAULT false,
    PRIMARY KEY (`id`),
    INDEX `partida_agrupa_I_1` (`fecha_contable`),
    INDEX `partida_agrupa_I_2` (`ano`),
    INDEX `partida_agrupa_I_3` (`mes`),
    INDEX `partida_agrupa_FI_1` (`empresa_id`),
    CONSTRAINT `partida_agrupa_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- partida_agrupa_linea
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `partida_agrupa_linea`;

CREATE TABLE `partida_agrupa_linea`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `detalle` VARCHAR(50),
    `cuenta_contable` VARCHAR(50),
    `debe` DOUBLE,
    `haber` DOUBLE,
    `empresa_id` INTEGER,
    `partida_agrupa_id` INTEGER,
    `cantidad` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `partida_agrupa_linea_I_1` (`cuenta_contable`),
    INDEX `partida_agrupa_linea_FI_1` (`empresa_id`),
    INDEX `partida_agrupa_linea_FI_2` (`partida_agrupa_id`),
    CONSTRAINT `partida_agrupa_linea_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `partida_agrupa_linea_FK_2`
        FOREIGN KEY (`partida_agrupa_id`)
        REFERENCES `partida_agrupa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cuenta_erp_contable
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cuenta_erp_contable`;

CREATE TABLE `cuenta_erp_contable`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `tipo` VARCHAR(50),
    `campo` VARCHAR(150),
    `nombre` VARCHAR(150),
    `cuenta_contable` VARCHAR(50),
    `fecha_inicio` DATE,
    `saldo_inicio` DOUBLE,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `cuenta_erp_contable_FI_1` (`empresa_id`),
    CONSTRAINT `cuenta_erp_contable_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- tipo_aparato
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tipo_aparato`;

CREATE TABLE `tipo_aparato`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `codigo` VARCHAR(50),
    `descripcion` VARCHAR(150) DEFAULT '',
    `activo` TINYINT(1) DEFAULT 1,
    `menu_invertido` TINYINT(1) DEFAULT 0,
    `muestra_menu` TINYINT(1) DEFAULT 1,
    `logo` VARCHAR(150),
    `cargo_peso_libra_producto` DOUBLE,
    `imagen` VARCHAR(151),
    `orden_mostrar` INTEGER DEFAULT 1,
    `menu_muestra_producto` TINYINT(1) DEFAULT 0,
    `tipo_menu` INTEGER DEFAULT 1,
    `menu_lateral` TINYINT(1) DEFAULT 0,
    `receta` TINYINT(1) DEFAULT 0,
    `status` INTEGER DEFAULT 0,
    `cuenta_contable` VARCHAR(50) DEFAULT '',
    `venta` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `llave` (`descripcion`, `empresa_id`),
    INDEX `tipo_aparato_FI_1` (`empresa_id`),
    CONSTRAINT `tipo_aparato_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- marca
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `marca`;

CREATE TABLE `marca`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `tipo_aparato_id` INTEGER,
    `codigo` VARCHAR(32),
    `descripcion` VARCHAR(260) DEFAULT '' NOT NULL,
    `muestra_menu` TINYINT(1) DEFAULT 1,
    `logo` VARCHAR(150),
    `activo` TINYINT(1) DEFAULT 1,
    `imagen` VARCHAR(150),
    `orden_mostrar` INTEGER DEFAULT 1,
    `receta` TINYINT(1) DEFAULT 0,
    `status` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `marca_FI_1` (`empresa_id`),
    INDEX `marca_FI_2` (`tipo_aparato_id`),
    CONSTRAINT `marca_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `marca_FK_2`
        FOREIGN KEY (`tipo_aparato_id`)
        REFERENCES `tipo_aparato` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- modelo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `modelo`;

CREATE TABLE `modelo`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `marca_id` INTEGER,
    `codigo` VARCHAR(32),
    `descripcion` VARCHAR(260) DEFAULT '' NOT NULL,
    `muestra_menu` TINYINT(1) DEFAULT 1,
    `logo` VARCHAR(150),
    `activo` TINYINT(1) DEFAULT 1,
    `imagen` VARCHAR(150),
    `orden_mostrar` INTEGER DEFAULT 1,
    `aparato` VARCHAR(150),
    `status` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `modelo_FI_1` (`empresa_id`),
    INDEX `modelo_FI_2` (`marca_id`),
    CONSTRAINT `modelo_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `modelo_FK_2`
        FOREIGN KEY (`marca_id`)
        REFERENCES `marca` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- producto
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `producto`;

CREATE TABLE `producto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(260) DEFAULT '' NOT NULL,
    `codigo_sku` VARCHAR(32) NOT NULL,
    `codigo_barras` VARCHAR(32),
    `descripcion_corta` TEXT,
    `descripcion` TEXT,
    `activo` TINYINT(1) DEFAULT 1,
    `tipo_aparato_id` INTEGER,
    `modelo_id` INTEGER,
    `marca_id` INTEGER,
    `existencia` INTEGER DEFAULT 0,
    `precio_anterior` DOUBLE,
    `ofertado` TINYINT(1) DEFAULT 0,
    `precio` DOUBLE,
    `orden` INTEGER DEFAULT 0,
    `codigo_proveedor` VARCHAR(250),
    `costo_proveedor` DOUBLE,
    `cargo_peso_libra_producto` DOUBLE,
    `estatus` INTEGER,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `dia_garantia` INTEGER,
    `alerta_minimo` INTEGER,
    `tercero` TINYINT(1) DEFAULT 0,
    `imagen` VARCHAR(360),
    `promocional` TINYINT(1) DEFAULT 0,
    `traslado` TINYINT(1) DEFAULT 0,
    `top_venta` TINYINT(1) DEFAULT 0,
    `salida` TINYINT(1) DEFAULT 0,
    `opcion_combo` TINYINT(1) DEFAULT 0,
    `bodega_interna` TINYINT(1) DEFAULT 0,
    `afecto_inventario` TINYINT(1) DEFAULT 0,
    `empresa_id` INTEGER,
    `receta_producto_id` INTEGER,
    `combo_producto_id` INTEGER,
    `status` INTEGER DEFAULT 0,
    `proveedor_id` INTEGER,
    `unidad_medida` VARCHAR(60),
    `unidad_medida_costo` VARCHAR(60),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `llave` (`codigo_sku`),
    INDEX `producto_FI_1` (`tipo_aparato_id`),
    INDEX `producto_FI_2` (`modelo_id`),
    INDEX `producto_FI_3` (`marca_id`),
    INDEX `producto_FI_4` (`empresa_id`),
    INDEX `producto_FI_5` (`receta_producto_id`),
    INDEX `producto_FI_6` (`combo_producto_id`),
    INDEX `producto_FI_7` (`proveedor_id`),
    CONSTRAINT `producto_FK_1`
        FOREIGN KEY (`tipo_aparato_id`)
        REFERENCES `tipo_aparato` (`id`),
    CONSTRAINT `producto_FK_2`
        FOREIGN KEY (`modelo_id`)
        REFERENCES `modelo` (`id`),
    CONSTRAINT `producto_FK_3`
        FOREIGN KEY (`marca_id`)
        REFERENCES `marca` (`id`),
    CONSTRAINT `producto_FK_4`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `producto_FK_5`
        FOREIGN KEY (`receta_producto_id`)
        REFERENCES `receta_producto` (`id`),
    CONSTRAINT `producto_FK_6`
        FOREIGN KEY (`combo_producto_id`)
        REFERENCES `combo_producto` (`id`),
    CONSTRAINT `producto_FK_7`
        FOREIGN KEY (`proveedor_id`)
        REFERENCES `proveedor` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- receta_producto
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `receta_producto`;

CREATE TABLE `receta_producto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(250),
    `activo` TINYINT(1) DEFAULT 0,
    `vence` TINYINT(1) DEFAULT 0,
    `fecha_fin` DATE,
    `afecto_inventario` TINYINT(1) DEFAULT 0,
    `precio_variable` TINYINT(1) DEFAULT 0,
    `precio` DOUBLE,
    `codigo_sku` VARCHAR(50),
    `imagen` VARCHAR(150),
    `codigo_barras` VARCHAR(50),
    `usuario_creo` VARCHAR(50),
    `fecha_creo` DATETIME,
    `usuario_confirmo` VARCHAR(50),
    `fecha_confirmo` DATETIME,
    `comentario` VARCHAR(250),
    `estatus` VARCHAR(50) DEFAULT 'Pendiente',
    `empresa_id` INTEGER,
    `descripcion` VARCHAR(250),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `llave` (`codigo_sku`),
    INDEX `receta_producto_FI_1` (`empresa_id`),
    CONSTRAINT `receta_producto_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- receta_producto_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `receta_producto_detalle`;

CREATE TABLE `receta_producto_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `receta_producto_id` INTEGER,
    `marca_id` INTEGER,
    `producto_default` INTEGER,
    `orden` INTEGER,
    `ultimo` TINYINT(1) DEFAULT 0,
    `obligatorio` TINYINT(1) DEFAULT 1,
    `precio` DOUBLE,
    `seleccion` INTEGER,
    `empresa_id` INTEGER,
    `unidad_medida` VARCHAR(50),
    `cantidad_medida` DOUBLE,
    `costo_unidad` VARCHAR(5),
    `costo_producto` DOUBLE,
    `costo_promedio` DOUBLE,
    `costo_unidad_pro` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `receta_producto_detalle_FI_1` (`receta_producto_id`),
    INDEX `receta_producto_detalle_FI_2` (`marca_id`),
    INDEX `receta_producto_detalle_FI_3` (`empresa_id`),
    CONSTRAINT `receta_producto_detalle_FK_1`
        FOREIGN KEY (`receta_producto_id`)
        REFERENCES `receta_producto` (`id`),
    CONSTRAINT `receta_producto_detalle_FK_2`
        FOREIGN KEY (`marca_id`)
        REFERENCES `marca` (`id`),
    CONSTRAINT `receta_producto_detalle_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- combo_producto
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `combo_producto`;

CREATE TABLE `combo_producto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(250),
    `activo` TINYINT(1) DEFAULT 0,
    `precio` DOUBLE,
    `codigo_sku` VARCHAR(50),
    `imagen` VARCHAR(150),
    `codigo_barras` VARCHAR(50),
    `precio_variable` TINYINT(1) DEFAULT 0,
    `empresa_id` INTEGER,
    `usuario_creo` VARCHAR(50),
    `fecha_creo` DATETIME,
    `usuario_confirmo` VARCHAR(50),
    `fecha_confirmo` DATETIME,
    `comentario` VARCHAR(250),
    `estatus` VARCHAR(50) DEFAULT 'Pendiente',
    `descripcion` VARCHAR(250),
    PRIMARY KEY (`id`),
    INDEX `combo_producto_FI_1` (`empresa_id`),
    CONSTRAINT `combo_producto_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- combo_producto_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `combo_producto_detalle`;

CREATE TABLE `combo_producto_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `combo_producto_id` INTEGER,
    `marca_id` INTEGER,
    `producto_default` INTEGER,
    `orden` INTEGER,
    `ultimo` TINYINT(1) DEFAULT 0,
    `obligatorio` TINYINT(1) DEFAULT 1,
    `precio` DOUBLE,
    `seleccion` INTEGER,
    `empresa_id` INTEGER,
    `unidad_medida` VARCHAR(50),
    `cantidad_medida` DOUBLE,
    `costo_unidad` VARCHAR(5),
    `costo_producto` DOUBLE,
    `costo_promedio` DOUBLE,
    `costo_unidad_pro` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `combo_producto_detalle_FI_1` (`combo_producto_id`),
    INDEX `combo_producto_detalle_FI_2` (`marca_id`),
    INDEX `combo_producto_detalle_FI_3` (`empresa_id`),
    CONSTRAINT `combo_producto_detalle_FK_1`
        FOREIGN KEY (`combo_producto_id`)
        REFERENCES `combo_producto` (`id`),
    CONSTRAINT `combo_producto_detalle_FK_2`
        FOREIGN KEY (`marca_id`)
        REFERENCES `marca` (`id`),
    CONSTRAINT `combo_producto_detalle_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- lista_combo_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `lista_combo_detalle`;

CREATE TABLE `lista_combo_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `combo_producto_detalle_id` INTEGER,
    `producto_id` INTEGER,
    `empresa_id` INTEGER,
    `precio` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `lista_combo_detalle_FI_1` (`combo_producto_detalle_id`),
    INDEX `lista_combo_detalle_FI_2` (`producto_id`),
    INDEX `lista_combo_detalle_FI_3` (`empresa_id`),
    CONSTRAINT `lista_combo_detalle_FK_1`
        FOREIGN KEY (`combo_producto_detalle_id`)
        REFERENCES `combo_producto_detalle` (`id`),
    CONSTRAINT `lista_combo_detalle_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `lista_combo_detalle_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- lista_receta_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `lista_receta_detalle`;

CREATE TABLE `lista_receta_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `receta_producto_detalle_id` INTEGER,
    `producto_id` INTEGER,
    `empresa_id` INTEGER,
    `precio` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `lista_receta_detalle_FI_1` (`receta_producto_detalle_id`),
    INDEX `lista_receta_detalle_FI_2` (`producto_id`),
    INDEX `lista_receta_detalle_FI_3` (`empresa_id`),
    CONSTRAINT `lista_receta_detalle_FK_1`
        FOREIGN KEY (`receta_producto_detalle_id`)
        REFERENCES `receta_producto_detalle` (`id`),
    CONSTRAINT `lista_receta_detalle_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `lista_receta_detalle_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ingreso_producto_pro
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ingreso_producto_pro`;

CREATE TABLE `ingreso_producto_pro`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `codigo_proveedor` VARCHAR(50),
    `proveedor_id` INTEGER,
    `tienda_id` INTEGER,
    `numero_documento` VARCHAR(50),
    `fecha_documento` DATE,
    `fecha_contabilizacion` DATE,
    `observaciones` TEXT,
    `tipo` VARCHAR(20),
    `motivo` VARCHAR(50),
    `estatus` VARCHAR(20),
    `usuario_id` INTEGER,
    `confirmado` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `bodega_origen` VARCHAR(50),
    `serie_documento` VARCHAR(250),
    `correlativo` VARCHAR(10),
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `ingreso_producto_pro_FI_1` (`proveedor_id`),
    INDEX `ingreso_producto_pro_FI_2` (`tienda_id`),
    INDEX `ingreso_producto_pro_FI_3` (`usuario_id`),
    INDEX `ingreso_producto_pro_FI_4` (`empresa_id`),
    CONSTRAINT `ingreso_producto_pro_FK_1`
        FOREIGN KEY (`proveedor_id`)
        REFERENCES `proveedor` (`id`),
    CONSTRAINT `ingreso_producto_pro_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `ingreso_producto_pro_FK_3`
        FOREIGN KEY (`usuario_id`)
        REFERENCES `usuario` (`id`),
    CONSTRAINT `ingreso_producto_pro_FK_4`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ingreso_producto_detalle_pro
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ingreso_producto_detalle_pro`;

CREATE TABLE `ingreso_producto_detalle_pro`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `ingreso_producto_pro_id` INTEGER,
    `producto_id` INTEGER,
    `codigo` VARCHAR(42),
    `detalle` VARCHAR(300),
    `valor` DOUBLE,
    `cantidad` INTEGER,
    `valor_total` DOUBLE,
    `excento` TINYINT(1) DEFAULT 0,
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `ingreso_producto_detalle_pro_FI_1` (`ingreso_producto_pro_id`),
    INDEX `ingreso_producto_detalle_pro_FI_2` (`producto_id`),
    INDEX `ingreso_producto_detalle_pro_FI_3` (`empresa_id`),
    CONSTRAINT `ingreso_producto_detalle_pro_FK_1`
        FOREIGN KEY (`ingreso_producto_pro_id`)
        REFERENCES `ingreso_producto_pro` (`id`),
    CONSTRAINT `ingreso_producto_detalle_pro_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `ingreso_producto_detalle_pro_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- salida_producto
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `salida_producto`;

CREATE TABLE `salida_producto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `tienda_id` INTEGER,
    `numero_documento` VARCHAR(50),
    `fecha_documento` DATE,
    `fecha_contabilizacion` DATE,
    `observaciones` TEXT,
    `tipo` VARCHAR(20),
    `motivo` VARCHAR(50),
    `estatus` VARCHAR(20),
    `usuario_id` INTEGER,
    `confirmado` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `bodega_destino` VARCHAR(50),
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `salida_producto_FI_1` (`tienda_id`),
    INDEX `salida_producto_FI_2` (`usuario_id`),
    INDEX `salida_producto_FI_3` (`empresa_id`),
    CONSTRAINT `salida_producto_FK_1`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `salida_producto_FK_2`
        FOREIGN KEY (`usuario_id`)
        REFERENCES `usuario` (`id`),
    CONSTRAINT `salida_producto_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- salida_producto_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `salida_producto_detalle`;

CREATE TABLE `salida_producto_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `salida_producto_id` INTEGER,
    `producto_id` INTEGER,
    `codigo` VARCHAR(42),
    `detalle` VARCHAR(300),
    `valor` DOUBLE,
    `cantidad` INTEGER,
    `valor_total` DOUBLE,
    `excento` TINYINT(1) DEFAULT 0,
    `confirmado` TINYINT(1) DEFAULT 0,
    `usuario_id` INTEGER,
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `salida_producto_detalle_FI_1` (`salida_producto_id`),
    INDEX `salida_producto_detalle_FI_2` (`producto_id`),
    INDEX `salida_producto_detalle_FI_3` (`usuario_id`),
    INDEX `salida_producto_detalle_FI_4` (`empresa_id`),
    CONSTRAINT `salida_producto_detalle_FK_1`
        FOREIGN KEY (`salida_producto_id`)
        REFERENCES `salida_producto` (`id`),
    CONSTRAINT `salida_producto_detalle_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `salida_producto_detalle_FK_3`
        FOREIGN KEY (`usuario_id`)
        REFERENCES `usuario` (`id`),
    CONSTRAINT `salida_producto_detalle_FK_4`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- motivo_movimiento_producto
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `motivo_movimiento_producto`;

CREATE TABLE `motivo_movimiento_producto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(32),
    `nombre` VARCHAR(200) DEFAULT '' NOT NULL,
    `descripcion` TEXT,
    `activo` TINYINT(1) DEFAULT 1,
    `empresa_id` INTEGER,
    `tipo` VARCHAR(32),
    PRIMARY KEY (`id`),
    INDEX `motivo_movimiento_producto_FI_1` (`empresa_id`),
    CONSTRAINT `motivo_movimiento_producto_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cliente
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cliente`;

CREATE TABLE `cliente`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `codigo` VARCHAR(32),
    `nombre` VARCHAR(260) DEFAULT '' NOT NULL,
    `pequeno_contribuye` TINYINT(1) DEFAULT 0,
    `regimen_isr` TINYINT(1) DEFAULT 0,
    `direccion` VARCHAR(160),
    `telefono` VARCHAR(260),
    `correo_electronico` VARCHAR(160),
    `observaciones` TEXT,
    `nit` VARCHAR(20),
    `dias_credito` INTEGER,
    `tipo_referencia` VARCHAR(120),
    `activo` TINYINT(1) DEFAULT 1,
    `tiene_credito` TINYINT(1) DEFAULT 1,
    `avenida_calle` VARCHAR(10),
    `zona` VARCHAR(10),
    `departamento_id` INTEGER,
    `municipio_id` INTEGER,
    `contacto` VARCHAR(160),
    `correo_contacto` VARCHAR(160),
    `imagen` VARCHAR(160),
    `telefono_contacto` VARCHAR(60),
    `tipificacion` INTEGER DEFAULT 0,
    `fecha` DATETIME,
    `tipo_producto` VARCHAR(30),
    `porcentaje_negociado` DOUBLE DEFAULT 0,
    `limite_credito` DOUBLE DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `cliente_FI_1` (`empresa_id`),
    INDEX `cliente_FI_2` (`departamento_id`),
    INDEX `cliente_FI_3` (`municipio_id`),
    CONSTRAINT `cliente_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `cliente_FK_2`
        FOREIGN KEY (`departamento_id`)
        REFERENCES `departamento` (`id`),
    CONSTRAINT `cliente_FK_3`
        FOREIGN KEY (`municipio_id`)
        REFERENCES `municipio` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cierre_caja
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cierre_caja`;

CREATE TABLE `cierre_caja`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fecha_creo` DATETIME,
    `usuario` VARCHAR(50),
    `fecha_calendario` DATE,
    `valor_total` DOUBLE,
    `no_documentos` INTEGER,
    `valor_caja` DOUBLE,
    `estatus` VARCHAR(50),
    `inicio` DATETIME,
    `fin` DATETIME,
    `empresa_id` INTEGER,
    `tienda_id` INTEGER,
    `cierre_dia_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `cierre_caja_FI_1` (`empresa_id`),
    INDEX `cierre_caja_FI_2` (`tienda_id`),
    INDEX `cierre_caja_FI_3` (`cierre_dia_id`),
    CONSTRAINT `cierre_caja_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `cierre_caja_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `cierre_caja_FK_3`
        FOREIGN KEY (`cierre_dia_id`)
        REFERENCES `cierre_dia` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cierre_caja_valor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cierre_caja_valor`;

CREATE TABLE `cierre_caja_valor`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `cierre_caja_id` INTEGER,
    `medio_pago` VARCHAR(50),
    `valor` DOUBLE,
    `documento` VARCHAR(50),
    `banco_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `cierre_caja_valor_FI_1` (`cierre_caja_id`),
    INDEX `cierre_caja_valor_FI_2` (`banco_id`),
    CONSTRAINT `cierre_caja_valor_FK_1`
        FOREIGN KEY (`cierre_caja_id`)
        REFERENCES `cierre_caja` (`id`),
    CONSTRAINT `cierre_caja_valor_FK_2`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- usuario_corte_valor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `usuario_corte_valor`;

CREATE TABLE `usuario_corte_valor`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `usuario_id` INTEGER,
    `banco_id` INTEGER,
    `documento` VARCHAR(50),
    `medio_pago` VARCHAR(50),
    `valor` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `usuario_corte_valor_FI_1` (`usuario_id`),
    INDEX `usuario_corte_valor_FI_2` (`banco_id`),
    CONSTRAINT `usuario_corte_valor_FK_1`
        FOREIGN KEY (`usuario_id`)
        REFERENCES `usuario` (`id`),
    CONSTRAINT `usuario_corte_valor_FK_2`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- check_lista
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `check_lista`;

CREATE TABLE `check_lista`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(50),
    `activo` TINYINT(1) DEFAULT 0,
    `orden` INTEGER,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cierre_check
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cierre_check`;

CREATE TABLE `cierre_check`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `check_lista_id` INTEGER,
    `cierre_caja_id` INTEGER,
    `cierre_dia_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `cierre_check_FI_1` (`check_lista_id`),
    INDEX `cierre_check_FI_2` (`cierre_caja_id`),
    INDEX `cierre_check_FI_3` (`cierre_dia_id`),
    CONSTRAINT `cierre_check_FK_1`
        FOREIGN KEY (`check_lista_id`)
        REFERENCES `check_lista` (`id`),
    CONSTRAINT `cierre_check_FK_2`
        FOREIGN KEY (`cierre_caja_id`)
        REFERENCES `cierre_caja` (`id`),
    CONSTRAINT `cierre_check_FK_3`
        FOREIGN KEY (`cierre_dia_id`)
        REFERENCES `cierre_dia` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cierre_dia
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cierre_dia`;

CREATE TABLE `cierre_dia`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fecha_creo` DATETIME,
    `usuario` VARCHAR(50),
    `valor_total` DOUBLE,
    `no_cierre` INTEGER,
    `empresa_id` INTEGER,
    `tienda_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `cierre_dia_FI_1` (`empresa_id`),
    INDEX `cierre_dia_FI_2` (`tienda_id`),
    CONSTRAINT `cierre_dia_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `cierre_dia_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- servicio
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `servicio`;

CREATE TABLE `servicio`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(32),
    `nombre` VARCHAR(260) DEFAULT '' NOT NULL,
    `activo` TINYINT(1) DEFAULT 1,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `observaciones` TEXT,
    `empresa_id` INTEGER,
    `precio` DOUBLE DEFAULT 0,
    `cuenta_contable` VARCHAR(32),
    PRIMARY KEY (`id`),
    INDEX `servicio_FI_1` (`empresa_id`),
    CONSTRAINT `servicio_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- nombre_banco
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `nombre_banco`;

CREATE TABLE `nombre_banco`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(260) DEFAULT '' NOT NULL,
    `activo` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- campo_usuario
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `campo_usuario`;

CREATE TABLE `campo_usuario`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `tipo_documento` VARCHAR(50),
    `codigo` VARCHAR(32),
    `nombre` VARCHAR(260) DEFAULT '' NOT NULL,
    `tipo_campo` VARCHAR(50),
    `valores` TEXT,
    `requerido` TINYINT(1) DEFAULT 0,
    `activo` TINYINT(1) DEFAULT 1,
    `orden` INTEGER,
    `tienda_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `campo_usuario_FI_1` (`empresa_id`),
    INDEX `campo_usuario_FI_2` (`tienda_id`),
    CONSTRAINT `campo_usuario_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `campo_usuario_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- valor_usuario
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `valor_usuario`;

CREATE TABLE `valor_usuario`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `campo_usuario_id` INTEGER,
    `nombre_campo` VARCHAR(150),
    `tipo_documento` VARCHAR(50) DEFAULT '',
    `no_documento` INTEGER,
    `valor` VARCHAR(50),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `valor_usuario_I_1` (`tipo_documento`),
    INDEX `valor_usuario_I_2` (`no_documento`),
    INDEX `valor_usuario_FI_1` (`campo_usuario_id`),
    INDEX `valor_usuario_FI_2` (`empresa_id`),
    CONSTRAINT `valor_usuario_FK_1`
        FOREIGN KEY (`campo_usuario_id`)
        REFERENCES `campo_usuario` (`id`),
    CONSTRAINT `valor_usuario_FK_2`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- proyecto
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `proyecto`;

CREATE TABLE `proyecto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(32),
    `nombre` VARCHAR(260) DEFAULT '' NOT NULL,
    `activo` TINYINT(1) DEFAULT 1,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `observaciones` TEXT,
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `proyecto_FI_1` (`empresa_id`),
    CONSTRAINT `proyecto_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- gasto
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `gasto`;

CREATE TABLE `gasto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `usuario` VARCHAR(32),
    `excento` TINYINT(1) DEFAULT 0,
    `empresa_id` INTEGER,
    `proyecto_id` INTEGER,
    `proveedor_id` INTEGER,
    `orden_proveedor_id` INTEGER,
    `fecha` DATETIME,
    `tienda_id` INTEGER,
    `estatus` VARCHAR(32),
    `dias_credito` INTEGER,
    `tipo_documento` VARCHAR(32),
    `documento` VARCHAR(150),
    `sub_total` DOUBLE,
    `iva` DOUBLE,
    `valor_total` DOUBLE,
    `partida_no` INTEGER DEFAULT 0,
    `token` VARCHAR(50),
    `observaciones` TEXT,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `valor_pagado` DOUBLE DEFAULT 0,
    `aplica_isr` TINYINT(1) DEFAULT 1,
    `aplica_iva` TINYINT(1) DEFAULT 1,
    `valor_impuesto` DOUBLE,
    `excento_isr` TINYINT(1) DEFAULT 0,
    `valor_isr` DOUBLE,
    `valor_retiene_iva` DOUBLE,
    `retiene_iva` TINYINT(1) DEFAULT 0,
    `valor_retenido_iva` DOUBLE DEFAULT 0,
    `confrontado_sat` TINYINT(1) DEFAULT 0,
    `no_sat` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `gasto_I_1` (`no_sat`),
    INDEX `gasto_FI_1` (`empresa_id`),
    INDEX `gasto_FI_2` (`proyecto_id`),
    INDEX `gasto_FI_3` (`proveedor_id`),
    INDEX `gasto_FI_4` (`orden_proveedor_id`),
    INDEX `gasto_FI_5` (`tienda_id`),
    CONSTRAINT `gasto_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `gasto_FK_2`
        FOREIGN KEY (`proyecto_id`)
        REFERENCES `proyecto` (`id`),
    CONSTRAINT `gasto_FK_3`
        FOREIGN KEY (`proveedor_id`)
        REFERENCES `proveedor` (`id`),
    CONSTRAINT `gasto_FK_4`
        FOREIGN KEY (`orden_proveedor_id`)
        REFERENCES `orden_proveedor` (`id`),
    CONSTRAINT `gasto_FK_5`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- gasto_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `gasto_detalle`;

CREATE TABLE `gasto_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `gasto_id` INTEGER,
    `cuenta_contable` VARCHAR(50),
    `concepto` VARCHAR(350),
    `cantidad` DOUBLE,
    `sub_total` DOUBLE,
    `iva` DOUBLE,
    `valor_total` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `gasto_detalle_FI_1` (`gasto_id`),
    CONSTRAINT `gasto_detalle_FK_1`
        FOREIGN KEY (`gasto_id`)
        REFERENCES `gasto` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- gasto_pago
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `gasto_pago`;

CREATE TABLE `gasto_pago`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `empresa_id` INTEGER,
    `proveedor_id` INTEGER,
    `gasto_id` INTEGER,
    `tipo_pago` VARCHAR(50),
    `documento` VARCHAR(150),
    `fecha` DATE,
    `valor_total` DOUBLE,
    `usuario` VARCHAR(50),
    `fecha_creo` DATETIME,
    `cuenta_proveedor_id` INTEGER,
    `banco_id` INTEGER,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `cuenta_contable` VARCHAR(50) DEFAULT '',
    `partida_no` INTEGER DEFAULT 0,
    `cheque_id` INTEGER,
    `temporal` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `gasto_pago_FI_1` (`empresa_id`),
    INDEX `gasto_pago_FI_2` (`proveedor_id`),
    INDEX `gasto_pago_FI_3` (`gasto_id`),
    INDEX `gasto_pago_FI_4` (`cuenta_proveedor_id`),
    INDEX `gasto_pago_FI_5` (`banco_id`),
    INDEX `gasto_pago_FI_6` (`cheque_id`),
    CONSTRAINT `gasto_pago_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `gasto_pago_FK_2`
        FOREIGN KEY (`proveedor_id`)
        REFERENCES `proveedor` (`id`),
    CONSTRAINT `gasto_pago_FK_3`
        FOREIGN KEY (`gasto_id`)
        REFERENCES `gasto` (`id`),
    CONSTRAINT `gasto_pago_FK_4`
        FOREIGN KEY (`cuenta_proveedor_id`)
        REFERENCES `cuenta_proveedor` (`id`),
    CONSTRAINT `gasto_pago_FK_5`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`),
    CONSTRAINT `gasto_pago_FK_6`
        FOREIGN KEY (`cheque_id`)
        REFERENCES `cheque` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- parametro_cuenta
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `parametro_cuenta`;

CREATE TABLE `parametro_cuenta`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `tipo` VARCHAR(50),
    `empresa_id` INTEGER,
    `cuenta_default` VARCHAR(50),
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `parametro_cuenta_FI_1` (`empresa_id`),
    CONSTRAINT `parametro_cuenta_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- producto_existencia
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `producto_existencia`;

CREATE TABLE `producto_existencia`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `producto_id` INTEGER,
    `cantidad` INTEGER,
    `tienda_id` INTEGER,
    `diferencia` INTEGER,
    `transito` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `producto_existencia_FI_1` (`empresa_id`),
    INDEX `producto_existencia_FI_2` (`producto_id`),
    INDEX `producto_existencia_FI_3` (`tienda_id`),
    CONSTRAINT `producto_existencia_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `producto_existencia_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `producto_existencia_FK_3`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- producto_ubicacion
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `producto_ubicacion`;

CREATE TABLE `producto_ubicacion`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `producto_id` INTEGER,
    `cantidad` INTEGER,
    `tienda_id` INTEGER,
    `ubicacion` VARCHAR(100),
    `transito` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `producto_ubicacion_FI_1` (`empresa_id`),
    INDEX `producto_ubicacion_FI_2` (`producto_id`),
    INDEX `producto_ubicacion_FI_3` (`tienda_id`),
    CONSTRAINT `producto_ubicacion_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `producto_ubicacion_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `producto_ubicacion_FK_3`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- producto_precio
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `producto_precio`;

CREATE TABLE `producto_precio`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `producto_id` INTEGER,
    `valor` INTEGER,
    `lista_precio_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `producto_precio_FI_1` (`empresa_id`),
    INDEX `producto_precio_FI_2` (`producto_id`),
    INDEX `producto_precio_FI_3` (`lista_precio_id`),
    CONSTRAINT `producto_precio_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `producto_precio_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `producto_precio_FK_3`
        FOREIGN KEY (`lista_precio_id`)
        REFERENCES `lista_precio` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- lista_precio
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `lista_precio`;

CREATE TABLE `lista_precio`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `codigo` VARCHAR(32),
    `nombre` VARCHAR(260) DEFAULT '' NOT NULL,
    `activo` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`id`),
    INDEX `lista_precio_FI_1` (`empresa_id`),
    CONSTRAINT `lista_precio_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ingreso_producto
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ingreso_producto`;

CREATE TABLE `ingreso_producto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `usuario_id` INTEGER,
    `fecha` DATETIME,
    `tienda_id` INTEGER,
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `ingreso_producto_FI_1` (`usuario_id`),
    INDEX `ingreso_producto_FI_2` (`tienda_id`),
    INDEX `ingreso_producto_FI_3` (`empresa_id`),
    CONSTRAINT `ingreso_producto_FK_1`
        FOREIGN KEY (`usuario_id`)
        REFERENCES `usuario` (`id`),
    CONSTRAINT `ingreso_producto_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `ingreso_producto_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ingreso_producto_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ingreso_producto_detalle`;

CREATE TABLE `ingreso_producto_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `producto_id` INTEGER,
    `ingreso_producto_id` INTEGER,
    `cantidad` INTEGER,
    `empresa_id` INTEGER,
    `ubicacion` VARCHAR(50),
    PRIMARY KEY (`id`),
    INDEX `ingreso_producto_detalle_FI_1` (`producto_id`),
    INDEX `ingreso_producto_detalle_FI_2` (`ingreso_producto_id`),
    INDEX `ingreso_producto_detalle_FI_3` (`empresa_id`),
    CONSTRAINT `ingreso_producto_detalle_FK_1`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `ingreso_producto_detalle_FK_2`
        FOREIGN KEY (`ingreso_producto_id`)
        REFERENCES `ingreso_producto` (`id`),
    CONSTRAINT `ingreso_producto_detalle_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- producto_movimiento
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `producto_movimiento`;

CREATE TABLE `producto_movimiento`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `producto_id` INTEGER,
    `fecha` DATETIME,
    `cantidad` INTEGER,
    `tienda_id` INTEGER,
    `identificador` VARCHAR(200),
    `tipo` VARCHAR(132),
    `motivo` VARCHAR(100),
    `inicio` DOUBLE,
    `fin` DOUBLE,
    `valor_total` DOUBLE,
    `sub_total` DOUBLE,
    `iva` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `producto_movimiento_FI_1` (`empresa_id`),
    INDEX `producto_movimiento_FI_2` (`producto_id`),
    INDEX `producto_movimiento_FI_3` (`tienda_id`),
    CONSTRAINT `producto_movimiento_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `producto_movimiento_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `producto_movimiento_FK_3`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- precio_producto
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `precio_producto`;

CREATE TABLE `precio_producto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `usuario_id` INTEGER,
    `fecha` DATETIME,
    `tienda_id` INTEGER,
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `precio_producto_FI_1` (`usuario_id`),
    INDEX `precio_producto_FI_2` (`tienda_id`),
    INDEX `precio_producto_FI_3` (`empresa_id`),
    CONSTRAINT `precio_producto_FK_1`
        FOREIGN KEY (`usuario_id`)
        REFERENCES `usuario` (`id`),
    CONSTRAINT `precio_producto_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `precio_producto_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- precio_producto_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `precio_producto_detalle`;

CREATE TABLE `precio_producto_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `producto_id` INTEGER,
    `precio_producto_id` INTEGER,
    `precio` DOUBLE,
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `precio_producto_detalle_FI_1` (`producto_id`),
    INDEX `precio_producto_detalle_FI_2` (`precio_producto_id`),
    INDEX `precio_producto_detalle_FI_3` (`empresa_id`),
    CONSTRAINT `precio_producto_detalle_FK_1`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `precio_producto_detalle_FK_2`
        FOREIGN KEY (`precio_producto_id`)
        REFERENCES `precio_producto` (`id`),
    CONSTRAINT `precio_producto_detalle_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- bitacora_cambio
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bitacora_cambio`;

CREATE TABLE `bitacora_cambio`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `tipo` VARCHAR(50),
    `observaciones` VARCHAR(450),
    `fecha` DATETIME,
    `usuario` VARCHAR(50),
    `revisado` TINYINT(1) DEFAULT 1,
    `usuario_reviso` VARCHAR(50),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- orden_cotizacion
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `orden_cotizacion`;

CREATE TABLE `orden_cotizacion`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `empresa_id` INTEGER,
    `cliente_id` INTEGER,
    `nit` VARCHAR(50),
    `nombre` VARCHAR(150),
    `fecha_documento` DATE,
    `fecha_vencimiento` DATE,
    `fecha` DATETIME,
    `dia_credito` INTEGER DEFAULT 0,
    `excento` TINYINT(1) DEFAULT 0,
    `usuario` VARCHAR(50),
    `estatus` VARCHAR(50),
    `comentario` VARCHAR(450),
    `sub_total` DOUBLE,
    `iva` DOUBLE,
    `valor_total` DOUBLE,
    `cuenta_contable` VARCHAR(50) DEFAULT '',
    `partida_no` INTEGER DEFAULT 0,
    `tienda_id` INTEGER,
    `token` VARCHAR(50),
    `telefono` VARCHAR(150),
    `direccion` VARCHAR(450),
    `correo` VARCHAR(150),
    `usuario_confirmo` VARCHAR(50),
    `fecha_confirmo` DATETIME,
    `combo_numero` VARCHAR(50),
    `recetario_id` INTEGER,
    `solicitar_bodega` TINYINT(1) DEFAULT 0,
    `cantidad_total_caja` INTEGER,
    `peso_total` VARCHAR(150),
    PRIMARY KEY (`id`),
    INDEX `orden_cotizacion_FI_1` (`empresa_id`),
    INDEX `orden_cotizacion_FI_2` (`cliente_id`),
    INDEX `orden_cotizacion_FI_3` (`tienda_id`),
    INDEX `orden_cotizacion_FI_4` (`recetario_id`),
    CONSTRAINT `orden_cotizacion_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `orden_cotizacion_FK_2`
        FOREIGN KEY (`cliente_id`)
        REFERENCES `cliente` (`id`),
    CONSTRAINT `orden_cotizacion_FK_3`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `orden_cotizacion_FK_4`
        FOREIGN KEY (`recetario_id`)
        REFERENCES `recetario` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- orden_cotizacion_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `orden_cotizacion_detalle`;

CREATE TABLE `orden_cotizacion_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `orden_cotizacion_id` INTEGER,
    `producto_id` INTEGER,
    `servicio_id` INTEGER,
    `codigo` VARCHAR(50),
    `detalle` VARCHAR(150),
    `valor_unitario` DOUBLE,
    `cantidad` INTEGER,
    `valor_total` DOUBLE,
    `total_iva` DOUBLE,
    `combo_numero` VARCHAR(50),
    `costo_unitario` DOUBLE,
    `verificado` TINYINT(1) DEFAULT 0,
    `cantidad_caja` INTEGER,
    `peso` VARCHAR(150),
    PRIMARY KEY (`id`),
    INDEX `orden_cotizacion_detalle_FI_1` (`orden_cotizacion_id`),
    INDEX `orden_cotizacion_detalle_FI_2` (`producto_id`),
    INDEX `orden_cotizacion_detalle_FI_3` (`servicio_id`),
    CONSTRAINT `orden_cotizacion_detalle_FK_1`
        FOREIGN KEY (`orden_cotizacion_id`)
        REFERENCES `orden_cotizacion` (`id`),
    CONSTRAINT `orden_cotizacion_detalle_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `orden_cotizacion_detalle_FK_3`
        FOREIGN KEY (`servicio_id`)
        REFERENCES `servicio` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- moneda
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `moneda`;

CREATE TABLE `moneda`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `codigo_iso` VARCHAR(50),
    `nombre` VARCHAR(450),
    `activo` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `moneda_FI_1` (`empresa_id`),
    CONSTRAINT `moneda_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- banco_saldo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `banco_saldo`;

CREATE TABLE `banco_saldo`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `banco_id` INTEGER,
    `moneda_id` INTEGER,
    `nombre` VARCHAR(150),
    `saldo` DOUBLE,
    `ultima_actualizacion` DATETIME,
    `ultimo_movimiento` VARCHAR(10),
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `banco_saldo_FI_1` (`banco_id`),
    INDEX `banco_saldo_FI_2` (`moneda_id`),
    INDEX `banco_saldo_FI_3` (`empresa_id`),
    CONSTRAINT `banco_saldo_FK_1`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`),
    CONSTRAINT `banco_saldo_FK_2`
        FOREIGN KEY (`moneda_id`)
        REFERENCES `moneda` (`id`),
    CONSTRAINT `banco_saldo_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- nota_credito
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `nota_credito`;

CREATE TABLE `nota_credito`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `numero` INTEGER DEFAULT 0,
    `codigo` VARCHAR(50),
    `fecha` DATE,
    `cliente_id` INTEGER,
    `proveedor_id` INTEGER,
    `nombre` VARCHAR(250),
    `documento` VARCHAR(150),
    `tipo_documento` VARCHAR(50),
    `sub_total` DOUBLE,
    `iva` DOUBLE,
    `valor_total` DOUBLE,
    `estatus` VARCHAR(150),
    `empresa_id` INTEGER,
    `medio_pago_id` INTEGER,
    `fecha_contabilizacion` DATE,
    `dias_credito` DOUBLE,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `usuario` VARCHAR(50),
    `partida_no` INTEGER DEFAULT 0,
    `concepto` VARCHAR(450),
    PRIMARY KEY (`id`),
    INDEX `nota_credito_FI_1` (`cliente_id`),
    INDEX `nota_credito_FI_2` (`proveedor_id`),
    INDEX `nota_credito_FI_3` (`empresa_id`),
    INDEX `nota_credito_FI_4` (`medio_pago_id`),
    CONSTRAINT `nota_credito_FK_1`
        FOREIGN KEY (`cliente_id`)
        REFERENCES `cliente` (`id`),
    CONSTRAINT `nota_credito_FK_2`
        FOREIGN KEY (`proveedor_id`)
        REFERENCES `proveedor` (`id`),
    CONSTRAINT `nota_credito_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `nota_credito_FK_4`
        FOREIGN KEY (`medio_pago_id`)
        REFERENCES `medio_pago` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- nota_credito_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `nota_credito_detalle`;

CREATE TABLE `nota_credito_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nota_credito_id` INTEGER,
    `cantidad` DOUBLE,
    `detalle` VARCHAR(150),
    `sub_total` DOUBLE,
    `iva` DOUBLE,
    `valor_total` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `nota_credito_detalle_FI_1` (`nota_credito_id`),
    CONSTRAINT `nota_credito_detalle_FK_1`
        FOREIGN KEY (`nota_credito_id`)
        REFERENCES `nota_credito` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- bitacora_documento
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bitacora_documento`;

CREATE TABLE `bitacora_documento`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `tipo` VARCHAR(50),
    `identificador` VARCHAR(20),
    `usuario` VARCHAR(50),
    `fecha` DATE,
    `hora` VARCHAR(8),
    `accion` VARCHAR(50),
    `comentario` TEXT,
    `ip` VARCHAR(20),
    PRIMARY KEY (`id`),
    INDEX `bitacora_documento_I_1` (`tipo`),
    INDEX `bitacora_documento_I_2` (`identificador`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- definicion_cuenta
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `definicion_cuenta`;

CREATE TABLE `definicion_cuenta`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `grupo` VARCHAR(50),
    `tipo` VARCHAR(50),
    `cuenta_contable` VARCHAR(50),
    `empresa_id` INTEGER,
    `detalle` VARCHAR(150),
    PRIMARY KEY (`id`),
    INDEX `definicion_cuenta_I_1` (`grupo`),
    INDEX `definicion_cuenta_I_2` (`tipo`),
    INDEX `definicion_cuenta_FI_1` (`empresa_id`),
    CONSTRAINT `definicion_cuenta_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- documento_cheque
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `documento_cheque`;

CREATE TABLE `documento_cheque`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `banco_id` INTEGER,
    `titulo` VARCHAR(50),
    `tipo_negociable` VARCHAR(32),
    `formato` TEXT,
    `activo` TINYINT(1) DEFAULT 0,
    `margen_superior` INTEGER,
    `margen_izquierdo` INTEGER,
    `ancho` INTEGER,
    `alto` INTEGER,
    `empresa_id` INTEGER,
    `correlativo` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `documento_cheque_FI_1` (`banco_id`),
    INDEX `documento_cheque_FI_2` (`empresa_id`),
    CONSTRAINT `documento_cheque_FK_1`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`),
    CONSTRAINT `documento_cheque_FK_2`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cheque
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cheque`;

CREATE TABLE `cheque`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `banco_id` INTEGER,
    `documento_cheque_id` INTEGER,
    `proveedor_id` INTEGER,
    `numero` VARCHAR(32),
    `beneficiario` VARCHAR(150),
    `fecha_cheque` DATE,
    `valor` DOUBLE,
    `motivo` VARCHAR(450),
    `estatus` VARCHAR(50),
    `negociable` TINYINT(1) DEFAULT 1,
    `usuario` VARCHAR(50),
    `fecha_creo` DATETIME,
    `orden_devolucion_id` INTEGER,
    `solicitud_cheque_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `cheque_FI_1` (`banco_id`),
    INDEX `cheque_FI_2` (`documento_cheque_id`),
    INDEX `cheque_FI_3` (`proveedor_id`),
    INDEX `cheque_FI_4` (`orden_devolucion_id`),
    INDEX `cheque_FI_5` (`solicitud_cheque_id`),
    CONSTRAINT `cheque_FK_1`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`),
    CONSTRAINT `cheque_FK_2`
        FOREIGN KEY (`documento_cheque_id`)
        REFERENCES `documento_cheque` (`id`),
    CONSTRAINT `cheque_FK_3`
        FOREIGN KEY (`proveedor_id`)
        REFERENCES `proveedor` (`id`),
    CONSTRAINT `cheque_FK_4`
        FOREIGN KEY (`orden_devolucion_id`)
        REFERENCES `orden_devolucion` (`id`),
    CONSTRAINT `cheque_FK_5`
        FOREIGN KEY (`solicitud_cheque_id`)
        REFERENCES `solicitud_cheque` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cuenta_banco
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cuenta_banco`;

CREATE TABLE `cuenta_banco`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `banco_id` INTEGER,
    `movimiento_banco_id` INTEGER,
    `valor` DOUBLE,
    `fecha` DATE,
    `documento` VARCHAR(50),
    `observaciones` VARCHAR(450),
    `usuario` VARCHAR(50),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `estatus` VARCHAR(10),
    `operacion_pago_id` INTEGER,
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `cuenta_banco_I_1` (`fecha`),
    INDEX `cuenta_banco_I_2` (`estatus`),
    INDEX `cuenta_banco_FI_1` (`banco_id`),
    INDEX `cuenta_banco_FI_2` (`movimiento_banco_id`),
    INDEX `cuenta_banco_FI_3` (`operacion_pago_id`),
    INDEX `cuenta_banco_FI_4` (`empresa_id`),
    CONSTRAINT `cuenta_banco_FK_1`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`),
    CONSTRAINT `cuenta_banco_FK_2`
        FOREIGN KEY (`movimiento_banco_id`)
        REFERENCES `movimiento_banco` (`id`),
    CONSTRAINT `cuenta_banco_FK_3`
        FOREIGN KEY (`operacion_pago_id`)
        REFERENCES `operacion_pago` (`id`),
    CONSTRAINT `cuenta_banco_FK_4`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- venta_resumida
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `venta_resumida`;

CREATE TABLE `venta_resumida`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `medio_pago_id` INTEGER,
    `tienda_id` INTEGER,
    `fecha` DATE,
    `total` DOUBLE,
    `comision` DOUBLE,
    `iva` DOUBLE,
    `retencion` DOUBLE,
    `documento` VARCHAR(50),
    `observaciones` VARCHAR(450),
    `usuario` VARCHAR(50),
    `created_at` DATETIME,
    `partida_no` INTEGER DEFAULT 0,
    `empresa_id` INTEGER,
    `linea` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `venta_resumida_I_1` (`fecha`),
    INDEX `venta_resumida_I_2` (`partida_no`),
    INDEX `venta_resumida_FI_1` (`medio_pago_id`),
    INDEX `venta_resumida_FI_2` (`tienda_id`),
    INDEX `venta_resumida_FI_3` (`empresa_id`),
    CONSTRAINT `venta_resumida_FK_1`
        FOREIGN KEY (`medio_pago_id`)
        REFERENCES `medio_pago` (`id`),
    CONSTRAINT `venta_resumida_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `venta_resumida_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- venta_resumida_linea
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `venta_resumida_linea`;

CREATE TABLE `venta_resumida_linea`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `venta_resumida_id` INTEGER,
    `numero_cuotas` INTEGER,
    `total_linea` DOUBLE,
    `comision_linea` DOUBLE,
    `iva_linea` DOUBLE,
    `retencion_linea` DOUBLE,
    `medio_pago_id` INTEGER,
    `empresa_id` INTEGER,
    `banco_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `venta_resumida_linea_FI_1` (`venta_resumida_id`),
    INDEX `venta_resumida_linea_FI_2` (`medio_pago_id`),
    INDEX `venta_resumida_linea_FI_3` (`empresa_id`),
    INDEX `venta_resumida_linea_FI_4` (`banco_id`),
    CONSTRAINT `venta_resumida_linea_FK_1`
        FOREIGN KEY (`venta_resumida_id`)
        REFERENCES `venta_resumida` (`id`),
    CONSTRAINT `venta_resumida_linea_FK_2`
        FOREIGN KEY (`medio_pago_id`)
        REFERENCES `medio_pago` (`id`),
    CONSTRAINT `venta_resumida_linea_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `venta_resumida_linea_FK_4`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- orden_devolucion
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `orden_devolucion`;

CREATE TABLE `orden_devolucion`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fecha` DATE,
    `nombre` VARCHAR(150),
    `referencia_factura` VARCHAR(50),
    `concepto` VARCHAR(450),
    `archivo` VARCHAR(50),
    `valor` DOUBLE,
    `retencion` TINYINT(1) DEFAULT 0,
    `partida_no` INTEGER DEFAULT 0,
    `estatus` VARCHAR(50),
    `cheque_no` INTEGER DEFAULT 0,
    `usuario_creo` VARCHAR(50),
    `created_at` DATETIME,
    `usuario_confirmo` VARCHAR(50),
    `updated_at` DATETIME,
    `motivo_autorizo` VARCHAR(150),
    `valor_otros` DOUBLE,
    `empresa_id` INTEGER,
    `token` VARCHAR(50),
    `codigo` VARCHAR(50),
    `fecha_confirmo` DATETIME,
    `porcentaje_retenie` INTEGER DEFAULT 0,
    `tipo` VARCHAR(50),
    `proveedor_id` INTEGER,
    `pago_medio` VARCHAR(50),
    `vendedor` VARCHAR(50),
    `referencia_nota` VARCHAR(50),
    `no_hollander` VARCHAR(50),
    `no_stock` VARCHAR(50),
    `descripcion` VARCHAR(450),
    `solicitud_devolucion_id` INTEGER,
    `archivo_2` VARCHAR(50),
    `tienda_id` INTEGER,
    `fecha_factura` DATE,
    `motivo` VARCHAR(100),
    `detalle_motivo` VARCHAR(450),
    `detalle_repuesto` VARCHAR(250),
    `producto_id` INTEGER,
    `cantidad` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `orden_devolucion_I_1` (`fecha`),
    INDEX `orden_devolucion_FI_1` (`empresa_id`),
    INDEX `orden_devolucion_FI_2` (`proveedor_id`),
    INDEX `orden_devolucion_FI_3` (`solicitud_devolucion_id`),
    INDEX `orden_devolucion_FI_4` (`tienda_id`),
    INDEX `orden_devolucion_FI_5` (`producto_id`),
    CONSTRAINT `orden_devolucion_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `orden_devolucion_FK_2`
        FOREIGN KEY (`proveedor_id`)
        REFERENCES `proveedor` (`id`),
    CONSTRAINT `orden_devolucion_FK_3`
        FOREIGN KEY (`solicitud_devolucion_id`)
        REFERENCES `solicitud_devolucion` (`id`),
    CONSTRAINT `orden_devolucion_FK_4`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `orden_devolucion_FK_5`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- egresos_recibido
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `egresos_recibido`;

CREATE TABLE `egresos_recibido`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `medio_pago_id` INTEGER,
    `tienda_id` INTEGER,
    `fecha` DATE,
    `total` DOUBLE,
    `partida_no` INTEGER DEFAULT 0,
    `empresa_id` INTEGER,
    `usuario_creo` VARCHAR(50),
    `created_at` DATETIME,
    `observaciones` TEXT,
    PRIMARY KEY (`id`),
    INDEX `egresos_recibido_I_1` (`fecha`),
    INDEX `egresos_recibido_I_2` (`partida_no`),
    INDEX `egresos_recibido_FI_1` (`medio_pago_id`),
    INDEX `egresos_recibido_FI_2` (`tienda_id`),
    INDEX `egresos_recibido_FI_3` (`empresa_id`),
    CONSTRAINT `egresos_recibido_FK_1`
        FOREIGN KEY (`medio_pago_id`)
        REFERENCES `medio_pago` (`id`),
    CONSTRAINT `egresos_recibido_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `egresos_recibido_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- tasa_cambio
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tasa_cambio`;

CREATE TABLE `tasa_cambio`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fecha` DATE,
    `valor` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `tasa_cambio_I_1` (`fecha`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- gasto_caja
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `gasto_caja`;

CREATE TABLE `gasto_caja`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `tienda_id` INTEGER,
    `empresa_id` INTEGER,
    `fecha` DATE,
    `concepto` VARCHAR(450),
    `usuario` VARCHAR(50),
    `created_at` DATETIME,
    `estatus` VARCHAR(50),
    `gasto_id` INTEGER,
    `valor` DOUBLE,
    `observaciones` TEXT,
    `cuenta` VARCHAR(50),
    `partida_no` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `gasto_caja_I_1` (`partida_no`),
    INDEX `gasto_caja_FI_1` (`tienda_id`),
    INDEX `gasto_caja_FI_2` (`empresa_id`),
    INDEX `gasto_caja_FI_3` (`gasto_id`),
    CONSTRAINT `gasto_caja_FK_1`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `gasto_caja_FK_2`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `gasto_caja_FK_3`
        FOREIGN KEY (`gasto_id`)
        REFERENCES `gasto` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- gasto_caja_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `gasto_caja_detalle`;

CREATE TABLE `gasto_caja_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `gasto_caja_id` INTEGER,
    `serie` VARCHAR(20),
    `factura` VARCHAR(50),
    `fecha` VARCHAR(10),
    `descripcion` VARCHAR(450),
    `proveedor_id` INTEGER,
    `cuenta` VARCHAR(50),
    `valor` DOUBLE,
    `iva` DOUBLE,
    `valor_isr` DOUBLE,
    `valor_retiene_iva` DOUBLE,
    `confrontado_sat` TINYINT(1) DEFAULT 0,
    `no_sat` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `gasto_caja_detalle_I_1` (`no_sat`),
    INDEX `gasto_caja_detalle_FI_1` (`gasto_caja_id`),
    INDEX `gasto_caja_detalle_FI_2` (`proveedor_id`),
    CONSTRAINT `gasto_caja_detalle_FK_1`
        FOREIGN KEY (`gasto_caja_id`)
        REFERENCES `gasto_caja` (`id`),
    CONSTRAINT `gasto_caja_detalle_FK_2`
        FOREIGN KEY (`proveedor_id`)
        REFERENCES `proveedor` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- saldo_banco
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `saldo_banco`;

CREATE TABLE `saldo_banco`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fecha` DATE,
    `saldo_libro` DOUBLE,
    `banco_id` INTEGER,
    `usuario` VARCHAR(50),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `saldo_banco` DOUBLE,
    `saldo_conciliado` DOUBLE,
    `diferencia` DOUBLE,
    `fecha_docu` DATE,
    `deposito_transito` DOUBLE,
    `nota_credito` DOUBLE,
    `cheques_circula` DOUBLE,
    `nota_transito` DOUBLE,
    `diferencial` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `saldo_banco_I_1` (`fecha`),
    INDEX `saldo_banco_FI_1` (`banco_id`),
    CONSTRAINT `saldo_banco_FK_1`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- vendedor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `vendedor`;

CREATE TABLE `vendedor`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `nombre` VARCHAR(150),
    `activo` TINYINT(1) DEFAULT 0,
    `empresa_id` INTEGER,
    `porcentaje_comision` DOUBLE,
    `tienda_comision` VARCHAR(150),
    `encargado_tienda` TINYINT(1) DEFAULT 1,
    `codigo_planilla` VARCHAR(50),
    `observaciones` TEXT,
    PRIMARY KEY (`id`),
    INDEX `vendedor_FI_1` (`empresa_id`),
    CONSTRAINT `vendedor_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- orden_vendedor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `orden_vendedor`;

CREATE TABLE `orden_vendedor`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `observaciones` VARCHAR(450),
    `estado` VARCHAR(50),
    `fecha` DATETIME,
    `usuario` VARCHAR(50),
    `empresa_id` INTEGER,
    `vendedor_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `orden_vendedor_FI_1` (`empresa_id`),
    INDEX `orden_vendedor_FI_2` (`vendedor_id`),
    CONSTRAINT `orden_vendedor_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `orden_vendedor_FK_2`
        FOREIGN KEY (`vendedor_id`)
        REFERENCES `vendedor` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- vendedor_producto
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `vendedor_producto`;

CREATE TABLE `vendedor_producto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `vendedor_id` INTEGER,
    `producto_id` INTEGER,
    `cantidad` INTEGER,
    `observaciones` VARCHAR(450),
    `fecha` DATETIME,
    `usuario` VARCHAR(50),
    `valor_unitario` DOUBLE,
    `orden_vendedor_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `vendedor_producto_FI_1` (`vendedor_id`),
    INDEX `vendedor_producto_FI_2` (`producto_id`),
    INDEX `vendedor_producto_FI_3` (`orden_vendedor_id`),
    CONSTRAINT `vendedor_producto_FK_1`
        FOREIGN KEY (`vendedor_id`)
        REFERENCES `vendedor` (`id`),
    CONSTRAINT `vendedor_producto_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `vendedor_producto_FK_3`
        FOREIGN KEY (`orden_vendedor_id`)
        REFERENCES `orden_vendedor` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- solicitud_devolucion
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `solicitud_devolucion`;

CREATE TABLE `solicitud_devolucion`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `fecha` DATE,
    `factura` VARCHAR(50),
    `no_referencia` VARCHAR(50),
    `vendedor` VARCHAR(100),
    `descripcion` VARCHAR(450),
    `nombre_cliente` VARCHAR(150),
    `dpi` VARCHAR(50),
    `telefono` VARCHAR(50),
    `medio_pago` VARCHAR(50),
    `usuario` VARCHAR(50),
    `created_at` DATETIME,
    `estatus` VARCHAR(50),
    `empresa_id` INTEGER,
    `valor` DOUBLE,
    `usuario_confirmo` VARCHAR(50),
    `fecha_confirmo` DATETIME,
    `valor_retiene` DOUBLE,
    `tienda_id` INTEGER,
    `motivo` VARCHAR(100),
    `detalle_motivo` VARCHAR(450),
    PRIMARY KEY (`id`),
    INDEX `solicitud_devolucion_I_1` (`fecha`),
    INDEX `solicitud_devolucion_FI_1` (`empresa_id`),
    INDEX `solicitud_devolucion_FI_2` (`tienda_id`),
    CONSTRAINT `solicitud_devolucion_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `solicitud_devolucion_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- solicitud_dev_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `solicitud_dev_detalle`;

CREATE TABLE `solicitud_dev_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `solicitud_devolucion_id` INTEGER,
    `hollander` VARCHAR(50),
    `descripcion` VARCHAR(150),
    `stock` VARCHAR(50),
    `tipo` INTEGER DEFAULT 1,
    `tipo_respuesto` VARCHAR(50),
    PRIMARY KEY (`id`),
    INDEX `solicitud_dev_detalle_FI_1` (`solicitud_devolucion_id`),
    CONSTRAINT `solicitud_dev_detalle_FK_1`
        FOREIGN KEY (`solicitud_devolucion_id`)
        REFERENCES `solicitud_devolucion` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- solicitud_dev_motivo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `solicitud_dev_motivo`;

CREATE TABLE `solicitud_dev_motivo`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `solicitud_devolucion_id` INTEGER,
    `motivo` VARCHAR(150),
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `solicitud_dev_motivo_FI_1` (`solicitud_devolucion_id`),
    INDEX `solicitud_dev_motivo_FI_2` (`empresa_id`),
    CONSTRAINT `solicitud_dev_motivo_FK_1`
        FOREIGN KEY (`solicitud_devolucion_id`)
        REFERENCES `solicitud_devolucion` (`id`),
    CONSTRAINT `solicitud_dev_motivo_FK_2`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- solicitud_cheque
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `solicitud_cheque`;

CREATE TABLE `solicitud_cheque`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `empresa_id` INTEGER,
    `tipo` VARCHAR(50),
    `nombre` VARCHAR(150),
    `referencia` VARCHAR(50),
    `motivo` TEXT,
    `valor` DOUBLE,
    `partida_no` INTEGER,
    `estatus` VARCHAR(50),
    `fecha` DATE,
    `usuario` VARCHAR(50),
    `usuario_confirmo` VARCHAR(50),
    `fecha_confirmo` DATETIME,
    `cheque_no` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `solicitud_cheque_I_1` (`fecha`),
    INDEX `solicitud_cheque_FI_1` (`empresa_id`),
    CONSTRAINT `solicitud_cheque_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- facturas
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `facturas`;

CREATE TABLE `facturas`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `tienda` VARCHAR(5),
    `referencia` VARCHAR(10),
    `fecha` DATETIME,
    `tipo_documento` VARCHAR(10),
    `firma` VARCHAR(50),
    `motivo` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- libro_agrupado
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `libro_agrupado`;

CREATE TABLE `libro_agrupado`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `nombre` VARCHAR(100),
    `tipo` VARCHAR(50),
    `grupo` VARCHAR(50),
    `orden` INTEGER,
    `abs` TINYINT(1) DEFAULT 0,
    `haber` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `libro_agrupado_FI_1` (`empresa_id`),
    CONSTRAINT `libro_agrupado_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- libro_agrupado_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `libro_agrupado_detalle`;

CREATE TABLE `libro_agrupado_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `libro_agrupado_id` INTEGER,
    `cuenta_contable` VARCHAR(50),
    `detalle` VARCHAR(50),
    PRIMARY KEY (`id`),
    INDEX `libro_agrupado_detalle_FI_1` (`empresa_id`),
    INDEX `libro_agrupado_detalle_FI_2` (`libro_agrupado_id`),
    CONSTRAINT `libro_agrupado_detalle_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `libro_agrupado_detalle_FK_2`
        FOREIGN KEY (`libro_agrupado_id`)
        REFERENCES `libro_agrupado` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- carga_compras_sat
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `carga_compras_sat`;

CREATE TABLE `carga_compras_sat`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fecha` DATE,
    `validado` TINYINT(1) DEFAULT 0,
    `tipo_dte` VARCHAR(10),
    `serie` VARCHAR(20),
    `no_dte` VARCHAR(20),
    `emisor` VARCHAR(150),
    `autorizacion` VARCHAR(50),
    `nit_emisor` VARCHAR(20),
    `monto` DOUBLE,
    `tipo` VARCHAR(10),
    `codigo` VARCHAR(15),
    `usuario` VARCHAR(50),
    `updated_at` DATETIME,
    `manual` TINYINT(1) DEFAULT 0,
    `documento` VARCHAR(150),
    PRIMARY KEY (`id`),
    INDEX `carga_compras_sat_I_1` (`fecha`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- lista_activos
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `lista_activos`;

CREATE TABLE `lista_activos`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `cuenta_contable` VARCHAR(20),
    `detalle` VARCHAR(250),
    `fecha_adquision` DATE,
    `anio_util` INTEGER,
    `valor_libro` DOUBLE,
    `porcentaje` INTEGER,
    `cuenta_erp_contable_id` INTEGER,
    `usuario` VARCHAR(50),
    `updated_at` DATETIME,
    `activo` TINYINT(1) DEFAULT 1,
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `lista_activos_FI_1` (`cuenta_erp_contable_id`),
    INDEX `lista_activos_FI_2` (`empresa_id`),
    CONSTRAINT `lista_activos_FK_1`
        FOREIGN KEY (`cuenta_erp_contable_id`)
        REFERENCES `cuenta_erp_contable` (`id`),
    CONSTRAINT `lista_activos_FK_2`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- region
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `region`;

CREATE TABLE `region`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `detalle` VARCHAR(250),
    `activo` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- region_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `region_detalle`;

CREATE TABLE `region_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `departamento_id` INTEGER,
    `region_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `region_detalle_FI_1` (`departamento_id`),
    INDEX `region_detalle_FI_2` (`region_id`),
    CONSTRAINT `region_detalle_FK_1`
        FOREIGN KEY (`departamento_id`)
        REFERENCES `departamento` (`id`),
    CONSTRAINT `region_detalle_FK_2`
        FOREIGN KEY (`region_id`)
        REFERENCES `region` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- formulario_datos
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `formulario_datos`;

CREATE TABLE `formulario_datos`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `establecimiento` VARCHAR(250),
    `tipo` VARCHAR(50),
    `propietario` VARCHAR(250),
    `telefono` VARCHAR(150),
    `email` VARCHAR(200),
    `region_id` INTEGER,
    `departamento_id` INTEGER,
    `municipio_id` INTEGER,
    `direccion` VARCHAR(450),
    `nit` VARCHAR(250),
    `contacto` VARCHAR(250),
    `whtas_app` VARCHAR(250),
    `observaciones` TEXT,
    `fecha_visita` DATE,
    `usuario` VARCHAR(50),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    PRIMARY KEY (`id`),
    INDEX `formulario_datos_FI_1` (`region_id`),
    INDEX `formulario_datos_FI_2` (`departamento_id`),
    INDEX `formulario_datos_FI_3` (`municipio_id`),
    CONSTRAINT `formulario_datos_FK_1`
        FOREIGN KEY (`region_id`)
        REFERENCES `region` (`id`),
    CONSTRAINT `formulario_datos_FK_2`
        FOREIGN KEY (`departamento_id`)
        REFERENCES `departamento` (`id`),
    CONSTRAINT `formulario_datos_FK_3`
        FOREIGN KEY (`municipio_id`)
        REFERENCES `municipio` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- formulario_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `formulario_detalle`;

CREATE TABLE `formulario_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `formulario_datos_id` INTEGER,
    `hollander` VARCHAR(50),
    `repuesto` VARCHAR(250),
    PRIMARY KEY (`id`),
    INDEX `formulario_detalle_FI_1` (`formulario_datos_id`),
    CONSTRAINT `formulario_detalle_FK_1`
        FOREIGN KEY (`formulario_datos_id`)
        REFERENCES `formulario_datos` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- temporal_compara
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `temporal_compara`;

CREATE TABLE `temporal_compara`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `indicador` INTEGER,
    `valor` VARCHAR(50),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- solicitud_deposito
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `solicitud_deposito`;

CREATE TABLE `solicitud_deposito`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `banco_id` INTEGER,
    `tienda_id` INTEGER,
    `fecha_ingreso` DATETIME,
    `fecha_deposito` DATE,
    `total` DOUBLE,
    `boleta` VARCHAR(50),
    `vendedor` VARCHAR(50),
    `telefono` VARCHAR(20),
    `cliente` VARCHAR(150),
    `pieza` VARCHAR(50),
    `stock` VARCHAR(50),
    `documento_confirmacion` VARCHAR(50),
    `usuario_confirmo` VARCHAR(50),
    `fecha_confirmo` DATETIME,
    `estatus` VARCHAR(50),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `empresa_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `solicitud_deposito_FI_1` (`banco_id`),
    INDEX `solicitud_deposito_FI_2` (`tienda_id`),
    INDEX `solicitud_deposito_FI_3` (`empresa_id`),
    CONSTRAINT `solicitud_deposito_FK_1`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`),
    CONSTRAINT `solicitud_deposito_FK_2`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `solicitud_deposito_FK_3`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- prestamo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `prestamo`;

CREATE TABLE `prestamo`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `nombre` VARCHAR(150),
    `observaciones` TEXT,
    `valor` DOUBLE,
    `fecha_inicio` DATE,
    `moneda` VARCHAR(50),
    `tasa_interes` DOUBLE,
    `empresa_id` INTEGER,
    `estatus` VARCHAR(50),
    PRIMARY KEY (`id`),
    INDEX `prestamo_FI_1` (`empresa_id`),
    CONSTRAINT `prestamo_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- prestamo_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `prestamo_detalle`;

CREATE TABLE `prestamo_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `prestamo_id` INTEGER,
    `comentario` VARCHAR(150),
    `fecha_inicio` DATE,
    `fecha_fin` DATE,
    `dias` INTEGER,
    `tasa_cambio` DOUBLE,
    `valor_quetzales` DOUBLE,
    `valor_dolares` DOUBLE,
    `created_at` DATETIME,
    `created_by` VARCHAR(50),
    `tipo` VARCHAR(50),
    `valor` DOUBLE,
    `banco_id` INTEGER,
    `movimiento_banco_id` INTEGER,
    `partida_no` INTEGER,
    `detalle_interes` TEXT,
    PRIMARY KEY (`id`),
    INDEX `prestamo_detalle_FI_1` (`prestamo_id`),
    INDEX `prestamo_detalle_FI_2` (`banco_id`),
    INDEX `prestamo_detalle_FI_3` (`movimiento_banco_id`),
    CONSTRAINT `prestamo_detalle_FK_1`
        FOREIGN KEY (`prestamo_id`)
        REFERENCES `prestamo` (`id`),
    CONSTRAINT `prestamo_detalle_FK_2`
        FOREIGN KEY (`banco_id`)
        REFERENCES `banco` (`id`),
    CONSTRAINT `prestamo_detalle_FK_3`
        FOREIGN KEY (`movimiento_banco_id`)
        REFERENCES `movimiento_banco` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ventas_vendedor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ventas_vendedor`;

CREATE TABLE `ventas_vendedor`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo_vendedor` VARCHAR(50),
    `nombre_vendedor` VARCHAR(250),
    `facturas` INTEGER,
    `total_facturas` DOUBLE,
    `detalle_facturas` TEXT,
    `notas` INTEGER,
    `total_notas` DOUBLE,
    `detalle_notas` TEXT,
    `periodo` INTEGER,
    `mes` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `empresa_id` INTEGER,
    `bono` DOUBLE,
    PRIMARY KEY (`id`),
    INDEX `ventas_vendedor_FI_1` (`empresa_id`),
    CONSTRAINT `ventas_vendedor_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- tienda_comision
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tienda_comision`;

CREATE TABLE `tienda_comision`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre_tienda` VARCHAR(200),
    `minimo` DOUBLE,
    `maximo` DOUBLE,
    `tipo` VARCHAR(100),
    `valor` VARCHAR(50),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- inventario_powerlink
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `inventario_powerlink`;

CREATE TABLE `inventario_powerlink`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `categorizing_store_number` VARCHAR(5),
    `dat` TEXT,
    `last_date_modified` DATE,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- agenda
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `agenda`;

CREATE TABLE `agenda`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fecha` DATE,
    `hora_inicio` VARCHAR(32),
    `hora_fin` VARCHAR(32),
    `estatus` VARCHAR(32),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` VARCHAR(32),
    `updated_by` VARCHAR(32),
    `cliente_id` INTEGER,
    `empresa_id` INTEGER,
    `observaciones` TEXT,
    `tienda_id` INTEGER,
    `doctor` VARCHAR(32),
    `no_sesion` VARCHAR(10),
    PRIMARY KEY (`id`),
    INDEX `agenda_I_1` (`fecha`),
    INDEX `agenda_I_2` (`hora_inicio`),
    INDEX `agenda_FI_1` (`cliente_id`),
    INDEX `agenda_FI_2` (`empresa_id`),
    INDEX `agenda_FI_3` (`tienda_id`),
    CONSTRAINT `agenda_FK_1`
        FOREIGN KEY (`cliente_id`)
        REFERENCES `cliente` (`id`),
    CONSTRAINT `agenda_FK_2`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `agenda_FK_3`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- recetario
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `recetario`;

CREATE TABLE `recetario`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fecha` DATE,
    `cliente_id` INTEGER,
    `empresa_id` INTEGER,
    `observaciones` TEXT,
    `usuario` VARCHAR(50),
    PRIMARY KEY (`id`),
    INDEX `recetario_I_1` (`fecha`),
    INDEX `recetario_FI_1` (`cliente_id`),
    INDEX `recetario_FI_2` (`empresa_id`),
    CONSTRAINT `recetario_FK_1`
        FOREIGN KEY (`cliente_id`)
        REFERENCES `cliente` (`id`),
    CONSTRAINT `recetario_FK_2`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- recetario_detalle
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `recetario_detalle`;

CREATE TABLE `recetario_detalle`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `recetario_id` INTEGER,
    `tipo_detalle` VARCHAR(32),
    `servicio` VARCHAR(255),
    `producto_id` INTEGER,
    `dosis` VARCHAR(32),
    `frecuencia` VARCHAR(32),
    `observaciones` TEXT,
    PRIMARY KEY (`id`),
    INDEX `recetario_detalle_FI_1` (`recetario_id`),
    INDEX `recetario_detalle_FI_2` (`producto_id`),
    CONSTRAINT `recetario_detalle_FK_1`
        FOREIGN KEY (`recetario_id`)
        REFERENCES `recetario` (`id`),
    CONSTRAINT `recetario_detalle_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- usuario_report
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `usuario_report`;

CREATE TABLE `usuario_report`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `tipo_letra` VARCHAR(50),
    `papel` VARCHAR(50),
    `orientacion` VARCHAR(50),
    `logo_tamanio` VARCHAR(50),
    `logo_posicion` VARCHAR(90),
    `letra_titulo_no` INTEGER,
    `letra_detalle_no` INTEGER,
    `letra_titulo_bold` TINYINT(1) DEFAULT 1,
    `letra_detalle_bold` TINYINT(1) DEFAULT 1,
    `letra_titulo_color` VARCHAR(10),
    `letra_detalle_color` VARCHAR(10),
    `una_linea` TINYINT(1) DEFAULT 0,
    `tipo_tabla` VARCHAR(50),
    `border_color` VARCHAR(50),
    `fondo_color_encabezado` VARCHAR(50),
    `fondo_color_detalle` VARCHAR(50),
    `marca_agua` INTEGER DEFAULT 0,
    `fondo` VARCHAR(150),
    `logo` VARCHAR(150),
    PRIMARY KEY (`id`),
    INDEX `usuario_report_FI_1` (`empresa_id`),
    CONSTRAINT `usuario_report_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- inventario_vence
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `inventario_vence`;

CREATE TABLE `inventario_vence`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `producto_id` INTEGER,
    `fecha_vence` DATE,
    `despachado` TINYINT(1) DEFAULT 0,
    `ingreso_producto_id` INTEGER,
    `tienda_id` INTEGER,
    `operacion_no` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `inventario_vence_FI_1` (`empresa_id`),
    INDEX `inventario_vence_FI_2` (`producto_id`),
    INDEX `inventario_vence_FI_3` (`ingreso_producto_id`),
    INDEX `inventario_vence_FI_4` (`tienda_id`),
    CONSTRAINT `inventario_vence_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `inventario_vence_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `inventario_vence_FK_3`
        FOREIGN KEY (`ingreso_producto_id`)
        REFERENCES `ingreso_producto` (`id`),
    CONSTRAINT `inventario_vence_FK_4`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- traslado_producto
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `traslado_producto`;

CREATE TABLE `traslado_producto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50),
    `empresa_id` INTEGER,
    `producto_id` INTEGER,
    `bodega_origen` INTEGER,
    `bodega_destino` INTEGER,
    `comentario` VARCHAR(350),
    `cantidad` INTEGER,
    `estatus` VARCHAR(32) DEFAULT 'Nuevo',
    `usuario` VARCHAR(50),
    `fecha` DATE,
    `usuario_confirmo` VARCHAR(50),
    `fecha_confirmo` DATE,
    PRIMARY KEY (`id`),
    INDEX `traslado_producto_FI_1` (`empresa_id`),
    INDEX `traslado_producto_FI_2` (`producto_id`),
    CONSTRAINT `traslado_producto_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`),
    CONSTRAINT `traslado_producto_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- orden_ubicacion
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `orden_ubicacion`;

CREATE TABLE `orden_ubicacion`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `tienda_id` INTEGER,
    `producto_id` INTEGER,
    `ubicacion_id` VARCHAR(50),
    `orden_cotizacion_id` INTEGER,
    `procesado` TINYINT(1) DEFAULT 0,
    `cantidad` INTEGER,
    `tienda_ubica` INTEGER,
    `vendedor_producto_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `orden_ubicacion_FI_1` (`tienda_id`),
    INDEX `orden_ubicacion_FI_2` (`producto_id`),
    INDEX `orden_ubicacion_FI_3` (`orden_cotizacion_id`),
    INDEX `orden_ubicacion_FI_4` (`vendedor_producto_id`),
    CONSTRAINT `orden_ubicacion_FK_1`
        FOREIGN KEY (`tienda_id`)
        REFERENCES `tienda` (`id`),
    CONSTRAINT `orden_ubicacion_FK_2`
        FOREIGN KEY (`producto_id`)
        REFERENCES `producto` (`id`),
    CONSTRAINT `orden_ubicacion_FK_3`
        FOREIGN KEY (`orden_cotizacion_id`)
        REFERENCES `orden_cotizacion` (`id`),
    CONSTRAINT `orden_ubicacion_FK_4`
        FOREIGN KEY (`vendedor_producto_id`)
        REFERENCES `vendedor_producto` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
