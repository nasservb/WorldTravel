<?php
namespace nasservb\AgencyAssistant\Database\Seeders;
use nasservb\AgencyAssistant\Database\DB; 
class Place
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
       INSERT INTO `places` (`id`, `name`, `address`, `location_latitude`, `location_longitude`) 
       VALUES
        (1, '50670 Cologne', '50670 Cologne, Hansaring 115', NULL, NULL),
        (2, 'Airport Cologne', 'Airport Cologne/Bonn', NULL, NULL),
        (3, 'Airport Düsseldorf', 'Airport Düsseldorf', NULL, NULL),
        (4, '53332 Bornheim', '53332 Bornheim, Hauptweg 2', NULL, NULL),
        (5, 'Cologne Main Station', 'Cologne Main Station', NULL, NULL),
        (6, 'Düsseldorf Main Station', 'Düsseldorf Main Station', NULL, NULL);
       "
        );
    }


};