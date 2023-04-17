<?php 

namespace nasservb\AgencyAssistant\Database\Seeders;
class Seeders
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function run()
    {
        (new User)->run();
        (new VehicleClass)->run();
        (new Place)->run();
        (new Transfer)->run();
        (new DriverPreferred)->run();
        (new Book)->run();
    }


};