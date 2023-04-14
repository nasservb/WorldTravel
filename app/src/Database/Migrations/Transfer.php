<?php 
namespace nasservb\AgencyAssistant\Database\Migrations;
use nasservb\AgencyAssistant\Database\DB;

class Transfer
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
       CREATE TABLE `transfers` (
        `id` int NOT NULL,
        `source_place_id` int NOT NULL,
        `destination_place_id` int NOT NULL,
        `start_time` DateTime NULL,
        `end_time` DateTime NULL,
        `executing_driver` int NOT NULL,
        `price_per_ticket` double NOT NULL,
        `vehicle_class_id` int NOT NULL,
        `passenger_capacity` int DEFAULT 1
      ) ENGINE=InnoDB;
       '
        );

        DB::run(
            '
       ALTER TABLE `transfers`
       ADD PRIMARY KEY (`id`);
       '
        );

        DB::run(
            '
       ALTER TABLE `transfers`
        MODIFY `id` int NOT NULL AUTO_INCREMENT;    
       '
        );

        /**
         * foreign keys
         */
        DB::run(
            '
       ALTER TABLE `transfers` 
        ADD CONSTRAINT `source_place` FOREIGN KEY (`source_place_id`) 
            REFERENCES `places`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;        
       '
        );
       
        DB::run(
            '
       ALTER TABLE `transfers` 
        ADD CONSTRAINT `destination_places` FOREIGN KEY (`destination_place_id`) 
            REFERENCES `places`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
       '
        );

        DB::run(
            '
       ALTER TABLE `transfers` 
        ADD CONSTRAINT `driver` FOREIGN KEY (`executing_driver`) 
            REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;      
        '
        );

        DB::run(
            '
        ALTER TABLE `transfers` 
         ADD CONSTRAINT `vehicle_class` FOREIGN KEY (`vehicle_class_id`) 
             REFERENCES `vehicle_classes`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;     
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
       drop table if exists transfers;
       '
        );

      
        return $this;
    }
};