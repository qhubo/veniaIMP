<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1769749033.
 * Generated on 2026-01-30 05:57:13 
 */
class PropelMigration_1769749033
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

ALTER TABLE `cliente` CHANGE `tipo_cliente` `tipo_cliente` VARCHAR(120);

ALTER TABLE `cuenta_banco` CHANGE `documento` `documento` VARCHAR(250);

ALTER TABLE `gasto` CHANGE `documento` `documento` VARCHAR(250);

ALTER TABLE `gasto_pago` CHANGE `documento` `documento` VARCHAR(250);

ALTER TABLE `orden_cotizacion_detalle` CHANGE `bulto_inicio` `bulto_inicio` INTEGER;

ALTER TABLE `orden_proveedor` CHANGE `no_documento` `no_documento` VARCHAR(250);

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

ALTER TABLE `cliente` CHANGE `tipo_cliente` `tipo_cliente` VARCHAR(200);

ALTER TABLE `cuenta_banco` CHANGE `documento` `documento` VARCHAR(50);

ALTER TABLE `gasto` CHANGE `documento` `documento` VARCHAR(150);

ALTER TABLE `gasto_pago` CHANGE `documento` `documento` VARCHAR(150);

ALTER TABLE `orden_cotizacion_detalle` CHANGE `bulto_inicio` `bulto_inicio` VARCHAR(10);

ALTER TABLE `orden_proveedor` CHANGE `no_documento` `no_documento` VARCHAR(50);

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