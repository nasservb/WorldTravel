<?php

namespace Tests\Integration;

use nasservb\AgencyAssistant\Services\HotelService;
use nasservb\AgencyAssistant\Controllers\TransferController;
use nasservb\AgencyAssistant\Models\Transfer;
use nasservb\AgencyAssistant\Models\Place;
use nasservb\AgencyAssistant\Models\User;
use nasservb\AgencyAssistant\Database\DB;
use PHPUnit\Framework\TestCase;

class TransferTest extends TestCase
{
    
    /**
     * @test
     */
    public function testSearch()
    {
        /**
         * refresh database 
        */
        DB::init();

        $this->login();
        ob_start();
        $transferController = new TransferController();

        $_GET = [
            'source_id'=>0
        ]; 
        $transferController->search(); 
        $output1 = ob_get_clean();

        ob_start();
        $_GET = [
            'source_id'=>1 , 'destination_id'=>0
        ]; 
        $transferController->search(); 
        $output2 = ob_get_clean();

        ob_start();
        $_GET = [
            'source_id'=>1 , 'destination_id'=>1
        ]; 
        $transferController->search(); 
        $output3 = ob_get_clean();

        ob_start();
        $_GET = [
            'source_id'=>1 , 'destination_id'=>2,
        ]; 
        $transferController->search(); 
        $output4 = ob_get_clean();
        
        ob_start();
        $_GET = [
            'source_id'=>1 , 'destination_id'=>2,'start_time'=>''
        ]; 
        $transferController->search(); 
        $output5 = ob_get_clean();

        ob_start();
        $_GET = [
            'source_id'=>1 , 'destination_id'=>2,'start_time'=>'2023-01-02 12:00:00','end_time'=>''
        ]; 
        $transferController->search(); 
        $output6 = ob_get_clean();

        ob_start();
        $_GET = [
            'source_id'=>1 , 'destination_id'=>2,
            'start_time'=>'2023-01-02 12:00:00','end_time'=>'2023-01-02 12:00:00'
        ]; 
        $transferController->search(); 
        $output7 = ob_get_clean();

        ob_start();
        $_GET = [
            'source_id'=>1 , 'destination_id'=>2,
            'start_time'=>'2023-01-02 12:00:00','end_time'=>'2023-01-02 14:00:10'
        ]; 
        $transferController->search(); 
        $output8 = ob_get_clean();
        
        ob_end_clean();

        $this->assertEquals(json_decode($output1), 'the source_id is not valid!');
        $this->assertEquals(json_decode($output2), 'the destination_id is not valid!');
        $this->assertEquals(json_decode($output3), 'the source_id is equal to destination_id!');
        $this->assertEquals(json_decode($output4), 'the start_time is not valid!');
        $this->assertEquals(json_decode($output5), 'the start_time is not valid!');
        $this->assertEquals(json_decode($output6), 'the end_time is not valid!');
        $this->assertEquals(json_decode($output7), 'the start_time is equal to end_time!');
            
        $transfersOnDB= Transfer::search(
            [
            'source_place'=>1,
            'destination_place'=>2,
            'start_time'=>'2023-01-02 12:00:00',
            'end_time'=>'2023-01-02 14:00:10']
        );

        $this->assertEquals($transfersOnDB[0]['id'], 1);
        $this->assertEquals($transfersOnDB[1]['id'], 2);
        $this->assertEquals($transfersOnDB[0]['fare'], 12.65);
        $this->assertEquals($transfersOnDB[1]['fare'], 16.65);
        $this->assertEquals($transfersOnDB[0]['vehicle_class'], 'Economy, Sedan or Van');
        $this->assertEquals($transfersOnDB[1]['vehicle_class'], 'Business, Sedan or Van');
    }

      
    /**
     * @test
     */
    public function testGetTransferDetails()
    {
        /**
 * refresh database 
*/
        DB::init();

        $this->login();
        ob_start();

        $transferController = new TransferController();
        
        $_GET = [
            'id'=>0
        ];
        $transferController->getTransferDetails();         
        $output = ob_get_clean();

        ob_start();
        $_GET = [
            'id'=>1
        ];
        $transferController->getTransferDetails();         
        $output2 = ob_get_clean();

        ob_start();
        (new User(''))->logout(); 
        $transferController->getTransferDetails(); 
        $output3 = ob_get_clean();

        ob_end_clean();

        $this->assertEquals(json_decode($output), 'the id is not valid!');

        $transfer = json_decode($output2[0]);
        $transferOnDB= DB::run('select * from transfers where id =1');

        $this->assertEquals($transferOnDB['source_place_id'], $transfer[0]['source_place_id']);
        $this->assertEquals($transferOnDB['destination_place_id'], $transfer[0]['destination_place_id']);
        $this->assertEquals($transferOnDB['start_time'], $transfer[0]['start_time']);
        $this->assertEquals($transferOnDB['end_time'], $transfer[0]['end_time']);
        $this->assertEquals($transferOnDB['vehicle_class_id'], $transfer[0]['vehicle_class_id']);
        $this->assertEquals($transferOnDB['price_per_ticket'], $transfer[0]['price_per_ticket']);
        $this->assertEquals($transferOnDB['passenger_capacity'], $transfer[0]['passenger_capacity']);

        $this->assertEquals(json_decode($output3), 'Authentication required!');

    }

     /**
      * @test
      */
    public function testGetPlaces()
    {
        /**
 * refresh database 
*/
        DB::init();

        $this->login();
        ob_start();
        $transferController = new TransferController();
        
        $transferController->getPlaces(); 
        $output = ob_get_clean();

        ob_start();
        (new User(''))->logout(); 
        $transferController->getPlaces(); 
        $output2 = ob_get_clean();

        ob_end_clean();

        $places= DB::run('select * from places');
        
        $this->assertEquals($output, json_encode($places));
        $this->assertEquals(json_decode($output2), 'Authentication required!');

    }


    private function login()
    {
        (new User(''))->login('nasser.niazymobsser@gmail.com', '12345678');
    }

}