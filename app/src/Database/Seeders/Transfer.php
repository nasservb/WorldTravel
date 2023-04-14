<?php 
namespace nasservb\AgencyAssistant\Database\Seeders;
use nasservb\AgencyAssistant\Database\DB;
class Transfer
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
       INSERT INTO `transfers`
        (`id`, `source_place_id`, `destination_place_id`, `start_time`, `end_time`, `executing_driver`, `price_per_ticket`, `vehicle_class_id`, `passenger_capacity`) 
       VALUES 
        (NULL,1,2,'2023-01-02 12:00:00','2023-01-02 14:00:10',3,12.65,1,9),
        (NULL,1,2,'2023-01-02 12:00:00','2023-01-02 14:00:10',3,16.65,2,7),
        (NULL,2,4,'2023-01-02 12:00:00','2023-01-02 14:00:10',3,16.65,2,7),
        (NULL,5,6,'2023-01-02 12:00:00','2023-01-02 14:00:10',3,12.65,1,9),
        (NULL,5,1,'2023-01-02 12:00:00','2023-01-02 14:00:10',3,12.65,1,9),
        (NULL,6,2,'2023-01-02 12:00:00','2023-01-02 14:00:10',3,12.65,1,9),
        (NULL,3,4,'2023-01-02 12:00:00','2023-01-02 14:00:10',3,12.65,1,9),
        (NULL,3,1,'2023-01-02 12:00:00','2023-01-02 14:00:10',3,12.65,1,9),
        (NULL,4,2,'2023-01-02 12:00:00','2023-01-02 14:00:10',3,12.65,1,9)
       "
        );
    }


};