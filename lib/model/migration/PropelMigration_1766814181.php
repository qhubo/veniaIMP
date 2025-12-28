<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1766814181.
 * Generated on 2025-12-27 06:43:01 
 */
class PropelMigration_1766814181
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

ALTER TABLE `cliente` DROP `tipo_cliente`;

ALTER TABLE `cliente` DROP `transporte`;

ALTER TABLE `partida` CHANGE `ano` `ano` INTEGER DEFAULT false;

ALTER TABLE `partida` CHANGE `mes` `mes` INTEGER DEFAULT false;

ALTER TABLE `partida_agrupa` CHANGE `ano` `ano` INTEGER DEFAULT false;

ALTER TABLE `partida_agrupa` CHANGE `mes` `mes` INTEGER DEFAULT false;

ALTER TABLE `producto`
    ADD `codigo_arancel` VARCHAR(50) AFTER `costo_anterior`,
    ADD `marca_producto` VARCHAR(50) AFTER `codigo_arancel`,
    ADD `caracteristica` VARCHAR(150) AFTER `marca_producto`,
    ADD `nombre_ingles` VARCHAR(350) AFTER `caracteristica`,
    ADD `alto` DOUBLE AFTER `nombre_ingles`,
    ADD `ancho` DOUBLE AFTER `alto`,
    ADD `largo` DOUBLE AFTER `ancho`,
    ADD `peso` DOUBLE AFTER `largo`,
    ADD `costo_fabrica` DOUBLE AFTER `peso`,
    ADD `costo_cif` DOUBLE AFTER `costo_fabrica`;

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

ALTER TABLE `cliente`
    ADD `tipo_cliente` VARCHAR(30) AFTER `pais_id`,
    ADD `transporte` VARCHAR(160) AFTER `tipo_cliente`;

ALTER TABLE `partida` CHANGE `ano` `ano` INTEGER DEFAULT 0;

ALTER TABLE `partida` CHANGE `mes` `mes` INTEGER DEFAULT 0;

ALTER TABLE `partida_agrupa` CHANGE `ano` `ano` INTEGER DEFAULT 0;

ALTER TABLE `partida_agrupa` CHANGE `mes` `mes` INTEGER DEFAULT 0;

ALTER TABLE `producto` DROP `codigo_arancel`;

ALTER TABLE `producto` DROP `marca_producto`;

ALTER TABLE `producto` DROP `caracteristica`;

ALTER TABLE `producto` DROP `nombre_ingles`;

ALTER TABLE `producto` DROP `alto`;

ALTER TABLE `producto` DROP `ancho`;

ALTER TABLE `producto` DROP `largo`;

ALTER TABLE `producto` DROP `peso`;

ALTER TABLE `producto` DROP `costo_fabrica`;

ALTER TABLE `producto` DROP `costo_cif`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}