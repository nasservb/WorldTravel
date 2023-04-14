<?php 

namespace nasservb\AgencyAssistant\Database\Migrations;
use nasservb\AgencyAssistant\Database\DB;

class User
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
       CREATE TABLE `users` (
        `id` int NOT NULL,
        `name` varchar(100) NOT NULL,
        `phone` varchar(20) NULL,
        `email_address` varchar(100) NOT NULL,
        `user_type`ENUM(\'agency\',\'user\',\'admin\',\'driver\')  NOT NULL,
        `password` varchar(100) NOT NULL
      ) ENGINE=InnoDB;
       '
        );

        DB::run(
            '
       ALTER TABLE `users`
       ADD PRIMARY KEY (`id`),
       ADD UNIQUE KEY `name_unique` (`name`);
       '
        );
        DB::run(
            '
       ALTER TABLE `users`
        MODIFY `id` int NOT NULL AUTO_INCREMENT;
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
       drop table if exists users 
       '
        );
        return $this;
    }
};