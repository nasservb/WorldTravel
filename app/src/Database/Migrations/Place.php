<?php 
namespace nasservb\AgencyAssistant\Database\Migrations;
use nasservb\AgencyAssistant\Database\DB;

class Place
{    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::run('
       CREATE TABLE `places` (
        `id` int NOT NULL,
        `name` varchar(100) NOT NULL,
        `address` varchar(100) NOT NULL,
        `location_latitude` float DEFAULT  NULL,
        `location_longitude` float DEFAULT NULL
      ) ENGINE=InnoDB;      
       ');


       DB::run('       
        ALTER TABLE `places`
        ADD PRIMARY KEY (`id`); 
       ');

       DB::run('
       ALTER TABLE `places`
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
       drop table if exists places
       ');
       return $this;
    }
};