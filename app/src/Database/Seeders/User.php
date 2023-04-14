<?php
namespace nasservb\AgencyAssistant\Database\Seeders;
use nasservb\AgencyAssistant\Database\DB; 
class User
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function run()
    {
        DB::run(
            "
       INSERT INTO `users` (`id`, `name`, `phone`, `email_address`, `user_type`, `password`) 
       VALUES 
        (NULL, 'nasser1', '3178552288', 'nasser.niazymobsser@gmail.com', 'user', '".md5('12345678')."'),
        (NULL, 'nasser2', '4178552288', 'nasser2.niazymobsser@gmail.com', 'agency','".md5('12345678')."'),
        (NULL, 'nasser3', '5178552288', 'nasser3.niazymobsser@gmail.com', 'driver', '".md5('12345678')."'),
        (NULL, 'nasser4', '6178552288', 'nasser4.niazymobsser@gmail.com', 'admin', '".md5('12345678')."');


       "
        );
    }


};