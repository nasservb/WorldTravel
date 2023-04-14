<?php 
namespace nasservb\AgencyAssistant\Database\Seeders;
use nasservb\AgencyAssistant\Database\DB;
class VehicleClass
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
       INSERT INTO `vehicle_classes` (`id`, `name`, `icon`) 
       VALUES 
        (NULL, 'Economy, Sedan or Van', 'eco'), 
        (NULL, 'Business, Sedan or Van', 'bus');
       "
        );
    }


};