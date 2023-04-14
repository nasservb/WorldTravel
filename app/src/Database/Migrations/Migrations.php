<?php 

namespace nasservb\AgencyAssistant\Database\Migrations;
use nasservb\AgencyAssistant\Database\DB;

class Migrations
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function run()
    {
        (new Book)->down();
        (new Transfer)->down();
        (new Place)->down();
        (new VehicleClass)->down();
        (new User)->down();
        
        (new User)->up();
        (new VehicleClass)->up();
        (new Place)->up();
        (new Transfer)->up();
        (new Book)->up();
    }


};