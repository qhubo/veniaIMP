<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1766864226.
 * Generated on 2025-12-27 20:37:06 
 */
class PropelMigration_1766864226
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

DROP TABLE IF EXISTS `tipo_aparato`;

ALTER TABLE `marca` DROP FOREIGN KEY `marca_FK_2`;

ALTER TABLE `marca` ADD CONSTRAINT `marca_FK_2`
    FOREIGN KEY (`tipo_aparato_id`)
    REFERENCES `marca_producto` (`id`);

ALTER TABLE `partida` CHANGE `ano` `ano` INTEGER DEFAULT false;

ALTER TABLE `partida` CHANGE `mes` `mes` INTEGER DEFAULT false;

ALTER TABLE `partida_agrupa` CHANGE `ano` `ano` INTEGER DEFAULT false;

ALTER TABLE `partida_agrupa` CHANGE `mes` `mes` INTEGER DEFAULT false;

ALTER TABLE `producto` DROP FOREIGN KEY `producto_FK_1`;

ALTER TABLE `producto` CHANGE `marca_producto` `marca_producto` VARCHAR(150);

ALTER TABLE `producto` ADD CONSTRAINT `producto_FK_1`
    FOREIGN KEY (`tipo_aparato_id`)
    REFERENCES `marca_producto` (`id`);

CREATE TABLE `marca_producto`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `codigo` VARCHAR(50),
    `nombre` VARCHAR(150) DEFAULT \'\',
    `activo` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`id`),
    INDEX `marca_producto_FI_1` (`empresa_id`),
    CONSTRAINT `marca_producto_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
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

DROP TABLE IF EXISTS `marca_producto`;

ALTER TABLE `marca` DROP FOREIGN KEY `marca_FK_2`;

ALTER TABLE `marca` ADD CONSTRAINT `marca_FK_2`
    FOREIGN KEY (`tipo_aparato_id`)
    REFERENCES `tipo_aparato` (`id`);

ALTER TABLE `partida` CHANGE `ano` `ano` INTEGER DEFAULT 0;

ALTER TABLE `partida` CHANGE `mes` `mes` INTEGER DEFAULT 0;

ALTER TABLE `partida_agrupa` CHANGE `ano` `ano` INTEGER DEFAULT 0;

ALTER TABLE `partida_agrupa` CHANGE `mes` `mes` INTEGER DEFAULT 0;

ALTER TABLE `producto` DROP FOREIGN KEY `producto_FK_1`;

ALTER TABLE `producto` CHANGE `marca_producto` `marca_producto` VARCHAR(50);

ALTER TABLE `producto` ADD CONSTRAINT `producto_FK_1`
    FOREIGN KEY (`tipo_aparato_id`)
    REFERENCES `tipo_aparato` (`id`);

CREATE TABLE `tipo_aparato`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `empresa_id` INTEGER,
    `codigo` VARCHAR(50),
    `descripcion` VARCHAR(150) DEFAULT \'\',
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
    `cuenta_contable` VARCHAR(50) DEFAULT \'\',
    `venta` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    BTREE INDEX `llave` (`descripcion`(150), `empresa_id`),
    BTREE INDEX `tipo_aparato_FI_1` (`empresa_id`),
    CONSTRAINT `tipo_aparato_FK_1`
        FOREIGN KEY (`empresa_id`)
        REFERENCES `empresa` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}