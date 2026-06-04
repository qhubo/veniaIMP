<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1780535286.
 * Generated on 2026-06-04 03:08:06 
 */
class PropelMigration_1780535286
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

DROP TABLE IF EXISTS `tempo`;

CREATE INDEX `cliente_FI_5` ON `cliente` (`vendedor_id`);

ALTER TABLE `cliente` ADD CONSTRAINT `cliente_FK_5`
    FOREIGN KEY (`vendedor_id`)
    REFERENCES `vendedor` (`id`);

ALTER TABLE `operacion_pago` CHANGE `documento` `documento` VARCHAR(500);

DROP INDEX `unique_codigo` ON `orden_cotizacion`;

ALTER TABLE `orden_cotizacion` CHANGE `empacado` `empacado` TINYINT(1) DEFAULT 0;

ALTER TABLE `orden_cotizacion_detalle` CHANGE `archivo` `archivo` TINYINT(1) DEFAULT 0;

ALTER TABLE `partida` CHANGE `ano` `ano` INTEGER DEFAULT false;

ALTER TABLE `partida` CHANGE `mes` `mes` INTEGER DEFAULT false;

ALTER TABLE `partida_agrupa` CHANGE `ano` `ano` INTEGER DEFAULT false;

ALTER TABLE `partida_agrupa` CHANGE `mes` `mes` INTEGER DEFAULT false;

ALTER TABLE `producto` CHANGE `codigo_sku` `codigo_sku` VARCHAR(32) NOT NULL;

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

ALTER TABLE `cliente` DROP FOREIGN KEY `cliente_FK_5`;

DROP INDEX `cliente_FI_5` ON `cliente`;

ALTER TABLE `operacion_pago` CHANGE `documento` `documento` VARCHAR(550);

ALTER TABLE `orden_cotizacion` CHANGE `empacado` `empacado` bit(1);

CREATE BTREE INDEX `unique_codigo` ON `orden_cotizacion` (`codigo`);

ALTER TABLE `orden_cotizacion_detalle` CHANGE `archivo` `archivo` TINYINT(1);

ALTER TABLE `partida` CHANGE `ano` `ano` INTEGER DEFAULT 0;

ALTER TABLE `partida` CHANGE `mes` `mes` INTEGER DEFAULT 0;

ALTER TABLE `partida_agrupa` CHANGE `ano` `ano` INTEGER DEFAULT 0;

ALTER TABLE `partida_agrupa` CHANGE `mes` `mes` INTEGER DEFAULT 0;

ALTER TABLE `producto` CHANGE `codigo_sku` `codigo_sku` VARCHAR(100);

CREATE TABLE `tempo`
(
    `id` INTEGER
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}