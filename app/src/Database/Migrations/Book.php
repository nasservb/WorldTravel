<?php 
namespace nasservb\AgencyAssistant\Database\Migrations;
use nasservb\AgencyAssistant\Database\DB;

class Book
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
       CREATE TABLE `books` ( 
        `id` int NOT NULL,
         `user_id` int NOT NULL, 
         `booked_by` int NOT NULL, 
         `transfer_id` int NOT NULL, 
         `seats_booked` int DEFAULT 0, 
         `pickup_time` datetime DEFAULT NULL, 
         `executing_driver` int DEFAULT NULL, 
         `fare` float DEFAULT 0) ENGINE=InnoDB ;
       '
        );
       
        DB::run(
            '       
        ALTER TABLE `books`
        ADD PRIMARY KEY (`id`); 
       '
        );
 

        DB::run(
            '
       ALTER TABLE `books`
        MODIFY `id` int NOT NULL AUTO_INCREMENT;    
       '
        );

        /**
         * foreign keys
         */
        DB::run(
            '
       ALTER TABLE `books` 
        ADD CONSTRAINT `booked_user` FOREIGN KEY (`booked_by`) 
            REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;      
       '
        );
       
        DB::run(
            '
       ALTER TABLE `books` 
        ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) 
            REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
       '
        );

        DB::run(
            '
       ALTER TABLE `books` 
        ADD CONSTRAINT `transfer` FOREIGN KEY (`transfer_id`) 
            REFERENCES `transfers`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;    
        '
        );

        DB::run(
            '
       ALTER TABLE `books` 
        ADD CONSTRAINT `books_transfer` FOREIGN KEY (`executing_driver`) 
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
       drop table if exists books
       '
        );
        return $this;
    }
};