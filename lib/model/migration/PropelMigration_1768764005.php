<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1768764005.
 * Generated on 2026-01-18 20:20:05 
 */
class PropelMigration_1768764005
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

ALTER TABLE `tipo_transporte`
    ADD `descripcion` VARCHAR(260) AFTER `activo`,
    ADD `telefono` VARCHAR(50) AFTER `descripcion`,
    ADD `clave` VARCHAR(150) AFTER `telefono`,
    ADD `clave_2` VARCHAR(150) AFTER `clave`,
    ADD `direccion` VARCHAR(450) AFTER `clave_2`,
    ADD `correo` VARCHAR(150) AFTER `direccion`;

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

ALTER TABLE `tipo_transporte` DROP `descripcion`;

ALTER TABLE `tipo_transporte` DROP `telefono`;

ALTER TABLE `tipo_transporte` DROP `clave`;

ALTER TABLE `tipo_transporte` DROP `clave_2`;

ALTER TABLE `tipo_transporte` DROP `direccion`;

ALTER TABLE `tipo_transporte` DROP `correo`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}