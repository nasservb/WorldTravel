<?php
namespace nasservb\AgencyAssistant\Database\Seeders;
use nasservb\AgencyAssistant\Database\DB; 
class DriverPreferred
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
       INSERT INTO `driver_preferred` (`driver_id`,  `source_place_id`, `destination_place_id`) 
       VALUES
        (3,1,2),
        (4,1,2),
        (3,2,4),
        (4,5,6),
        (4,5,1),
        (4,6,2),
        (3,3,4),
        (3,3,1),
        (4,4,2);
       "
        );
    }


};