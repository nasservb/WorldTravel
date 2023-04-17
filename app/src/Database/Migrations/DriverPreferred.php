<?php 
namespace nasservb\AgencyAssistant\Database\Migrations;
use nasservb\AgencyAssistant\Database\DB;

class DriverPreferred
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::run(
            '
       CREATE TABLE `driver_preferred` (
        `driver_id` int NOT NULL,
        `source_place_id` int NOT NULL,
        `destination_place_id` int NOT NULL
      ) ENGINE=InnoDB;
       '
        );
               
        /**
         * foreign keys
         */
        DB::run(
            '
       ALTER TABLE `driver_preferred` 
        ADD CONSTRAINT `driver_preferred_source_place` FOREIGN KEY (`source_place_id`) 
            REFERENCES `places`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;        
       '
        );
       
        DB::run(
            '
       ALTER TABLE `driver_preferred` 
        ADD CONSTRAINT `driver_preferred_destination_places` FOREIGN KEY (`destination_place_id`) 
            REFERENCES `places`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
       '
        );

        DB::run(
            '
       ALTER TABLE `driver_preferred` 
        ADD CONSTRAINT `driver_preferred_driver` FOREIGN KEY (`driver_id`) 
            REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;      
        '
        );
        return $this;
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::run(
            '
       drop table if exists driver_preferred 
       '
        );
        return $this;
    }
};