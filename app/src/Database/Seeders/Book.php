<?php 
namespace nasservb\AgencyAssistant\Database\Seeders;
use nasservb\AgencyAssistant\Database\DB;
class Book
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
       INSERT INTO `books`
        (`id`, `user_id`, `booked_by`, `transfer_id`, `pickup_time`, `fare`,`seats_booked`,`executing_driver`) 
       VALUES 
        (NULL,1,1,1,'2023-01-01 18:10:10',12.65,4,3),
        (NULL,1,1,2,'2023-01-01 19:10:10',16.65,7,4)
       "
        );
    }


};