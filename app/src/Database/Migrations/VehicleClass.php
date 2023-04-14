<?php 
namespace nasservb\AgencyAssistant\Database\Migrations;
use nasservb\AgencyAssistant\Database\DB;

class VehicleClass
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::run('
       CREATE TABLE `vehicle_classes` (
        `id` int NOT NULL,
        `name` varchar(100) NOT NULL,
        `icon` varchar(100) NULL
      ) ENGINE=InnoDB;
       ');
       
       DB::run('
       ALTER TABLE `vehicle_classes`
        ADD UNIQUE KEY `name` (`name`);
       ');

       DB::run('       
        ALTER TABLE `vehicle_classes`
        ADD PRIMARY KEY (`id`); 
       ');

       DB::run('
       ALTER TABLE `vehicle_classes`
        MODIFY `id` int NOT NULL AUTO_INCREMENT;    
       ');
       return $this;
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::run('
       drop table if exists vehicle_classes 
       ');
       return $this;
    }
};