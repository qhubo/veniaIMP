<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1766707528.
 * Generated on 2025-12-26 01:05:28 
 */
class PropelMigration_1766707528
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

ALTER TABLE `cliente`
    ADD `pais_id` INTEGER AFTER `limite_credito`;

CREATE INDEX `cliente_FI_4` ON `cliente` (`pais_id`);

ALTER TABLE `cliente` ADD CONSTRAINT `cliente_FK_4`
    FOREIGN KEY (`pais_id`)
    REFERENCES `pais` (`id`);

ALTER TABLE `operacion`
    ADD `pais_id` INTEGER AFTER `observa_facturar`;

CREATE INDEX `operacion_FI_6` ON `operacion` (`pais_id`);

ALTER TABLE `operacion` ADD CONSTRAINT `operacion_FK_6`
    FOREIGN KEY (`pais_id`)
    REFERENCES `pais` (`id`);

ALTER TABLE `orden_cotizacion`
    ADD `pais_id` INTEGER AFTER `vendedor_id`;

CREATE INDEX `orden_cotizacion_FI_6` ON `orden_cotizacion` (`pais_id`);

ALTER TABLE `orden_cotizacion` ADD CONSTRAINT `orden_cotizacion_FK_6`
    FOREIGN KEY (`pais_id`)
    REFERENCES `pais` (`id`);

ALTER TABLE `partida` CHANGE `ano` `ano` INTEGER DEFAULT false;

ALTER TABLE `partida` CHANGE `mes` `mes` INTEGER DEFAULT false;

ALTER TABLE `partida_agrupa` CHANGE `ano` `ano` INTEGER DEFAULT false;

ALTER TABLE `partida_agrupa` CHANGE `mes` `mes` INTEGER DEFAULT false;

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

ALTER TABLE `cliente` DROP FOREIGN KEY `cliente_FK_4`;

DROP INDEX `cliente_FI_4` ON `cliente`;

ALTER TABLE `cliente` DROP `pais_id`;

ALTER TABLE `operacion` DROP FOREIGN KEY `operacion_FK_6`;

DROP INDEX `operacion_FI_6` ON `operacion`;

ALTER TABLE `operacion` DROP `pais_id`;

ALTER TABLE `orden_cotizacion` DROP FOREIGN KEY `orden_cotizacion_FK_6`;

DROP INDEX `orden_cotizacion_FI_6` ON `orden_cotizacion`;

ALTER TABLE `orden_cotizacion` DROP `pais_id`;

ALTER TABLE `partida` CHANGE `ano` `ano` INTEGER DEFAULT 0;

ALTER TABLE `partida` CHANGE `mes` `mes` INTEGER DEFAULT 0;

ALTER TABLE `partida_agrupa` CHANGE `ano` `ano` INTEGER DEFAULT 0;

ALTER TABLE `partida_agrupa` CHANGE `mes` `mes` INTEGER DEFAULT 0;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}